<div class="max-w-7xl mx-auto pb-12">
    <div class="flex items-center justify-between mb-6">
        <div class="flex items-center gap-3">
            <a href="{{ route('admin.settings.index') }}" class="p-2 rounded-full hover:bg-zinc-100 dark:hover:bg-zinc-800 transition-colors">
                <flux:icon name="arrow-left" class="h-5 w-5 text-zinc-500" />
            </a>
            <div>
                <flux:heading size="xl">General Settings</flux:heading>
                <flux:subheading>Manage your system's core information, contact details, and basic configuration.</flux:subheading>
            </div>
        </div>
        <flux:button wire:click="save" variant="primary" wire:loading.attr="disabled" wire:target="save">
            <span wire:loading.remove wire:target="save">Save changes</span>
            <span wire:loading wire:target="save">Saving...</span>
        </flux:button>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 max-w-7xl items-start">
        <flux:card>
            <div class="mb-6">
                <flux:heading size="lg">System Settings</flux:heading>
                <flux:text class="!text-sm">Configure system-wide settings for your application</flux:text>
            </div>
            
            <div class="space-y-6">
                
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                    <flux:select wire:model="default_language" label="Default Language" icon="language">
                        <option value="en">🇬🇧 English</option>
                        <option value="bn">🇧🇩 Bengali</option>
                    </flux:select>
                    
                    <flux:select wire:model="date_format" label="Date Format" icon="calendar">
                        <option value="M j, Y">M j, Y (Jan 1, 2025)</option>
                        <option value="d-m-Y">d-m-Y (01-01-2025)</option>
                        <option value="m-d-Y">m-d-Y (01-01-2025)</option>
                        <option value="Y-m-d">Y-m-d (2025-01-01)</option>
                        <option value="d M, Y">d M, Y (01 Jan, 2025)</option>
                        <option value="d F, Y">d F, Y (01 January, 2025)</option>
                        <option value="F j, Y">F j, Y (January 1, 2025)</option>
                        <option value="j F Y">j F Y (1 January 2025)</option>
                        <option value="D, M j, Y">D, M j, Y (Thu, Jan 1, 2025)</option>
                        <option value="l, F j, Y">l, F j, Y (Thursday, January 1, 2025)</option>
                        <option value="d/m/Y">d/m/Y (01/01/2025)</option>
                        <option value="m/d/Y">m/d/Y (01/01/2025)</option>
                    </flux:select>
                </div>
                
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                    <flux:select wire:model="time_format" label="Time Format" icon="clock">
                        <option value="H:i">H:i (13:30)</option>
                        <option value="h:i A">h:i A (01:30 PM)</option>
                    </flux:select>
                    
                    <flux:select wire:model="calendar_start_day" label="Calendar Start Day" icon="calendar-days">
                        <option value="Sunday">Sunday</option>
                        <option value="Monday">Monday</option>
                        <option value="Saturday">Saturday</option>
                    </flux:select>
                </div>
                
                <div class="grid grid-cols-1 gap-6">
                    <flux:select wire:model="default_timezone" label="Default Timezone" icon="globe-alt" searchable placeholder="Search timezones...">
                        @foreach($this->timezones as $tzValue => $tzLabel)
                            <option value="{{ $tzValue }}">{{ $tzLabel }}</option>
                        @endforeach
                    </flux:select>
                </div>
                
                <flux:separator variant="subtle" />
                
                <flux:switch wire:model="email_verification" label="Email Verification" description="Require users to verify their email addresses" />
                
                <flux:switch wire:model="landing_page" label="Landing Page" description="Enable or disable the public landing page" />
                
                <flux:switch wire:model="user_registration" label="User Registration" description="Allow new users to create accounts on your platform" />
                
                <div class="pt-2">
                    <flux:input wire:model="terms_conditions_url" label="Terms and Conditions URL" icon="link" placeholder="https://example.com/terms" description="Enter the URL for your Terms and Conditions page that will be linked in the registration form" />
                </div>
            </div>
        </flux:card>

        <flux:card>
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6 gap-4">
                <div>
                    <flux:heading size="lg">Basic Information</flux:heading>
                    <flux:text class="!text-sm">These details might be displayed on the frontend to the users.</flux:text>
                </div>
            </div>
            
            <div class="space-y-6">
                
                <flux:textarea wire:model="site_description" label="Site Description (SEO)" placeholder="Briefly describe what this platform is about..." rows="3" description="Used for SEO meta descriptions on the public site." />
                
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                    <flux:input wire:model="support_email" type="email" label="Support Email" icon="envelope" placeholder="support@example.com" />
                    
                    <flux:input wire:model="support_phone" label="Support Phone" icon="phone" placeholder="+8801XXXXXXXXX" />
                </div>
                
                <flux:textarea wire:model="company_address" label="Company Address" placeholder="123 Main Street, City, Country" rows="2" />
                
                <div class="grid grid-cols-1 gap-6">
                    <flux:select wire:model="system_currency" label="System Currency" icon="currency-dollar" required>
                        <option value="BDT">BDT (৳)</option>
                        <option value="USD">USD ($)</option>
                        <option value="EUR">EUR (€)</option>
                        <option value="INR">INR (₹)</option>
                    </flux:select>
                </div>

                <flux:separator variant="subtle" />

                <flux:heading size="lg">Social Media Links</flux:heading>
                <div class="space-y-4">
                    <flux:input wire:model="facebook_url" type="url" label="Facebook URL" icon="link" placeholder="https://facebook.com/yourpage" />
                    <flux:input wire:model="youtube_url" type="url" label="YouTube URL" icon="link" placeholder="https://youtube.com/c/yourchannel" />
                    <flux:input wire:model="linkedin_url" type="url" label="LinkedIn URL" icon="link" placeholder="https://linkedin.com/company/yourcompany" />
                </div>
            </div>
        </flux:card>
    </div>
</div>