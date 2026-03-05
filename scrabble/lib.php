<?php
function gamePathFromId($game_id){
    return 'games/'.$game_id.'.json';
}
function gameIdFromPath($game_path){
    return str_replace('.json','',str_replace('games/','',$game_path));
}
function refillRack($game_data, $nickname){
    while (count($game_data[$nickname]['rack']) < 7 && count($game_data['tilebag']) > 0){
        $new_tile_tilebag_index = array_rand($game_data['tilebag'], 1);
        $new_tile = array_splice($game_data['tilebag'], $new_tile_tilebag_index, 1)[0];
        $game_data[$nickname]['rack'][] = $new_tile;
        $game_data[$nickname]['rack'] = array_values($game_data[$nickname]['rack']);
    }
    return $game_data;
}
function renderHeading($level=''){
    echo '<head><link rel="stylesheet" href="'.$level.'style.css"></head><div id="title-container"><h1>hog scrabble</h1><h2>free and multiplayer</h2><a href="?">home</a></div>';
}
function getGameUsersString($game_id){
    $game_path = gamePathFromId($game_id);
    $game_data = json_decode(file_get_contents($game_path),true);
    $users = $game_data['users'];
    if (isset($_SESSION[$game_id])){
	unset($users[array_search($_SESSION[$game_id],$users)]); // remove the user looking at the list
    }
    if (count($users) > 0){
	return ' (with '.implode(', ',$users).')';
    } else {
	return ' (waiting for users)';
    }
}
function renderSessionGames(){
    echo '<br><br><h2>Rejoin Game</h2><form>';
    for ($game_index=0; $game_index<count($_SESSION); $game_index++){
	$game_id = array_keys($_SESSION)[$game_index];
	$game_users_string = getGameUsersString($game_id);
	echo '<span><a href="./?game='.$game_id.'">'.$game_id.'</a>'.$game_users_string.'</span>';
    }
    echo '</form>';
}
function renderCreateGameForm(){
    echo '<br><br><h2>Create Game</h2><form action="create_game.php" method="POST" style="margin-bottom: 5rem;"><p>Number of Players:</p>';
    for ($players=2; $players<=8; $players++){
	echo '<input type="radio" name="players" value="'.$players.'" id="players-'.$players.'">';
	echo '<label for="players-'.$players.'">'.$players.'</label>';
    }
    echo '<label for="nickname-input">Your Nickname</label><input id="nickname-input" name="nickname"><input type="submit" value="Create Game"></form>';
}
?>
