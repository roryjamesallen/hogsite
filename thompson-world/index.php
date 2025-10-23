<?php
include '../lib/generic_content.php';

$rooms = ["lounge",
          "kitchen",
          "conservatory",
          "entrance-hallway",
          "naughty-step",
          "garden",
          "pigeons",
          "first-floor-landing",
          "rorys-room",
          "under-construction"
];
$thompson_room = 'front-door'; // Default
foreach ($rooms as $room){
    if (isset($_GET[$room.'_x'])){
            $thompson_room = $room; // Update if GET is set to another room
        }
}
$thompson_room_pretty = ucwords(str_replace('-', ' ', $thompson_room));

function renderImageLink($image_name, $links_to, $width, $height, $style){
	return '<input class="scene-image-link" type="image" src="images/thompson-world/thompson-world-'.$image_name.'.png" name="'.$links_to.'" width="'.$width.'px" height="'.$height.'px" style="'.$style.'">';
}
function renderImageOnclick($image_name, $width, $height, $style){
    return '<img class="scene-image-link" id="'.$image_name.'" src="images/thompson-world/thompson-world-'.$image_name.'.png" width="'.$width.'px" height="'.$height.'px" style="'.$style.'">';
}
function renderUnderlayImage($image_name, $width, $height, $style){
    return '<img class="scene-image" id="'.$image_name.'" src="images/thompson-world/thompson-world-'.$image_name.'.png" width="'.$width.'px" height="'.$height.'px" style="'.$style.'">';
}

if ($thompson_room == 'lounge'){
	$thompson_background_height = '710';
	$thompson_background_src = 'lounge';
	$thompson_room_links =
        renderImageLink('lounge-to-naughty-step', 'naughty-step', '136', '111', 'left: 0px; bottom: 0px').
        renderImageLink('lounge-to-kitchen', 'kitchen', '122', '208', 'left: 544px; top: 110px');
} else if ($thompson_room == 'front-door'){
	$thompson_background_height = '1699';
	$thompson_background_src = 'front-door';
	$thompson_room_links =
        renderImageLink('front-door-to-entrance-hallway', 'entrance-hallway', '253', '499', 'left: 236px; top: 866px');
} else if ($thompson_room == 'naughty-step'){
	$thompson_background_height = '1441';
	$thompson_background_src = 'naughty-step';
	$thompson_room_links =
        renderImageLink('naughty-step-to-lounge', 'lounge', '277', '942', 'left: 0px; top: 379px').
        renderImageLink('naughty-step-to-entrance-hallway', 'entrance-hallway', '130', '228', 'left: 406px; bottom: 0px').
        renderImageLink('naughty-step-to-first-floor-landing', 'first-floor-landing', '472', '816', 'left: 316px; top: 204px').
        renderImageLink('naughty-step-to-alexs-room', 'under-construction', '279', '977', 'right: 0px; top: 345px');
} else if($thompson_room == 'entrance-hallway'){
	$thompson_background_height = '938';
	$thompson_background_src = 'front-hallway';
	$thompson_room_links =
        renderImageLink('front-hallway-door-to-naughty-step', 'naughty-step', '143', '352', 'left: 549px; top: 174px').
        renderImageLink('entrance-hallway-to-garden', 'garden', '74', '226', 'left: 393px; top: 117px').
        renderImageLink('entrance-hallway-to-front-door', 'front-door', '97', '167', 'left: 413px; top: 722px');
} else if($thompson_room == 'kitchen'){
	$thompson_background_height = '1296';
	$thompson_background_src = 'kitchen';
	$thompson_room_links =
        renderImageLink('kitchen-to-lounge', 'lounge', '143', '103', 'left: 0px; bottom: 0px').
        renderImageLink('kitchen-to-conservatory', 'conservatory', '266', '484', 'left: 389px; top: 191px').
        renderUnderlayImage('kitchen-lights-on', '1080', $thompson_background_height, 'top: 0; left: 0; display: none; z-index: -1;');
} else if ($thompson_room == 'conservatory'){
	$thompson_background_height = '744';
	$thompson_background_src = 'conservatory';
	$thompson_room_links =
        renderImageLink('conservatory-to-kitchen', 'kitchen', '156', '79', 'left: 0px; bottom: 0px').
        renderImageLink('conservatory-to-garden', 'garden', '103', '234', 'left: 213px; top: 116px').
        renderImageOnclick('conservatory-light-switch', '45', '58', 'left: 695px; top: 407px').
        renderUnderlayImage('conservatory-lights-on', '1080', $thompson_background_height, 'top: 0; left: 0; display: none; z-index: -1;');
} else if ($thompson_room == 'garden'){
	$thompson_background_height = '737';
	$thompson_background_src = 'garden';
	$thompson_room_links =
        renderImageLink('garden-to-conservatory', 'conservatory', '129', '212', 'left: 288px; top: 336px').
        renderImageLink('garden-to-entrance-hallway', 'entrance-hallway', '124', '68', 'right: 0px; bottom: 0px').
        renderImageLink('garden-to-pigeons', 'pigeons', '125', '67', 'left: 320px; top: 46px').
        renderUnderlayImage('garden-lights-on', '1080', $thompson_background_height, 'top: 0; left: 0; display: none; z-index: -1;');
} else if ($thompson_room == 'pigeons'){
	$thompson_background_height = '744';
	$thompson_background_src = 'pigeons';
	$thompson_room_links =
        renderImageLink('pigeons-to-garden', 'garden', '185', '88', 'left: 0px; bottom: 0px');
} else if ($thompson_room == 'first-floor-landing'){
	$thompson_background_height = '810';
	$thompson_background_src = 'first-floor-landing';
	$thompson_room_links =
        renderImageLink('first-floor-landing-to-naughty-step', 'naughty-step', '208', '152', 'left: 253px; top: 538px').
        renderImageLink('first-floor-landing-to-rorys-room', 'under-construction', '176', '575', 'left:0px; bottom: 0px').
        renderImageLink('first-floor-landing-to-itays-room', 'under-construction', '149', '446', 'left:673px; top: 239px').
        renderImageLink('first-floor-landing-to-second-floor-landing', 'under-construction', '95', '236', 'left:448px; top: 143px').
        renderImageLink('first-floor-landing-to-bathroom', 'under-construction', '181', '227', 'right:0px; bottom: 0px');
} else if ($thompson_room == 'under-construction'){
	$thompson_background_height = '500';
	$thompson_background_src = 'under-construction';
	$thompson_room_links =
        renderImageLink('pigeons-to-garden', 'entrance-hallway', '185', '88', 'left: 0px; bottom: 0px');
}
?>

<!DOCTYPE html>
<head>
    <?php echo $standard_header_content;?>
    <link rel="canonical" href="https://tw.hogwild.uk" />
    <title><?php echo $thompson_room_pretty;?></title>
</head>
<body>
<?php echo $standard_toolbar;?>
<div class="button-container" style="padding-top: 0;">
	<div id="scene-container" class="scene-container" style="transform-origin: top; width: 1080px; height: <?php echo $thompson_background_height ?>px">
		<form action="" method="GET" class="thompson-world-form">
			<img class="scene-image scene-background" src="images/thompson-world/thompson-world-<?php echo $thompson_background_src ?>.png">
            <?php echo $thompson_room_links; ?>
		</form>
	</div>
</div>
</body>

<script type='module'>
import { createCookie, readCookie } from './lib/hoglib.js';

var thompson_room = '<?php echo $thompson_room;?>';

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
        var scale = width_scale;
    } else {
        var scale = height_scale;
    }
    document.getElementById('scene-container').style.transform = 'scale(' + scale + ')';
}
function initialiseConservatoryLights(){
    var old_state = readCookie('conservatory-light-display');
    if (old_state == null){
	old_state = 'none';
    }
    if (thompson_room == 'conservatory'){
	document.getElementById('conservatory-light-switch').addEventListener('click', flipConservatoryLights);
	document.getElementById('conservatory-lights-on').style.display = old_state;
    } else if (thompson_room == 'garden'){  
	document.getElementById('garden-lights-on').style.display = old_state;
    } else if (thompson_room == 'kitchen'){  
	document.getElementById('kitchen-lights-on').style.display = old_state;
    }
}
function flipConservatoryLights(){
    var current_state = document.getElementById('conservatory-lights-on').style.display;
    if (current_state == 'none'){
        var new_state = 'block';
    } else {
        var new_state = 'none';
    }
    createCookie('conservatory-light-display', new_state, 1);
    document.getElementById('conservatory-lights-on').style.display = new_state;
    document.getElementById('garden-lights-on').style.display = new_state;
    document.getElementById('kitchen-lights-on').style.display = new_state;
}
resizeSceneContainer();
initialiseConservatoryLights();
</script>
