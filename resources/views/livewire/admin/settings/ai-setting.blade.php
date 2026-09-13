<div class="max-w-7xl mx-auto pb-12">
    <div class="flex items-center justify-between mb-6">
        <div class="flex items-center gap-3">
            <a href="{{ route('admin.settings.index') }}" class="p-2 rounded-full hover:bg-zinc-100 dark:hover:bg-zinc-800 transition-colors">
                <flux:icon name="arrow-left" class="h-5 w-5 text-zinc-500" />
            </a>
            <div>
                <flux:heading size="xl">AI Settings</flux:heading>
                <flux:subheading>Configure Artificial Intelligence providers and API keys used across the platform.</flux:subheading>
            </div>
        </div>
        <flux:button wire:click="save" variant="primary" wire:loading.attr="disabled" wire:target="save">
            <span wire:loading.remove wire:target="save">Save changes</span>
            <span wire:loading wire:target="save">Saving...</span>
        </flux:button>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 max-w-7xl items-start">
        <!-- AI Provider Selection (Left Column) -->
        <div class="lg:col-span-1 space-y-6">
            <flux:card>
                <flux:heading size="lg">Select AI Provider</flux:heading>
                <flux:text class="!text-sm mb-4">Choose which artificial intelligence provider you want to use as the default for the system.</flux:text>
                
                <flux:radio.group wire:model.live="ai_provider">
                    <flux:radio value="openai" label="Chat GPT (OpenAI)" description="Use OpenAI's GPT models" />
                    <flux:radio value="gemini" label="Google Gemini" description="Use Google's Gemini AI models (Recommended)" />
                </flux:radio.group>
            </flux:card>
        </div>

        <!-- Provider Specific Settings (Right Column) -->
        <div class="lg:col-span-2 space-y-6">
            @if($ai_provider === 'openai')
                <flux:card>
                    <div class="mb-6">
                        <flux:heading size="lg">Chat GPT Settings</flux:heading>
                        <flux:text class="!text-sm">Configure Chat GPT integration settings for AI-powered features</flux:text>
                    </div>
                    
                    <div class="space-y-6">
                        <flux:input type="password" wire:model="openai_api_key" label="Chat GPT Key" icon="key" placeholder="Enter your OpenAI API key" required />
                        
                        <flux:select wire:model="openai_model" label="Chat GPT Model Name" icon="cpu-chip" required>
                            <option value="gpt-3.5-turbo">GPT-3.5 Turbo</option>
                            <option value="gpt-4">GPT-4</option>
                            <option value="gpt-4o">GPT-4o</option>
                            <option value="gpt-4o-mini">GPT-4o Mini</option>
                            <option value="gpt-4-turbo">GPT-4 Turbo</option>
                        </flux:select>
                    </div>
                </flux:card>
            @endif

            @if($ai_provider === 'gemini')
                <flux:card>
                    <div class="mb-6">
                        <flux:heading size="lg">Google Gemini Settings</flux:heading>
                        <flux:text class="!text-sm">Configure Google Gemini integration settings for AI-powered features</flux:text>
                    </div>
                    
                    <div class="space-y-6">
                        <flux:input type="password" wire:model="gemini_api_key" label="Gemini API Key" icon="key" placeholder="Enter your Gemini API key" required />
                        
                        <flux:select wire:model="gemini_model" label="Primary Gemini Model" icon="cpu-chip" required>
                            <option value="gemini-2.5-flash-lite">Gemini 2.5 Flash-Lite (Fastest & most lightweight)</option>
                            <option value="gemini-2.5-flash">Gemini 2.5 Flash (Fast & Cost-effective)</option>
                            <option value="gemini-2.5-pro">Gemini 2.5 Pro (Complex reasoning)</option>
                            <option value="gemini-3.5-flash-lite">Gemini 3.5 Flash-Lite (Next generation lightweight)</option>
                            <option value="gemini-3.5-flash">Gemini 3.5 Flash (Next generation fast)</option>
                            <option value="gemini-1.5-flash">Gemini 1.5 Flash (Legacy)</option>
                            <option value="gemini-1.5-pro">Gemini 1.5 Pro (Legacy)</option>
                        </flux:select>
                        
                        <flux:separator variant="subtle" />
                        
                        <flux:switch wire:model.live="enable_gemini_fallback" label="Enable Dynamic Model Fallback" description="If the primary model reaches its limit or fails, automatically switch to a fallback model." />
                        
                        @if($enable_gemini_fallback)
                            <flux:select wire:model="gemini_fallback_model" label="Fallback Model" icon="cpu-chip" required>
                                <option value="gemini-2.5-flash-lite">Gemini 2.5 Flash-Lite (Fastest & most lightweight)</option>
                            <option value="gemini-2.5-flash">Gemini 2.5 Flash (Fast & Cost-effective)</option>
                            <option value="gemini-2.5-pro">Gemini 2.5 Pro (Complex reasoning)</option>
                            <option value="gemini-3.5-flash-lite">Gemini 3.5 Flash-Lite (Next generation lightweight)</option>
                            <option value="gemini-3.5-flash">Gemini 3.5 Flash (Next generation fast)</option>
                            <option value="gemini-1.5-flash">Gemini 1.5 Flash (Legacy)</option>
                            <option value="gemini-1.5-pro">Gemini 1.5 Pro (Legacy)</option>
                            </flux:select>
                        @endif
                    </div>
                </flux:card>
            @endif
        </div>
    </div>
</div>