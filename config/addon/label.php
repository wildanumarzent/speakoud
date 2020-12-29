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
    'jabatan' => [
        0 => 'Fungsional',
        1 => 'Struktural (non fungsional)'
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
            'title' => 'Quiz',
            'get' => 'quiz',
            'description' => '',
            'icon' => 'spell-check',
            'child' => [
                0 => [
                    'title' => 'Pre Test',
                    'get' => 1,
                    'icon' => 'project-diagram',
                ],
                1 => [
                    'title' => 'Post Test',
                    'get' => 2,
                    'icon' => 'project-diagram',
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
];
