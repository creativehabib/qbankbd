<?php

namespace App\Livewire\SuperAdmin\Settings;

use Livewire\Component;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Storage;
use App\Livewire\Traits\InteractsWithFluxToasts;
use Livewire\WithPagination;

class Backups extends Component
{
    use InteractsWithFluxToasts, WithPagination;

    public $perPage = 10;
    
    public function getBackupsProperty()
    {
        $disk = Storage::disk(config('backup.backup.destination.disks')[0] ?? 'local');
        $backupName = config('backup.backup.name');
        
        $files = $disk->exists($backupName) ? $disk->files($backupName) : [];
        
        // Also check root if backupName dir doesn't exist
        if (empty($files)) {
            $files = $disk->files();
        }
        
        $backups = [];
        foreach ($files as $file) {
            if (pathinfo($file, PATHINFO_EXTENSION) === 'zip') {
                $backups[] = [
                    'path' => $file,
                    'file_name' => basename($file),
                    'file_size' => $this->formatBytes($disk->size($file)),
                    'date' => \Carbon\Carbon::createFromTimestamp($disk->lastModified($file)),
                ];
            }
        }
        
        // Sort by date descending
        usort($backups, function($a, $b) {
            return $b['date']->timestamp - $a['date']->timestamp;
        });
        
        return $backups;
    }

    public function runBackup($onlyDb = false)
    {
        abort_unless(auth()->user()?->hasRole('super_admin'), 403);
        
        try {
            if ($onlyDb) {
                Artisan::call('backup:run', ['--only-db' => true, '--disable-notifications' => true]);
            } else {
                Artisan::call('backup:run', ['--disable-notifications' => true]);
            }
            
            $this->toastSuccess('ব্যাকআপ সফলভাবে তৈরি হয়েছে!');
        } catch (\Exception $e) {
            $this->toastError('ব্যাকআপ তৈরিতে সমস্যা হয়েছে: ' . $e->getMessage());
        }
    }

    public function downloadBackup($file)
    {
        abort_unless(auth()->user()?->hasRole('super_admin'), 403);
        
        $diskName = config('backup.backup.destination.disks')[0] ?? 'local';
        $disk = Storage::disk($diskName);
        
        if ($disk->exists($file)) {
            // Livewire will trigger a front-end redirect to this route, preventing Livewire from buffering the file
            return redirect()->route('superadmin.settings.backups.download', ['file' => base64_encode($file)]);
        }
        
        $this->toastError('ফাইলটি পাওয়া যায়নি!');
    }

    public function deleteBackup($file)
    {
        abort_unless(auth()->user()?->hasRole('super_admin'), 403);
        
        $disk = Storage::disk(config('backup.backup.destination.disks')[0] ?? 'local');
        if ($disk->exists($file)) {
            $disk->delete($file);
            $this->toastSuccess('ব্যাকআপ ফাইলটি ডিলিট করা হয়েছে!');
        }
    }
    
    public function cleanBackups()
    {
        abort_unless(auth()->user()?->hasRole('super_admin'), 403);
        try {
            Artisan::call('backup:clean', ['--disable-notifications' => true]);
            $this->toastSuccess('পুরোনো ব্যাকআপগুলো ক্লিন করা হয়েছে!');
        } catch (\Exception $e) {
            $this->toastError('ক্লিন করতে সমস্যা হয়েছে: ' . $e->getMessage());
        }
    }
    
    private function formatBytes($bytes, $precision = 2)
    {
        $units = ['B', 'KB', 'MB', 'GB', 'TB'];
        $bytes = max($bytes, 0);
        $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
        $pow = min($pow, count($units) - 1);
        $bytes /= (1 << (10 * $pow));
        return round($bytes, $precision) . ' ' . $units[$pow];
    }

    public function render()
    {
        abort_unless(auth()->user()?->hasRole('super_admin'), 403);
        return view('livewire.superadmin.settings.backups')->layout('layouts.app', ['title' => 'System Backups']);
    }
}
