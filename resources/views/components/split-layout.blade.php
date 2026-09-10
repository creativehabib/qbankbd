@props([
    'header' => null,
])

<div class="space-y-6">
    @if($header)
        {{ $header }}
    @endif
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 items-start">
        <!-- Left Side: Form -->
        <div class="lg:col-span-1 sticky top-6">
            <flux:card>
                {{ $form }}
            </flux:card>
        </div>

        <!-- Right Side: Table -->
        <div class="lg:col-span-2">
            <flux:card class="p-0! overflow-hidden">
                {{ $table }}
            </flux:card>
        </div>
    </div>
</div>
