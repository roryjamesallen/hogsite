<?php
include '../lib/generic_content.php';

function resolveLinks($json){
	preg_match("/\[([^\]]*)\]/", $json, $matches);
	foreach ($matches as $match){
		$json = str_replace('['.$match.']','<input type="submit" name="page" value="'.$match.'">', $json);
	}
	return $json;	
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
