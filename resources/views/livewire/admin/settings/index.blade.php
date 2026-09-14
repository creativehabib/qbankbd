<div class="max-w-7xl mx-auto space-y-6 pb-12">
    <div>
        <flux:heading size="xl">Settings</flux:heading>
        <flux:subheading>Configure how the system behaves across every screen.</flux:subheading>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4">
        @php
            $settings = [
                ['title' => 'Company profile', 'desc' => 'Your business name, legal details, address, and logo — shown on receipts, reports, and headers.', 'icon' => 'building-storefront', 'route' => '#'],
                ['title' => 'Branding & theme', 'desc' => 'Accent color, favicon, and the default light/dark theme for the admin.', 'icon' => 'photo', 'route' => route('admin.settings.branding')],
                ['title' => 'Regional', 'desc' => 'Time zone and how dates and times are displayed across the system.', 'icon' => 'globe-alt', 'route' => '#'],
                ['title' => 'Currency & formatting', 'desc' => 'Base currency, symbol, placement, decimals, and number separators used everywhere.', 'icon' => 'banknotes', 'route' => '#'],
                
                ['title' => 'Receipt template', 'desc' => 'Paper size, what to show, and the editable header/footer/return-policy text.', 'icon' => 'document-text', 'route' => '#'],
                ['title' => 'Cashier (POS)', 'desc' => 'Layout, tile size, default theme, and which totals show on the cashier checkout screen.', 'icon' => 'computer-desktop', 'route' => '#'],
                ['title' => 'Security', 'desc' => 'Sign-in policy for every account on this install.', 'icon' => 'lock-closed', 'route' => '#'],
                ['title' => 'Header & footer scripts', 'desc' => 'Add trusted analytics, tag-manager, or tracking snippets to selected browser pages.', 'icon' => 'shield-check', 'route' => '#'],
                
                ['title' => 'Weighing scale', 'desc' => 'Decode scale-printed barcodes (embedded weight or price) so weighed items ring up.', 'icon' => 'scale', 'route' => '#'],
                ['title' => 'Stock locations', 'desc' => 'Name the shelf coordinates your shop actually uses — aisle, rack, shelf, bin.', 'icon' => 'cube', 'route' => '#'],
                ['title' => 'Loyalty points', 'desc' => 'Reward repeat customers — set how points are earned on every sale, what they are worth.', 'icon' => 'users', 'route' => '#'],
                ['title' => 'Pricing', 'desc' => 'Cost-to-selling automation — auto-update selling price when goods are received.', 'icon' => 'tag', 'route' => '#'],

                ['title' => 'Numbering', 'desc' => 'Customise number formats for sales, refunds, held orders, and auto-generated product SKUs.', 'icon' => 'hashtag', 'route' => '#'],
                ['title' => 'Email & SMTP', 'desc' => 'How the system sends mail — password resets, receipts-by-email, and notifications.', 'icon' => 'envelope', 'route' => '#'],
                ['title' => 'WhatsApp', 'desc' => 'Send transactional documents through free Click-to-Chat or an official API connection.', 'icon' => 'chat-bubble-left-right', 'route' => '#'],
                ['title' => 'Payment Gateways', 'desc' => 'Configure API keys and credentials for payment gateways like bKash and SSLCommerz.', 'icon' => 'credit-card', 'route' => route('admin.settings.payment')],
            ];
        @endphp

        @foreach($settings as $setting)
            <a href="{{ $setting['route'] }}" class="group block rounded-xl border border-zinc-200 bg-white p-5 hover:border-orange-500 hover:ring-1 hover:ring-orange-500 dark:border-zinc-800 dark:bg-zinc-900 dark:hover:border-orange-500 transition-all">
                <div class="flex items-start gap-4">
                    <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg bg-orange-50 text-orange-600 dark:bg-orange-500/10 dark:text-orange-500">
                        <flux:icon name="{{ $setting['icon'] }}" variant="outline" class="h-6 w-6" />
                    </div>
                    <div class="flex-1">
                        <div class="flex items-center justify-between">
                            <h3 class="font-semibold text-zinc-900 dark:text-zinc-100">{{ $setting['title'] }}</h3>
                            <flux:icon.chevron-right class="h-4 w-4 text-zinc-400 group-hover:text-orange-500 transition-colors" />
                        </div>
                        <p class="mt-1 text-sm text-zinc-500 dark:text-zinc-400 line-clamp-3">
                            {{ $setting['desc'] }}
                        </p>
                    </div>
                </div>
            </a>
        @endforeach
    </div>
</div>
