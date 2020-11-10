<?php

return [
    'publish' => [
        '1' => 'PUBLISH',
        '0' => 'DRAFT'
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
            'get' => 'link',
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
    ],
    'forum_tipe' => [
        0 => [
            'title' => 'A single simple discussion',
            'description' => 'A single topic discussion developed on one page, which is useful for short focused discussions (cannot be used with separate groups)',
        ],
        1 => [
            'title' => 'Standard forum for general use',
            'description' => 'An open forum where anyone can start a new topic at any time; this is the best general-purpose forum',
        ],
        2 => [
            'title' => 'Each person posts one discussion',
            'description' => "Each person can post exactly one new discussion topic (everyone can reply to them though); this is useful when you want each student to start a discussion about, say, their reflections on the week's topic, and everyone else responds to these"
        ],
        3 => [
            'title' => 'Q and A Forum',
            'description' => 'Instead of initiating discussions participants pose a question in the initial post of a discussion. Students may reply with an answer, but they will not see the replies of other Students to the question in that discussion until they have themselves replied to the same discussion.',
        ],
        4 => [
            'title' => 'Standard forum',
            'description' => 'displayed in a blog-like format',
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
    ],
];
