<?php

namespace App\Http\Controllers;

use App\Exceptions\Handler;
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
        try {
            $roles = $this->roleService->getAllRoles();

            return ResponseHelper::success(
                RoleResource::collection($roles),
                'Roles retrieved successfully.'
            );
        } catch (\Exception $e) {
            return Handler::handle($e);
        }
    }

    public function show($id)
    {
        try {
            $role = $this->roleService->getRoleById($id);

            return ResponseHelper::success(
                new RoleResource($role),
                'Role retrieved successfully.'
            );
        } catch (\Exception $e) {
            return Handler::handle($e);
        }
    }

    public function store(RoleRequest $request)
    {
        try {
            $role = $this->roleService->createRole($request->validated());

            return ResponseHelper::success(new RoleResource($role), 'Role created successfully.');
        } catch (\Exception $e) {
            return Handler::handle($e);
        }
    }

    public function update(RoleRequest $request, $id)
    {
        try {
            $role = $this->roleService->updateRole($id, $request->validated());

            return ResponseHelper::success(new RoleResource($role), 'Role updated successfully.');
        } catch (\Exception $e) {
            return Handler::handle($e);
        }
    }

    public function destroy($id)
    {
        try {
            $this->roleService->deleteRole($id);

            return ResponseHelper::success(null, 'Role deleted successfully.');
        } catch (\Exception $e) {
            return Handler::handle($e);
        }
    }

    public function assignPermission(Request $request, $roleId)
    {
        try {
            $permissionName = $request->input('permission_name');
            $role = $this->roleService->assignPermissionToRole($roleId, $permissionName);

            return ResponseHelper::success(new RoleResource($role->load('permissions')), 'Permission assigned successfully.');
        } catch (\Exception $e) {
            return Handler::handle($e);
        }
    }

    public function removePermission(Request $request, $roleId)
    {
        try {
            $permissionName = $request->input('permission_name');
            $role = $this->roleService->removePermissionFromRole($roleId, $permissionName);

            return ResponseHelper::success(new RoleResource($role->load('permissions')), 'Permission removed successfully.');
        } catch (\Exception $e) {
            return Handler::handle($e);
        }
    }

    public function assignRoleToUser(AssignUserRole $assignUserRole)
    {
        try {
            $user = $this->roleService->assignRoleToUser($assignUserRole->validated());

            return ResponseHelper::success($user, 'Role assigned to user successfully.');
        } catch (\Exception $e) {
            return Handler::handle($e);
        }
    }

    public function updateRoleOfUser(AssignUserRole $assignUserRole)
    {
        try {
            $user = $this->roleService->updateRoleOfUser($assignUserRole->validated());

            return ResponseHelper::success($user, 'User role updated successfully.');
        } catch (\Exception $e) {
            return Handler::handle($e);
        }
    }

    public function removeRoleFromUser($userId)
    {
        try {
            $user = $this->roleService->removeRoleFromUser($userId);

            return ResponseHelper::success($user, 'Role removed from user successfully.');
        } catch (\Exception $e) {
            return Handler::handle($e);
        }
    }
}
