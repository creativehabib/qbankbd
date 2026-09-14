<?php

namespace App\Http\Controllers;

use App\Models\Package;
use App\Models\Payment;
use App\Models\UserSubscription;
use App\Services\BkashService;
use App\Services\SSLCommerzService;
use App\Services\NagadService;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PaymentController extends Controller
{
    /** ============================
     *  bKash Integration
     *  ============================ */
    public function bkashPay(Request $request, Package $package, BkashService $bkashService)
    {
        $user = auth()->user();

        // 1. Get Grant Token
        $tokenResponse = $bkashService->getGrantToken();
        if (!isset($tokenResponse['id_token'])) {
            $errorMsg = $tokenResponse['message'] ?? $tokenResponse['statusMessage'] ?? 'Failed to connect to bKash gateway.';
            return back()->with('error', 'bKash Error: ' . $errorMsg);
        }

        $idToken = $tokenResponse['id_token'];
        session()->put('bkash_token', $idToken);

        // 2. Create Payment Record (Pending)
        $invoiceNumber = 'BK-' . time() . '-' . Str::random(5);
        $payment = Payment::create([
            'user_id' => $user->id,
            'package_id' => $package->id,
            'transaction_id' => $invoiceNumber,
            'amount' => $package->price,
            'payment_method' => 'bkash',
            'status' => 'pending',
        ]);

        // 3. Create bKash Payment
        $callbackUrl = route('payment.bkash.callback');
        $createResponse = $bkashService->createPayment($idToken, $package->price, $invoiceNumber, $callbackUrl);

        if (isset($createResponse['bkashURL'])) {
            $payment->update([
                'transaction_id' => $createResponse['paymentID'], // Update with actual paymentID
            ]);
            return redirect($createResponse['bkashURL']);
        }

        $payment->update(['status' => 'failed', 'payment_response' => $createResponse]);
        return redirect()->route(auth()->user()->isTeacher() ? 'teacher.pricing' : 'student.pricing')->with('error', $createResponse['statusMessage'] ?? 'bKash payment initiation failed.');
    }

    public function bkashCallback(Request $request, BkashService $bkashService)
    {
        $paymentID = $request->input('paymentID');
        $status = $request->input('status');
        $idToken = session()->get('bkash_token');

        $payment = Payment::where('transaction_id', $paymentID)->firstOrFail();
        auth()->loginUsingId($payment->user_id);

        if ($status === 'success') {
            $executeResponse = $bkashService->executePayment($idToken, $paymentID);

            if (isset($executeResponse['statusCode']) && $executeResponse['statusCode'] === '0000') {
                $payment->update([
                    'status' => 'completed',
                    'payment_response' => $executeResponse
                ]);

                $this->unlockPackage($payment);
                session()->flash('success', 'Payment successful! bKash TrxID: ' . $executeResponse['trxID']);
                return response('<script>window.location.href="' . (auth()->user()->isTeacher() ? route('teacher.subscription') : route('student.model-tests.index')) . '";</script>');
            } else {
                $payment->update([
                    'status' => 'failed',
                    'payment_response' => $executeResponse
                ]);
                $errorMsg = $executeResponse['statusMessage'] ?? 'Payment execution failed.';
                session()->flash('error', $errorMsg);
                return response('<script>window.location.href="' . (auth()->user()->isTeacher() ? route('teacher.pricing') : route('student.pricing')) . '";</script>');
            }
        }

        $payment->update(['status' => 'canceled']);
        session()->flash('error', 'bKash payment was ' . $status);
        return response('<script>window.location.href="' . (auth()->user()->isTeacher() ? route('teacher.pricing') : route('student.pricing')) . '";</script>');
    }


    /** ============================
     *  SSLCommerz Integration
     *  ============================ */
    public function sslPay(Request $request, Package $package, SSLCommerzService $sslService)
    {
        $user = auth()->user();
        $transactionId = 'SSL-' . time() . '-' . Str::random(5);

        $payment = Payment::create([
            'user_id' => $user->id,
            'package_id' => $package->id,
            'transaction_id' => $transactionId,
            'amount' => $package->price,
            'payment_method' => 'sslcommerz',
            'status' => 'pending',
        ]);

        $postData = [
            'total_amount' => $package->price,
            'currency' => 'BDT',
            'tran_id' => $transactionId,
            'success_url' => route('payment.ssl.success'),
            'fail_url' => route('payment.ssl.fail'),
            'cancel_url' => route('payment.ssl.cancel'),
            'ipn_url' => route('payment.ssl.ipn'),
            'cus_name' => $user->name,
            'cus_email' => $user->email ?? 'no-email@example.com',
            'cus_add1' => 'Dhaka',
            'cus_add2' => 'Dhaka',
            'cus_city' => 'Dhaka',
            'cus_state' => 'Dhaka',
            'cus_postcode' => '1000',
            'cus_country' => 'Bangladesh',
            'cus_phone' => $user->phone ?? '01700000000',
            'shipping_method' => 'NO',
            'product_name' => $package->name,
            'product_category' => $package->type,
            'product_profile' => 'non-physical-goods',
        ];

        $response = $sslService->initPayment($postData);

        if (isset($response['status']) && $response['status'] === 'SUCCESS') {
            return redirect($response['GatewayPageURL']);
        }

        $payment->update(['status' => 'failed', 'payment_response' => $response]);
        $errorMessage = $response['failedreason'] ?? 'SSLCommerz payment initiation failed. Please check Sandbox API Keys.';
        return redirect()->route(auth()->user()->isTeacher() ? 'teacher.pricing' : 'student.pricing')->with('error', $errorMessage);
    }

    public function sslSuccess(Request $request, SSLCommerzService $sslService)
    {
        $transactionId = $request->input('tran_id');
        $valId = $request->input('val_id');

        $payment = Payment::where('transaction_id', $transactionId)->firstOrFail();
        auth()->loginUsingId($payment->user_id);

        // Validate via Server-to-Server
        $validationResponse = $sslService->validatePayment($valId);

        if (isset($validationResponse['status']) && ($validationResponse['status'] === 'VALID' || $validationResponse['status'] === 'VALIDATED')) {
            $payment->update([
                'status' => 'completed',
                'payment_response' => $validationResponse
            ]);
            $this->unlockPackage($payment);
            session()->flash('success', 'Payment successful!');
            return response('<script>window.location.href="' . (auth()->user()->isTeacher() ? route('teacher.subscription') : route('student.model-tests.index')) . '";</script>');
        }

        $payment->update(['status' => 'failed', 'payment_response' => $validationResponse]);
        session()->flash('error', 'Payment validation failed.');
        return response('<script>window.location.href="' . (auth()->user()->isTeacher() ? route('teacher.pricing') : route('student.pricing')) . '";</script>');
    }

    public function sslFail(Request $request)
    {
        $transactionId = $request->input('tran_id');
        $payment = Payment::where('transaction_id', $transactionId)->firstOrFail();
        auth()->loginUsingId($payment->user_id);
        $payment->update(['status' => 'failed']);
        session()->flash('error', 'Payment failed.');
        return response('<script>window.location.href="' . (auth()->user()->isTeacher() ? route('teacher.pricing') : route('student.pricing')) . '";</script>');
    }

    public function sslCancel(Request $request)
    {
        $transactionId = $request->input('tran_id');
        $payment = Payment::where('transaction_id', $transactionId)->firstOrFail();
        auth()->loginUsingId($payment->user_id);
        $payment->update(['status' => 'canceled']);
        session()->flash('warning', 'Payment canceled.');
        return response('<script>window.location.href="' . (auth()->user()->isTeacher() ? route('teacher.pricing') : route('student.pricing')) . '";</script>');
    }

    public function sslIpn(Request $request)
    {
        // IPN logic (runs in background)
        $transactionId = $request->input('tran_id');
        $status = $request->input('status');
        
        $payment = Payment::where('transaction_id', $transactionId)->first();
        if ($payment && $payment->status === 'pending') {
            if ($status === 'VALID') {
                $payment->update(['status' => 'completed', 'payment_response' => $request->all()]);
                $this->unlockPackage($payment);
            } else {
                $payment->update(['status' => 'failed', 'payment_response' => $request->all()]);
            }
        }
        return response()->json(['message' => 'IPN received']);
    }

    
    /** ============================
     *  Nagad Integration
     *  ============================ */
    public function nagadPay(Request $request, Package $package, NagadService $nagadService)
    {
        $user = auth()->user();
        $invoiceNumber = 'N' . time() . Str::random(4);

        $payment = Payment::create([
            'user_id' => $user->id,
            'package_id' => $package->id,
            'transaction_id' => $invoiceNumber,
            'amount' => $package->price,
            'payment_method' => 'nagad',
            'status' => 'pending',
        ]);

        $response = $nagadService->initializePayment($invoiceNumber, $package->price);

        if (isset($response['status']) && $response['status'] === 'success') {
            $payment->update([
                'transaction_id' => $response['payment_ref_id'] // use the ref id for callback matching
            ]);
            return redirect($response['payment_url']);
        }

        $payment->update(['status' => 'failed', 'payment_response' => $response]);
        return redirect()->route($user->isTeacher() ? 'teacher.pricing' : 'student.pricing')
            ->with('error', $response['message'] ?? 'Nagad payment initiation failed. Check API keys.');
    }

    public function nagadCallback(Request $request, NagadService $nagadService)
    {
        $paymentRefId = $request->input('payment_ref_id');
        $status = $request->input('status');

        if (!$paymentRefId) {
            session()->flash('error', 'Invalid Nagad callback parameters.');
            return response('<script>window.location.href="' . route('student.pricing') . '";</script>');
        }

        $payment = Payment::where('transaction_id', $paymentRefId)->firstOrFail();
        auth()->loginUsingId($payment->user_id);
        $isTeacher = $payment->user->isTeacher();

        if ($status === 'Success') {
            $verifyResponse = $nagadService->verifyPayment($paymentRefId);

            if (isset($verifyResponse['status']) && $verifyResponse['status'] === 'success') {
                $payment->update([
                    'status' => 'completed',
                    'payment_response' => $verifyResponse['data']
                ]);

                $this->unlockPackage($payment);
                session()->flash('success', 'Payment successful! Nagad TrxID: ' . ($verifyResponse['data']['issuerPaymentRefNo'] ?? ''));
                return response('<script>window.location.href="' . ($isTeacher ? route('teacher.subscription') : route('student.model-tests.index')) . '";</script>');
            } else {
                $payment->update([
                    'status' => 'failed',
                    'payment_response' => $verifyResponse['data'] ?? []
                ]);
                session()->flash('error', 'Nagad payment verification failed.');
                return response('<script>window.location.href="' . ($isTeacher ? route('teacher.pricing') : route('student.pricing')) . '";</script>');
            }
        }

        $payment->update(['status' => 'canceled']);
        session()->flash('error', 'Nagad payment was ' . $status);
        return response('<script>window.location.href="' . ($isTeacher ? route('teacher.pricing') : route('student.pricing')) . '";</script>');
    }
/** ============================
     *  Common Helpers
     *  ============================ */
    protected function unlockPackage(Payment $payment)
    {
        $package = $payment->package;
        
        UserSubscription::updateOrCreate(
            [
                'user_id' => $payment->user_id,
                'package_id' => $package->id,
            ],
            [
                'started_at' => now(),
                'expires_at' => now()->addDays($package->validity_days),
                'remaining_question_limit' => $package->question_create_limit ?? 0,
                'status' => 'active',
            ]
        );
    }
}
