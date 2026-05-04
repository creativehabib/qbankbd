<?php

namespace App\Livewire\Students;

use App\Models\User;
use Livewire\Component;

class Leaderboard extends Component
{
    public function render()
    {
        // যেসব স্টুডেন্ট অন্তত একটি মক টেস্ট কমপ্লিট করেছে, তাদের ডাটা আনা হচ্ছে
        $topStudents = User::query()
            ->whereHas('mockTests', function ($query) {
                $query->where('status', 'completed');
            })
            ->withCount(['mockTests' => function ($query) {
                $query->where('status', 'completed'); // সে মোট কয়টি পরীক্ষা দিয়েছে
            }])
            ->withSum(['mockTests as total_points' => function ($query) {
                $query->where('status', 'completed'); // তার সব পরীক্ষার মোট স্কোর
            }], 'total_score')
            ->orderByDesc('total_points') // সবচেয়ে বেশি পয়েন্ট পাওয়া জনকে ওপরে রাখা
            ->take(10) // সেরা ১০ জনকে দেখানো হবে
            ->get();

        return view('livewire.students.leaderboard', [
            'topStudents' => $topStudents,
        ])->layout('layouts.app', ['title' => 'Leaderboard']);
    }
}
