<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

function getTileDifference($old_state, $new_state){
    $tiles_different = [];
    for ($slot=0; $slot<count($old_state); ++$slot){
	if ($old_state[$slot] != $new_state[$slot]){
	    $tiles_different[] = $new_state[$slot];
	}
    }
    return $tiles_different;
}
function removeTiles($rack, $tiles_to_remove){
    echo $rack.'<br>';
    echo $tiles_to_remove.'<br>';
    return array_diff($rack, $tiles_to_remove);
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['board_state']) && isset($_POST['game_path'])){
    $game_path = $_POST['game_path'];
    $board_state = json_decode($_POST['board_state']);
    $game_data = json_decode(file_get_contents($game_path),true);
    $user_played = $game_data['turn'];
    $user_next = ($user_played + 1) % $game_data['players']; // increment user and wrap around

    // compare new vs old board state to find tiles used by prev player
    // use tilebag to repopulate users rack if possible

    $user_object_key = $game_data['users'][$user_played];
    $users_old_rack = $game_data[$user_object_key]['rack'];
    $users_new_rack = json_encode(removeTiles($users_old_rack, getTileDifference($game_data['board_state'], $board_state)));
    echo $users_new_rack;
    
    //update actual json
    $game_data['turn'] = $user_next;
    $game_data['board_state'] = $board_state;
    $game_data[$user_object_key]['rack'] = $users_new_rack;
    file_put_contents($game_path, json_encode($game_data));
    //return true;
    
    // get game json
    // get user who just played from game json
    // check which user should be next based on number of users in json
}
?>
