<?php

use Illuminate\Database\Seeder;
use App\Models\Konfigurasi;
use App\Models\PersenNilai;
use App\Models\Page;
use App\Models\Banner\Banner;
use App\Models\Banner\BannerKategori;
class Temp extends Seeder
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
                'keterangan' => '<h1>BPPT E-Learning System</h1>
                                    <h5>Layanan Pelatihan Jarak Jauh oleh Pusbindiklat BPPT.</h5>'
            ],
        ];

        $banner = [
            0 => [
                'banner_kategori_id' => 1,
                'file' => 'slide-1.jpg',
                'judul' => 'BPPT E-Learning System',
                'keterangan' => '<h5>Layanan Pelatihan Jarak Jauh oleh Pusbindiklat BPPT.</h5>',
                'link' => 'javascript:;',
            ],
            1 => [
                'banner_kategori_id' => 1,
                'file' => 'slide-2.jpg',
                'judul' => 'BELS: BPPT E-Learning System',
                'keterangan' => '<h5>Tingkatkan pengetahuan dan keterampilan anda bersama kami, kapan pun dan dimana pun.</h5>',
                'link' => 'javascript:;',
            ],
            2 => [
                'banner_kategori_id' => 1,
                'file' => 'slide-3.jpg',
                'judul' => 'Pelatihan Jabatan Fungsional Perekayasa',
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
        $pages = [
            0 => [
                'parent' => 0,
                'judul' => 'Selamat Datang di BPPT E-Learning System',
                'slug' => 'selamat-datang-di-bppt-elearning-system',
                'intro' => null,
                'content' => '<p><strong>Kepala Pusat Pembinaan, Pendidikan dan Pelatihan BPPT</strong></p>
                                <p><em>Prof. Dr. Ir. Suhendar I. Sachoemar, M.Si.</em></p>
                                <p>Pusat Pembinaan, Pendidikan dan Pelatihan (Pusbindiklat) Badan Pengkajian dan Penerapan Teknologi (BPPT) bertugas melaksanakan pembinaan, menyelenggarakan pendidikan dan pelatihan perekayasaan teknologi dan pelatihan bidang lainnya. Kegiatan pendidikan dan pelatihan yang telah dilakukan selama ini merupakan kontribusi nyata Pusbindiklat dalam mempersiapkan sumber daya manusia indonesia yang profesional dan kompeten di bidang ilmu pengetahuan dan teknologi (IPTEK).</p>
                                <p>Dalam rangka memudahkan peserta pelatihan dalam mengikuti pelatihan yang kami selenggarakan, kini kami memfasilitasi pembelajaran secara daring melalui BELS (BPPT E-Learning System). Dengan begitu, para peserta pelatihan dapat mengkuti kegiatan pembelajaran yang kami selenggarakan secara daring dimana saja, dan kapan saja sesuai dengan kebutuhan peserta diklat.</p>',
                'cover' => [
                    'filename' => 'asep.jpg',
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
                'judul' => 'About Us',
                'slug' => 'about-us',
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
                'judul' => 'Terms Of Use',
                'slug' => 'terms-of-use',
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
                'judul' => 'Privacy Policy',
                'slug' => 'privacy-policy',
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
            4 => [
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
            5 => [
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

        $letter = [
            0 => [
                'nilai_maksimum' => '100.00',
                'nilai_minimum' => '93.00',
                'angka' => 'A',
            ],
            1 => [
                'nilai_maksimum' => '92.99',
                'nilai_minimum' => '90.00',
                'angka' => 'A-',
            ],
            2 => [
                'nilai_maksimum' => '89.99',
                'nilai_minimum' => '87.00',
                'angka' => 'B+',
            ],
            3 => [
                'nilai_maksimum' => '86.99',
                'nilai_minimum' => '83.00',
                'angka' => 'B',
            ],
            4 => [
                'nilai_maksimum' => '82.99',
                'nilai_minimum' => '80.00',
                'angka' => 'B-',
            ],
            5 => [
                'nilai_maksimum' => '79.99',
                'nilai_minimum' => '77.00',
                'angka' => 'C+',
            ],
            6 => [
                'nilai_maksimum' => '76.99',
                'nilai_minimum' => '73.00',
                'angka' => 'C',
            ],
            7 => [
                'nilai_maksimum' => '72.99',
                'nilai_minimum' => '70.00',
                'angka' => 'C-',
            ],
            8 => [
                'nilai_maksimum' => '69.99',
                'nilai_minimum' => '67.00',
                'angka' => 'D+',
            ],
            9 => [
                'nilai_maksimum' => '66.99',
                'nilai_minimum' => '60.00',
                'angka' => 'D',
            ],
            10 => [
                'nilai_maksimum' => '59.99',
                'nilai_minimum' => '0.00',
                'angka' => 'E',
            ],
        ];

        foreach ($letter as $value) {
            PersenNilai::create([
                'creator_id' => 2,
                'nilai_minimum' => $value['nilai_minimum'],
                'nilai_maksimum' => $value['nilai_maksimum'],
                'angka' => $value['angka']
            ]);
        }


        $konfigurasi = [
            0 => [
                'group' => 1,
                'name' => 'banner_default',
                'label' => 'Banner',
                'value' => null,
                'is_upload' => true,
            ],
            1 => [
                'group' => 2,
                'name' => 'website_name',
                'label' => 'Website Name',
                'value' => 'BPPT E-Learning System',
                'is_upload' => false,
            ],
            2 => [
                'group' => 2,
                'name' => 'banner_limit',
                'label' => 'Banner Limit',
                'value' => 3,
                'is_upload' => false,
            ],
            3 => [
                'group' => 2,
                'name' => 'content_limit',
                'label' => 'Content Limit',
                'value' => 6,
                'is_upload' => false,
            ],
            4 => [
                'group' => 2,
                'name' => 'address',
                'label' => 'Address',
                'value' => 'Gedung BPPT II, Lt. 6 Jl. M.H. Thamrin No. 8, Jakarta Pusat - 10340',
                'is_upload' => false,
            ],
            5 => [
                'group' => 2,
                'name' => 'email',
                'label' => 'Email',
                'value' => 'sekr-pusbindiklat@bppt.go.id',
                'is_upload' => false,
            ],
            6 => [
                'group' => 2,
                'name' => 'email_2',
                'label' => 'Email 2',
                'value' => null,
                'is_upload' => false,
            ],
            7 => [
                'group' => 2,
                'name' => 'fax',
                'label' => 'FAX',
                'value' => null,
                'is_upload' => false,
            ],
            8 => [
                'group' => 2,
                'name' => 'phone',
                'label' => 'Phone',
                'value' => '(021) 316 91 82',
                'is_upload' => false,
            ],
            9 => [
                'group' => 2,
                'name' => 'phone_2',
                'label' => 'Phone 2',
                'value' => null,
                'is_upload' => false,
            ],
            10 => [
                'group' => 3,
                'name' => 'meta_title',
                'label' => 'Meta Title',
                'value' => null,
                'is_upload' => false,
            ],
            11 => [
                'group' => 3,
                'name' => 'meta_description',
                'label' => 'Meta Description',
                'value' => null,
                'is_upload' => false,
            ],
            12 => [
                'group' => 3,
                'name' => 'meta_keywords',
                'label' => 'Meta Keywords',
                'value' => null,
                'is_upload' => false,
            ],
            13 => [
                'group' => 3,
                'name' => 'google_analytics',
                'label' => 'Google Analytics (script)',
                'value' => null,
                'is_upload' => false,
            ],
            14 => [
                'group' => 1,
                'name' => 'google_analytics_api',
                'label' => 'Service Account Credentials',
                'value' => null,
                'is_upload' => true,
            ],
            15 => [
                'group' => 3,
                'name' => 'google_analytics_view_id',
                'label' => 'Google Analytics View ID',
                'value' => null,
                'is_upload' => false,
            ],
            16 => [
                'group' => 3,
                'name' => 'google_verification',
                'label' => 'Google Verification',
                'value' => null,
                'is_upload' => false,
            ],
            17 => [
                'group' => 3,
                'name' => 'domain_verification',
                'label' => 'Domain Verification',
                'value' => null,
                'is_upload' => false,
            ],
            18 => [
                'group' => 4,
                'name' => 'app_store',
                'label' => 'App Store',
                'value' => null,
                'is_upload' => false,
            ],
            19 => [
                'group' => 4,
                'name' => 'google_play_store',
                'label' => 'Google Play Store',
                'value' => null,
                'is_upload' => false,
            ],
            20 => [
                'group' => 4,
                'name' => 'google_plus',
                'label' => 'Google Plus URL',
                'value' => null,
                'is_upload' => false,
            ],
            21 => [
                'group' => 4,
                'name' => 'facebook',
                'label' => 'Facebook URL',
                'value' => null,
                'is_upload' => false,
            ],
            22 => [
                'group' => 4,
                'name' => 'instagram',
                'label' => 'Instagram URL',
                'value' => null,
                'is_upload' => false,
            ],
            23 => [
                'group' => 4,
                'name' => 'linkedin',
                'label' => 'LinkedIn URL',
                'value' => null,
                'is_upload' => false,
            ],
            24 => [
                'group' => 4,
                'name' => 'pinterest',
                'label' => 'Pinterest URL',
                'value' => null,
                'is_upload' => false,
            ],
            25 => [
                'group' => 4,
                'name' => 'twitter',
                'label' => 'Twitter URL',
                'value' => null,
                'is_upload' => false,
            ],
            26 => [
                'group' => 4,
                'name' => 'whatsapp',
                'label' => 'WhatsApp URL',
                'value' => null,
                'is_upload' => false,
            ],
            27 => [
                'group' => 4,
                'name' => 'youtube',
                'label' => 'Youtube URL',
                'value' => null,
                'is_upload' => false,
            ],
        ];

        foreach ($konfigurasi as $value) {
            Konfigurasi::create([
                'group' => $value['group'],
                'name' => $value['name'],
                'label' => $value['label'],
                'value' => $value['value'],
                'is_upload' => $value['is_upload'],
            ]);
        }

    }
}
