<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <span class="text-xs font-bold tracking-widest text-[#005952] uppercase block">DIREKTORI EKOSISTEM & INSAN INOVATOR</span>
                <h2 class="font-black text-xl sm:text-2xl text-gray-900 leading-tight">
                    Kelola Pendiri, Tim Inti, Kontributor & Manifes Kepemimpinan
                </h2>
            </div>
            <div class="flex flex-wrap items-center gap-2.5">
                <a 
                    href="{{ route('public.people.index') }}" 
                    target="_blank" 
                    class="inline-flex items-center gap-1.5 px-4 py-2 rounded-xl bg-white border border-gray-300 text-xs font-bold text-gray-700 hover:bg-gray-50 shadow-xs transition-colors"
                >
                    <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                    <span>Portal Publik ↗</span>
                </a>
                <a 
                    href="{{ route('admin.people.export-excel') }}" 
                    class="inline-flex items-center gap-1.5 px-4 py-2 rounded-xl bg-emerald-50 border border-emerald-300 text-xs font-bold text-emerald-800 hover:bg-emerald-100 shadow-xs transition-colors"
                >
                    <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                    <span>Ekspor Excel</span>
                </a>
                <button 
                    @click="window.dispatchEvent(new CustomEvent('open-person-modal', { detail: { category: 'founder' } }))" 
                    type="button"
                    class="inline-flex items-center gap-1.5 px-4 py-2 rounded-xl bg-[#005952] hover:bg-teal-900 text-white text-xs font-bold shadow-sm transition-colors"
                >
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                    <span>Tambah Insan Baru</span>
                </button>
            </div>
        </div>
    </x-slot>

    {{-- Quill CSS & Pro Styles --}}
    <link href="https://cdn.jsdelivr.net/npm/quill@2.0.2/dist/quill.snow.css" rel="stylesheet">
    <style>
        #quill-story-wrapper {
            border: 1px solid #cbd5e1;
            border-radius: 1rem;
            overflow: hidden;
            background: #ffffff;
            box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.05);
            transition: border-color 0.2s;
        }
        #quill-story-wrapper:focus-within {
            border-color: #005952;
            box-shadow: 0 0 0 3px rgba(0, 89, 82, 0.1);
        }
        #quill-story-toolbar {
            border: none;
            border-bottom: 1px solid #e2e8f0;
            background-color: #f8fafc;
            padding: 0.5rem 0.75rem;
        }
        #quill-story-editor {
            min-height: 320px;
            max-height: 520px;
            overflow-y: auto;
            font-size: 0.9375rem;
            line-height: 1.75;
            color: #1e293b;
            border: none;
            padding: 1.25rem 1.5rem;
            font-family: ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
        }
        #quill-story-editor.ql-blank::before {
            color: #94a3b8;
            font-style: italic;
            left: 1.5rem;
            right: 1.5rem;
        }
        #quill-story-editor iframe.ql-video {
            width: 100%;
            aspect-ratio: 16 / 9;
            min-height: 280px;
            border-radius: 0.875rem;
            margin: 1.25rem 0;
            box-shadow: 0 10px 25px -5px rgba(0,0,0,0.12);
            border: 1px solid #cbd5e1;
            display: block;
        }
        #quill-story-editor img {
            max-width: 100%;
            height: auto;
            border-radius: 0.875rem;
            margin: 1.25rem auto;
            display: block;
            box-shadow: 0 8px 20px -4px rgba(0,0,0,0.1);
            border: 1px solid #e2e8f0;
        }
        #quill-story-editor blockquote {
            border-left: 4px solid #005952;
            padding: 0.75rem 1.25rem;
            margin: 1.25rem 0;
            font-style: italic;
            color: #003430;
            background: #f0fdf4;
            border-radius: 0 0.75rem 0.75rem 0;
        }
    </style>

    @php
        $allPeopleKeyed = $founders->concat($team)->concat($contributors)->keyBy('id');
        $allStoriesKeyed = $stories->keyBy('id');
    @endphp
    <script>
        window.__PEOPLE_DATA__ = {!! json_encode($allPeopleKeyed) !!};
        window.__STORIES_DATA__ = {!! json_encode($allStoriesKeyed) !!};
    </script>

    <div 
        x-data="{ 
            activeTab: '{{ $activeTab }}',
            personModal: false,
            isEditingPerson: false,
            personFormAction: '',
            personForm: {
                id: null,
                category: 'founder',
                name: '',
                role_id: '',
                role_en: '',
                bio_id: '',
                bio_en: '',
                initiative_id: '',
                is_active: 1,
                contribution_type: '',
                organization: '',
                period: '',
                sort_order: 0,
                visibility: 'public',
                quote: '',
                skills_raw: '',
                trajectory_raw: '',
                social_linkedin: '',
                social_instagram: '',
                social_twitter: '',
                social_github: '',
                social_email: '',
                story_html: ''
            },

            storyModal: false,
            isEditingStory: false,
            storyFormAction: '',
            storyForm: {
                id: null,
                person_id: '',
                chapter_number: '',
                title: '',
                subtitle: '',
                reading_time: '',
                excerpt: '',
                content_html: '',
                status: 'published',
                sort_order: 0
            },

            openCreatePerson(category = 'founder') {
                this.isEditingPerson = false;
                this.personFormAction = '{{ route('admin.people.store') }}';
                this.personForm = {
                    id: null,
                    category: category,
                    name: '',
                    role_id: '',
                    role_en: '',
                    bio_id: '',
                    bio_en: '',
                    initiative_id: '',
                    is_active: 1,
                    contribution_type: category === 'kontributor' ? 'magang' : '',
                    organization: '',
                    period: '',
                    sort_order: 0,
                    visibility: 'public',
                    quote: '',
                    skills_raw: '',
                    trajectory_raw: '',
                    social_linkedin: '',
                    social_instagram: '',
                    social_twitter: '',
                    social_github: '',
                    social_email: '',
                    story_html: ''
                };
                this.personModal = true;
            },

            openEditPerson(itemOrId) {
                let item = (typeof itemOrId === 'object' && itemOrId !== null)
                    ? itemOrId
                    : (window.__PEOPLE_DATA__ ? window.__PEOPLE_DATA__[itemOrId] : null);
                if (!item) return;

                this.isEditingPerson = true;
                this.personFormAction = '/admin/people/' + item.id;
                
                let skills = '';
                let trajectory = '';
                let quote = '';
                if (item.meta) {
                    if (Array.isArray(item.meta.skills)) {
                        skills = item.meta.skills.join(', ');
                    } else if (typeof item.meta.skills === 'string') {
                        skills = item.meta.skills;
                    }
                    if (Array.isArray(item.meta.trajectory)) {
                        trajectory = item.meta.trajectory.map(t => {
                            if (typeof t === 'string') return t;
                            if (t && typeof t === 'object') {
                                return (t.year ? t.year + ': ' : '') + (t.title || '') + (t.description ? ' - ' + t.description : '');
                            }
                            return '';
                        }).filter(Boolean).join('\n');
                    } else if (typeof item.meta.trajectory === 'string') {
                        trajectory = item.meta.trajectory;
                    }
                    quote = item.meta.quote || '';
                }

                let social = item.social_links || {};

                this.personForm = {
                    id: item.id,
                    category: item.category || 'tim',
                    name: item.name || '',
                    role_id: item.role_id || '',
                    role_en: item.role_en || '',
                    bio_id: item.bio_id || '',
                    bio_en: item.bio_en || '',
                    initiative_id: item.initiative_id || '',
                    is_active: item.is_active ? 1 : 0,
                    contribution_type: item.contribution_type || '',
                    organization: item.organization || '',
                    period: item.period || '',
                    sort_order: item.sort_order || 0,
                    visibility: item.visibility || 'public',
                    quote: quote,
                    skills_raw: skills,
                    trajectory_raw: trajectory,
                    social_linkedin: social.linkedin || '',
                    social_instagram: social.instagram || '',
                    social_twitter: social.twitter || '',
                    social_github: social.github || '',
                    social_email: social.email || '',
                    story_html: item.story_html || ''
                };
                this.personModal = true;
            },

            openCreateStory() {
                this.isEditingStory = false;
                this.storyFormAction = '{{ route('admin.people.stories.store') }}';
                this.storyForm = {
                    id: null,
                    person_id: '',
                    chapter_number: '',
                    title: '',
                    subtitle: '',
                    reading_time: '7 min read',
                    excerpt: '',
                    content_html: '',
                    status: 'published',
                    sort_order: 0
                };
                this.storyModal = true;
                this.$nextTick(() => {
                    setTimeout(() => {
                        initOrUpdateQuillStory('');
                    }, 50);
                });
            },

            openEditStory(itemOrId) {
                let item = (typeof itemOrId === 'object' && itemOrId !== null)
                    ? itemOrId
                    : (window.__STORIES_DATA__ ? window.__STORIES_DATA__[itemOrId] : null);
                if (!item) return;

                this.isEditingStory = true;
                this.storyFormAction = '/admin/people/stories/' + item.id;
                this.storyForm = {
                    id: item.id,
                    person_id: item.person_id || '',
                    chapter_number: item.chapter_number || '',
                    title: item.title || '',
                    subtitle: item.subtitle || '',
                    reading_time: item.reading_time || '',
                    excerpt: item.excerpt || '',
                    content_html: item.content_html || '',
                    status: item.status || 'published',
                    sort_order: item.sort_order || 0
                };
                this.storyModal = true;
                this.$nextTick(() => {
                    setTimeout(() => {
                        initOrUpdateQuillStory(item.content_html || '');
                    }, 50);
                });
            }
        }" 
        @open-person-modal.window="openCreatePerson($event.detail.category)"
        class="py-8 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8"
    >

        {{-- Alerts --}}
        @if(session('success'))
            <div class="p-4 rounded-2xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs font-bold flex items-center justify-between shadow-xs">
                <div class="flex items-center gap-2">
                    <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                    <span>{{ session('success') }}</span>
                </div>
                <button type="button" @click="$el.parentElement.remove()" class="text-emerald-600 hover:text-emerald-900">&times;</button>
            </div>
        @endif

        @if(session('error'))
            <div class="p-4 rounded-2xl bg-rose-50 border border-rose-200 text-rose-800 text-xs font-bold flex items-center justify-between shadow-xs">
                <div class="flex items-center gap-2">
                    <svg class="w-5 h-5 text-rose-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    <span>{{ session('error') }}</span>
                </div>
                <button type="button" @click="$el.parentElement.remove()" class="text-rose-600 hover:text-rose-900">&times;</button>
            </div>
        @endif

        @if(isset($errors) && $errors->any())
            <div class="p-4 rounded-2xl bg-rose-50 border border-rose-200 text-rose-800 text-xs shadow-xs space-y-1.5">
                <div class="flex items-center justify-between font-bold">
                    <div class="flex items-center gap-2">
                        <svg class="w-5 h-5 text-rose-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        <span>Terdapat kesalahan pada input form:</span>
                    </div>
                    <button type="button" @click="$el.parentElement.remove()" class="text-rose-600 hover:text-rose-900 font-bold">&times;</button>
                </div>
                <ul class="list-disc list-inside pl-7 text-[11px] text-rose-700 space-y-0.5">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- Metric Overview Cards --}}
        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-4">
            <div class="bg-white rounded-2xl border border-gray-200/80 p-4 shadow-xs">
                <span class="text-[11px] font-bold text-gray-500 uppercase tracking-wider block">Total Insan</span>
                <span class="text-2xl font-black text-gray-950 mt-1 block">{{ $totalPeople }}</span>
                <span class="text-[10px] text-gray-400 font-mono">Semua Entitas</span>
            </div>
            <div class="bg-white rounded-2xl border border-gray-200/80 p-4 shadow-xs">
                <span class="text-[11px] font-bold text-[#005952] uppercase tracking-wider block">Dewan Pendiri</span>
                <span class="text-2xl font-black text-[#005952] mt-1 block">{{ $foundersCount }}</span>
                <span class="text-[10px] text-gray-400 font-mono">Co-Founders</span>
            </div>
            <div class="bg-white rounded-2xl border border-gray-200/80 p-4 shadow-xs">
                <span class="text-[11px] font-bold text-teal-700 uppercase tracking-wider block">Tim Inti</span>
                <span class="text-2xl font-black text-teal-700 mt-1 block">{{ $teamCount }}</span>
                <span class="text-[10px] text-gray-400 font-mono">Lintas Venture</span>
            </div>
            <div class="bg-white rounded-2xl border border-gray-200/80 p-4 shadow-xs">
                <span class="text-[11px] font-bold text-amber-700 uppercase tracking-wider block">Kontributor</span>
                <span class="text-2xl font-black text-amber-700 mt-1 block">{{ $contributorsCount }}</span>
                <span class="text-[10px] text-gray-400 font-mono">Magang, Riset & Proyek</span>
            </div>
            <div class="bg-white rounded-2xl border border-gray-200/80 p-4 shadow-xs">
                <span class="text-[11px] font-bold text-purple-700 uppercase tracking-wider block">Manifes & Esai</span>
                <span class="text-2xl font-black text-purple-700 mt-1 block">{{ $storiesCount }}</span>
                <span class="text-[10px] text-gray-400 font-mono">Dokumen Eksekutif</span>
            </div>
        </div>

        {{-- Main Tab Bar --}}
        <div class="bg-white rounded-2xl border border-gray-200/80 p-2 shadow-xs flex items-center gap-1.5 overflow-x-auto no-scrollbar">
            <button 
                type="button" 
                @click="activeTab = 'founders'" 
                class="px-4 py-2 rounded-xl text-xs font-bold transition-all shrink-0 flex items-center gap-2"
                :class="activeTab === 'founders' ? 'bg-[#005952] text-white shadow-xs' : 'text-gray-600 hover:bg-gray-100'"
            >
                <span>🌟 Dewan Pendiri ({{ $foundersCount }})</span>
            </button>
            <button 
                type="button" 
                @click="activeTab = 'team'" 
                class="px-4 py-2 rounded-xl text-xs font-bold transition-all shrink-0 flex items-center gap-2"
                :class="activeTab === 'team' ? 'bg-[#005952] text-white shadow-xs' : 'text-gray-600 hover:bg-gray-100'"
            >
                <span>🚀 Tim Inti ({{ $teamCount }})</span>
            </button>
            <button 
                type="button" 
                @click="activeTab = 'contributors'" 
                class="px-4 py-2 rounded-xl text-xs font-bold transition-all shrink-0 flex items-center gap-2"
                :class="activeTab === 'contributors' ? 'bg-[#005952] text-white shadow-xs' : 'text-gray-600 hover:bg-gray-100'"
            >
                <span>🎓 Kontributor ({{ $contributorsCount }})</span>
            </button>
            <button 
                type="button" 
                @click="activeTab = 'stories'" 
                class="px-4 py-2 rounded-xl text-xs font-bold transition-all shrink-0 flex items-center gap-2"
                :class="activeTab === 'stories' ? 'bg-[#005952] text-white shadow-xs' : 'text-gray-600 hover:bg-gray-100'"
            >
                <span>📖 Manifes & Esai Pendiri ({{ $storiesCount }})</span>
            </button>
            <button 
                type="button" 
                @click="activeTab = 'clients'" 
                class="px-4 py-2 rounded-xl text-xs font-bold transition-all shrink-0 flex items-center gap-2"
                :class="activeTab === 'clients' ? 'bg-[#005952] text-white shadow-xs' : 'text-gray-600 hover:bg-gray-100'"
            >
                <span>🤝 Mitra Logo Sync ({{ $clients->count() }})</span>
            </button>
            <button 
                type="button" 
                @click="activeTab = 'excel'" 
                class="px-4 py-2 rounded-xl text-xs font-bold transition-all shrink-0 flex items-center gap-2"
                :class="activeTab === 'excel' ? 'bg-[#005952] text-white shadow-xs' : 'text-gray-600 hover:bg-gray-100'"
            >
                <span>📊 Hub Import & Ekspor Excel</span>
            </button>
        </div>

        {{-- TAB 1: FOUNDERS --}}
        <div x-show="activeTab === 'founders'" x-cloak class="space-y-6">
            <div class="flex items-center justify-between pb-2 border-b border-gray-200">
                <div>
                    <h3 class="text-lg font-bold text-gray-900">Daftar Dewan Pendiri (Founders)</h3>
                    <p class="text-xs text-gray-500">Profil utama, kutipan filosofis, rekam jejak, dan esai kepemimpinan.</p>
                </div>
                <button 
                    @click="openCreatePerson('founder')" 
                    type="button"
                    class="px-3.5 py-2 rounded-xl bg-[#005952] text-white text-xs font-bold hover:bg-teal-900 transition-colors shadow-xs"
                >
                    + Tambah Pendiri
                </button>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($founders as $founder)
                    <div class="bg-white rounded-3xl border border-gray-200/90 p-5 shadow-xs hover:shadow-md transition-all flex flex-col justify-between">
                        <div>
                            <div class="flex items-center gap-4 mb-4">
                                <div class="w-16 h-16 rounded-2xl overflow-hidden bg-gray-900 shrink-0">
                                    @if($founder->photo)
                                        <img src="{{ asset($founder->photo) }}" alt="{{ $founder->name }}" class="w-full h-full object-cover">
                                    @else
                                        <div class="w-full h-full flex items-center justify-center text-teal-400 font-bold text-2xl">
                                            {{ substr($founder->name, 0, 1) }}
                                        </div>
                                    @endif
                                </div>
                                <div class="min-w-0">
                                    <h4 class="text-sm font-bold text-gray-950 truncate">{{ $founder->name }}</h4>
                                    <p class="text-xs font-semibold text-[#005952] truncate">{{ $founder->role_id }}</p>
                                    <span class="text-[10px] text-gray-400 font-mono">Urutan: {{ $founder->sort_order }}</span>
                                </div>
                            </div>

                            @if($founder->getMeta('quote'))
                                <p class="text-xs italic text-gray-600 bg-gray-50 p-2.5 rounded-xl border border-gray-100 line-clamp-2 mb-3">
                                    "{{ $founder->getMeta('quote') }}"
                                </p>
                            @endif

                            <p class="text-xs text-gray-500 line-clamp-3 mb-4 font-light">
                                {{ $founder->bio_id }}
                            </p>
                        </div>

                        <div class="pt-3 border-t border-gray-100 flex items-center justify-between">
                            <a 
                                href="{{ route('public.people.founder.show', $founder->slug) }}" 
                                target="_blank"
                                class="text-xs font-bold text-[#005952] hover:underline"
                            >
                                Preview ↗
                            </a>
                            <div class="flex items-center gap-2">
                                <button 
                                    type="button" 
                                    @click="openEditPerson({{ $founder->id }})" 
                                    class="px-2.5 py-1 rounded-lg text-xs font-bold bg-gray-100 hover:bg-gray-200 text-gray-700 transition-colors"
                                >
                                    Edit
                                </button>
                                <form 
                                    action="{{ route('admin.people.destroy', $founder->id) }}" 
                                    method="POST" 
                                    onsubmit="return confirm('Hapus profil pendiri ini?')"
                                >
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="p-1 text-rose-500 hover:text-rose-700">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        {{-- TAB 2: TIM INTI --}}
        <div x-show="activeTab === 'team'" x-cloak class="space-y-6">
            <div class="flex items-center justify-between pb-2 border-b border-gray-200">
                <div>
                    <h3 class="text-lg font-bold text-gray-900">Daftar Tim Inti (Core Team)</h3>
                    <p class="text-xs text-gray-500">Talenta inti yang terikat ke brand holding/venture, status aktif vs alumni.</p>
                </div>
                <button 
                    @click="openCreatePerson('tim')" 
                    type="button"
                    class="px-3.5 py-2 rounded-xl bg-[#005952] text-white text-xs font-bold hover:bg-teal-900 transition-colors shadow-xs"
                >
                    + Tambah Anggota Tim
                </button>
            </div>

            <div class="bg-white rounded-3xl border border-gray-200/90 overflow-hidden shadow-xs">
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-xs">
                        <thead class="bg-gray-50/80 border-b border-gray-200 text-gray-500 font-bold uppercase tracking-wider">
                            <tr>
                                <th class="p-4">Anggota</th>
                                <th class="p-4">Brand / Unit</th>
                                <th class="p-4">Status</th>
                                <th class="p-4">Kompetensi</th>
                                <th class="p-4 text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @foreach($team as $member)
                                <tr class="hover:bg-gray-50/50 transition-colors">
                                    <td class="p-4 flex items-center gap-3">
                                        <div class="w-10 h-10 rounded-xl overflow-hidden bg-gray-100 shrink-0">
                                            @if($member->photo)
                                                <img src="{{ asset($member->photo) }}" alt="{{ $member->name }}" class="w-full h-full object-cover">
                                            @else
                                                <div class="w-full h-full flex items-center justify-center font-bold text-gray-400">
                                                    {{ substr($member->name, 0, 1) }}
                                                </div>
                                            @endif
                                        </div>
                                        <div class="min-w-0">
                                            <span class="font-bold text-gray-900 block truncate">{{ $member->name }}</span>
                                            <span class="text-[11px] text-[#005952] block truncate">{{ $member->role_id }}</span>
                                        </div>
                                    </td>
                                    <td class="p-4">
                                        <span class="px-2.5 py-1 rounded-lg text-[11px] font-bold {{ $member->initiative ? 'bg-teal-50 text-[#005952]' : 'bg-gray-100 text-gray-700' }}">
                                            {{ $member->initiative ? $member->initiative->name : 'Holding YOIN' }}
                                        </span>
                                    </td>
                                    <td class="p-4">
                                        @if($member->is_active)
                                            <span class="inline-flex items-center gap-1 text-[11px] font-bold text-emerald-700">
                                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                                Aktif
                                            </span>
                                        @else
                                            <span class="inline-flex items-center gap-1 text-[11px] font-semibold text-gray-500">
                                                Alumni
                                            </span>
                                        @endif
                                    </td>
                                    <td class="p-4">
                                        <div class="flex flex-wrap gap-1 max-w-xs">
                                            @foreach((array)$member->getMeta('skills', []) as $s)
                                                <span class="px-1.5 py-0.5 rounded bg-gray-100 text-gray-600 text-[10px] font-mono">{{ $s }}</span>
                                            @endforeach
                                        </div>
                                    </td>
                                    <td class="p-4 text-right">
                                        <div class="flex items-center justify-end gap-2">
                                            <button 
                                                type="button" 
                                                @click="openEditPerson({{ $member->id }})" 
                                                class="px-2.5 py-1 rounded-lg text-xs font-bold bg-gray-100 hover:bg-gray-200 text-gray-700"
                                            >
                                                Edit
                                            </button>
                                            <form action="{{ route('admin.people.destroy', $member->id) }}" method="POST" onsubmit="return confirm('Hapus anggota tim ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="p-1 text-rose-500 hover:text-rose-700">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        {{-- TAB 3: KONTRIBUTOR --}}
        <div x-show="activeTab === 'contributors'" x-cloak class="space-y-6">
            <div class="flex items-center justify-between pb-2 border-b border-gray-200">
                <div>
                    <h3 class="text-lg font-bold text-gray-900">Daftar Kontributor & Talenta</h3>
                    <p class="text-xs text-gray-500">Magang, riset akademik, kerjasama kemitraan, dan fellowship.</p>
                </div>
                <button 
                    @click="openCreatePerson('kontributor')" 
                    type="button"
                    class="px-3.5 py-2 rounded-xl bg-[#005952] text-white text-xs font-bold hover:bg-teal-900 transition-colors shadow-xs"
                >
                    + Tambah Kontributor
                </button>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($contributors as $c)
                    <div class="bg-white rounded-3xl border border-gray-200/90 p-5 shadow-xs hover:shadow-md transition-all flex flex-col justify-between">
                        <div>
                            <div class="flex items-center justify-between gap-2 mb-3">
                                <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold uppercase tracking-wider bg-teal-50 text-[#005952]">
                                    {{ ucfirst($c->contribution_type ?: 'Kontributor') }}
                                </span>
                                <span class="text-[10px] font-mono text-gray-400">{{ $c->period }}</span>
                            </div>

                            <div class="flex items-center gap-3 mb-3">
                                <div class="w-12 h-12 rounded-xl overflow-hidden bg-gray-100 shrink-0">
                                    @if($c->photo)
                                        <img src="{{ asset($c->photo) }}" alt="{{ $c->name }}" class="w-full h-full object-cover">
                                    @else
                                        <div class="w-full h-full flex items-center justify-center font-bold text-gray-400">
                                            {{ substr($c->name, 0, 1) }}
                                        </div>
                                    @endif
                                </div>
                                <div class="min-w-0">
                                    <h4 class="text-xs font-bold text-gray-900 truncate">{{ $c->name }}</h4>
                                    <p class="text-[11px] text-[#005952] truncate">{{ $c->role_id }}</p>
                                    <p class="text-[10px] text-gray-400 truncate">{{ $c->organization }}</p>
                                </div>
                            </div>

                            <p class="text-xs text-gray-600 line-clamp-2 mb-4 font-light">
                                {{ $c->bio_id }}
                            </p>
                        </div>

                        <div class="pt-3 border-t border-gray-100 flex items-center justify-between">
                            <a href="{{ route('public.people.kontributor.show', $c->slug) }}" target="_blank" class="text-xs font-bold text-[#005952] hover:underline">
                                Preview ↗
                            </a>
                            <div class="flex items-center gap-2">
                                <button type="button" @click="openEditPerson({{ $c->id }})" class="px-2.5 py-1 rounded-lg text-xs font-bold bg-gray-100 hover:bg-gray-200 text-gray-700">
                                    Edit
                                </button>
                                <form action="{{ route('admin.people.destroy', $c->id) }}" method="POST" onsubmit="return confirm('Hapus kontributor ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="p-1 text-rose-500 hover:text-rose-700">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        {{-- TAB 4: MANIFES & ESAI PENDIRI (EXECUTIVE STORIES) --}}
        <div x-show="activeTab === 'stories'" x-cloak class="space-y-6">
            <div class="flex items-center justify-between pb-2 border-b border-gray-200">
                <div>
                    <h3 class="text-lg font-bold text-gray-900">Manifes & Esai Strategis Dewan Pendiri (Executive Stories)</h3>
                    <p class="text-xs text-gray-500">Narasi mendalam pembelajaran kepemimpinan, tesis inovasi, dan rekam jejak holding dengan editor teks kaya.</p>
                </div>
                <button 
                    @click="openCreateStory()" 
                    type="button"
                    class="px-3.5 py-2 rounded-xl bg-[#005952] text-white text-xs font-bold hover:bg-teal-900 transition-colors shadow-xs"
                >
                    + Tulis Manifes Baru
                </button>
            </div>

            <div class="space-y-4">
                @foreach($stories as $story)
                    <div class="bg-white rounded-3xl border border-gray-200/90 p-5 sm:p-6 shadow-xs flex flex-col md:flex-row md:items-center justify-between gap-4">
                        <div class="flex items-start gap-4">
                            <span class="px-3 py-1.5 rounded-xl bg-teal-50 text-[#005952] font-mono font-bold text-xs shrink-0 border border-teal-200">
                                {{ $story->chapter_number ?: 'MANIFES' }}
                            </span>
                            <div>
                                <h4 class="text-base font-bold text-gray-950">{{ $story->title }}</h4>
                                @if($story->subtitle)
                                    <p class="text-xs italic text-gray-500 mb-1">{{ $story->subtitle }}</p>
                                @endif
                                <div class="flex items-center gap-3 text-xs text-gray-400 mt-1 font-mono">
                                    <span>Penutur: {{ $story->author ? $story->author->name : 'Dewan Pendiri' }}</span>
                                    <span>•</span>
                                    <span>{{ $story->reading_time ?: '5 min read' }}</span>
                                    <span>•</span>
                                    <span class="{{ $story->status === 'published' ? 'text-emerald-600 font-bold' : 'text-gray-400' }}">{{ ucfirst($story->status) }}</span>
                                </div>
                            </div>
                        </div>

                        <div class="flex items-center gap-2 shrink-0 self-end md:self-center">
                            <a href="{{ route('public.people.storyfounder.show', $story->slug) }}" target="_blank" class="px-3 py-1.5 rounded-xl bg-gray-100 hover:bg-gray-200 text-xs font-bold text-gray-700">
                                Pratinjau ↗
                            </a>
                            <button type="button" @click="openEditStory({{ $story->id }})" class="px-3 py-1.5 rounded-xl bg-[#005952] hover:bg-teal-900 text-xs font-bold text-white">
                                Edit Manifes
                            </button>
                            <form action="{{ route('admin.people.stories.destroy', $story->id) }}" method="POST" onsubmit="return confirm('Hapus dokumen manifes ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="p-1.5 text-rose-500 hover:text-rose-700">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                </button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        {{-- TAB 5: MITRA & LOGO SYNC --}}
        <div x-show="activeTab === 'clients'" x-cloak class="space-y-6">
            <div class="flex items-center justify-between pb-2 border-b border-gray-200">
                <div>
                    <h3 class="text-lg font-bold text-gray-900">Mitra Kolaborator (Sinkronisasi Database Logo)</h3>
                    <p class="text-xs text-gray-500">
                        Data ini disinkronkan langsung dengan tabel klien ekosistem (EcosystemClient) agar tidak terduplikasi.
                    </p>
                </div>
                <a href="{{ route('admin.ecosystem.index', ['tab' => 'clients']) }}" class="px-3.5 py-2 rounded-xl bg-teal-50 text-[#005952] border border-teal-200 text-xs font-bold hover:bg-teal-100 transition-colors">
                    Kelola di CMS Ekosistem ↗
                </a>
            </div>

            <div class="grid grid-cols-2 sm:grid-cols-4 lg:grid-cols-6 gap-4">
                @foreach($clients as $client)
                    <div class="bg-white rounded-2xl border border-gray-200/80 p-4 text-center flex flex-col items-center justify-center min-h-[110px]">
                        @if($client->logo)
                            <img src="{{ asset($client->logo) }}" alt="{{ $client->name }}" class="max-h-10 max-w-[100px] object-contain">
                        @else
                            <span class="text-xs font-bold text-[#005952]">{{ $client->name }}</span>
                        @endif
                        <span class="text-[10px] text-gray-400 mt-2 truncate max-w-full">{{ $client->name }}</span>
                    </div>
                @endforeach
            </div>
        </div>

        {{-- TAB 6: EXCEL HUB (IMPORT & EKSPOR) --}}
        <div x-show="activeTab === 'excel'" x-cloak class="space-y-8">
            <div class="bg-gradient-to-br from-emerald-950 via-[#003430] to-gray-950 text-white rounded-3xl p-8 sm:p-10 shadow-xl border border-emerald-800/40">
                <span class="px-3 py-1 rounded-full bg-emerald-500/20 text-emerald-300 text-[11px] font-bold uppercase tracking-wider mb-4 inline-block">
                    MICROSOFT EXCEL & CSV BRIDGE
                </span>
                <h3 class="text-2xl sm:text-3xl font-black mb-3">Integrasi Ekspor & Impor File Excel</h3>
                <p class="text-sm text-gray-300 font-light leading-relaxed max-w-2xl mb-8">
                    Kelola data ratusan insan, pendiri, tim inti, dan kontributor secara massal menggunakan file Excel (.xlsx) atau CSV UTF-8. Mudah dimodifikasi secara offline dan diunggah kembali ke sistem.
                </p>

                <div class="flex flex-wrap items-center gap-4">
                    <a 
                        href="{{ route('admin.people.export-excel') }}" 
                        class="px-6 py-3 rounded-xl bg-emerald-400 hover:bg-emerald-300 text-gray-950 font-bold text-xs transition-all shadow-md inline-flex items-center gap-2"
                    >
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                        <span>Unduh Semua Data (.csv Excel)</span>
                    </a>
                    <a 
                        href="{{ route('admin.people.download-template') }}" 
                        class="px-6 py-3 rounded-xl bg-white/10 hover:bg-white/20 text-white font-bold text-xs transition-all border border-white/20 inline-flex items-center gap-2"
                    >
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M9 19l3 3m0 0l3-3m-3 3V10"/></svg>
                        <span>Unduh Template Format Excel</span>
                    </a>
                </div>
            </div>

            {{-- Import Box --}}
            <div class="bg-white rounded-3xl border border-gray-200/90 p-8 shadow-xs max-w-2xl">
                <h4 class="text-base font-bold text-gray-900 mb-2">Unggah File Excel atau CSV untuk Impor</h4>
                <p class="text-xs text-gray-500 mb-6 font-light">
                    Sistem mendukung format berkas <code>.xlsx</code> dan <code>.csv</code>. Kolom yang didukung: category, name, role_id, role_en, bio_id, bio_en, is_active, contribution_type, organization, period, skills, quote, linkedin, instagram, github, email.
                </p>

                <form action="{{ route('admin.people.import-excel') }}" method="POST" enctype="multipart/form-data" class="space-y-5">
                    @csrf
                    <div>
                        <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">Pilih File (.xlsx atau .csv)</label>
                        <input 
                            type="file" 
                            name="excel_file" 
                            accept=".csv,.xlsx" 
                            required 
                            class="block w-full text-xs text-gray-600 file:mr-4 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-teal-50 file:text-[#005952] hover:file:bg-teal-100 border border-gray-300 rounded-xl cursor-pointer"
                        >
                    </div>

                    <div class="pt-3 border-t border-gray-100">
                        <button 
                            type="submit" 
                            class="px-6 py-2.5 rounded-xl bg-[#005952] hover:bg-teal-900 text-white text-xs font-bold shadow-xs transition-colors"
                        >
                            Proses & Impor Data Massal
                        </button>
                    </div>
                </form>
            </div>
        </div>

        {{-- MODAL: TAMBAH / EDIT INSAN (FOUNDER, TIM, KONTRIBUTOR) --}}
        <div 
            x-show="personModal" 
            x-cloak 
            class="fixed inset-0 z-50 overflow-y-auto bg-black/60 backdrop-blur-xs flex items-center justify-center p-4"
        >
            <div 
                @click.outside="personModal = false" 
                class="bg-white rounded-3xl max-w-3xl w-full p-6 sm:p-8 shadow-2xl border border-gray-100 max-h-[90vh] overflow-y-auto"
            >
                <div class="flex items-center justify-between pb-4 border-b border-gray-100 mb-6">
                    <h3 class="text-lg font-black text-gray-900" x-text="isEditingPerson ? 'Edit Data Insan' : 'Tambah Insan Baru'"></h3>
                    <button type="button" @click="personModal = false" class="text-gray-400 hover:text-gray-700 text-xl font-bold">&times;</button>
                </div>

                <form :action="personFormAction" method="POST" enctype="multipart/form-data" class="space-y-6 text-xs">
                    @csrf
                    <input type="hidden" name="_method" :value="isEditingPerson ? 'PUT' : 'POST'">

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block font-bold text-gray-700 mb-1">Kategori *</label>
                            <select name="category" x-model="personForm.category" required class="w-full rounded-xl border-gray-300 text-xs">
                                <option value="founder">Dewan Pendiri (Founder)</option>
                                <option value="tim">Tim Inti (Core Team)</option>
                                <option value="kontributor">Kontributor (Magang, Riset, dll)</option>
                            </select>
                        </div>
                        <div>
                            <label class="block font-bold text-gray-700 mb-1">Nama Lengkap *</label>
                            <input type="text" name="name" x-model="personForm.name" required class="w-full rounded-xl border-gray-300 text-xs" placeholder="Misal: Dr. Ir. Rian Ardiansyah">
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block font-bold text-gray-700 mb-1">Peran / Jabatan (ID) *</label>
                            <input type="text" name="role_id" x-model="personForm.role_id" required class="w-full rounded-xl border-gray-300 text-xs" placeholder="Misal: Chief Executive Officer">
                        </div>
                        <div>
                            <label class="block font-bold text-gray-700 mb-1">Peran / Jabatan (EN)</label>
                            <input type="text" name="role_en" x-model="personForm.role_en" class="w-full rounded-xl border-gray-300 text-xs" placeholder="Misal: Chief Executive Officer & Co-Founder">
                        </div>
                    </div>

                    {{-- Conditional Fields for Team & Initiative --}}
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4" x-show="personForm.category === 'tim'">
                        <div class="sm:col-span-2">
                            <label class="block font-bold text-gray-700 mb-1">Terikat ke Brand / Inisiatif</label>
                            <select name="initiative_id" x-model="personForm.initiative_id" class="w-full rounded-xl border-gray-300 text-xs">
                                <option value="">-- Holding YOIN (Umum) --</option>
                                @foreach($initiatives as $init)
                                    <option value="{{ $init->id }}">{{ $init->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block font-bold text-gray-700 mb-1">Status Keaktifan</label>
                            <select name="is_active" x-model="personForm.is_active" class="w-full rounded-xl border-gray-300 text-xs">
                                <option :value="1">Aktif</option>
                                <option :value="0">Alumni / Non-Aktif</option>
                            </select>
                        </div>
                    </div>

                    {{-- Conditional Fields for Contributor --}}
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4" x-show="personForm.category === 'kontributor'">
                        <div>
                            <label class="block font-bold text-gray-700 mb-1">Tipe Kontribusi</label>
                            <select name="contribution_type" x-model="personForm.contribution_type" class="w-full rounded-xl border-gray-300 text-xs">
                                <option value="magang">Magang (Internship)</option>
                                <option value="riset">Riset & Akademik</option>
                                <option value="kerjasama">Kerjasama Proyek</option>
                                <option value="fellowship">Fellowship</option>
                            </select>
                        </div>
                        <div>
                            <label class="block font-bold text-gray-700 mb-1">Kampus / Asal Organisasi</label>
                            <input type="text" name="organization" x-model="personForm.organization" class="w-full rounded-xl border-gray-300 text-xs" placeholder="Misal: Institut Teknologi Bandung">
                        </div>
                        <div>
                            <label class="block font-bold text-gray-700 mb-1">Periode / Batch</label>
                            <input type="text" name="period" x-model="personForm.period" class="w-full rounded-xl border-gray-300 text-xs" placeholder="Misal: Batch VI - 2026">
                        </div>
                    </div>

                    {{-- Photos --}}
                    <div>
                        <label class="block font-bold text-gray-700 mb-1">Unggah Foto Profil</label>
                        <input type="file" name="photo" accept="image/*" class="block w-full text-xs text-gray-600 border border-gray-300 rounded-xl p-2 cursor-pointer">
                    </div>

                    {{-- Biographies --}}
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block font-bold text-gray-700 mb-1">Bio Ringkas (ID)</label>
                            <textarea name="bio_id" x-model="personForm.bio_id" rows="3" class="w-full rounded-xl border-gray-300 text-xs"></textarea>
                        </div>
                        <div>
                            <label class="block font-bold text-gray-700 mb-1">Bio Ringkas (EN)</label>
                            <textarea name="bio_en" x-model="personForm.bio_en" rows="3" class="w-full rounded-xl border-gray-300 text-xs"></textarea>
                        </div>
                    </div>

                    {{-- JSON Meta Attributes --}}
                    <div class="p-4 rounded-2xl bg-gray-50 border border-gray-200/80 space-y-4">
                        <span class="text-[11px] font-bold text-gray-500 uppercase tracking-wider block">Atribut Tambahan (Disimpan Otomatis ke JSON)</span>
                        
                        <div x-show="personForm.category === 'founder'">
                            <label class="block font-bold text-gray-700 mb-1">Kutipan Inspiratif Pendiri (Quote)</label>
                            <input type="text" name="quote" x-model="personForm.quote" class="w-full rounded-xl border-gray-300 text-xs" placeholder="Misal: Teknologi terbaik adalah yang menyentuh tanah dan memberdayakan petani.">
                        </div>

                        <div>
                            <label class="block font-bold text-gray-700 mb-1">Keahlian / Fokus (Pisahkan dengan koma)</label>
                            <input type="text" name="skills_raw" x-model="personForm.skills_raw" class="w-full rounded-xl border-gray-300 text-xs" placeholder="Misal: Artificial Intelligence, Precision Farming, Agronomy">
                        </div>

                        <div x-show="personForm.category === 'founder'">
                            <label class="block font-bold text-gray-700 mb-1">Rekam Jejak / Trajectory (1 per baris)</label>
                            <textarea name="trajectory_raw" x-model="personForm.trajectory_raw" rows="3" class="w-full rounded-xl border-gray-300 text-xs" placeholder="Misal:&#10;2021: Menginisiasi Lab Riset Agroteknologi&#10;2024: Membangun holding YOIN"></textarea>
                        </div>
                    </div>

                    {{-- Social Media Links (Stored in JSON) --}}
                    <div class="p-4 rounded-2xl bg-gray-50 border border-gray-200/80 space-y-4">
                        <span class="text-[11px] font-bold text-gray-500 uppercase tracking-wider block">Tautan Media Sosial</span>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                            <input type="url" name="social_linkedin" x-model="personForm.social_linkedin" class="rounded-xl border-gray-300 text-xs" placeholder="URL LinkedIn">
                            <input type="url" name="social_instagram" x-model="personForm.social_instagram" class="rounded-xl border-gray-300 text-xs" placeholder="URL Instagram">
                            <input type="url" name="social_twitter" x-model="personForm.social_twitter" class="rounded-xl border-gray-300 text-xs" placeholder="URL Twitter / X">
                            <input type="url" name="social_github" x-model="personForm.social_github" class="rounded-xl border-gray-300 text-xs" placeholder="URL GitHub">
                            <input type="email" name="social_email" x-model="personForm.social_email" class="rounded-xl border-gray-300 text-xs" placeholder="Email Resmi">
                        </div>
                    </div>

                    {{-- Sort Order & Visibility --}}
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block font-bold text-gray-700 mb-1">Urutan Tampil (Sort Order)</label>
                            <input type="number" name="sort_order" x-model="personForm.sort_order" class="w-full rounded-xl border-gray-300 text-xs">
                        </div>
                        <div>
                            <label class="block font-bold text-gray-700 mb-1">Visibilitas</label>
                            <select name="visibility" x-model="personForm.visibility" class="w-full rounded-xl border-gray-300 text-xs">
                                <option value="public">Publik (Tampil di Website)</option>
                                <option value="internal">Internal Saja</option>
                            </select>
                        </div>
                    </div>

                    <div class="pt-4 border-t border-gray-100 flex items-center justify-end gap-2">
                        <button type="button" @click="personModal = false" class="px-4 py-2 rounded-xl bg-gray-100 text-gray-700 font-bold hover:bg-gray-200">Batal</button>
                        <button type="submit" class="px-5 py-2 rounded-xl bg-[#005952] hover:bg-teal-900 text-white font-bold shadow-xs">Simpan Data</button>
                    </div>
                </form>
            </div>
        </div>

        {{-- MODAL: TAMBAH / EDIT MANIFES & ESAI PENDIRI (QUILL RICH TEXT EDITOR) --}}
        <div 
            x-show="storyModal" 
            x-cloak 
            class="fixed inset-0 z-50 overflow-y-auto bg-black/60 backdrop-blur-xs flex items-center justify-center p-4"
        >
            <div 
                @click.outside="storyModal = false" 
                class="bg-white rounded-3xl max-w-5xl w-full p-6 sm:p-8 shadow-2xl border border-gray-100 max-h-[92vh] overflow-y-auto"
            >
                <div class="flex items-center justify-between pb-4 border-b border-gray-100 mb-6">
                    <div>
                        <span class="text-[11px] font-bold text-[#005952] uppercase tracking-wider block">STUDIO DOKUMENTASI EKSEKUTIF</span>
                        <h3 class="text-xl font-black text-gray-900" x-text="isEditingStory ? 'Edit Manifes & Esai Pendiri' : 'Tulis Manifes & Esai Baru'"></h3>
                    </div>
                    <button type="button" @click="storyModal = false" class="w-8 h-8 rounded-full bg-gray-100 hover:bg-gray-200 text-gray-500 hover:text-gray-900 flex items-center justify-center font-bold text-lg transition-colors">&times;</button>
                </div>

                <form :action="storyFormAction" method="POST" id="form-story" class="space-y-6 text-xs">
                    @csrf
                    <input type="hidden" name="_method" :value="isEditingStory ? 'PUT' : 'POST'">

                    {{-- Baris 1: Penulis & Nomor Seri --}}
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block font-bold text-gray-700 mb-1.5">Penutur / Penulis Manifes (Founder Author)</label>
                            <select name="person_id" x-model="storyForm.person_id" class="w-full rounded-xl border-gray-300 text-xs focus:ring-[#005952] focus:border-[#005952]">
                                <option value="">-- Kolektif Dewan Pendiri Holding --</option>
                                @foreach($founders as $f)
                                    <option value="{{ $f->id }}">{{ $f->name }} ({{ $f->role_id }})</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block font-bold text-gray-700 mb-1.5">Nomor / Label Seri Dokumen *</label>
                            <input type="text" name="chapter_number" x-model="storyForm.chapter_number" required class="w-full rounded-xl border-gray-300 text-xs focus:ring-[#005952] focus:border-[#005952]" placeholder="Misal: MANIFES 00, MANIFES 01, TESIS 2026">
                        </div>
                    </div>

                    {{-- Baris 2: Judul Manifes --}}
                    <div>
                        <label class="block font-bold text-gray-700 mb-1.5">Judul Manifes & Esai *</label>
                        <input type="text" name="title" x-model="storyForm.title" required class="w-full rounded-xl border-gray-300 text-xs font-semibold focus:ring-[#005952] focus:border-[#005952]" placeholder="Misal: Meletakkan Fondasi Ekosistem dari Akar Rumput">
                    </div>

                    {{-- Baris 3: Subjudul / Tesis Utama --}}
                    <div>
                        <label class="block font-bold text-gray-700 mb-1.5">Sub-judul / Tesis Utama</label>
                        <input type="text" name="subtitle" x-model="storyForm.subtitle" class="w-full rounded-xl border-gray-300 text-xs focus:ring-[#005952] focus:border-[#005952]" placeholder="Misal: Prinsip Kemandirian Unit Ekonomi dan Validasi Masalah Nyata Sejak Hari Pertama">
                    </div>

                    {{-- Baris 4: Waktu Baca, Status, Cover Image --}}
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                        <div>
                            <label class="block font-bold text-gray-700 mb-1.5">Estimasi Waktu Baca</label>
                            <input type="text" name="reading_time" id="input-reading-time" x-model="storyForm.reading_time" class="w-full rounded-xl border-gray-300 text-xs" placeholder="Misal: 7 Menit Baca">
                        </div>
                        <div>
                            <label class="block font-bold text-gray-700 mb-1.5">Status Publikasi</label>
                            <select name="status" x-model="storyForm.status" class="w-full rounded-xl border-gray-300 text-xs">
                                <option value="published">Terpublikasi (Published)</option>
                                <option value="draft">Draft (Konsep Internal)</option>
                            </select>
                        </div>
                        <div>
                            <label class="block font-bold text-gray-700 mb-1.5">Urutan Tampil (Sort Order)</label>
                            <input type="number" name="sort_order" x-model="storyForm.sort_order" class="w-full rounded-xl border-gray-300 text-xs">
                        </div>
                    </div>

                    {{-- Baris 5: Ringkasan Eksekutif --}}
                    <div>
                        <label class="block font-bold text-gray-700 mb-1.5">Ringkasan Eksekutif (Executive Summary / Excerpt)</label>
                        <textarea name="excerpt" x-model="storyForm.excerpt" rows="2" class="w-full rounded-xl border-gray-300 text-xs leading-relaxed" placeholder="Ringkasan tesis strategis atau intisari pemikiran yang ditampilkan pada kartu pratinjau..."></textarea>
                    </div>

                    {{-- Baris 6: QUILL RICH TEXT EDITOR STUDIO (DENGAN GAMBAR & VIDEO) --}}
                    <div>
                        <div class="flex items-center justify-between mb-1.5">
                            <label class="block font-bold text-gray-700">Naskah Lengkap Manifes (Editor Kaya: Gambar, Video, & Tipografi) *</label>
                            <span class="text-[11px] text-[#005952] font-semibold flex items-center gap-1">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                                <span>Quill Pro Editor Active</span>
                            </span>
                        </div>

                        <div id="quill-story-wrapper" class="relative">
                            {{-- Custom Toolbar --}}
                            <div id="quill-story-toolbar" class="flex flex-wrap items-center gap-1.5">
                                <span class="ql-formats">
                                    <select class="ql-header">
                                        <option value="2">Heading 2</option>
                                        <option value="3">Heading 3</option>
                                        <option selected>Normal</option>
                                    </select>
                                </span>
                                <span class="ql-formats">
                                    <button class="ql-bold" title="Tebal (Ctrl+B)"></button>
                                    <button class="ql-italic" title="Miring (Ctrl+I)"></button>
                                    <button class="ql-underline" title="Garis Bawah (Ctrl+U)"></button>
                                    <button class="ql-strike" title="Coret"></button>
                                </span>
                                <span class="ql-formats">
                                    <select class="ql-color" title="Warna Teks"></select>
                                    <select class="ql-background" title="Warna Latar"></select>
                                </span>
                                <span class="ql-formats">
                                    <button class="ql-blockquote" title="Kutipan / Blockquote"></button>
                                    <button class="ql-code-block" title="Blok Kode"></button>
                                </span>
                                <span class="ql-formats">
                                    <button class="ql-list" value="ordered" title="Daftar Bernomor"></button>
                                    <button class="ql-list" value="bullet" title="Daftar Poin"></button>
                                </span>
                                <span class="ql-formats">
                                    <select class="ql-align" title="Perataan Teks"></select>
                                </span>
                                <span class="ql-formats">
                                    <button class="ql-link" title="Sisipkan Tautan"></button>
                                    {{-- Custom Image Trigger Button --}}
                                    <button type="button" id="btn-story-modal-image" class="hover:text-[#005952] text-gray-700 p-1 rounded-md transition-colors" title="Sisipkan Foto / Gambar">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                    </button>
                                    {{-- Custom Video Trigger Button --}}
                                    <button type="button" id="btn-story-modal-video" class="hover:text-[#005952] text-gray-700 p-1 rounded-md transition-colors" title="Sisipkan Video (YouTube / Vimeo / Shorts / MP4)">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/></svg>
                                    </button>
                                </span>
                                <span class="ql-formats">
                                    <button type="button" id="btn-story-hr" class="text-xs font-bold text-gray-600 hover:text-gray-950 px-1.5" title="Garis Pemisah (Divider)">―</button>
                                    <button class="ql-clean" title="Bersihkan Format"></button>
                                </span>
                                <span class="ql-formats ml-auto flex items-center gap-1">
                                    <button type="button" id="btn-story-undo" class="text-gray-600 hover:text-gray-950 p-1 rounded" title="Undo">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h10a5 5 0 015 5v2m0 0l-4-4m4 4l4-4"/></svg>
                                    </button>
                                    <button type="button" id="btn-story-redo" class="text-gray-600 hover:text-gray-950 p-1 rounded" title="Redo">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 10H11a5 5 0 00-5 5v2m0 0l4-4m-4 4l-4-4"/></svg>
                                    </button>
                                </span>
                            </div>

                            {{-- Editor Canvas --}}
                            <div id="quill-story-editor"></div>

                            {{-- Hidden input synced with Quill --}}
                            <input type="hidden" name="content_html" id="story_content_html" x-model="storyForm.content_html">
                        </div>

                        {{-- Live Content Statistics --}}
                        <div class="flex items-center justify-between text-[11px] text-gray-400 font-mono mt-2 px-1">
                            <div class="flex items-center gap-3">
                                <span id="stat-story-words">0 Kata</span>
                                <span>•</span>
                                <span id="stat-story-chars">0 Karakter</span>
                            </div>
                            <span id="stat-story-read-time" class="text-[#005952] font-semibold">~1 Menit Baca</span>
                        </div>
                    </div>

                    {{-- Form Actions --}}
                    <div class="pt-5 border-t border-gray-100 flex items-center justify-between">
                        <button type="button" @click="storyModal = false" class="px-5 py-2.5 rounded-xl bg-gray-100 hover:bg-gray-200 text-gray-700 font-bold transition-colors">
                            Batal
                        </button>
                        <button type="submit" class="px-6 py-2.5 rounded-xl bg-[#005952] hover:bg-teal-900 text-white font-bold shadow-md transition-colors flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                            <span>Simpan Manifes</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>

        {{-- SUB-MODAL 1: SISIPKAN GAMBAR KE EDITOR MANIFES --}}
        <div id="modal-story-image" class="fixed inset-0 z-60 bg-black/70 backdrop-blur-xs hidden items-center justify-center p-4">
            <div class="bg-white rounded-3xl max-w-lg w-full p-6 shadow-2xl border border-gray-100 space-y-5 text-xs">
                <div class="flex items-center justify-between pb-3 border-b border-gray-100">
                    <h4 class="text-sm font-bold text-gray-900">Sisipkan Gambar ke Naskah Manifes</h4>
                    <button type="button" onclick="closeStoryImageModal()" class="text-gray-400 hover:text-gray-700 text-lg font-bold">&times;</button>
                </div>

                {{-- Tabs: Upload vs URL --}}
                <div class="flex border-b border-gray-200">
                    <button type="button" id="tab-story-img-upload" onclick="switchStoryImgTab('upload')" class="py-2 px-4 border-b-2 border-[#005952] text-[#005952] font-bold">
                        Unggah Foto Lokal
                    </button>
                    <button type="button" id="tab-story-img-url" onclick="switchStoryImgTab('url')" class="py-2 px-4 border-b-2 border-transparent text-gray-500 hover:text-gray-800 font-medium">
                        Tautan URL Web
                    </button>
                </div>

                {{-- Tab 1: Upload File --}}
                <div id="pane-story-img-upload" class="space-y-4">
                    <div 
                        onclick="document.getElementById('input-story-file-img').click()"
                        class="border-2 border-dashed border-gray-300 hover:border-[#005952] rounded-2xl p-6 text-center cursor-pointer transition-colors bg-gray-50 hover:bg-teal-50/40"
                    >
                        <input type="file" id="input-story-file-img" accept="image/*" class="hidden" onchange="handleStoryImageSelect(this)">
                        <svg class="w-8 h-8 text-gray-400 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/></svg>
                        <p class="font-bold text-gray-700">Pilih Foto dari Perangkat</p>
                        <p class="text-[11px] text-gray-400 mt-0.5">JPG, PNG, WebP atau GIF (Maks. 10MB)</p>
                    </div>

                    {{-- Upload Preview --}}
                    <div id="wrapper-story-upload-preview" class="hidden p-3 rounded-xl bg-gray-50 border border-gray-200 flex items-center gap-3">
                        <img id="img-story-upload-preview" src="" class="w-12 h-12 object-cover rounded-lg border border-gray-200">
                        <div class="flex-1 min-w-0">
                            <p id="name-story-upload-preview" class="font-bold text-gray-800 truncate"></p>
                            <p id="size-story-upload-preview" class="text-[10px] text-gray-500 font-mono"></p>
                        </div>
                    </div>

                    {{-- Progress Bar --}}
                    <div id="bar-story-upload-progress" class="hidden w-full bg-gray-200 rounded-full h-2 overflow-hidden">
                        <div id="fill-story-upload-progress" class="bg-[#005952] h-2 transition-all duration-300" style="width: 0%"></div>
                    </div>
                </div>

                {{-- Tab 2: URL Web --}}
                <div id="pane-story-img-url" class="hidden space-y-3">
                    <div>
                        <label class="block font-bold text-gray-700 mb-1">Alamat URL Gambar (HTTPS)</label>
                        <input type="url" id="input-story-url-img" class="w-full rounded-xl border-gray-300 text-xs" placeholder="https://images.unsplash.com/photo-..." oninput="previewStoryImgUrl(this.value)">
                    </div>
                    <div id="wrapper-story-url-preview" class="hidden max-h-40 overflow-hidden rounded-xl border border-gray-200">
                        <img id="img-story-url-preview" src="" class="w-full h-auto object-cover">
                    </div>
                </div>

                {{-- Caption Input --}}
                <div>
                    <label class="block font-bold text-gray-700 mb-1">Keterangan Gambar / Caption (Opsional)</label>
                    <input type="text" id="input-story-img-caption" class="w-full rounded-xl border-gray-300 text-xs" placeholder="Misal: Dokumentasi validasi telemetri mikro di Jawa Barat">
                </div>

                <div class="pt-3 border-t border-gray-100 flex items-center justify-end gap-2">
                    <button type="button" onclick="closeStoryImageModal()" class="px-4 py-2 rounded-xl bg-gray-100 text-gray-700 font-bold hover:bg-gray-200">Batal</button>
                    <button type="button" id="btn-submit-story-image" onclick="submitStoryImage()" class="px-5 py-2 rounded-xl bg-[#005952] text-white font-bold hover:bg-teal-900 shadow-xs">
                        Sisipkan Gambar
                    </button>
                </div>
            </div>
        </div>

        {{-- SUB-MODAL 2: SISIPKAN VIDEO KE EDITOR MANIFES (YOUTUBE, VIMEO, MP4, EMBED) --}}
        <div id="modal-story-video" class="fixed inset-0 z-60 bg-black/70 backdrop-blur-xs hidden items-center justify-center p-4">
            <div class="bg-white rounded-3xl max-w-lg w-full p-6 shadow-2xl border border-gray-100 space-y-5 text-xs">
                <div class="flex items-center justify-between pb-3 border-b border-gray-100">
                    <div>
                        <h4 class="text-sm font-bold text-gray-900">Sisipkan Video ke Naskah Manifes</h4>
                        <p class="text-[11px] text-gray-500">Mendukung YouTube, YouTube Shorts, Vimeo, MP4, atau kode &lt;iframe&gt;</p>
                    </div>
                    <button type="button" onclick="closeStoryVideoModal()" class="text-gray-400 hover:text-gray-700 text-lg font-bold">&times;</button>
                </div>

                <div class="space-y-4">
                    <div>
                        <label class="block font-bold text-gray-700 mb-1">Tautan URL Video atau Kode &lt;iframe&gt; *</label>
                        <input 
                            type="text" 
                            id="input-story-video-url" 
                            class="w-full rounded-xl border-gray-300 text-xs" 
                            placeholder="https://www.youtube.com/watch?v=... atau https://youtu.be/..."
                            oninput="previewStoryVideo(this.value)"
                        >
                        <p class="text-[10px] text-gray-400 mt-1 font-mono">Contoh: https://youtube.com/watch?v=dQw4w9WgXcQ atau shorts</p>
                    </div>

                    {{-- Live Embed Preview --}}
                    <div id="wrapper-story-video-preview" class="hidden aspect-video rounded-xl overflow-hidden border border-gray-200 bg-gray-900">
                        <iframe id="iframe-story-video-preview" class="w-full h-full" src="" frameborder="0" allowfullscreen></iframe>
                    </div>
                </div>

                <div class="pt-3 border-t border-gray-100 flex items-center justify-end gap-2">
                    <button type="button" onclick="closeStoryVideoModal()" class="px-4 py-2 rounded-xl bg-gray-100 text-gray-700 font-bold hover:bg-gray-200">Batal</button>
                    <button type="button" id="btn-submit-story-video" onclick="submitStoryVideo()" class="px-5 py-2 rounded-xl bg-[#005952] text-white font-bold hover:bg-teal-900 shadow-xs">
                        Sisipkan Video
                    </button>
                </div>
            </div>
        </div>

    </div>

    {{-- Quill Rich Text Editor Script & Handler Suite --}}
    <script src="https://cdn.jsdelivr.net/npm/quill@2.0.2/dist/quill.js"></script>
    <script>
        let quillStory = null;
        let storySavedRange = null;
        let currentStoryImgTab = 'upload';
        let selectedStoryImgFile = null;

        // Extract video URL (YouTube standard, shorts, Vimeo, MP4, or iframe)
        function extractVideoEmbedUrl(input) {
            if (!input) return null;
            let url = input.trim();

            const iframeMatch = url.match(/src=["']([^"']+)["']/i);
            if (iframeMatch && iframeMatch[1]) {
                url = iframeMatch[1];
            }

            const ytMatch = url.match(/(?:youtu\.be\/|youtube\.com\/(?:embed\/|v\/|watch\?v=|watch\?.+&v=|shorts\/))([\w-]{11})/i);
            if (ytMatch && ytMatch[1]) {
                return 'https://www.youtube-nocookie.com/embed/' + ytMatch[1] + '?rel=0';
            }

            const vimeoMatch = url.match(/(?:vimeo\.com\/|player\.vimeo\.com\/video\/)(\d+)/i);
            if (vimeoMatch && vimeoMatch[1]) {
                return 'https://player.vimeo.com/video/' + vimeoMatch[1];
            }

            if (url.startsWith('https://') || url.startsWith('http://')) {
                return url;
            }

            return null;
        }

        // Initialize or Update Quill Story Editor
        function initOrUpdateQuillStory(initialHtml = '') {
            const editorEl = document.getElementById('quill-story-editor');
            const hiddenInput = document.getElementById('story_content_html');

            if (!quillStory && editorEl) {
                try {
                    quillStory = new Quill('#quill-story-editor', {
                        modules: {
                            toolbar: {
                                container: '#quill-story-toolbar',
                                handlers: {
                                    'image': openStoryImageModal,
                                    'video': openStoryVideoModal
                                }
                            },
                            history: {
                                delay: 1000,
                                maxStack: 150,
                                userOnly: true
                            }
                        },
                        theme: 'snow',
                        placeholder: 'Tuliskan naskah lengkap manifes, tesis bisnis, metodologi riset, atau pembelajaran kepemimpinan di sini...'
                    });

                    // Synchronize to hidden input and update statistics on change
                    quillStory.on('text-change', function() {
                        if (hiddenInput && quillStory && quillStory.root) {
                            hiddenInput.value = quillStory.root.innerHTML;
                        }
                        updateStoryStatistics();
                    });

                    // Bind Custom Tool buttons
                    document.getElementById('btn-story-modal-image')?.addEventListener('click', function(e) {
                        e.preventDefault();
                        openStoryImageModal();
                    });
                    document.getElementById('btn-story-modal-video')?.addEventListener('click', function(e) {
                        e.preventDefault();
                        openStoryVideoModal();
                    });
                    document.getElementById('btn-story-undo')?.addEventListener('click', function(e) {
                        e.preventDefault();
                        quillStory.history.undo();
                    });
                    document.getElementById('btn-story-redo')?.addEventListener('click', function(e) {
                        e.preventDefault();
                        quillStory.history.redo();
                    });
                    document.getElementById('btn-story-hr')?.addEventListener('click', function(e) {
                        e.preventDefault();
                        const range = quillStory.getSelection(true);
                        quillStory.insertText(range.index, '\n', Quill.sources.USER);
                        quillStory.insertEmbed(range.index + 1, 'divider', true, Quill.sources.USER);
                        quillStory.setSelection(range.index + 2, Quill.sources.SILENT);
                    });

                } catch (e) {
                    console.warn('Quill initialization warning:', e);
                }
            }

            if (quillStory && quillStory.root) {
                quillStory.root.innerHTML = initialHtml || '';
                if (hiddenInput) hiddenInput.value = initialHtml || '';
                updateStoryStatistics();
            }
        }

        // Live statistics update
        function updateStoryStatistics() {
            if (!quillStory) return;
            const text = quillStory.getText().trim();
            const words = text ? text.split(/\s+/).filter(Boolean).length : 0;
            const chars = text.length;
            const readMinutes = Math.max(1, Math.ceil(words / 180));

            const statWords = document.getElementById('stat-story-words');
            const statChars = document.getElementById('stat-story-chars');
            const statReadTime = document.getElementById('stat-story-read-time');
            const inputReadingTime = document.getElementById('input-reading-time');

            if (statWords) statWords.textContent = words.toLocaleString('id-ID') + ' Kata';
            if (statChars) statChars.textContent = chars.toLocaleString('id-ID') + ' Karakter';
            if (statReadTime) statReadTime.textContent = '~' + readMinutes + ' Menit Baca';

            // Auto-fill reading time input if empty or generated
            if (inputReadingTime && (!inputReadingTime.value || inputReadingTime.value.includes('Menit Baca') || inputReadingTime.value.includes('min read'))) {
                inputReadingTime.value = readMinutes + ' Menit Baca';
            }
        }

        // --- IMAGE MODAL FUNCTIONS ---
        function openStoryImageModal() {
            if (quillStory) {
                storySavedRange = quillStory.getSelection() || { index: quillStory.getLength() - 1, length: 0 };
            }
            const modal = document.getElementById('modal-story-image');
            if (modal) {
                modal.classList.remove('hidden');
                modal.classList.add('flex');
            }
            switchStoryImgTab('upload');
        }

        function closeStoryImageModal() {
            const modal = document.getElementById('modal-story-image');
            if (modal) {
                modal.classList.add('hidden');
                modal.classList.remove('flex');
            }
            selectedStoryImgFile = null;
            const fileInput = document.getElementById('input-story-file-img');
            if (fileInput) fileInput.value = '';
            const previewWrap = document.getElementById('wrapper-story-upload-preview');
            if (previewWrap) previewWrap.classList.add('hidden');
            const urlInput = document.getElementById('input-story-url-img');
            if (urlInput) urlInput.value = '';
            const captionInput = document.getElementById('input-story-img-caption');
            if (captionInput) captionInput.value = '';
            const urlPreviewWrap = document.getElementById('wrapper-story-url-preview');
            if (urlPreviewWrap) urlPreviewWrap.classList.add('hidden');
            const progressBar = document.getElementById('bar-story-upload-progress');
            if (progressBar) progressBar.classList.add('hidden');
        }

        function switchStoryImgTab(tab) {
            currentStoryImgTab = tab;
            const btnUpload = document.getElementById('tab-story-img-upload');
            const btnUrl = document.getElementById('tab-story-img-url');
            const paneUpload = document.getElementById('pane-story-img-upload');
            const paneUrl = document.getElementById('pane-story-img-url');

            if (tab === 'upload') {
                btnUpload.className = 'py-2 px-4 border-b-2 border-[#005952] text-[#005952] font-bold';
                btnUrl.className = 'py-2 px-4 border-b-2 border-transparent text-gray-500 hover:text-gray-800 font-medium';
                paneUpload.classList.remove('hidden');
                paneUrl.classList.add('hidden');
            } else {
                btnUrl.className = 'py-2 px-4 border-b-2 border-[#005952] text-[#005952] font-bold';
                btnUpload.className = 'py-2 px-4 border-b-2 border-transparent text-gray-500 hover:text-gray-800 font-medium';
                paneUrl.classList.remove('hidden');
                paneUpload.classList.add('hidden');
            }
        }

        function handleStoryImageSelect(input) {
            if (input.files && input.files[0]) {
                const file = input.files[0];
                selectedStoryImgFile = file;

                const wrapper = document.getElementById('wrapper-story-upload-preview');
                const img = document.getElementById('img-story-upload-preview');
                const name = document.getElementById('name-story-upload-preview');
                const size = document.getElementById('size-story-upload-preview');

                if (wrapper && img && name && size) {
                    name.textContent = file.name;
                    size.textContent = (file.size / 1024 > 1024) 
                        ? (file.size / (1024 * 1024)).toFixed(2) + ' MB' 
                        : (file.size / 1024).toFixed(1) + ' KB';

                    const reader = new FileReader();
                    reader.onload = (e) => {
                        img.src = e.target.result;
                        wrapper.classList.remove('hidden');
                    };
                    reader.readAsDataURL(file);
                }
            }
        }

        function previewStoryImgUrl(url) {
            const wrapper = document.getElementById('wrapper-story-url-preview');
            const img = document.getElementById('img-story-url-preview');
            if (url && url.trim().startsWith('http')) {
                img.src = url.trim();
                wrapper.classList.remove('hidden');
            } else {
                wrapper.classList.add('hidden');
            }
        }

        function submitStoryImage() {
            const caption = document.getElementById('input-story-img-caption')?.value.trim() || '';

            if (currentStoryImgTab === 'upload') {
                if (!selectedStoryImgFile) {
                    alert('Silakan pilih file gambar terlebih dahulu.');
                    return;
                }
                uploadStoryImageFile(selectedStoryImgFile, caption);
            } else {
                const url = document.getElementById('input-story-url-img')?.value.trim();
                if (!url || !url.startsWith('http')) {
                    alert('Silakan masukkan URL gambar yang valid.');
                    return;
                }
                insertStoryImageIntoQuill(url, caption);
                closeStoryImageModal();
            }
        }

        function uploadStoryImageFile(file, caption) {
            const formData = new FormData();
            formData.append('image', file);
            formData.append('_token', '{{ csrf_token() }}');

            const progressBar = document.getElementById('bar-story-upload-progress');
            const progressFill = document.getElementById('fill-story-upload-progress');
            const submitBtn = document.getElementById('btn-submit-story-image');

            if (progressBar) progressBar.classList.remove('hidden');
            if (progressFill) progressFill.style.width = '45%';
            if (submitBtn) {
                submitBtn.disabled = true;
                submitBtn.textContent = 'Mengunggah...';
            }

            fetch('{{ route('admin.people.stories.upload-image') }}', {
                method: 'POST',
                body: formData,
                headers: {
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(res => {
                if (!res.ok) throw new Error('Gagal mengunggah foto ke server.');
                return res.json();
            })
            .then(data => {
                if (progressFill) progressFill.style.width = '100%';
                if (data.success && data.url) {
                    insertStoryImageIntoQuill(data.url, caption);
                    closeStoryImageModal();
                } else {
                    throw new Error(data.message || 'Gagal menyimpan foto.');
                }
            })
            .catch(err => {
                console.warn('Fallback data URL:', err);
                const reader = new FileReader();
                reader.onload = function(e) {
                    insertStoryImageIntoQuill(e.target.result, caption);
                    closeStoryImageModal();
                };
                reader.readAsDataURL(file);
            })
            .finally(() => {
                if (submitBtn) {
                    submitBtn.disabled = false;
                    submitBtn.textContent = 'Sisipkan Gambar';
                }
            });
        }

        function insertStoryImageIntoQuill(imageUrl, caption) {
            if (!quillStory) return;
            const index = storySavedRange ? storySavedRange.index : (quillStory.getSelection() ? quillStory.getSelection().index : quillStory.getLength() - 1);

            quillStory.insertEmbed(index, 'image', imageUrl, Quill.sources.USER);

            if (caption) {
                quillStory.insertText(index + 1, '\n' + caption + '\n', {
                    'italic': true,
                    'color': '#64748b'
                }, Quill.sources.USER);
            }
            quillStory.setSelection(index + (caption ? 2 : 1), Quill.sources.SILENT);
        }

        // --- VIDEO MODAL FUNCTIONS ---
        function openStoryVideoModal() {
            if (quillStory) {
                storySavedRange = quillStory.getSelection() || { index: quillStory.getLength() - 1, length: 0 };
            }
            const modal = document.getElementById('modal-story-video');
            if (modal) {
                modal.classList.remove('hidden');
                modal.classList.add('flex');
            }
            const input = document.getElementById('input-story-video-url');
            if (input) input.value = '';
            const preview = document.getElementById('wrapper-story-video-preview');
            if (preview) preview.classList.add('hidden');
        }

        function closeStoryVideoModal() {
            const modal = document.getElementById('modal-story-video');
            if (modal) {
                modal.classList.add('hidden');
                modal.classList.remove('flex');
            }
        }

        function previewStoryVideo(val) {
            const embedUrl = extractVideoEmbedUrl(val);
            const previewWrapper = document.getElementById('wrapper-story-video-preview');
            const iframe = document.getElementById('iframe-story-video-preview');

            if (embedUrl && previewWrapper && iframe) {
                iframe.src = embedUrl;
                previewWrapper.classList.remove('hidden');
            } else if (previewWrapper) {
                previewWrapper.classList.add('hidden');
            }
        }

        function submitStoryVideo() {
            const inputVal = document.getElementById('input-story-video-url')?.value.trim();
            if (!inputVal) {
                alert('Silakan masukkan tautan URL video.');
                return;
            }
            const embedUrl = extractVideoEmbedUrl(inputVal);
            if (!embedUrl) {
                alert('Tautan video tidak dikenali. Pastikan URL berasal dari YouTube, Vimeo, atau format embed.');
                return;
            }

            if (!quillStory) return;
            const index = storySavedRange ? storySavedRange.index : (quillStory.getSelection() ? quillStory.getSelection().index : quillStory.getLength() - 1);

            quillStory.insertEmbed(index, 'video', embedUrl, Quill.sources.USER);
            quillStory.setSelection(index + 1, Quill.sources.SILENT);
            closeStoryVideoModal();
        }

        // Form submit safety: sync Quill root content into hidden input
        document.getElementById('form-story')?.addEventListener('submit', function(e) {
            const hiddenInput = document.getElementById('story_content_html');
            if (hiddenInput && quillStory && quillStory.root) {
                hiddenInput.value = quillStory.root.innerHTML;
            }
        });
    </script>

    </div>
</x-app-layout>
