<?php

namespace Database\Seeders;

use App\Models\MenuHighlight;
use Illuminate\Database\Seeder;

class MenuHighlightSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $cards = [
            [
                'title_id' => 'ABOUT US',
                'title_en' => 'ABOUT US',
                'badge_id' => 'TENTANG KAMI',
                'badge_en' => 'ABOUT US',
                'subtitle_id' => 'Mitra Transformasi Digital & Kemanusiaan',
                'subtitle_en' => 'Digital Transformation & Humanity',
                'image_url' => 'https://images.unsplash.com/photo-1528605248644-14dd04022da1?q=80&w=1000&auto=format&fit=crop',
                'link_url' => '#ecosystem',
                'sort_order' => 1,
                'is_active' => true,
            ],
            [
                'title_id' => 'CONSERVATION',
                'title_en' => 'CONSERVATION',
                'badge_id' => 'KONSERVASI & INOVASI',
                'badge_en' => 'CONSERVATION & INNOVATION',
                'subtitle_id' => 'Inisiatif Alam & Keberlanjutan Presisi',
                'subtitle_en' => 'Nature Initiatives & Sustainability',
                'image_url' => 'https://images.unsplash.com/photo-1511497584788-87676104235f?q=80&w=1000&auto=format&fit=crop',
                'link_url' => '#inisiatif-unggulan',
                'sort_order' => 2,
                'is_active' => true,
            ],
            [
                'title_id' => 'BLOG',
                'title_en' => 'BLOG',
                'badge_id' => 'JURNAL & RISET',
                'badge_en' => 'JOURNAL & RESEARCH',
                'subtitle_id' => 'Wawasan Riset & Dokumentasi Terbuka',
                'subtitle_en' => 'Research Insights & Open Notes',
                'image_url' => 'https://images.unsplash.com/photo-1544551763-46a013bb70d5?q=80&w=1000&auto=format&fit=crop',
                'link_url' => '/publikasi',
                'sort_order' => 3,
                'is_active' => true,
            ],
            [
                'title_id' => 'FAQ',
                'title_en' => 'FAQ',
                'badge_id' => 'FAQ & DAMPAK',
                'badge_en' => 'FAQ & IMPACT',
                'subtitle_id' => 'Pertanyaan Umum & Bantuan Kolaborasi',
                'subtitle_en' => 'Frequently Asked & Collaboration Help',
                'image_url' => 'https://images.unsplash.com/photo-1507525428034-b723cf961d3e?q=80&w=1000&auto=format&fit=crop',
                'link_url' => '#impact',
                'sort_order' => 4,
                'is_active' => true,
            ],
        ];

        foreach ($cards as $card) {
            MenuHighlight::updateOrCreate(
                ['sort_order' => $card['sort_order']],
                $card
            );
        }
    }
}
