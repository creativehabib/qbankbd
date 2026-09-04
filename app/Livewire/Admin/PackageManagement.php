<?php

namespace App\Livewire\Admin;

use App\Livewire\Traits\InteractsWithFluxToasts;
use App\Models\Package;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class PackageManagement extends Component
{
    use InteractsWithFluxToasts;
    public ?int $editingId = null;

    public string $name = '';

    public string $price = '';

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
        $this->name = $package->name;
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
            'name' => ['required', 'string', 'max:255'],
            'price' => ['required', 'numeric', 'min:0'],
            'questionCreateLimit' => ['required', 'integer', 'min:0'],
            'pageViewLimit' => ['nullable', 'integer', 'min:0'],
            'validityDays' => ['required', 'integer', 'min:1'],
            'isAdFree' => ['boolean'],
            'isActive' => ['boolean'],
        ]);

        Package::query()->updateOrCreate(
            ['id' => $this->editingId],
            [
                'name' => $validated['name'],
                'price' => $validated['price'],
                'question_create_limit' => $validated['questionCreateLimit'],
                'page_view_limit' => $validated['pageViewLimit'] !== '' ? $validated['pageViewLimit'] : null,
                'is_ad_free' => $validated['isAdFree'],
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
        $this->reset(['editingId', 'name', 'price', 'questionCreateLimit', 'pageViewLimit']);
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
