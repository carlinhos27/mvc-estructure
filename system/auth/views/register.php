<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Empresa y Usuario</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.0.3/dist/tailwind.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/tailwindcss@2.0.3"></script>
</head>

<body class="bg-gray-100">

    <div class="min-h-screen flex items-center justify-center">
        <div class="bg-white rounded-lg shadow-xl p-8 w-full max-w-lg">
            <h2 class="text-2xl font-semibold text-center mb-6">Registro</h2>


            <form id="registrationForm" method="POST">

                <!-- Sección 1: Datos de la Empresa -->
                <div id="empresaSection" class="space-y-6">
                    <h3 class="text-xl text-center font-semibold">Datos de la Empresa</h3>

                    <label for="empresa_nombre" class="block text-sm font-medium text-gray-700">Nombre de la Empresa:</label>
                    <input type="text" name="empresa_nombre" id="empresa_nombre" class="mt-2 block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 transition duration-150 ease-in-out" required>

                    <label for="empresa_email" class="block text-sm font-medium text-gray-700">Email de la Empresa:</label>
                    <input type="email" name="empresa_email" id="empresa_email" class="mt-2 block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 transition duration-150 ease-in-out" required>

                    <label for="empresa_telefono" class="block text-sm font-medium text-gray-700">Teléfono de la Empresa:</label>
                    <input type="text" name="empresa_telefono" id="empresa_telefono" class="mt-2 block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 transition duration-150 ease-in-out" required>

                    <label for="empresa_direccion" class="block text-sm font-medium text-gray-700">Dirección de la Empresa:</label>
                    <input type="text" name="empresa_direccion" id="empresa_direccion" class="mt-2 block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 transition duration-150 ease-in-out" required>

                    <input type="hidden" name="empresa_plan" id="empresa_plan" class="mt-2 block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 transition duration-150 ease-in-out" value="free" required>

                    <div class="flex justify-end">
                        <button type="button" onclick="nextStep('empresaSection', 'usuarioSection')" class="w-full bg-green-500 text-white py-2 px-4 rounded-lg hover:bg-green-600 focus:outline-none transition duration-300 ease-in-out transform hover:scale-105">Siguiente</button>
                    </div>
                </div>

                <!-- Sección 2: Datos del Usuario -->
                <div id="usuarioSection" class="space-y-6 hidden">
                    <h3 class="text-xl font-semibold">Datos del Usuario</h3>

                    <label for="usuario_nombre" class="block text-sm font-medium text-gray-700">Nombre del Usuario:</label>
                    <input type="text" name="usuario_nombre" id="usuario_nombre" class="mt-2 block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 transition duration-150 ease-in-out" required>

                    <label for="usuario_email" class="block text-sm font-medium text-gray-700">Email del Usuario:</label>
                    <input type="email" name="usuario_email" id="usuario_email" class="mt-2 block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 transition duration-150 ease-in-out" required>

                    <label for="usuario_password" class="block text-sm font-medium text-gray-700">Contraseña:</label>
                    <input type="password" name="usuario_password" id="usuario_password" class="mt-2 block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 transition duration-150 ease-in-out" required>

                    <div class="flex justify-between space-x-4">
                        <button type="button" onclick="prevStep('usuarioSection', 'empresaSection')" class="w-full bg-gray-400 text-white py-2 px-4 rounded-lg hover:bg-gray-400 focus:outline-none transition duration-300 ease-in-out transform hover:scale-105">Anterior</button>
                        <button type="submit" class="w-full bg-green-500 text-white py-2 px-4 rounded-lg hover:bg-green-600 focus:outline-none transition duration-300 ease-in-out transform hover:scale-105">Registrar</button>
                    </div>

                    <!-- Enlace a Login -->
                    <p class="mt-4 text-center text-sm">
                        ¿Ya tienes cuenta? <a href="/login" class="text-blue-500 hover:underline">Inicia sesión aquí</a>
                    </p>
                </div>

            </form>
        </div>
    </div>

    <script>
        // Función para ir al siguiente paso
        function nextStep(currentSection, nextSection) {
            document.getElementById(currentSection).classList.add('hidden');
            document.getElementById(nextSection).classList.remove('hidden');
        }

        // Función para ir al paso anterior
        function prevStep(currentSection, prevSection) {
            document.getElementById(currentSection).classList.add('hidden');
            document.getElementById(prevSection).classList.remove('hidden');
        }
    </script>

</body>

</html>