<?php
class RolePermissionController extends Controller
{
    public function assignPermissions($roleId)
    {
        $rolePermissionModel = new RolePermission();
        $permissions = $_POST['permissions'] ?? [];

        // Asignar permisos al rol
        $rolePermissionModel->assignPermissionsToRole($roleId, $permissions);

        header("Location: /roles/$roleId/permissions");
    }

    public function removePermissions($roleId, $permissionId)
    {
        $rolePermissionModel = new RolePermission();
        $rolePermissionModel->removePermissionFromRole($roleId, $permissionId);

        header("Location: /roles/$roleId/permissions");
    }
}
