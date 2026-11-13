<?php
/** @var string $pageTitle */
$adminPage = basename($_SERVER['SCRIPT_NAME']);
$adminLinks = [
    ['index.php', 'Overview', '📊'],
    ['users.php', 'Users', '👥'],
    ['transactions.php', 'Transactions', '📜'],
    ['loans.php', 'Loans', '🏦'],
    ['security-logs.php', 'Security Logs', '🛡️'],
    ['settings.php', 'Settings', '⚙️'],
];
?>
<!DOCTYPE html>
<html lang="en" data-theme="dark">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title><?= e($pageTitle ?? 'Admin') ?> · NovaBank Admin</title>
<meta name="csrf-token" content="<?= e(csrf_token()) ?>">
<link rel="stylesheet" href="<?= APP_BASE_URL ?>/assets/css/style.css?v=3">
<script>window.NOVABANK_BASE_URL = <?= json_encode(APP_BASE_URL) ?>;</script>
</head>
<body class="admin-page admin-page-<?= e(pathinfo($adminPage, PATHINFO_FILENAME)) ?>">
<div class="demo-banner">NOVABANK ADMIN · DEMO ENVIRONMENT · No real users, funds, or data.</div>
<div class="app-shell">
    <aside class="sidebar">
        <div class="brand">
            <span class="nova-mark" aria-hidden="true"><i></i><i></i><i></i></span>
            <div>
                <div class="brand-name">NovaBank</div>
                <div class="brand-tagline">Admin Console</div>
            </div>
        </div>
        <?php foreach ($adminLinks as [$file, $label, $icon]): ?>
            <a href="<?= APP_BASE_URL ?>/admin/<?= $file ?>" class="nav-link <?= $adminPage === $file ? 'active' : '' ?>">
                <span class="nav-icon" aria-hidden="true"><?= $icon ?></span>
                <span><?= e($label) ?></span>
            </a>
        <?php endforeach; ?>
        <div class="sidebar-footer">
            <a href="<?= APP_BASE_URL ?>/dashboard.php" class="nav-link"><span class="nav-icon">🏠</span><span>Customer View</span></a>
            <form method="post" action="<?= APP_BASE_URL ?>/logout.php">
                <?= csrf_field() ?>
                <button type="submit" class="nav-link" style="width:100%;text-align:left;border:none;background:none;cursor:pointer;font-family:inherit;">
                    <span class="nav-icon">🚪</span><span>Log Out</span>
                </button>
            </form>
        </div>
    </aside>

    <div class="main-area">
        <header class="mobile-header admin-mobile-header">
            <button id="mobile-menu-toggle" class="mobile-menu-toggle" type="button" aria-label="Open navigation" aria-expanded="false"><span></span><span></span></button>
            <div class="brand"><span class="nova-mark" aria-hidden="true"><i></i><i></i><i></i></span><div><div class="brand-name">NovaBank</div><div class="brand-tagline">Admin Console</div></div></div>
        </header>
        <header class="topbar">
            <div class="topbar-left"><h1 style="font-size:18px;margin:0;"><?= e($pageTitle ?? '') ?></h1></div>
            <div class="topbar-right">
                <span class="badge badge-danger">ADMIN</span>
            </div>
        </header>
        <main class="page-content">
            <?php foreach (flash_get_all() as $flash): ?>
                <div class="alert alert-<?= e($flash['type']) ?>"><?= e($flash['message']) ?></div>
            <?php endforeach; ?>
