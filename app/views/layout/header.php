<?php
//use Config;
$logoConfig = Config::get('logo');
$logoFilename = $logoConfig['filename'] ?? null;
$logoPathPublic = $logoFilename
    ? '/assets/images/' . $logoFilename
    : null;
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title><?= e($title ?? 'Resident MVC') ?></title>

    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?=  $link ?? '' ?>
    <link rel="stylesheet"
          href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="/assets/css/style.css?v=<?= time() ?>">
    <style>
    <?= $custom_style ?? '' ?>
    </style>
    <?php if (!empty($page_css)) : ?>
    <link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/<?= $page_css ?>">
    <?php endif; ?>
    </head>
<body>
<?php require __DIR__ . '/../layout/menu.php'; 
$options = Config::options(); 
if (!isset($custom_js)) {
    $custom_js = '';
};   
?>

