<?php

namespace App\Livewire\SuperAdmin\Settings;

use Livewire\Component;
use Illuminate\Support\Facades\Artisan;
use App\Livewire\Traits\InteractsWithFluxToasts;
use Illuminate\Support\Facades\File;

class CacheManagement extends Component
{
    use InteractsWithFluxToasts;

    public function getCacheInfoProperty()
    {
        $driver = config('cache.default');
        
        // Calculate file cache size if using file driver
        $fileCacheSize = 0;
        if ($driver === 'file') {
            $path = storage_path('framework/cache/data');
            $fileCacheSize = $this->getDirectorySize($path);
        }
        
        // Views cache size
        $viewsPath = storage_path('framework/views');
        $viewsSize = $this->getDirectorySize($viewsPath);
        
        return [
            'driver' => $driver,
            'file_cache_size' => $this->formatBytes($fileCacheSize),
            'views_size' => $this->formatBytes($viewsSize),
        ];
    }
    
    private function getDirectorySize($path)
    {
        $size = 0;
        if (File::exists($path)) {
            foreach (File::allFiles($path) as $file) {
                $size += $file->getSize();
            }
        }
        return $size;
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

    public function clearApplicationCache()
    {
        abort_unless(auth()->user()?->hasRole('super_admin'), 403);
        Artisan::call('cache:clear');
        log_activity('cleared_cache', 'Cleared Application Cache'); $this->toastSuccess('অ্যাপিকেশন ক্যাশ সফলভাবে ক্লিয়ার করা হয়েছে।');
    }

    public function clearViewCache()
    {
        abort_unless(auth()->user()?->hasRole('super_admin'), 403);
        Artisan::call('view:clear');
        $this->toastSuccess('ভিউ (Views) ক্যাশ সফলভাবে ক্লিয়ার করা হয়েছে।');
    }

    public function clearRouteCache()
    {
        abort_unless(auth()->user()?->hasRole('super_admin'), 403);
        Artisan::call('route:clear');
        $this->toastSuccess('রাউট (Route) ক্যাশ সফলভাবে ক্লিয়ার করা হয়েছে।');
    }

    public function clearConfigCache()
    {
        abort_unless(auth()->user()?->hasRole('super_admin'), 403);
        Artisan::call('config:clear');
        $this->toastSuccess('কনফিগারেশন ক্যাশ সফলভাবে ক্লিয়ার করা হয়েছে।');
    }
    
    public function optimizeClear()
    {
        abort_unless(auth()->user()?->hasRole('super_admin'), 403);
        Artisan::call('optimize:clear');
        $this->toastSuccess('সকল ক্যাশ একসাথে (Optimize Clear) মুছে ফেলা হয়েছে।');
    }

    public function render()
    {
        abort_unless(auth()->user()?->hasRole('super_admin'), 403);
        return view('livewire.superadmin.settings.cache-management')->layout('layouts.app', ['title' => 'Cache Management']);
    }
}
