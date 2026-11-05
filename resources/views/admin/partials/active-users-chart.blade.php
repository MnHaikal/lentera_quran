{{-- Row 3: Total Pengguna Aktif Area Line Chart --}}
<section
    id="pengguna-aktif"
    x-data="{
        activeRange: '7d',
        activePoint: @js($chartData['datasets']['7d']['activePoint'] ?? ['x' => 820, 'y' => 70, 'info' => '']),
        defaults: {
            '7d': @js($chartData['datasets']['7d']['activePoint'] ?? ['x' => 820, 'y' => 70, 'info' => '']),
            '30d': @js($chartData['datasets']['30d']['activePoint'] ?? ['x' => 820, 'y' => 70, 'info' => '']),
            '12m': @js($chartData['datasets']['12m']['activePoint'] ?? ['x' => 820, 'y' => 70, 'info' => '']),
        },
        setRange(r) {
            this.activeRange = r;
            if (this.defaults[r]) {
                this.activePoint = this.defaults[r];
            }
        },
        tooltipX(x) {
            return Math.max(10, Math.min(880 - 248 - 10, x - 124));
        },
        tooltipY(y) {
            return Math.max(6, y - 48);
        }
    }"
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
                    {{ number_format($userCount ?? 0, 0, ',', '.') }}
                </p>
                <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full bg-[#E1F1F1] text-[#1B6B73] text-xs font-bold">
                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.2" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 18L9 11.25l4.306 4.307a11.95 11.95 0 015.814-5.519l2.74-1.22m0 0l-5.94-2.28m5.94 2.28l-2.28 5.941" />
                    </svg>
                    <span>+{{ $usersThisMonth ?? 0 }} bln ini</span>
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
                @click="setRange('7d')"
                :class="activeRange === '7d' ? 'bg-[#0F2D4F] text-white font-bold shadow-sm' : 'text-[#5B6B7A] font-semibold hover:text-[#0F2D4F]'"
                class="px-4 py-1.5 rounded-full text-xs font-semibold transition"
            >
                7 Hari
            </button>
            <button
                type="button"
                @click="setRange('30d')"
                :class="activeRange === '30d' ? 'bg-[#0F2D4F] text-white font-bold shadow-sm' : 'text-[#5B6B7A] font-semibold hover:text-[#0F2D4F]'"
                class="px-4 py-1.5 rounded-full text-xs font-semibold transition"
            >
                30 Hari
            </button>
            <button
                type="button"
                @click="setRange('12m')"
                :class="activeRange === '12m' ? 'bg-[#0F2D4F] text-white font-bold shadow-sm' : 'text-[#5B6B7A] font-semibold hover:text-[#0F2D4F]'"
                class="px-4 py-1.5 rounded-full text-xs font-semibold transition"
            >
                12 Bulan
            </button>
        </div>
    </div>

    {{-- SVG Smooth Area Line Chart --}}
    <div class="w-full overflow-x-auto">
        <div class="min-w-[680px]">
            <svg viewBox="0 0 880 260" class="w-full h-auto overflow-visible select-none" role="img" aria-label="Grafik Total Pengguna Aktif">
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

                {{-- Horizontal Grid Lines & Y-Axis Labels --}}
                <g class="text-[11px] fill-[#8C98A4] font-medium pointer-events-none">
                    <text x="34" y="34" text-anchor="end">{{ $chartData['yLabels'][0] ?? '5' }}</text>
                    <line x1="52" y1="30" x2="840" y2="30" stroke="#EFECE2" stroke-width="1" stroke-dasharray="3 3" />

                    <text x="34" y="74" text-anchor="end">{{ $chartData['yLabels'][1] ?? '4' }}</text>
                    <line x1="52" y1="70" x2="840" y2="70" stroke="#EFECE2" stroke-width="1" stroke-dasharray="3 3" />

                    <text x="34" y="114" text-anchor="end">{{ $chartData['yLabels'][2] ?? '3' }}</text>
                    <line x1="52" y1="110" x2="840" y2="110" stroke="#EFECE2" stroke-width="1" stroke-dasharray="3 3" />

                    <text x="34" y="154" text-anchor="end">{{ $chartData['yLabels'][3] ?? '2' }}</text>
                    <line x1="52" y1="150" x2="840" y2="150" stroke="#EFECE2" stroke-width="1" stroke-dasharray="3 3" />

                    <text x="34" y="194" text-anchor="end">{{ $chartData['yLabels'][4] ?? '1' }}</text>
                    <line x1="52" y1="190" x2="840" y2="190" stroke="#EFECE2" stroke-width="1" stroke-dasharray="3 3" />

                    <text x="34" y="234" text-anchor="end">{{ $chartData['yLabels'][5] ?? '0' }}</text>
                    <line x1="52" y1="230" x2="840" y2="230" stroke="#E5DEC9" stroke-width="1" />
                </g>

                {{-- Dynamic Datasets (7d, 30d, 12m) --}}
                @foreach(['7d', '30d', '12m'] as $rangeKey)
                    @php
                        $dataset = $chartData['datasets'][$rangeKey] ?? null;
                    @endphp
                    @if($dataset)
                        <g x-show="activeRange === '{{ $rangeKey }}'" style="{{ $rangeKey === '7d' ? '' : 'display: none;' }}">
                            {{-- Shaded Area Under Curve --}}
                            <path
                                d="{{ $dataset['paths']['area'] }}"
                                fill="url(#activeUsersAreaGrad)"
                                class="pointer-events-none"
                            />

                            {{-- Main Smooth Teal Curve Line --}}
                            <path
                                d="{{ $dataset['paths']['line'] }}"
                                fill="none"
                                stroke="#1D6D75"
                                stroke-width="2.6"
                                stroke-linecap="round"
                                class="pointer-events-none"
                            />

                            {{-- Data Nodes (Hollow Teal Circles) --}}
                            <g fill="#FFFFFF" stroke="#1D6D75" stroke-width="2" class="pointer-events-none">
                                @foreach($dataset['points'] as $pt)
                                    <circle cx="{{ $pt['x'] }}" cy="{{ $pt['y'] }}" r="3.8" />
                                @endforeach
                            </g>

                            {{-- X-Axis Date Labels with Active Highlight --}}
                            <g class="text-[11px] font-medium" text-anchor="middle">
                                @foreach($dataset['points'] as $pt)
                                    <text
                                        x="{{ $pt['x'] }}"
                                        y="254"
                                        :fill="Math.abs(activePoint.x - {{ $pt['x'] }}) < 2 ? '#1B6B73' : '#8C98A4'"
                                        :font-weight="Math.abs(activePoint.x - {{ $pt['x'] }}) < 2 ? '700' : '500'"
                                        class="transition-colors duration-150 cursor-pointer"
                                        @mouseenter="activePoint = { x: {{ $pt['x'] }}, y: {{ $pt['y'] }}, info: '{{ addslashes($pt['info']) }}' }"
                                    >{{ $pt['label'] }}</text>
                                @endforeach
                            </g>

                            {{-- Invisible Interactive Hitboxes over each point --}}
                            <g>
                                @foreach($dataset['points'] as $pt)
                                    <circle
                                        cx="{{ $pt['x'] }}"
                                        cy="{{ $pt['y'] }}"
                                        r="24"
                                        fill="transparent"
                                        class="cursor-pointer"
                                        @mouseenter="activePoint = { x: {{ $pt['x'] }}, y: {{ $pt['y'] }}, info: '{{ addslashes($pt['info']) }}' }"
                                        @mousemove="activePoint = { x: {{ $pt['x'] }}, y: {{ $pt['y'] }}, info: '{{ addslashes($pt['info']) }}' }"
                                    />
                                @endforeach
                            </g>
                        </g>
                    @endif
                @endforeach

                {{-- Vertical Dashed Drop-Line from Highlighted Point --}}
                <line
                    :x1="activePoint.x"
                    :y1="activePoint.y"
                    :x2="activePoint.x"
                    y2="230"
                    stroke="#7A9A9E"
                    stroke-width="1.2"
                    stroke-dasharray="4 4"
                    class="pointer-events-none transition-all duration-150 ease-out"
                />

                {{-- Highlighted Gold Active Node --}}
                <circle
                    :cx="activePoint.x"
                    :cy="activePoint.y"
                    r="7.5"
                    fill="#E2B14C"
                    fill-opacity="0.25"
                    class="pointer-events-none transition-all duration-150 ease-out"
                />
                <circle
                    :cx="activePoint.x"
                    :cy="activePoint.y"
                    r="4.2"
                    fill="#E2B14C"
                    stroke="#FFFFFF"
                    stroke-width="2"
                    class="pointer-events-none transition-all duration-150 ease-out"
                />

                {{-- Floating Dark Navy Tooltip Pill (Dynamically following hovered point) --}}
                <g filter="url(#tooltipShadow)" class="pointer-events-none transition-all duration-150 ease-out">
                    <rect
                        :x="tooltipX(activePoint.x)"
                        :y="tooltipY(activePoint.y)"
                        width="248"
                        height="32"
                        rx="8"
                        fill="#0B2239"
                    />
                    <polygon
                        :points="`${activePoint.x - 6},${tooltipY(activePoint.y) + 32} ${activePoint.x + 6},${tooltipY(activePoint.y) + 32} ${activePoint.x},${tooltipY(activePoint.y) + 39}`"
                        fill="#0B2239"
                    />
                    <circle
                        :cx="tooltipX(activePoint.x) + 16"
                        :cy="tooltipY(activePoint.y) + 16"
                        r="3.5"
                        fill="#E2B14C"
                    />
                    <text
                        :x="tooltipX(activePoint.x) + 27"
                        :y="tooltipY(activePoint.y) + 20"
                        fill="#FFFFFF"
                        font-size="11"
                        font-weight="700"
                        x-text="activePoint.info"
                    >
                        {{ $chartData['datasets']['7d']['activePoint']['info'] ?? '' }}
                    </text>
                </g>
            </svg>
        </div>
    </div>
</section>
