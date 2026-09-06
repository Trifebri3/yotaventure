<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <span class="text-xs font-bold tracking-widest text-[#005952] uppercase block">ARSITEKTUR & MANAGEMENT HUB</span>
                <h2 class="font-black text-xl sm:text-2xl text-gray-900 leading-tight">
                    Kelola Ekosistem, Inisiatif & Portofolio
                </h2>
            </div>
            <div class="flex items-center gap-3">
                <a 
                    href="{{ route('public.ecosystem.index') }}" 
                    target="_blank" 
                    class="inline-flex items-center gap-1.5 px-4 py-2 rounded-xl bg-white border border-gray-300 text-xs font-bold text-gray-700 hover:bg-gray-50 shadow-xs transition-colors"
                >
                    <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                    <span>Lihat Direktori Publik ↗</span>
                </a>
                <a 
                    href="{{ route('public.portfolio.index') }}" 
                    target="_blank" 
                    class="inline-flex items-center gap-1.5 px-4 py-2 rounded-xl bg-teal-50 border border-teal-200 text-xs font-bold text-[#005952] hover:bg-teal-100 shadow-xs transition-colors"
                >
                    <span>Lihat Portofolio ↗</span>
                </a>
            </div>
        </div>
    </x-slot>

    <div 
        x-data="{ 
            activeTab: '{{ $activeTab }}',
            createInitiativeModal: false,
            editInitiativeModal: false,
            selectedInitiative: {},
            createDomainModal: false,
            editDomainModal: false,
            selectedDomain: {},
            createProjectModal: false,
            editProjectModal: false,
            selectedProject: {},
            createClientModal: false,
            editClientModal: false,
            selectedClient: {},
            createProductModal: false,
            editProductModal: false,
            selectedProduct: {},

            openEditProduct(item) {
                this.selectedProduct = JSON.parse(JSON.stringify(item));
                this.editProductModal = true;
            },

            openEditInitiative(item) {
                this.selectedInitiative = JSON.parse(JSON.stringify(item));
                this.selectedInitiative.focus_areas_raw = Array.isArray(item.focus_areas) ? item.focus_areas.join(', ') : (item.focus_areas || '');
                this.selectedInitiative.sdgs_raw = Array.isArray(item.sdgs) ? item.sdgs.join(', ') : (item.sdgs || '');
                this.selectedInitiative.government_issues_raw = Array.isArray(item.government_issues) ? item.government_issues.join(', ') : (item.government_issues || '');
                this.selectedInitiative.gallery_raw = Array.isArray(item.gallery) ? item.gallery.join('\n') : (item.gallery || '');
                if (item.social_links && typeof item.social_links === 'object') {
                    this.selectedInitiative.social_instagram = item.social_links.instagram || '';
                    this.selectedInitiative.social_linkedin = item.social_links.linkedin || '';
                    this.selectedInitiative.social_github = item.social_links.github || '';
                    this.selectedInitiative.social_youtube = item.social_links.youtube || '';
                } else {
                    this.selectedInitiative.social_instagram = '';
                    this.selectedInitiative.social_linkedin = '';
                    this.selectedInitiative.social_github = '';
                    this.selectedInitiative.social_youtube = '';
                }
                this.editInitiativeModal = true;
            },
            openEditDomain(item) {
                this.selectedDomain = JSON.parse(JSON.stringify(item));
                this.selectedDomain.gallery_raw = Array.isArray(item.gallery) ? item.gallery.join('\n') : (item.gallery || '');
                this.selectedDomain.program_logos_raw = Array.isArray(item.program_logos) ? item.program_logos.join('\n') : (item.program_logos || '');
                this.selectedDomain.sdgs_raw = Array.isArray(item.sdgs) ? item.sdgs.join(', ') : (item.sdgs || '');
                if (Array.isArray(item.issues)) {
                    this.selectedDomain.issues_raw = item.issues.map(i => {
                        if (typeof i === 'object' && i !== null && i.issue) {
                            return i.solution ? `${i.issue} :: ${i.solution}` : i.issue;
                        }
                        return String(i);
                    }).join('\n');
                } else {
                    this.selectedDomain.issues_raw = '';
                }
                this.editDomainModal = true;
            },
            openEditProject(item) {
                this.selectedProject = JSON.parse(JSON.stringify(item));
                this.selectedProject.services_raw = Array.isArray(item.services_provided) ? item.services_provided.join(', ') : '';
                this.selectedProject.technologies_raw = Array.isArray(item.technologies) ? item.technologies.join(', ') : '';
                this.editProjectModal = true;
            },
            openEditClient(item) {
                this.selectedClient = JSON.parse(JSON.stringify(item));
                this.editClientModal = true;
            },
            createDocumentModal: false,
            editDocumentModal: false,
            selectedDocument: {},
            openEditDocument(item) {
                this.selectedDocument = JSON.parse(JSON.stringify(item));
                this.editDocumentModal = true;
            },
            createMetricModal: false,
            editMetricModal: false,
            selectedMetric: {},
            openEditMetric(item) {
                this.selectedMetric = JSON.parse(JSON.stringify(item));
                this.editMetricModal = true;
            },
            editPillarModal: false,
            selectedPillar: {},
            openEditPillar(item) {
                this.selectedPillar = JSON.parse(JSON.stringify(item));
                this.selectedPillar.gallery_raw = Array.isArray(item.gallery) ? item.gallery.join('\n') : '';
                this.selectedPillar.sdgs_raw = Array.isArray(item.sdgs) ? item.sdgs.join('\n') : (item.sdgs || '');
                this.selectedPillar.global_programs_raw = Array.isArray(item.global_programs) ? item.global_programs.join('\n') : (item.global_programs || '');
                this.selectedPillar.national_programs_raw = Array.isArray(item.national_programs) ? item.national_programs.join('\n') : (item.national_programs || '');
                this.selectedPillar.youtube_url = item.youtube_url || '';
                this.editPillarModal = true;
            }
        }" 
        class="py-8 bg-gray-50 min-h-screen font-sans"
    >
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">

            {{-- Flash Notification --}}
            @if(session('success'))
                <div class="p-4 rounded-2xl bg-emerald-50 border border-emerald-200 text-emerald-900 flex items-center justify-between shadow-xs">
                    <div class="flex items-center gap-3 text-xs sm:text-sm font-semibold">
                        <svg class="w-5 h-5 text-emerald-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        <span>{{ session('success') }}</span>
                    </div>
                </div>
            @endif

            @if($errors->any())
                <div class="p-4 rounded-2xl bg-red-50 border border-red-200 text-red-900 shadow-xs text-xs">
                    <span class="font-bold block mb-1">Terjadi kesalahan validasi:</span>
                    <ul class="list-disc pl-4 space-y-0.5">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{-- Top KPI Cards --}}
            <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-4">
                <div class="bg-white p-5 rounded-2xl border border-gray-200 shadow-xs">
                    <span class="text-xs font-bold text-gray-500 uppercase tracking-wider block">Domain Makro</span>
                    <span class="text-2xl font-black text-gray-900 mt-1 block">{{ $stats['total_domains'] }}</span>
                    <span class="text-[11px] text-gray-400">Pilar strategis ekosistem</span>
                </div>
                <div class="bg-white p-5 rounded-2xl border border-gray-200 shadow-xs">
                    <span class="text-xs font-bold text-gray-500 uppercase tracking-wider block">Inisiatif / Brand</span>
                    <span class="text-2xl font-black text-[#005952] mt-1 block">{{ $stats['total_initiatives'] }}</span>
                    <span class="text-[11px] text-gray-400">Brand mandiri & unit karya</span>
                </div>
                <div class="bg-white p-5 rounded-2xl border border-gray-200 shadow-xs">
                    <span class="text-xs font-bold text-gray-500 uppercase tracking-wider block">Produk & Inovasi</span>
                    <span class="text-2xl font-black text-[#005952] mt-1 block">{{ $stats['total_products'] }}</span>
                    <span class="text-[11px] text-gray-400">Pipeline Solusi & Isu DB</span>
                </div>
                <div class="bg-white p-5 rounded-2xl border border-gray-200 shadow-xs">
                    <span class="text-xs font-bold text-gray-500 uppercase tracking-wider block">Karya & Portofolio</span>
                    <span class="text-2xl font-black text-gray-900 mt-1 block">{{ $stats['total_projects'] }}</span>
                    <span class="text-[11px] text-gray-400">Studi kasus terverifikasi</span>
                </div>
                <div class="bg-white p-5 rounded-2xl border border-gray-200 shadow-xs">
                    <span class="text-xs font-bold text-gray-500 uppercase tracking-wider block">Mitra Klien</span>
                    <span class="text-2xl font-black text-gray-900 mt-1 block">{{ $stats['total_clients'] }}</span>
                    <span class="text-[11px] text-gray-400">Enterprise & Komunitas</span>
                </div>
                <div class="bg-white p-5 rounded-2xl border border-gray-200 shadow-xs">
                    <span class="text-xs font-bold text-gray-500 uppercase tracking-wider block">Dokumen & ESG</span>
                    <span class="text-2xl font-black text-[#005952] mt-1 block">{{ $stats['total_documents'] }}</span>
                    <span class="text-[11px] text-gray-400">Publikasi & 9 Pilar</span>
                </div>
            </div>

            {{-- Unified Tabs Navigation --}}
            <div class="flex items-center gap-2 border-b border-gray-200 pb-3 select-none overflow-x-auto">
                <button 
                    @click="activeTab = 'initiatives'"
                    type="button"
                    class="px-5 py-2.5 rounded-xl text-xs font-bold tracking-wider uppercase transition-all cursor-pointer flex items-center gap-2 shrink-0"
                    :class="activeTab === 'initiatives' ? 'bg-[#005952] text-white shadow-xs' : 'bg-white text-gray-600 hover:bg-gray-100 border border-gray-200'"
                >
                    <span>Inisiatif / Brand</span>
                    <span class="px-2 py-0.5 rounded-full text-[10px]" :class="activeTab === 'initiatives' ? 'bg-white/20 text-white' : 'bg-gray-100 text-gray-600'">{{ $stats['total_initiatives'] }}</span>
                </button>

                <button 
                    @click="activeTab = 'products'"
                    type="button"
                    class="px-5 py-2.5 rounded-xl text-xs font-bold tracking-wider uppercase transition-all cursor-pointer flex items-center gap-2 shrink-0"
                    :class="activeTab === 'products' ? 'bg-[#005952] text-white shadow-xs' : 'bg-white text-gray-600 hover:bg-gray-100 border border-gray-200'"
                >
                    <span>Produk & Pipeline</span>
                    <span class="px-2 py-0.5 rounded-full text-[10px]" :class="activeTab === 'products' ? 'bg-white/20 text-white' : 'bg-gray-100 text-gray-600'">{{ $stats['total_products'] }}</span>
                </button>

                <button 
                    @click="activeTab = 'domains'"
                    type="button"
                    class="px-5 py-2.5 rounded-xl text-xs font-bold tracking-wider uppercase transition-all cursor-pointer flex items-center gap-2 shrink-0"
                    :class="activeTab === 'domains' ? 'bg-[#005952] text-white shadow-xs' : 'bg-white text-gray-600 hover:bg-gray-100 border border-gray-200'"
                >
                    <span>Domain Makro</span>
                    <span class="px-2 py-0.5 rounded-full text-[10px]" :class="activeTab === 'domains' ? 'bg-white/20 text-white' : 'bg-gray-100 text-gray-600'">{{ $stats['total_domains'] }}</span>
                </button>

                <button 
                    @click="activeTab = 'projects'"
                    type="button"
                    class="px-5 py-2.5 rounded-xl text-xs font-bold tracking-wider uppercase transition-all cursor-pointer flex items-center gap-2 shrink-0"
                    :class="activeTab === 'projects' ? 'bg-[#005952] text-white shadow-xs' : 'bg-white text-gray-600 hover:bg-gray-100 border border-gray-200'"
                >
                    <span>Karya & Portofolio</span>
                    <span class="px-2 py-0.5 rounded-full text-[10px]" :class="activeTab === 'projects' ? 'bg-white/20 text-white' : 'bg-gray-100 text-gray-600'">{{ $stats['total_projects'] }}</span>
                </button>

                <button 
                    @click="activeTab = 'impact'"
                    type="button"
                    class="px-5 py-2.5 rounded-xl text-xs font-bold tracking-wider uppercase transition-all cursor-pointer flex items-center gap-2 shrink-0"
                    :class="activeTab === 'impact' ? 'bg-[#005952] text-white shadow-xs' : 'bg-white text-gray-600 hover:bg-gray-100 border border-gray-200'"
                >
                    <span>Dampak & ESG</span>
                    <span class="px-2 py-0.5 rounded-full text-[10px]" :class="activeTab === 'impact' ? 'bg-white/20 text-white' : 'bg-gray-100 text-gray-600'">{{ $stats['total_documents'] }}</span>
                </button>

                <button 
                    @click="activeTab = 'clients'"
                    type="button"
                    class="px-5 py-2.5 rounded-xl text-xs font-bold tracking-wider uppercase transition-all cursor-pointer flex items-center gap-2 shrink-0"
                    :class="activeTab === 'clients' ? 'bg-[#005952] text-white shadow-xs' : 'bg-white text-gray-600 hover:bg-gray-100 border border-gray-200'"
                >
                    <span>Klien & Mitra</span>
                    <span class="px-2 py-0.5 rounded-full text-[10px]" :class="activeTab === 'clients' ? 'bg-white/20 text-white' : 'bg-gray-100 text-gray-600'">{{ $stats['total_clients'] }}</span>
                </button>
            </div>

            {{-- ========================================================= --}}
            {{-- TAB 1: INITIATIVES / BRANDS                               --}}
            {{-- ========================================================= --}}
            <div x-show="activeTab === 'initiatives'" class="space-y-6">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="text-lg font-black text-gray-900">Daftar Inisiatif & Brand Mandiri</h3>
                        <p class="text-xs text-gray-500">Masing-masing entitas memiliki problem statement yang jelas dan link gateway situs resmi.</p>
                    </div>
                    <button 
                        @click="createInitiativeModal = true"
                        type="button"
                        class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-[#005952] hover:bg-[#004741] text-white text-xs font-bold shadow-sm transition-all"
                    >
                        <span>+ Tambah Inisiatif / Brand</span>
                    </button>
                </div>

                <div class="bg-white rounded-2xl border border-gray-200 overflow-hidden shadow-xs">
                    <div class="overflow-x-auto">
                        <table class="w-full text-left text-xs text-gray-700">
                            <thead class="bg-gray-50 text-[11px] font-bold text-gray-500 uppercase tracking-wider border-b border-gray-200">
                                <tr>
                                    <th class="px-5 py-4">Inisiatif / Brand</th>
                                    <th class="px-5 py-4">Domain & Kaitan SDGs</th>
                                    <th class="px-5 py-4">Masalah & Lokus Wilayah</th>
                                    <th class="px-5 py-4">Situs & Profil Publik</th>
                                    <th class="px-5 py-4">Status</th>
                                    <th class="px-5 py-4 text-right">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                @forelse($initiatives as $initiative)
                                    <tr class="hover:bg-gray-50/80 transition-colors">
                                        <td class="px-5 py-4 font-semibold text-gray-900">
                                            <div class="flex items-center gap-3">
                                                @if($initiative->logo_image)
                                                    <img src="{{ $initiative->logo_image }}" alt="{{ $initiative->name }}" class="w-10 h-10 rounded-xl object-contain bg-white border border-gray-200 p-1 shrink-0 shadow-xs">
                                                @else
                                                    <div class="w-10 h-10 rounded-xl bg-teal-50 border border-teal-200 flex items-center justify-center text-[#005952] font-black text-xs shrink-0">
                                                        {{ strtoupper(substr($initiative->name, 0, 2)) }}
                                                    </div>
                                                @endif
                                                <div>
                                                    <a href="{{ route('public.ecosystem.initiative', $initiative->slug) }}" target="_blank" class="text-sm font-black text-gray-900 hover:text-[#005952] hover:underline flex items-center gap-1">
                                                        <span>{{ $initiative->name }}</span>
                                                        <svg class="w-3 h-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                                                    </a>
                                                    <div class="flex items-center gap-1.5 mt-1">
                                                        <span class="inline-block px-2 py-0.5 rounded text-[10px] font-bold uppercase bg-gray-100 text-gray-700 border border-gray-200">
                                                            {{ $initiative->stage }}
                                                        </span>
                                                        @if(!empty($initiative->gallery) && count($initiative->gallery) > 0)
                                                            <span class="inline-block px-1.5 py-0.5 rounded text-[10px] font-bold bg-purple-50 text-purple-700 border border-purple-200">
                                                                {{ count($initiative->gallery) }} Foto Galeri
                                                            </span>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-5 py-4">
                                            <span class="px-2.5 py-1 rounded-md text-[10px] font-bold bg-teal-50 text-[#005952] border border-teal-200 inline-block mb-1.5">
                                                {{ $initiative->domain->name_id }}
                                            </span>
                                            @if(!empty($initiative->sdgs) && count($initiative->sdgs) > 0)
                                                <div class="flex flex-wrap gap-1 max-w-xs">
                                                    @foreach(array_slice($initiative->sdgs, 0, 3) as $sdgItem)
                                                        <span class="px-1.5 py-0.5 rounded text-[9px] font-bold bg-blue-50 text-blue-700 border border-blue-200">
                                                            {{ Str::limit($sdgItem, 25) }}
                                                        </span>
                                                    @endforeach
                                                    @if(count($initiative->sdgs) > 3)
                                                        <span class="px-1.5 py-0.5 rounded text-[9px] font-bold bg-gray-100 text-gray-600">
                                                            +{{ count($initiative->sdgs) - 3 }} lainnya
                                                        </span>
                                                    @endif
                                                </div>
                                            @else
                                                <span class="text-[11px] text-gray-400 italic block">Belum ditautkan ke SDGs</span>
                                            @endif
                                        </td>
                                        <td class="px-5 py-4 max-w-xs">
                                            <p class="line-clamp-2 text-xs text-gray-600 mb-1">
                                                {{ $initiative->problem_statement_id }}
                                            </p>
                                            @if($initiative->locus)
                                                <div class="flex items-center gap-1 text-[10px] font-bold text-amber-800 bg-amber-50 border border-amber-200 px-2 py-0.5 rounded-md inline-flex">
                                                    <span>Lokus:</span>
                                                    <span>{{ $initiative->locus }}</span>
                                                </div>
                                            @endif
                                        </td>
                                        <td class="px-5 py-4 space-y-1">
                                            @if($initiative->external_website_url)
                                                <a href="{{ $initiative->external_website_url }}" target="_blank" class="text-xs font-bold text-[#005952] hover:underline flex items-center gap-1">
                                                    <span>{{ $initiative->external_url_label }}</span>
                                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                                                </a>
                                            @endif
                                            <a href="{{ route('public.ecosystem.initiative', $initiative->slug) }}" target="_blank" class="text-[11px] font-semibold text-gray-500 hover:text-gray-800 flex items-center gap-1">
                                                <span>Buka Profil Publik</span>
                                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                                            </a>
                                        </td>
                                        <td class="px-5 py-4">
                                            <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-emerald-50 text-emerald-700 border border-emerald-200">
                                                {{ $initiative->status }}
                                            </span>
                                        </td>
                                        <td class="px-5 py-4 text-right space-x-2 whitespace-nowrap">
                                            <button 
                                                @click="openEditInitiative({{ json_encode($initiative) }})" 
                                                type="button" 
                                                class="px-3 py-1.5 rounded-lg bg-gray-100 hover:bg-gray-200 text-gray-800 text-xs font-bold transition-colors"
                                            >
                                                Edit
                                            </button>
                                            <form action="{{ route('admin.ecosystem.initiatives.destroy', $initiative->id) }}" method="POST" class="inline" onsubmit="return confirm('Hapus inisiatif ini beserta data turunannya?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="px-3 py-1.5 rounded-lg bg-red-50 hover:bg-red-100 text-red-700 text-xs font-bold transition-colors">
                                                    Hapus
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="px-5 py-8 text-center text-gray-400">Belum ada inisiatif yang terdaftar.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            {{-- ========================================================= --}}
            {{-- TAB: PRODUCTS & INNOVATION PIPELINE (PRODUK & ISU)        --}}
            {{-- ========================================================= --}}
            <div x-show="activeTab === 'products'" class="space-y-6">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                    <div>
                        <h3 class="text-lg font-black text-gray-900">Katalog Produk & Rekayasa Solusi Database</h3>
                        <p class="text-xs text-gray-500">Seluruh produk dan platform digital/fisik ekosistem yang terhubung langsung ke Inisiatif, Isu Lapangan (Problem Statement), dan Halaman Investasi.</p>
                    </div>
                    <button 
                        @click="createProductModal = true"
                        type="button" 
                        class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-[#005952] hover:bg-[#004741] text-white text-xs font-bold shadow-xs transition-all cursor-pointer shrink-0"
                    >
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                        <span>Tambah Produk Baru</span>
                    </button>
                </div>

                {{-- Table of Products --}}
                <div class="bg-white rounded-2xl border border-gray-200 overflow-hidden shadow-xs">
                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="bg-gray-50/75 border-b border-gray-200 text-[10px] font-mono uppercase tracking-wider text-gray-500">
                                    <th class="px-5 py-3">Produk & Tipe</th>
                                    <th class="px-5 py-3">Inisiatif / Brand</th>
                                    <th class="px-5 py-3">Akar Masalah (Isu Nyata)</th>
                                    <th class="px-5 py-3">Solusi Rekayasa</th>
                                    <th class="px-5 py-3">Status / Akses</th>
                                    <th class="px-5 py-3 text-right">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100 text-xs">
                                @forelse($products as $product)
                                    <tr class="hover:bg-gray-50/50 transition-colors">
                                        <td class="px-5 py-4">
                                            <div class="font-bold text-gray-900 text-sm">{{ $product->name }}</div>
                                            <div class="flex items-center gap-2 mt-1">
                                                <span class="px-2 py-0.5 rounded-md bg-teal-50 text-[#005952] font-mono text-[10px] font-bold">
                                                    {{ $product->type ?: 'Product' }}
                                                </span>
                                                <span class="text-gray-400 font-mono text-[10px]">{{ $product->slug }}</span>
                                            </div>
                                        </td>
                                        <td class="px-5 py-4">
                                            <span class="font-bold text-gray-800">{{ $product->initiative->name ?? '—' }}</span>
                                            <span class="text-[10px] text-gray-400 block">{{ $product->initiative->domain->name_id ?? '' }}</span>
                                        </td>
                                        <td class="px-5 py-4 max-w-xs">
                                            <p class="text-xs text-rose-900 font-medium line-clamp-2 leading-relaxed">
                                                {{ $product->problem_statement_id ?: '—' }}
                                            </p>
                                        </td>
                                        <td class="px-5 py-4 max-w-xs">
                                            <p class="text-xs text-teal-900 font-medium line-clamp-2 leading-relaxed">
                                                {{ $product->solution_statement_id ?: '—' }}
                                            </p>
                                        </td>
                                        <td class="px-5 py-4">
                                            <div class="flex flex-col gap-1">
                                                <span class="inline-flex px-2 py-0.5 rounded-full text-[10px] font-bold w-fit {{ $product->status === 'OPERATING' ? 'bg-emerald-100 text-emerald-800' : 'bg-amber-100 text-amber-800' }}">
                                                    {{ $product->status }}
                                                </span>
                                                @if(!empty($product->website_url))
                                                    <a href="{{ $product->website_url }}" target="_blank" class="text-[10px] text-[#005952] font-bold hover:underline flex items-center gap-0.5">
                                                        <span>Link Produk</span>
                                                        <span>↗</span>
                                                    </a>
                                                @endif
                                            </div>
                                        </td>
                                        <td class="px-5 py-4 text-right whitespace-nowrap space-x-2">
                                            <button 
                                                type="button" 
                                                @click="openEditProduct({{ json_encode($product) }})"
                                                class="px-3 py-1.5 rounded-lg bg-gray-100 hover:bg-gray-200 text-gray-700 text-xs font-bold transition-colors cursor-pointer"
                                            >
                                                Edit
                                            </button>
                                            <form action="{{ route('admin.ecosystem.products.destroy', $product->id) }}" method="POST" class="inline" onsubmit="return confirm('Hapus produk ini dari database?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="px-3 py-1.5 rounded-lg bg-red-50 hover:bg-red-100 text-red-700 text-xs font-bold transition-colors cursor-pointer">
                                                    Hapus
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="px-5 py-8 text-center text-gray-400">Belum ada produk yang terdaftar di database.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            {{-- ========================================================= --}}
            {{-- TAB 2: DOMAINS                                            --}}
            {{-- ========================================================= --}}
            <div x-show="activeTab === 'domains'" class="space-y-6">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="text-lg font-black text-gray-900">Daftar Domain Makro Ekosistem</h3>
                        <p class="text-xs text-gray-500">Arena makro tempat membangun solusi strategis ekosistem (Digital, Agrikultur, Dampak, dll).</p>
                    </div>
                    <button 
                        @click="createDomainModal = true"
                        type="button"
                        class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-[#005952] hover:bg-[#004741] text-white text-xs font-bold shadow-sm transition-all"
                    >
                        <span>+ Tambah Domain</span>
                    </button>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    @foreach($domains as $domain)
                        <div class="bg-white rounded-3xl border border-gray-200 shadow-xs overflow-hidden flex flex-col justify-between hover:shadow-md transition-all">
                            <div>
                                {{-- Cover Banner / Header --}}
                                @if($domain->cover_image)
                                    <div class="h-32 w-full relative overflow-hidden bg-gray-100">
                                        <img src="{{ $domain->cover_image }}" alt="{{ $domain->name_id }}" class="w-full h-full object-cover">
                                        <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-black/20 to-transparent"></div>
                                        <div class="absolute bottom-3 left-4 right-4 flex items-center justify-between text-white text-[10px] font-bold">
                                            <span class="px-2 py-0.5 rounded-md bg-black/40 backdrop-blur-xs border border-white/20 uppercase tracking-wider">
                                                Urutan #{{ $domain->sort_order }}
                                            </span>
                                            <span class="px-2 py-0.5 rounded-md bg-teal-500/80 backdrop-blur-xs text-white uppercase tracking-wider">
                                                {{ $domain->status }}
                                            </span>
                                        </div>
                                    </div>
                                @endif

                                <div class="p-6">
                                    @if(!$domain->cover_image)
                                        <div class="flex items-center justify-between mb-3">
                                            <span class="px-2.5 py-1 rounded-md text-[10px] font-extrabold uppercase bg-teal-50 text-[#005952] border border-teal-200">
                                                Urutan #{{ $domain->sort_order }}
                                            </span>
                                            <span class="text-xs font-mono font-bold text-gray-400 uppercase">{{ $domain->status }}</span>
                                        </div>
                                    @endif

                                    {{-- Icon & Titles --}}
                                    <div class="flex items-start gap-3.5 {{ $domain->cover_image ? '-mt-10' : '' }}">
                                        @if($domain->icon_image)
                                            <img src="{{ $domain->icon_image }}" alt="Icon" class="w-14 h-14 rounded-2xl object-cover border-2 border-white shadow-md bg-white p-1 shrink-0">
                                        @else
                                            <div class="w-12 h-12 rounded-2xl bg-teal-50 border border-teal-200 text-[#005952] flex items-center justify-center shrink-0 shadow-2xs">
                                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>
                                            </div>
                                        @endif

                                        <div class="min-w-0 flex-1">
                                            <h4 class="text-xl font-black text-gray-900 leading-snug">{{ $domain->name_id }}</h4>
                                            <p class="text-xs text-gray-500 italic mt-0.5">{{ $domain->name_en }}</p>
                                        </div>
                                    </div>

                                    @if($domain->tagline_id)
                                        <p class="text-xs text-gray-700 font-medium mt-3">{{ $domain->tagline_id }}</p>
                                    @endif

                                    {{-- SDGs Alignment Badges --}}
                                    @if(!empty($domain->sdgs) && count($domain->sdgs) > 0)
                                        <div class="mt-3 flex flex-wrap gap-1.5">
                                            @foreach($domain->sdgs as $sdg)
                                                <span class="px-2 py-0.5 rounded-md text-[10px] font-bold bg-amber-50 text-amber-900 border border-amber-200">
                                                    {{ $sdg }}
                                                </span>
                                            @endforeach
                                        </div>
                                    @endif

                                    {{-- Core Problem & Tangible Solution --}}
                                    <div class="mt-4 space-y-2.5 text-xs">
                                        <div class="p-3.5 bg-red-50/70 rounded-2xl border border-red-200/80">
                                            <div class="flex items-center gap-1.5 text-[10px] font-black uppercase text-red-900 tracking-wider mb-1">
                                                <svg class="w-3.5 h-3.5 text-red-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                                                <span>Tantangan & Isu Kritis Lapangan:</span>
                                            </div>
                                            <p class="text-red-950 line-clamp-3 leading-relaxed">{{ $domain->problem_statement_id }}</p>
                                        </div>

                                        <div class="p-3.5 bg-emerald-50/70 rounded-2xl border border-emerald-200/80">
                                            <div class="flex items-center gap-1.5 text-[10px] font-black uppercase text-[#005952] tracking-wider mb-1">
                                                <svg class="w-3.5 h-3.5 text-emerald-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                                                <span>Solusi Strategis Ekosistem (Solusi Nyata):</span>
                                            </div>
                                            <p class="text-emerald-950 line-clamp-3 leading-relaxed">{{ $domain->solution_statement_id }}</p>
                                        </div>
                                    </div>

                                    {{-- Structured Issues & Solutions Breakdown --}}
                                    @if(!empty($domain->issues) && count($domain->issues) > 0)
                                        <div class="mt-3 p-3 bg-gray-50 rounded-2xl border border-gray-200 space-y-2">
                                            <span class="text-[10px] font-bold text-gray-700 uppercase tracking-wider block">Katalog Pemecahan Isu Spesifik:</span>
                                            <div class="space-y-1.5">
                                                @foreach(array_slice($domain->issues, 0, 2) as $issueItem)
                                                    <div class="text-[11px] p-2 bg-white rounded-xl border border-gray-100 shadow-2xs">
                                                        <div class="font-bold text-red-900">
                                                            Isu: {{ is_array($issueItem) ? ($issueItem['issue'] ?? '') : $issueItem }}
                                                        </div>
                                                        <div class="text-[#005952] font-semibold mt-0.5">
                                                            Solusi: {{ is_array($issueItem) ? ($issueItem['solution'] ?? $domain->solution_statement_id) : $domain->solution_statement_id }}
                                                        </div>
                                                    </div>
                                                @endforeach
                                                @if(count($domain->issues) > 2)
                                                    <span class="text-[10px] text-gray-400 font-semibold block text-center">+{{ count($domain->issues) - 2 }} isu terpetakan lainnya</span>
                                                @endif
                                            </div>
                                        </div>
                                    @endif

                                    {{-- Program / Partner Logos --}}
                                    @if(!empty($domain->program_logos) && count($domain->program_logos) > 0)
                                        <div class="mt-3">
                                            <span class="text-[10px] font-bold text-gray-400 uppercase tracking-wider block mb-1">Logo Program & Mitra Terkait:</span>
                                            <div class="flex flex-wrap items-center gap-2">
                                                @foreach($domain->program_logos as $pLogo)
                                                    <img src="{{ $pLogo }}" alt="Program" class="h-6 max-w-[80px] object-contain bg-white rounded-md border border-gray-200 p-1">
                                                @endforeach
                                            </div>
                                        </div>
                                    @endif

                                    {{-- Documentation Gallery Preview --}}
                                    @if(!empty($domain->gallery) && count($domain->gallery) > 0)
                                        <div class="mt-3">
                                            <span class="text-[10px] font-bold text-gray-400 uppercase tracking-wider block mb-1">Dokumentasi & Galeri ({{ count($domain->gallery) }} foto):</span>
                                            <div class="grid grid-cols-3 gap-2">
                                                @foreach(array_slice($domain->gallery, 0, 3) as $gIndex => $gPhoto)
                                                    <div class="relative rounded-xl overflow-hidden border border-gray-200 aspect-video bg-gray-100">
                                                        <img src="{{ $gPhoto }}" alt="Galeri" class="w-full h-full object-cover">
                                                        @if($gIndex === 2 && count($domain->gallery) > 3)
                                                            <div class="absolute inset-0 bg-black/60 flex items-center justify-center text-white text-xs font-bold">
                                                                +{{ count($domain->gallery) - 3 }}
                                                            </div>
                                                        @endif
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>

                            {{-- Footer Bar --}}
                            <div class="p-6 pt-4 border-t border-gray-100 bg-gray-50/50 flex items-center justify-between">
                                <div class="flex items-center gap-2">
                                    <span class="text-xs text-gray-500 font-semibold">{{ $domain->initiatives->count() }} Inisiatif</span>
                                    <span class="text-gray-300">•</span>
                                    <a 
                                        href="{{ route('public.ecosystem.domain', $domain->slug) }}" 
                                        target="_blank"
                                        class="text-xs font-bold text-[#005952] hover:underline"
                                    >
                                        Lihat Publik ↗
                                    </a>
                                </div>
                                <div class="space-x-2">
                                    <button 
                                        @click="openEditDomain({{ json_encode($domain) }})" 
                                        type="button" 
                                        class="px-3 py-1.5 rounded-xl bg-white hover:bg-gray-100 text-gray-800 text-xs font-bold border border-gray-200 shadow-2xs transition-colors"
                                    >
                                        Edit
                                    </button>
                                    <form action="{{ route('admin.ecosystem.domains.destroy', $domain->id) }}" method="POST" class="inline" onsubmit="return confirm('Hapus domain ini beserta inisiatifnya?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="px-3 py-1.5 rounded-xl bg-red-50 hover:bg-red-100 text-red-700 text-xs font-bold border border-red-200 transition-colors">
                                            Hapus
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            {{-- ========================================================= --}}
            {{-- TAB 3: PROJECTS / PORTFOLIO                               --}}
            {{-- ========================================================= --}}
            <div x-show="activeTab === 'projects'" class="space-y-6">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="text-lg font-black text-gray-900">Daftar Karya & Portofolio Nyata</h3>
                        <p class="text-xs text-gray-500">Studi kasus riil yang dilengkapi Problem, Solution, Purpose, Tech Stack, dan Measurable Outcome.</p>
                    </div>
                    <button 
                        @click="createProjectModal = true"
                        type="button"
                        class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-[#005952] hover:bg-[#004741] text-white text-xs font-bold shadow-sm transition-all"
                    >
                        <span>+ Tambah Karya / Proyek</span>
                    </button>
                </div>

                <div class="bg-white rounded-2xl border border-gray-200 overflow-hidden shadow-xs">
                    <div class="overflow-x-auto">
                        <table class="w-full text-left text-xs text-gray-700">
                            <thead class="bg-gray-50 text-[11px] font-bold text-gray-500 uppercase tracking-wider border-b border-gray-200">
                                <tr>
                                    <th class="px-5 py-4">Nama Proyek</th>
                                    <th class="px-5 py-4">Inisiatif / Kategori</th>
                                    <th class="px-5 py-4">Klien</th>
                                    <th class="px-5 py-4">Tantangan yang Dihadapi</th>
                                    <th class="px-5 py-4">Hasil Terukur</th>
                                    <th class="px-5 py-4 text-right">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                @forelse($projects as $project)
                                    <tr class="hover:bg-gray-50/80 transition-colors">
                                        <td class="px-5 py-4 font-bold text-gray-900">
                                            <a href="{{ route('public.portfolio.show', $project->slug) }}" target="_blank" class="hover:text-[#005952] hover:underline">
                                                {{ $project->name }}
                                            </a>
                                            <span class="block text-[10px] text-gray-400 font-normal mt-0.5">Status: {{ $project->status }}</span>
                                        </td>
                                        <td class="px-5 py-4">
                                            <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-teal-50 text-[#005952] border border-teal-200">
                                                {{ $project->initiative->name }}
                                            </span>
                                            <div class="text-[11px] text-gray-500 mt-1">{{ $project->category->name_id }}</div>
                                        </td>
                                        <td class="px-5 py-4">
                                            <span class="font-semibold text-gray-800">{{ $project->client?->name ?? 'Internal' }}</span>
                                        </td>
                                        <td class="px-5 py-4 max-w-xs">
                                            <p class="line-clamp-2 text-xs text-red-950 font-medium">{{ $project->problem_statement_id }}</p>
                                        </td>
                                        <td class="px-5 py-4 max-w-xs">
                                            <p class="line-clamp-2 text-xs text-emerald-950 font-medium">{{ $project->result_outcome_id }}</p>
                                        </td>
                                        <td class="px-5 py-4 text-right space-x-2 whitespace-nowrap">
                                            <button 
                                                @click="openEditProject({{ json_encode($project) }})" 
                                                type="button" 
                                                class="px-3 py-1.5 rounded-lg bg-gray-100 hover:bg-gray-200 text-gray-800 text-xs font-bold"
                                            >
                                                Edit
                                            </button>
                                            <form action="{{ route('admin.ecosystem.projects.destroy', $project->id) }}" method="POST" class="inline" onsubmit="return confirm('Hapus proyek portofolio ini?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="px-3 py-1.5 rounded-lg bg-red-50 hover:bg-red-100 text-red-700 text-xs font-bold">
                                                    Hapus
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="px-5 py-8 text-center text-gray-400">Belum ada karya atau studi kasus terdaftar.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="p-4 border-t border-gray-100">
                        {{ $projects->links() }}
                    </div>
                </div>
            </div>

            {{-- ========================================================= --}}
            {{-- TAB 4: CLIENTS & PARTNERS                                 --}}
            {{-- ========================================================= --}}
            <div x-show="activeTab === 'clients'" x-data="{ clientFilter: 'all' }" class="space-y-6">
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                    <div>
                        <h3 class="text-lg font-black text-gray-900">Direktori Mitra & Klien Ekosistem</h3>
                        <p class="text-xs text-gray-500">Daftar instansi, korporasi, lembaga pemerintah, dan mitra kolaboratif yang terhubung dalam ekosistem YOIN.</p>
                    </div>
                    <button 
                        @click="createClientModal = true"
                        type="button"
                        class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-[#005952] hover:bg-[#004741] text-white text-xs font-bold shadow-sm transition-all cursor-pointer"
                    >
                        <span>+ Tambah Mitra / Klien</span>
                    </button>
                </div>

                {{-- Filter Pills by Type --}}
                <div class="flex items-center flex-wrap gap-2 pt-1 pb-2">
                    <button 
                        @click="clientFilter = 'all'"
                        class="px-3.5 py-1.5 rounded-full text-xs font-bold transition-all cursor-pointer"
                        :class="clientFilter === 'all' ? 'bg-[#005952] text-white shadow-xs' : 'bg-white text-gray-600 hover:bg-gray-100 border border-gray-200'"
                    >
                        Semua ({{ $clients->count() }})
                    </button>
                    @php
                        $typesList = ['Mitra Strategis', 'Klien Komersial', 'Pemerintah & BUMN', 'Akademisi & Riset', 'Komunitas & NGO'];
                    @endphp
                    @foreach($typesList as $t)
                        @php
                            $cnt = $clients->where('client_type', $t)->count();
                        @endphp
                        <button 
                            @click="clientFilter = '{{ $t }}'"
                            class="px-3.5 py-1.5 rounded-full text-xs font-bold transition-all cursor-pointer"
                            :class="clientFilter === '{{ $t }}' ? 'bg-[#005952] text-white shadow-xs' : 'bg-white text-gray-600 hover:bg-gray-100 border border-gray-200'"
                        >
                            {{ $t }} ({{ $cnt }})
                        </button>
                    @endforeach
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @forelse($clients as $client)
                        <div 
                            x-show="clientFilter === 'all' || clientFilter === '{{ $client->client_type }}'"
                            class="bg-white rounded-2xl border border-gray-200 p-6 shadow-xs hover:shadow-md transition-all flex flex-col justify-between"
                        >
                            <div>
                                {{-- Card Header: Type Badge & Active Status --}}
                                <div class="flex items-center justify-between gap-2 mb-4">
                                    @php
                                        $typeBadgeClasses = match($client->client_type) {
                                            'Mitra Strategis', 'Enterprise' => 'bg-emerald-50 text-emerald-700 border-emerald-200',
                                            'Pemerintah & BUMN', 'Government' => 'bg-blue-50 text-blue-700 border-blue-200',
                                            'Akademisi & Riset' => 'bg-purple-50 text-purple-700 border-purple-200',
                                            'Klien Komersial' => 'bg-amber-50 text-amber-700 border-amber-200',
                                            'Komunitas & NGO', 'Community', 'NGO' => 'bg-teal-50 text-teal-700 border-teal-200',
                                            default => 'bg-gray-100 text-gray-700 border-gray-200',
                                        };
                                    @endphp
                                    <span class="px-2.5 py-1 rounded-md text-[10px] font-extrabold uppercase border {{ $typeBadgeClasses }}">
                                        {{ $client->client_type }}
                                    </span>
                                    <div class="flex items-center gap-1.5">
                                        @if($client->is_active)
                                            <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-[10px] font-bold bg-green-50 text-green-700">
                                                <span class="w-1.5 h-1.5 rounded-full bg-green-500"></span> Aktif
                                            </span>
                                        @else
                                            <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-[10px] font-bold bg-gray-100 text-gray-500">
                                                Nonaktif
                                            </span>
                                        @endif
                                    </div>
                                </div>

                                {{-- Logo Preview Container --}}
                                <div class="h-16 w-full rounded-xl bg-gray-50 border border-gray-100 flex items-center justify-center p-3 mb-4 overflow-hidden">
                                    @if($client->logo_image)
                                        <img src="{{ $client->logo_image }}" alt="{{ $client->name }}" class="max-h-12 max-w-full object-contain">
                                    @else
                                        <div class="flex items-center gap-2 text-gray-400">
                                            <div class="w-8 h-8 rounded-lg bg-[#005952]/10 text-[#005952] flex items-center justify-center font-black text-xs">
                                                {{ strtoupper(substr($client->name, 0, 2)) }}
                                            </div>
                                            <span class="text-xs font-bold text-gray-600 truncate max-w-[180px]">{{ $client->name }}</span>
                                        </div>
                                    @endif
                                </div>

                                <h4 class="text-base font-black text-gray-950 leading-tight">{{ $client->name }}</h4>
                                <p class="text-xs text-gray-500 mt-1">{{ $client->industry ?: 'Umum' }} • {{ $client->location ?: 'Indonesia' }}</p>
                                
                                @if($client->description_id)
                                    <p class="text-xs text-gray-600 mt-2.5 line-clamp-2 leading-relaxed">{{ $client->description_id }}</p>
                                @endif
                            </div>

                            <div class="mt-6 pt-4 border-t border-gray-100 flex items-center justify-between">
                                @if($client->website_url)
                                    <a href="{{ $client->website_url }}" target="_blank" class="text-xs font-bold text-[#005952] hover:underline inline-flex items-center gap-1">
                                        <span>Website ↗</span>
                                    </a>
                                @else
                                    <span class="text-[10px] text-gray-400">Tanpa tautan</span>
                                @endif
                                <div class="space-x-2">
                                    <button 
                                        @click="openEditClient({{ json_encode($client) }})" 
                                        type="button" 
                                        class="px-3 py-1.5 rounded-lg bg-gray-100 hover:bg-gray-200 text-gray-800 text-xs font-bold transition-colors cursor-pointer"
                                    >
                                        Edit
                                    </button>
                                    <form action="{{ route('admin.ecosystem.clients.destroy', $client->id) }}" method="POST" class="inline" onsubmit="return confirm('Hapus mitra / klien ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="px-3 py-1.5 rounded-lg bg-red-50 hover:bg-red-100 text-red-700 text-xs font-bold transition-colors cursor-pointer">
                                            Hapus
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-span-3 bg-white p-8 rounded-2xl text-center border border-dashed border-gray-300 text-gray-400 text-xs">
                            Belum ada mitra atau klien terdaftar.
                        </div>
                    @endforelse
                </div>
            </div>

            {{-- ========================================================= --}}
            {{-- TAB 5: DAMPAK & ESG (STATISTIK, 9 PILAR & DOKUMEN)        --}}
            {{-- ========================================================= --}}
            <div x-show="activeTab === 'impact'" x-data="{ docCategoryFilter: 'all' }" class="space-y-12">
                
                {{-- ------------------------------------------------------------- --}}
                {{-- BAGIAN 1: ANGKA STATISTIK DAMPAK (TAMPIL DI /dampak)          --}}
                {{-- ------------------------------------------------------------- --}}
                <div class="bg-white rounded-3xl border border-gray-200 p-6 sm:p-8 shadow-xs space-y-6">
                    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-4 border-b border-gray-100">
                        <div>
                            <div class="flex items-center gap-2 mb-1">
                                <span class="w-2 h-2 rounded-full bg-[#005952]"></span>
                                <span class="text-[10px] font-mono font-bold tracking-widest text-[#005952] uppercase">ANGKA CAPAIAN NYATA</span>
                            </div>
                            <h3 class="text-lg font-black text-gray-900">Angka Statistik Dampak Utama</h3>
                            <p class="text-xs text-gray-500">Angka metrik capaian yang ditampilkan di bagian atas halaman publik <a href="{{ route('public.impact.index') }}" target="_blank" class="text-[#005952] underline font-semibold">/dampak</a>.</p>
                        </div>
                        <button 
                            @click="createMetricModal = true"
                            type="button"
                            class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-[#005952] hover:bg-[#004741] text-white text-xs font-bold shadow-sm transition-all cursor-pointer self-start sm:self-auto"
                        >
                            <span>+ Tambah Angka Statistik</span>
                        </button>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="w-full text-left text-xs">
                            <thead>
                                <tr class="border-b border-gray-200 text-gray-400 font-bold uppercase tracking-wider text-[10px]">
                                    <th class="py-3 px-3">Angka Capaian</th>
                                    <th class="py-3 px-3">Label / Metrik (ID & EN)</th>
                                    <th class="py-3 px-3">Deskripsi</th>
                                    <th class="py-3 px-2 text-center">Urutan</th>
                                    <th class="py-3 px-2 text-center">Status</th>
                                    <th class="py-3 px-3 text-right">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                @forelse($metrics as $met)
                                    <tr class="hover:bg-gray-50/80 transition-colors">
                                        <td class="py-3 px-3 font-mono font-black text-base text-gray-950">
                                            {{ $met->metric_value }}
                                        </td>
                                        <td class="py-3 px-3">
                                            <span class="font-bold text-gray-900 block text-xs">{{ $met->label_id }}</span>
                                            @if($met->label_en)
                                                <span class="text-gray-400 text-[11px] block">{{ $met->label_en }}</span>
                                            @endif
                                        </td>
                                        <td class="py-3 px-3 max-w-xs text-gray-500 text-[11px] truncate">
                                            {{ $met->description_id ?: '-' }}
                                        </td>
                                        <td class="py-3 px-2 text-center font-mono font-bold text-gray-600">
                                            {{ $met->sort_order }}
                                        </td>
                                        <td class="py-3 px-2 text-center">
                                            <span class="px-2 py-0.5 rounded-full text-[10px] font-bold {{ $met->is_active ? 'bg-emerald-100 text-emerald-800' : 'bg-gray-100 text-gray-600' }}">
                                                {{ $met->is_active ? 'Aktif' : 'Draft' }}
                                            </span>
                                        </td>
                                        <td class="py-3 px-3 text-right space-x-2 whitespace-nowrap">
                                            <button 
                                                @click="openEditMetric({{ json_encode($met) }})"
                                                type="button"
                                                class="px-2.5 py-1 rounded-lg bg-gray-100 hover:bg-gray-200 text-gray-800 text-[11px] font-bold transition-colors cursor-pointer"
                                            >
                                                Edit
                                            </button>
                                            <form action="{{ route('admin.ecosystem.metrics.destroy', $met->id) }}" method="POST" class="inline" onsubmit="return confirm('Hapus statistik dampak ini?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="px-2.5 py-1 rounded-lg bg-red-50 hover:bg-red-100 text-red-700 text-[11px] font-bold transition-colors cursor-pointer">
                                                    Hapus
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="py-6 text-center text-gray-400 text-xs">
                                            Belum ada angka statistik dampak terdaftar.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                {{-- ------------------------------------------------------------- --}}
                {{-- BAGIAN 2: 9 PILAR GERAKAN TERPADU & KELOLA GALERI FOTO        --}}
                {{-- ------------------------------------------------------------- --}}
                <div class="bg-white rounded-3xl border border-gray-200 p-6 sm:p-8 shadow-xs space-y-6">
                    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-4 border-b border-gray-100">
                        <div>
                            <div class="flex items-center gap-2 mb-1">
                                <span class="w-2 h-2 rounded-full bg-emerald-600"></span>
                                <span class="text-[10px] font-mono font-bold tracking-widest text-emerald-700 uppercase">DOKUMENTASI AKSI LAPANGAN</span>
                            </div>
                            <h3 class="text-lg font-black text-gray-900">9 Pilar Gerakan Terpadu & Galeri Visual (siyota.org)</h3>
                            <p class="text-xs text-gray-500">Kelola foto sampul pilar, metrik khusus, dan kumpulan galeri foto aksi lapangan untuk masing-masing dari 9 pilar.</p>
                        </div>
                        <a 
                            href="https://siyota.org" 
                            target="_blank" 
                            rel="noopener noreferrer" 
                            class="text-xs font-bold text-[#005952] hover:underline self-start sm:self-auto"
                        >
                            Kunjungi Portal siyota.org ↗
                        </a>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach($impactPillars as $pil)
                            @php
                                $pGal = $pil->gallery ?? [];
                                $pSdgs = $pil->sdgs ?? [];
                            @endphp
                            <div class="bg-gray-50 rounded-2xl border border-gray-200 overflow-hidden flex flex-col justify-between hover:border-gray-300 transition-all hover:shadow-md">
                                <div>
                                    {{-- Main Photo Header --}}
                                    <div class="relative h-44 w-full overflow-hidden bg-gray-900 group cursor-pointer" @click="openEditPillar({{ json_encode($pil) }})">
                                        <img src="{{ $pil->photo_image }}" alt="{{ $pil->name }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                                        <div class="absolute inset-0 bg-gradient-to-t from-gray-950 via-gray-950/40 to-transparent"></div>
                                        
                                        <div class="absolute top-3 left-3 right-3 flex items-center justify-between">
                                            <span class="px-2 py-0.5 rounded-md bg-black/70 backdrop-blur-md text-[10px] font-mono font-bold text-teal-300 border border-teal-500/30">
                                                PILAR #0{{ $pil->pillar_number }}
                                            </span>
                                            <div class="flex items-center gap-1.5">
                                                @if($pil->youtube_url)
                                                    <span class="px-2 py-0.5 rounded-md bg-red-600/90 text-white text-[10px] font-bold flex items-center gap-1 shadow-xs" title="Video YouTube Tersemat">
                                                        <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 24 24"><path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/></svg>
                                                        <span>Video</span>
                                                    </span>
                                                @endif
                                                @if($pil->metric_value)
                                                    <span class="px-2.5 py-0.5 rounded-md bg-[#005952] text-white text-[10px] font-mono font-black shadow-xs">
                                                        {{ $pil->metric_value }}
                                                    </span>
                                                @endif
                                            </div>
                                        </div>

                                        <div class="absolute bottom-2.5 left-3 right-3">
                                            <span class="text-[9px] font-mono font-bold text-teal-300 uppercase block tracking-widest">{{ $pil->name }}</span>
                                            <h4 class="font-black text-white text-sm leading-snug">{{ $pil->title_id }}</h4>
                                        </div>
                                    </div>

                                    <div class="p-4 space-y-3">
                                        <p class="text-[11px] text-gray-600 line-clamp-2 leading-relaxed">
                                            {{ $pil->description_id }}
                                        </p>

                                        {{-- SDGs Badges if set --}}
                                        @if(!empty($pSdgs))
                                            <div class="flex flex-wrap gap-1">
                                                @foreach(array_slice($pSdgs, 0, 2) as $sItem)
                                                    <span class="px-2 py-0.5 rounded-md bg-emerald-50 border border-emerald-200 text-emerald-800 text-[10px] font-semibold truncate max-w-[180px]">
                                                        {{ $sItem }}
                                                    </span>
                                                @endforeach
                                                @if(count($pSdgs) > 2)
                                                    <span class="px-1.5 py-0.5 rounded-md bg-gray-100 text-gray-600 text-[9px] font-mono font-bold">
                                                        +{{ count($pSdgs) - 2 }} SDGs
                                                    </span>
                                                @endif
                                            </div>
                                        @endif

                                        {{-- Gallery Preview Thumbnails --}}
                                        <div>
                                            <div class="flex items-center justify-between text-[10px] text-gray-500 font-mono mb-1.5">
                                                <span>Dokumentasi Galeri Aksi</span>
                                                <span class="font-bold text-gray-700">{{ count($pGal) }} Foto</span>
                                            </div>
                                            @if(!empty($pGal))
                                                <div class="grid grid-cols-3 gap-1.5">
                                                    @foreach(array_slice($pGal, 0, 3) as $gUrl)
                                                        <div class="h-12 rounded-lg overflow-hidden border border-gray-200 bg-gray-900">
                                                            <img src="{{ $gUrl }}" alt="" class="w-full h-full object-cover">
                                                        </div>
                                                    @endforeach
                                                </div>
                                            @else
                                                <div class="p-2 rounded-lg border border-dashed border-gray-200 text-center text-[10px] text-gray-400">
                                                    Belum ada foto galeri pilar
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <div class="p-4 pt-2 border-t border-gray-200/80 flex items-center justify-between gap-2">
                                    <span class="text-[10px] text-emerald-600 font-semibold flex items-center gap-1">
                                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                        siyota.org
                                    </span>
                                    <button 
                                        @click="openEditPillar({{ json_encode($pil) }})" 
                                        type="button" 
                                        class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl bg-[#005952] hover:bg-[#004741] text-white text-xs font-bold transition-all shadow-xs cursor-pointer"
                                    >
                                        <svg class="w-3.5 h-3.5 text-teal-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                        <span>Edit Profil & Galeri</span>
                                    </button>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                {{-- ------------------------------------------------------------- --}}
                {{-- BAGIAN 3: KATALOG DOKUMEN & LAPORAN ESG (WAJIB ADA COVER)     --}}
                {{-- ------------------------------------------------------------- --}}
                <div class="bg-white rounded-3xl border border-gray-200 p-6 sm:p-8 shadow-xs space-y-6">
                    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-4 border-b border-gray-100">
                        <div>
                            <div class="flex items-center gap-2 mb-1">
                                <span class="w-2 h-2 rounded-full bg-[#005952]"></span>
                                <span class="text-[10px] font-mono font-bold tracking-widest text-[#005952] uppercase">PUBLIKASI AKUNTABEL</span>
                            </div>
                            <h3 class="text-lg font-black text-gray-900">Katalog Dokumen, Whitepaper & Laporan ESG</h3>
                            <p class="text-xs text-gray-500">Kelola berkas laporan PDF dan tautan eksternal yang dapat diunduh publik di halaman <a href="{{ route('public.impact.index') }}#dokumen-esg" target="_blank" class="text-[#005952] underline font-semibold">/dampak#dokumen-esg</a>. Wajib memiliki gambar sampul (cover image).</p>
                        </div>
                        <button 
                            @click="createDocumentModal = true"
                            type="button"
                            class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-[#005952] hover:bg-[#004741] text-white text-xs font-bold shadow-sm transition-all cursor-pointer self-start sm:self-auto"
                        >
                            <span>+ Tambah Dokumen / Laporan ESG</span>
                        </button>
                    </div>

                    {{-- Filter by Category --}}
                    <div class="flex items-center flex-wrap gap-2 pt-1 pb-2">
                        <button 
                            @click="docCategoryFilter = 'all'"
                            class="px-3.5 py-1.5 rounded-full text-xs font-bold transition-all cursor-pointer"
                            :class="docCategoryFilter === 'all' ? 'bg-[#005952] text-white shadow-xs' : 'bg-white text-gray-600 hover:bg-gray-100 border border-gray-200'"
                        >
                            Semua ({{ $documents->count() }})
                        </button>
                        @php
                            $docCategoriesList = ['Laporan ESG', 'Whitepaper', 'Katalog Program', 'Audit Dampak', 'Riset Kebijakan', 'Lainnya'];
                        @endphp
                        @foreach($docCategoriesList as $cat)
                            @php
                                $dCnt = $documents->where('category', $cat)->count();
                            @endphp
                            @if($dCnt > 0)
                                <button 
                                    @click="docCategoryFilter = '{{ $cat }}'"
                                    class="px-3.5 py-1.5 rounded-full text-xs font-bold transition-all cursor-pointer"
                                    :class="docCategoryFilter === '{{ $cat }}' ? 'bg-[#005952] text-white shadow-xs' : 'bg-white text-gray-600 hover:bg-gray-100 border border-gray-200'"
                                >
                                    {{ $cat }} ({{ $dCnt }})
                                </button>
                            @endif
                        @endforeach
                    </div>

                    {{-- Documents Grid --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @forelse($documents as $doc)
                            <div 
                                x-show="docCategoryFilter === 'all' || docCategoryFilter === '{{ $doc->category }}'"
                                class="bg-white rounded-2xl border border-gray-200 overflow-hidden shadow-xs hover:shadow-md transition-all flex flex-col justify-between"
                            >
                                <div>
                                    {{-- Cover image thumbnail --}}
                                    <div class="relative h-44 w-full overflow-hidden bg-gray-900">
                                        <img src="{{ $doc->cover_image }}" alt="{{ $doc->title_id }}" class="w-full h-full object-cover">
                                        <div class="absolute inset-0 bg-gradient-to-t from-gray-950/80 via-transparent to-transparent"></div>
                                        <div class="absolute top-3 left-3 right-3 flex items-center justify-between">
                                            <span class="px-2.5 py-1 rounded-md bg-white/95 backdrop-blur-md text-[10px] font-extrabold uppercase text-[#005952] shadow-xs">
                                                {{ $doc->category }}
                                            </span>
                                            @if($doc->year)
                                                <span class="px-2 py-0.5 rounded-md bg-black/60 backdrop-blur-md text-[10px] font-mono text-white">
                                                    {{ $doc->year }}
                                                </span>
                                            @endif
                                        </div>
                                        <div class="absolute bottom-2 left-3 right-3 flex items-center justify-between text-[11px] text-white">
                                            <span class="font-mono text-teal-300 font-bold text-[10px]">
                                                {{ $doc->is_pdf ? 'PDF ' . ($doc->file_size ? '(' . $doc->file_size . ')' : '') : ($doc->file_size ?: 'Tautan Eksternal') }}
                                            </span>
                                            <span class="px-2 py-0.5 rounded-full text-[9px] font-bold {{ $doc->is_active ? 'bg-emerald-500/80 text-white' : 'bg-gray-500/80 text-white' }}">
                                                {{ $doc->is_active ? 'Aktif di Web' : 'Draft' }}
                                            </span>
                                        </div>
                                    </div>

                                    <div class="p-5">
                                        <h4 class="font-black text-gray-900 text-sm leading-snug line-clamp-2">
                                            {{ $doc->title_id }}
                                        </h4>
                                        @if($doc->description_id)
                                            <p class="text-xs text-gray-500 mt-2 line-clamp-2">
                                                {{ $doc->description_id }}
                                            </p>
                                        @endif
                                    </div>
                                </div>

                                <div class="p-5 pt-0 border-t border-gray-100 flex items-center justify-between gap-2 mt-4">
                                    <a 
                                        href="{{ $doc->download_url }}" 
                                        target="_blank" 
                                        rel="noopener noreferrer" 
                                        class="inline-flex items-center gap-1 text-xs font-bold text-[#005952] hover:underline"
                                    >
                                        <span>Buka / Unduh</span>
                                        <span>↗</span>
                                    </a>
                                    <div class="space-x-2">
                                        <button 
                                            @click="openEditDocument({{ json_encode($doc) }})" 
                                            type="button" 
                                            class="px-3 py-1.5 rounded-lg bg-gray-100 hover:bg-gray-200 text-gray-800 text-xs font-bold transition-colors cursor-pointer"
                                        >
                                            Edit
                                        </button>
                                        <form action="{{ route('admin.ecosystem.documents.destroy', $doc->id) }}" method="POST" class="inline" onsubmit="return confirm('Hapus dokumen ini?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="px-3 py-1.5 rounded-lg bg-red-50 hover:bg-red-100 text-red-700 text-xs font-bold transition-colors cursor-pointer">
                                                Hapus
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="col-span-3 bg-white p-8 rounded-2xl text-center border border-dashed border-gray-300 text-gray-400 text-xs">
                                Belum ada dokumen publikasi ESG terdaftar.
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>

        </div>

        {{-- ========================================================= --}}
        {{-- MODALS SECTION                                            --}}
        {{-- ========================================================= --}}

        {{-- MODAL: TAMBAH PRODUK & PIPELINE --}}
        <div x-show="createProductModal" x-cloak class="fixed inset-0 z-50 overflow-y-auto bg-black/50 backdrop-blur-xs flex items-center justify-center p-4">
            <div @click.away="createProductModal = false" class="bg-white rounded-3xl max-w-2xl w-full p-6 sm:p-8 shadow-2xl max-h-[90vh] overflow-y-auto text-left relative">
                <div class="flex items-center justify-between pb-4 border-b border-gray-100">
                    <div>
                        <span class="text-[10px] font-mono font-bold tracking-widest text-[#005952] uppercase">REKAYASA SOLUSI & PRODUK</span>
                        <h3 class="text-lg font-black text-gray-900 mt-0.5">Tambah Produk & Solusi Baru</h3>
                    </div>
                    <button type="button" @click="createProductModal = false" class="text-gray-400 hover:text-gray-600 text-xl font-bold">&times;</button>
                </div>

                <form action="{{ route('admin.ecosystem.products.store') }}" method="POST" enctype="multipart/form-data" class="mt-6 space-y-4 text-xs">
                    @csrf
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="font-bold text-gray-700 block mb-1">Inisiatif / Brand *</label>
                            <select name="initiative_id" required class="w-full rounded-xl border border-gray-300 p-2.5 bg-white">
                                <option value="">Pilih Inisiatif...</option>
                                @foreach($initiatives as $init)
                                    <option value="{{ $init->id }}">{{ $init->name }} ({{ $init->domain->name_id ?? 'Domain' }})</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="font-bold text-gray-700 block mb-1">Nama Produk *</label>
                            <input type="text" name="name" required placeholder="Misal: YOIN Enterprise Suite" class="w-full rounded-xl border border-gray-300 p-2.5">
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="font-bold text-gray-700 block mb-1">Tipe Produk / Format *</label>
                            <input type="text" name="type" required placeholder="Misal: Platform SaaS, IoT Device, AgriTech, Fellowship" class="w-full rounded-xl border border-gray-300 p-2.5">
                        </div>
                        <div>
                            <label class="font-bold text-gray-700 block mb-1">URL Situs / Demo Produk</label>
                            <input type="url" name="website_url" placeholder="https://..." class="w-full rounded-xl border border-gray-300 p-2.5">
                        </div>
                    </div>

                    {{-- Masalah & Solusi Lapangan (Sinkron Database Isu) --}}
                    <div class="p-4 bg-rose-50/60 border border-rose-200 rounded-2xl space-y-3">
                        <span class="font-bold text-rose-950 block uppercase tracking-wider text-[10px] font-mono">Akar Masalah Nyata (Isu Lapangan yang Diselesaikan):</span>
                        <div>
                            <label class="font-bold text-gray-700 block mb-1">Isu / Problem Statement (Bahasa Indonesia)</label>
                            <textarea name="problem_statement_id" rows="2" placeholder="Jelaskan masalah riil lapangan yang mendasari lahirnya produk ini..." class="w-full rounded-xl border border-rose-200 p-2.5 bg-white"></textarea>
                        </div>
                        <div>
                            <label class="font-bold text-gray-700 block mb-1">Problem Statement (English)</label>
                            <textarea name="problem_statement_en" rows="2" placeholder="The real-world problem solved by this product..." class="w-full rounded-xl border border-rose-200 p-2.5 bg-white"></textarea>
                        </div>
                    </div>

                    <div class="p-4 bg-teal-50/60 border border-teal-200 rounded-2xl space-y-3">
                        <span class="font-bold text-[#005952] block uppercase tracking-wider text-[10px] font-mono">Solusi Rekayasa YOIN:</span>
                        <div>
                            <label class="font-bold text-gray-700 block mb-1">Solusi Rekayasa (Bahasa Indonesia)</label>
                            <textarea name="solution_statement_id" rows="2" placeholder="Bagaimana produk ini memecahkan masalah tersebut secara teknis..." class="w-full rounded-xl border border-teal-200 p-2.5 bg-white"></textarea>
                        </div>
                        <div>
                            <label class="font-bold text-gray-700 block mb-1">Engineered Solution (English)</label>
                            <textarea name="solution_statement_en" rows="2" placeholder="The engineered solution provided..." class="w-full rounded-xl border border-teal-200 p-2.5 bg-white"></textarea>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="font-bold text-gray-700 block mb-1">Deskripsi Singkat (ID)</label>
                            <textarea name="description_id" rows="2" placeholder="Ringkasan produk..." class="w-full rounded-xl border border-gray-300 p-2.5"></textarea>
                        </div>
                        <div>
                            <label class="font-bold text-gray-700 block mb-1">Short Description (EN)</label>
                            <textarea name="description_en" rows="2" placeholder="Product summary..." class="w-full rounded-xl border border-gray-300 p-2.5"></textarea>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                        <div>
                            <label class="font-bold text-gray-700 block mb-1">Status Kesiapan *</label>
                            <select name="status" required class="w-full rounded-xl border border-gray-300 p-2.5 bg-white">
                                <option value="OPERATING">OPERATING (Berjalan)</option>
                                <option value="BUILDING">BUILDING (Tahap Rekayasa)</option>
                                <option value="PLANNING">PLANNING (Riset Awal)</option>
                                <option value="COMPLETED">COMPLETED</option>
                            </select>
                        </div>
                        <div>
                            <label class="font-bold text-gray-700 block mb-1">Visibilitas Publik *</label>
                            <select name="visibility" required class="w-full rounded-xl border border-gray-300 p-2.5 bg-white">
                                <option value="public">Publik (Tampil di Invest & Ekosistem)</option>
                                <option value="private">Private (Hanya Internal)</option>
                                <option value="draft">Draft</option>
                            </select>
                        </div>
                        <div>
                            <label class="font-bold text-gray-700 block mb-1">Urutan Sort</label>
                            <input type="number" name="sort_order" value="0" class="w-full rounded-xl border border-gray-300 p-2.5">
                        </div>
                    </div>

                    <div class="pt-4 border-t border-gray-100 flex items-center justify-end gap-3">
                        <button type="button" @click="createProductModal = false" class="px-4 py-2 rounded-xl border border-gray-300 text-gray-700 font-bold">Batal</button>
                        <button type="submit" class="px-5 py-2.5 rounded-xl bg-[#005952] hover:bg-[#004741] text-white font-bold shadow-xs">Simpan Produk</button>
                    </div>
                </form>
            </div>
        </div>

        {{-- MODAL: EDIT PRODUK & PIPELINE --}}
        <div x-show="editProductModal" x-cloak class="fixed inset-0 z-50 overflow-y-auto bg-black/50 backdrop-blur-xs flex items-center justify-center p-4">
            <div @click.away="editProductModal = false" class="bg-white rounded-3xl max-w-2xl w-full p-6 sm:p-8 shadow-2xl max-h-[90vh] overflow-y-auto text-left relative">
                <div class="flex items-center justify-between pb-4 border-b border-gray-100">
                    <div>
                        <span class="text-[10px] font-mono font-bold tracking-widest text-[#005952] uppercase">REKAYASA SOLUSI & PRODUK</span>
                        <h3 class="text-lg font-black text-gray-900 mt-0.5">Edit Produk & Solusi</h3>
                    </div>
                    <button type="button" @click="editProductModal = false" class="text-gray-400 hover:text-gray-600 text-xl font-bold">&times;</button>
                </div>

                <form :action="'{{ url('admin/ecosystem/products') }}/' + selectedProduct.id" method="POST" enctype="multipart/form-data" class="mt-6 space-y-4 text-xs">
                    @csrf
                    @method('PUT')
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="font-bold text-gray-700 block mb-1">Inisiatif / Brand *</label>
                            <select name="initiative_id" x-model="selectedProduct.initiative_id" required class="w-full rounded-xl border border-gray-300 p-2.5 bg-white">
                                @foreach($initiatives as $init)
                                    <option value="{{ $init->id }}">{{ $init->name }} ({{ $init->domain->name_id ?? 'Domain' }})</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="font-bold text-gray-700 block mb-1">Nama Produk *</label>
                            <input type="text" name="name" x-model="selectedProduct.name" required class="w-full rounded-xl border border-gray-300 p-2.5">
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="font-bold text-gray-700 block mb-1">Tipe Produk / Format *</label>
                            <input type="text" name="type" x-model="selectedProduct.type" required class="w-full rounded-xl border border-gray-300 p-2.5">
                        </div>
                        <div>
                            <label class="font-bold text-gray-700 block mb-1">URL Situs / Demo Produk</label>
                            <input type="url" name="website_url" x-model="selectedProduct.website_url" class="w-full rounded-xl border border-gray-300 p-2.5">
                        </div>
                    </div>

                    {{-- Masalah & Solusi Lapangan (Sinkron Database Isu) --}}
                    <div class="p-4 bg-rose-50/60 border border-rose-200 rounded-2xl space-y-3">
                        <span class="font-bold text-rose-950 block uppercase tracking-wider text-[10px] font-mono">Akar Masalah Nyata (Isu Lapangan yang Diselesaikan):</span>
                        <div>
                            <label class="font-bold text-gray-700 block mb-1">Isu / Problem Statement (Bahasa Indonesia)</label>
                            <textarea name="problem_statement_id" x-model="selectedProduct.problem_statement_id" rows="2" class="w-full rounded-xl border border-rose-200 p-2.5 bg-white"></textarea>
                        </div>
                        <div>
                            <label class="font-bold text-gray-700 block mb-1">Problem Statement (English)</label>
                            <textarea name="problem_statement_en" x-model="selectedProduct.problem_statement_en" rows="2" class="w-full rounded-xl border border-rose-200 p-2.5 bg-white"></textarea>
                        </div>
                    </div>

                    <div class="p-4 bg-teal-50/60 border border-teal-200 rounded-2xl space-y-3">
                        <span class="font-bold text-[#005952] block uppercase tracking-wider text-[10px] font-mono">Solusi Rekayasa YOIN:</span>
                        <div>
                            <label class="font-bold text-gray-700 block mb-1">Solusi Rekayasa (Bahasa Indonesia)</label>
                            <textarea name="solution_statement_id" x-model="selectedProduct.solution_statement_id" rows="2" class="w-full rounded-xl border border-teal-200 p-2.5 bg-white"></textarea>
                        </div>
                        <div>
                            <label class="font-bold text-gray-700 block mb-1">Engineered Solution (English)</label>
                            <textarea name="solution_statement_en" x-model="selectedProduct.solution_statement_en" rows="2" class="w-full rounded-xl border border-teal-200 p-2.5 bg-white"></textarea>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="font-bold text-gray-700 block mb-1">Deskripsi Singkat (ID)</label>
                            <textarea name="description_id" x-model="selectedProduct.description_id" rows="2" class="w-full rounded-xl border border-gray-300 p-2.5"></textarea>
                        </div>
                        <div>
                            <label class="font-bold text-gray-700 block mb-1">Short Description (EN)</label>
                            <textarea name="description_en" x-model="selectedProduct.description_en" rows="2" class="w-full rounded-xl border border-gray-300 p-2.5"></textarea>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                        <div>
                            <label class="font-bold text-gray-700 block mb-1">Status Kesiapan *</label>
                            <select name="status" x-model="selectedProduct.status" required class="w-full rounded-xl border border-gray-300 p-2.5 bg-white">
                                <option value="OPERATING">OPERATING (Berjalan)</option>
                                <option value="BUILDING">BUILDING (Tahap Rekayasa)</option>
                                <option value="PLANNING">PLANNING (Riset Awal)</option>
                                <option value="COMPLETED">COMPLETED</option>
                            </select>
                        </div>
                        <div>
                            <label class="font-bold text-gray-700 block mb-1">Visibilitas Publik *</label>
                            <select name="visibility" x-model="selectedProduct.visibility" required class="w-full rounded-xl border border-gray-300 p-2.5 bg-white">
                                <option value="public">Publik (Tampil di Invest & Ekosistem)</option>
                                <option value="private">Private (Hanya Internal)</option>
                                <option value="draft">Draft</option>
                            </select>
                        </div>
                        <div>
                            <label class="font-bold text-gray-700 block mb-1">Urutan Sort</label>
                            <input type="number" name="sort_order" x-model="selectedProduct.sort_order" class="w-full rounded-xl border border-gray-300 p-2.5">
                        </div>
                    </div>

                    <div class="pt-4 border-t border-gray-100 flex items-center justify-end gap-3">
                        <button type="button" @click="editProductModal = false" class="px-4 py-2 rounded-xl border border-gray-300 text-gray-700 font-bold">Batal</button>
                        <button type="submit" class="px-5 py-2.5 rounded-xl bg-[#005952] hover:bg-[#004741] text-white font-bold shadow-xs">Simpan Perubahan</button>
                    </div>
                </form>
            </div>
        </div>

        {{-- MODAL: TAMBAH INISIATIF --}}
        <div x-show="createInitiativeModal" x-cloak class="fixed inset-0 z-50 overflow-y-auto bg-black/50 backdrop-blur-xs flex items-center justify-center p-4">
            <div @click.away="createInitiativeModal = false" class="bg-white rounded-3xl max-w-2xl w-full p-6 sm:p-8 shadow-2xl max-h-[90vh] overflow-y-auto">
                <div class="flex items-center justify-between pb-4 border-b border-gray-100">
                    <h3 class="text-lg font-black text-gray-900">Tambah Inisiatif / Brand Baru</h3>
                    <button @click="createInitiativeModal = false" class="text-gray-400 hover:text-gray-600 text-xl font-bold">&times;</button>
                </div>

                <form action="{{ route('admin.ecosystem.initiatives.store') }}" method="POST" enctype="multipart/form-data" class="mt-6 space-y-4 text-xs">
                    @csrf
                    <div>
                        <label class="font-bold text-gray-700 block mb-1">Domain Naungan *</label>
                        <select name="domain_id" required class="w-full rounded-xl border border-gray-300 p-2.5">
                            @foreach($domains as $d)
                                <option value="{{ $d->id }}">{{ $d->name_id }} ({{ $d->name_en }})</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="font-bold text-gray-700 block mb-1">Nama Inisiatif / Brand *</label>
                            <input type="text" name="name" required placeholder="Contoh: YOIN Digital" class="w-full rounded-xl border border-gray-300 p-2.5">
                        </div>
                        <div>
                            <label class="font-bold text-gray-700 block mb-1">Stage / Tipe *</label>
                            <select name="stage" required class="w-full rounded-xl border border-gray-300 p-2.5">
                                <option value="Tech Brand">Tech Brand</option>
                                <option value="AgriTech Initiative">AgriTech Initiative</option>
                                <option value="Social Initiative">Social Initiative</option>
                                <option value="Consumer Brand">Consumer Brand</option>
                                <option value="Product Brand">Product Brand</option>
                                <option value="Movement">Movement</option>
                                <option value="Foundation">Foundation</option>
                            </select>
                        </div>
                    </div>

                    <div>
                        <label class="font-bold text-gray-700 block mb-1">Tagline Singkat (ID)</label>
                        <input type="text" name="tagline_id" placeholder="Kalimat filosofis atau deskripsi 1 baris" class="w-full rounded-xl border border-gray-300 p-2.5">
                    </div>

                    {{-- Visual Branding & Logo with File Upload --}}
                    <div class="p-4 bg-gray-50 border border-gray-200 rounded-2xl space-y-3">
                        <span class="font-bold text-gray-900 block text-xs uppercase tracking-wider">Aset Visual & Branding (Upload File)</span>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label class="font-bold text-gray-700 block mb-1">Upload File Logo *</label>
                                <input type="file" name="logo_file" accept="image/*" class="w-full text-xs text-gray-500 file:mr-2 file:py-1.5 file:px-3 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-[#005952] file:text-white hover:file:bg-[#004741] border border-gray-300 rounded-xl p-1 bg-white">
                                <span class="text-[10px] text-gray-400 mt-1 block">Atau input URL Logo:</span>
                                <input type="url" name="logo_image" placeholder="https://..." class="w-full rounded-xl border border-gray-300 p-2 text-xs mt-0.5">
                            </div>
                            <div>
                                <label class="font-bold text-gray-700 block mb-1">Upload File Cover Banner</label>
                                <input type="file" name="cover_file" accept="image/*" class="w-full text-xs text-gray-500 file:mr-2 file:py-1.5 file:px-3 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-[#005952] file:text-white hover:file:bg-[#004741] border border-gray-300 rounded-xl p-1 bg-white">
                                <span class="text-[10px] text-gray-400 mt-1 block">Atau input URL Banner:</span>
                                <input type="url" name="cover_image" placeholder="https://..." class="w-full rounded-xl border border-gray-300 p-2 text-xs mt-0.5">
                            </div>
                        </div>
                    </div>

                    {{-- SDGs, Government Issues & Locus --}}
                    <div class="p-4 bg-emerald-50/50 border border-emerald-200 rounded-2xl space-y-3">
                        <span class="font-bold text-emerald-950 block text-xs uppercase tracking-wider">Keterkaitan SDGs, Agenda Pemerintah & Lokus</span>
                        <div class="space-y-3">
                            <div>
                                <label class="font-bold text-gray-700 block mb-1">Kaitan SDGs PBB (Pisahkan koma atau baris)</label>
                                <textarea name="sdgs_raw" rows="2" placeholder="Contoh: SDG 2: Tanpa Kelaparan, SDG 8: Pekerjaan Layak, SDG 12: Konsumsi Bertanggung Jawab" class="w-full rounded-xl border border-emerald-300 p-2.5 text-xs"></textarea>
                            </div>
                            <div>
                                <label class="font-bold text-gray-700 block mb-1">Kaitan Isu & Agenda Prioritas Pemerintah</label>
                                <textarea name="government_issues_raw" rows="2" placeholder="Contoh: Ketahanan Pangan Nasional, Hilirisasi Pertanian, Kemandirian Pangan Lokal" class="w-full rounded-xl border border-emerald-300 p-2.5 text-xs"></textarea>
                            </div>
                            <div>
                                <label class="font-bold text-gray-700 block mb-1">Lokus Sasaran / Wilayah Kerja</label>
                                <input type="text" name="locus" placeholder="Contoh: Jawa Barat, Jawa Tengah & DIY" class="w-full rounded-xl border border-emerald-300 p-2.5">
                            </div>
                        </div>
                    </div>

                    {{-- Gallery Documentation with Multi-File Upload --}}
                    <div class="p-4 bg-purple-50/40 border border-purple-200 rounded-2xl space-y-3">
                        <span class="font-bold text-purple-950 block text-xs uppercase tracking-wider">Upload Galeri Foto Lapangan & Dokumentasi</span>
                        <div>
                            <label class="font-bold text-gray-700 block mb-1">Pilih File Foto (Bisa pilih banyak sekaligus) *</label>
                            <input type="file" name="gallery_files[]" multiple accept="image/*" class="w-full text-xs text-gray-500 file:mr-2 file:py-1.5 file:px-3 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-purple-700 file:text-white hover:file:bg-purple-800 border border-purple-200 rounded-xl p-1 bg-white">
                            <span class="text-[10px] text-purple-700 mt-1 block">Pilih beberapa foto kegiatan lapangan sekaligus untuk disimpan ke galeri profil.</span>
                        </div>
                        <div>
                            <label class="font-bold text-gray-700 block mb-1">Atau Tautan Foto Eksternal (1 URL per baris)</label>
                            <textarea name="gallery_raw" rows="2" placeholder="https://images.unsplash.com/...&#10;https://images.unsplash.com/..." class="w-full rounded-xl border border-purple-200 p-2 text-xs font-mono"></textarea>
                        </div>
                    </div>

                    {{-- Crucial Problem Statement --}}
                    <div class="p-4 bg-red-50/50 border border-red-200 rounded-2xl space-y-3">
                        <label class="font-bold text-red-900 block text-xs uppercase tracking-wider">
                            Masalah yang Diselesaikan oleh Inisiatif Ini *
                        </label>
                        <textarea name="problem_statement_id" required rows="3" placeholder="Jelaskan tantangan/masalah spesifik yang melatarbelakangi lahirnya inisiatif ini..." class="w-full rounded-xl border border-red-300 p-2.5 text-xs"></textarea>
                    </div>

                    <div>
                        <label class="font-bold text-gray-700 block mb-1">Mandat Misi</label>
                        <textarea name="mission_id" rows="2" placeholder="Tujuan dan misi strategis..." class="w-full rounded-xl border border-gray-300 p-2.5"></textarea>
                    </div>

                    <div>
                        <label class="font-bold text-gray-700 block mb-1">Area Fokus (Pisahkan dengan koma)</label>
                        <input type="text" name="focus_areas_raw" placeholder="Contoh: Web Systems, IoT Telemetry, Precision Farming" class="w-full rounded-xl border border-gray-300 p-2.5">
                    </div>

                    {{-- External Gateway URL --}}
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 p-4 bg-teal-50/50 border border-teal-200 rounded-2xl">
                        <div>
                            <label class="font-bold text-[#005952] block mb-1">URL Website Resmi (Gateway)</label>
                            <input type="url" name="external_website_url" placeholder="https://yoindigital.com" class="w-full rounded-xl border border-teal-300 p-2.5">
                        </div>
                        <div>
                            <label class="font-bold text-[#005952] block mb-1">Label Tombol</label>
                            <input type="text" name="external_url_label" value="Visit Website →" class="w-full rounded-xl border border-teal-300 p-2.5">
                        </div>
                    </div>

                    {{-- Social Media Links --}}
                    <div class="p-4 bg-gray-50 border border-gray-200 rounded-2xl space-y-3">
                        <span class="font-bold text-gray-900 block text-xs uppercase tracking-wider">Kanal Komunikasi & Media Sosial</span>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                            <div>
                                <label class="font-bold text-gray-700 block mb-1">Instagram URL</label>
                                <input type="text" name="social_instagram" placeholder="https://instagram.com/akun" class="w-full rounded-xl border border-gray-300 p-2.5">
                            </div>
                            <div>
                                <label class="font-bold text-gray-700 block mb-1">LinkedIn URL</label>
                                <input type="text" name="social_linkedin" placeholder="https://linkedin.com/company/akun" class="w-full rounded-xl border border-gray-300 p-2.5">
                            </div>
                            <div>
                                <label class="font-bold text-gray-700 block mb-1">GitHub / Tech Org</label>
                                <input type="text" name="social_github" placeholder="https://github.com/organisasi" class="w-full rounded-xl border border-gray-300 p-2.5">
                            </div>
                            <div>
                                <label class="font-bold text-gray-700 block mb-1">YouTube Channel</label>
                                <input type="text" name="social_youtube" placeholder="https://youtube.com/@channel" class="w-full rounded-xl border border-gray-300 p-2.5">
                            </div>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                        <div>
                            <label class="font-bold text-gray-700 block mb-1">Status</label>
                            <select name="status" class="w-full rounded-xl border border-gray-300 p-2.5">
                                <option value="OPERATING">OPERATING</option>
                                <option value="BUILDING">BUILDING</option>
                                <option value="PLANNING">PLANNING</option>
                                <option value="IDEA">IDEA</option>
                                <option value="COMPLETED">COMPLETED</option>
                            </select>
                        </div>
                        <div>
                            <label class="font-bold text-gray-700 block mb-1">Visibilitas</label>
                            <select name="visibility" class="w-full rounded-xl border border-gray-300 p-2.5">
                                <option value="public">Public</option>
                                <option value="draft">Draft</option>
                                <option value="private">Private</option>
                            </select>
                        </div>
                        <div>
                            <label class="font-bold text-gray-700 block mb-1">Urutan Sort</label>
                            <input type="number" name="sort_order" value="0" class="w-full rounded-xl border border-gray-300 p-2.5">
                        </div>
                    </div>

                    <div class="pt-4 border-t border-gray-100 flex items-center justify-end gap-3">
                        <button type="button" @click="createInitiativeModal = false" class="px-4 py-2 rounded-xl border border-gray-300 text-gray-700 font-bold">Batal</button>
                        <button type="submit" class="px-5 py-2.5 rounded-xl bg-[#005952] text-white font-bold shadow-sm">Simpan Inisiatif</button>
                    </div>
                </form>
            </div>
        </div>

        {{-- MODAL: EDIT INISIATIF --}}
        <div x-show="editInitiativeModal" x-cloak class="fixed inset-0 z-50 overflow-y-auto bg-black/50 backdrop-blur-xs flex items-center justify-center p-4">
            <div @click.away="editInitiativeModal = false" class="bg-white rounded-3xl max-w-2xl w-full p-6 sm:p-8 shadow-2xl max-h-[90vh] overflow-y-auto">
                <div class="flex items-center justify-between pb-4 border-b border-gray-100">
                    <h3 class="text-lg font-black text-gray-900">Edit Inisiatif / Brand</h3>
                    <button @click="editInitiativeModal = false" class="text-gray-400 hover:text-gray-600 text-xl font-bold">&times;</button>
                </div>

                <form :action="'{{ url('admin/ecosystem/initiatives') }}/' + selectedInitiative.id" method="POST" enctype="multipart/form-data" class="mt-6 space-y-4 text-xs">
                    @csrf
                    @method('PUT')
                    <div>
                        <label class="font-bold text-gray-700 block mb-1">Domain Naungan *</label>
                        <select name="domain_id" x-model="selectedInitiative.domain_id" required class="w-full rounded-xl border border-gray-300 p-2.5">
                            @foreach($domains as $d)
                                <option value="{{ $d->id }}">{{ $d->name_id }} ({{ $d->name_en }})</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="font-bold text-gray-700 block mb-1">Nama Inisiatif / Brand *</label>
                            <input type="text" name="name" x-model="selectedInitiative.name" required class="w-full rounded-xl border border-gray-300 p-2.5">
                        </div>
                        <div>
                            <label class="font-bold text-gray-700 block mb-1">Slug URL *</label>
                            <input type="text" name="slug" x-model="selectedInitiative.slug" required class="w-full rounded-xl border border-gray-300 p-2.5">
                        </div>
                    </div>

                    <div>
                        <label class="font-bold text-gray-700 block mb-1">Stage / Tipe *</label>
                        <input type="text" name="stage" x-model="selectedInitiative.stage" required class="w-full rounded-xl border border-gray-300 p-2.5">
                    </div>

                    <div>
                        <label class="font-bold text-gray-700 block mb-1">Tagline Singkat (ID)</label>
                        <input type="text" name="tagline_id" x-model="selectedInitiative.tagline_id" class="w-full rounded-xl border border-gray-300 p-2.5">
                    </div>

                    {{-- Visual Branding & Logo with File Upload --}}
                    <div class="p-4 bg-gray-50 border border-gray-200 rounded-2xl space-y-3">
                        <span class="font-bold text-gray-900 block text-xs uppercase tracking-wider">Aset Visual & Branding (Upload File)</span>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label class="font-bold text-gray-700 block mb-1">Upload File Logo Baru</label>
                                <template x-if="selectedInitiative.logo_image">
                                    <div class="flex items-center gap-2 mb-2 p-2 bg-white rounded-xl border border-gray-200 shadow-2xs">
                                        <img :src="selectedInitiative.logo_image" alt="Logo" class="w-8 h-8 object-contain rounded-lg">
                                        <span class="text-[10px] text-gray-500 font-semibold truncate">Logo Terpasang</span>
                                    </div>
                                </template>
                                <input type="file" name="logo_file" accept="image/*" class="w-full text-xs text-gray-500 file:mr-2 file:py-1.5 file:px-3 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-[#005952] file:text-white hover:file:bg-[#004741] border border-gray-300 rounded-xl p-1 bg-white">
                                <span class="text-[10px] text-gray-400 mt-1 block">Atau URL Logo:</span>
                                <input type="url" name="logo_image" x-model="selectedInitiative.logo_image" placeholder="https://..." class="w-full rounded-xl border border-gray-300 p-2 text-xs mt-0.5">
                            </div>
                            <div>
                                <label class="font-bold text-gray-700 block mb-1">Upload File Cover Banner Baru</label>
                                <template x-if="selectedInitiative.cover_image">
                                    <div class="flex items-center gap-2 mb-2 p-2 bg-white rounded-xl border border-gray-200 shadow-2xs">
                                        <img :src="selectedInitiative.cover_image" alt="Cover" class="w-12 h-8 object-cover rounded-lg">
                                        <span class="text-[10px] text-gray-500 font-semibold truncate">Banner Terpasang</span>
                                    </div>
                                </template>
                                <input type="file" name="cover_file" accept="image/*" class="w-full text-xs text-gray-500 file:mr-2 file:py-1.5 file:px-3 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-[#005952] file:text-white hover:file:bg-[#004741] border border-gray-300 rounded-xl p-1 bg-white">
                                <span class="text-[10px] text-gray-400 mt-1 block">Atau URL Cover:</span>
                                <input type="url" name="cover_image" x-model="selectedInitiative.cover_image" placeholder="https://..." class="w-full rounded-xl border border-gray-300 p-2 text-xs mt-0.5">
                            </div>
                        </div>
                    </div>

                    {{-- SDGs, Government Issues & Locus --}}
                    <div class="p-4 bg-emerald-50/50 border border-emerald-200 rounded-2xl space-y-3">
                        <span class="font-bold text-emerald-950 block text-xs uppercase tracking-wider">Keterkaitan SDGs, Agenda Pemerintah & Lokus</span>
                        <div class="space-y-3">
                            <div>
                                <label class="font-bold text-gray-700 block mb-1">Kaitan SDGs PBB (Pisahkan koma atau baris)</label>
                                <textarea name="sdgs_raw" x-model="selectedInitiative.sdgs_raw" rows="2" placeholder="Contoh: SDG 2: Tanpa Kelaparan, SDG 8: Pekerjaan Layak, SDG 12: Konsumsi Bertanggung Jawab" class="w-full rounded-xl border border-emerald-300 p-2.5 text-xs"></textarea>
                            </div>
                            <div>
                                <label class="font-bold text-gray-700 block mb-1">Kaitan Isu & Agenda Prioritas Pemerintah</label>
                                <textarea name="government_issues_raw" x-model="selectedInitiative.government_issues_raw" rows="2" placeholder="Contoh: Ketahanan Pangan Nasional, Hilirisasi Pertanian, Kemandirian Pangan Lokal" class="w-full rounded-xl border border-emerald-300 p-2.5 text-xs"></textarea>
                            </div>
                            <div>
                                <label class="font-bold text-gray-700 block mb-1">Lokus Sasaran / Wilayah Kerja</label>
                                <input type="text" name="locus" x-model="selectedInitiative.locus" placeholder="Contoh: Jawa Barat, Jawa Tengah & DIY" class="w-full rounded-xl border border-emerald-300 p-2.5">
                            </div>
                        </div>
                    </div>

                    {{-- Gallery Documentation with Multi-File Upload --}}
                    <div class="p-4 bg-purple-50/40 border border-purple-200 rounded-2xl space-y-3">
                        <span class="font-bold text-purple-950 block text-xs uppercase tracking-wider">Galeri Foto Lapangan & Dokumentasi</span>
                        <div>
                            <label class="font-bold text-gray-700 block mb-1">Upload File Foto Baru Tambahan (Bisa banyak sekaligus)</label>
                            <input type="file" name="gallery_files[]" multiple accept="image/*" class="w-full text-xs text-gray-500 file:mr-2 file:py-1.5 file:px-3 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-purple-700 file:text-white hover:file:bg-purple-800 border border-purple-200 rounded-xl p-1 bg-white">
                            <span class="text-[10px] text-purple-700 mt-1 block">Foto yang diupload otomatis ditambahkan ke galeri inisiatif ini.</span>
                        </div>
                        <div>
                            <label class="font-bold text-gray-700 block mb-1">Daftar Link Foto Galeri (1 URL per baris)</label>
                            <textarea name="gallery_raw" x-model="selectedInitiative.gallery_raw" rows="3" placeholder="https://images.unsplash.com/...&#10;https://images.unsplash.com/..." class="w-full rounded-xl border border-purple-200 p-2.5 text-xs font-mono"></textarea>
                        </div>
                    </div>

                    {{-- Crucial Problem Statement --}}
                    <div class="p-4 bg-red-50/50 border border-red-200 rounded-2xl space-y-3">
                        <label class="font-bold text-red-900 block text-xs uppercase tracking-wider">
                            Masalah yang Diselesaikan oleh Inisiatif Ini *
                        </label>
                        <textarea name="problem_statement_id" x-model="selectedInitiative.problem_statement_id" required rows="3" class="w-full rounded-xl border border-red-300 p-2.5 text-xs"></textarea>
                    </div>

                    <div>
                        <label class="font-bold text-gray-700 block mb-1">Mandat Misi</label>
                        <textarea name="mission_id" x-model="selectedInitiative.mission_id" rows="2" class="w-full rounded-xl border border-gray-300 p-2.5"></textarea>
                    </div>

                    <div>
                        <label class="font-bold text-gray-700 block mb-1">Area Fokus (Pisahkan dengan koma)</label>
                        <input type="text" name="focus_areas_raw" x-model="selectedInitiative.focus_areas_raw" class="w-full rounded-xl border border-gray-300 p-2.5">
                    </div>

                    {{-- External Gateway URL --}}
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 p-4 bg-teal-50/50 border border-teal-200 rounded-2xl">
                        <div>
                            <label class="font-bold text-[#005952] block mb-1">URL Website Resmi (Gateway)</label>
                            <input type="url" name="external_website_url" x-model="selectedInitiative.external_website_url" class="w-full rounded-xl border border-teal-300 p-2.5">
                        </div>
                        <div>
                            <label class="font-bold text-[#005952] block mb-1">Label Tombol</label>
                            <input type="text" name="external_url_label" x-model="selectedInitiative.external_url_label" class="w-full rounded-xl border border-teal-300 p-2.5">
                        </div>
                    </div>

                    {{-- Social Media Links --}}
                    <div class="p-4 bg-gray-50 border border-gray-200 rounded-2xl space-y-3">
                        <span class="font-bold text-gray-900 block text-xs uppercase tracking-wider">Kanal Komunikasi & Media Sosial</span>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                            <div>
                                <label class="font-bold text-gray-700 block mb-1">Instagram URL</label>
                                <input type="text" name="social_instagram" x-model="selectedInitiative.social_instagram" placeholder="https://instagram.com/akun" class="w-full rounded-xl border border-gray-300 p-2.5">
                            </div>
                            <div>
                                <label class="font-bold text-gray-700 block mb-1">LinkedIn URL</label>
                                <input type="text" name="social_linkedin" x-model="selectedInitiative.social_linkedin" placeholder="https://linkedin.com/company/akun" class="w-full rounded-xl border border-gray-300 p-2.5">
                            </div>
                            <div>
                                <label class="font-bold text-gray-700 block mb-1">GitHub / Tech Org</label>
                                <input type="text" name="social_github" x-model="selectedInitiative.social_github" placeholder="https://github.com/organisasi" class="w-full rounded-xl border border-gray-300 p-2.5">
                            </div>
                            <div>
                                <label class="font-bold text-gray-700 block mb-1">YouTube Channel</label>
                                <input type="text" name="social_youtube" x-model="selectedInitiative.social_youtube" placeholder="https://youtube.com/@channel" class="w-full rounded-xl border border-gray-300 p-2.5">
                            </div>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                        <div>
                            <label class="font-bold text-gray-700 block mb-1">Status</label>
                            <select name="status" x-model="selectedInitiative.status" class="w-full rounded-xl border border-gray-300 p-2.5">
                                <option value="OPERATING">OPERATING</option>
                                <option value="BUILDING">BUILDING</option>
                                <option value="PLANNING">PLANNING</option>
                                <option value="IDEA">IDEA</option>
                                <option value="COMPLETED">COMPLETED</option>
                            </select>
                        </div>
                        <div>
                            <label class="font-bold text-gray-700 block mb-1">Visibilitas</label>
                            <select name="visibility" x-model="selectedInitiative.visibility" class="w-full rounded-xl border border-gray-300 p-2.5">
                                <option value="public">Public</option>
                                <option value="draft">Draft</option>
                                <option value="private">Private</option>
                            </select>
                        </div>
                        <div>
                            <label class="font-bold text-gray-700 block mb-1">Urutan Sort</label>
                            <input type="number" name="sort_order" x-model="selectedInitiative.sort_order" class="w-full rounded-xl border border-gray-300 p-2.5">
                        </div>
                    </div>

                    <div class="pt-4 border-t border-gray-100 flex items-center justify-end gap-3">
                        <button type="button" @click="editInitiativeModal = false" class="px-4 py-2 rounded-xl border border-gray-300 text-gray-700 font-bold">Batal</button>
                        <button type="submit" class="px-5 py-2.5 rounded-xl bg-[#005952] text-white font-bold shadow-sm">Perbarui Inisiatif</button>
                    </div>
                </form>
            </div>
        </div>

        {{-- MODAL: TAMBAH KARYA / PROYEK --}}
        <div x-show="createProjectModal" x-cloak class="fixed inset-0 z-50 overflow-y-auto bg-black/50 backdrop-blur-xs flex items-center justify-center p-4">
            <div @click.away="createProjectModal = false" class="bg-white rounded-3xl max-w-2xl w-full p-6 sm:p-8 shadow-2xl max-h-[90vh] overflow-y-auto">
                <div class="flex items-center justify-between pb-4 border-b border-gray-100">
                    <h3 class="text-lg font-black text-gray-900">Tambah Karya / Portofolio Baru</h3>
                    <button @click="createProjectModal = false" class="text-gray-400 hover:text-gray-600 text-xl font-bold">&times;</button>
                </div>

                <form action="{{ route('admin.ecosystem.projects.store') }}" method="POST" enctype="multipart/form-data" class="mt-6 space-y-4 text-xs">
                    @csrf
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="font-bold text-gray-700 block mb-1">Inisiatif Pemilik *</label>
                            <select name="initiative_id" required class="w-full rounded-xl border border-gray-300 p-2.5">
                                @foreach($initiatives as $i)
                                    <option value="{{ $i->id }}">{{ $i->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="font-bold text-gray-700 block mb-1">Kategori *</label>
                            <select name="category_id" required class="w-full rounded-xl border border-gray-300 p-2.5">
                                @foreach($categories as $c)
                                    <option value="{{ $c->id }}">{{ $c->name_id }} ({{ $c->product->name }})</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="font-bold text-gray-700 block mb-1">Klien / Mitra (Opsional)</label>
                            <select name="client_id" class="w-full rounded-xl border border-gray-300 p-2.5">
                                <option value="">-- Tanpa Klien / Internal --</option>
                                @foreach($clients as $cl)
                                    <option value="{{ $cl->id }}">{{ $cl->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="font-bold text-gray-700 block mb-1">Tipe Spesifik (Opsional)</label>
                            <select name="type_id" class="w-full rounded-xl border border-gray-300 p-2.5">
                                <option value="">-- Pilih Tipe --</option>
                                @foreach($types as $t)
                                    <option value="{{ $t->id }}">{{ $t->name_id }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div>
                        <label class="font-bold text-gray-700 block mb-1">Judul / Nama Proyek *</label>
                        <input type="text" name="name" required placeholder="Contoh: Portal Intelijen Aset Danantara" class="w-full rounded-xl border border-gray-300 p-2.5">
                    </div>

                    {{-- Visual Uploads for Project --}}
                    <div class="p-4 bg-gray-50 border border-gray-200 rounded-2xl space-y-3">
                        <span class="font-bold text-gray-900 block text-xs uppercase tracking-wider">Aset Visual Proyek (Upload File)</span>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label class="font-bold text-gray-700 block mb-1">Upload Foto Mockup / Hero *</label>
                                <input type="file" name="hero_image_file" accept="image/*" class="w-full text-xs text-gray-500 file:mr-2 file:py-1.5 file:px-3 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-[#005952] file:text-white hover:file:bg-[#004741] border border-gray-300 rounded-xl p-1 bg-white">
                                <span class="text-[10px] text-gray-400 mt-1 block">Atau URL Gambar:</span>
                                <input type="url" name="hero_image" placeholder="https://..." class="w-full rounded-xl border border-gray-300 p-2 text-xs mt-0.5">
                            </div>
                            <div>
                                <label class="font-bold text-gray-700 block mb-1">Upload Foto Cover / Header</label>
                                <input type="file" name="cover_image_file" accept="image/*" class="w-full text-xs text-gray-500 file:mr-2 file:py-1.5 file:px-3 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-[#005952] file:text-white hover:file:bg-[#004741] border border-gray-300 rounded-xl p-1 bg-white">
                                <span class="text-[10px] text-gray-400 mt-1 block">Atau URL Banner:</span>
                                <input type="url" name="cover_image" placeholder="https://..." class="w-full rounded-xl border border-gray-300 p-2 text-xs mt-0.5">
                            </div>
                        </div>
                    </div>

                    {{-- Crucial Problem & Solution --}}
                    <div class="p-4 bg-red-50/50 border border-red-200 rounded-2xl">
                        <label class="font-bold text-red-900 block mb-1 text-xs uppercase tracking-wider">Tantangan / Masalah yang Dihadapi Klien *</label>
                        <textarea name="problem_statement_id" required rows="2" placeholder="Jelaskan masalah riil lapangan yang dihadapi..." class="w-full rounded-xl border border-red-300 p-2.5"></textarea>
                    </div>

                    <div class="p-4 bg-emerald-50/50 border border-emerald-200 rounded-2xl">
                        <label class="font-bold text-[#005952] block mb-1 text-xs uppercase tracking-wider">Pendekatan Solusi & Rekayasa *</label>
                        <textarea name="solution_statement_id" required rows="2" placeholder="Jelaskan bagaimana inisiatif ini merekayasa solusinya..." class="w-full rounded-xl border border-emerald-300 p-2.5"></textarea>
                    </div>

                    <div>
                        <label class="font-bold text-gray-700 block mb-1">Hasil Terukur & Dampak Kuantitatif</label>
                        <textarea name="result_outcome_id" rows="2" placeholder="Contoh: Menghemat waktu siklus audit dari 21 hari menjadi 4 hari kerja (78%)..." class="w-full rounded-xl border border-gray-300 p-2.5"></textarea>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="font-bold text-gray-700 block mb-1">Teknologi Digunakan (Pisahkan koma)</label>
                            <input type="text" name="technologies_raw" placeholder="Laravel, Tailwind, Docker, Redis" class="w-full rounded-xl border border-gray-300 p-2.5">
                        </div>
                        <div>
                            <label class="font-bold text-gray-700 block mb-1">Layanan Diberikan (Pisahkan koma)</label>
                            <input type="text" name="services_raw" placeholder="System Architecture, Frontend, API" class="w-full rounded-xl border border-gray-300 p-2.5">
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                        <div>
                            <label class="font-bold text-gray-700 block mb-1">Status Proyek</label>
                            <select name="status" class="w-full rounded-xl border border-gray-300 p-2.5">
                                <option value="COMPLETED">COMPLETED</option>
                                <option value="OPERATING">OPERATING</option>
                                <option value="BUILDING">BUILDING</option>
                                <option value="PLANNING">PLANNING</option>
                            </select>
                        </div>
                        <div>
                            <label class="font-bold text-gray-700 block mb-1">Tanggal Selesai / Rilis</label>
                            <input type="date" name="launch_date" class="w-full rounded-xl border border-gray-300 p-2.5">
                        </div>
                        <div>
                            <label class="font-bold text-gray-700 block mb-1">URL Proyek Eksternal</label>
                            <input type="url" name="external_url" placeholder="https://..." class="w-full rounded-xl border border-gray-300 p-2.5">
                        </div>
                    </div>

                    <div class="pt-4 border-t border-gray-100 flex items-center justify-end gap-3">
                        <button type="button" @click="createProjectModal = false" class="px-4 py-2 rounded-xl border border-gray-300 text-gray-700 font-bold">Batal</button>
                        <button type="submit" class="px-5 py-2.5 rounded-xl bg-[#005952] text-white font-bold shadow-sm">Simpan Proyek</button>
                    </div>
                </form>
            </div>
        </div>

        {{-- MODAL: EDIT KARYA / PROYEK --}}
        <div x-show="editProjectModal" x-cloak class="fixed inset-0 z-50 overflow-y-auto bg-black/50 backdrop-blur-xs flex items-center justify-center p-4">
            <div @click.away="editProjectModal = false" class="bg-white rounded-3xl max-w-2xl w-full p-6 sm:p-8 shadow-2xl max-h-[90vh] overflow-y-auto">
                <div class="flex items-center justify-between pb-4 border-b border-gray-100">
                    <h3 class="text-lg font-black text-gray-900">Edit Karya / Portofolio</h3>
                    <button @click="editProjectModal = false" class="text-gray-400 hover:text-gray-600 text-xl font-bold">&times;</button>
                </div>

                <form :action="'{{ url('admin/ecosystem/projects') }}/' + selectedProject.id" method="POST" enctype="multipart/form-data" class="mt-6 space-y-4 text-xs">
                    @csrf
                    @method('PUT')
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="font-bold text-gray-700 block mb-1">Inisiatif Pemilik *</label>
                            <select name="initiative_id" x-model="selectedProject.initiative_id" required class="w-full rounded-xl border border-gray-300 p-2.5">
                                @foreach($initiatives as $i)
                                    <option value="{{ $i->id }}">{{ $i->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="font-bold text-gray-700 block mb-1">Kategori *</label>
                            <select name="category_id" x-model="selectedProject.category_id" required class="w-full rounded-xl border border-gray-300 p-2.5">
                                @foreach($categories as $c)
                                    <option value="{{ $c->id }}">{{ $c->name_id }} ({{ $c->product->name }})</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="font-bold text-gray-700 block mb-1">Klien / Mitra (Opsional)</label>
                            <select name="client_id" x-model="selectedProject.client_id" class="w-full rounded-xl border border-gray-300 p-2.5">
                                <option value="">-- Tanpa Klien / Internal --</option>
                                @foreach($clients as $cl)
                                    <option value="{{ $cl->id }}">{{ $cl->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="font-bold text-gray-700 block mb-1">Tipe Spesifik (Opsional)</label>
                            <select name="type_id" x-model="selectedProject.type_id" class="w-full rounded-xl border border-gray-300 p-2.5">
                                <option value="">-- Pilih Tipe --</option>
                                @foreach($types as $t)
                                    <option value="{{ $t->id }}">{{ $t->name_id }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div>
                        <label class="font-bold text-gray-700 block mb-1">Judul / Nama Proyek *</label>
                        <input type="text" name="name" x-model="selectedProject.name" required class="w-full rounded-xl border border-gray-300 p-2.5">
                    </div>

                    {{-- Visual Uploads for Project --}}
                    <div class="p-4 bg-gray-50 border border-gray-200 rounded-2xl space-y-3">
                        <span class="font-bold text-gray-900 block text-xs uppercase tracking-wider">Aset Visual Proyek (Upload File)</span>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label class="font-bold text-gray-700 block mb-1">Upload Foto Mockup / Hero Baru</label>
                                <template x-if="selectedProject.hero_image">
                                    <div class="flex items-center gap-2 mb-2 p-2 bg-white rounded-xl border border-gray-200 shadow-2xs">
                                        <img :src="selectedProject.hero_image" alt="Hero" class="w-10 h-8 object-cover rounded-lg">
                                        <span class="text-[10px] text-gray-500 font-semibold truncate">Gambar Terpasang</span>
                                    </div>
                                </template>
                                <input type="file" name="hero_image_file" accept="image/*" class="w-full text-xs text-gray-500 file:mr-2 file:py-1.5 file:px-3 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-[#005952] file:text-white hover:file:bg-[#004741] border border-gray-300 rounded-xl p-1 bg-white">
                                <span class="text-[10px] text-gray-400 mt-1 block">Atau URL Gambar:</span>
                                <input type="url" name="hero_image" x-model="selectedProject.hero_image" placeholder="https://..." class="w-full rounded-xl border border-gray-300 p-2 text-xs mt-0.5">
                            </div>
                            <div>
                                <label class="font-bold text-gray-700 block mb-1">Upload Foto Cover / Header Baru</label>
                                <template x-if="selectedProject.cover_image">
                                    <div class="flex items-center gap-2 mb-2 p-2 bg-white rounded-xl border border-gray-200 shadow-2xs">
                                        <img :src="selectedProject.cover_image" alt="Cover" class="w-10 h-8 object-cover rounded-lg">
                                        <span class="text-[10px] text-gray-500 font-semibold truncate">Banner Terpasang</span>
                                    </div>
                                </template>
                                <input type="file" name="cover_image_file" accept="image/*" class="w-full text-xs text-gray-500 file:mr-2 file:py-1.5 file:px-3 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-[#005952] file:text-white hover:file:bg-[#004741] border border-gray-300 rounded-xl p-1 bg-white">
                                <span class="text-[10px] text-gray-400 mt-1 block">Atau URL Banner:</span>
                                <input type="url" name="cover_image" x-model="selectedProject.cover_image" placeholder="https://..." class="w-full rounded-xl border border-gray-300 p-2 text-xs mt-0.5">
                            </div>
                        </div>
                    </div>

                    {{-- Crucial Problem & Solution --}}
                    <div class="p-4 bg-red-50/50 border border-red-200 rounded-2xl">
                        <label class="font-bold text-red-900 block mb-1 text-xs uppercase tracking-wider">Tantangan / Masalah yang Dihadapi Klien *</label>
                        <textarea name="problem_statement_id" x-model="selectedProject.problem_statement_id" required rows="2" class="w-full rounded-xl border border-red-300 p-2.5"></textarea>
                    </div>

                    <div class="p-4 bg-emerald-50/50 border border-emerald-200 rounded-2xl">
                        <label class="font-bold text-[#005952] block mb-1 text-xs uppercase tracking-wider">Pendekatan Solusi & Rekayasa *</label>
                        <textarea name="solution_statement_id" x-model="selectedProject.solution_statement_id" required rows="2" class="w-full rounded-xl border border-emerald-300 p-2.5"></textarea>
                    </div>

                    <div>
                        <label class="font-bold text-gray-700 block mb-1">Hasil Terukur & Dampak Kuantitatif</label>
                        <textarea name="result_outcome_id" x-model="selectedProject.result_outcome_id" rows="2" class="w-full rounded-xl border border-gray-300 p-2.5"></textarea>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="font-bold text-gray-700 block mb-1">Teknologi Digunakan (Pisahkan koma)</label>
                            <input type="text" name="technologies_raw" x-model="selectedProject.technologies_raw" class="w-full rounded-xl border border-gray-300 p-2.5">
                        </div>
                        <div>
                            <label class="font-bold text-gray-700 block mb-1">Layanan Diberikan (Pisahkan koma)</label>
                            <input type="text" name="services_raw" x-model="selectedProject.services_raw" class="w-full rounded-xl border border-gray-300 p-2.5">
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                        <div>
                            <label class="font-bold text-gray-700 block mb-1">Status Proyek</label>
                            <select name="status" x-model="selectedProject.status" class="w-full rounded-xl border border-gray-300 p-2.5">
                                <option value="COMPLETED">COMPLETED</option>
                                <option value="OPERATING">OPERATING</option>
                                <option value="BUILDING">BUILDING</option>
                                <option value="PLANNING">PLANNING</option>
                            </select>
                        </div>
                        <div>
                            <label class="font-bold text-gray-700 block mb-1">Tanggal Selesai / Rilis</label>
                            <input type="date" name="launch_date" x-model="selectedProject.launch_date" class="w-full rounded-xl border border-gray-300 p-2.5">
                        </div>
                        <div>
                            <label class="font-bold text-gray-700 block mb-1">URL Proyek Eksternal</label>
                            <input type="url" name="external_url" x-model="selectedProject.external_url" class="w-full rounded-xl border border-gray-300 p-2.5">
                        </div>
                    </div>

                    <div class="pt-4 border-t border-gray-100 flex items-center justify-end gap-3">
                        <button type="button" @click="editProjectModal = false" class="px-4 py-2 rounded-xl border border-gray-300 text-gray-700 font-bold">Batal</button>
                        <button type="submit" class="px-5 py-2.5 rounded-xl bg-[#005952] text-white font-bold shadow-sm">Perbarui Proyek</button>
                    </div>
                </form>
            </div>
        </div>

        {{-- MODAL: TAMBAH MITRA / KLIEN --}}
        <div x-show="createClientModal" x-cloak class="fixed inset-0 z-50 overflow-y-auto bg-black/50 backdrop-blur-xs flex items-center justify-center p-4">
            <div @click.away="createClientModal = false" class="bg-white rounded-3xl max-w-lg w-full p-6 sm:p-8 shadow-2xl">
                <div class="flex items-center justify-between pb-4 border-b border-gray-100">
                    <h3 class="text-lg font-black text-gray-900">Tambah Mitra / Klien Baru</h3>
                    <button @click="createClientModal = false" class="text-gray-400 hover:text-gray-600 text-xl font-bold">&times;</button>
                </div>

                <form action="{{ route('admin.ecosystem.clients.store') }}" method="POST" enctype="multipart/form-data" class="mt-6 space-y-4 text-xs">
                    @csrf
                    <div>
                        <label class="font-bold text-gray-700 block mb-1">Nama Klien / Mitra *</label>
                        <input type="text" name="name" required placeholder="Contoh: PT Danantara Nusantara" class="w-full rounded-xl border border-gray-300 p-2.5">
                    </div>
                    <div>
                        <label class="font-bold text-gray-700 block mb-1">Upload File Logo Klien</label>
                        <input type="file" name="logo_file" accept="image/*" class="w-full text-xs text-gray-500 file:mr-2 file:py-1.5 file:px-3 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-[#005952] file:text-white hover:file:bg-[#004741] border border-gray-300 rounded-xl p-1 bg-white">
                        <span class="text-[10px] text-gray-400 mt-1 block">Atau input URL Logo:</span>
                        <input type="url" name="logo_image" placeholder="https://..." class="w-full rounded-xl border border-gray-300 p-2 text-xs mt-0.5">
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="font-bold text-gray-700 block mb-1">Tipe Mitra / Klien *</label>
                            <select name="client_type" required class="w-full rounded-xl border border-gray-300 p-2.5">
                                <option value="Mitra Strategis">Mitra Strategis (Strategic Partner)</option>
                                <option value="Klien Komersial">Klien Komersial (Client / Commercial)</option>
                                <option value="Pemerintah & BUMN">Pemerintah & BUMN (Government & SOE)</option>
                                <option value="Akademisi & Riset">Akademisi & Riset (Academia & Research)</option>
                                <option value="Komunitas & NGO">Komunitas & NGO (Community & NGO)</option>
                                <option value="Enterprise">Enterprise</option>
                                <option value="Government">Government</option>
                                <option value="Community">Community</option>
                                <option value="NGO">NGO</option>
                                <option value="Internal">Internal</option>
                            </select>
                        </div>
                        <div>
                            <label class="font-bold text-gray-700 block mb-1">Industri / Sektor</label>
                            <input type="text" name="industry" placeholder="Energy, Finance, Agriculture, dll." class="w-full rounded-xl border border-gray-300 p-2.5">
                        </div>
                    </div>
                    <div>
                        <label class="font-bold text-gray-700 block mb-1">Lokasi</label>
                        <input type="text" name="location" placeholder="Jakarta, Indonesia" class="w-full rounded-xl border border-gray-300 p-2.5">
                    </div>
                    <div>
                        <label class="font-bold text-gray-700 block mb-1">Website URL</label>
                        <input type="url" name="website_url" placeholder="https://..." class="w-full rounded-xl border border-gray-300 p-2.5">
                    </div>
                    <div>
                        <label class="font-bold text-gray-700 block mb-1">Deskripsi Ringkas</label>
                        <textarea name="description_id" rows="2" placeholder="Keterangan singkat peran atau profil..." class="w-full rounded-xl border border-gray-300 p-2.5"></textarea>
                    </div>
                    <div class="flex items-center gap-2 pt-1">
                        <input type="checkbox" name="is_active" value="1" id="create_client_is_active" checked class="rounded border-gray-300 text-[#005952] focus:ring-[#005952]">
                        <label for="create_client_is_active" class="font-bold text-gray-700">Tampilkan Aktif di Web Publik (Running Marquee)</label>
                    </div>

                    <div class="pt-4 border-t border-gray-100 flex items-center justify-end gap-3">
                        <button type="button" @click="createClientModal = false" class="px-4 py-2 rounded-xl border border-gray-300 text-gray-700 font-bold cursor-pointer">Batal</button>
                        <button type="submit" class="px-5 py-2.5 rounded-xl bg-[#005952] text-white font-bold shadow-sm cursor-pointer">Simpan Mitra / Klien</button>
                    </div>
                </form>
            </div>
        </div>

        {{-- MODAL: EDIT MITRA / KLIEN --}}
        <div x-show="editClientModal" x-cloak class="fixed inset-0 z-50 overflow-y-auto bg-black/50 backdrop-blur-xs flex items-center justify-center p-4">
            <div @click.away="editClientModal = false" class="bg-white rounded-3xl max-w-lg w-full p-6 sm:p-8 shadow-2xl">
                <div class="flex items-center justify-between pb-4 border-b border-gray-100">
                    <h3 class="text-lg font-black text-gray-900">Edit Mitra / Klien</h3>
                    <button @click="editClientModal = false" class="text-gray-400 hover:text-gray-600 text-xl font-bold">&times;</button>
                </div>

                <form :action="'{{ url('admin/ecosystem/clients') }}/' + selectedClient.id" method="POST" enctype="multipart/form-data" class="mt-6 space-y-4 text-xs">
                    @csrf
                    @method('PUT')
                    <div>
                        <label class="font-bold text-gray-700 block mb-1">Nama Klien / Mitra *</label>
                        <input type="text" name="name" x-model="selectedClient.name" required class="w-full rounded-xl border border-gray-300 p-2.5">
                    </div>
                    <div>
                        <label class="font-bold text-gray-700 block mb-1">Upload File Logo Klien Baru</label>
                        <template x-if="selectedClient.logo_image">
                            <div class="flex items-center gap-2 mb-2 p-2 bg-white rounded-xl border border-gray-200 shadow-2xs">
                                <img :src="selectedClient.logo_image" alt="Logo" class="w-8 h-8 object-contain rounded-lg">
                                <span class="text-[10px] text-gray-500 font-semibold truncate">Logo Klien Terpasang</span>
                            </div>
                        </template>
                        <input type="file" name="logo_file" accept="image/*" class="w-full text-xs text-gray-500 file:mr-2 file:py-1.5 file:px-3 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-[#005952] file:text-white hover:file:bg-[#004741] border border-gray-300 rounded-xl p-1 bg-white">
                        <span class="text-[10px] text-gray-400 mt-1 block">Atau URL Logo:</span>
                        <input type="url" name="logo_image" x-model="selectedClient.logo_image" placeholder="https://..." class="w-full rounded-xl border border-gray-300 p-2 text-xs mt-0.5">
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="font-bold text-gray-700 block mb-1">Tipe Mitra / Klien *</label>
                            <select name="client_type" x-model="selectedClient.client_type" required class="w-full rounded-xl border border-gray-300 p-2.5">
                                <option value="Mitra Strategis">Mitra Strategis (Strategic Partner)</option>
                                <option value="Klien Komersial">Klien Komersial (Client / Commercial)</option>
                                <option value="Pemerintah & BUMN">Pemerintah & BUMN (Government & SOE)</option>
                                <option value="Akademisi & Riset">Akademisi & Riset (Academia & Research)</option>
                                <option value="Komunitas & NGO">Komunitas & NGO (Community & NGO)</option>
                                <option value="Enterprise">Enterprise</option>
                                <option value="Government">Government</option>
                                <option value="Community">Community</option>
                                <option value="NGO">NGO</option>
                                <option value="Internal">Internal</option>
                            </select>
                        </div>
                        <div>
                            <label class="font-bold text-gray-700 block mb-1">Industri / Sektor</label>
                            <input type="text" name="industry" x-model="selectedClient.industry" placeholder="Energy, Finance, Agriculture, dll." class="w-full rounded-xl border border-gray-300 p-2.5">
                        </div>
                    </div>
                    <div>
                        <label class="font-bold text-gray-700 block mb-1">Lokasi</label>
                        <input type="text" name="location" x-model="selectedClient.location" class="w-full rounded-xl border border-gray-300 p-2.5">
                    </div>
                    <div>
                        <label class="font-bold text-gray-700 block mb-1">Website URL</label>
                        <input type="url" name="website_url" x-model="selectedClient.website_url" class="w-full rounded-xl border border-gray-300 p-2.5">
                    </div>
                    <div>
                        <label class="font-bold text-gray-700 block mb-1">Deskripsi Ringkas</label>
                        <textarea name="description_id" x-model="selectedClient.description_id" rows="2" class="w-full rounded-xl border border-gray-300 p-2.5"></textarea>
                    </div>
                    <div class="flex items-center gap-2 pt-1">
                        <input type="checkbox" name="is_active" value="1" id="edit_client_is_active" x-model="selectedClient.is_active" class="rounded border-gray-300 text-[#005952] focus:ring-[#005952]">
                        <label for="edit_client_is_active" class="font-bold text-gray-700">Tampilkan Aktif di Web Publik (Running Marquee)</label>
                    </div>

                    <div class="pt-4 border-t border-gray-100 flex items-center justify-end gap-3">
                        <button type="button" @click="editClientModal = false" class="px-4 py-2 rounded-xl border border-gray-300 text-gray-700 font-bold cursor-pointer">Batal</button>
                        <button type="submit" class="px-5 py-2.5 rounded-xl bg-[#005952] text-white font-bold shadow-sm cursor-pointer">Perbarui Mitra / Klien</button>
                    </div>
                </form>
            </div>
        </div>

        {{-- MODAL: TAMBAH DOMAIN MAKRO --}}
        <div x-show="createDomainModal" x-cloak class="fixed inset-0 z-50 overflow-y-auto bg-black/50 backdrop-blur-xs flex items-center justify-center p-4">
            <div @click.away="createDomainModal = false" class="bg-white rounded-3xl max-w-3xl w-full p-6 sm:p-8 shadow-2xl max-h-[90vh] overflow-y-auto">
                <div class="flex items-center justify-between pb-4 border-b border-gray-100">
                    <div>
                        <h3 class="text-lg font-black text-gray-900">Tambah Domain Makro Ekosistem</h3>
                        <p class="text-xs text-gray-500">Bangun pilar arena strategis baru beserta galeri, icon, SDGs dan solusi tantangannya.</p>
                    </div>
                    <button @click="createDomainModal = false" class="text-gray-400 hover:text-gray-600 text-xl font-bold">&times;</button>
                </div>

                <form action="{{ route('admin.ecosystem.domains.store') }}" method="POST" enctype="multipart/form-data" class="mt-6 space-y-5 text-xs">
                    @csrf
                    
                    {{-- Basic Info --}}
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="font-bold text-gray-700 block mb-1">Nama Domain (ID) *</label>
                            <input type="text" name="name_id" required placeholder="Contoh: Agrikultur & Ketahanan Pangan" class="w-full rounded-xl border border-gray-300 p-2.5">
                        </div>
                        <div>
                            <label class="font-bold text-gray-700 block mb-1">Nama Domain (EN) *</label>
                            <input type="text" name="name_en" required placeholder="Contoh: Agriculture & Food Security" class="w-full rounded-xl border border-gray-300 p-2.5">
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="font-bold text-gray-700 block mb-1">Slug URL (Opsional)</label>
                            <input type="text" name="slug" placeholder="Otomatis jika dikosongkan" class="w-full rounded-xl border border-gray-300 p-2.5">
                        </div>
                        <div>
                            <label class="font-bold text-gray-700 block mb-1">Tagline / Sub-judul Singkat</label>
                            <input type="text" name="tagline_id" placeholder="Kalimat visi penggerak pilar ini" class="w-full rounded-xl border border-gray-300 p-2.5">
                        </div>
                    </div>

                    <div>
                        <label class="font-bold text-gray-700 block mb-1">Deskripsi Ringkas</label>
                        <textarea name="short_description_id" rows="2" placeholder="Penjelasan singkat peran domain ini di masyarakat..." class="w-full rounded-xl border border-gray-300 p-2.5"></textarea>
                    </div>

                    {{-- VISUAL BRANDING & FILE UPLOADS (WAJIB UPLOAD) --}}
                    <div class="p-4 bg-teal-50/50 border border-teal-200 rounded-2xl space-y-4">
                        <span class="font-black text-[#005952] block text-xs uppercase tracking-wider">Visual Branding, Icon & Banner (Upload File)</span>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label class="font-bold text-gray-700 block mb-1">Upload File Icon / Logo Domain</label>
                                <input type="file" name="icon_file" accept="image/*" class="w-full text-xs text-gray-500 file:mr-2 file:py-1.5 file:px-3 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-[#005952] file:text-white hover:file:bg-[#004741] border border-gray-300 rounded-xl p-1 bg-white">
                                <span class="text-[10px] text-gray-400 mt-1 block">Atau URL Gambar Icon:</span>
                                <input type="url" name="icon_image" placeholder="https://..." class="w-full rounded-xl border border-gray-300 p-2 text-xs mt-0.5">
                            </div>
                            <div>
                                <label class="font-bold text-gray-700 block mb-1">Upload File Cover / Hero Banner</label>
                                <input type="file" name="cover_file" accept="image/*" class="w-full text-xs text-gray-500 file:mr-2 file:py-1.5 file:px-3 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-[#005952] file:text-white hover:file:bg-[#004741] border border-gray-300 rounded-xl p-1 bg-white">
                                <span class="text-[10px] text-gray-400 mt-1 block">Atau URL Banner:</span>
                                <input type="url" name="cover_image" placeholder="https://..." class="w-full rounded-xl border border-gray-300 p-2 text-xs mt-0.5">
                            </div>
                        </div>
                    </div>

                    {{-- DOKUMENTASI & GALERI FOTO (WAJIB UPLOAD) --}}
                    <div class="p-4 bg-purple-50/40 border border-purple-200 rounded-2xl space-y-3">
                        <span class="font-black text-purple-950 block text-xs uppercase tracking-wider">Upload Galeri Foto Lapangan & Dokumentasi</span>
                        <div>
                            <label class="font-bold text-gray-700 block mb-1">Pilih File Foto Galeri (Bisa pilih banyak sekaligus) *</label>
                            <input type="file" name="gallery_files[]" multiple accept="image/*" class="w-full text-xs text-gray-500 file:mr-2 file:py-1.5 file:px-3 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-purple-700 file:text-white hover:file:bg-purple-800 border border-purple-200 rounded-xl p-1 bg-white">
                            <span class="text-[10px] text-purple-700 mt-1 block">Pilih foto dokumentasi kegiatan lapangan untuk ditampilkan pada galeri publik.</span>
                        </div>
                        <div>
                            <label class="font-bold text-gray-700 block mb-1">Atau Tautan Foto Tambahan (1 URL per baris)</label>
                            <textarea name="gallery_raw" rows="2" placeholder="https://images.unsplash.com/...&#10;https://images.unsplash.com/..." class="w-full rounded-xl border border-purple-200 p-2 text-xs font-mono"></textarea>
                        </div>
                    </div>

                    {{-- PROGRAM / PARTNER LOGOS --}}
                    <div class="p-4 bg-blue-50/40 border border-blue-200 rounded-2xl space-y-3">
                        <span class="font-black text-blue-950 block text-xs uppercase tracking-wider">Logo Program Lain & Mitra Terkait</span>
                        <div>
                            <label class="font-bold text-gray-700 block mb-1">Upload File Logo Program / Mitra (Bisa banyak sekaligus)</label>
                            <input type="file" name="program_logo_files[]" multiple accept="image/*" class="w-full text-xs text-gray-500 file:mr-2 file:py-1.5 file:px-3 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-blue-700 file:text-white hover:file:bg-blue-800 border border-blue-200 rounded-xl p-1 bg-white">
                        </div>
                        <div>
                            <label class="font-bold text-gray-700 block mb-1">Atau URL Logo Program (1 per baris)</label>
                            <textarea name="program_logos_raw" rows="2" placeholder="https://...&#10;https://..." class="w-full rounded-xl border border-blue-200 p-2 text-xs font-mono"></textarea>
                        </div>
                    </div>

                    {{-- SDGS ALIGNMENT --}}
                    <div class="p-4 bg-amber-50/50 border border-amber-200 rounded-2xl space-y-3">
                        <span class="font-black text-amber-950 block text-xs uppercase tracking-wider">Keterkaitan SDGs (Tujuan Pembangunan Berkelanjutan)</span>
                        <div>
                            <label class="font-bold text-gray-700 block mb-1">Input SDGs Terkait (Pisahkan dengan koma atau baris baru)</label>
                            <textarea name="sdgs_raw" rows="2" placeholder="Contoh: SDG 2: Tanpa Kelaparan, SDG 8: Pekerjaan Layak, SDG 9: Industri & Inovasi, SDG 12: Konsumsi Bertanggung Jawab" class="w-full rounded-xl border border-amber-300 p-2.5 text-xs"></textarea>
                            <span class="text-[10px] text-amber-800 mt-1 block">Sebutkan nomor atau nama SDG yang menjadi fokus dampak pilar domain ini.</span>
                        </div>
                    </div>

                    {{-- CORE PROBLEM & SOLUTION DIRECTION --}}
                    <div class="space-y-4">
                        <div class="p-4 bg-red-50/60 border border-red-200 rounded-2xl space-y-2">
                            <label class="font-black text-red-900 block text-xs uppercase tracking-wider">
                                Tantangan Makro & Isu Lapangan yang Dihadapi *
                            </label>
                            <textarea name="problem_statement_id" required rows="3" placeholder="Uraikan problem riil di lapangan/sektor ini yang mendesak untuk diselesaikan..." class="w-full rounded-xl border border-red-300 p-2.5 text-xs"></textarea>
                        </div>

                        <div class="p-4 bg-emerald-50/60 border border-emerald-200 rounded-2xl space-y-2">
                            <label class="font-black text-[#005952] block text-xs uppercase tracking-wider">
                                Solusi Strategis Ekosistem Kita (Tunjukkan Solusi Kami) *
                            </label>
                            <textarea name="solution_statement_id" required rows="3" placeholder="Tunjukkan dengan jelas bagaimana ekosistem kami hadir merekayasa solusi konkrit..." class="w-full rounded-xl border border-emerald-300 p-2.5 text-xs"></textarea>
                        </div>

                        <div class="p-4 bg-gray-50 border border-gray-200 rounded-2xl space-y-2">
                            <label class="font-bold text-gray-700 block text-xs uppercase tracking-wider">
                                Rincian Isu-Isu Spesifik & Solusi Nyata (Format: Isu :: Solusi)
                            </label>
                            <textarea name="issues_raw" rows="3" placeholder="Contoh:&#10;Rantai pasok panjang tengkulak :: Platform marketplace langsung dari gabungan kelompok tani&#10;Timbulan sampah plastik :: Kemasan sirkular bio-material lokal" class="w-full rounded-xl border border-gray-300 p-2.5 text-xs font-mono"></textarea>
                            <span class="text-[10px] text-gray-500">Tulis satu per baris dengan format: [Nama Isu] :: [Solusi Ekosistem].</span>
                        </div>
                    </div>

                    {{-- Status, Visibility & Sort Order --}}
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 pt-2">
                        <div>
                            <label class="font-bold text-gray-700 block mb-1">Status Domain</label>
                            <select name="status" class="w-full rounded-xl border border-gray-300 p-2.5">
                                <option value="OPERATING">OPERATING</option>
                                <option value="BUILDING">BUILDING</option>
                                <option value="DEVELOPING">DEVELOPING</option>
                                <option value="PLANNING">PLANNING</option>
                                <option value="IDEA">IDEA</option>
                                <option value="COMPLETED">COMPLETED</option>
                            </select>
                        </div>
                        <div>
                            <label class="font-bold text-gray-700 block mb-1">Visibilitas</label>
                            <select name="visibility" class="w-full rounded-xl border border-gray-300 p-2.5">
                                <option value="public">Public</option>
                                <option value="draft">Draft</option>
                                <option value="private">Private</option>
                            </select>
                        </div>
                        <div>
                            <label class="font-bold text-gray-700 block mb-1">Urutan Sort</label>
                            <input type="number" name="sort_order" value="0" class="w-full rounded-xl border border-gray-300 p-2.5">
                        </div>
                    </div>

                    <div class="pt-4 border-t border-gray-100 flex items-center justify-end gap-3">
                        <button type="button" @click="createDomainModal = false" class="px-4 py-2 rounded-xl border border-gray-300 text-gray-700 font-bold">Batal</button>
                        <button type="submit" class="px-5 py-2.5 rounded-xl bg-[#005952] text-white font-bold shadow-sm">Simpan Domain</button>
                    </div>
                </form>
            </div>
        </div>

        {{-- MODAL: EDIT DOMAIN MAKRO --}}
        <div x-show="editDomainModal" x-cloak class="fixed inset-0 z-50 overflow-y-auto bg-black/50 backdrop-blur-xs flex items-center justify-center p-4">
            <div @click.away="editDomainModal = false" class="bg-white rounded-3xl max-w-3xl w-full p-6 sm:p-8 shadow-2xl max-h-[90vh] overflow-y-auto">
                <div class="flex items-center justify-between pb-4 border-b border-gray-100">
                    <div>
                        <h3 class="text-lg font-black text-gray-900">Edit Domain Makro Ekosistem</h3>
                        <p class="text-xs text-gray-500">Perbarui informasi, foto-foto dokumentasi, SDGs dan pemetaan solusi isu domain.</p>
                    </div>
                    <button @click="editDomainModal = false" class="text-gray-400 hover:text-gray-600 text-xl font-bold">&times;</button>
                </div>

                <form :action="'{{ url('admin/ecosystem/domains') }}/' + selectedDomain.id" method="POST" enctype="multipart/form-data" class="mt-6 space-y-5 text-xs">
                    @csrf
                    @method('PUT')
                    
                    {{-- Basic Info --}}
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="font-bold text-gray-700 block mb-1">Nama Domain (ID) *</label>
                            <input type="text" name="name_id" x-model="selectedDomain.name_id" required class="w-full rounded-xl border border-gray-300 p-2.5">
                        </div>
                        <div>
                            <label class="font-bold text-gray-700 block mb-1">Nama Domain (EN) *</label>
                            <input type="text" name="name_en" x-model="selectedDomain.name_en" required class="w-full rounded-xl border border-gray-300 p-2.5">
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="font-bold text-gray-700 block mb-1">Slug URL *</label>
                            <input type="text" name="slug" x-model="selectedDomain.slug" required class="w-full rounded-xl border border-gray-300 p-2.5">
                        </div>
                        <div>
                            <label class="font-bold text-gray-700 block mb-1">Tagline / Sub-judul Singkat</label>
                            <input type="text" name="tagline_id" x-model="selectedDomain.tagline_id" class="w-full rounded-xl border border-gray-300 p-2.5">
                        </div>
                    </div>

                    <div>
                        <label class="font-bold text-gray-700 block mb-1">Deskripsi Ringkas</label>
                        <textarea name="short_description_id" x-model="selectedDomain.short_description_id" rows="2" class="w-full rounded-xl border border-gray-300 p-2.5"></textarea>
                    </div>

                    {{-- VISUAL BRANDING & FILE UPLOADS (WAJIB UPLOAD) --}}
                    <div class="p-4 bg-teal-50/50 border border-teal-200 rounded-2xl space-y-4">
                        <span class="font-black text-[#005952] block text-xs uppercase tracking-wider">Visual Branding, Icon & Banner (Upload File)</span>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label class="font-bold text-gray-700 block mb-1">Upload File Icon / Logo Domain</label>
                                <template x-if="selectedDomain.icon_image">
                                    <div class="flex items-center gap-2 mb-2 p-2 bg-white rounded-xl border border-gray-200 shadow-2xs">
                                        <img :src="selectedDomain.icon_image" alt="Icon" class="w-8 h-8 object-contain rounded-lg">
                                        <span class="text-[10px] text-gray-500 font-semibold truncate">Icon Terpasang</span>
                                    </div>
                                </template>
                                <input type="file" name="icon_file" accept="image/*" class="w-full text-xs text-gray-500 file:mr-2 file:py-1.5 file:px-3 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-[#005952] file:text-white hover:file:bg-[#004741] border border-gray-300 rounded-xl p-1 bg-white">
                                <span class="text-[10px] text-gray-400 mt-1 block">Atau URL Gambar Icon:</span>
                                <input type="url" name="icon_image" x-model="selectedDomain.icon_image" placeholder="https://..." class="w-full rounded-xl border border-gray-300 p-2 text-xs mt-0.5">
                            </div>
                            <div>
                                <label class="font-bold text-gray-700 block mb-1">Upload File Cover / Hero Banner</label>
                                <template x-if="selectedDomain.cover_image">
                                    <div class="flex items-center gap-2 mb-2 p-2 bg-white rounded-xl border border-gray-200 shadow-2xs">
                                        <img :src="selectedDomain.cover_image" alt="Cover" class="w-12 h-7 object-cover rounded-md">
                                        <span class="text-[10px] text-gray-500 font-semibold truncate">Cover Terpasang</span>
                                    </div>
                                </template>
                                <input type="file" name="cover_file" accept="image/*" class="w-full text-xs text-gray-500 file:mr-2 file:py-1.5 file:px-3 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-[#005952] file:text-white hover:file:bg-[#004741] border border-gray-300 rounded-xl p-1 bg-white">
                                <span class="text-[10px] text-gray-400 mt-1 block">Atau URL Banner:</span>
                                <input type="url" name="cover_image" x-model="selectedDomain.cover_image" placeholder="https://..." class="w-full rounded-xl border border-gray-300 p-2 text-xs mt-0.5">
                            </div>
                        </div>
                    </div>

                    {{-- DOKUMENTASI & GALERI FOTO (WAJIB UPLOAD) --}}
                    <div class="p-4 bg-purple-50/40 border border-purple-200 rounded-2xl space-y-3">
                        <span class="font-black text-purple-950 block text-xs uppercase tracking-wider">Upload Galeri Foto Lapangan & Dokumentasi</span>
                        <template x-if="selectedDomain.gallery && selectedDomain.gallery.length > 0">
                            <div>
                                <span class="text-[10px] font-bold text-purple-900 block mb-1.5">Foto Galeri Saat Ini:</span>
                                <div class="flex flex-wrap gap-2 mb-2">
                                    <template x-for="(photo, pIdx) in selectedDomain.gallery" :key="pIdx">
                                        <div class="w-14 h-10 rounded-lg overflow-hidden border border-purple-200 bg-white">
                                            <img :src="photo" class="w-full h-full object-cover">
                                        </div>
                                    </template>
                                </div>
                            </div>
                        </template>
                        <div>
                            <label class="font-bold text-gray-700 block mb-1">Upload Tambahan Foto Galeri (Bisa banyak sekaligus)</label>
                            <input type="file" name="gallery_files[]" multiple accept="image/*" class="w-full text-xs text-gray-500 file:mr-2 file:py-1.5 file:px-3 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-purple-700 file:text-white hover:file:bg-purple-800 border border-purple-200 rounded-xl p-1 bg-white">
                        </div>
                        <div>
                            <label class="font-bold text-gray-700 block mb-1">Daftar URL Foto Galeri (1 per baris, bisa diedit langsung)</label>
                            <textarea name="gallery_raw" x-model="selectedDomain.gallery_raw" rows="3" class="w-full rounded-xl border border-purple-200 p-2 text-xs font-mono"></textarea>
                        </div>
                    </div>

                    {{-- PROGRAM / PARTNER LOGOS --}}
                    <div class="p-4 bg-blue-50/40 border border-blue-200 rounded-2xl space-y-3">
                        <span class="font-black text-blue-950 block text-xs uppercase tracking-wider">Logo Program Lain & Mitra Terkait</span>
                        <template x-if="selectedDomain.program_logos && selectedDomain.program_logos.length > 0">
                            <div class="flex flex-wrap gap-2 mb-2">
                                <template x-for="(pLogo, lIdx) in selectedDomain.program_logos" :key="lIdx">
                                    <img :src="pLogo" class="h-6 max-w-[70px] object-contain bg-white rounded border border-blue-200 p-0.5">
                                </template>
                            </div>
                        </template>
                        <div>
                            <label class="font-bold text-gray-700 block mb-1">Upload Tambahan Logo Program / Mitra</label>
                            <input type="file" name="program_logo_files[]" multiple accept="image/*" class="w-full text-xs text-gray-500 file:mr-2 file:py-1.5 file:px-3 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-blue-700 file:text-white hover:file:bg-blue-800 border border-blue-200 rounded-xl p-1 bg-white">
                        </div>
                        <div>
                            <label class="font-bold text-gray-700 block mb-1">Daftar URL Logo Program (1 per baris)</label>
                            <textarea name="program_logos_raw" x-model="selectedDomain.program_logos_raw" rows="2" class="w-full rounded-xl border border-blue-200 p-2 text-xs font-mono"></textarea>
                        </div>
                    </div>

                    {{-- SDGS ALIGNMENT --}}
                    <div class="p-4 bg-amber-50/50 border border-amber-200 rounded-2xl space-y-3">
                        <span class="font-black text-amber-950 block text-xs uppercase tracking-wider">Keterkaitan SDGs (Tujuan Pembangunan Berkelanjutan)</span>
                        <div>
                            <label class="font-bold text-gray-700 block mb-1">Input SDGs Terkait (Pisahkan koma atau baris baru)</label>
                            <textarea name="sdgs_raw" x-model="selectedDomain.sdgs_raw" rows="2" class="w-full rounded-xl border border-amber-300 p-2.5 text-xs"></textarea>
                        </div>
                    </div>

                    {{-- CORE PROBLEM & SOLUTION DIRECTION --}}
                    <div class="space-y-4">
                        <div class="p-4 bg-red-50/60 border border-red-200 rounded-2xl space-y-2">
                            <label class="font-black text-red-900 block text-xs uppercase tracking-wider">
                                Tantangan Makro & Isu Lapangan yang Dihadapi *
                            </label>
                            <textarea name="problem_statement_id" x-model="selectedDomain.problem_statement_id" required rows="3" class="w-full rounded-xl border border-red-300 p-2.5 text-xs"></textarea>
                        </div>

                        <div class="p-4 bg-emerald-50/60 border border-emerald-200 rounded-2xl space-y-2">
                            <label class="font-black text-[#005952] block text-xs uppercase tracking-wider">
                                Solusi Strategis Ekosistem Kita (Tunjukkan Solusi Kami) *
                            </label>
                            <textarea name="solution_statement_id" x-model="selectedDomain.solution_statement_id" required rows="3" class="w-full rounded-xl border border-emerald-300 p-2.5 text-xs"></textarea>
                        </div>

                        <div class="p-4 bg-gray-50 border border-gray-200 rounded-2xl space-y-2">
                            <label class="font-bold text-gray-700 block text-xs uppercase tracking-wider">
                                Rincian Isu-Isu Spesifik & Solusi Nyata (Format: Isu :: Solusi)
                            </label>
                            <textarea name="issues_raw" x-model="selectedDomain.issues_raw" rows="3" class="w-full rounded-xl border border-gray-300 p-2.5 text-xs font-mono"></textarea>
                            <span class="text-[10px] text-gray-500">Tulis satu per baris dengan format: [Nama Isu] :: [Solusi Ekosistem].</span>
                        </div>
                    </div>

                    {{-- Status, Visibility & Sort Order --}}
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 pt-2">
                        <div>
                            <label class="font-bold text-gray-700 block mb-1">Status Domain</label>
                            <select name="status" x-model="selectedDomain.status" class="w-full rounded-xl border border-gray-300 p-2.5">
                                <option value="OPERATING">OPERATING</option>
                                <option value="BUILDING">BUILDING</option>
                                <option value="DEVELOPING">DEVELOPING</option>
                                <option value="PLANNING">PLANNING</option>
                                <option value="IDEA">IDEA</option>
                                <option value="COMPLETED">COMPLETED</option>
                            </select>
                        </div>
                        <div>
                            <label class="font-bold text-gray-700 block mb-1">Visibilitas</label>
                            <select name="visibility" x-model="selectedDomain.visibility" class="w-full rounded-xl border border-gray-300 p-2.5">
                                <option value="public">Public</option>
                                <option value="draft">Draft</option>
                                <option value="private">Private</option>
                            </select>
                        </div>
                        <div>
                            <label class="font-bold text-gray-700 block mb-1">Urutan Sort</label>
                            <input type="number" name="sort_order" x-model="selectedDomain.sort_order" class="w-full rounded-xl border border-gray-300 p-2.5">
                        </div>
                    </div>

                    <div class="pt-4 border-t border-gray-100 flex items-center justify-end gap-3">
                        <button type="button" @click="editDomainModal = false" class="px-4 py-2 rounded-xl border border-gray-300 text-gray-700 font-bold">Batal</button>
                        <button type="submit" class="px-5 py-2.5 rounded-xl bg-[#005952] text-white font-bold shadow-sm">Perbarui Domain</button>
                    </div>
                </form>
            </div>
        </div>

        {{-- ========================================================= --}}
        {{-- MODAL: TAMBAH DOKUMEN / LAPORAN ESG                       --}}
        {{-- ========================================================= --}}
        <div x-show="createDocumentModal" x-cloak class="fixed inset-0 z-50 overflow-y-auto bg-black/50 backdrop-blur-xs flex items-center justify-center p-4">
            <div @click.away="createDocumentModal = false" class="bg-white rounded-3xl max-w-2xl w-full p-6 sm:p-8 shadow-2xl max-h-[90vh] overflow-y-auto">
                <div class="flex items-center justify-between pb-4 border-b border-gray-100">
                    <div>
                        <h3 class="text-lg font-black text-gray-900">Tambah Dokumen / Laporan ESG</h3>
                        <p class="text-xs text-gray-500">Unggah berkas PDF atau tautan dokumen publikasi. Gambar sampul (cover) wajib ada.</p>
                    </div>
                    <button @click="createDocumentModal = false" class="text-gray-400 hover:text-gray-600 text-xl font-bold">&times;</button>
                </div>

                <form action="{{ route('admin.ecosystem.documents.store') }}" method="POST" enctype="multipart/form-data" class="mt-6 space-y-4 text-xs">
                    @csrf
                    
                    {{-- Judul Bebas --}}
                    <div>
                        <label class="font-bold text-gray-700 block mb-1">Judul Dokumen / Laporan * (Bebas)</label>
                        <input type="text" name="title_id" required placeholder="Contoh: Laporan Keberlanjutan & Dampak ESG 2025/2026" class="w-full rounded-xl border border-gray-300 p-2.5">
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="font-bold text-gray-700 block mb-1">Judul Bahasa Inggris (Opsional)</label>
                            <input type="text" name="title_en" placeholder="Contoh: Sustainability & ESG Impact Report 2025/2026" class="w-full rounded-xl border border-gray-300 p-2.5">
                        </div>
                        <div>
                            <label class="font-bold text-gray-700 block mb-1">Kategori Dokumen *</label>
                            <select name="category" required class="w-full rounded-xl border border-gray-300 p-2.5">
                                <option value="Laporan ESG">Laporan ESG</option>
                                <option value="Whitepaper">Whitepaper</option>
                                <option value="Katalog Program">Katalog Program</option>
                                <option value="Audit Dampak">Audit Dampak</option>
                                <option value="Riset Kebijakan">Riset Kebijakan</option>
                                <option value="Lainnya">Lainnya</option>
                            </select>
                        </div>
                    </div>

                    {{-- Cover Image (Wajib) --}}
                    <div class="p-4 bg-teal-50/60 border border-teal-200 rounded-2xl space-y-3">
                        <label class="font-black text-[#005952] block text-xs uppercase tracking-wider">
                            Gambar Sampul / Cover Image * (WAJIB ADA COVER)
                        </label>
                        <p class="text-[11px] text-gray-500">Unggah foto sampul berkas atau masukkan URL gambar langsung. Disarankan rasio buku/laporan (3:4 atau 16:9).</p>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                            <div>
                                <label class="text-gray-700 font-bold block mb-1">Unggah Berkas Gambar Sampul</label>
                                <input type="file" name="cover_file" accept="image/*" class="w-full text-xs text-gray-600 file:mr-2 file:py-2 file:px-3 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-[#005952] file:text-white hover:file:bg-[#004741]">
                            </div>
                            <div>
                                <label class="text-gray-700 font-bold block mb-1">Atau URL Gambar Sampul</label>
                                <input type="url" name="cover_image" placeholder="https://images.unsplash.com/..." class="w-full rounded-xl border border-gray-300 p-2.5">
                            </div>
                        </div>
                    </div>

                    {{-- Document Type & File / Link --}}
                    <div x-data="{ docType: 'pdf' }" class="p-4 bg-gray-50 border border-gray-200 rounded-2xl space-y-3">
                        <label class="font-bold text-gray-800 block text-xs uppercase tracking-wider">
                            Tipe Berkas & Sumber Dokumen *
                        </label>
                        <div class="flex items-center gap-4">
                            <label class="flex items-center gap-2 cursor-pointer font-bold text-gray-700">
                                <input type="radio" name="file_type" value="pdf" x-model="docType" class="text-[#005952] focus:ring-[#005952]">
                                <span>File PDF (Upload Langsung)</span>
                            </label>
                            <label class="flex items-center gap-2 cursor-pointer font-bold text-gray-700">
                                <input type="radio" name="file_type" value="link" x-model="docType" class="text-[#005952] focus:ring-[#005952]">
                                <span>Tautan Eksternal (Link / Cloud URL)</span>
                            </label>
                        </div>

                        {{-- Input PDF --}}
                        <div x-show="docType === 'pdf'" class="space-y-2 pt-2">
                            <label class="text-gray-700 font-bold block mb-1">Unggah Berkas PDF (Maks. 50 MB)</label>
                            <input type="file" name="document_file" accept=".pdf,.doc,.docx" class="w-full text-xs text-gray-600 file:mr-2 file:py-2 file:px-3 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-gray-800 file:text-white">
                            <span class="text-[10px] text-gray-400 block">Ukuran file akan dihitung otomatis saat diunggah.</span>
                        </div>

                        {{-- Input Tautan Eksternal --}}
                        <div x-show="docType === 'link'" class="space-y-2 pt-2">
                            <label class="text-gray-700 font-bold block mb-1">Tautan / URL Berkas Eksternal</label>
                            <input type="url" name="file_url" placeholder="https://siyota.org/reports/laporan.pdf atau Google Drive" class="w-full rounded-xl border border-gray-300 p-2.5">
                            <div>
                                <label class="text-gray-700 font-bold block mb-1">Keterangan / Teks Label Tautan (Opsional)</label>
                                <input type="text" name="file_size" placeholder="Contoh: Tautan Interaktif atau PDF 4.2 MB" class="w-full rounded-xl border border-gray-300 p-2.5">
                            </div>
                        </div>
                    </div>

                    {{-- Tahun & Deskripsi --}}
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="font-bold text-gray-700 block mb-1">Tahun Publikasi</label>
                            <input type="text" name="year" value="{{ date('Y') }}" placeholder="2026" class="w-full rounded-xl border border-gray-300 p-2.5">
                        </div>
                        <div>
                            <label class="font-bold text-gray-700 block mb-1">Urutan Sort</label>
                            <input type="number" name="sort_order" value="0" class="w-full rounded-xl border border-gray-300 p-2.5">
                        </div>
                    </div>

                    <div>
                        <label class="font-bold text-gray-700 block mb-1">Ringkasan / Deskripsi Dokumen</label>
                        <textarea name="description_id" rows="3" placeholder="Jelaskan ringkas isi dokumen atau cakupan audit laporan..." class="w-full rounded-xl border border-gray-300 p-2.5"></textarea>
                    </div>

                    <div class="pt-2">
                        <label class="flex items-center gap-2 cursor-pointer text-xs font-bold text-gray-800">
                            <input type="checkbox" name="is_active" value="1" checked class="rounded border-gray-300 text-[#005952] focus:ring-[#005952]">
                            <span>Tampilkan Aktif di Seksi Publik (#impact)</span>
                        </label>
                    </div>

                    <div class="pt-4 border-t border-gray-100 flex items-center justify-end gap-3">
                        <button type="button" @click="createDocumentModal = false" class="px-4 py-2 rounded-xl border border-gray-300 text-gray-700 font-bold">Batal</button>
                        <button type="submit" class="px-5 py-2.5 rounded-xl bg-[#005952] text-white font-bold shadow-sm">Simpan Dokumen Publikasi</button>
                    </div>
                </form>
            </div>
        </div>

        {{-- ========================================================= --}}
        {{-- MODAL: EDIT DOKUMEN / LAPORAN ESG                         --}}
        {{-- ========================================================= --}}
        <div x-show="editDocumentModal" x-cloak class="fixed inset-0 z-50 overflow-y-auto bg-black/50 backdrop-blur-xs flex items-center justify-center p-4">
            <div @click.away="editDocumentModal = false" class="bg-white rounded-3xl max-w-2xl w-full p-6 sm:p-8 shadow-2xl max-h-[90vh] overflow-y-auto">
                <div class="flex items-center justify-between pb-4 border-b border-gray-100">
                    <div>
                        <h3 class="text-lg font-black text-gray-900">Edit Dokumen / Laporan ESG</h3>
                        <p class="text-xs text-gray-500">Perbarui rincian dokumen, sampul (cover), atau berkas tautan.</p>
                    </div>
                    <button @click="editDocumentModal = false" class="text-gray-400 hover:text-gray-600 text-xl font-bold">&times;</button>
                </div>

                <form :action="'{{ url('admin/ecosystem/documents') }}/' + selectedDocument.id" method="POST" enctype="multipart/form-data" class="mt-6 space-y-4 text-xs">
                    @csrf
                    @method('PUT')
                    
                    {{-- Judul Bebas --}}
                    <div>
                        <label class="font-bold text-gray-700 block mb-1">Judul Dokumen / Laporan * (Bebas)</label>
                        <input type="text" name="title_id" x-model="selectedDocument.title_id" required class="w-full rounded-xl border border-gray-300 p-2.5">
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="font-bold text-gray-700 block mb-1">Judul Bahasa Inggris (Opsional)</label>
                            <input type="text" name="title_en" x-model="selectedDocument.title_en" class="w-full rounded-xl border border-gray-300 p-2.5">
                        </div>
                        <div>
                            <label class="font-bold text-gray-700 block mb-1">Kategori Dokumen *</label>
                            <select name="category" x-model="selectedDocument.category" required class="w-full rounded-xl border border-gray-300 p-2.5">
                                <option value="Laporan ESG">Laporan ESG</option>
                                <option value="Whitepaper">Whitepaper</option>
                                <option value="Katalog Program">Katalog Program</option>
                                <option value="Audit Dampak">Audit Dampak</option>
                                <option value="Riset Kebijakan">Riset Kebijakan</option>
                                <option value="Lainnya">Lainnya</option>
                            </select>
                        </div>
                    </div>

                    {{-- Cover Image (Wajib) --}}
                    <div class="p-4 bg-teal-50/60 border border-teal-200 rounded-2xl space-y-3">
                        <label class="font-black text-[#005952] block text-xs uppercase tracking-wider">
                            Gambar Sampul / Cover Image * (WAJIB ADA COVER)
                        </label>
                        <div class="flex items-center gap-3">
                            <template x-if="selectedDocument.cover_image">
                                <div class="w-16 h-20 rounded-lg overflow-hidden border border-gray-200 shrink-0 bg-gray-950">
                                    <img :src="selectedDocument.cover_image" alt="Cover Preview" class="w-full h-full object-cover">
                                </div>
                            </template>
                            <div class="space-y-2 flex-1">
                                <label class="text-gray-700 font-bold block">Ganti Berkas Gambar Sampul</label>
                                <input type="file" name="cover_file" accept="image/*" class="w-full text-xs text-gray-600 file:mr-2 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-bold file:bg-[#005952] file:text-white">
                                <input type="url" name="cover_image" x-model="selectedDocument.cover_image" placeholder="Atau URL Gambar..." class="w-full rounded-xl border border-gray-300 p-2">
                            </div>
                        </div>
                    </div>

                    {{-- Document Type & File / Link --}}
                    <div class="p-4 bg-gray-50 border border-gray-200 rounded-2xl space-y-3">
                        <label class="font-bold text-gray-800 block text-xs uppercase tracking-wider">
                            Tipe Berkas & Sumber Dokumen *
                        </label>
                        <div class="flex items-center gap-4">
                            <label class="flex items-center gap-2 cursor-pointer font-bold text-gray-700">
                                <input type="radio" name="file_type" value="pdf" x-model="selectedDocument.file_type" class="text-[#005952] focus:ring-[#005952]">
                                <span>File PDF</span>
                            </label>
                            <label class="flex items-center gap-2 cursor-pointer font-bold text-gray-700">
                                <input type="radio" name="file_type" value="link" x-model="selectedDocument.file_type" class="text-[#005952] focus:ring-[#005952]">
                                <span>Tautan Eksternal</span>
                            </label>
                        </div>

                        {{-- Input PDF --}}
                        <div x-show="selectedDocument.file_type === 'pdf'" class="space-y-2 pt-2">
                            <template x-if="selectedDocument.file_path">
                                <p class="text-[11px] text-gray-600 font-mono truncate">Berkas saat ini: <span x-text="selectedDocument.file_path" class="text-[#005952]"></span></p>
                            </template>
                            <label class="text-gray-700 font-bold block mb-1">Ganti Berkas PDF</label>
                            <input type="file" name="document_file" accept=".pdf,.doc,.docx" class="w-full text-xs text-gray-600 file:mr-2 file:py-2 file:px-3 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-gray-800 file:text-white">
                        </div>

                        {{-- Input Tautan Eksternal --}}
                        <div x-show="selectedDocument.file_type === 'link'" class="space-y-2 pt-2">
                            <label class="text-gray-700 font-bold block mb-1">Tautan / URL Berkas Eksternal</label>
                            <input type="url" name="file_url" x-model="selectedDocument.file_url" placeholder="https://..." class="w-full rounded-xl border border-gray-300 p-2.5">
                            <div>
                                <label class="text-gray-700 font-bold block mb-1">Keterangan / Label Tautan</label>
                                <input type="text" name="file_size" x-model="selectedDocument.file_size" placeholder="Contoh: Tautan Interaktif" class="w-full rounded-xl border border-gray-300 p-2.5">
                            </div>
                        </div>
                    </div>

                    {{-- Tahun & Deskripsi --}}
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="font-bold text-gray-700 block mb-1">Tahun Publikasi</label>
                            <input type="text" name="year" x-model="selectedDocument.year" class="w-full rounded-xl border border-gray-300 p-2.5">
                        </div>
                        <div>
                            <label class="font-bold text-gray-700 block mb-1">Urutan Sort</label>
                            <input type="number" name="sort_order" x-model="selectedDocument.sort_order" class="w-full rounded-xl border border-gray-300 p-2.5">
                        </div>
                    </div>

                    <div>
                        <label class="font-bold text-gray-700 block mb-1">Ringkasan / Deskripsi Dokumen</label>
                        <textarea name="description_id" x-model="selectedDocument.description_id" rows="3" class="w-full rounded-xl border border-gray-300 p-2.5"></textarea>
                    </div>

                    <div class="pt-2">
                        <label class="flex items-center gap-2 cursor-pointer text-xs font-bold text-gray-800">
                            <input type="checkbox" name="is_active" value="1" :checked="selectedDocument.is_active" class="rounded border-gray-300 text-[#005952] focus:ring-[#005952]">
                            <span>Tampilkan Aktif di Seksi Publik (#impact)</span>
                        </label>
                    </div>

                    <div class="pt-4 border-t border-gray-100 flex items-center justify-end gap-3">
                        <button type="button" @click="editDocumentModal = false" class="px-4 py-2 rounded-xl border border-gray-300 text-gray-700 font-bold">Batal</button>
                        <button type="submit" class="px-5 py-2.5 rounded-xl bg-[#005952] text-white font-bold shadow-sm">Simpan Perubahan</button>
                    </div>
                </form>
            </div>
        </div>

        {{-- ========================================================= --}}
        {{-- MODAL: TAMBAH ANGKA STATISTIK DAMPAK                      --}}
        {{-- ========================================================= --}}
        <div x-show="createMetricModal" x-cloak class="fixed inset-0 z-50 overflow-y-auto bg-black/50 backdrop-blur-xs flex items-center justify-center p-4">
            <div @click.away="createMetricModal = false" class="bg-white rounded-3xl max-w-xl w-full p-6 sm:p-8 shadow-2xl max-h-[90vh] overflow-y-auto">
                <div class="flex items-center justify-between pb-4 border-b border-gray-100">
                    <div>
                        <h3 class="text-lg font-black text-gray-900">Tambah Angka Statistik Dampak</h3>
                        <p class="text-xs text-gray-500">Angka metrik capaian yang tampil di seksi atas halaman /dampak.</p>
                    </div>
                    <button @click="createMetricModal = false" class="text-gray-400 hover:text-gray-600 text-xl font-bold">&times;</button>
                </div>

                <form action="{{ route('admin.ecosystem.metrics.store') }}" method="POST" class="mt-6 space-y-4 text-xs">
                    @csrf
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="font-bold text-gray-700 block mb-1">Nilai Capaian / Angka *</label>
                            <input type="text" name="metric_value" required placeholder="Contoh: 50.000+, 9, 34, 100%" class="w-full rounded-xl border border-gray-300 p-2.5 font-mono font-bold">
                        </div>
                        <div>
                            <label class="font-bold text-gray-700 block mb-1">Ikon / Simbol</label>
                            <input type="text" name="icon" placeholder="Contoh: users, map, flag, sparkles" class="w-full rounded-xl border border-gray-300 p-2.5">
                        </div>
                    </div>

                    <div>
                        <label class="font-bold text-gray-700 block mb-1">Label Metrik (Bahasa Indonesia) *</label>
                        <input type="text" name="label_id" required placeholder="Contoh: Pemuda & Komunitas Terdampak" class="w-full rounded-xl border border-gray-300 p-2.5">
                    </div>

                    <div>
                        <label class="font-bold text-gray-700 block mb-1">Label Metrik (Bahasa Inggris)</label>
                        <input type="text" name="label_en" placeholder="Contoh: Youth & Communities Impacted" class="w-full rounded-xl border border-gray-300 p-2.5">
                    </div>

                    <div>
                        <label class="font-bold text-gray-700 block mb-1">Deskripsi Singkat (Bahasa Indonesia)</label>
                        <textarea name="description_id" rows="2" placeholder="Keterangan singkat konteks angka capaian..." class="w-full rounded-xl border border-gray-300 p-2.5"></textarea>
                    </div>

                    <div>
                        <label class="font-bold text-gray-700 block mb-1">Deskripsi Singkat (Bahasa Inggris)</label>
                        <textarea name="description_en" rows="2" placeholder="Brief context for international visitors..." class="w-full rounded-xl border border-gray-300 p-2.5"></textarea>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 items-center">
                        <div>
                            <label class="font-bold text-gray-700 block mb-1">Urutan Tampil (Sort)</label>
                            <input type="number" name="sort_order" value="0" class="w-full rounded-xl border border-gray-300 p-2.5">
                        </div>
                        <div class="pt-5">
                            <label class="flex items-center gap-2 cursor-pointer font-bold text-gray-800">
                                <input type="checkbox" name="is_active" value="1" checked class="rounded border-gray-300 text-[#005952] focus:ring-[#005952]">
                                <span>Tampilkan Aktif di /dampak</span>
                            </label>
                        </div>
                    </div>

                    <div class="pt-4 border-t border-gray-100 flex items-center justify-end gap-3">
                        <button type="button" @click="createMetricModal = false" class="px-4 py-2 rounded-xl border border-gray-300 text-gray-700 font-bold">Batal</button>
                        <button type="submit" class="px-5 py-2.5 rounded-xl bg-[#005952] text-white font-bold shadow-sm">Simpan Statistik</button>
                    </div>
                </form>
            </div>
        </div>

        {{-- ========================================================= --}}
        {{-- MODAL: EDIT ANGKA STATISTIK DAMPAK                        --}}
        {{-- ========================================================= --}}
        <div x-show="editMetricModal" x-cloak class="fixed inset-0 z-50 overflow-y-auto bg-black/50 backdrop-blur-xs flex items-center justify-center p-4">
            <div @click.away="editMetricModal = false" class="bg-white rounded-3xl max-w-xl w-full p-6 sm:p-8 shadow-2xl max-h-[90vh] overflow-y-auto">
                <div class="flex items-center justify-between pb-4 border-b border-gray-100">
                    <div>
                        <h3 class="text-lg font-black text-gray-900">Edit Angka Statistik Dampak</h3>
                        <p class="text-xs text-gray-500">Perbarui nilai metrik, label dwi-bahasa, atau urutan tampil.</p>
                    </div>
                    <button @click="editMetricModal = false" class="text-gray-400 hover:text-gray-600 text-xl font-bold">&times;</button>
                </div>

                <form :action="'{{ url('admin/ecosystem/metrics') }}/' + selectedMetric.id" method="POST" class="mt-6 space-y-4 text-xs">
                    @csrf
                    @method('PUT')
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="font-bold text-gray-700 block mb-1">Nilai Capaian / Angka *</label>
                            <input type="text" name="metric_value" x-model="selectedMetric.metric_value" required class="w-full rounded-xl border border-gray-300 p-2.5 font-mono font-bold">
                        </div>
                        <div>
                            <label class="font-bold text-gray-700 block mb-1">Ikon / Simbol</label>
                            <input type="text" name="icon" x-model="selectedMetric.icon" class="w-full rounded-xl border border-gray-300 p-2.5">
                        </div>
                    </div>

                    <div>
                        <label class="font-bold text-gray-700 block mb-1">Label Metrik (Bahasa Indonesia) *</label>
                        <input type="text" name="label_id" x-model="selectedMetric.label_id" required class="w-full rounded-xl border border-gray-300 p-2.5">
                    </div>

                    <div>
                        <label class="font-bold text-gray-700 block mb-1">Label Metrik (Bahasa Inggris)</label>
                        <input type="text" name="label_en" x-model="selectedMetric.label_en" class="w-full rounded-xl border border-gray-300 p-2.5">
                    </div>

                    <div>
                        <label class="font-bold text-gray-700 block mb-1">Deskripsi Singkat (Bahasa Indonesia)</label>
                        <textarea name="description_id" x-model="selectedMetric.description_id" rows="2" class="w-full rounded-xl border border-gray-300 p-2.5"></textarea>
                    </div>

                    <div>
                        <label class="font-bold text-gray-700 block mb-1">Deskripsi Singkat (Bahasa Inggris)</label>
                        <textarea name="description_en" x-model="selectedMetric.description_en" rows="2" class="w-full rounded-xl border border-gray-300 p-2.5"></textarea>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 items-center">
                        <div>
                            <label class="font-bold text-gray-700 block mb-1">Urutan Tampil (Sort)</label>
                            <input type="number" name="sort_order" x-model="selectedMetric.sort_order" class="w-full rounded-xl border border-gray-300 p-2.5">
                        </div>
                        <div class="pt-5">
                            <label class="flex items-center gap-2 cursor-pointer font-bold text-gray-800">
                                <input type="checkbox" name="is_active" value="1" :checked="selectedMetric.is_active" class="rounded border-gray-300 text-[#005952] focus:ring-[#005952]">
                                <span>Tampilkan Aktif di /dampak</span>
                            </label>
                        </div>
                    </div>

                    <div class="pt-4 border-t border-gray-100 flex items-center justify-end gap-3">
                        <button type="button" @click="editMetricModal = false" class="px-4 py-2 rounded-xl border border-gray-300 text-gray-700 font-bold">Batal</button>
                        <button type="submit" class="px-5 py-2.5 rounded-xl bg-[#005952] text-white font-bold shadow-sm">Simpan Perubahan</button>
                    </div>
                </form>
            </div>
        </div>

        {{-- ========================================================= --}}
        {{-- MODAL: EDIT PILAR, GALERI FOTO & METRIK                   --}}
        {{-- ========================================================= --}}
        <div x-show="editPillarModal" x-cloak class="fixed inset-0 z-50 overflow-y-auto bg-black/50 backdrop-blur-xs flex items-center justify-center p-4">
            <div @click.away="editPillarModal = false" class="bg-white rounded-3xl max-w-3xl w-full p-6 sm:p-8 shadow-2xl max-h-[90vh] overflow-y-auto">
                <div class="flex items-center justify-between pb-4 border-b border-gray-100">
                    <div>
                        <div class="flex items-center gap-2 mb-1">
                            <span class="px-2 py-0.5 rounded bg-teal-100 text-[#005952] font-mono text-[10px] font-bold" x-text="'PILAR #0' + selectedPillar.pillar_number"></span>
                            <span class="text-xs font-mono font-bold text-gray-500 uppercase" x-text="selectedPillar.name"></span>
                        </div>
                        <h3 class="text-lg font-black text-gray-900">Kelola Pilar Gerakan & Galeri Foto</h3>
                        <p class="text-xs text-gray-500">Perbarui rincian pilar, tautan SIYOTA, foto sampul, dan unggah dokumentasi galeri foto.</p>
                    </div>
                    <button @click="editPillarModal = false" class="text-gray-400 hover:text-gray-600 text-xl font-bold">&times;</button>
                </div>

                <form :action="'{{ url('admin/ecosystem/pillars') }}/' + selectedPillar.id" method="POST" enctype="multipart/form-data" class="mt-6 space-y-5 text-xs">
                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                        <div>
                            <label class="font-bold text-gray-700 block mb-1">Nama / Kategori Pilar *</label>
                            <input type="text" name="name" x-model="selectedPillar.name" required placeholder="Contoh: YOUTH DEVELOPMENT" class="w-full rounded-xl border border-gray-300 p-2.5 font-mono font-bold uppercase">
                        </div>
                        <div>
                            <label class="font-bold text-gray-700 block mb-1">Judul Pilar (ID) *</label>
                            <input type="text" name="title_id" x-model="selectedPillar.title_id" required class="w-full rounded-xl border border-gray-300 p-2.5">
                        </div>
                        <div>
                            <label class="font-bold text-gray-700 block mb-1">Judul Pilar (EN)</label>
                            <input type="text" name="title_en" x-model="selectedPillar.title_en" class="w-full rounded-xl border border-gray-300 p-2.5">
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="font-bold text-gray-700 block mb-1">Deskripsi Ringkas (ID) *</label>
                            <textarea name="description_id" x-model="selectedPillar.description_id" required rows="2" class="w-full rounded-xl border border-gray-300 p-2.5"></textarea>
                        </div>
                        <div>
                            <label class="font-bold text-gray-700 block mb-1">Deskripsi Ringkas (EN)</label>
                            <textarea name="description_en" x-model="selectedPillar.description_en" rows="2" class="w-full rounded-xl border border-gray-300 p-2.5"></textarea>
                        </div>
                    </div>

                    {{-- Kenapa Ada Pilar Ini? (Why It Matters) --}}
                    <div class="p-4 bg-amber-50/60 border border-amber-200 rounded-2xl space-y-3">
                        <div class="flex items-center gap-2">
                            <span class="w-2 h-2 rounded-full bg-amber-500"></span>
                            <span class="font-bold text-amber-950 block text-xs uppercase tracking-wider">Kenapa Ada Pilar Ini? (Latar Belakang & Urgensi Masalah)</span>
                        </div>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label class="font-bold text-gray-700 block mb-1">Alasan & Urgensi (Bahasa Indonesia)</label>
                                <textarea name="why_it_matters_id" x-model="selectedPillar.why_it_matters_id" rows="3" placeholder="Jelaskan kondisi riil, kesenjangan, atau masalah sosial/lingkungan di Indonesia yang melandasi pentingnya pilar ini..." class="w-full rounded-xl border border-amber-300 p-2.5 text-xs"></textarea>
                            </div>
                            <div>
                                <label class="font-bold text-gray-700 block mb-1">Alasan & Urgensi (English)</label>
                                <textarea name="why_it_matters_en" x-model="selectedPillar.why_it_matters_en" rows="3" placeholder="Explain the real-world gap or systemic challenge driving this pillar..." class="w-full rounded-xl border border-amber-300 p-2.5 text-xs"></textarea>
                            </div>
                        </div>
                    </div>

                    {{-- Kita Ngapain? (What We Do / Tangible Programs) --}}
                    <div class="p-4 bg-blue-50/60 border border-blue-200 rounded-2xl space-y-3">
                        <div class="flex items-center gap-2">
                            <span class="w-2 h-2 rounded-full bg-blue-500"></span>
                            <span class="font-bold text-blue-950 block text-xs uppercase tracking-wider">Kita Ngapain? (Aksi Nyata & Program Terpadu di Lapangan)</span>
                        </div>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label class="font-bold text-gray-700 block mb-1">Aksi & Solusi Lapangan (Bahasa Indonesia)</label>
                                <textarea name="what_we_do_id" x-model="selectedPillar.what_we_do_id" rows="3" placeholder="Jelaskan langkah konkret, program intervensi, pendampingan, dan aksi nyata yang dilakukan ekosistem bersama komunitas..." class="w-full rounded-xl border border-blue-300 p-2.5 text-xs"></textarea>
                            </div>
                            <div>
                                <label class="font-bold text-gray-700 block mb-1">Aksi & Solusi Lapangan (English)</label>
                                <textarea name="what_we_do_en" x-model="selectedPillar.what_we_do_en" rows="3" placeholder="Outline direct programs, grassroots enablement, and concrete initiatives executed..." class="w-full rounded-xl border border-blue-300 p-2.5 text-xs"></textarea>
                            </div>
                        </div>
                    </div>

                    {{-- SDGs PBB, Program Dunia & Agenda Nasional --}}
                    <div class="p-4 bg-emerald-50/60 border border-emerald-200 rounded-2xl space-y-3">
                        <div class="flex items-center gap-2">
                            <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                            <span class="font-bold text-emerald-950 block text-xs uppercase tracking-wider">Keterkaitan SDGs, Program Dunia & Agenda Nasional RI</span>
                        </div>
                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                            <div>
                                <label class="font-bold text-gray-700 block mb-1">SDGs PBB Terkait (1 per baris / koma)</label>
                                <textarea name="sdgs_raw" x-model="selectedPillar.sdgs_raw" rows="3" placeholder="SDG 4: Pendidikan Berkualitas&#10;SDG 8: Pekerjaan Layak" class="w-full rounded-xl border border-emerald-300 p-2 font-mono text-[11px]"></textarea>
                            </div>
                            <div>
                                <label class="font-bold text-gray-700 block mb-1">Program & Konvensi Dunia</label>
                                <textarea name="global_programs_raw" x-model="selectedPillar.global_programs_raw" rows="3" placeholder="UN Youth 2030 Strategy&#10;UNESCO Global Action" class="w-full rounded-xl border border-emerald-300 p-2 font-mono text-[11px]"></textarea>
                            </div>
                            <div>
                                <label class="font-bold text-gray-700 block mb-1">Agenda & Program Nasional RI</label>
                                <textarea name="national_programs_raw" x-model="selectedPillar.national_programs_raw" rows="3" placeholder="RPJMN 2025-2029&#10;Indonesia Emas 2045" class="w-full rounded-xl border border-emerald-300 p-2 font-mono text-[11px]"></textarea>
                            </div>
                        </div>
                        <div>
                            <label class="font-bold text-gray-700 block mb-1">Sasaran Penerima Manfaat</label>
                            <input type="text" name="target_beneficiaries" x-model="selectedPillar.target_beneficiaries" placeholder="Contoh: Pemuda desa, petani muda, UMKM lokal, dan relawan komunitas" class="w-full rounded-xl border border-emerald-300 p-2.5">
                        </div>
                    </div>

                    {{-- Metrik Khusus Pilar --}}
                    <div class="p-4 bg-teal-50/50 border border-teal-200 rounded-2xl space-y-3">
                        <span class="font-bold text-[#005952] block text-xs uppercase tracking-wider">Metrik Capaian Khusus Pilar Ini</span>
                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                            <div>
                                <label class="font-bold text-gray-700 block mb-1">Angka Metrik</label>
                                <input type="text" name="metric_value" x-model="selectedPillar.metric_value" placeholder="Contoh: 15.000+" class="w-full rounded-xl border border-teal-300 p-2 font-mono font-bold">
                            </div>
                            <div>
                                <label class="font-bold text-gray-700 block mb-1">Label Metrik (ID)</label>
                                <input type="text" name="metric_label_id" x-model="selectedPillar.metric_label_id" placeholder="Contoh: Pemuda Terlatih" class="w-full rounded-xl border border-teal-300 p-2">
                            </div>
                            <div>
                                <label class="font-bold text-gray-700 block mb-1">Label Metrik (EN)</label>
                                <input type="text" name="metric_label_en" x-model="selectedPillar.metric_label_en" placeholder="Contoh: Trained Youth" class="w-full rounded-xl border border-teal-300 p-2">
                            </div>
                        </div>
                    </div>

                    {{-- Target URL & Action Label --}}
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="font-bold text-gray-700 block mb-1">Tautan SIYOTA / Target URL *</label>
                            <input type="url" name="target_url" x-model="selectedPillar.target_url" required placeholder="https://siyota.org/..." class="w-full rounded-xl border border-gray-300 p-2.5">
                        </div>
                        <div>
                            <label class="font-bold text-gray-700 block mb-1">Label Tombol</label>
                            <input type="text" name="action_label" x-model="selectedPillar.action_label" placeholder="Contoh: Pelajari di siyota.org ↗" class="w-full rounded-xl border border-gray-300 p-2.5">
                        </div>
                    </div>

                    {{-- Embed Video Dokumentasi YouTube --}}
                    <div class="p-4 bg-red-50/50 border border-red-200 rounded-2xl space-y-2">
                        <div class="flex items-center justify-between">
                            <span class="font-bold text-red-950 block text-xs uppercase tracking-wider flex items-center gap-1.5">
                                <svg class="w-4 h-4 text-red-600" fill="currentColor" viewBox="0 0 24 24"><path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/></svg>
                                Embed Video YouTube Dokumentasi Aksi
                            </span>
                            <span class="text-[10px] text-red-700 font-mono font-bold">Bisa URL Standar / Shorts / Share</span>
                        </div>
                        <p class="text-[11px] text-gray-500">Masukkan tautan YouTube (contoh: https://www.youtube.com/watch?v=... atau https://youtu.be/...). Video akan langsung tertanam dan diputar di website publik.</p>
                        <input type="url" name="youtube_url" x-model="selectedPillar.youtube_url" placeholder="https://www.youtube.com/watch?v=..." class="w-full rounded-xl border border-red-300 p-2.5 text-xs bg-white focus:ring-red-500">
                    </div>

                    {{-- Foto Sampul Utama Pilar --}}
                    <div class="p-4 bg-gray-50 border border-gray-200 rounded-2xl space-y-3">
                        <span class="font-bold text-gray-900 block text-xs uppercase tracking-wider">Foto Sampul Utama Pilar</span>
                        <template x-if="selectedPillar.photo_image">
                            <div class="flex items-center gap-3 p-2 bg-white rounded-xl border border-gray-200">
                                <img :src="selectedPillar.photo_image" alt="Sampul Pilar" class="w-16 h-12 object-cover rounded-lg">
                                <div>
                                    <span class="text-[11px] font-bold text-gray-800 block">Foto Sampul Terpasang</span>
                                    <span class="text-[10px] text-gray-400 block font-mono truncate max-w-sm" x-text="selectedPillar.photo_image"></span>
                                </div>
                            </div>
                        </template>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                            <div>
                                <label class="font-bold text-gray-700 block mb-1">Upload File Baru</label>
                                <input type="file" name="photo_file" accept="image/*" class="w-full text-xs text-gray-500 file:mr-2 file:py-1.5 file:px-3 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-[#005952] file:text-white hover:file:bg-[#004741] border border-gray-300 rounded-xl p-1 bg-white">
                            </div>
                            <div>
                                <label class="font-bold text-gray-700 block mb-1">Atau URL Foto Langsung</label>
                                <input type="url" name="photo_image" x-model="selectedPillar.photo_image" placeholder="https://images.unsplash.com/..." class="w-full rounded-xl border border-gray-300 p-2">
                            </div>
                        </div>
                    </div>

                    {{-- Galeri Foto Dokumentasi Lapangan --}}
                    <div class="p-4 bg-purple-50/50 border border-purple-200 rounded-2xl space-y-3">
                        <div class="flex items-center justify-between">
                            <span class="font-bold text-purple-950 block text-xs uppercase tracking-wider">Galeri Foto Aksi Nyata Pilar</span>
                            <span class="text-[10px] text-purple-700 font-mono" x-text="(selectedPillar.gallery ? selectedPillar.gallery.length : 0) + ' Foto Tersimpan'"></span>
                        </div>
                        
                        <template x-if="selectedPillar.gallery && selectedPillar.gallery.length > 0">
                            <div class="grid grid-cols-4 sm:grid-cols-6 gap-2 p-2 bg-white rounded-xl border border-purple-100">
                                <template x-for="(img, idx) in selectedPillar.gallery" :key="idx">
                                    <div class="aspect-video rounded-lg overflow-hidden border border-purple-200 bg-gray-900">
                                        <img :src="img" alt="Galeri" class="w-full h-full object-cover">
                                    </div>
                                </template>
                            </div>
                        </template>

                        <div>
                            <label class="font-bold text-gray-700 block mb-1">Upload File Foto Baru Tambahan (Multi-file)</label>
                            <input type="file" name="gallery_files[]" multiple accept="image/*" class="w-full text-xs text-gray-500 file:mr-2 file:py-1.5 file:px-3 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-purple-700 file:text-white hover:file:bg-purple-800 border border-purple-200 rounded-xl p-1 bg-white">
                            <span class="text-[10px] text-purple-700 mt-1 block">Foto baru yang diunggah akan otomatis ditambahkan ke galeri pilar ini.</span>
                        </div>

                        <div>
                            <label class="font-bold text-gray-700 block mb-1">Daftar Link Foto Galeri (1 URL per baris)</label>
                            <textarea name="gallery_raw" x-model="selectedPillar.gallery_raw" rows="3" placeholder="https://images.unsplash.com/...&#10;https://images.unsplash.com/..." class="w-full rounded-xl border border-purple-200 p-2.5 font-mono text-xs"></textarea>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 items-center">
                        <div>
                            <label class="font-bold text-gray-700 block mb-1">Urutan Sort</label>
                            <input type="number" name="sort_order" x-model="selectedPillar.sort_order" class="w-full rounded-xl border border-gray-300 p-2.5">
                        </div>
                        <div class="pt-5">
                            <label class="flex items-center gap-2 cursor-pointer font-bold text-gray-800">
                                <input type="checkbox" name="is_active" value="1" :checked="selectedPillar.is_active" class="rounded border-gray-300 text-[#005952] focus:ring-[#005952]">
                                <span>Pilar Aktif Ditampilkan</span>
                            </label>
                        </div>
                    </div>

                    <div class="pt-4 border-t border-gray-100 flex items-center justify-end gap-3">
                        <button type="button" @click="editPillarModal = false" class="px-4 py-2 rounded-xl border border-gray-300 text-gray-700 font-bold">Batal</button>
                        <button type="submit" class="px-5 py-2.5 rounded-xl bg-[#005952] text-white font-bold shadow-sm">Simpan Pilar & Galeri</button>
                    </div>
                </form>
            </div>
        </div>

    </div>
</x-app-layout>
