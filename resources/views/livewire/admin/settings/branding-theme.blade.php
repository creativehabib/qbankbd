<div class="max-w-7xl mx-auto pb-12">
    <div class="flex items-center justify-between mb-6">
        <div class="flex items-center gap-3">
            <a href="{{ route('admin.settings.index') }}" class="p-2 rounded-full hover:bg-zinc-100 dark:hover:bg-zinc-800 transition-colors">
                <flux:icon name="arrow-left" class="h-5 w-5 text-zinc-500" />
            </a>
            <div>
                <flux:heading size="xl">Branding & theme</flux:heading>
                <flux:subheading>Make the admin yours — app name, logos, accent color, favicon, and default theme.</flux:subheading>
            </div>
        </div>
        <flux:button wire:click="save" variant="primary" wire:loading.attr="disabled" wire:target="save">
            <span wire:loading.remove wire:target="save">Save changes</span>
            <span wire:loading wire:target="save">Saving...</span>
        </flux:button>
    </div>

    <div class="flex flex-col lg:flex-row gap-8">
        <!-- Main Form -->
        <div class="flex-1 space-y-6">
            
            <!-- App Name -->
            <flux:card>
                <div class="mb-4">
                    <h3 class="text-sm font-semibold text-zinc-900 dark:text-zinc-100">App name</h3>
                    <p class="text-xs text-zinc-500 dark:text-zinc-400">Shown in the browser title, sidebar, and login page. Independent of the company name on receipts.</p>
                </div>
                <div class="space-y-2">
                    <label class="text-xs font-medium text-zinc-500 uppercase tracking-wider">App Name</label>
                    <flux:input wire:model="app_name" placeholder="Hyper POS" />
                    <p class="text-xs text-zinc-400">Leave blank to use the server default (config('app.name')).</p>
                </div>
            </flux:card>

            <!-- Footer -->
            <flux:card>
                <div class="mb-4">
                    <h3 class="text-sm font-semibold text-zinc-900 dark:text-zinc-100">Footer</h3>
                    <p class="text-xs text-zinc-500 dark:text-zinc-400">A short line shown at the bottom of every admin page — copyright, version, or a support link.</p>
                </div>
                <div class="space-y-2">
                    <label class="text-xs font-medium text-zinc-500 uppercase tracking-wider">Footer Text</label>
                    <flux:input wire:model="footer_text" placeholder="© 2026 Hyper POS. All rights reserved." />
                    <p class="text-xs text-zinc-400">Leave blank to hide the footer entirely. Max 300 characters.</p>
                </div>
            </flux:card>

            <!-- App logos -->
            <flux:card class="space-y-6">
                <div>
                    <h3 class="text-sm font-semibold text-zinc-900 dark:text-zinc-100">App logos</h3>
                    <p class="text-xs text-zinc-500 dark:text-zinc-400">Full logo for the expanded sidebar; compact icon for the collapsed state. Add dark-mode variants for each.</p>
                </div>

                <!-- Full logo -->
                <div>
                    <div class="flex justify-between items-center mb-2">
                        <label class="text-sm font-medium text-zinc-700 dark:text-zinc-300">Full logo (expanded sidebar)</label>
                        <span class="text-xs text-zinc-400 bg-zinc-100 dark:bg-zinc-800 px-2 py-1 rounded">Max 400 × 80 px · PNG / JPG / WebP</span>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        
                        <div class="space-y-2">
                                                                                                                <x-modern-image-uploader 
                                label="LIGHT MODE" 
                                uploadModel="logo_light_upload" 
                                :upload="$logo_light_upload"
                                existingModel="logo_light" 
                                :existing="$logo_light"
                                mode="light"
                                emptyTitle="Drag the app logo or click to browse"
                                emptyHint="PNG, JPG, or WebP · up to 2048 KB"
                                previewHeight="h-32" 
                            />  
                        </div>


                        
                        <div class="space-y-2">
                                                                                                                <x-modern-image-uploader 
                                label="DARK MODE" 
                                uploadModel="logo_dark_upload" 
                                :upload="$logo_dark_upload"
                                existingModel="logo_dark" 
                                :existing="$logo_dark"
                                mode="dark"
                                emptyTitle="Drag the app logo or click to browse"
                                emptyHint="PNG, JPG, or WebP · up to 2048 KB"
                                previewHeight="h-32" 
                            />  
                        </div>

                    </div>
                </div>

                <hr class="border-zinc-200 dark:border-zinc-800">

                <!-- Collapsed icon -->
                <div>
                    <div class="flex justify-between items-center mb-2">
                        <label class="text-sm font-medium text-zinc-700 dark:text-zinc-300">Collapsed sidebar icon</label>
                        <span class="text-xs text-zinc-400 bg-zinc-100 dark:bg-zinc-800 px-2 py-1 rounded">Ideal 80 × 80 px · PNG / JPG / WebP</span>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        
                        <div class="space-y-2">
                                                                                                                <x-modern-image-uploader 
                                label="LIGHT MODE" 
                                uploadModel="icon_light_upload" 
                                :upload="$icon_light_upload"
                                existingModel="icon_light" 
                                :existing="$icon_light"
                                mode="light"
                                emptyTitle="Drag the icon/mark or click to browse"
                                emptyHint="PNG, JPG, or WebP · up to 2048 KB"
                                previewHeight="h-48" 
                            />  
                        </div>


                        
                        <div class="space-y-2">
                                                                                                                <x-modern-image-uploader 
                                label="DARK MODE" 
                                uploadModel="icon_dark_upload" 
                                :upload="$icon_dark_upload"
                                existingModel="icon_dark" 
                                :existing="$icon_dark"
                                mode="dark"
                                emptyTitle="Drag the icon/mark or click to browse"
                                emptyHint="PNG, JPG, or WebP · up to 2048 KB"
                                previewHeight="h-48" 
                            />  
                        </div>

                    </div>
                </div>
            </flux:card>

            <!-- Favicon -->
            <flux:card>
                <div class="mb-4">
                    <h3 class="text-sm font-semibold text-zinc-900 dark:text-zinc-100">Favicon</h3>
                    <p class="text-xs text-zinc-500 dark:text-zinc-400">The little icon in the browser tab. PNG, JPG, or ICO.</p>
                </div>
                
                
                <div>
                                                                                                <x-modern-image-uploader 
                                label="" 
                                uploadModel="favicon_upload" 
                                :upload="$favicon_upload"
                                existingModel="favicon" 
                                :existing="$favicon"
                                mode="auto"
                                emptyTitle="Drag a favicon or click to browse"
                                emptyHint="PNG, JPG, or ICO · up to 1024 KB"
                                previewHeight="h-48" 
                            />  
                </div>
            </flux:card>

            <!-- Accent Color -->
            <flux:card>
                <div class="mb-4">
                    <h3 class="text-sm font-semibold text-zinc-900 dark:text-zinc-100">Accent color</h3>
                    <p class="text-xs text-zinc-500 dark:text-zinc-400">Recolors buttons, links, toggles, and highlights across the admin.</p>
                </div>

                <div class="space-y-4">
                    <div class="space-y-2">
                                                <label class="text-[11px] font-bold text-zinc-400 dark:text-zinc-500 uppercase tracking-wider">Suggested</label>
                        <div class="flex flex-wrap gap-2">
                            @php
                                $colors = [
                                    '#f97316', // Orange
                                    '#f43f5e', // Rose/Pink
                                    '#9f1239', // Dark Red
                                    '#8b5cf6', // Purple
                                    '#3b82f6', // Blue
                                    '#06b6d4', // Cyan
                                    '#10b981', // Emerald
                                    '#d97706', // Yellow/Amber
                                    '#0f172a', // Slate/Black
                                ];
                            @endphp
                            @foreach($colors as $color)
                                <button type="button" wire:click="$set('accent_color', '{{ $color }}')" 
                                        class="w-8 h-8 rounded-lg shadow-sm transition-all focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-zinc-900 dark:focus:ring-offset-zinc-900
                                        {{ $accent_color === $color ? 'ring-2 ring-accent ring-offset-2 dark:ring-offset-zinc-900' : 'border border-zinc-200 dark:border-zinc-700' }}"
                                        style="background-color: {{ $color }};">
                                </button>
                            @endforeach
                        </div>
                    </div>

                    <div class="space-y-2 pt-2">
                        <label class="text-[11px] font-bold text-zinc-400 dark:text-zinc-500 uppercase tracking-wider">Custom</label>
                        <div class="flex items-center">
                            <label class="flex items-center gap-3 cursor-pointer">
                                <div class="relative flex items-center justify-center size-10 bg-white dark:bg-zinc-800 border border-zinc-200 dark:border-zinc-700 rounded-lg p-1 shadow-sm">
                                    <div class="w-full h-full rounded-[4px]" style="background-color: {{ $accent_color }};"></div>
                                    <input type="color" wire:model.live="accent_color" class="absolute inset-0 opacity-0 cursor-pointer w-full h-full" />
                                </div>
                                <span class="text-sm font-medium text-zinc-600 dark:text-zinc-300 w-16">{{ strtoupper($accent_color) }}</span>
                            </label>
                            <button type="button" wire:click="$set('accent_color', '#f97316')" class="text-sm font-medium text-zinc-500 hover:text-zinc-800 dark:hover:text-zinc-200 transition-colors ml-4">
                                Reset to default
                            </button>
                        </div>
                    </div>
                </div>
            </flux:card>

            <!-- Text Color -->
                        <flux:card>
                <div class="mb-4">
                    <h3 class="text-sm font-semibold text-zinc-900 dark:text-zinc-100">Text color</h3>
                    <p class="text-xs text-zinc-500 dark:text-zinc-400">The color of text and icons sitting on accent-filled buttons. Pick the one with the best contrast.</p>
                </div>

                <div class="flex items-center gap-4">
                    <div class="flex gap-2">
                        <button type="button" wire:click="$set('text_color', '#ffffff')" 
                                class="w-8 h-8 rounded-lg shadow-sm transition-all bg-white border border-zinc-200 dark:border-zinc-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-zinc-900 dark:focus:ring-offset-zinc-900
                                {{ $text_color === '#ffffff' ? 'ring-2 ring-zinc-900 dark:ring-white ring-offset-2 dark:ring-offset-zinc-900' : '' }}">
                        </button>
                        <button type="button" wire:click="$set('text_color', '#000000')" 
                                class="w-8 h-8 rounded-lg shadow-sm transition-all bg-black border border-zinc-900 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-zinc-900 dark:focus:ring-offset-zinc-900
                                {{ $text_color === '#000000' ? 'ring-2 ring-zinc-900 dark:ring-white ring-offset-2 dark:ring-offset-zinc-900' : '' }}">
                        </button>
                    </div>

                    <label class="flex items-center gap-3 cursor-pointer ml-2">
                        <div class="relative flex items-center justify-center size-10 bg-white dark:bg-zinc-800 border border-zinc-200 dark:border-zinc-700 rounded-lg p-1 shadow-sm">
                            <div class="w-full h-full rounded-[4px] border border-black/10 dark:border-white/10" style="background-color: {{ $text_color }};"></div>
                            <input type="color" wire:model.live="text_color" class="absolute inset-0 opacity-0 cursor-pointer w-full h-full" />
                        </div>
                        <span class="text-sm font-medium text-zinc-600 dark:text-zinc-300 w-16">{{ strtoupper($text_color) }}</span>
                    </label>
                </div>
            </flux:card>

            <!-- Default theme -->
            <flux:card>
                <div class="mb-4">
                    <h3 class="text-sm font-semibold text-zinc-900 dark:text-zinc-100">Default theme</h3>
                    <p class="text-xs text-zinc-500 dark:text-zinc-400">What new users see until they pick their own in the profile menu.</p>
                </div>

                <div class="space-y-2">
                    <label class="text-xs font-medium text-zinc-500 uppercase tracking-wider">Default Theme</label>
                    <flux:select wire:model="default_theme" class="w-full">
                        <flux:select.option value="System">System default</flux:select.option>
                        <flux:select.option value="Light">Light</flux:select.option>
                        <flux:select.option value="Dark">Dark</flux:select.option>
                    </flux:select>
                </div>
            </flux:card>
        </div>

        <!-- Sidebar / Live Preview -->
        <div class="lg:w-[350px] shrink-0">
            <div class="sticky top-6 space-y-4">
                <div>
                    <h3 class="text-sm font-semibold text-zinc-900 dark:text-zinc-100">Live preview</h3>
                    <p class="text-xs text-zinc-500 dark:text-zinc-400">How the accent looks across the admin — in light and dark.</p>
                </div>

                <!-- Light Preview -->
                <div class="rounded-xl border border-zinc-200 bg-white p-4 shadow-sm relative overflow-hidden">
                    <div class="text-[10px] font-bold text-zinc-400 uppercase tracking-widest mb-4">Light</div>
                    
                    <div class="space-y-4">
                        <div class="flex justify-between items-center bg-zinc-50 p-2 rounded-lg border border-zinc-100">
                            <div class="flex items-center gap-2">
                                <div class="w-2 h-2 rounded-full" style="background-color: {{ $accent_color }}"></div>
                                <span class="text-sm font-medium text-zinc-900">Dashboard</span>
                            </div>
                            <span class="text-xs font-medium px-2 py-0.5 rounded-full" style="color: {{ $accent_color }}; background-color: {{ $accent_color }}20;">Active</span>
                        </div>

                        <div class="flex justify-between items-center px-1">
                            <button class="px-3 py-1.5 rounded-md text-sm font-medium shadow-sm" style="background-color: {{ $accent_color }}; color: {{ $text_color }};">
                                New sale
                            </button>
                            <span class="text-sm font-medium" style="color: {{ $accent_color }};">View report</span>
                        </div>

                        <div class="flex items-center gap-3 px-1">
                            <div class="w-10 h-6 rounded-full relative transition-colors duration-200" style="background-color: {{ $accent_color }};">
                                <div class="absolute right-1 top-1 w-4 h-4 rounded-full bg-white shadow-sm"></div>
                            </div>
                            <span class="text-sm font-medium text-zinc-700">Enabled</span>
                        </div>
                    </div>
                </div>

                <!-- Dark Preview -->
                <div class="rounded-xl border border-zinc-700 bg-zinc-950 p-4 shadow-sm relative overflow-hidden">
                    <div class="text-[10px] font-bold text-zinc-500 uppercase tracking-widest mb-4">Dark</div>
                    
                    <div class="space-y-4">
                        <div class="flex justify-between items-center bg-zinc-900 p-2 rounded-lg border border-zinc-800">
                            <div class="flex items-center gap-2">
                                <div class="w-2 h-2 rounded-full" style="background-color: {{ $accent_color }}"></div>
                                <span class="text-sm font-medium text-white">Dashboard</span>
                            </div>
                            <span class="text-xs font-medium px-2 py-0.5 rounded-full" style="color: {{ $accent_color }}; background-color: {{ $accent_color }}20;">Active</span>
                        </div>

                        <div class="flex justify-between items-center px-1">
                            <button class="px-3 py-1.5 rounded-md text-sm font-medium shadow-sm" style="background-color: {{ $accent_color }}; color: {{ $text_color }};">
                                New sale
                            </button>
                            <span class="text-sm font-medium" style="color: {{ $accent_color }};">View report</span>
                        </div>

                        <div class="flex items-center gap-3 px-1">
                            <div class="w-10 h-6 rounded-full relative transition-colors duration-200" style="background-color: {{ $accent_color }};">
                                <div class="absolute right-1 top-1 w-4 h-4 rounded-full bg-white shadow-sm"></div>
                            </div>
                            <span class="text-sm font-medium text-zinc-300">Enabled</span>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('livewire:initialized', () => {
        Livewire.on('branding-saved', () => {
            if (window.Flux) {
                window.Flux.toast({ variant: 'success', text: 'Branding settings updated successfully!' });
            }
        });
    });
</script>

<script>
    document.addEventListener('livewire:init', () => {
        Livewire.on('default-theme-updated', (event) => {
            let theme = event.theme || (event[0] && event[0].theme) || (event[0] ? event[0] : null);
            
            if (theme) {
                window.localStorage.removeItem('flux.appearance');
                window.localStorage.removeItem('theme');
            }
        });

        Livewire.on('branding-saved', () => {
            if (typeof Flux !== 'undefined' && typeof Flux.toast === 'function') {
                Flux.toast({
                    title: 'Settings saved',
                    description: 'Applying new branding theme...',
                    variant: 'success'
                });
            }
            // Reload the page so that CSS variables in <head> and new logos are applied instantly
            setTimeout(() => {
                window.location.reload();
            }, 800); 
        });
    });
</script>