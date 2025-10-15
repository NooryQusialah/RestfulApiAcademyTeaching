<?php

namespace App\Interfaces;

use App\Models\User;

interface RoleInterface
{
    public function getAllRoles();

    public function getRoleById($id);

    public function createRole(array $data);

    public function updateRole($id, array $data);

    public function deleteRole($id);

    public function assignPermissionToRole($roleId, $permissionIdName);

    public function removePermissionFromRole($roleId, $permissionIds);

    public function assignRoleToUser(array $data): User;

    public function updateRoleOfUser(array $data): User;

    public function removeRoleFromUser($userId);
}
