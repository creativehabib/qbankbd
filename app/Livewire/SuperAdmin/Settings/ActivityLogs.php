<?php

namespace App\Livewire\SuperAdmin\Settings;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\ActivityLog;

class ActivityLogs extends Component
{
    use WithPagination;

    public $search = '';

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        abort_unless(auth()->user()?->hasRole('super_admin'), 403);

        $logs = collect();
        if (\Illuminate\Support\Facades\Schema::hasTable('activity_logs')) {
            $logs = ActivityLog::with('user')
                ->when($this->search !== '', function ($query) {
                    $query->where('action', 'like', '%' . $this->search . '%')
                          ->orWhere('description', 'like', '%' . $this->search . '%')
                          ->orWhere('ip_address', 'like', '%' . $this->search . '%')
                          ->orWhereHas('user', function ($q) {
                              $q->where('name', 'like', '%' . $this->search . '%')
                                ->orWhere('email', 'like', '%' . $this->search . '%');
                          });
                })
                ->latest()
                ->paginate(15);
        }

        return view('livewire.superadmin.settings.activity-logs', [
            'logs' => $logs
        ])->layout('layouts.app', ['title' => 'Activity Logs']);
    }
}
