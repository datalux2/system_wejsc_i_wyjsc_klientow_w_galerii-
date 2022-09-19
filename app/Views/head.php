<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>System wejść i wyjść klientów w galerii</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles/bootstrap.min.css">
    <link rel="stylesheet" href="styles/styles.css">
    <script type="text/javascript" src="js/jquery-3.6.1.min.js"></script>
    <script type="text/javascript" src="js/bootstrap.min.js"></script>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
</head>
<body>
<div id="title">
    System wejść i wyjść klientów w galerii
</div>
<div id="menu-container">
    <ul id="menu">
        <li><a href="/"<?php if(uri_string() == '/'): ?> class="active"<?php endif; ?>>Strona główna</a></li>
        <li><a href="zlicz-losowo-wejscia-wyjscia"<?php if(uri_string() == 'zlicz-losowo-wejscia-wyjscia'): ?> class="active"<?php endif; ?>>Zlicz losowo wejścia i wyjścia - cron</a></li>
        <li><a href="wykres-statystyki"<?php if(uri_string() == 'wykres-statystyki'): ?> class="active"<?php endif; ?>>Wykres i statystyki</a></li>
    </ul>
</div>
<div id="content">
