<div>
    <div class="mb-6">
        <flux:heading size="xl">Payment Gateways</flux:heading>
        <flux:subheading>Configure API keys and credentials for payment gateways like bKash and SSLCommerz.</flux:subheading>
    </div>

    <form wire:submit="save" class="space-y-6">
        
        <!-- SSLCommerz Settings -->
        <flux:card>
            <div class="flex items-center gap-4 mb-4 border-b border-zinc-100 pb-4 dark:border-zinc-800">
                <div class="font-black text-2xl tracking-tighter" style="color:#0f5898">SSLCommerz</div>
                <div>
                    <h3 class="text-lg font-bold text-zinc-800 dark:text-zinc-100">SSLCommerz Settings</h3>
                    <p class="text-sm text-zinc-500">Enable and configure SSLCommerz integration.</p>
                </div>
            </div>

            <div class="space-y-6">
                <flux:switch wire:model.live="sslcommerz_active" label="Enable SSLCommerz" description="Allow students to pay using Cards, Mobile Banking via SSLCommerz." />

                <div x-show="$wire.sslcommerz_active" class="space-y-6 pt-4 border-t border-zinc-100 dark:border-zinc-800">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <flux:input wire:model="sslcommerz_store_id" label="Store ID" placeholder="Enter your Store ID" />
                        <flux:input wire:model="sslcommerz_store_password" label="Store Password" type="password" placeholder="Enter your Store Password" viewable />
                    </div>
                    
                    <flux:switch wire:model="sslcommerz_sandbox" label="Sandbox Mode (Test Environment)" description="Enable test mode for local development. Turn off for production." />
                </div>
            </div>
        </flux:card>

        <!-- bKash Settings -->
        <flux:card>
            <div class="flex items-center gap-4 mb-4 border-b border-zinc-100 pb-4 dark:border-zinc-800">
                <div class="font-black text-3xl tracking-tighter" style="color:#e2136e">bKash</div>
                <div>
                    <h3 class="text-lg font-bold text-zinc-800 dark:text-zinc-100">bKash Payment Gateway</h3>
                    <p class="text-sm text-zinc-500">Enable and configure bKash PGW API.</p>
                </div>
            </div>

            <div class="space-y-6">
                <flux:switch wire:model.live="bkash_active" label="Enable bKash" description="Allow students to pay directly via bKash." />

                <div x-show="$wire.bkash_active" class="space-y-6 pt-4 border-t border-zinc-100 dark:border-zinc-800">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <flux:input wire:model="bkash_app_key" label="App Key" placeholder="Enter App Key" />
                        <flux:input wire:model="bkash_app_secret" label="App Secret" type="password" placeholder="Enter App Secret" viewable />
                        <flux:input wire:model="bkash_username" label="Username" placeholder="Enter Username" />
                        <flux:input wire:model="bkash_password" label="Password" type="password" placeholder="Enter Password" viewable />
                    </div>

                    <flux:switch wire:model="bkash_sandbox" label="Sandbox Mode (Test Environment)" description="Enable bKash sandbox API. Turn off for production." />
                </div>
            </div>
        </flux:card>

        <div class="flex items-center gap-4">
            <flux:button type="submit" variant="primary">Save Changes</flux:button>
            
            <div wire:loading wire:target="save" class="text-sm text-zinc-500 flex items-center gap-2">
                <flux:icon.arrow-path class="size-4 animate-spin" /> Saving...
            </div>
        </div>

    </form>
</div>
