<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 260 80" width="100%" height="100%" class="h-12 w-auto">
    <defs>
        <!-- 🌟 Light Mode Gradient -->
        <linearGradient id="ringLight" x1="0%" y1="0%" x2="100%" y2="100%">
            <stop offset="0%" stop-color="#0F172A" /> <!-- Slate 900 -->
            <stop offset="100%" stop-color="#334155" /> <!-- Slate 700 -->
        </linearGradient>

        <!-- 🌙 Dark Mode Gradient -->
        <linearGradient id="ringDark" x1="0%" y1="0%" x2="100%" y2="100%">
            <stop offset="0%" stop-color="#F8FAFC" /> <!-- Slate 50 -->
            <stop offset="100%" stop-color="#E2E8F0" /> <!-- Slate 200 -->
        </linearGradient>

        <!-- 🔮 AI Spark Gradient -->
        <linearGradient id="aiSparkGrad" x1="0%" y1="0%" x2="100%" y2="100%">
            <stop offset="0%" stop-color="#06B6D4" /> <!-- Electric Cyan -->
            <stop offset="100%" stop-color="#10B981" /> <!-- Vibrant Emerald -->
        </linearGradient>

        <!-- Premium Glow for the AI Spark -->
        <filter id="aiGlow" x="-30%" y="-30%" width="160%" height="160%">
            <feDropShadow dx="0" dy="2" stdDeviation="4" flood-color="#10B981" flood-opacity="0.5" />
        </filter>

        <!-- ✂️ Precision Cutout Mask -->
        <mask id="perfect-cutout">
            <rect x="-20" y="-20" width="120" height="120" fill="white" />
            <!-- Slightly increased mask to give the sharper star more breathing room -->
            <circle cx="52" cy="52" r="18" fill="black" />
        </mask>
    </defs>

    <g transform="translate(10, 5)">
        <!-- Ring (Light Mode) -->
        <circle cx="35" cy="35" r="22"
                fill="none"
                stroke="url(#ringLight)"
                stroke-width="10"
                mask="url(#perfect-cutout)"
                class="block dark:hidden transition-colors duration-300" />

        <!-- Ring (Dark Mode) -->
        <circle cx="35" cy="35" r="22"
                fill="none"
                stroke="url(#ringDark)"
                stroke-width="10"
                mask="url(#perfect-cutout)"
                class="hidden dark:block transition-colors duration-300" />

        <!-- 🔮 THE REFINED AI SPARKLE -->
        <!-- Made sharper and more elegant to match top-tier AI branding -->
        <path d="M 52 34 Q 52 52 34 52 Q 52 52 52 70 Q 52 52 70 52 Q 52 52 52 34 Z"
              fill="url(#aiSparkGrad)"
              filter="url(#aiGlow)" />
    </g>

    <!-- Typography -->
    <text x="90" y="54"
          font-family="'Outfit', 'Plus Jakarta Sans', 'Inter', system-ui, -apple-system, sans-serif"
          font-size="42"
          font-weight="800"
          class="fill-slate-900 dark:fill-white transition-colors duration-300"
          letter-spacing="-0.03em">
        Qerobi
    </text>

    <!-- Tech Accent Dot (Slightly re-aligned for perfect baseline match) -->
    <circle cx="238" cy="50" r="4.5" fill="url(#aiSparkGrad)" />
</svg>
