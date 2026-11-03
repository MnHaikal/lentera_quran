{{-- Row 3: Total Pengguna Aktif Area Line Chart --}}
<section
    id="pengguna-aktif"
    :class="darkPreview ? 'bg-[#0F2440] border-white/10' : 'bg-white border-[#EAE3D2]'"
    class="bg-white rounded-2xl border border-[#EAE3D2] p-5 sm:p-6 shadow-sm space-y-4"
>
    {{-- Chart Header --}}
    <div class="flex flex-col sm:flex-row sm:items-start justify-between gap-4">
        <div>
            <h2 :class="darkPreview ? 'text-white' : 'text-[#0F2D4F]'" class="text-base sm:text-lg font-extrabold text-[#0F2D4F] tracking-tight">
                Total Pengguna Aktif
            </h2>
            <div class="flex flex-wrap items-center gap-3 mt-1">
                <p :class="darkPreview ? 'text-white' : 'text-[#0F2D4F]'" class="text-2xl sm:text-[30px] font-extrabold text-[#0F2D4F] tracking-tight leading-none">
                    48.290
                </p>
                <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full bg-[#E1F1F1] text-[#1B6B73] text-xs font-bold">
                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.2" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 18L9 11.25l4.306 4.307a11.95 11.95 0 015.814-5.519l2.74-1.22m0 0l-5.94-2.28m5.94 2.28l-2.28 5.941" />
                    </svg>
                    <span>+12,4% bln ini</span>
                </span>
            </div>
        </div>

        {{-- Range Toggle: 7 Hari | 30 Hari | 12 Bulan --}}
        <div
            :class="darkPreview ? 'bg-[#0A192D] border-white/10' : 'bg-[#FAF7F0] border-[#EAE3D2]'"
            class="inline-flex items-center rounded-full bg-[#FAF7F0] p-1 border border-[#EAE3D2] self-start"
        >
            <button
                type="button"
                @click="activeRange = '7d'"
                :class="activeRange === '7d' ? 'bg-[#0F2D4F] text-white font-bold shadow-sm' : 'text-[#5B6B7A] font-semibold hover:text-[#0F2D4F]'"
                class="px-4 py-1.5 rounded-full text-xs text-[#5B6B7A] font-semibold transition"
            >
                7 Hari
            </button>
            <button
                type="button"
                @click="activeRange = '30d'"
                :class="activeRange === '30d' ? 'bg-[#0F2D4F] text-white font-bold shadow-sm' : 'text-[#5B6B7A] font-semibold hover:text-[#0F2D4F]'"
                class="px-4 py-1.5 rounded-full bg-[#0F2D4F] text-white font-bold shadow-sm text-xs transition"
            >
                30 Hari
            </button>
            <button
                type="button"
                @click="activeRange = '12m'"
                :class="activeRange === '12m' ? 'bg-[#0F2D4F] text-white font-bold shadow-sm' : 'text-[#5B6B7A] font-semibold hover:text-[#0F2D4F]'"
                class="px-4 py-1.5 rounded-full text-xs text-[#5B6B7A] font-semibold transition"
            >
                12 Bulan
            </button>
        </div>
    </div>

    {{-- SVG Smooth Area Line Chart --}}
    <div class="w-full overflow-x-auto">
        <div class="min-w-[680px]">
            <svg viewBox="0 0 880 260" class="w-full h-auto overflow-visible" role="img" aria-label="Grafik Total Pengguna Aktif Bulan Mei">
                <defs>
                    <linearGradient id="activeUsersAreaGrad" x1="0" y1="0" x2="0" y2="1">
                        <stop offset="0%" stop-color="#1D6D75" stop-opacity="0.24" />
                        <stop offset="75%" stop-color="#1D6D75" stop-opacity="0.06" />
                        <stop offset="100%" stop-color="#1D6D75" stop-opacity="0.0" />
                    </linearGradient>
                    <filter id="tooltipShadow" x="-15%" y="-20%" width="130%" height="150%">
                        <feDropShadow dx="0" dy="4" stdDeviation="6" flood-color="#0B2239" flood-opacity="0.22" />
                    </filter>
                </defs>

                {{-- Horizontal Grid Lines & Y-Axis Labels (50k down to 0) --}}
                <g class="text-[11px] fill-[#8C98A4] font-medium">
                    <text x="34" y="34" text-anchor="end">50k</text>
                    <line x1="52" y1="30" x2="840" y2="30" stroke="#EFECE2" stroke-width="1" stroke-dasharray="3 3" />

                    <text x="34" y="74" text-anchor="end">40k</text>
                    <line x1="52" y1="70" x2="840" y2="70" stroke="#EFECE2" stroke-width="1" stroke-dasharray="3 3" />

                    <text x="34" y="114" text-anchor="end">30k</text>
                    <line x1="52" y1="110" x2="840" y2="110" stroke="#EFECE2" stroke-width="1" stroke-dasharray="3 3" />

                    <text x="34" y="154" text-anchor="end">20k</text>
                    <line x1="52" y1="150" x2="840" y2="150" stroke="#EFECE2" stroke-width="1" stroke-dasharray="3 3" />

                    <text x="34" y="194" text-anchor="end">10k</text>
                    <line x1="52" y1="190" x2="840" y2="190" stroke="#EFECE2" stroke-width="1" stroke-dasharray="3 3" />

                    <text x="34" y="234" text-anchor="end">0</text>
                    <line x1="52" y1="230" x2="840" y2="230" stroke="#E5DEC9" stroke-width="1" />
                </g>

                {{-- Shaded Area Under Curve --}}
                <path
                    d="M 60 190
                       C 98 183, 110 179, 136 175
                       C 168 170, 184 168, 212 162
                       C 244 154, 260 144, 288 137
                       C 318 129, 338 125, 364 124
                       C 392 123, 412 126, 440 123
                       C 472 120, 490 103, 516 95
                       C 546 86, 566 83, 592 79
                       C 622 74, 644 61, 668 57
                       C 694 54, 718 62, 744 63
                       C 772 64, 796 61, 820 59
                       L 820 230 L 60 230 Z"
                    fill="url(#activeUsersAreaGrad)"
                />

                {{-- Vertical Dashed Drop-Line from Highlighted Peak Point --}}
                <line x1="668" y1="57" x2="668" y2="230" stroke="#7A9A9E" stroke-width="1.2" stroke-dasharray="4 4" />

                {{-- Main Smooth Teal Curve Line --}}
                <path
                    d="M 60 190
                       C 98 183, 110 179, 136 175
                       C 168 170, 184 168, 212 162
                       C 244 154, 260 144, 288 137
                       C 318 129, 338 125, 364 124
                       C 392 123, 412 126, 440 123
                       C 472 120, 490 103, 516 95
                       C 546 86, 566 83, 592 79
                       C 622 74, 644 61, 668 57
                       C 694 54, 718 62, 744 63
                       C 772 64, 796 61, 820 59"
                    fill="none"
                    stroke="#1D6D75"
                    stroke-width="2.6"
                    stroke-linecap="round"
                />

                {{-- Data Nodes (Hollow Teal Circles) --}}
                <g fill="#FFFFFF" stroke="#1D6D75" stroke-width="2">
                    <circle cx="60" cy="190" r="3.8" />
                    <circle cx="136" cy="175" r="3.8" />
                    <circle cx="212" cy="162" r="3.8" />
                    <circle cx="288" cy="137" r="3.8" />
                    <circle cx="364" cy="124" r="3.8" />
                    <circle cx="440" cy="123" r="3.8" />
                    <circle cx="516" cy="95" r="3.8" />
                    <circle cx="592" cy="79" r="3.8" />
                    <circle cx="744" cy="63" r="3.8" />
                    <circle cx="820" cy="59" r="3.8" />
                </g>

                {{-- Highlighted Gold Peak Node --}}
                <circle cx="668" cy="57" r="7.5" fill="#E2B14C" fill-opacity="0.25" />
                <circle cx="668" cy="57" r="4.2" fill="#E2B14C" stroke="#FFFFFF" stroke-width="2" />

                {{-- Floating Dark Navy Tooltip Pill --}}
                <g filter="url(#tooltipShadow)">
                    <rect x="536" y="6" width="248" height="32" rx="8" fill="#0B2239" />
                    <polygon points="662,38 674,38 668,45" fill="#0B2239" />
                    <circle cx="552" cy="22" r="3.5" fill="#E2B14C" />
                    <text x="563" y="26" fill="#FFFFFF" font-size="11" font-weight="700">
                        15 Mei 2025 — 43.120 pengguna aktif
                    </text>
                </g>

                {{-- X-Axis Date Labels --}}
                <g class="text-[11px] fill-[#8C98A4] font-medium" text-anchor="middle">
                    <text x="60" y="254">1 Mei</text>
                    <text x="136" y="254">4 Mei</text>
                    <text x="212" y="254">7 Mei</text>
                    <text x="288" y="254">10 Mei</text>
                    <text x="364" y="254">13 Mei</text>
                    <text x="440" y="254" fill="#1B6B73" font-weight="700">15 Mei</text>
                    <text x="516" y="254">19 Mei</text>
                    <text x="592" y="254">22 Mei</text>
                    <text x="668" y="254">25 Mei</text>
                    <text x="744" y="254">28 Mei</text>
                    <text x="820" y="254">31 Mei</text>
                </g>
            </svg>
        </div>
    </div>
</section>
