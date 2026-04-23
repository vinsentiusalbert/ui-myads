<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;

class CampaignMenuController extends Controller
{
    public function show(string $channel, string $menu): View
    {
        $pages = $this->pages();

        abort_unless(isset($pages[$channel][$menu]), 404);

        $page = $pages[$channel][$menu];

        if ($menu === 'location-based-area') {
            return view('campaign-lba', [
                'channel' => $channel,
                'menu' => $menu,
                'page' => $page,
            ]);
        }

        return view('campaign-menu', [
            'channel' => $channel,
            'menu' => $menu,
            'page' => $page,
        ]);
    }

    private function pages(): array
    {
        $lbaShots = [
            'image15.png' => 'Pilih kategori iklan untuk masuk ke Location Based Advertising.',
            'image16.png' => 'Form pembuatan iklan LBA dan pengisian detail awal campaign.',
            'image17.png' => 'Pencarian lokasi pada peta untuk menentukan area target.',
            'image18.png' => 'Atur radius dan tipe lokasi untuk menghitung penerima potensial.',
            'image19.png' => 'Review titik lokasi dan simpan pengaturan area kampanye.',
            'image20.png' => 'Ringkasan pengaturan lokasi sebelum melanjutkan proses.',
            'image21.png' => 'Susun konten pesan dan informasi pengirim untuk iklan berbasis lokasi.',
            'image22.png' => 'Lihat preview pesan dan detail segmentasi penerima.',
            'image23.png' => 'Review biaya dan detail campaign sebelum pembayaran.',
            'image24.png' => 'Halaman menunggu persetujuan setelah campaign LBA dikirim.',
        ];

        $broadcastShots = [
            'image25.png' => 'Mulai dari form pembuatan iklan broadcast SMS.',
            'image26.png' => 'Atur konten pesan, pengirim, dan profil penerima.',
            'image27.png' => 'Tentukan jadwal pengiriman dan konfigurasi tambahan.',
            'image28.png' => 'Preview isi pesan broadcast yang akan dikirim.',
            'image29.png' => 'Review keseluruhan campaign broadcast sebelum proses bayar.',
            'image30.png' => 'Rincian biaya campaign untuk kanal broadcast.',
            'image31.png' => 'Status menunggu persetujuan setelah iklan broadcast dikirim.',
        ];

        $targetedShots = [
            'image32.png' => 'Buka flow targeted SMS dan beri judul campaign.',
            'image33.png' => 'Lengkapi konten pesan iklan targeted.',
            'image34.png' => 'Pilih kategori audience dan segmentasi penerima.',
            'image35.png' => 'Atur filter profil untuk audience targeted.',
            'image36.png' => 'Tentukan waktu pengiriman untuk audience pilihan.',
            'image37.png' => 'Preview pesan serta ringkasan target audience.',
            'image38.png' => 'Review biaya dan detail pembayaran targeted SMS.',
            'image39.png' => 'Halaman approval setelah campaign targeted diajukan.',
        ];

        return [
            'sms' => [
                'location-based-area' => [
                    'title' => 'SMS Location Based Area',
                    'headline' => 'Mulai campaign SMS Location Based Area dari judul iklan',
                    'description' => 'Flow ini dimulai dari modal judul iklan, lalu dilanjutkan ke tahap buat konten iklan dengan preview pesan dan stepper campaign.',
                    'badge' => 'SMS LBA',
                    'steps' => [
                        'Buat Konten Iklan',
                        'Atur Pengiriman',
                        'Review & Pembayaran',
                        'Menunggu Persetujuan',
                    ],
                ],
                'broadcast' => [
                    'title' => 'SMS Broadcast',
                    'headline' => 'Flow campaign broadcast SMS dari draft sampai approval',
                    'description' => 'Struktur halaman mengikuti deck PPT untuk pembuatan broadcast SMS, termasuk konten iklan, waktu pengiriman, preview, review biaya, dan status approval.',
                    'badge' => 'SMS Broadcast',
                    'steps' => [
                        'Buat konten iklan',
                        'Atur pengiriman',
                        'Preview pesan',
                        'Review pembayaran',
                        'Menunggu persetujuan',
                    ],
                    'screenshots' => $broadcastShots,
                ],
                'targeted' => [
                    'title' => 'SMS Targeted',
                    'headline' => 'Flow campaign targeted SMS berbasis audience',
                    'description' => 'Halaman ini memetakan step pada deck targeted SMS: judul iklan, isi pesan, filter audience, jadwal kirim, review biaya, dan approval.',
                    'badge' => 'SMS Targeted',
                    'steps' => [
                        'Judul campaign',
                        'Konten pesan',
                        'Filter audience',
                        'Atur jadwal',
                        'Review & approval',
                    ],
                    'screenshots' => $targetedShots,
                ],
            ],
            'wa-business' => [
                'location-based-area' => [
                    'title' => 'WA Business Location Based Area',
                    'headline' => 'Dummy flow WA Business berbasis lokasi',
                    'description' => 'Tampilan ini memakai fungsi dummy yang sama seperti LBA SMS namun dengan konteks channel WA Business agar tiap menu sudah terpasang sesuai fungsi dasarnya.',
                    'badge' => 'WA LBA',
                    'steps' => [
                        'Pilih kategori',
                        'Buat judul',
                        'Konten pesan',
                        'Atur lokasi',
                        'Atur profil',
                        'Review',
                    ],
                ],
                'broadcast' => [
                    'title' => 'WA Business Broadcast',
                    'headline' => 'Template flow broadcast WA Business',
                    'description' => 'Halaman ini memakai struktur visual broadcast dari deck agar setiap menu sudah terpasang rapi dengan template yang sama.',
                    'badge' => 'WA Broadcast',
                    'steps' => [
                        'Buat konten broadcast',
                        'Atur pengiriman',
                        'Preview pesan',
                        'Review pembayaran',
                        'Menunggu persetujuan',
                    ],
                    'screenshots' => $broadcastShots,
                ],
                'targeted' => [
                    'title' => 'WA Business Targeted',
                    'headline' => 'Template flow targeted WA Business',
                    'description' => 'Tampilan mengikuti alur targeted dari deck sebagai baseline, lalu dipasang ke menu WA Business agar pengalaman antar menu tetap konsisten.',
                    'badge' => 'WA Targeted',
                    'steps' => [
                        'Judul campaign',
                        'Konten pesan',
                        'Pilih audience',
                        'Jadwalkan kirim',
                        'Review & approval',
                    ],
                    'screenshots' => $targetedShots,
                ],
            ],
        ];
    }
}
