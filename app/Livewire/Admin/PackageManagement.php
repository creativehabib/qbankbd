<?php

namespace App\Livewire\Admin;

use App\Livewire\Traits\InteractsWithFluxToasts;
use App\Models\Package;
use Illuminate\Contracts\View\View;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;

class PackageManagement extends Component
{
    public $perPage = 10;

    use InteractsWithFluxToasts, WithFileUploads;

    public ?int $editingId = null;

    public string $type = 'subscription'; // 'subscription' or 'course'
    public string $name = '';
    public string $price = '';
    public ?string $description = '';
    public $thumbnail_image; // for upload
    public ?string $existing_thumbnail = null; // for preview

    public string $questionCreateLimit = '';

    public string $pageViewLimit = '';

    public bool $isAdFree = true;

    public string $validityDays = '30';

    public bool $isActive = true;

    public function mount(): void
    {
        abort_unless(auth()->user()?->hasPermission('users.manage_roles'), 403);
    }

    public function edit(int $packageId): void
    {
        $package = Package::query()->findOrFail($packageId);

        $this->editingId = $package->id;
        $this->type = $package->type ?? 'subscription';
        $this->name = $package->name;
        $this->description = $package->description;
        $this->existing_thumbnail = $package->thumbnail_image;
        $this->price = (string) $package->price;
        $this->questionCreateLimit = (string) $package->question_create_limit;
        $this->pageViewLimit = (string) ($package->page_view_limit ?? '');
        $this->isAdFree = (bool) $package->is_ad_free;
        $this->validityDays = (string) $package->validity_days;
        $this->isActive = (bool) $package->is_active;
    }

    public function save(): void
    {
        $validated = $this->validate([
            'type' => ['required', 'in:subscription,course'],
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:1000'],
            'price' => ['required', 'numeric', 'min:0'],
            'thumbnail_image' => ['nullable', 'image', 'max:2048'],
            'questionCreateLimit' => ['nullable', 'integer', 'min:0'],
            'validityDays' => ['required', 'integer', 'min:1'],
            'isActive' => ['boolean'],
        ]);

        $imagePath = $this->existing_thumbnail;
        if ($this->thumbnail_image) {
            if ($this->existing_thumbnail) {
                // Delete old if exists (simplified path logic)
                $oldPath = str_replace('/storage/', '', $this->existing_thumbnail);
                Storage::disk('public')->delete($oldPath);
            }
            $path = $this->thumbnail_image->store('packages', 'public');
            $imagePath = '/storage/' . $path;
        }

        Package::query()->updateOrCreate(
            ['id' => $this->editingId],
            [
                'type' => $validated['type'],
                'name' => $validated['name'],
                'description' => $validated['description'],
                'price' => $validated['price'],
                'thumbnail_image' => $imagePath,
                'question_create_limit' => $validated['questionCreateLimit'] ?? 0,
                'validity_days' => $validated['validityDays'],
                'is_active' => $validated['isActive'],
            ],
        );

        $this->resetForm();
        $this->toastSuccess('Package saved successfully.');
    }

    public function delete(int $packageId): void
    {
        Package::query()->findOrFail($packageId)->delete();
        $this->toastSuccess('Package deleted successfully.');
    }

    public function resetForm(): void
    {
        $this->reset(['editingId', 'type', 'name', 'description', 'price', 'thumbnail_image', 'existing_thumbnail', 'questionCreateLimit', 'pageViewLimit']);
        $this->isAdFree = true;
        $this->validityDays = '30';
        $this->isActive = true;
    }

    public function render(): View
    {
        return view('livewire.admin.package-management', [
            'packages' => Package::query()->latest('id')->get(),
        ]);
    }
}
