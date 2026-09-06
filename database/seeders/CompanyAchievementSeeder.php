<?php

namespace Database\Seeders;

use App\Models\CompanyAchievement;
use App\Models\CompanyProfile;
use Illuminate\Database\Seeder;

class CompanyAchievementSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Seed Achievement Narrative on CompanyProfile
        $profile = CompanyProfile::getProfile();
        $profile->update([
            'achievement_badge' => 'MOMEN, PENGHARGAAN & PITCH DECK',
            'achievement_title' => 'Tonggak Langkah, Penghargaan & Pitch Deck',
            'achievement_summary' => 'Koleksi momen nyata, apresiasi penganugerahan founder, dokumen pitch deck resmi, dan sertifikasi yang menandai perjalanan kami membangun kedaulatan teknologi dan dampak kemanusiaan nusantara.',
            'achievement_content_html' => '<h2>Dedikasi Nyata dari Akar Rumput ke Panggung Nasional</h2>'
                .'<p>Di balik setiap baris kode, arsitektur komputasi awan berdaulat, dan hilirisasi sensor agroteknologi, ada kerja keras tim, diskusi hangat bersama komunitas, serta kepercayaan yang diberikan oleh kementerian dan para mitra strategis.</p>'
                .'<blockquote>"Inovasi sejati bukan hanya tentang kecanggihan teknologi di laboratorium, tetapi tentang seberapa nyata manfaatnya dirasakan oleh masyarakat dan bagaimana generasi muda berani memimpin perubahan."</blockquote>'
                .'<p>Halaman ini kami persembahkan sebagai galeri terbuka: tempat Anda dapat melihat momen penghargaan founder seperti Pemuda Pelopor, mempelajari pitch deck resmi ekosistem YOIN, hingga memeriksa sertifikasi mutu yang kami pegang teguh.</p>',
        ]);

        // 2. Seed Structured Achievements & Moments with Multiple Photos
        $items = [
            [
                'title' => 'Penganugerahan Pemuda Pelopor Bidang Inovasi Teknologi untuk Founder',
                'category' => 'Penghargaan',
                'issuer' => 'Kementerian Pemuda dan Olahraga (Kemenpora RI)',
                'year' => '2025',
                'image' => 'https://images.unsplash.com/photo-1531545514256-b1400bc00f31?auto=format&fit=crop&w=1200&q=80',
                'photos' => [
                    'https://images.unsplash.com/photo-1531545514256-b1400bc00f31?auto=format&fit=crop&w=1200&q=80',
                    'https://images.unsplash.com/photo-1567427017947-545c5f8d16ad?auto=format&fit=crop&w=1200&q=80',
                    'https://images.unsplash.com/photo-1475721027785-f74eccf877e2?auto=format&fit=crop&w=1200&q=80',
                ],
                'description' => 'Momen apresiasi penganugerahan Pemuda Pelopor tingkat nasional untuk Founder YOIN. Penghargaan ini diberikan atas kepeloporan menginisiasi riset teknologi mandiri, kedaulatan data, serta hilirisasi inovasi digital ke pelosok desa.',
                'credential_url' => 'https://yotainovasi.id',
                'badge_label' => 'Pemuda Pelopor',
                'sort_order' => 1,
                'is_featured' => true,
                'is_active' => true,
            ],
            [
                'title' => 'Official Pitch Deck: Peta Jalan & Model Ekosistem YOIN 2025',
                'category' => 'Pitch Deck',
                'issuer' => 'Sekretariat Ekosistem YOIN Nusantara',
                'year' => '2025',
                'image' => 'https://images.unsplash.com/photo-1557804506-669a67965ba0?auto=format&fit=crop&w=1200&q=80',
                'photos' => [
                    'https://images.unsplash.com/photo-1557804506-669a67965ba0?auto=format&fit=crop&w=1200&q=80',
                    'https://images.unsplash.com/photo-1460925895917-afdab827c52f?auto=format&fit=crop&w=1200&q=80',
                    'https://images.unsplash.com/photo-1551836022-d5d88e9218df?auto=format&fit=crop&w=1200&q=80',
                ],
                'description' => 'Dokumen presentasi komprehensif mengenai arsitektur holding, model dividen kemanusiaan, hilirisasi agriteknologi, dan prospek sinergi strategis. Terbuka dipelajari oleh seluruh calon mitra kolaborasi dan investor.',
                'credential_url' => 'https://yotainovasi.id/publikasi',
                'badge_label' => 'Pitch Deck Resmi',
                'sort_order' => 2,
                'is_featured' => true,
                'is_active' => true,
            ],
            [
                'title' => 'Dokumentasi Uji Coba Lapangan Sensor Agroteknologi di Jawa Barat',
                'category' => 'Momen Lapangan',
                'issuer' => 'Sentra Tani Mandiri & Tim Engineer YOIN',
                'year' => '2024',
                'image' => 'https://images.unsplash.com/photo-1592982537447-7440770cbfc9?auto=format&fit=crop&w=1200&q=80',
                'photos' => [
                    'https://images.unsplash.com/photo-1592982537447-7440770cbfc9?auto=format&fit=crop&w=1200&q=80',
                    'https://images.unsplash.com/photo-1581092160607-ee22621dd758?auto=format&fit=crop&w=1200&q=80',
                    'https://images.unsplash.com/photo-1589923188900-85dae523342b?auto=format&fit=crop&w=1200&q=80',
                ],
                'description' => 'Suasana hangat dan penuh antusiasme saat tim engineer bersama founder turun langsung ke lahan sawah petani untuk menguji sensor kelembapan tanah bertenaga surya dan sistem pemantauan cuaca mikro.',
                'credential_url' => 'https://yotainovasi.id/kolaborasi',
                'badge_label' => 'Akar Rumput',
                'sort_order' => 3,
                'is_featured' => true,
                'is_active' => true,
            ],
            [
                'title' => 'Sertifikasi ISO/IEC 27001:2022 Sistem Keamanan Informasi',
                'category' => 'Sertifikasi',
                'issuer' => 'Lembaga Sertifikasi Terakreditasi KAN',
                'year' => '2025',
                'image' => 'https://images.unsplash.com/photo-1450133064473-71024230f91b?auto=format&fit=crop&w=1200&q=80',
                'photos' => [
                    'https://images.unsplash.com/photo-1450133064473-71024230f91b?auto=format&fit=crop&w=1200&q=80',
                    'https://images.unsplash.com/photo-1454165804606-c3d57bc86b40?auto=format&fit=crop&w=1200&q=80',
                ],
                'description' => 'Bukti audit resmi atas kepatuhan standar internasional keamanan data, proteksi privasi, dan integritas infrastruktur cloud mandiri yang kami bangun tanpa ketergantungan asing.',
                'credential_url' => 'https://yotainovasi.id',
                'badge_label' => 'Standar Global',
                'sort_order' => 4,
                'is_featured' => false,
                'is_active' => true,
            ],
            [
                'title' => 'Presentasi Sinergi Riset Terapan di Hadapan Sivitas Akademika',
                'category' => 'Pitch Deck',
                'issuer' => 'Konsorsium Perguruan Tinggi Mitra',
                'year' => '2024',
                'image' => 'https://images.unsplash.com/photo-1524178232363-1fb2b075b655?auto=format&fit=crop&w=1200&q=80',
                'photos' => [
                    'https://images.unsplash.com/photo-1524178232363-1fb2b075b655?auto=format&fit=crop&w=1200&q=80',
                    'https://images.unsplash.com/photo-1517245386807-bb43f82c33c4?auto=format&fit=crop&w=1200&q=80',
                ],
                'description' => 'Sesi diskusi interaktif dan pemaparan proposal riset teknologi komputasi awan domestik bersama dosen, peneliti, dan mahasiswa di auditorium kampus mitra konsorsium.',
                'credential_url' => 'https://yotainovasi.id/kolaborasi',
                'badge_label' => 'Forum Akademik',
                'sort_order' => 5,
                'is_featured' => false,
                'is_active' => true,
            ],
            [
                'title' => 'Penghargaan Inovator Hilirisasi Agroteknologi & Sains Nusantara',
                'category' => 'Penghargaan',
                'issuer' => 'Forum Akselerasi Riset & Inovasi Terapan',
                'year' => '2024',
                'image' => 'https://images.unsplash.com/photo-1567427017947-545c5f8d16ad?auto=format&fit=crop&w=1200&q=80',
                'description' => 'Apresiasi atas keberhasilan mengintegrasikan riset IoT tanah presisi dan rantai pasok maritim yang secara nyata menaikkan produktivitas panen petani di 34 sentra binaan.',
                'credential_url' => 'https://yotainovasi.id',
                'badge_label' => 'Inovasi Sains',
                'sort_order' => 6,
                'is_featured' => false,
                'is_active' => true,
            ],
            [
                'title' => 'Pencatatan Resmi HAKI Hak Cipta Core Architecture Engine',
                'category' => 'Sertifikasi',
                'issuer' => 'Ditjen Kekayaan Intelektual Kemenkumham RI',
                'year' => '2024',
                'image' => 'https://images.unsplash.com/photo-1589829545856-d10d557cf95f?auto=format&fit=crop&w=1200&q=80',
                'description' => 'Sertifikat resmi perlindungan kekayaan intelektual atas rancang bangun sistem operasi holding dan manajemen data terdistribusi ciptaan tim engineer lokal YOIN.',
                'credential_url' => 'https://yotainovasi.id',
                'badge_label' => 'HAKI & Cipta',
                'sort_order' => 7,
                'is_featured' => false,
                'is_active' => true,
            ],
        ];

        foreach ($items as $item) {
            CompanyAchievement::updateOrCreate(
                ['title' => $item['title']],
                $item
            );
        }
    }
}
