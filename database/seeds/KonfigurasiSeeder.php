<?php

use App\Models\Konfigurasi;
use Illuminate\Database\Seeder;

class KonfigurasiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
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
            27 => [
                'group' => 4,
                'name' => 'website',
                'label' => 'Website URL',
                'value' => 'https://e-learning.bppt.go.id/',
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
