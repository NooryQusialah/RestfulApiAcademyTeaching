<?php

namespace App\Repositories;

use App\Exceptions\NotFoundException;
use App\Interfaces\RoleInterface;
use App\Models\Permission;
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
        return Role::with('permissions')->find($id);
    }

    public function createRole(array $data)
    {
        return Role::create($data);
    }

    public function updateRole($id, array $data)
    {
        $role = Role::find($id);
        if (! $role) {
            return null;
        }
        $role->update($data);

        return $role;
    }

    public function deleteRole($id)
    {
        $role = Role::find($id);
        if (! $role) {
            return false;
        }

        return $role->delete();
    }

    public function assignPermissionToRole($roleId, $permissionName)
    {
        $role = Role::find($roleId);

        if (! $role) {
            return null;
        }
        if (! Permission::where('name', $permissionName)->exists()) {
            throw new NotFoundException('Permission not found');
        }

        $role->givePermissionTo($permissionName);

        return $role;
    }

    public function removePermissionFromRole($roleId, $permissionIds)
    {
        $role = Role::find($roleId);
        if (! $role) {
            return null;
        }
        $role->revokePermissionTo($permissionIds);

        return $role;
    }

    public function assignRoleToUser($data): User
    {
        $user = User::find($data['user_id']);

        if (! $user) {
            throw new NotFoundException('User not found');
        }

        if (! Role::where('name', $data['role_name'])->exists()) {
            throw new NotFoundException('Role not found');
        }

        $user->assignRole($data['role_name']);

        return $user;
    }

    public function updateRoleOfUser($data): User
    {
        $user = User::findOrFail($data['user_id']);

        if (! Role::where('name', $data['role_name'])->exists()) {
            throw new NotFoundException('Role not found');
        }

        $user->syncRoles($data['role_name']);

        return $user;
    }

    public function removeRoleFromUser($userId)
    {
        $user = User::find($userId);
        if (! $user) {
            return null;
        }

        $user->syncRoles([]);

        return $user;
    }
}
