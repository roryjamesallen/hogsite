<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

// $_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['players']) && isset($_POST['nickname']) or true
if (true){
    $game_id = uniqid();
    $game_path = 'games/'.$game_id.'.json';
    $game_data = '{
	"status": 0,
	"players": '.$_POST['players'].',
	"users": ['.$_POST['nickname'].'],
	"turn": 0,
	'.$_POST['nickname'].': {
	    "rack": []
	},
	"tilebag":[
	    "E","E","E","E","E","E","E","E","E","E","E","E",
	    "A","A","A","A","A","A","A","A","A",
	    "I","I","I","I","I","I","I","I","I",
	    "O","O","O","O","O","O","O","O",
	    "N","N","N","N","N","N",
	    "T","T","T","T","T","T",
	    "L","L","L","L",
	    "S","S","S","S",
	    "U","U","U","U",
	    "D","D","D","D",
	    "G","G","G",
	    "B","B",
	    "C","C",
	    "M","M",
	    "P","P",
	    "F","F",
	    "H","H",
	    "V","V",
	    "W","W",
	    "Y","Y",
	    "K","J","X","Q","Z"]
    }';
    file_put_contents($game_path, $game_data);
    echo 'send this link to your pals: <a href="../scrabble?game='.$game_id.'">Copy Join Link</a>';
}
?>
