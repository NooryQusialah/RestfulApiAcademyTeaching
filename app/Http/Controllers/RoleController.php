<?php

namespace App\Http\Controllers;

use App\Exceptions\NotFoundException;
use App\Helpers\ResponseHelper;
use App\Http\Requests\AssignUserRole;
use App\Http\Requests\RoleRequest;
use App\Http\Resources\RoleResource;
use App\Services\RoleService;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    protected $roleService;

    public function __construct(RoleService $roleService)
    {
        $this->roleService = $roleService;
    }

    public function index()
    {
        $roles = $this->roleService->getAllRoles();

        return ResponseHelper::success(
            RoleResource::collection($roles),
            'Roles retrieved successfully.'
        );

    }

    public function show($id)
    {

        $role = $this->roleService->getRoleById($id);

        if (! $role) {
            throw new NotFoundException('Role not found');
        }

        return ResponseHelper::success(new RoleResource($role), 'Role retrieved successfully.');

    }

    public function store(RoleRequest $request)
    {
        $role = $this->roleService->createRole($request->validated());

        return ResponseHelper::success(new RoleResource($role), 'Role created successfully.');

    }

    public function update(RoleRequest $request, $id)
    {

        $role = $this->roleService->updateRole($id, $request->validated());

        if (! $role) {
            throw new NotFoundException('Role not found');
        }

        return ResponseHelper::success(new RoleResource($role), 'Role updated successfully.');

    }

    public function destroy($id)
    {
        $role = $this->roleService->deleteRole($id);

        if (! $role) {
            throw new NotFoundException('Role not found');
        }

        return ResponseHelper::success(null, 'Role deleted successfully.');
    }

    public function assignPermission(Request $request, $roleId)
    {

        $permissionName = $request->input('permission_name');
        $role = $this->roleService->assignPermissionToRole($roleId, $permissionName);
        if (! $role) {
            throw new NotFoundException('Role not found');
        }

        return ResponseHelper::success(new RoleResource($role->load('permissions')), 'Permission assigned successfully.');

    }

    public function removePermission(Request $request, $roleId)
    {

        $permissionName = $request->input('permission_name');
        $role = $this->roleService->removePermissionFromRole($roleId, $permissionName);
        if (! $role) {
            throw new NotFoundException('Role not found');
        }

        return ResponseHelper::success(new RoleResource($role->load('permissions')), 'Permission removed successfully.');

    }

    public function assignRoleToUser(AssignUserRole $assignUserRole)
    {
        $user = $this->roleService->assignRoleToUser($assignUserRole->validated());

        return ResponseHelper::success($user, 'Role assigned to user successfully.');

    }

    public function updateRoleOfUser(AssignUserRole $assignUserRole)
    {
        $user = $this->roleService->updateRoleOfUser($assignUserRole->validated());

        return ResponseHelper::success($user, 'User role updated successfully.');

    }

    public function removeRoleFromUser($userId)
    {
        $user = $this->roleService->removeRoleFromUser($userId);

        if (! $user) {
            throw new NotFoundException('User not found');
        }

        return ResponseHelper::success($user, 'Role removed from user successfully.');

    }
}
