<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BackupDownloadController extends Controller
{
    public function download(Request $request)
    {
        abort_unless(auth()->user()?->hasRole('super_admin'), 403);

        $file = base64_decode($request->query('file'));
        if (!$file) {
            abort(404);
        }

        $diskName = config('backup.backup.destination.disks')[0] ?? 'local';
        $disk = Storage::disk($diskName);

        if ($disk->exists($file)) {
            if ($diskName === 'local') {
                return response()->download($disk->path($file));
            }
            
            return response()->streamDownload(function () use ($disk, $file) {
                $stream = $disk->readStream($file);
                fpassthru($stream);
                if (is_resource($stream)) {
                    fclose($stream);
                }
            }, basename($file));
        }

        abort(404, 'Backup file not found.');
    }
}
