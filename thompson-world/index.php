<?php 
include '../html_header.php';

if (!isset($_GET['thompson-room'])){
	$thompson_room = 'lounge';
} else {
	$thompson_room = $_GET['thompson-room'];
}
?>

<?php 
	if ($thompson_room == 'lounge'){
		$thompson_background_height = '710';
		$thompson_background_src = 'lounge';
		$thompson_room_links = '
			<a href="https://hogwild.uk/thompson-world/entrance-hallway" class="scene-image-link" style="width: 258px; height: 180px; left: 0px; bottom: 0px">
				<img class="scene-image" src="images/thompson-world/thompson-world-lounge-to-hallway.png">
			</a>
			<a href="https://hogwild.uk/thompson-world/kitchen" class="scene-image-link" style="width: 122px; height: 208px; left: 544px; top: 110px">
				<img class="scene-image" src="images/thompson-world/thompson-world-lounge-to-kitchen.png">
			</a>';
		$thompson_room_links = '
			<input class="scene-image" type="image" src="../images/thompson-world/thompson-world-lounge-to-hallway.png" name="entrance-hallway" width="258px" height="180px" style="left: 0px; bottom: 0px">
			<input class="scene-image" type="image" src="../images/thompson-world/thompson-world-lounge-to-kitchen.png" name="entrance-hallway" width="122px" height="208px" style="left: 544px; top: 110px">
			'
	} else if($thompson_room == 'entrance-hallway'){
		$thompson_background_height: '938';
		$thompson_background_src = 'front-hallway';
		$thompson_room_links = '
			<a href="https://hogwild.uk/thompson-world/lounge" class="scene-image-link" style="width: 143px; height: 352px; left: 549px; top: 174px">
				<img class="scene-image" src="images/thompson-world/thompson-world-front-hallway-door-to-lounge.png">
			</a>
		';
	} else if($thompson_room == 'kitchen'){
		$thompson_background_height: '1296';
		$thompson_background_src = 'kitchen';
		$thompson_room_links = '
			<a href="https://hogwild.uk/thompson-world/lounge" class="scene-image-link" style="width: 310px; height: 211px; left: 0px; bottom: 0px">
				<img class="scene-image" src="images/thompson-world/thompson-world-kitchen-to-lounge.png">
			</a>
		';
	} 
?>

<div class="scene-container" style="width: 1080px; height: <?php echo $thompson_background_height ?>px">
	<img class="scene-image scene-background" src="images/thompson-world/thompson-world-<?php echo $thompson_background_src ?>.png">
	<form action="" method="GET">
		<?php echo $thompson_room_links ?>
	</form>
</div>