<?php
include '../lib/generic_content.php';

$string = file_get_contents('wiki_content.json');
$json = json_decode($string,true);
if (isset($_GET['page'])){
    $page_handle = $_GET['page'];
} else {
    $page_handle = 'home';
}

function getTitleFromHandle($handle){
    global $json;
    foreach ($json as $page_handle => $page){
        if ($page_handle == $handle){
            return $page['title'];
        }
    }
}
function resolveLinks($section){
	preg_match("/\[([^\]]*)\]/", $section, $matches);
	foreach ($matches as $match){
		$section = str_replace('['.$match.']','<button class="button-as-link" type="submit" name="page" value="'.$match.'">'.getTitleFromHandle($match).'</button>', $section);
	}
	return $section;
}
function renderWikiPage($page){
    echo '<h1>'.$page['title'].'</h1>';
	echo '<form method="GET">';
    echo '<h2>'.$page['category'].'</h2>';
    foreach ($page['sections'] as $heading => $section){
        echo '<h3>'.$heading.'</h3>';
        echo resolveLinks($section).'<br>';
    }
	echo '</form>';
}
?>

<html>
    <head>
<?php echo $standard_header_content;?>
    </head>
    <body class="wiki-page">
<?php renderWikiPage($json[$page_handle]);;?>
    </body>
</html>
