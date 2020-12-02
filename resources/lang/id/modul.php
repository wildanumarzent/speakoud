<?php

return [
    'dashboard' => [
        'title' => 'Dashboard',
        'calendar' => 'Today is '.now()->format('l, j F Y') .' (<em id="time-part"></em>)',
        'alert_welcome' => ' Selamat datang, <strong><em>'.auth()->user()->name.'</em></strong> di aplikasi Learning Management System !'
    ],
    'instansi' => [
        'bppt' => [
            'title' => 'Instansi BPPT List',
            'button' => 'Tambah',
            'table' => [
                'field_1' => 'No',
                'field_2' => 'Logo',
                'field_3' => 'Nama Instansi',
                'field_4' => 'Telpon',
                'field_5' => 'Fax',
                'field_6' => 'NIP Pimpinan',
                'field_7' => 'Jabatan',
                'field_8' => 'Created',
                'field_9' => 'Updated',
                'field_10' => 'Action',
            ]
        ]
    ],
];
