<div class="flex items-center gap-2 w-full p-1 rounded-lg bg-zinc-100/50 dark:bg-zinc-800/50 border border-zinc-200/50 dark:border-zinc-700/50">
    <flux:dropdown position="bottom" align="start" class="flex-1 min-w-0">
        <button type="button" class="group flex items-center w-full rounded-lg hover:bg-zinc-800/5 dark:hover:bg-white/10 p-1" data-flux-sidebar-profile data-test="sidebar-menu-button">
            <div class="shrink-0">
                <flux:avatar :name="auth()->user()->name" :initials="auth()->user()->initials()" size="sm" />
            </div>
            <div class="in-data-flux-sidebar-collapsed-desktop:hidden mx-2 flex-1 flex flex-col text-left overflow-hidden">
                <span class="text-sm text-zinc-900 dark:text-white font-semibold truncate">{{ auth()->user()->name }}</span>
                @if(auth()->user()->isAdmin())
                    <span class="text-xs text-indigo-600 dark:text-indigo-400 font-bold flex items-center gap-1"><flux:icon.shield-check class="size-3"/> Admin</span>
                @elseif(auth()->user()->hasActiveSubscription())
                    <span class="text-xs text-amber-600 dark:text-amber-500 font-bold flex items-center gap-1"><flux:icon.sparkles class="size-3"/> Pro</span>
                @else
                    <span class="text-xs text-zinc-500 dark:text-zinc-400 font-medium">Free</span>
                @endif
            </div>
            <div class="in-data-flux-sidebar-collapsed-desktop:hidden shrink-0 ms-auto size-6 flex justify-center items-center">
                <flux:icon icon="chevrons-up-down" variant="micro" class="size-4 text-zinc-400 dark:text-white/80 group-hover:text-zinc-800 dark:group-hover:text-white" />
            </div>
        </button>

    <flux:menu>
        <div class="flex items-center gap-2 px-1 py-1.5 text-start text-sm">
            <flux:avatar
                :name="auth()->user()->name"
                :initials="auth()->user()->initials()"
            />
            <div class="grid flex-1 text-start text-sm leading-tight">
                <flux:heading class="truncate">{{ auth()->user()->name }}</flux:heading>
                <flux:text class="truncate">{{ auth()->user()->email }}</flux:text>
            </div>
        </div>
        <flux:menu.separator />
        <flux:menu.radio.group>
            <flux:menu.item :href="route('profile.edit')" icon="cog" wire:navigate>
                {{ __('Settings') }}
            </flux:menu.item>
            <form method="POST" action="{{ route('logout') }}" class="w-full">
                @csrf
                <flux:menu.item
                    as="button"
                    type="submit"
                    icon="arrow-right-start-on-rectangle"
                    class="w-full cursor-pointer"
                    data-test="logout-button"
                >
                    {{ __('Log out') }}
                </flux:menu.item>
            </form>
        </flux:menu.radio.group>
    </flux:menu>
</flux:dropdown>
    @if(!auth()->user()->hasActiveSubscription() && !auth()->user()->isAdmin())
        <a href="{{ route('student.pricing') }}" wire:navigate class="in-data-flux-sidebar-collapsed-desktop:hidden shrink-0 text-xs font-bold bg-white dark:bg-zinc-800 text-zinc-900 dark:text-white px-2 py-1.5 rounded-md border border-zinc-200 dark:border-zinc-700 shadow-sm hover:bg-zinc-50 dark:hover:bg-zinc-700 transition">
            Upgrade
        </a>
    @endif
</div>
