<?php
include 'lib/generic_content.php';
ob_start(); // Begin output buffering to allow output to be rendered after html head

openSqlConnection('wildhog_analytics', 'sql_login_wildhog_analytics.php');
recordUserVisit();
?>

<head>
    <?php echo $standard_header_content;?>
    <title>hogwild.uk</title>
</head>
    
<div class="button-container">
    <img style="width: 100%;" src="images/hogwilduk-banner.png"></img>
     
    <a class="button" href="https://notoalgorithms.hogwild.uk">
		<img src="images/buttons/notoalgorithms.png" class="button-image">
	</a>

	<div class="hogspin-container">
		<img id="hogspin1" src="images/hogspin/1.png" style="display: block">
		<img id="hogspin2" src="images/hogspin/2.png" style="display: none">
		<img id="hogspin3" src="images/hogspin/3.png" style="display: none">
		<img id="hogspin4" src="images/hogspin/4.png" style="display: none">
		<img id="hogspin5" src="images/hogspin/5.png" style="display: none">
		<img id="hogspin6" src="images/hogspin/6.png" style="display: none">
		<img id="hogspin7" src="images/hogspin/7.png" style="display: none">
		<img id="hogspin8" src="images/hogspin/8.png" style="display: none">
	</div>


	<a class="button" href="https://tw.hogwild.uk">
		<img src="images/buttons/thompson-world.png" class="button-image">
	</a>
	
</div>

<script type="module">
    import { start_image_loop } from './lib/hoglib.js';
    start_image_loop('hogspin', 8, 150);
</script>
