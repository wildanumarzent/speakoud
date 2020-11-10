<?php

namespace App\Services\Component;

class FormBuilderService{

public function formUser(){
$form['route'] = 'user';
$form['input'] = [];
        $form['input'][] = [
            'label' => 'Nama',
            'value' => 'name',
            'type' => 'text',
            'required' => true,
        ];
        $form['input'][] = [
            'label' => 'NIP',
            'value' => 'nip',
            'type' => 'number',
            'required' => true,
        ];
        $form['input'][] = [
            'label' => 'Username',
            'value' => 'username',
            'type' => 'text',
            'required' => true,
        ];
        $form['input'][] = [
            'label' => 'Email',
            'value' => 'email',
            'type' => 'email',
            'required' => true,
        ];
        $form['input'][] = [
            'label' => 'Password',
            'value' => 'password',
            'type' => 'password',
            'required' => true,
        ];
        $form['input'][] = [
            'label' => 'Jabatan',
            'value' => 'jabatan',
            'type' => 'text',
            'required' => true,
        ];
        $form['input'][] = [
            'label' => 'Role',
            'value' => 'role_id',
            'type' => 'select',
            'name' => 'role',
            'param' => 'id',
            'required' => true,
        ];

        $form['input'][] = [
            'label' => 'OPD',
            'value' => 'opd_kode',
            'type' => 'select',
            'name' => 'nama',
            'param' => 'kode',
            'required' => true,
        ];

return $form;

}
}
