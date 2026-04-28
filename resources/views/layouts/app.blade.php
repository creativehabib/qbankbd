@php
    $pageTitle = $pageTitle ?? $title ?? 'Dashboard';
@endphp

<x-layouts::app.sidebar :title="$title ?? null">
    <!-- মূল কন্টেন্ট -->
    <flux:main class="pt-5 print:p-0 print:m-0 print:w-full print:block">
        {{ $slot }}
    </flux:main>
</x-layouts::app.sidebar>
