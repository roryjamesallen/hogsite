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
?>
