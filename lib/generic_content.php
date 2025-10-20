<?php
$current_url = $_SERVER['REQUEST_URI'];

$base_content = '<base href="/hogsite/">';

$standard_header_content = '
	<meta charset="utf-8">
	<meta name="description" content="Welcome to the Hog Universe">
	<meta name="viewport" content="width=device-width, initial-scale=1" />'.$base_content.'
    <link rel="icon" type="image/png" href="favicon/favicon-96x96.png" sizes="96x96" />
	<link rel="icon" type="image/svg+xml" href="favicon/favicon.svg" />
	<link rel="shortcut icon" href="./favicon/favicon.ico" />
	<link rel="apple-touch-icon" sizes="180x180" href="favicon/apple-touch-icon.png" />
	<meta name="apple-mobile-web-app-title" content="hogwild.uk" />
	<link rel="manifest" href="favicon/site.webmanifest" />
	<link rel="stylesheet" href="style.css">';

$standard_toolbar = '
    <div class="standard-toolbar">
    <a class="button" href="https://hogwild.uk" style="background-image: url(images/buttons/hogwilduk.png)"></a>
    </div>';
?>
