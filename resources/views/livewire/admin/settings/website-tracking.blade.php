<div class="max-w-7xl mx-auto pb-12">
    <div class="flex items-center justify-between mb-6">
        <div class="flex items-center gap-3">
            <a href="{{ route('admin.settings.index') }}" class="p-2 rounded-full hover:bg-zinc-100 dark:hover:bg-zinc-800 transition-colors">
                <flux:icon name="arrow-left" class="h-5 w-5 text-zinc-500" />
            </a>
            <div>
                <flux:heading size="xl">Website Tracking</flux:heading>
                <flux:subheading>Manage Google Analytics, Facebook Pixel, and custom tracking scripts.</flux:subheading>
            </div>
        </div>
        <flux:button wire:click="save" variant="primary" wire:loading.attr="disabled" wire:target="save">
            <span wire:loading.remove wire:target="save">Save changes</span>
            <span wire:loading wire:target="save">Saving...</span>
        </flux:button>
    </div>

    <div class="space-y-6 max-w-4xl">
        <flux:card>
            <div class="space-y-6">
                
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                    <flux:input wire:model="google_analytics_id" label="Google Analytics ID" placeholder="e.g. G-XXXXXXX" />
                    
                    <flux:input wire:model="facebook_pixel_id" label="Facebook Pixel ID" placeholder="e.g. 1234567890" />
                </div>

                <flux:separator variant="subtle" />

                <flux:heading size="lg">Custom Scripts</flux:heading>
                <flux:text class="!text-sm">These scripts will be injected into the website. Be careful with what you add here.</flux:text>

                <div class="grid grid-cols-1 gap-6">
                    <flux:textarea wire:model="custom_header_script" label="Header Script" placeholder="<script>...</script>" rows="4" description="Inserted just before the closing </head> tag." />
                    
                    <flux:textarea wire:model="custom_footer_script" label="Footer Script" placeholder="<script>...</script>" rows="4" description="Inserted just before the closing </body> tag." />
                </div>
            </div>
        </flux:card>
    </div>
</div>