<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompanyProfile extends Model
{
    use HasFactory;

    /**
     * @var list<string>
     */
    protected $fillable = [
        'hero_badge',
        'company_name',
        'tagline',
        'summary',
        'content_html',
        'hero_image',
        'legal_entity_name',
        'legal_registration_info',
        'office_address',
        'contact_email',
        'contact_phone',
        'highlights',
        'meta_title',
        'meta_description',
        'achievement_badge',
        'achievement_title',
        'achievement_summary',
        'achievement_content_html',
        'invest_badge',
        'invest_title',
        'invest_subtitle',
        'invest_summary',
        'invest_content_html',
        'invest_metrics',
        'invest_deck_url',
        'invest_data_room_url',
        'invest_resources',
    ];

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'highlights' => 'array',
            'invest_metrics' => 'array',
            'invest_resources' => 'array',
        ];
    }

    /**
     * Retrieve the primary singleton CompanyProfile instance or create default.
     */
    public static function getProfile(): self
    {
        $profile = self::first();

        if (! $profile) {
            $profile = self::create([
                'hero_badge' => 'IDENTITAS RESMI PT YOTA INOVASI NUSANTARA',
                'company_name' => 'PT Yota Inovasi Nusantara',
                'tagline' => 'Orkestrasi Inovasi Teknologi Berkelanjutan Nusantara',
                'summary' => 'PT Yota Inovasi Nusantara (YOIN) adalah ekosistem holding inovasi mandiri yang mengintegrasikan rekayasa piranti lunak berdaulat, teknologi sirkular, pertanian cerdas, serta alokasi seluruh keuntungan operasional bagi kemanusiaan.',
                'content_html' => self::defaultContentHtml(),
                'hero_image' => 'https://images.unsplash.com/photo-1486406146926-c627a92ad1ab?auto=format&fit=crop&w=1600&q=80',
                'legal_entity_name' => 'PT Yota Inovasi Nusantara',
                'legal_registration_info' => 'Terdaftar secara sah di Kementerian Hukum dan HAM Republik Indonesia sebagai perseroan terbatas bidang teknologi informasi, riset, dan konsultasi inovasi strategis.',
                'office_address' => 'Perumahan Jatimekar residence, Blk. C No.26, RT./RW/RW.002/011, Malakasari, Kec. Baleendah, Kabupaten Bandung, Jawa Barat 40375',
                'contact_email' => 'hello@yotainovasi.id',
                'contact_phone' => '0858 6231 9524',
                'highlights' => self::defaultHighlights(),
                'meta_title' => 'Profil Perusahaan & Ekosistem - PT Yota Inovasi Nusantara',
                'meta_description' => 'Profil resmi PT Yota Inovasi Nusantara (YOIN). Holding inovasi teknologi berkelanjutan, riset terpadu, kedaulatan digital, dan dividen kemanusiaan di Indonesia.',
            ]);
        }

        if (empty($profile->invest_title) || str_contains($profile->invest_subtitle ?? '', 'YOTA')) {
            $profile->update([
                'invest_badge' => 'VENTURE ECOSYSTEM BUILDER',
                'invest_title' => 'Building Companies From the Ground Up',
                'invest_subtitle' => 'YOIN Inovasi Nusantara',
                'invest_summary' => 'We are building a venture ecosystem from Indonesia — creating focused businesses around real problems in technology, agriculture, products, and community development. YOIN is not built around a single product. We build people, ideas, products, and ventures — then give each one the space to find its own market, team, and direction.',
                'invest_content_html' => self::defaultInvestContentHtml(),
                'invest_metrics' => self::defaultInvestMetrics(),
                'invest_resources' => self::defaultInvestResources(),
            ]);
        }

        return $profile;
    }

    /**
     * @return list<array<string, string>>
     */
    public static function defaultHighlights(): array
    {
        return [
            [
                'number' => '01',
                'title' => 'Kedaulatan Digital',
                'description' => 'Membangun infrastruktur cloud berstandar industri, sistem cerdas, dan keamanan data mandiri di tanah air.',
            ],
            [
                'number' => '02',
                'title' => 'Hilirisasi Riset Terpadu',
                'description' => 'Menjembatani inovasi kampus dan laboratorium menuju implementasi nyata dalam industri dan masyarakat.',
            ],
            [
                'number' => '03',
                'title' => 'Dividen Kemanusiaan',
                'description' => 'Seluruh keuntungan operasional dialokasikan untuk pendidikan inklusif, kelestarian alam, dan program sosial.',
            ],
        ];
    }

    /**
     * Default rich text editorial content.
     */
    public static function defaultContentHtml(): string
    {
        return '<h2>Tentang Ekosistem YOIN</h2>'
            .'<p>PT Yota Inovasi Nusantara didirikan sebagai respon atas tantangan kedaulatan teknologi dan kebutuhan percepatan hilirisasi riset di Indonesia. Beroperasi dengan model holding inovasi multi-domain, kami memadukan kemampuan rekayasa perangkat lunak modern, agroteknologi sirkular, dan komitmen filantropi terstruktur.</p>'
            .'<blockquote>"Teknologi bukan sekadar alat efisiensi, melainkan instrumen kedaulatan bangsa dan sarana pemerataan kesejahteraan sosial."</blockquote>'
            .'<h3>Pilar Strategis Kami</h3>'
            .'<p>Melalui unit riset dan inisiatif komersial kami, setiap produk yang dikembangkan dituntut memenuhi standar keandalan tinggi, arsitektur terbuka, dan dampak lingkungan yang terukur. Kami berkolaborasi erat dengan lembaga riset terkemuka, kementerian, BUMN, serta asosiasi petani dan pelaku usaha daerah.</p>'
            .'<ul>'
            .'<li><strong>Riset & Rekayasa Mandiri:</strong> Pengembangan platform digital berdaulat dari hulu ke hilir.</li>'
            .'<li><strong>Ekonomi Sirkular Berdampak:</strong> Pengelolaan sumber daya hayati dan limbah material menjadi komoditas bernilai tinggi.</li>'
            .'<li><strong>Transparansi Tata Kelola:</strong> Audit dampak berkala dan pembagian dividen kemanusiaan yang terverifikasi.</li>'
            .'</ul>';
    }

    /**
     * @return list<array<string, string>>
     */
    public static function defaultInvestMetrics(): array
    {
        return [
            ['key' => 'projects_delivered', 'label' => 'Projects Delivered', 'value' => '24+'],
            ['key' => 'clients_partners', 'label' => 'Clients & Partners', 'value' => '30+'],
            ['key' => 'people_ecosystem', 'label' => 'People Across Ecosystem', 'value' => '150+'],
            ['key' => 'active_ventures', 'label' => 'Active Ventures & Initiatives', 'value' => '5'],
            ['key' => 'communities_reached', 'label' => 'Communities Reached', 'value' => '34'],
            ['key' => 'years_building', 'label' => 'Years Building', 'value' => '4+'],
            ['key' => 'cumulative_gmv', 'label' => 'Cumulative Revenue / GMV', 'value' => 'Rp 12.5 M*'],
            ['key' => 'growth_rate', 'label' => 'YoY Platform Growth', 'value' => '140%'],
        ];
    }

    /**
     * @return list<array<string, string>>
     */
    public static function defaultInvestResources(): array
    {
        return [
            [
                'title' => 'Investor Deck',
                'description' => 'Overview of YOIN, ecosystem, ventures, traction, strategy, and investment opportunity.',
                'action_label' => 'Download / Request Deck →',
                'url' => '#request-deck',
                'type' => 'deck',
            ],
            [
                'title' => 'Company Profile',
                'description' => 'Corporate profile and organizational overview of YOIN.',
                'action_label' => 'Download Profile →',
                'url' => '#company-profile',
                'type' => 'profile',
            ],
            [
                'title' => 'Impact & ESG Report',
                'description' => 'Programs, impact metrics, and community initiatives through YOIN Adiwidya Center.',
                'action_label' => 'View Report →',
                'url' => '/dampak',
                'type' => 'impact',
            ],
            [
                'title' => 'Financial / Performance Summary',
                'description' => 'Selected business and performance indicators.',
                'action_label' => 'Request Access →',
                'url' => '#request-data-room',
                'type' => 'financial',
            ],
            [
                'title' => 'Data Room',
                'description' => 'Detailed materials available for qualified investors.',
                'action_label' => 'Request Access →',
                'url' => '#request-data-room',
                'type' => 'dataroom',
            ],
        ];
    }

    /**
     * Default rich text investment manifesto content.
     */
    public static function defaultInvestContentHtml(): string
    {
        return '<h2>WHY YOIN, WHY NOW</h2>'
            .'<p>Indonesia is changing fast. We want to build where the change is happening.</p>'
            .'<p>Indonesia’s economy grew 5.11% in 2025, reaching approximately Rp23,821.1 trillion in GDP. More than 64 million MSMEs represent over 60% of national GDP and nearly 97% of employment, making business digitalization and productivity a massive structural opportunity.</p>'
            .'<p>Meanwhile, Southeast Asia’s digital economy is projected to surpass US$300 billion in GMV in 2025, with digital-economy revenue projected at US$135 billion. The region has also attracted approximately US$120 billion in private funding over the past decade.</p>'
            .'<blockquote>"The opportunity isn\'t one market. It is the intersection of Digital Transformation, Agriculture & Food Systems, AI & Emerging Technology, Entrepreneurship & MSMEs, and Community Development. We believe some of the next important companies will emerge from problems that are still being solved inefficiently today."</blockquote>'
            .'<h2>OUR THESIS: Find. Build. Validate. Grow.</h2>'
            .'<p>We don\'t begin by asking: <em>"What startup should we build?"</em> We begin with: <strong>"What problem is worth solving?"</strong></p>'
            .'<ul>'
            .'<li><strong>01 — DISCOVER:</strong> We go where problems actually exist.</li>'
            .'<li><strong>02 — EXPLORE:</strong> We work with users, communities, businesses, and partners.</li>'
            .'<li><strong>03 — BUILD:</strong> We turn validated opportunities into products and ventures.</li>'
            .'<li><strong>04 — VALIDATE:</strong> We test them in the real world.</li>'
            .'<li><strong>05 — SCALE:</strong> When a venture demonstrates traction, we invest deeper.</li>'
            .'</ul>'
            .'<h2>ONE ECOSYSTEM. DIFFERENT BETS.</h2>'
            .'<p>YOIN is the platform. Each venture has its own team, product, market, business model, and growth strategy, while YOIN provides the shared foundation: capital, talent, technology, network, knowledge, operations, and brand.</p>'
            .'<h2>THE LONG-TERM VISION</h2>'
            .'<p>Today, we are building ventures. Tomorrow, we want to build an institution that knows how to build them repeatedly. YOIN’s ambition is not to become known for having the most companies. It is to become known for building meaningful companies from the ground up — From Indonesia, For Indonesia, and eventually, for markets beyond it.</p>';
    }
}
