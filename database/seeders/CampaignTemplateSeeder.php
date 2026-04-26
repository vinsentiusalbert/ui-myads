<?php

namespace Database\Seeders;

use App\Models\CampaignTemplate;
use Illuminate\Database\Seeder;

class CampaignTemplateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $templates = [
            [
                'name' => 'idc_397_260414_ar4_simpati_wfh',
                'created_at' => '2026-04-14 11:04:00',
                'body' => 'Butuh kuota besar untuk Work From Home tapi budget terbatas? SIMPATI punya promo spesial untuk kamu.',
            ],
            [
                'name' => 'idc_236_251105_ar4_hvc_local_baseline',
                'created_at' => '2025-11-05 14:59:00',
                'body' => 'Tabe ada Flash Sale Super Seru khusus untuk pelanggan Prioritas. Kuota besar dengan harga spesial.',
            ],
            [
                'name' => 'idc_235_251105_ar4_hvc_spcial_offer',
                'created_at' => '2025-11-05 14:52:00',
                'body' => 'Karena Kamu Prioritas, Kenyamanan Harus Tanpa Batas. Dapatkan penawaran kuota terbaik hari ini.',
            ],
            [
                'name' => 'idc_234_251105_ar4_hvc_churn_push',
                'created_at' => '2025-11-05 14:51:00',
                'body' => 'Kami merindukan Anda untuk menikmati benefit pelanggan Prioritas. Flash sale terbatas sudah tersedia.',
            ],
            [
                'name' => 'idc_233_251105_ar4_hvc_urgency_boost',
                'created_at' => '2025-11-05 14:48:00',
                'body' => 'Kuota besar 65GB hanya 5 hari di Flash Sales Super Seru, nikmati kuota besar dengan harga hemat.',
            ],
        ];

        foreach ($templates as $template) {
            CampaignTemplate::updateOrCreate(
                ['name' => $template['name']],
                [
                    'template_type' => 'simple_message',
                    'category' => 'Single Banner',
                    'language' => 'Indonesia',
                    'header_type' => 'image',
                    'body' => $template['body'],
                    'footer' => null,
                    'buttons' => [
                        ['type' => 'visit_website', 'text' => 'Coba Sekarang', 'url' => 'https://www.telkomsel.com'],
                    ],
                    'status' => 'APPROVED',
                    'created_at' => $template['created_at'],
                    'updated_at' => $template['created_at'],
                ],
            );
        }
    }
}
