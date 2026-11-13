<?php
/** @var string $pageTitle */
$user = current_user();
$currentPage = basename($_SERVER['SCRIPT_NAME']);
?>
<!DOCTYPE html>
<html lang="<?= e(current_lang()) ?>" data-theme="dark">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
<title><?= e($pageTitle ?? t('app_name')) ?> · <?= e(t('app_name')) ?></title>
<meta name="csrf-token" content="<?= e(csrf_token()) ?>">
<link rel="stylesheet" href="<?= APP_BASE_URL ?>/assets/css/style.css?v=3">
<script>window.NOVABANK_BASE_URL = <?= json_encode(APP_BASE_URL) ?>;</script>
</head>
<body class="app-page app-page-<?= e(pathinfo($currentPage, PATHINFO_FILENAME)) ?>">
<div class="demo-banner" style="display: none;"><?= e(t('demo_notice')) ?></div>
<div class="app-shell">
    <aside class="sidebar">
        <?php require __DIR__ . '/sidebar.php'; ?>
    </aside>

    <div class="main-area">
        <header class="mobile-header">
            <button id="mobile-menu-toggle" class="mobile-menu-toggle" type="button" aria-label="Open navigation" aria-expanded="false"><span></span><span></span></button>
            <div class="brand">
                <span class="nova-mark" aria-hidden="true"><i></i><i></i><i></i></span>
                <div>
                    <div class="brand-name"><?= e(t('app_name')) ?></div>
                </div>
            </div>
            <div class="flex-gap">
                <a href="<?= APP_BASE_URL ?>/notifications.php" class="btn btn-ghost btn-sm" aria-label="<?= e(t('nav_notifications')) ?>">🔔</a>
            </div>
        </header>

        <header class="topbar">
            <div class="topbar-left">
                <h1 style="font-size:18px;margin:0;"><?= e($pageTitle ?? '') ?></h1>
            </div>
            <div class="topbar-right">
                <form method="get" style="margin:0;">
                    <input type="hidden" name="__keep" value="1">
                    <select name="lang" onchange="this.form.submit()" aria-label="Language" style="min-height:38px;padding:6px 10px;">
                        <option value="en" <?= current_lang() === 'en' ? 'selected' : '' ?>>English</option>
                        <option value="fil" <?= current_lang() === 'fil' ? 'selected' : '' ?>>Filipino</option>
                    </select>
                </form>
                <a href="<?= APP_BASE_URL ?>/notifications.php" class="btn btn-ghost btn-sm" aria-label="<?= e(t('nav_notifications')) ?>">🔔</a>
                <?php if ($user): ?>
                <a href="<?= APP_BASE_URL ?>/profile.php" class="btn btn-secondary btn-sm"><?= e($user['first_name']) ?></a>
                <?php endif; ?>
            </div>
        </header>

        <main class="page-content">
            <?php foreach (flash_get_all() as $flash): ?>
                <div class="alert alert-<?= e($flash['type']) ?>"><?= e($flash['message']) ?></div>
            <?php endforeach; ?>
