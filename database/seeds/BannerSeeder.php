<?php

use App\Models\Banner\Banner;
use App\Models\Banner\BannerKategori;
use Illuminate\Database\Seeder;

class BannerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $kategori = [
            0 => [
                'judul' => 'Banner Home',
                'keterangan' => null,
            ],
            1 => [
                'judul' => 'Banner Login',
                'keterangan' => '<h1>SPEAKOUD E-Learning System</h1>
                                    <h5>Layanan Pelatihan Jarak Jauh oleh SPEAKOUD.</h5>'
            ],
        ];

        $banner = [
            0 => [
                'banner_kategori_id' => 1,
                'file' => 'slide-1.jpg',
                'judul' => 'SPEAKOUD',
                'keterangan' => '<h5>Sistem Pembelajaran untuk Edukasi Dan Konsultasi Digital</h5>',
                'link' => 'javascript:;',
            ],
            1 => [
                'banner_kategori_id' => 1,
                'file' => 'slide-2.jpg',
                'judul' => 'SINERGI DIGITAL',
                'keterangan' => '<h5>Mendukung Sistem Manajemen Pembelajaran Hybrid Dengan Modul Beragam</h5>',
                'link' => 'javascript:;',
            ],
            2 => [
                'banner_kategori_id' => 1,
                'file' => 'slide-3.jpg',
                'judul' => 'Interaktif',
                'keterangan' => '<h5>Tingkatkan pengetahuan dan keterampilan anda bersama kami, kapan pun dan dimana pun.</h5>',
                'link' => 'javascript:;',
            ],
            3 => [
                'banner_kategori_id' => 2,
                'file' => 'slide-1.jpg',
                'judul' => 'Banner 1',
                'keterangan' => null,
                'link' => null,
            ],
            4 => [
                'banner_kategori_id' => 2,
                'file' => 'slide-2.jpg',
                'judul' => 'Banner 2',
                'keterangan' => null,
                'link' => null,
            ],
        ];

        foreach ($kategori as $key => $value) {
            BannerKategori::create([
                'judul' => $value['judul'],
                'keterangan' => $value['keterangan'],
            ]);
        }

        foreach ($banner as $key => $value) {
            Banner::create([
                'banner_kategori_id' => $value['banner_kategori_id'],
                'creator_id' => 1,
                'file' => $value['file'],
                'judul' => $value['judul'],
                'keterangan' => $value['keterangan'],
                'link' => $value['link'],
                'publish' => 1,
                'urutan' => ($key + 1),
            ]);
        }
    }
}
