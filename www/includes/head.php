<?php
/**
 * Shared <head> partial
 *
 * Variables (set before including):
 *   $page_title       — Page title (required)
 *   $page_description — Meta description (required)
 *   $page_canonical   — Canonical URL (required)
 *   $page_og_image    — OG image URL (optional)
 */

$og_image = isset($page_og_image) ? $page_og_image : 'https://automationsequre.nl/assets/og-default.jpg';
?>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title><?= htmlspecialchars($page_title) ?></title>
<meta name="description" content="<?= htmlspecialchars($page_description) ?>">
<link rel="canonical" href="<?= htmlspecialchars($page_canonical) ?>">

<!-- Open Graph -->
<meta property="og:title" content="<?= htmlspecialchars($page_title) ?>">
<meta property="og:description" content="<?= htmlspecialchars($page_description) ?>">
<meta property="og:type" content="website">
<meta property="og:url" content="<?= htmlspecialchars($page_canonical) ?>">
<meta property="og:locale" content="nl_NL">
<meta property="og:image" content="<?= htmlspecialchars($og_image) ?>">

<!-- Favicon -->
<link rel="icon" type="image/svg+xml" href="/favicon.svg">
<link rel="icon" type="image/png" sizes="32x32" href="/favicon.png">
<link rel="apple-touch-icon" href="/favicon.png">

<!-- Fonts -->
<link rel="preconnect" href="https://api.fontshare.com" crossorigin>
<link href="https://api.fontshare.com/v2/css?f[]=satoshi@400;500;700;900&display=swap" rel="stylesheet">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=DM+Sans:ital,opsz,wght@0,9..40,400;0,9..40,500;0,9..40,700;1,9..40,400&family=Geist+Mono:wght@400;500&display=swap" rel="stylesheet">

<!-- Styles -->
<link rel="stylesheet" href="/styles.css">
<link rel="stylesheet" href="/css/pages.css">
