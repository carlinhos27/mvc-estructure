<form method="POST" action="/register">
    <h2>Registrar Empresa y Usuario</h2>

    <!-- Datos de la empresa -->
    <label for="empresa_nombre">Nombre de la empresa:</label>
    <input type="text" name="empresa_nombre" id="empresa_nombre" required><br><br>

    <label for="empresa_email">Email de la empresa:</label>
    <input type="email" name="empresa_email" id="empresa_email" required><br><br>

    <label for="empresa_telefono">Teléfono:</label>
    <input type="text" name="empresa_telefono" id="empresa_telefono"><br><br>

    <label for="empresa_direccion">Dirección:</label>
    <textarea name="empresa_direccion" id="empresa_direccion"></textarea><br><br>

    <!-- Datos del usuario -->
    <label for="usuario_nombre">Nombre del usuario:</label>
    <input type="text" name="usuario_nombre" id="usuario_nombre" required><br><br>

    <label for="usuario_email">Email del usuario:</label>
    <input type="email" name="usuario_email" id="usuario_email" required><br><br>

    <label for="usuario_password">Contraseña:</label>
    <input type="password" name="usuario_password" id="usuario_password" required><br><br>

    <label for="usuario_role">Rol:</label>
    <select name="usuario_role" id="usuario_role" required>
        <option value="admin">Admin</option>
        <option value="operador">Operador</option>
        <option value="vendedor">Vendedor</option>
    </select><br><br>

    <button type="submit">Registrar</button>
</form>
