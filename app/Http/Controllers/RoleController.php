<?php

namespace App\Http\Controllers;

use App\Exceptions\Handler;
use App\Helpers\ResponseHelper;
use App\Http\Requests\RoleRequest;
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

            return ResponseHelper::success($roles);
        } catch (\Exception $e) {
            return Handler::handle($e);
        }
    }

    public function show($id)
    {
        try {
            $role = $this->roleService->getRoleById($id);

            return ResponseHelper::success($role);
        } catch (\Exception $e) {
            return Handler::handle($e);
        }
    }

    public function store(RoleRequest $request)
    {
        try {
            $role = $this->roleService->createRole($request->validated());

            return ResponseHelper::success($role, 'Role created successfully.');
        } catch (\Exception $e) {
            return Handler::handle($e);
        }
    }

    public function update(RoleRequest $request, $id)
    {
        try {
            $role = $this->roleService->updateRole($id, $request->validated());

            return ResponseHelper::success($role, 'Role updated successfully.');
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

            return ResponseHelper::success($role, 'Permission assigned to role successfully.');
        } catch (\Exception $e) {
            return Handler::handle($e);
        }
    }

    public function removePermission(Request $request, $roleId)
    {
        try {
            $permissionName = $request->input('permission_name');
            $role = $this->roleService->removePermissionFromRole($roleId, $permissionName);

            return ResponseHelper::success($role, 'Permission removed from role successfully.');
        } catch (\Exception $e) {
            return Handler::handle($e);
        }
    }
}
