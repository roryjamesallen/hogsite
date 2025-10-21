<?php
include '../lib/generic_content.php';

function resolveLinks($json){
	return str_replace('[[','<input type="submit" name="',str_replace(']]','">',$json));	
}
function renderWikiPage($schema){
    echo '<h1>'.$schema['title'].'</h1>';
	echo '<form method="GET">';
    echo '<h2>'.$schema['category'].'</h2>';
    foreach ($schema['sections'] as $heading => $section){
        echo '<h3>'.$heading.'</h3>';
        echo resolveLinks($section).'<br>';
    }
	echo '</form>';
}

$string = file_get_contents('wiki_content.json');
$json = json_decode($string,true);

renderWikiPage($json['the-wrangler']);
?>
