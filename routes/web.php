    <?php


    //dashboard
        //rutas GET
        $router->get('home', ['HomeController', 'index'],'AuthMiddleware');
        $router->get('/', ['HomeController', 'index'], 'AuthMiddleware');
        