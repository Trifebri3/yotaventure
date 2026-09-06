<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <div class="flex items-center gap-2.5 mb-1">
                    <h2 class="font-black text-2xl text-gray-900 leading-tight">
                        Kelola Kolaborasi & Formulir Masuk
                    </h2>
                    @if($unreadCount > 0)
                        <span class="px-2.5 py-0.5 rounded-full bg-rose-500 text-white text-xs font-black tracking-wider animate-pulse">
                            {{ $unreadCount }} PESAN BARU
                        </span>
                    @endif
                </div>
                <p class="text-xs sm:text-sm text-gray-500">
                    Tinjau pesan formulir kemitraan yang diajukan oleh publik, tindak lanjuti langsung ke WhatsApp atau Email, serta kelola syarat & alur 6 program sinergi.
                </p>
            </div>
            <div class="flex items-center gap-3">
                <a 
                    href="{{ route('public.collaboration.index') }}" 
                    target="_blank"
                    class="inline-flex items-center gap-2 px-4 py-2.5 bg-[#005952] hover:bg-[#004741] text-white text-xs font-bold tracking-wider uppercase rounded-xl transition-all shadow-sm"
                >
                    <span>Lihat Halaman Publik</span>
                    <span>↗</span>
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-8 bg-gray-50 min-h-screen" x-data="{
        detailModalOpen: false,
        activeInquiry: {
            id: null,
            name: '',
            email: '',
            phone: '',
            category: '',
            message: '',
            status: 'baru',
            admin_notes: '',
            created_at: '',
            whatsapp_url: ''
        },
        openDetail(inquiry) {
            this.activeInquiry = {
                id: inquiry.id,
                name: inquiry.name,
                email: inquiry.email,
                phone: inquiry.phone || '-',
                category: inquiry.category,
                message: inquiry.message,
                status: inquiry.status,
                admin_notes: inquiry.admin_notes || '',
                created_at: inquiry.created_at_formatted || inquiry.created_at,
                whatsapp_url: inquiry.whatsapp_url || ''
            };
            this.detailModalOpen = true;
        },
        closeDetail() {
            this.detailModalOpen = false;
        }
    }">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">

            {{-- Status Alert --}}
            @if(session('status'))
                <div class="p-4 bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs sm:text-sm font-semibold rounded-2xl flex items-center justify-between shadow-xs">
                    <div class="flex items-center gap-2.5">
                        <svg class="w-5 h-5 text-emerald-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        <span>{{ session('status') }}</span>
                    </div>
                    <button type="button" @click="$el.parentElement.remove()" class="text-emerald-500 hover:text-emerald-700 text-xs font-bold">✕</button>
                </div>
            @endif

            {{-- NAVIGATION TABS --}}
            <div class="flex items-center gap-2 border-b border-gray-200 pb-2">
                <a 
                    href="{{ route('admin.collaborations.index', ['tab' => 'inquiries']) }}"
                    class="px-5 py-3 rounded-2xl text-xs sm:text-sm font-bold tracking-wide transition-all flex items-center gap-2.5 {{ $activeTab === 'inquiries' ? 'bg-[#005952] text-white shadow-md shadow-[#005952]/20' : 'bg-white text-gray-700 hover:bg-gray-100 border border-gray-200' }}"
                >
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                    <span>Pesan & Formulir Masuk</span>
                    @if($unreadCount > 0)
                        <span class="px-2 py-0.5 rounded-full {{ $activeTab === 'inquiries' ? 'bg-rose-500 text-white' : 'bg-rose-100 text-rose-700' }} text-[10px] font-black">
                            {{ $unreadCount }} Baru
                        </span>
                    @else
                        <span class="px-2 py-0.5 rounded-full bg-gray-100 text-gray-600 text-[10px] font-bold">
                            {{ $totalInquiries }}
                        </span>
                    @endif
                </a>

                <a 
                    href="{{ route('admin.collaborations.index', ['tab' => 'tracks']) }}"
                    class="px-5 py-3 rounded-2xl text-xs sm:text-sm font-bold tracking-wide transition-all flex items-center gap-2.5 {{ $activeTab === 'tracks' ? 'bg-[#005952] text-white shadow-md shadow-[#005952]/20' : 'bg-white text-gray-700 hover:bg-gray-100 border border-gray-200' }}"
                >
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>
                    <span>6 Program Sinergi</span>
                    <span class="px-2 py-0.5 rounded-full {{ $activeTab === 'tracks' ? 'bg-teal-700 text-white' : 'bg-gray-100 text-gray-600' }} text-[10px] font-bold">
                        {{ $collaborations->count() }} Track
                    </span>
                </a>
            </div>

            {{-- ======================================================== --}}
            {{-- TAB 1: PESAN & FORMULIR MASUK (INQUIRIES)                 --}}
            {{-- ======================================================== --}}
            @if($activeTab === 'inquiries')
                <div class="space-y-6">
                    
                    {{-- 1. Metrics Overview Grid --}}
                    <div class="grid grid-cols-2 lg:grid-cols-5 gap-4">
                        <div class="bg-white p-5 rounded-3xl border border-gray-200 shadow-xs">
                            <span class="text-[10px] font-bold tracking-wider text-gray-400 uppercase block mb-1">Total Formulir Masuk</span>
                            <div class="text-2xl font-black text-gray-900">{{ $totalInquiries }}</div>
                            <span class="text-[11px] text-gray-500 mt-1 block">Dari formulir web</span>
                        </div>

                        <div class="bg-white p-5 rounded-3xl border border-rose-200 bg-rose-50/20 shadow-xs">
                            <span class="text-[10px] font-bold tracking-wider text-rose-600 uppercase block mb-1">Belum Ditinjau</span>
                            <div class="text-2xl font-black text-rose-700">{{ $newCount }}</div>
                            <span class="text-[11px] text-rose-500 mt-1 block font-medium">Perlu respons tim</span>
                        </div>

                        <div class="bg-white p-5 rounded-3xl border border-amber-200 bg-amber-50/20 shadow-xs">
                            <span class="text-[10px] font-bold tracking-wider text-amber-600 uppercase block mb-1">Sedang Ditinjau</span>
                            <div class="text-2xl font-black text-amber-700">{{ $reviewCount }}</div>
                            <span class="text-[11px] text-amber-500 mt-1 block font-medium">Dalam kurasi internal</span>
                        </div>

                        <div class="bg-white p-5 rounded-3xl border border-blue-200 bg-blue-50/20 shadow-xs">
                            <span class="text-[10px] font-bold tracking-wider text-blue-600 uppercase block mb-1">Sudah Dihubungi</span>
                            <div class="text-2xl font-black text-blue-700">{{ $contactedCount }}</div>
                            <span class="text-[11px] text-blue-500 mt-1 block font-medium">Via WA / Email</span>
                        </div>

                        <div class="bg-white p-5 rounded-3xl border border-emerald-200 bg-emerald-50/20 shadow-xs col-span-2 lg:col-span-1">
                            <span class="text-[10px] font-bold tracking-wider text-emerald-600 uppercase block mb-1">Selesai / Terjalin</span>
                            <div class="text-2xl font-black text-emerald-700">{{ $doneCount }}</div>
                            <span class="text-[11px] text-emerald-500 mt-1 block font-medium">Kolaborasi aktif</span>
                        </div>
                    </div>

                    {{-- 2. Filter & Search Bar --}}
                    <div class="bg-white p-4 sm:p-5 rounded-3xl border border-gray-200 shadow-xs flex flex-col md:flex-row items-center justify-between gap-4">
                        {{-- Status Filters Pills --}}
                        <div class="flex items-center gap-1.5 overflow-x-auto w-full md:w-auto pb-1 md:pb-0 scrollbar-none">
                            @php
                                $statuses = [
                                    'all' => 'Semua ('.$totalInquiries.')',
                                    'baru' => 'Baru ('.$newCount.')',
                                    'ditinjau' => 'Ditinjau ('.$reviewCount.')',
                                    'dihubungi' => 'Dihubungi ('.$contactedCount.')',
                                    'selesai' => 'Selesai ('.$doneCount.')',
                                ];
                            @endphp
                            @foreach($statuses as $stKey => $stLabel)
                                <a 
                                    href="{{ route('admin.collaborations.index', ['tab' => 'inquiries', 'status' => $stKey, 'search' => $search]) }}"
                                    class="px-3.5 py-1.5 rounded-xl text-xs font-bold whitespace-nowrap transition-colors {{ $statusFilter === $stKey ? 'bg-[#005952] text-white shadow-xs' : 'bg-gray-100 text-gray-600 hover:bg-gray-200' }}"
                                >
                                    {{ $stLabel }}
                                </a>
                            @endforeach
                        </div>

                        {{-- Search Input --}}
                        <form method="GET" action="{{ route('admin.collaborations.index') }}" class="w-full md:w-80 flex items-center gap-2">
                            <input type="hidden" name="tab" value="inquiries">
                            <input type="hidden" name="status" value="{{ $statusFilter }}">
                            <div class="relative w-full">
                                <input 
                                    type="text" 
                                    name="search" 
                                    value="{{ $search }}" 
                                    placeholder="Cari nama, email, pesan..."
                                    class="w-full pl-9 pr-3 py-2 text-xs rounded-xl border border-gray-200 bg-gray-50 focus:bg-white focus:border-[#005952] outline-none"
                                >
                                <svg class="w-4 h-4 text-gray-400 absolute left-3 top-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                            </div>
                            @if($search)
                                <a href="{{ route('admin.collaborations.index', ['tab' => 'inquiries', 'status' => $statusFilter]) }}" class="text-xs text-gray-400 hover:text-gray-600 font-bold">Reset</a>
                            @endif
                        </form>
                    </div>

                    {{-- 3. Inquiries Table --}}
                    <div class="bg-white rounded-3xl border border-gray-200 shadow-xs overflow-hidden">
                        @if($inquiries->isEmpty())
                            <div class="p-12 text-center space-y-3">
                                <div class="w-12 h-12 rounded-2xl bg-gray-100 text-gray-400 flex items-center justify-center mx-auto">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/></svg>
                                </div>
                                <h4 class="text-sm font-bold text-gray-800">Belum Ada Pesan Formulir Masuk</h4>
                                <p class="text-xs text-gray-500 max-w-sm mx-auto">Semua pesan yang diajukan pengunjung dari formulir kemitraan publik akan otomatis tersimpan dan tampil di sini.</p>
                            </div>
                        @else
                            <div class="overflow-x-auto">
                                <table class="w-full text-left border-collapse">
                                    <thead>
                                        <tr class="border-b border-gray-100 bg-gray-50/70 text-[11px] font-bold text-gray-500 uppercase tracking-wider">
                                            <th class="py-3.5 px-6">Pengirim & Kontak</th>
                                            <th class="py-3.5 px-6">Bidang Kolaborasi</th>
                                            <th class="py-3.5 px-6">Ringkasan Gagasan</th>
                                            <th class="py-3.5 px-6">Status & Waktu</th>
                                            <th class="py-3.5 px-6 text-right">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-gray-100 text-xs">
                                        @foreach($inquiries as $item)
                                            <tr class="hover:bg-gray-50/60 transition-colors {{ empty($item->read_at) ? 'bg-teal-50/20 font-semibold' : '' }}">
                                                {{-- Name & Contacts --}}
                                                <td class="py-4 px-6">
                                                    <div class="flex items-start gap-2.5">
                                                        @if(empty($item->read_at))
                                                            <span class="w-2 h-2 rounded-full bg-rose-500 mt-1.5 shrink-0" title="Belum Dibaca"></span>
                                                        @endif
                                                        <div>
                                                            <span class="font-extrabold text-gray-900 block text-sm">{{ $item->name }}</span>
                                                            <a href="mailto:{{ $item->email }}" class="text-[#005952] hover:underline font-mono text-[11px] block mt-0.5">
                                                                {{ $item->email }}
                                                            </a>
                                                            @if($item->phone)
                                                                <div class="flex items-center gap-1.5 mt-1">
                                                                    <span class="text-gray-500 font-mono text-[11px]">{{ $item->phone }}</span>
                                                                    @if($item->whatsapp_url)
                                                                        <a 
                                                                            href="{{ $item->whatsapp_url }}" 
                                                                            target="_blank" 
                                                                            class="inline-flex items-center px-1.5 py-0.5 rounded bg-emerald-100 text-emerald-800 text-[10px] font-bold hover:bg-emerald-200 transition-colors"
                                                                            title="Kirim Pesan WhatsApp"
                                                                        >
                                                                            WhatsApp ↗
                                                                        </a>
                                                                    @endif
                                                                </div>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </td>

                                                {{-- Category --}}
                                                <td class="py-4 px-6">
                                                    <span class="inline-block px-2.5 py-1 rounded-lg bg-gray-100 text-gray-800 font-bold text-[11px]">
                                                        {{ $item->category }}
                                                    </span>
                                                </td>

                                                {{-- Message Preview --}}
                                                <td class="py-4 px-6 max-w-xs">
                                                    <p class="text-gray-700 line-clamp-2 leading-relaxed">
                                                        {{ $item->message }}
                                                    </p>
                                                    @if($item->admin_notes)
                                                        <div class="mt-1 flex items-center gap-1 text-[10px] text-amber-700 bg-amber-50 px-2 py-0.5 rounded border border-amber-200 w-fit">
                                                            <span>Catatan:</span>
                                                            <span class="truncate max-w-[180px]">{{ $item->admin_notes }}</span>
                                                        </div>
                                                    @endif
                                                </td>

                                                {{-- Status & Date --}}
                                                <td class="py-4 px-6">
                                                    @php
                                                        $badgeClasses = [
                                                            'baru' => 'bg-rose-100 text-rose-800 border-rose-200',
                                                            'ditinjau' => 'bg-amber-100 text-amber-800 border-amber-200',
                                                            'dihubungi' => 'bg-blue-100 text-blue-800 border-blue-200',
                                                            'selesai' => 'bg-emerald-100 text-emerald-800 border-emerald-200',
                                                            'arsip' => 'bg-gray-100 text-gray-600 border-gray-200',
                                                        ];
                                                        $statusLabel = [
                                                            'baru' => 'Baru',
                                                            'ditinjau' => 'Sedang Ditinjau',
                                                            'dihubungi' => 'Sudah Dihubungi',
                                                            'selesai' => 'Selesai',
                                                            'arsip' => 'Arsip',
                                                        ];
                                                    @endphp
                                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-extrabold border {{ $badgeClasses[$item->status] ?? 'bg-gray-100 text-gray-700' }}">
                                                        {{ $statusLabel[$item->status] ?? $item->status }}
                                                    </span>
                                                    <span class="text-[10px] text-gray-400 block mt-1">
                                                        {{ $item->created_at->translatedFormat('d M Y, H:i') }} WIB
                                                    </span>
                                                </td>

                                                {{-- Actions --}}
                                                <td class="py-4 px-6 text-right">
                                                    <div class="flex items-center justify-end gap-2">
                                                        {{-- Detail Button --}}
                                                        <button 
                                                            type="button" 
                                                            @click="openDetail({{ json_encode([
                                                                'id' => $item->id,
                                                                'name' => $item->name,
                                                                'email' => $item->email,
                                                                'phone' => $item->phone,
                                                                'category' => $item->category,
                                                                'message' => $item->message,
                                                                'status' => $item->status,
                                                                'admin_notes' => $item->admin_notes,
                                                                'created_at_formatted' => $item->created_at->translatedFormat('d F Y, H:i WIB'),
                                                                'whatsapp_url' => $item->whatsapp_url,
                                                            ]) }})"
                                                            class="px-3 py-1.5 rounded-xl bg-[#005952] hover:bg-[#004741] text-white text-xs font-bold transition-all shadow-xs cursor-pointer"
                                                        >
                                                            Tindak Lanjut
                                                        </button>

                                                        {{-- Toggle Read --}}
                                                        <form method="POST" action="{{ route('admin.collaborations.inquiries.toggle-read', $item->id) }}" class="inline">
                                                            @csrf
                                                            <button 
                                                                type="submit" 
                                                                class="p-1.5 rounded-xl border border-gray-200 text-gray-500 hover:bg-gray-100 transition-colors"
                                                                title="{{ $item->read_at ? 'Tandai Belum Dibaca' : 'Tandai Sudah Dibaca' }}"
                                                            >
                                                                @if($item->read_at)
                                                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 19v-8a2 2 0 012-2h14a2 2 0 012 2v8M3 19h18M3 19l6-6m12 6l-6-6"/></svg>
                                                                @else
                                                                    <svg class="w-3.5 h-3.5 text-emerald-600" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/></svg>
                                                                @endif
                                                            </button>
                                                        </form>

                                                        {{-- Delete Button --}}
                                                        <form method="POST" action="{{ route('admin.collaborations.inquiries.destroy', $item->id) }}" onsubmit="return confirm('Hapus pesan formulir ini?')" class="inline">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button 
                                                                type="submit" 
                                                                class="p-1.5 rounded-xl border border-gray-200 text-red-500 hover:bg-red-50 hover:border-red-200 transition-colors"
                                                                title="Hapus Pesan"
                                                            >
                                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                                            </button>
                                                        </form>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                            {{-- Pagination --}}
                            @if($inquiries->hasPages())
                                <div class="p-4 border-t border-gray-100">
                                    {{ $inquiries->links() }}
                                </div>
                            @endif
                        @endif
                    </div>

                </div>
            @endif

            {{-- ======================================================== --}}
            {{-- TAB 2: 6 PROGRAM SINERGI (TRACKS)                         --}}
            {{-- ======================================================== --}}
            @if($activeTab === 'tracks')
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($collaborations as $track)
                        <div class="bg-white rounded-3xl border border-gray-200 shadow-sm p-6 flex flex-col justify-between hover:shadow-md transition-shadow">
                            <div>
                                <div class="flex items-center justify-between mb-3 pb-3 border-b border-gray-100">
                                    <span class="px-2.5 py-1 rounded-md bg-teal-50 text-[#005952] text-[10px] font-extrabold tracking-wider uppercase font-mono">
                                        {{ $track->slug }}
                                    </span>
                                    <span class="text-xs text-gray-400">Urutan: #{{ $track->sort_order }}</span>
                                </div>

                                <span class="text-[10px] text-gray-400 uppercase font-semibold block mb-1">
                                    {{ $track->badge_id }}
                                </span>
                                <h3 class="text-lg font-black text-gray-900 mb-2">
                                    {{ $track->title_id }}
                                </h3>
                                <p class="text-xs text-gray-500 line-clamp-2 mb-4 leading-relaxed">
                                    {{ $track->subtitle_id }}
                                </p>

                                <div class="space-y-2 bg-gray-50 rounded-2xl p-4 border border-gray-100 text-xs text-gray-600 mb-4">
                                    <div class="flex items-center justify-between">
                                        <span class="text-gray-400 font-semibold">Syarat Terdaftar:</span>
                                        <span class="font-bold text-gray-900">{{ count($track->terms_id ?? []) }} poin</span>
                                    </div>
                                    <div class="flex items-center justify-between">
                                        <span class="text-gray-400 font-semibold">Dokumen Disiapkan:</span>
                                        <span class="font-bold text-gray-900">{{ count($track->requirements_id ?? []) }} berkas</span>
                                    </div>
                                    <div class="flex items-center justify-between">
                                        <span class="text-gray-400 font-semibold">Tahapan Alur:</span>
                                        <span class="font-bold text-gray-900">{{ count($track->steps_id ?? []) }} tahap</span>
                                    </div>
                                    <div class="flex items-center justify-between border-t border-gray-200/60 pt-2">
                                        <span class="text-gray-400 font-semibold">Tujuan Email:</span>
                                        <span class="font-bold text-[#005952] font-mono text-[11px]">{{ $track->email_to }}</span>
                                    </div>
                                </div>
                            </div>

                            <div class="pt-4 border-t border-gray-100 flex items-center justify-between">
                                <a 
                                    href="{{ route('public.collaboration.index', ['track' => $track->slug]) }}" 
                                    target="_blank"
                                    class="text-xs text-gray-400 hover:text-gray-600 font-semibold"
                                >
                                    Pratinjau ↗
                                </a>
                                <a 
                                    href="{{ route('admin.collaborations.edit', $track) }}"
                                    class="px-4 py-2 bg-[#005952] hover:bg-[#004741] text-white text-xs font-bold tracking-wider uppercase rounded-xl transition-all shadow-xs"
                                >
                                    Edit Syarat & Alur
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif

        </div>

        {{-- ======================================================== --}}
        {{-- INTERACTIVE DETAIL & FOLLOW-UP MODAL                     --}}
        {{-- ======================================================== --}}
        <div 
            x-show="detailModalOpen" 
            x-cloak
            class="fixed inset-0 bg-gray-950/70 backdrop-blur-xs z-[99999] flex items-center justify-center p-4 overflow-y-auto"
        >
            <div 
                @click.away="closeDetail()"
                class="bg-white rounded-3xl max-w-2xl w-full shadow-2xl border border-gray-200 overflow-hidden transform transition-all my-8 animate-in fade-in zoom-in-95"
            >
                {{-- Header --}}
                <div class="px-6 py-4 bg-gray-50 border-b border-gray-200 flex items-center justify-between">
                    <div class="flex items-center gap-2">
                        <div class="w-8 h-8 rounded-xl bg-teal-100 text-[#005952] flex items-center justify-center font-black text-xs">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                        </div>
                        <div>
                            <h3 class="font-extrabold text-sm text-gray-900" x-text="activeInquiry.name"></h3>
                            <span class="text-[10px] text-gray-400 font-medium" x-text="activeInquiry.created_at"></span>
                        </div>
                    </div>
                    <button type="button" @click="closeDetail()" class="text-gray-400 hover:text-gray-600 text-lg p-1 rounded-lg hover:bg-gray-200/50">✕</button>
                </div>

                {{-- Modal Body --}}
                <div class="p-6 space-y-5 text-left text-xs">
                    {{-- Contacts & Quick Actions Strip --}}
                    <div class="bg-teal-50/50 border border-teal-100 rounded-2xl p-4 flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                        <div>
                            <span class="text-[10px] font-bold text-gray-400 uppercase tracking-wider block mb-1">Kontak Pengirim:</span>
                            <div class="space-y-0.5">
                                <div class="font-bold text-gray-900" x-text="activeInquiry.email"></div>
                                <div class="text-gray-600 font-mono" x-text="activeInquiry.phone"></div>
                            </div>
                        </div>

                        <div class="flex items-center gap-2">
                            <template x-if="activeInquiry.whatsapp_url">
                                <a 
                                    :href="activeInquiry.whatsapp_url" 
                                    target="_blank" 
                                    class="px-3.5 py-2 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white font-bold inline-flex items-center gap-1.5 transition-colors shadow-xs"
                                >
                                    <span>Chat WhatsApp ↗</span>
                                </a>
                            </template>
                            <a 
                                :href="'mailto:' + activeInquiry.email" 
                                class="px-3.5 py-2 rounded-xl bg-white hover:bg-gray-100 text-gray-700 font-bold border border-gray-300 inline-flex items-center gap-1.5 transition-colors"
                            >
                                <span>Kirim Email ↗</span>
                            </a>
                        </div>
                    </div>

                    {{-- Category --}}
                    <div>
                        <span class="text-[10px] font-bold text-gray-400 uppercase tracking-wider block mb-1">Bidang Kolaborasi yang Dipilih:</span>
                        <span class="inline-block px-3 py-1.5 rounded-xl bg-gray-100 text-gray-900 font-bold text-xs" x-text="activeInquiry.category"></span>
                    </div>

                    {{-- Message Box --}}
                    <div>
                        <span class="text-[10px] font-bold text-gray-400 uppercase tracking-wider block mb-1.5">Ringkasan Gagasan / Pesan Kolaborasi:</span>
                        <div class="p-4 rounded-2xl bg-gray-50 border border-gray-200 text-gray-800 leading-relaxed whitespace-pre-line font-normal" x-text="activeInquiry.message"></div>
                    </div>

                    {{-- Follow-up Form --}}
                    <form 
                        :action="'/admin/collaborations/inquiries/' + activeInquiry.id" 
                        method="POST" 
                        class="border-t border-gray-200 pt-4 space-y-4"
                    >
                        @csrf
                        @method('PUT')

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1.5">
                                    Status Tindak Lanjut *
                                </label>
                                <select 
                                    name="status" 
                                    x-model="activeInquiry.status"
                                    class="w-full px-3 py-2.5 rounded-xl border border-gray-200 bg-gray-50 focus:bg-white focus:border-[#005952] text-xs font-semibold text-gray-800 outline-none"
                                >
                                    <option value="baru">Baru (Belum Ditinjau)</option>
                                    <option value="ditinjau">Sedang Ditinjau</option>
                                    <option value="dihubungi">Sudah Dihubungi</option>
                                    <option value="selesai">Selesai / Kerja Sama Terjalin</option>
                                    <option value="arsip">Arsip / Belum Relevan</option>
                                </select>
                            </div>
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1.5">
                                Catatan Internal Tim (Admin Notes)
                            </label>
                            <textarea 
                                name="admin_notes" 
                                rows="2" 
                                x-model="activeInquiry.admin_notes"
                                placeholder="Contoh: Sudah dihubungi via WA tgl 6 Sep oleh Mas Budi, menunggu konfirmasi zoom meeting..."
                                class="w-full px-3 py-2 rounded-xl border border-gray-200 bg-gray-50 focus:bg-white focus:border-[#005952] text-xs text-gray-800 outline-none resize-none"
                            ></textarea>
                        </div>

                        <div class="flex items-center justify-between pt-2">
                            <button 
                                type="button" 
                                @click="closeDetail()"
                                class="px-4 py-2 rounded-xl text-xs font-bold text-gray-600 hover:bg-gray-100 transition-colors"
                            >
                                Tutup
                            </button>

                            <button 
                                type="submit" 
                                class="px-5 py-2.5 rounded-xl bg-[#005952] hover:bg-[#004741] text-white text-xs font-bold uppercase tracking-wider transition-all shadow-md shadow-[#005952]/20 cursor-pointer"
                            >
                                Simpan Tindak Lanjut
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>
</x-app-layout>
