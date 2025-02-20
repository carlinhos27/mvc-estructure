<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
</head>
<body>
    <h1>Iniciar sesión</h1>
    <form action="/login" method="POST">
        <input type="email" name="email" placeholder="Correo electrónico" required>
        <input type="password" name="password" placeholder="Contraseña" required>
        <button type="submit">Ingresar</button>
    </form>
    <?php if (!empty($_SESSION['error'])): ?>
        <p style="color: red;"><?= $_SESSION['error']; ?></p>
    <?php endif; ?>
</body>
</html>
