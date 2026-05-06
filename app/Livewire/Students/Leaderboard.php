<?php

namespace App\Livewire\Students;

use App\Models\User;
use Carbon\Carbon;
use Livewire\Attributes\Url;
use Livewire\Component;

class Leaderboard extends Component
{
    /**
     * URL এ ?league_id=2 দেখানোর জন্য এবং স্টেট ধরে রাখার জন্য।
     */
    #[Url]
    public int $league_id = 1;

    /**
     * লিগগুলোর লিস্ট এবং তাদের XP লিমিট।
     */
    public function getLeagues(): array
    {
        return [
            1 => ['name' => 'Bronze League', 'icon' => 'bronze', 'min' => 0, 'max' => 1999],
            2 => ['name' => 'Silver League', 'icon' => 'silver', 'min' => 2000, 'max' => 4999],
            3 => ['name' => 'Gold League', 'icon' => 'gold', 'min' => 5000, 'max' => 9999],
            4 => ['name' => 'Platinum League', 'icon' => 'platinum', 'min' => 10000, 'max' => 19999],
            5 => ['name' => 'Diamond League', 'icon' => 'diamond', 'min' => 20000, 'max' => 49999],
            6 => ['name' => 'Elite League', 'icon' => 'elite', 'min' => 50000, 'max' => 99999],
            7 => ['name' => 'Titan League', 'icon' => 'titan', 'min' => 100000, 'max' => 199999],
            8 => ['name' => 'Supreme League', 'icon' => 'supreme', 'min' => 200000, 'max' => 10000000],
        ];
    }

    public function render()
    {
        $leagues = $this->getLeagues();

        // ভুল আইডি দিলে ব্রোঞ্জ এ রিসেট হবে
        if (! isset($leagues[$this->league_id])) {
            $this->league_id = 1;
        }

        $currentLeague = $leagues[$this->league_id];

        // ডাটাবেস কোয়েরি: নির্দিষ্ট লিগের স্টুডেন্টদের আনা হচ্ছে
        $query = User::role('student')
            ->whereBetween('xp', [$currentLeague['min'], $currentLeague['max']])
            ->orderByDesc('xp');

        $totalStudents = $query->count();
        $topStudents = $query->take(50)->get();

        // ইউজারের নিজের স্ট্যাটাস বের করা
        $myRank = 0;
        $myActualLeagueId = 1;
        $userInTopList = false;

        if (auth()->check()) {
            $myXp = auth()->user()->xp ?? 0;

            // ইউজারের বর্তমান আসল লিগ বের করা
            foreach ($leagues as $id => $l) {
                if ($myXp >= $l['min'] && $myXp <= $l['max']) {
                    $myActualLeagueId = $id;
                    break;
                }
            }

            // ইউজারের র‍্যাংক বের করা যদি সে বর্তমান নির্বাচিত লিগে থাকে
            if ($myActualLeagueId == $this->league_id) {
                $userInTopList = $topStudents->contains('id', auth()->id());
                if ($myXp > 0) {
                    $myRank = User::role('student')
                        ->whereBetween('xp', [$currentLeague['min'], $currentLeague['max']])
                        ->where('xp', '>', $myXp)
                        ->count() + 1;
                }
            }
        }

        // টাইম কাউন্টডাউন টেক্সট
        $endOfWeek = now()->endOfWeek(Carbon::SUNDAY)->endOfDay();
        $daysRemaining = (int) now()->diffInDays($endOfWeek);

        if ($daysRemaining <= 0) {
            $timerText = 'Ends today';
        } else {
            $timerText = $daysRemaining.' days remaining';
        }

        return view('livewire.students.leaderboard', [
            'topStudents' => $topStudents,
            'totalStudents' => $totalStudents,
            'myRank' => $myRank,
            'leagues' => $leagues,
            'currentLeague' => $currentLeague,
            'myActualLeagueId' => $myActualLeagueId,
            'timerText' => $timerText,
            'userInTopList' => $userInTopList,
        ])->layout('layouts.app', ['title' => 'Weekly Leaderboard']);
    }
}
