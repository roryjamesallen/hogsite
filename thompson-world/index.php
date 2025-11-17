<?php
include '../lib/generic_content.php';

$rooms = [
		"front-door",
		"entrance-hallway",
		"naughty-step",
		"lounge",
		"kitchen",
		"conservatory",
		"garden",
		"pigeons", 
		"first-floor-landing",
        "danny-and-rubys-room",
		"bathroom",
		"under-construction",
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
        renderImageLink('front-door-to-entrance-hallway', 'entrance-hallway', '253', '499', 'left: 236px; top: 866px').
        "<span style='position: absolute; top: 4rem; right: 0; background: white; z-index: 99; font-size: 3rem; padding: 2rem'>This is a recreation (to the best of our memory) of the house that a few hogs lived in. See which rooms you can explore (some are yet to be added) and what you can interact with inside those rooms...</span>";
} else if ($thompson_room == 'naughty-step'){
	$thompson_background_height = '1441';
	$thompson_background_src = 'naughty-step';
	$thompson_room_links =
        renderImageLink('naughty-step-to-lounge', 'lounge', '277', '942', 'left: 0px; top: 379px').
        renderImageLink('naughty-step-to-entrance-hallway', 'entrance-hallway', '130', '228', 'left: 406px; bottom: 0px').
        renderImageLink('naughty-step-to-first-floor-landing', 'first-floor-landing', '472', '816', 'left: 316px; top: 204px').
        renderImageLink('naughty-step-to-alexs-room', 'under-construction', '279', '977', 'left: 800px; top: 345px');
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
        renderImageLink('garden-to-entrance-hallway', 'entrance-hallway', '124', '68', 'left: 930px; bottom: 0px').
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
        renderImageLink('first-floor-landing-to-second-floor-landing', 'danny-and-rubys-room', '95', '236', 'left:448px; top: 143px').
        renderImageLink('first-floor-landing-to-bathroom', 'bathroom', '181', '227', 'left: 870px; bottom: 0px');
} else if ($thompson_room == 'bathroom'){
	$thompson_background_height = '810';
	$thompson_background_src = 'bathroom';
	$thompson_room_links =
        renderImageLink('bathroom-to-first-floor-landing', 'first-floor-landing', '194', '96', 'left: 0px; bottom: 0px').
		renderUnderlayImage('bathroom-tap-on', '61', '60', 'top: 342px; left: 776px; display: none; z-index: -1;').
		renderImageOnclick('bathroom-tap', '48', '42', 'left: 790px; top: 315px');
} else if ($thompson_room == 'danny-and-rubys-room'){
	$thompson_background_height = '739';
	$thompson_background_src = 'danny-and-rubys-room';
	$thompson_room_links =
        renderImageLink('pigeons-to-garden', 'first-floor-landing', '185', '88', 'left: 0px; bottom: 0px');
} else if ($thompson_room == 'under-construction'){
	$thompson_background_height = '500';
	$thompson_background_src = 'under-construction';
	$thompson_room_links =
        renderImageLink('pigeons-to-garden', 'front-door', '185', '88', 'left: 0px; bottom: 0px');
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
<div class="button-container" id="button-container">
     <div class="scene-container" id="scene-container" style="transform-origin: left top; width: 1080px; height: <?php echo $thompson_background_height ?>px">
		<form action="" method="GET" class="thompson-world-form">
			<img class="scene-image scene-background" src="images/thompson-world/thompson-world-<?php echo $thompson_background_src ?>.png">
            <?php echo $thompson_room_links; ?>
		</form>
	</div>
</div>
<div class='neh-hogwild-footer' style='width: fit-content; margin: 2rem auto; font-family: Arial'>A <a class='button-as-link' href='https://hogwild.uk'>hogwild.uk</a> creation</div>
</body>

<script type='module'>
import { createCookie, readCookie, flipDisplayOfElements, initialiseFlippableElements } from './lib/hoglib.js';

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
    var container_height = original_container_height * scale;
    document.getElementById('button-container').style.height = container_height.toString() + 'px';
}

function flipConservatoryLights(){
    flipDisplayOfElements(['conservatory-lights-on','garden-lights-on','kitchen-lights-on']);
}
function initialiseConservatoryLights(){
	initialiseFlippableElements(
	['conservatory-lights-on','garden-lights-on','kitchen-lights-on'],
	['conservatory-light-switch'],
	flipConservatoryLights);
}
function flipBathroomTap(){
    flipDisplayOfElements(['bathroom-tap-on']);
}
function initialiseBathroomTap(){
	initialiseFlippableElements(
	['bathroom-tap-on'],
	['bathroom-tap'],
	flipBathroomTap);
}

initialiseConservatoryLights();
initialiseBathroomTap();

window.onload = resizeSceneContainer();
</script>
