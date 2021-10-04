<?php

return [
    'active' => [
        '1' => 'AKTIF',
        '0' => 'TIDAK AKTIF'
    ],
    'publish' => [
        '1' => 'PUBLISH',
        '0' => 'DRAFT'
    ],
    'is_sertifikat' =>[
        '1' => 'yes',
        '0' => 'No'
    ],
    'penilaian' => [
        '1' => 'yes',
        '0' => 'No'
    ],
    'bahan_tipe' => [
        0 => [
            'title' => 'Forum',
            'get' => 'forum',
            'description' => '',
            'icon' => 'comments',
            'child' => '',
        ],
        1 => [
            'title' => 'Dokumen',
            'get' => 'dokumen',
            'description' => '',
            'icon' => 'file',
            'child' => '',
        ],
        2 => [
            'title' => 'Video Conference',
            'get' => 'conference',
            'description' => '',
            'icon' => 'video',
            'child' => '',
        ],
        3 => [
            'title' => 'Post Test',
            'get' => 'quiz',
            'description' => '',
            'icon' => 'project-diagram',
            'child' => [
                0 => [
                    'title' => 'Pre Test',
                    'get' => 1,
                    'icon' => 'project-diagram',
                ],
                1 => [
                    'title' => 'Quiz',
                    'get' => 2,
                    'icon' => 'spell-check ',
                ]
            ]
        ],
        4 => [
            'title' => 'Scorm Package',
            'get' => 'scorm',
            'description' => '',
            'icon' => 'archive',
            'child' => '',
        ],
        5 => [
            'title' => 'Audio',
            'get' => 'audio',
            'description' => '',
            'icon' => 'file-audio',
            'child' => '',
        ],
        6 => [
            'title' => 'Video',
            'get' => 'video',
            'description' => '',
            'icon' => 'file-video',
            'child' => '',
        ],
        7 => [
            'title' => 'Tugas',
            'get' => 'tugas',
            'description' => '',
            'icon' => 'briefcase',
            'child' => '',
        ],
        8 => [
            'title' => 'Evaluasi Pengajar',
            'get' => 'evaluasi-pengajar',
            'description' => '',
            'icon' => 'user-tie',
            'child' => '',
        ],
    ],
    'bahan_completion' => [
        0 => 'No Condition',
        1 => 'Manual User Action',
        2 => 'On View',
        3 => 'Timer',
    ],
    'bahan_restrict' => [
        0 => 'Requirement',
        1 => 'Tanggal',
    ],
    'forum_tipe' => [
        0 => [
            'title' => 'Hanya Instruktur',
            'description' => 'A single topic discussion developed on one page, which is useful for short focused discussions (cannot be used with separate groups)',
        ],
        1 => [
            'title' => 'Instruktur dan Peserta',
            'description' => 'A single topic discussion developed on one page, which is useful for short focused discussions (cannot be used with separate groups)',
        ],
    ],
    'quiz_kategori' => [
        1 => 'PRE TEST',
        2 => 'POST TEST',
        3 => 'PROGRESS TEST',
        4 => 'LATIHAN'
    ],
    'quiz_tipe' => [
        1 => 'Tidak bisa diulang',
        0 => 'Bisa diulang',
    ],
    'quiz_item_tipe' => [
        0 => [
            'code' => 'multipel_choice',
            'title' => 'Multiple Choice',
        ],
        1 => [
            'code' => 'exact',
            'title' => 'Exact',
        ],
        2 => [
            'code' => 'essay',
            'title' => 'Essay',
        ],
        3 => [
            'code' => 'true_false',
            'title' => 'True / False',
            'choice' => [
                1 => 'TRUE',
                0 => 'FALSE',
            ]
        ],
    ],
    'quiz_view' => [
        0 => 'Tampilkan semua soal',
        1 => 'Tampilkan soal satu per satu'
    ],
    'badge_tipe_completion' => [
        0 => [
            'title' => 'Penyelesaian Program',
            'get' => 'program',
            'description' => 'Tipe Badge ini Didapatkan Jika Peserta Menyelesaikan Program',
            'icon' => 'medal',
            'child' => '',
        ],
        1 => [
            'title' => 'Penyelesaian Mata',
            'get' => 'mata',
            'description' => 'Tipe Badge ini Didapatkan Jika Peserta Menyelesaikan Suatu Mata',
            'icon' => 'medal',
            'child' => '',
        ],
        2 => [
            'title' => 'Penyelesaian Materi',
            'get' => 'materi',
            'description' => 'Tipe Badge ini Didapatkan Jika Peserta Menyelesaikan Suatu Materi',
            'icon' => 'medal',
            'child' => '',
        ],
    ],
    'badge_tipe_forum' => [
        0 => [
            'title' => 'Menambahkan Topik',
            'get' => 'forum',
            'description' => 'Tipe Badge ini Didapatkan Jika Peserta Menambahkan Sejumlah Topic pada Suatu Forum',
            'icon' => 'medal',
            'child' => '',
        ],
        1 => [
            'title' => 'Reply Topic',
            'get' => 'topic',
            'description' => 'Tipe Badge ini Didapatkan Jika Menulis Sejumlah Reply pada Suatu Topic',
            'icon' => 'medal',
            'child' => '',
        ],
    ],
    'tipe_sertifikat' => [
        0 => 'Sertifikat ISO',
        3 => 'Sertifikat Safety',
        4 => 'Sertifikat IT'
    ],
    'pendidikan' => [
        0 => 'SD',
        1 => 'SMP',
        2 => 'SMA',
        3 => 'SMK',
        4 => 'S1',
        5 => 'S2',
        6 => 'S3',
    ],
    'history_peserta' => [
        2 => 'Tidak Selesai',
        1 => 'Sudah Lulus',
        0 => 'Belum Lulus'
    ],
    'pekerjaan' => [
        0 => 'Pelajar',
        1 => 'Mahasiswa',
        2 => 'Pengajar',
        3 => 'Guru',
        4 => 'Dosen',
        5 => 'PNS',
        6 => 'Karyawan Swasta',
        7 => 'Lainnya',
    ],
    'filter_course' => [
        0 => 'New Published',
        1 => 'Alphabetical',
        2 => 'Most Members'
    ],
    'type_agenda' => [
        0 => 'Free',
        1 => 'Berbayar'
    ],
    'tipe_pelatihan' => [
        0 => 'Free',
        1 => 'Khusus'
    ],


];
