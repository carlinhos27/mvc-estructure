<?php
class RoleController extends Controller
{
    public function index()
    {
        $roleModel = new Role();
        $roles = $roleModel->all();
        view('roles/index', ['roles' => $roles]);
    }

    public function create()
    {
        view('roles/create');
    }

    public function store()
    {
        $roleModel = new Role();
        $roleData = [
            'name' => $_POST['name'],
            'description' => $_POST['description']
        ];

        $roleModel->insert($roleData);
        header('Location: /roles');
    }

    public function edit($id)
    {
        $roleModel = new Role();
        $role = $roleModel->find($id);
        view('roles/edit', ['role' => $role]);
    }

    public function update($id)
    {
        $roleModel = new Role();
        $roleData = [
            'name' => $_POST['name'],
            'description' => $_POST['description']
        ];

        $roleModel->update($id, $roleData);
        header('Location: /roles');
    }

    public function destroy($id)
    {
        $roleModel = new Role();
        $roleModel->delete($id);
        header('Location: /roles');
    }

    public function assignPermissions($roleId)
    {
        $rolePermissionModel = new RolePermission();
        $permissions = $_POST['permissions'] ?? [];
        
        $rolePermissionModel->assignPermissionsToRole($roleId, $permissions);
        header("Location: /roles/$roleId/permissions");
    }
}
