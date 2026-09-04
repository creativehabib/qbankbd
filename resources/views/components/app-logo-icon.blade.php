<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 260 80" width="100%" height="100%" class="h-12 w-auto">
    <defs>
        <!-- Light Mode Gradient for the Ring -->
        <linearGradient id="ringLight" x1="0%" y1="0%" x2="100%" y2="100%">
            <stop offset="0%" stop-color="#0F172A" /> <!-- Slate 900 -->
            <stop offset="100%" stop-color="#334155" /> <!-- Slate 700 -->
        </linearGradient>

        <!-- Dark Mode Gradient for the Ring (Silver/White finish) -->
        <linearGradient id="ringDark" x1="0%" y1="0%" x2="100%" y2="100%">
            <stop offset="0%" stop-color="#F8FAFC" /> <!-- Slate 50 -->
            <stop offset="100%" stop-color="#94A3B8" /> <!-- Slate 400 -->
        </linearGradient>

        <!-- Emerald Gradient for the Smart Dot -->
        <linearGradient id="neonDot" x1="0%" y1="0%" x2="100%" y2="100%">
            <stop offset="0%" stop-color="#34D399" />
            <stop offset="100%" stop-color="#059669" />
        </linearGradient>

        <!-- Subtle Glow Effect for the Green Dot (Looks amazing on Dark Mode) -->
        <filter id="emeraldGlow" x="-30%" y="-30%" width="160%" height="160%">
            <feDropShadow dx="0" dy="2" stdDeviation="4" flood-color="#10B981" flood-opacity="0.5" />
        </filter>

        <!-- Precision Cutout Mask -->
        <mask id="perfect-cutout">
            <rect x="-20" y="-20" width="120" height="120" fill="white" />
            <circle cx="52" cy="52" r="15" fill="black" />
        </mask>
    </defs>

    <g transform="translate(10, 5)">
        <!-- Light Mode Ring (Hidden in Dark Mode) -->
        <circle cx="35" cy="35" r="22"
                fill="none"
                stroke="url(#ringLight)"
                stroke-width="10"
                mask="url(#perfect-cutout)"
                class="block dark:hidden" />

        <!-- Dark Mode Ring (Hidden in Light Mode) -->
        <circle cx="35" cy="35" r="22"
                fill="none"
                stroke="url(#ringDark)"
                stroke-width="10"
                mask="url(#perfect-cutout)"
                class="hidden dark:block" />

        <!-- The Smart Dot (Remains vibrant in both modes) -->
        <circle cx="52" cy="52" r="8"
                fill="url(#neonDot)"
                filter="url(#emeraldGlow)" />
    </g>

    <!-- Typography: Automatically switches text color via Tailwind classes -->
    <!-- Removed inline 'fill' and added 'fill-slate-900 dark:fill-white' -->
    <text x="88" y="54"
          font-family="'Outfit', 'Plus Jakarta Sans', 'Inter', system-ui, -apple-system, sans-serif"
          font-size="42"
          font-weight="800"
          class="fill-slate-900 dark:fill-white transition-colors duration-300"
          letter-spacing="-0.03em">
        Qerobi
    </text>
</svg>
