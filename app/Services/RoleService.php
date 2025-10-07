<?php

namespace App\Services;

use App\Repositories\RoleRepository;

class RoleService
{
    protected $roleRepository;

    public function __construct(RoleRepository $roleRepository)
    {
        $this->roleRepository = $roleRepository;
    }

    public function getAllRoles()
    {
        return $this->roleRepository->getAllRoles();
    }

    public function getRoleById($id)
    {
        return $this->roleRepository->getRoleById($id);
    }

    public function createRole(array $data)
    {
        return $this->roleRepository->createRole($data);
    }

    public function updateRole($id, array $data)
    {
        return $this->roleRepository->updateRole($id, $data);
    }

    public function deleteRole($id)
    {
        return $this->roleRepository->deleteRole($id);
    }

    public function assignPermissionToRole($roleId, $permissionName)
    {
        return $this->roleRepository->assignPermissionToRole($roleId, $permissionName);
    }

    public function removePermissionFromRole($roleId, $permissionName)
    {
        return $this->roleRepository->removePermissionFromRole($roleId, $permissionName);
    }
}
