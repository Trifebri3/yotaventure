<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
            <div>
                <div class="flex items-center gap-2 mb-1">
                    <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-md bg-teal-50 border border-teal-200 text-[#005952] text-[11px] font-bold uppercase tracking-wider">
                        <span class="w-1.5 h-1.5 rounded-full bg-[#005952] animate-ping"></span>
                        <span>Live Analytics & SEO Hub</span>
                    </span>
                    <span class="text-xs text-gray-500">• PT Yota Inovasi Nusantara (YOIN)</span>
                </div>
                <h2 class="text-xl sm:text-2xl font-black text-gray-900 tracking-tight leading-tight">
                    Pusat Analitik Trafik, Audit SEO & Sebaran Akses
                </h2>
            </div>

            {{-- Period Filter & Excel Export --}}
            <div class="flex flex-wrap items-center gap-2.5">
                {{-- Period Selector Tabs --}}
                <div class="inline-flex items-center bg-gray-100 p-1 rounded-xl border border-gray-200 text-xs font-semibold">
                    <a 
                        href="{{ route('admin.dashboard', ['period' => 'today']) }}" 
                        class="px-3 py-1.5 rounded-lg transition-all {{ $period === 'today' ? 'bg-white text-[#005952] shadow-xs font-bold' : 'text-gray-600 hover:text-gray-900' }}"
                    >
                        Hari Ini
                    </a>
                    <a 
                        href="{{ route('admin.dashboard', ['period' => '7d']) }}" 
                        class="px-3 py-1.5 rounded-lg transition-all {{ $period === '7d' ? 'bg-white text-[#005952] shadow-xs font-bold' : 'text-gray-600 hover:text-gray-900' }}"
                    >
                        7 Hari
                    </a>
                    <a 
                        href="{{ route('admin.dashboard', ['period' => '30d']) }}" 
                        class="px-3 py-1.5 rounded-lg transition-all {{ $period === '30d' ? 'bg-white text-[#005952] shadow-xs font-bold' : 'text-gray-600 hover:text-gray-900' }}"
                    >
                        30 Hari
                    </a>
                    <a 
                        href="{{ route('admin.dashboard', ['period' => 'all']) }}" 
                        class="px-3 py-1.5 rounded-lg transition-all {{ $period === 'all' ? 'bg-white text-[#005952] shadow-xs font-bold' : 'text-gray-600 hover:text-gray-900' }}"
                    >
                        Semua
                    </a>
                </div>

                {{-- Native Excel / CSV Export Button --}}
                <a 
                    href="{{ route('admin.dashboard.export-excel', ['period' => $period]) }}" 
                    class="inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-[#005952] hover:bg-[#004741] text-white text-xs font-bold transition-all shadow-xs hover:shadow-md cursor-pointer"
                    title="Unduh Data Log Pengunjung ke File Excel (.csv)"
                >
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                    <span>Unduh Excel (XLSX/CSV)</span>
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-8 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">

        {{-- ======================================================== --}}
        {{-- 1. HEADLINE METRICS ROW                                  --}}
        {{-- ======================================================== --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
            
            {{-- Metric 1: Total Visits --}}
            <div class="bg-white rounded-2xl border border-gray-200/90 p-5 shadow-xs hover:shadow-md transition-all">
                <div class="flex items-center justify-between text-gray-500 mb-3">
                    <span class="text-xs font-bold uppercase tracking-wider text-gray-500">Total Kunjungan</span>
                    <div class="w-9 h-9 rounded-xl bg-teal-50 text-[#005952] flex items-center justify-center">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                        </svg>
                    </div>
                </div>
                <div class="flex items-baseline justify-between">
                    <h3 class="text-2xl sm:text-3xl font-black text-gray-950 tracking-tight">
                        {{ number_format($totalVisits) }}
                    </h3>
                    <span class="inline-flex items-center gap-0.5 text-xs font-bold text-emerald-600 bg-emerald-50 px-2 py-0.5 rounded-md">
                        <span>↑ {{ $growthRate }}%</span>
                    </span>
                </div>
                <p class="text-xs text-gray-500 mt-2">
                    Periode terpilih (Manusia riil)
                </p>
            </div>

            {{-- Metric 2: Unique IPs --}}
            <div class="bg-white rounded-2xl border border-gray-200/90 p-5 shadow-xs hover:shadow-md transition-all">
                <div class="flex items-center justify-between text-gray-500 mb-3">
                    <span class="text-xs font-bold uppercase tracking-wider text-gray-500">Pengunjung Unik IP</span>
                    <div class="w-9 h-9 rounded-xl bg-blue-50 text-blue-700 flex items-center justify-center">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                        </svg>
                    </div>
                </div>
                <div class="flex items-baseline justify-between">
                    <h3 class="text-2xl sm:text-3xl font-black text-gray-950 tracking-tight">
                        {{ number_format($uniqueIps) }}
                    </h3>
                    <span class="text-xs font-semibold text-blue-700 bg-blue-50 px-2 py-0.5 rounded-md">
                        Unik
                    </span>
                </div>
                <p class="text-xs text-gray-500 mt-2">
                    Berdasarkan IP unik pengunjung
                </p>
            </div>

            {{-- Metric 3: Kunjungan Hari Ini --}}
            <div class="bg-white rounded-2xl border border-gray-200/90 p-5 shadow-xs hover:shadow-md transition-all">
                <div class="flex items-center justify-between text-gray-500 mb-3">
                    <span class="text-xs font-bold uppercase tracking-wider text-gray-500">Aktivitas Hari Ini</span>
                    <div class="w-9 h-9 rounded-xl bg-amber-50 text-amber-700 flex items-center justify-center">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                </div>
                <div class="flex items-baseline justify-between">
                    <h3 class="text-2xl sm:text-3xl font-black text-gray-950 tracking-tight">
                        {{ number_format($todayVisits) }}
                    </h3>
                    <span class="text-xs font-semibold text-amber-700 bg-amber-50 px-2 py-0.5 rounded-md">
                        {{ number_format($todayUniques) }} IP
                    </span>
                </div>
                <p class="text-xs text-gray-500 mt-2">
                    Live sejak 00:00 WIB hari ini
                </p>
            </div>

            {{-- Metric 4: SEO Health Score --}}
            <div class="bg-white rounded-2xl border border-gray-200/90 p-5 shadow-xs hover:shadow-md transition-all">
                <div class="flex items-center justify-between text-gray-500 mb-3">
                    <span class="text-xs font-bold uppercase tracking-wider text-gray-500">Skor Kesehatan SEO</span>
                    <div class="w-9 h-9 rounded-xl bg-emerald-50 text-emerald-700 flex items-center justify-center">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                </div>
                <div class="flex items-baseline justify-between">
                    <h3 class="text-2xl sm:text-3xl font-black text-[#005952] tracking-tight">
                        {{ $seoAudit['overall_score'] }}/100
                    </h3>
                    <span class="text-xs font-black text-white bg-[#005952] px-2.5 py-0.5 rounded-md">
                        Grade {{ $seoAudit['rating_grade'] }}
                    </span>
                </div>
                <p class="text-xs text-gray-500 mt-2">
                    {{ $seoAudit['pages_audited'] }} rute publik dioptimalkan 100%
                </p>
            </div>

        </div>

        {{-- ======================================================== --}}
        {{-- 2. CHARTS & DEVICE BREAKDOWN ROW                         --}}
        {{-- ======================================================== --}}
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 items-stretch">
            
            {{-- Left Column: 14-Day Traffic Trend SVG Chart --}}
            <div class="lg:col-span-2 bg-white rounded-2xl border border-gray-200/90 p-6 shadow-xs flex flex-col justify-between">
                <div>
                    <div class="flex items-center justify-between mb-6">
                        <div>
                            <span class="text-xs font-bold uppercase tracking-wider text-[#005952] block">Tren Trafik Berkala</span>
                            <h4 class="text-lg font-extrabold text-gray-950">Grafik Kunjungan Harian (14 Hari Terakhir)</h4>
                        </div>
                        <div class="flex items-center gap-4 text-xs font-medium text-gray-500">
                            <div class="flex items-center gap-1.5">
                                <span class="w-3 h-3 rounded-full bg-[#005952]"></span>
                                <span>Total Kunjungan</span>
                            </div>
                            <div class="flex items-center gap-1.5">
                                <span class="w-3 h-3 rounded-full bg-teal-300"></span>
                                <span>Pengunjung Unik IP</span>
                            </div>
                        </div>
                    </div>

                    {{-- Native SVG Trend Chart --}}
                    <div class="relative w-full h-64 sm:h-72">
                        <svg class="w-full h-full overflow-visible" viewBox="0 0 700 240" preserveAspectRatio="none">
                            <defs>
                                <linearGradient id="chartGradient" x1="0" y1="0" x2="0" y2="1">
                                    <stop offset="0%" stop-color="#005952" stop-opacity="0.25"/>
                                    <stop offset="100%" stop-color="#005952" stop-opacity="0.0"/>
                                </linearGradient>
                            </defs>

                            {{-- Horizontal Grid Lines --}}
                            @for($g = 0; $g <= 4; $g++)
                                @php $yVal = 20 + ($g * 48); @endphp
                                <line x1="0" y1="{{ $yVal }}" x2="700" y2="{{ $yVal }}" stroke="#E5E7EB" stroke-dasharray="4 4" stroke-width="1" />
                            @endfor

                            {{-- Compute Coordinates --}}
                            @php
                                $stepX = 700 / max(count($trendVisits) - 1, 1);
                                $pointsTotal = [];
                                $pointsUnique = [];
                                foreach($trendVisits as $idx => $v) {
                                    $x = $idx * $stepX;
                                    $y = 212 - (($v / $chartMax) * 190);
                                    $pointsTotal[] = "{$x},{$y}";
                                }
                                foreach($trendUniques as $idx => $u) {
                                    $x = $idx * $stepX;
                                    $y = 212 - (($u / $chartMax) * 190);
                                    $pointsUnique[] = "{$x},{$y}";
                                }
                                $lineTotalStr = implode(' ', $pointsTotal);
                                $lineUniqueStr = implode(' ', $pointsUnique);
                                $areaStr = "0,212 " . $lineTotalStr . " 700,212";
                            @endphp

                            {{-- Shaded Area --}}
                            <polygon points="{{ $areaStr }}" fill="url(#chartGradient)" />

                            {{-- Unique IP Line (Teal-300) --}}
                            <polyline points="{{ $lineUniqueStr }}" fill="none" stroke="#5EEAD4" stroke-width="2.5" stroke-dasharray="4 4" />

                            {{-- Total Visits Line (Brand Teal #005952) --}}
                            <polyline points="{{ $lineTotalStr }}" fill="none" stroke="#005952" stroke-width="3.5" stroke-linecap="round" stroke-linejoin="round" />

                            {{-- Data Point Dots --}}
                            @foreach($trendVisits as $idx => $v)
                                @php
                                    $x = $idx * $stepX;
                                    $y = 212 - (($v / $chartMax) * 190);
                                @endphp
                                <circle cx="{{ $x }}" cy="{{ $y }}" r="4" fill="#005952" stroke="#FFFFFF" stroke-width="2" />
                            @endforeach
                        </svg>
                    </div>

                    {{-- X-Axis Date Labels --}}
                    <div class="flex justify-between items-center text-[10px] font-semibold text-gray-500 mt-2 px-1">
                        @foreach($trendDates as $idx => $label)
                            @if($idx % 2 === 0 || $idx === count($trendDates) - 1)
                                <span>{{ $label }}</span>
                            @endif
                        @endforeach
                    </div>
                </div>

                <div class="mt-4 pt-4 border-t border-gray-100 flex flex-wrap items-center justify-between text-xs text-gray-500">
                    <span>Tertinggi dalam rentang ini: <strong class="text-gray-900">{{ max($trendVisits) }} kunjungan/hari</strong></span>
                    <span>Diperbarui otomatis saat setiap akses publik diterima</span>
                </div>
            </div>

            {{-- Right Column: Perangkat & Browser Breakdown --}}
            <div class="bg-white rounded-2xl border border-gray-200/90 p-6 shadow-xs flex flex-col justify-between">
                <div>
                    <span class="text-xs font-bold uppercase tracking-wider text-[#005952] block mb-1">Distribusi Platform</span>
                    <h4 class="text-lg font-extrabold text-gray-950 mb-4">Perangkat & Browser</h4>

                    {{-- Device Types Progress Bars --}}
                    <div class="space-y-4 mb-6">
                        @php
                            $totalDevices = array_sum($deviceStats) ?: 1;
                            $desktopPct = round((($deviceStats['Desktop'] ?? 0) / $totalDevices) * 100);
                            $mobilePct = round((($deviceStats['Mobile'] ?? 0) / $totalDevices) * 100);
                            $tabletPct = round((($deviceStats['Tablet'] ?? 0) / $totalDevices) * 100);
                        @endphp

                        <div>
                            <div class="flex justify-between text-xs font-semibold mb-1">
                                <span class="text-gray-700 flex items-center gap-1.5">
                                    <svg class="w-3.5 h-3.5 text-[#005952]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                                    Desktop
                                </span>
                                <span class="text-gray-900 font-bold">{{ $desktopPct }}% ({{ $deviceStats['Desktop'] ?? 0 }})</span>
                            </div>
                            <div class="w-full h-2 bg-gray-100 rounded-full overflow-hidden">
                                <div class="h-full bg-[#005952] rounded-full" style="width: {{ $desktopPct }}%"></div>
                            </div>
                        </div>

                        <div>
                            <div class="flex justify-between text-xs font-semibold mb-1">
                                <span class="text-gray-700 flex items-center gap-1.5">
                                    <svg class="w-3.5 h-3.5 text-teal-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"/></svg>
                                    Mobile Smartphone
                                </span>
                                <span class="text-gray-900 font-bold">{{ $mobilePct }}% ({{ $deviceStats['Mobile'] ?? 0 }})</span>
                            </div>
                            <div class="w-full h-2 bg-gray-100 rounded-full overflow-hidden">
                                <div class="h-full bg-teal-500 rounded-full" style="width: {{ $mobilePct }}%"></div>
                            </div>
                        </div>

                        <div>
                            <div class="flex justify-between text-xs font-semibold mb-1">
                                <span class="text-gray-700 flex items-center gap-1.5">
                                    <svg class="w-3.5 h-3.5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"/></svg>
                                    Tablet / iPad
                                </span>
                                <span class="text-gray-900 font-bold">{{ $tabletPct }}% ({{ $deviceStats['Tablet'] ?? 0 }})</span>
                            </div>
                            <div class="w-full h-2 bg-gray-100 rounded-full overflow-hidden">
                                <div class="h-full bg-blue-500 rounded-full" style="width: {{ $tabletPct }}%"></div>
                            </div>
                        </div>
                    </div>

                    {{-- Top Browsers List --}}
                    <h5 class="text-xs font-bold uppercase tracking-wider text-gray-400 mb-2.5">Top Web Browsers</h5>
                    <div class="space-y-2">
                        @foreach($browserStats as $browserName => $count)
                            <div class="flex items-center justify-between text-xs p-2 rounded-lg bg-gray-50 border border-gray-100">
                                <span class="font-medium text-gray-800">{{ $browserName }}</span>
                                <span class="font-bold text-[#005952]">{{ number_format($count) }} hits</span>
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="mt-4 pt-3 border-t border-gray-100 text-[11px] text-gray-500 flex items-center justify-between">
                    <span>Bot Mesin Pencari Tercatat:</span>
                    <span class="font-bold text-gray-800">{{ number_format($botCrawls) }} crawl</span>
                </div>
            </div>

        </div>

        {{-- ======================================================== --}}
        {{-- 3. SEBARAN LOKASI IP & HALAMAN TERPOPULER                --}}
        {{-- ======================================================== --}}
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            
            {{-- Location Breakdown (Kota & Negara Pengunjung) --}}
            <div class="bg-white rounded-2xl border border-gray-200/90 p-6 shadow-xs">
                <div class="flex items-center justify-between mb-5">
                    <div>
                        <span class="text-xs font-bold uppercase tracking-wider text-[#005952] block">Sebaran Geografis</span>
                        <h4 class="text-lg font-extrabold text-gray-950">Lokasi & Kota Akses Pengunjung</h4>
                    </div>
                    <span class="px-2.5 py-1 rounded-md bg-teal-50 text-[#005952] text-xs font-bold">
                        Top 8 Wilayah
                    </span>
                </div>

                <div class="overflow-x-auto no-scrollbar">
                    <table class="w-full text-left text-xs">
                        <thead>
                            <tr class="border-b border-gray-200 text-gray-400 font-bold uppercase tracking-wider text-[10px]">
                                <th class="pb-2.5">Kota / Wilayah</th>
                                <th class="pb-2.5">Negara</th>
                                <th class="pb-2.5 text-right">Kunjungan</th>
                                <th class="pb-2.5 text-right">Proporsi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse($topLocations as $loc)
                                <tr class="hover:bg-gray-50/80 transition-colors">
                                    <td class="py-2.5 font-bold text-gray-900 flex items-center gap-2">
                                        <span class="w-2 h-2 rounded-full bg-[#005952]"></span>
                                        <span>{{ $loc->city ?: 'Kota Lain' }}</span>
                                    </td>
                                    <td class="py-2.5 text-gray-600 font-medium">
                                        {{ $loc->country ?: 'Indonesia' }} ({{ $loc->country_code ?: 'ID' }})
                                    </td>
                                    <td class="py-2.5 text-right font-black text-gray-950">
                                        {{ number_format($loc->total) }}
                                    </td>
                                    <td class="py-2.5 text-right">
                                        <div class="inline-flex items-center gap-2">
                                            <div class="w-16 h-1.5 bg-gray-100 rounded-full overflow-hidden hidden sm:block">
                                                <div class="h-full bg-[#005952] rounded-full" style="width: {{ $loc->percentage }}%"></div>
                                            </div>
                                            <span class="font-semibold text-gray-600 w-10 text-right">{{ $loc->percentage }}%</span>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="py-4 text-center text-gray-500">Belum ada data lokasi tercatat.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- Top Visited Pages & Articles --}}
            <div class="bg-white rounded-2xl border border-gray-200/90 p-6 shadow-xs">
                <div class="flex items-center justify-between mb-5">
                    <div>
                        <span class="text-xs font-bold uppercase tracking-wider text-[#005952] block">Trafik Halaman</span>
                        <h4 class="text-lg font-extrabold text-gray-950">Halaman Paling Sering Dikunjungi</h4>
                    </div>
                    <span class="px-2.5 py-1 rounded-md bg-teal-50 text-[#005952] text-xs font-bold">
                        Top URLs
                    </span>
                </div>

                <div class="overflow-x-auto no-scrollbar">
                    <table class="w-full text-left text-xs">
                        <thead>
                            <tr class="border-b border-gray-200 text-gray-400 font-bold uppercase tracking-wider text-[10px]">
                                <th class="pb-2.5">Path Halaman</th>
                                <th class="pb-2.5 text-right">Tampilan</th>
                                <th class="pb-2.5 text-right">Pengunjung Unik</th>
                                <th class="pb-2.5 text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse($topPages as $page)
                                <tr class="hover:bg-gray-50/80 transition-colors">
                                    <td class="py-2.5 font-bold text-gray-900 font-mono text-[11px] truncate max-w-[200px]">
                                        {{ $page->path }}
                                    </td>
                                    <td class="py-2.5 text-right font-black text-[#005952]">
                                        {{ number_format($page->views) }}
                                    </td>
                                    <td class="py-2.5 text-right font-semibold text-gray-600">
                                        {{ number_format($page->unique_visitors) }}
                                    </td>
                                    <td class="py-2.5 text-right">
                                        <a href="{{ url($page->path) }}" target="_blank" class="p-1 rounded hover:bg-gray-100 text-gray-400 hover:text-[#005952] inline-block transition-colors" title="Buka Halaman Publik">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="py-4 text-center text-gray-500">Belum ada kunjungan halaman tercatat.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>

        {{-- ======================================================== --}}
        {{-- 4. SEO AUDIT & HEALTH SCORECARD                          --}}
        {{-- ======================================================== --}}
        <div class="bg-white rounded-2xl border border-gray-200/90 p-6 shadow-xs">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6 pb-4 border-b border-gray-100">
                <div>
                    <div class="flex items-center gap-2">
                        <span class="text-xs font-bold uppercase tracking-wider text-[#005952]">Audit SEO Komprehensif</span>
                        <span class="px-2 py-0.5 rounded-full bg-emerald-50 text-emerald-700 text-[10px] font-bold">100% Siap Mesin Pencari</span>
                    </div>
                    <h4 class="text-xl font-extrabold text-gray-950 mt-1">Status Optimasi Mesin Pencari (Search Engine Optimization)</h4>
                </div>

                {{-- SEO Badges --}}
                <div class="flex flex-wrap items-center gap-2 text-xs">
                    <span class="px-3 py-1.5 rounded-xl bg-gray-50 border border-gray-200 text-gray-700 flex items-center gap-1.5">
                        <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                        <span>Sitemap.xml: {{ $seoAudit['sitemap_status'] }}</span>
                    </span>
                    <span class="px-3 py-1.5 rounded-xl bg-gray-50 border border-gray-200 text-gray-700 flex items-center gap-1.5">
                        <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                        <span>Robots.txt: {{ $seoAudit['robots_status'] }}</span>
                    </span>
                    <span class="px-3 py-1.5 rounded-xl bg-gray-50 border border-gray-200 text-gray-700 flex items-center gap-1.5">
                        <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                        <span>Schema.org: Aktif</span>
                    </span>
                </div>
            </div>

            {{-- Pages Audit Table --}}
            <div class="overflow-x-auto no-scrollbar mb-8">
                <table class="w-full text-left text-xs">
                    <thead>
                        <tr class="border-b border-gray-200 text-gray-400 font-bold uppercase tracking-wider text-[10px]">
                            <th class="pb-2.5">Halaman Publik</th>
                            <th class="pb-2.5">Meta Title</th>
                            <th class="pb-2.5">Meta Description</th>
                            <th class="pb-2.5 text-center">OpenGraph</th>
                            <th class="pb-2.5">Tipe Schema</th>
                            <th class="pb-2.5 text-right">Status Audit</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach($seoAudit['pages'] as $p)
                            <tr class="hover:bg-gray-50/80 transition-colors">
                                <td class="py-3 font-bold text-gray-900">
                                    {{ $p['page'] }}
                                </td>
                                <td class="py-3 text-gray-600 max-w-xs truncate" title="{{ $p['title'] }}">
                                    <span>{{ $p['title'] }}</span>
                                    <span class="block text-[10px] text-gray-400">{{ $p['title_length'] }} karakter</span>
                                </td>
                                <td class="py-3 text-gray-600 max-w-sm truncate" title="{{ $p['meta_desc'] }}">
                                    <span>{{ $p['meta_desc'] }}</span>
                                    <span class="block text-[10px] text-gray-400">{{ $p['desc_length'] }} karakter</span>
                                </td>
                                <td class="py-3 text-center">
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-md bg-emerald-50 text-emerald-700 font-bold text-[10px]">
                                        OG: Aktif
                                    </span>
                                </td>
                                <td class="py-3 text-gray-600 font-mono text-[11px]">
                                    {{ $p['schema_type'] }}
                                </td>
                                <td class="py-3 text-right">
                                    <span class="inline-flex items-center gap-1 font-bold text-[#005952]">
                                        <svg class="w-3.5 h-3.5 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                                        <span>{{ $p['status'] }}</span>
                                    </span>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            {{-- Target SEO Keywords --}}
            <div>
                <span class="text-xs font-bold uppercase tracking-wider text-gray-400 block mb-3">Kata Kunci Utama & Peringkat Mesin Pencari (Search Ranking Targets)</span>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-3">
                    @foreach($seoAudit['top_keywords'] as $kw)
                        <div class="p-3 rounded-xl bg-gray-50 border border-gray-200/80 flex items-center justify-between">
                            <div>
                                <span class="font-bold text-gray-900 text-xs block leading-tight">{{ $kw['keyword'] }}</span>
                                <span class="text-[10px] text-gray-500">Volume: {{ $kw['volume'] }}</span>
                            </div>
                            <span class="px-2 py-0.5 rounded-md bg-[#005952] text-white text-xs font-black">
                                {{ $kw['ranking'] }}
                            </span>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        {{-- ======================================================== --}}
        {{-- 5. REAL-TIME DETAILED VISITOR LOGS TABLE                 --}}
        {{-- ======================================================== --}}
        <div class="bg-white rounded-2xl border border-gray-200/90 shadow-xs overflow-hidden">
            <div class="p-6 border-b border-gray-100 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                <div>
                    <div class="flex items-center gap-2">
                        <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                        <span class="text-xs font-bold uppercase tracking-wider text-[#005952]">Log Kunjungan Nyata</span>
                    </div>
                    <h4 class="text-lg font-extrabold text-gray-950 mt-0.5">Catatan Akses IP Pengunjung & Riwayat URL</h4>
                </div>
                <div class="flex items-center gap-3">
                    <span class="text-xs text-gray-500">Menampilkan 15 entri per halaman</span>
                    <a 
                        href="{{ route('admin.dashboard.export-excel', ['period' => $period]) }}" 
                        class="px-3 py-1.5 rounded-lg bg-gray-100 hover:bg-gray-200 text-gray-700 text-xs font-bold transition-colors inline-flex items-center gap-1.5"
                    >
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                        <span>Unduh Semua Log</span>
                    </a>
                </div>
            </div>

            <div class="overflow-x-auto no-scrollbar">
                <table class="w-full text-left text-xs">
                    <thead>
                        <tr class="bg-gray-50/75 border-b border-gray-200 text-gray-500 font-bold uppercase tracking-wider text-[10px]">
                            <th class="py-3 px-6">Waktu & Tanggal</th>
                            <th class="py-3 px-4">Alamat IP</th>
                            <th class="py-3 px-4">Lokasi (Kota, Negara)</th>
                            <th class="py-3 px-4">Halaman Dikunjungi</th>
                            <th class="py-3 px-4">Sumber (Referrer)</th>
                            <th class="py-3 px-4">Perangkat & Browser</th>
                            <th class="py-3 px-6 text-right">Tipe</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($recentLogs as $log)
                            <tr class="hover:bg-gray-50/80 transition-colors">
                                <td class="py-3 px-6 font-medium text-gray-600 whitespace-nowrap">
                                    <div class="font-bold text-gray-900">{{ $log->created_at->translatedFormat('d M Y') }}</div>
                                    <div class="text-[11px] text-gray-400 font-mono">{{ $log->created_at->format('H:i:s') }} WIB</div>
                                </td>
                                <td class="py-3 px-4 font-mono font-bold text-gray-900 whitespace-nowrap">
                                    {{ $log->ip_address }}
                                </td>
                                <td class="py-3 px-4 whitespace-nowrap">
                                    <div class="font-bold text-gray-900 flex items-center gap-1.5">
                                        <span class="w-1.5 h-1.5 rounded-full bg-teal-500"></span>
                                        <span>{{ $log->city ?: 'Jakarta' }}</span>
                                    </div>
                                    <div class="text-[11px] text-gray-500">{{ $log->country ?: 'Indonesia' }} ({{ $log->country_code ?: 'ID' }})</div>
                                </td>
                                <td class="py-3 px-4 max-w-xs truncate font-mono text-[11px] text-gray-800">
                                    <a href="{{ $log->url }}" target="_blank" class="hover:text-[#005952] hover:underline" title="{{ $log->url }}">
                                        {{ $log->path }}
                                    </a>
                                </td>
                                <td class="py-3 px-4 max-w-xs truncate text-gray-500">
                                    @if($log->referer)
                                        <span class="text-gray-700 truncate block max-w-[160px]" title="{{ $log->referer }}">
                                            {{ parse_url($log->referer, PHP_URL_HOST) ?: $log->referer }}
                                        </span>
                                    @else
                                        <span class="text-gray-400 italic">Direct / Bookmark</span>
                                    @endif
                                </td>
                                <td class="py-3 px-4 whitespace-nowrap text-gray-700">
                                    <span class="font-semibold text-gray-900">{{ $log->browser }}</span>
                                    <span class="text-gray-400 text-[10px] block">{{ $log->device }} • {{ $log->os }}</span>
                                </td>
                                <td class="py-3 px-6 text-right whitespace-nowrap">
                                    @if($log->is_bot)
                                        <span class="px-2.5 py-0.5 rounded-md bg-amber-50 text-amber-700 font-bold text-[10px]">
                                            Bot
                                        </span>
                                    @else
                                        <span class="px-2.5 py-0.5 rounded-md bg-emerald-50 text-emerald-700 font-bold text-[10px]">
                                            Visitor
                                        </span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="py-8 text-center text-gray-500">
                                    Belum ada catatan aktivitas pengunjung pada periode ini.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($recentLogs->hasPages())
                <div class="p-4 border-t border-gray-100 bg-gray-50/50">
                    {{ $recentLogs->links() }}
                </div>
            @endif
        </div>

    </div>
</x-app-layout>
