<!DOCTYPE html>
<html>
    <head>
	<title>Meal Deal Maker</title>
	<meta charset="UTF-8">
	<meta name="description" content="Create and name your favourite meal deals.">
	<meta property="og:title" content="Meal Deal Maker">
	<meta property="og:description" content="Create and name your favourite meal deals.">
	<meta property="og:image" content="https://hogwild.uk/mealdeal/sharing.png">
	<meta property="og:url" content="https://hogwild.uk/mealdeal">
	<meta name="viewport" content="width=device-width, initial-scale=1"/>
	<link rel="icon" type="image/x-icon" href="favicon.ico"
	<link rel="shortcut icon" href="favicon.ico" />
	<link rel="stylesheet" href="style.css">
    </head>

    <!-- Google tag (gtag.js) -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-6BQYQMEP06"></script>
    <script>
     window.dataLayer = window.dataLayer || [];
     function gtag(){dataLayer.push(arguments);}
     gtag('js', new Date());
    </script>
    
    <body>
	<h1><span class="hidden">Meal Deal Maker</span><img id="logo" src="images/logo.png" alt="Logo for Meal Deal Maker" /></h1>
	<?php
	include '../lib/generic_content.php';
	openSqlConnection('wildhog_mealdeal', '../sql_login_wildhog_mealdeal.php');
	$combos = sqlQuery('SELECT * FROM combos WHERE 1 ORDER BY time DESC');
	echo '<div class="all-combo-list">';
	foreach ($combos as $combo){
	    $name_info = sqlQuery('SELECT * FROM names WHERE combo_id="'.$combo['combo_id'].'"');
	    $name = urldecode($name_info[0]['name']);
	    $username = urldecode($name_info[0]['username']);
	    $url = 'https://hogwild.uk/mealdeal?main='.$combo['main'].'&snack='.$combo['snack'].'&drink='.$combo['drink'];
	    echo '<a href="'.$url.'" class="all-combo-container">';
	    echo '<h2>'.$name.'</h2>';
	    foreach (['main','snack','drink'] as $type){
		echo '<img src="images/'.$combo[$type].'.jpg">';
	    }
	    echo '</a>';
	}
	echo '</div>';
	?>
	<br><h4><a href="https://hogwild.uk/mealdeal">Create A Meal Deal</a></h4>
	<div class='footer' style='width: fit-content; margin: 6rem auto; font-family: Arial; font-size: 1rem; text-align: center;'>
	    For bug reports and suggestions please email <a href="mailto:rory@hogwild.uk">rory@hogwild.uk</a><br><br>
	    A <a class='button-as-link' href='https://hogwild.uk'>hogwild.uk</a> creation
	</div>
    </body>
</html>
