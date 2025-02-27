

<!-- system/auth/views/login.php -->
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar sesión</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.0.3/dist/tailwind.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/tailwindcss@2.0.3"></script>
    
    
</head>

<body class="bg-gray-100">

    <div class="min-h-screen flex items-center justify-center">
        <div class="bg-white rounded-lg shadow-xl p-8 w-full max-w-md">
            <h2 class="text-2xl font-semibold text-center mb-6">Iniciar sesión</h2>

            <?php if (isset($error)): ?>
                <div class="bg-red-100 text-red-700 border border-red-400 p-2 mb-4 rounded">
                    <?= $error ?>
                </div>
            <?php endif; ?>

            <form action="/login" method="POST" class="space-y-6">
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                    <input type="email" id="email" name="email" class="mt-2 block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 transition duration-150 ease-in-out" required>
                </div>

                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700">Contraseña</label>
                    <input type="password" id="password" name="password" class="mt-2 block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 transition duration-150 ease-in-out" required>
                </div>

                <button type="submit" class="w-full bg-green-500 text-white py-2 px-4 rounded-lg hover:bg-green-600 focus:outline-none transition duration-300 ease-in-out transform hover:scale-105">Iniciar sesión</button>
            </form>

            <p class="mt-4 text-center text-sm">
                ¿No tienes cuenta? <a href="/register" class="text-blue-500 hover:underline">Registrate aquí</a>
            </p>
        