<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 240 240" width="100%" height="100%" class="h-16 w-auto">
    <defs>
        <!-- Seamless Brand Gradient matching the image -->
        <!-- gradientUnits="userSpaceOnUse" ensures the gradient flows smoothly across all separate shapes -->
        <linearGradient id="qerobiGrad" x1="20" y1="20" x2="220" y2="220" gradientUnits="userSpaceOnUse">
            <stop offset="0%" stop-color="#2B5DB0" />
            <stop offset="100%" stop-color="#5B2482" />
        </linearGradient>

        <!-- Professional Negative Space Mask -->
        <mask id="gapMask">
            <!-- Everything white remains visible -->
            <rect width="240" height="240" fill="white" />
            <!-- Hollow out the center of the 'Q' -->
            <circle cx="120" cy="135" r="50" fill="black" />
            <!-- Create the transparent gap separating the cap from the 'Q' ring -->
            <path d="M 75 72 L 75 90 Q 120 115 165 90 L 165 72 Q 120 95 75 72 Z" fill="black" stroke="black" stroke-width="12" stroke-linejoin="round" />
            <path d="M 120 20 L 210 55 L 120 90 L 30 55 Z" fill="black" stroke="black" stroke-width="12" stroke-linejoin="round" />
        </mask>
    </defs>

    <g fill="url(#qerobiGrad)">

        <!-- The Main 'Q' Ring & Tail (with Negative Space Mask Applied) -->
        <g mask="url(#gapMask)">
            <!-- Outer Ring -->
            <circle cx="120" cy="135" r="75" />
            <!-- Speech Bubble Tail -->
            <polygon points="160,170 215,220 185,155" />
        </g>

        <!-- Graduation Cap (Diamond Top) -->
        <path d="M 120 20 L 210 55 L 120 90 L 30 55 Z" />

        <!-- Graduation Cap (Base/Headpiece) -->
        <path d="M 75 72 L 75 90 Q 120 115 165 90 L 165 72 Q 120 95 75 72 Z" />

        <!-- Tassel Details -->
        <line x1="165" y1="72" x2="165" y2="95" stroke="url(#qerobiGrad)" stroke-width="2.5" />
        <circle cx="165" cy="95" r="3" />
        <polygon points="163,98 167,98 169,115 161,115" />

        <!-- Central Network Node (Inner Graphic) -->
        <!-- Connecting Lines -->
        <line x1="95" y1="135" x2="135" y2="115" stroke="url(#qerobiGrad)" stroke-width="3" />
        <line x1="95" y1="135" x2="135" y2="155" stroke="url(#qerobiGrad)" stroke-width="3" />
        <line x1="135" y1="115" x2="135" y2="155" stroke="url(#qerobiGrad)" stroke-width="3" />
        <!-- Node Circles -->
        <circle cx="95" cy="135" r="9" />
        <circle cx="135" cy="115" r="9" />
        <circle cx="135" cy="155" r="9" />

    </g>
</svg>
