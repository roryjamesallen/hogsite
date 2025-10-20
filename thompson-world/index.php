<?php
error_reporting(E_ALL);

include '../html_header.php';

if (isset($_GET['lounge_x'])){
	$thompson_room = 'lounge';
} else if (isset($_GET['kitchen_x'])){
	$thompson_room = 'kitchen';
} else if (isset($_GET['entrance-hallway_x'])){
	$thompson_room = 'entrance-hallway';
} else if (isset($_GET['conservatory_x'])){
	$thompson_room = 'conservatory';
} else if (isset($_GET['garden_x'])){
	$thompson_room = 'garden';
} else if (isset($_GET['pigeons_x'])){
	$thompson_room = 'pigeons';
} else {
	$thompson_room = 'entrance-hallway';
}
$thompson_room_pretty = ucwords(str_replace('-', ' ', $thompson_room));

function renderImageLink($image_name, $links_to, $width, $height, $style){
	return '<input class="scene-image-link" type="image" src="../images/thompson-world/thompson-world-'.$image_name.'.png" name="'.$links_to.'" width="'.$width.'px" height="'.$height.'px" style="'.$style.'">';
}
function renderImageOnclick($image_name, $onclick_function, $width, $height, $style){
    return '<img class="scene-image-link" id="'.$image_name.'" src="../images/thompson-world/thompson-world-'.$image_name.'.png" onclick="'.$onclick_function.'()" width="'.$width.'px" height="'.$height.'px" style="'.$style.'">';
}
function renderUnderlayImage($image_name, $width, $height, $style){
    return '<img class="scene-image" id="'.$image_name.'" src="../images/thompson-world/thompson-world-'.$image_name.'.png" width="'.$width.'px" height="'.$height.'px" style="'.$style.'">';
}

if ($thompson_room == 'lounge'){
	$thompson_background_height = '710';
	$thompson_background_src = 'lounge';
	$thompson_room_links = renderImageLink('lounge-to-hallway', 'entrance-hallway', '136', '111', 'left: 0px; bottom: 0px').renderImageLink('lounge-to-kitchen', 'kitchen', '122', '208', 'left: 544px; top: 110px');
} else if($thompson_room == 'entrance-hallway'){
	$thompson_background_height = '938';
	$thompson_background_src = 'front-hallway';
	$thompson_room_links = renderImageLink('front-hallway-door-to-lounge', 'lounge', '143', '352', 'left: 549px; top: 174px').renderImageLink('entrance-hallway-to-garden', 'garden', '74', '226', 'left: 393px; top: 117px');
} else if($thompson_room == 'kitchen'){
	$thompson_background_height = '1296';
	$thompson_background_src = 'kitchen';
	$thompson_room_links = renderImageLink('kitchen-to-lounge', 'lounge', '143', '103', 'left: 0px; bottom: 0px').renderImageLink('kitchen-to-conservatory', 'conservatory', '266', '484', 'left: 389px; top: 191px');
} else if ($thompson_room == 'conservatory'){
	$thompson_background_height = '744';
	$thompson_background_src = 'conservatory';
	$thompson_room_links = renderImageLink('conservatory-to-kitchen', 'kitchen', '156', '79', 'left: 0px; bottom: 0px').renderImageLink('conservatory-to-garden', 'garden', '103', '234', 'left: 213px; top: 116px').renderImageOnclick('conservatory-light-switch', 'flip_conservatory_lights', '45', '58', 'left: 695px; top: 407px').renderUnderlayImage('conservatory-lights-on', '1080', $thompson_background_height, 'top: 0; left: 0; display: none; z-index: -1;');
} else if ($thompson_room == 'garden'){
	$thompson_background_height = '737';
	$thompson_background_src = 'garden';
	$thompson_room_links = renderImageLink('garden-to-conservatory', 'conservatory', '129', '212', 'left: 288px; top: 336px').renderImageLink('garden-to-entrance-hallway', 'entrance-hallway', '124', '68', 'right: 0px; bottom: 0px').renderImageLink('garden-to-pigeons', 'pigeons', '125', '67', 'left: 320px; top: 46px');
} else if ($thompson_room == 'pigeons'){
	$thompson_background_height = '744';
	$thompson_background_src = 'pigeons';
	$thompson_room_links = renderImageLink('pigeons-to-garden', 'garden', '185', '88', 'left: 0px; bottom: 0px');
}
?>
    
<div class="button-container" style="padding-top: 0;">
	<div id="scene-container" class="scene-container" style="transform-origin: top; width: 1080px; height: <?php echo $thompson_background_height ?>px">
		<form action="" method="GET" class="thompson-world-form">
			<img class="scene-image scene-background" src="../images/thompson-world/thompson-world-<?php echo $thompson_background_src ?>.png">
            <?php echo $thompson_room_links; ?>
		</form>
	</div>
</div>

<script>
    function resizeSceneContainer(){
        var window_width = window.innerWidth;
        var window_height = window.innerHeight;
        var original_container_width = 1080;
        var original_container_height = <?php echo $thompson_background_height;?>;
        var width_scale = 1;
        var height_scale = 1;
        var width_scale = window_width / original_container_width;
        var height_scale = window_height / original_container_height;
        if (width_scale < height_scale){ // Use smaller scale
            scale = width_scale;
        } else {
            scale = height_scale;
        }
        document.getElementById('scene-container').style.transform = 'scale(' + scale + ')';
    }
resizeSceneContainer();

function flip_conservatory_lights(){
    var current_state = document.getElementById('conservatory-lights-on').style.display;
    if (current_state == 'none'){
        new_state = 'block';
    } else {
        new_state = 'none';
    }
    document.getElementById('conservatory-lights-on').style.display = new_state;
}
</script>
