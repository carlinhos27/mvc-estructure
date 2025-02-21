<?php
class PermissionController extends Controller
{
    public function index()
    {
        $permissionModel = new Permission();
        $permissions = $permissionModel->all();
        view('permissions/index', ['permissions' => $permissions]);
    }

    public function create()
    {
        view('permissions/create');
    }

    public function store()
    {
        $permissionModel = new Permission();
        $permissionData = [
            'module' => $_POST['module'],
            'view' => isset($_POST['view']) ? 1 : 0,
            'create' => isset($_POST['create']) ? 1 : 0,
            'edit' => isset($_POST['edit']) ? 1 : 0,
            'delete' => isset($_POST['delete']) ? 1 : 0
        ];

        $permissionModel->insert($permissionData);
        header('Location: /permissions');
    }

    public function edit($id)
    {
        $permissionModel = new Permission();
        $permission = $permissionModel->find($id);
        view('permissions/edit', ['permission' => $permission]);
    }

    public function update($id)
    {
        $permissionModel = new Permission();
        $permissionData = [
            'module' => $_POST['module'],
            'view' => isset($_POST['view']) ? 1 : 0,
            'create' => isset($_POST['create']) ? 1 : 0,
            'edit' => isset($_POST['edit']) ? 1 : 0,
            'delete' => isset($_POST['delete']) ? 1 : 0
        ];

        $permissionModel->update($id, $permissionData);
        header('Location: /permissions');
    }

    public function destroy($id)
    {
        $permissionModel = new Permission();
        $permissionModel->delete($id);
        header('Location: /permissions');
    }
}
