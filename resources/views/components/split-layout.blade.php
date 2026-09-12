@props([
    'header' => null,
])

<div class="space-y-6">
    @if($header)
        {{ $header }}
    @endif
    <div class="flex flex-col lg:flex-row gap-6 items-start">
        <!-- Left Side: Table/List (flex-1) -->
        <div class="w-full lg:flex-[2]">
            <flux:card class="p-0! overflow-hidden">
                {{ $table }}
            </flux:card>
        </div>

        <!-- Right Side: Form/Panel (w-96) -->
        <div class="w-full lg:w-[400px] shrink-0 sticky top-6">
            <flux:card class="shadow-sm">
                {{ $form }}
            </flux:card>
        </div>
    </div>
    
    {{ $slot ?? '' }}
</div>
