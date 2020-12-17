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
            'icon' => 'comments'
        ],
        1 => [
            'title' => 'Dokumen',
            'get' => 'dokumen',
            'description' => '',
            'icon' => 'file'
        ],
        2 => [
            'title' => 'Video Conference',
            'get' => 'conference',
            'description' => '',
            'icon' => 'video'
        ],
        3 => [
            'title' => 'Quiz',
            'get' => 'quiz',
            'description' => '',
            'icon' => 'spell-check'
        ],
        4 => [
            'title' => 'Scorm Package',
            'get' => 'scorm',
            'description' => '',
            'icon' => 'archive'
        ],
        5 => [
            'title' => 'Audio',
            'get' => 'audio',
            'description' => '',
            'icon' => 'file-audio'
        ],
        6 => [
            'title' => 'Video',
            'get' => 'video',
            'description' => '',
            'icon' => 'file-video'
        ],
        7 => [
            'title' => 'Tugas',
            'get' => 'tugas',
            'description' => '',
            'icon' => 'briefcase'
        ],
        8 => [
            'title' => 'Evaluasi Pengajar',
            'get' => 'evaluasi-pengajar',
            'description' => '',
            'icon' => 'user-tie'
        ],
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
    'quiz_tipe' => [
        0 => 'Bisa diulang',
        1 => 'Tidak bisa diulang'
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
        ],
    ],
    'quiz_view' => [
        0 => 'Tampilkan semua soal',
        1 => 'Tampilkan soal satu per satu'
    ],
];
