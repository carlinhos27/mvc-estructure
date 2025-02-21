    <?php


    //dashboard
    //rutas GET
    $router->get('home', [HomeController::class, 'index'], 'AuthMiddleware');
    $router->get('/', [HomeController::class, 'index'], 'AuthMiddleware');

    // // Rutas para la gestión de usuarios
    $router->get('usuarios', [UserController::class, 'index'], 'AuthMiddleware');
    $router->get('usuarios/nuevo', [UserController::class, 'create'], 'AuthMiddleware');
    // $route->post('/usuarios/crear', 'UserController@createUser');
    // $route->get('/usuarios/editar/{id}', 'UserController@showEditUserForm');
    // $route->post('/usuarios/editar/{id}', 'UserController@updateUser');
    // $route->get('/usuarios/eliminar/{id}', 'UserController@deleteUser');

    // // Rutas para la gestión de roles
    // $route->get('/roles', 'RoleController@getAllRoles');
    // $route->get('/roles/crear', 'RoleController@showCreateRoleForm');
    // $route->post('/roles/crear', 'RoleController@createRole');
    // $route->get('/roles/editar/{id}', 'RoleController@showEditRoleForm');
    // $route->post('/roles/editar/{id}', 'RoleController@updateRole');
    // $route->get('/roles/eliminar/{id}', 'RoleController@deleteRole');

    // // Ruta para obtener el rol de un usuario
    // $route->get('/usuarios/{id}/rol', 'UserController@getUserRole');
