<div class="space-y-5">
    <div class="flex items-center justify-between">
        <flux:heading size="xl">Package Management</flux:heading>
        <flux:button wire:click="resetForm" variant="ghost" icon="plus">
            New Package
        </flux:button>
    </div>

    @if (session('success'))
        <flux:callout variant="success" icon="check-circle">
            {{ session('success') }}
        </flux:callout>
    @endif

    <section class="rounded-xl border border-zinc-200 bg-white p-5 dark:border-zinc-700 dark:bg-zinc-800">
        <flux:heading size="lg">{{ $editingId ? 'Edit Package' : 'Create Package' }}</flux:heading>

        <div class="mt-4 grid gap-4 md:grid-cols-2">
            <flux:field>
                <flux:label>Package name</flux:label>
                <flux:input wire:model="name" placeholder="Package name" />
                <flux:error name="name" />
            </flux:field>

            <flux:field>
                <flux:label>Price</flux:label>
                <flux:input wire:model="price" type="number" step="0.01" min="0" placeholder="Price" />
                <flux:error name="price" />
            </flux:field>

            <flux:field>
                <flux:label>Question creation limit</flux:label>
                <flux:input wire:model="questionCreateLimit" type="number" min="0" placeholder="Question creation limit" />
                <flux:error name="questionCreateLimit" />
            </flux:field>

            <flux:field>
                <flux:label>Page-view limit</flux:label>
                <flux:input wire:model="pageViewLimit" type="number" min="0" placeholder="Optional" />
                <flux:error name="pageViewLimit" />
            </flux:field>

            <flux:field>
                <flux:label>Validity (days)</flux:label>
                <flux:input wire:model="validityDays" type="number" min="1" placeholder="Validity days" />
                <flux:error name="validityDays" />
            </flux:field>

            <div class="flex items-end gap-5 pb-2">
                <flux:checkbox wire:model="isAdFree" label="Ad free" />
                <flux:checkbox wire:model="isActive" label="Active" />
            </div>
        </div>

        <flux:button wire:click="save" variant="primary" class="mt-5" icon="check">
            Save Package
        </flux:button>
    </section>

    <section class="overflow-x-auto rounded-xl border border-zinc-200 bg-white p-4 dark:border-zinc-700 dark:bg-zinc-800">
        <table class="min-w-full text-sm">
            <thead>
                <tr class="text-left text-zinc-500 dark:text-zinc-400">
                    <th>Name</th>
                    <th>Price</th>
                    <th>Limit</th>
                    <th>Validity</th>
                    <th>Status</th>
                    <th><span class="sr-only">Actions</span></th>
                </tr>
            </thead>
            <tbody>
                @forelse ($packages as $package)
                    <tr wire:key="package-{{ $package->id }}" class="border-t border-zinc-200 dark:border-zinc-700">
                        <td class="py-2">{{ $package->name }}</td>
                        <td class="py-2">৳{{ $package->price }}</td>
                        <td class="py-2">{{ $package->question_create_limit }}</td>
                        <td class="py-2">{{ $package->validity_days }} days</td>
                        <td class="py-2">
                            <flux:badge :color="$package->is_active ? 'green' : 'zinc'">{{ $package->is_active ? 'Active' : 'Inactive' }}</flux:badge>
                        </td>
                        <td class="space-x-2 py-2 text-right">
                            <flux:button wire:click="edit({{ $package->id }})" size="sm" variant="ghost">Edit</flux:button>
                            <flux:button wire:click="delete({{ $package->id }})" wire:confirm="Delete this package?" size="sm" variant="danger">Delete</flux:button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="py-8 text-center text-zinc-500 dark:text-zinc-400">No packages found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </section>
</div>
