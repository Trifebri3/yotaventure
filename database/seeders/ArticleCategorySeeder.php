<?php

namespace Database\Seeders;

use App\Models\ArticleCategory;
use Illuminate\Database\Seeder;

class ArticleCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'slug' => 'inisiatif',
                'name_id' => 'INISIATIF UNGGULAN',
                'name_en' => 'FEATURED INITIATIVES',
                'subtitle_id' => 'Kedaulatan Energi, Pangan & Teknologi',
                'subtitle_en' => 'Energy, Food & Technology Sovereignty',
                'description_id' => 'Inisiatif strategis hilirisasi riset terapan untuk ketahanan dan kemandirian ekosistem nusantara.',
                'description_en' => 'Strategic downstream applied research initiatives for archipelago resilience.',
                'image_url' => 'https://images.unsplash.com/photo-1497440001374-f26997328c1b?q=80&w=1000&auto=format&fit=crop',
                'sort_order' => 1,
                'is_active' => true,
            ],
            [
                'slug' => 'jurnal',
                'name_id' => 'JURNAL RISET',
                'name_en' => 'RESEARCH JOURNALS',
                'subtitle_id' => 'Kajian Ilmiah & Data Lapangan',
                'subtitle_en' => 'Scientific Studies & Field Data',
                'description_id' => 'Publikasi berkala hasil riset ilmiah, telaah teknologi maritim, dan studi biodiversitas terapan.',
                'description_en' => 'Periodic scientific publications, maritime tech reviews, and applied biodiversity studies.',
                'image_url' => 'https://images.unsplash.com/photo-1507668077129-56e32842fceb?q=80&w=1000&auto=format&fit=crop',
                'sort_order' => 2,
                'is_active' => true,
            ],
            [
                'slug' => 'publikasi',
                'name_id' => 'PUBLIKASI RESMI',
                'name_en' => 'OFFICIAL PUBLICATIONS',
                'subtitle_id' => 'Laporan Kebijakan & Dokumen Terbuka',
                'subtitle_en' => 'Policy Reports & Open Documents',
                'description_id' => 'Arsip dokumentasi resmi, panduan teknis implementasi, dan rilis wawasan strategis ekosistem.',
                'description_en' => 'Official whitepapers, technical implementation guides, and strategic releases.',
                'image_url' => 'https://images.unsplash.com/photo-1450133064473-71024230f91b?q=80&w=1000&auto=format&fit=crop',
                'sort_order' => 3,
                'is_active' => true,
            ],
            [
                'slug' => 'artikel',
                'name_id' => 'ARTIKEL & BLOG',
                'name_en' => 'ARTICLES & BLOG',
                'subtitle_id' => 'Narasi Lapangan & Cerita Komunitas',
                'subtitle_en' => 'Field Narratives & Community Stories',
                'description_id' => 'Catatan perjalanan lapangan, profil penggerak komunitas lokal, dan refleksi kemanusiaan nusantara.',
                'description_en' => 'Field trip chronicles, community champion profiles, and humanitarian reflections.',
                'image_url' => 'https://images.unsplash.com/photo-1528605248644-14dd04022da1?q=80&w=1000&auto=format&fit=crop',
                'sort_order' => 4,
                'is_active' => true,
            ],
        ];

        foreach ($categories as $cat) {
            ArticleCategory::updateOrCreate(
                ['slug' => $cat['slug']],
                $cat
            );
        }
    }
}
