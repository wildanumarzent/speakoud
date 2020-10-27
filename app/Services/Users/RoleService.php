<?php

namespace App\Services\Users;

use Spatie\Permission\Models\Role;

class RoleService
{
    private $model;

    public function __construct(Role $model)
    {
        $this->model = $model;
    }

    public function getAllRole()
    {
        return $this->model->all();
    }

    public function getRoleAdministrator($myRole)
    {
        $query = $this->model->query();

        $query->where('id', '>=', $myRole);
        $query->whereIn('id', [1,2]);

        $result = $query->get();

        return $result;
    }
}
