<?php

use App\Models\Page;
use Illuminate\Database\Seeder;

class PageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $pages = [
            0 => [
                'parent' => 0,
                'judul' => 'Selamat Datang di BELS: BPPT E-Learning System',
                'slug' => 'selamat-datang-di-bels-bppt-elearning-system',
                'intro' => null,
                'content' => '<p>Pusat Pembinaan, Pendidikan dan Pelatihan (Pusbindiklat) Badan Pengkajian dan Penerapan Teknologi (BPPT) bertugas melaksanakan pembinaan, menyelenggarakan pendidikan dan pelatihan perekayasaan teknologi dan pelatihan bidang lainnya. Kegiatan pendidikan dan pelatihan yang telah dilakukan selama ini merupakan kontribusi nyata Pusbindiklat dalam mempersiapkan sumber daya manusia indonesia yang profesional dan kompeten di bidang ilmu pengetahuan dan teknologi (IPTEK).</p>
                                <p>Dalam rangka memudahkan peserta pelatihan dalam mengikuti pelatihan yang kami selenggarakan, kini kami memfasilitasi pembelajaran secara daring melalui BELS (BPPT E-Learning System). Dengan begitu, para peserta pelatihan dapat mengkuti kegiatan pembelajaran yang kami selenggarakan secara daring dimana saja, dan kapan saja sesuai dengan kebutuhan peserta diklat.</p>
                                <p>Selamat Belajar!</p>',
                'cover' => [
                    'filename' => 'bg-panduan.jpg',
                    'title' => null,
                    'alt' => null,
                ],
                'meta_data' => [
                    'title' => null,
                    'description' => null,
                    'keywords' => null
                ],
            ],
            1 => [
                'parent' => 0,
                'judul' => 'Tentang Kami',
                'slug' => 'tentang-kami',
                'intro' => null,
                'content' => null,
                'cover' => [
                    'filename' => null,
                    'title' => null,
                    'alt' => null,
                ],
                'meta_data' => [
                    'title' => null,
                    'description' => null,
                    'keywords' => null
                ],
            ],
            2 => [
                'parent' => 0,
                'judul' => 'E-Referensi',
                'slug' => 'ereferensi',
                'intro' => null,
                'content' => null,
                'cover' => [
                    'filename' => null,
                    'title' => null,
                    'alt' => null,
                ],
                'meta_data' => [
                    'title' => null,
                    'description' => null,
                    'keywords' => null
                ],
            ],
            3 => [
                'parent' => 0,
                'judul' => 'Panduan Penggunaan',
                'slug' => 'panduan-penggunaan',
                'intro' => null,
                'content' => null,
                'cover' => [
                    'filename' => null,
                    'title' => null,
                    'alt' => null,
                ],
                'meta_data' => [
                    'title' => null,
                    'description' => null,
                    'keywords' => null
                ],
            ],
        ];

        foreach ($pages as $key => $value) {
            Page::create([
                'creator_id' => 1,
                'parent' => $value['parent'],
                'judul' => $value['judul'],
                'slug' => $value['slug'],
                'intro' => $value['intro'],
                'content' => $value['content'],
                'cover' => $value['cover'],
                'publish' => 1,
                'urutan' => ($key + 1),
                'meta_data' => $value['meta_data'],
            ]);
        }
    }
}
