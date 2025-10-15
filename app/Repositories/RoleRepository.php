<?php

namespace App\Repositories;

use App\Interfaces\RoleInterface;
use App\Models\Role;
use App\Models\User;

class RoleRepository implements RoleInterface
{
    public function getAllRoles()
    {
        return Role::with('permissions')->get(); // return Role::all();
    }

    public function getRoleById($id)
    {
        return Role::with('permissions')->findOrFail($id);
    }

    public function createRole(array $data)
    {
        return Role::create($data);
    }

    public function updateRole($id, array $data)
    {
        $role = Role::findOrFail($id);
        $role->update($data);

        return $role;
    }

    public function deleteRole($id)
    {
        $role = Role::findOrFail($id);

        return $role->delete();
    }

    public function assignPermissionToRole($roleId, $permissionName)
    {
        $role = Role::findOrFail($roleId);
        $role->givePermissionTo($permissionName);

        return $role;
    }

    public function removePermissionFromRole($roleId, $permissionIds)
    {
        $role = Role::findOrFail($roleId);
        $role->revokePermissionTo($permissionIds);

        return $role;
    }

    public function assignRoleToUser($data):User
    {
        $user = User::findOrFail($data['user_id']);

        $user->assignRole($data['role_name']);

        return $user;
    }

    public function updateRoleOfUser($data):User
    {
        $user = User::findOrFail($data['user_id']);

        $user->syncRoles($data['role_name']);

        return $user;
    }
    public function removeRoleFromUser($userId)
    {
        $user=User::findOrFail($userId);
        $user->syncRoles([]);
        return $user;
    }
}
