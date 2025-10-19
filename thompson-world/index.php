<?php 
include '../html_header.php';

if (isset($_GET['lounge_x'])){
	$thompson_room = 'lounge';
} else if (isset($_GET['kitchen_x'])){
	$thompson_room = 'kitchen';
} else if (isset($_GET['entrance-hallway_x'])){
	$thompson_room = 'entrance-hallway';
} else if (isset($_GET['conservatory_x'])){
	$thompson_room = 'conservatory';
} else {
	$thompson_room = 'entrance-hallway';
}
$thompson_room_pretty = ucwords(str_replace('-', ' ', $thompson_room));

function renderImageLink($image_name, $links_to, $width, $height, $style){
	echo '<input class="scene-image-link" type="image" src="../images/thompson-world/thompson-world-'.$image_name.'.png" name="'.$links_to.'" width="'.$width.'px" height="'.$height.'px" style="'.$style.'">';
}

if ($thompson_room == 'lounge'){
	$thompson_background_height = '710';
	$thompson_background_src = 'lounge';
	$thompson_room_links = renderImageLink('lounge-to-hallway', 'entrance-hallway', '258', '180', 'left: 0px; bottom: 0px').renderImageLink('lounge-to-kitchen', 'kitchen', '122', '208', 'left: 544px; top: 110px');
} else if($thompson_room == 'entrance-hallway'){
	$thompson_background_height = '938';
	$thompson_background_src = 'front-hallway';
	$thompson_room_links = renderImageLink('front-hallway-door-to-lounge', 'lounge', '143', '352', 'left: 549px; top: 174px');
} else if($thompson_room == 'kitchen'){
	$thompson_background_height = '1296';
	$thompson_background_src = 'kitchen';
	$thompson_room_links = renderImageLink('kitchen-to-lounge', 'lounge', '310', '211', 'left: 0px; bottom: 0px').renderImageLink('kitchen-to-conservatory', 'conservatory', '266', '484', 'left: 389px; top: 191px');
} else if ($thompson_room == 'conservatory'){
	$thompson_background_height = '744';
	$thompson_background_src = 'conservatory';
	$thompson_room_links = renderImageLink('front-hallway-conservatory-to-lounge', 'lounge', '169', '152', 'left: 0px; bottom: 0px');
}
?>

<div class="button-container">
	<h1 style="width: 100%; text-align: center;"><?php echo $thompson_room_pretty ?></h1>
	<div class="scene-container" style="width: 1080px; height: <?php echo $thompson_background_height ?>px">
		<form action="" method="GET" class="thompson-world-form">
			<img class="scene-image scene-background" src="../images/thompson-world/thompson-world-<?php echo $thompson_background_src ?>.png">
			<?php echo $thompson_room_links ?>
		</form>
	</div>
</div>