<!-- app/views/layouts/layout.php -->
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= $title ?? 'CRM' ?></title>
    <link href="/assets/css/output.css" rel="stylesheet">
    <link href="/assets/css/custom.css" rel="stylesheet">
</head>
<body>
    <?php view('layouts/navbar'); ?>
    <div class="container mx-auto px-4 py-4">
        <?= $content ?>
    </div>
</body>
</html>