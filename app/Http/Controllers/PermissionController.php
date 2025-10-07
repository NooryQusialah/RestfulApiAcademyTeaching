<?php

namespace App\Http\Controllers;

use App\Helpers\ResponseHelper;
use App\Http\Requests\PermissionRequest;
use App\Services\PermissionService;
use Illuminate\Http\Request;

class PermissionController extends Controller
{
    protected $permissionService;

    public function __construct(PermissionService $permissionService)
    {
        $this->permissionService = $permissionService;
    }

    public function index()
    {

        $permissions = $this->permissionService->getAllPermissions();

        return ResponseHelper::success($permissions);
    }

    public function show($id)
    {
        $permission = $this->permissionService->getPermissionById($id);

        return ResponseHelper::success($permission);
    }

    public function store(PermissionRequest $request)
    {
        $permission = $this->permissionService->createPermission($request->validated());

        return ResponseHelper::success($permission, 'Permission created successfully.');
    }

    public function update(PermissionRequest $request, $id)
    {
        $permission = $this->permissionService->updatePermission($id, $request->validated());

        return ResponseHelper::success($permission, 'Permission updated successfully.');
    }

    public function destroy($id)
    {
        $this->permissionService->deletePermission($id);

        return ResponseHelper::success(null, 'Permission deleted successfully.');
    }

    public function assignRole(Request $request, $permissionId)
    {
        $roleName = $request->input('role_name');
        $permission = $this->permissionService->assignRoleToPermission($permissionId, $roleName);

        return ResponseHelper::success($permission, 'Role assigned to permission successfully.');
    }

    public function removeRole(Request $request, $permissionId)
    {
        $roleName = $request->input('role_name');
        $permission = $this->permissionService->removeRoleFromPermission($permissionId, $roleName);

        return ResponseHelper::success($permission, 'Role removed from permission successfully.');
    }
}
