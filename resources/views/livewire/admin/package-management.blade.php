<div class="space-y-5">
    <div class="flex items-center justify-between">
        <h1 class="text-2xl font-bold">Package Management</h1>
        <button wire:click="resetForm" class="rounded-lg border border-zinc-300 px-4 py-2 text-sm">New Package</button>
    </div>

    @if (session('success'))
        <div class="rounded-lg border border-emerald-200 bg-emerald-50 px-4 py-3 text-emerald-700">{{ session('success') }}</div>
    @endif

    <div class="rounded-xl border border-zinc-200 bg-white p-5">
        <h2 class="mb-4 text-lg font-semibold">{{ $editingId ? 'Edit Package' : 'Create Package' }}</h2>
        <div class="grid gap-3 md:grid-cols-2">
            <input wire:model="name" class="rounded-lg border border-zinc-300 px-3 py-2" placeholder="Package name" />
            <input wire:model="price" type="number" step="0.01" class="rounded-lg border border-zinc-300 px-3 py-2" placeholder="Price" />
            <input wire:model="questionCreateLimit" type="number" class="rounded-lg border border-zinc-300 px-3 py-2" placeholder="Question create limit" />
            <input wire:model="pageViewLimit" type="number" class="rounded-lg border border-zinc-300 px-3 py-2" placeholder="Page view limit (optional)" />
            <input wire:model="validityDays" type="number" class="rounded-lg border border-zinc-300 px-3 py-2" placeholder="Validity days" />
            <div class="flex items-center gap-4 text-sm">
                <label><input type="checkbox" wire:model="isAdFree"> Ad free</label>
                <label><input type="checkbox" wire:model="isActive"> Active</label>
            </div>
        </div>
        <button wire:click="save" class="mt-4 rounded-lg bg-indigo-600 px-5 py-2 text-sm font-semibold text-white">Save Package</button>
    </div>

    <div class="rounded-xl border border-zinc-200 bg-white p-4">
        <table class="min-w-full text-sm">
            <thead><tr class="text-left text-zinc-500"><th>Name</th><th>Price</th><th>Limit</th><th>Validity</th><th>Status</th><th></th></tr></thead>
            <tbody>
            @foreach($packages as $package)
                <tr class="border-t border-zinc-200">
                    <td class="py-2">{{ $package->name }}</td>
                    <td class="py-2">৳{{ $package->price }}</td>
                    <td class="py-2">{{ $package->question_create_limit }}</td>
                    <td class="py-2">{{ $package->validity_days }} days</td>
                    <td class="py-2">{{ $package->is_active ? 'Active' : 'Inactive' }}</td>
                    <td class="py-2 text-right space-x-2">
                        <button wire:click="edit({{ $package->id }})" class="rounded bg-zinc-100 px-3 py-1">Edit</button>
                        <button wire:click="delete({{ $package->id }})" class="rounded bg-rose-100 px-3 py-1 text-rose-700">Delete</button>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>
