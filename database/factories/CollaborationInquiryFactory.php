<?php

namespace Database\Factories;

use App\Models\CollaborationInquiry;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<CollaborationInquiry>
 */
class CollaborationInquiryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'email' => fake()->safeEmail(),
            'phone' => fake()->phoneNumber(),
            'category' => fake()->randomElement([
                'Inovasi & Akselerasi Inisiatif',
                'Layanan Digital & IT Solutions',
                'Teknologi Pertanian & Maritim',
                'Desain Produk & Material Sirkular',
                'Inisiatif Masa Depan & IKN',
                'Dampak Sosial & Program ESG',
            ]),
            'message' => fake()->paragraph(3),
            'status' => 'baru',
            'admin_notes' => null,
            'ip_address' => fake()->ipv4(),
            'user_agent' => fake()->userAgent(),
            'read_at' => null,
        ];
    }
}
