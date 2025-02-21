<?php
class UserController extends Controller
{
    public function index()
    {
        $userModel = new User();
        $users = $userModel->all();
        view('users/index', ['users' => $users]);
    }

    public function create()
    {
        $roleModel = new Role();
        $roles = $roleModel->all();
        view('users/create', ['roles' => $roles]);
    }

    public function store()
    {
        $userModel = new User();
        $userData = [
            'name' => $_POST['name'],
            'email' => $_POST['email'],
            'password' => password_hash($_POST['password'], PASSWORD_DEFAULT),
            'role_id' => $_POST['role_id']
        ];

        $userModel->insert($userData);
        header('Location: /users');
    }

    public function edit($id)
    {
        $userModel = new User();
        $user = $userModel->find($id);
        
        $roleModel = new Role();
        $roles = $roleModel->all();

        view('users/edit', ['user' => $user, 'roles' => $roles]);
    }

    public function update($id)
    {
        $userModel = new User();
        $userData = [
            'name' => $_POST['name'],
            'email' => $_POST['email'],
            'role_id' => $_POST['role_id']
        ];

        // Password update logic (optional)
        if (!empty($_POST['password'])) {
            $userData['password'] = password_hash($_POST['password'], PASSWORD_DEFAULT);
        }

        $userModel->update($id, $userData);
        header('Location: /users');
    }

    public function destroy($id)
    {
        $userModel = new User();
        $userModel->delete($id);
        header('Location: /users');
    }
}
