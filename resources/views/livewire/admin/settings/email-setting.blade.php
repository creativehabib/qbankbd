<div class="max-w-7xl mx-auto pb-12">
    <div class="flex items-center justify-between mb-6">
        <div class="flex items-center gap-3">
            <a href="{{ route('admin.settings.index') }}" class="p-2 rounded-full hover:bg-zinc-100 dark:hover:bg-zinc-800 transition-colors">
                <flux:icon name="arrow-left" class="h-5 w-5 text-zinc-500" />
            </a>
            <div>
                <flux:heading size="xl">Email Settings</flux:heading>
                <flux:subheading>Configure SMTP settings for sending emails from the application.</flux:subheading>
            </div>
        </div>
        <div class="flex items-center gap-3">
            <flux:button wire:click="save" variant="primary" wire:loading.attr="disabled" wire:target="save">
                <span wire:loading.remove wire:target="save">Save changes</span>
                <span wire:loading wire:target="save">Saving...</span>
            </flux:button>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 max-w-7xl">
        <!-- Settings Form (Left) -->
        <div class="lg:col-span-2 space-y-6">
            <flux:card>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                    <flux:select wire:model="mail_mailer" label="Mail Driver" icon="server" required>
                        <option value="smtp">SMTP</option>
                        <option value="sendmail">Sendmail</option>
                        <option value="mailgun">Mailgun</option>
                        <option value="postmark">Postmark</option>
                        <option value="ses">Amazon SES</option>
                    </flux:select>
                    
                    <flux:input wire:model="mail_host" label="SMTP Host" icon="server" placeholder="e.g. smtp.mailtrap.io" required />
                    
                    <flux:input wire:model="mail_username" label="SMTP Username" icon="user" />
                    
                    <flux:input wire:model="mail_password" type="password" label="SMTP Password" icon="lock-closed" />

                    <flux:input wire:model="mail_port" label="SMTP Port" icon="server" placeholder="e.g. 587 or 465" required />
                    
                    <flux:select wire:model="mail_encryption" label="Mail Encryption" icon="lock-closed">
                        <option value="tls">TLS</option>
                        <option value="ssl">SSL</option>
                        <option value="">None</option>
                    </flux:select>
                    
                    <flux:input wire:model="mail_from_address" label="From Address" icon="envelope" placeholder="e.g. hello@example.com" required />
                    
                    <flux:input wire:model="mail_from_name" label="From Name" icon="user" placeholder="e.g. Question Bank" required />
                </div>
            </flux:card>
        </div>

        <!-- Test Email Widget (Right) -->
        <div class="lg:col-span-1">
            <flux:card>
                <div class="flex items-center gap-2 mb-6">
                    <flux:icon name="paper-airplane" class="w-5 h-5 text-emerald-500" />
                    <flux:heading size="lg">Test Email Configuration</flux:heading>
                </div>
                
                <div class="space-y-4">
                    <flux:input wire:model="test_email_to" label="Send Test To" placeholder="test@example.com" description="Enter an email address to send a test message" required />
                    
                    <flux:button wire:click="sendTestEmail" class="w-full bg-emerald-400 hover:bg-emerald-500 text-white border-emerald-400" icon="paper-airplane" wire:loading.attr="disabled" wire:target="sendTestEmail">
                        <span wire:loading.remove wire:target="sendTestEmail">Send Test Email</span>
                        <span wire:loading wire:target="sendTestEmail">Sending...</span>
                    </flux:button>
                </div>
            </flux:card>
        </div>
    </div>
</div>