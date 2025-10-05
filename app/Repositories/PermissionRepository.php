<?php

namespace App\Repositories;

use App\Interfaces\PermissionInterface;
use App\Models\Permission;

class PermissionRepository implements PermissionInterface
{
    public function getAllPermissions()
    {
        try {
            return Permission::all();
        } catch (\Exception $th) {
            return response()->json(['error' => 'Could not retrieve permissions.'], 500);
        }
    }

    public function getPermissionById($id)
    {
        return Permission::findOrFail($id);
    }

    public function createPermission(array $data)
    {
        return Permission::create($data);
    }

    public function updatePermission($id, array $data)
    {
        $permission = Permission::findOrFail($id);
        $permission->update($data);
        return $permission;
    }

    public function deletePermission($id)
    {
        $permission = Permission::findOrFail($id);
        return $permission->delete();
    }

    public function assignRoleToPermission($permissionId, $roleName)
    {
        $permission = Permission::findOrFail($permissionId);
        $permission->assignRole($roleName);
        return $permission;
    }

    public function removeRoleFromPermission($permissionId, $roleName)
    {
        $permission = Permission::findOrFail($permissionId);
        if ($permission->hasRole($roleName)) {

            $permission->removeRole($roleName);
            return $permission;
        }
        else
        {
            return response()->json(['error' => 'Role not assigned to this permission.'], 400);
        }

        // return $permission;
    }
}
