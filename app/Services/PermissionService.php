<?php

namespace App\Services;

use App\Repositories\PermissionRepository;

class PermissionService
{
    protected $permissionRepository;

    public function __construct(PermissionRepository $permissionRepository)
    {
        $this->permissionRepository = $permissionRepository;
    }

    public function getAllPermissions()
    {
        return $this->permissionRepository->getAllPermissions();
    }

    public function getPermissionById($id)
    {
        return $this->permissionRepository->getPermissionById($id);
    }

    public function createPermission(array $data)
    {
        return $this->permissionRepository->createPermission($data);
    }

    public function updatePermission($id, array $data)
    {
        return $this->permissionRepository->updatePermission($id, $data);
    }

    public function deletePermission($id)
    {
        return $this->permissionRepository->deletePermission($id);
    }

    public function assignRoleToPermission($permissionId, $roleName)
    {
        return $this->permissionRepository->assignRoleToPermission($permissionId, $roleName);
    }

    public function removeRoleFromPermission($permissionId, $roleName)
    {
        return $this->permissionRepository->removeRoleFromPermission($permissionId, $roleName);
    }
}
