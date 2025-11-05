<?php
ob_start(); // Begin output buffering to allow output to be rendered after html head
include '../lib/generic_content.php';
openSqlConnection('wildhog_notoalgorithms', '../sql_login_wildhog_notoalgorithms.php');

if (!isset($_GET['submit_confident'])) {
	echo "<h1 class='page-title'><a href=".$_SERVER['PHP_SELF'].">no to algorithms!</a></h1>";
	echo "<div id='info-button' class='info-button'>?</div>";
	echo "<div id='user-count' class='info-button submitter-count'>".strval(count(getArtistsFromDatabase())/2)." submissions and counting</div>";
	if (isset($_GET['artist'])) {
		$issue_artist = urlencode($_GET['artist']);
	} else {
		$issue_artist = False;
	}
	echo "<a href='".$_SERVER['PHP_SELF']."?new_issue=".$issue_artist."' id='user-count' class='info-button report-issue'>!</a>";
}

$banned_ips = ['39.57.47.97', '77.136.66.255', '77.136.66.178', '8.28.99.154'];
if (in_array($ip_address, $banned_ips)) {
	echo "You have been banned from using this site. Please email contact@allensynthesis.co.uk if you think this is unfair";
	die();
}

function renderSearchbar() {
	echo "<form class='searchbar'>";
	echo "<div class='searchbox-container'>";
	echo "<input name='artist'/>";
	echo "<input id='search-button' type='submit' name='search' value='search'/>";
	echo "</div>";
	echo "<a class='searchbar-button' href='".$_SERVER['PHP_SELF']."?new_submission=True";
	if (isset($_GET['artist'])) {
		echo "&artist=".$_GET['artist'];
	}
	echo "'>new submission</a>";
	echo "</form>";
}

function getArtistsFromDatabase() {
	$artists = [];
	foreach (sqlQuery("SELECT * FROM artists") as $row){ // For row in the database
		foreach (['artist','related'] as $artist) { // For the two columns in the database row
			array_push($artists, urldecode($row[$artist]));
		}
	}
	return $artists;
}

function getSubmissionsByUser($ip) {
    $submissions = [];
    foreach (sqlQuery("SELECT * FROM artists WHERE ip='".$ip."'") as $row){ // For row in the database
		array_push($submissions, [$row['artist'],$row['related']]);
		array_push($submissions, [$row['related'],$row['artist']]); // Both ways round to allow for easy searching
    }
    return $submissions;
}

function renderArtistList($relations) { // Relations in format [artist: number of relations]
	arsort($relations); // Most related to artist at the top, descending to least related to artist (fewest submissions for that artist combination)
	echo "<div class='artist-list'>";
	$font_maximum = 100; // Maximum font size in px
    $font_minimum = 10;
    $font_difference = $font_maximum - $font_minimum;
	$most_related = max($relations);
	$font_multiplier = $font_difference / $most_related;
	//$font_multiplier = floor($font_maximum / $most_related);
	foreach ($relations as $related_artist => $submissions) {
		$font_size = (($font_multiplier*$submissions) + $font_minimum).'px';
		$href = $_SERVER['PHP_SELF'].'?artist='.urlencode($related_artist); // Link each artist name to a search for itself
		if ($related_artist != array_key_last($relations)) {
			$comma = ", "; // Add a comma after the artist as long as it's not the last one in the list
		} else {
			$comma = "";
		}
		echo "<h3><a
			class='artist-name'
			href=".$href."
			style='font-size: ".$font_size."'>".urldecode($related_artist).$comma."
		</a></h3><br>";
	}
    echo "<div class='nta-footer'>A <a class='button-as-link' href='https://hogwild.uk'>hogwild.uk</a> creation</div>";
	echo "</div>";
}

function renderHomeArtists() {
	$all_artists = getArtistsFromDatabase();
	$artist_relations = [];
	foreach ($all_artists as $artist) {
		if (array_key_exists($artist, $artist_relations)) {
			$artist_relations[$artist]++;
		} else {
			$artist_relations[$artist] = 1;
		}
	}
	renderArtistList($artist_relations);
}

function getUniqueUsers() {
	$unique_users = 0;
	foreach (sqlQuery("SELECT DISTINCT ip FROM artists") as $row){ // For row in the database
		$unique_users++;
	}
	return $unique_users;
}

function renderSuggestedSpellings($entered_artists = ['first_artist','second_artist']) {
	$already_asked = [];
	$questions_asked = 0;
	foreach ($entered_artists as $entered_artist) { // For the two submitted artists
		foreach (sqlQuery("SELECT * FROM artists") as $row){ // For row in the database
			foreach (['artist','related'] as $possible_real_artist) { // For the two columns in the database row
				if (levenshtein(urldecode($row[$possible_real_artist]), urldecode($_GET[$entered_artist])) < 4 && !in_array($row[$possible_real_artist], $already_asked) && urldecode($row[$possible_real_artist]) != urldecode($_GET[$entered_artist])) { // If similar and not already asked about this artist and the artist hasn't been spelled correctly anyway
					if ($questions_asked == 0) {
						echo "<div class='heading'>did you mean any of these artists?<br>"; // Only before the first question
					}
					echo "<a href='".$_SERVER['PHP_SELF']."?artist=".$row[$possible_real_artist]."'>".urldecode($row[$possible_real_artist])."</a><br>";
					array_push($already_asked, $row[$possible_real_artist]); // Prevent the question being asked twice about the same artist
					$questions_asked++; // Used for calculating 'and' if multiple questions are to be asked
				}
			}
		}
	}
	if ($questions_asked != 0) { // If any were asked then close the div
		echo "</div>";
	}
	return $questions_asked;
}

function writeToDatabase($ip_address='') {
	$sql = "INSERT INTO artists (artist, related, ip, time) VALUES ('".urlencode(trim($_GET['first_artist']))."', '".urlencode(trim($_GET['second_artist']))."', '".urlencode($ip_address)."', '".time()."')"; // Save the submitter's IP just in case
	sqlQuery($sql); // Write the artists to the database
    return true;
}

function writeIssue() {
	$sql = "
		INSERT INTO issues (artist, type, info, ip)
		VALUES ('".urlencode($_GET['issue_artist'])."', '".urlencode($_GET['issue_type'])."', '".urlencode($_GET['issue_info'])."', '".$_GET['issue_ip']."')"; // Save the submitter's IP just in case
	sqlQuery($sql); // Write the issue to the database
	//$to = "rory.james.allen1@gmail.com";
	//$subject = "nta issue with ".$_GET['issue_artist'];
	//$message = $_GET['issue_ip']." thinks ".$_GET['issue_type']." with ".$_GET['issue_artist']."<br><br>extra info: ".$_GET['issue_info'];
	//$headers = "From: webmaster@allensynthesis.co.uk" . "\r\n";
	//mail($to, $subject, $message, $headers); // add later
}

function renderSubmission($confident = False) { // Render the boxes to submit a new related artist
	echo "<form class='searchbar'>";
	echo "<p class='searchbar-text'>If you like </p>";
	if ($confident) {
		echo "<input name='first_artist' value='".$_GET['first_artist']."'/>";
	} elseif (isset($_GET['artist'])) {
		echo "<input name='first_artist' value='".$_GET['artist']."'/>";
	} else {
		echo "<input name='first_artist'/>";
	}
	echo "<p class='searchbar-text'> I think you might like </p>";
	echo "<div class='searchbox-container'>";
	if ($confident) {
		echo "<input name='second_artist' value='".$_GET['second_artist']."'/>";
	} else {
		echo "<input name='second_artist'/>";
	}
	if ($confident) {
		echo "<input id='submit-button' type='submit' name='submit_confident' value='i&rsquo;m sure'/>";
	} else {
		echo "<input id='submit-button' type='submit' name='submit' value='submit'/>";
	}
	echo "</div>";
	echo "</form>";
}

function getRelatedArtists($artist) {
	$artist = urlencode(substr($artist, 1, (strlen($artist) - 2)));
	$relations = [];
	$mode_parameters = []; // Allow different sql and column selection for the same code
	$mode_parameters['artist']['sql'] = "SELECT related FROM artists WHERE artist='".$artist."'";
	$mode_parameters['artist']['opposite'] = 'related';
	$mode_parameters['related']['sql'] = "SELECT artist FROM artists WHERE related='".$artist."'";
	$mode_parameters['related']['opposite'] = 'artist';
	
	foreach (['artist','related'] as $mode) { // Find related for artist and artist for related (use different sql etc as above)
		$sql = $mode_parameters[$mode]['sql']; // Get the sql query
		$result = sqlQuery($sql); // Query the database
		  foreach ($result as $row){ // For row in the database
			$related = $row[$mode_parameters[$mode]['opposite']]; // Related artist for this row
			if (array_key_exists($related, $relations)) {
				$relations[$related] = $relations[$related] + 1; // One *more* instance of the related artist
				//$relations[$related]++; 
			} else {
				$relations[$related] = 1; // One instance of the related artist
			}		
		  }
	}
	return $relations;
}

if (isset($_GET['new_submission'])) {
	renderSubmission();
	echo "<div class='heading warning'>artist names only, capitalised correctly please!</div>";
	//render write boxes
} elseif (isset($_GET['submit']) && isset($_GET['issue_ip'])) { // ip always sent with issue
	writeIssue();
    $buffer = ob_get_clean();
	header('Location: '.$_SERVER['PHP_SELF'].'?message=issue submitted, thanks :)');
} elseif (isset($_GET['submit']) && isset($_GET['first_artist'])) { // Receiving a submission, write to database (after spelling checks)
	if ($_GET['first_artist'] == "" or $_GET['second_artist'] == "") {
		renderSubmission();
		echo "<div class='heading warning'>neither artist can be blank!</div>";
	} elseif ($_GET['first_artist'] == $_GET['second_artist']) {
		renderSubmission();
		echo "<div class='heading warning'>the artist can't be related to themselves!</div>";
    } elseif (in_array([$_GET['first_artist'],$_GET['second_artist']], getSubmissionsByUser($ip_address))) { // If user has previously submitted this combo
        renderSubmission();
		echo "<div class='heading warning'>you've submitted that combo before!</div>";
	} else {
		renderSubmission(True); // Confident submission box (changes submit button function)
		$questions_asked = renderSuggestedSpellings();
		echo "<div class='heading'>";
		echo "&#x2022; please double check both artists before submitting<br>";
		echo "&#x2022; search for them first to check spellings<br>";
		echo "&#x2022; capitalise according to their streaming/socials!<br>";
		foreach (['first_artist', 'second_artist'] as $artist) {
			if (!in_array($_GET[$artist], getArtistsFromDatabase())) {
				echo "&#x2022 you'll be creating the artist: ".$_GET[$artist]."<br>";
			}
		}
		echo "</div>";
	}
} elseif (isset($_GET['new_issue'])) {
	$issue = $_GET['new_issue'];
	if ($issue != "") {
		echo "<form>";
		echo "<h2>is there a problem with the artist page for ".$issue."?</h2>";
		echo "<select name='issue_type'>";
		echo "<option value='there is a spelling mistake'>there is a spelling mistake</option>";
		echo "<option value='something is inappropriate'>something is inappropriate</option>";
		echo "</select>";
		echo "<h2>extra info (optional):</h2>";
		echo "<input name='issue_info'/><br><br>";
		echo "<input name='issue_artist' value='".$issue."' type='hidden'/>";
		echo "<input name='issue_ip' value='".$ip_address."' type='hidden'/>";
		echo "<input name='submit' type='submit' value='submit issue'/>";
		echo "</form>";
	} else {
		echo "<form>";
		echo "<h2>submit a general issue<br>note: to submit an artist issue click the ! button on the artist page</h2>";
		echo "<select name='issue_type'>";
		echo "<option value='there is a visual bug'>there is visual bug</option>";
		echo "<option value='something unexpected happened'>something unexpected happened</option>";
		echo "<option value='i have a feature idea'>i have a feature idea</option>";
		echo "</select>";
		echo "<h2>extra info (optional):</h2>";
		echo "<input name='issue_info'/><br><br>";
		echo "<input name='issue_ip' value='".$ip_address."' type='hidden'/>";
		echo "<input name='submit' type='submit' value='submit issue'/>";
		echo "</form>";
	}
} elseif (isset($_GET['submit_confident'])) { // User specifically confirmed they think their spelling etc is correct so just write to database
	if (writeToDatabase($ip_address)) {
        $buffer = ob_get_clean();
        header('Location: '.$_SERVER['PHP_SELF'].'?message=recommendation submitted, thanks :)');
    }
} elseif(isset($_GET['artist'])) {
	renderSearchbar();
	
	$artist = '"'.urldecode($_GET['artist']).'"';
	
	if ($artist == '""') {
		echo "<div class='heading warning'>type in the artist before searching</div>";
	} else {	
		$relations = getRelatedArtists($artist);
		// $relations is in the format [related_artist: number_of_times_relation_submitted] 
		if (count($relations) == 0) {
			echo "<div class='heading warning'>nobody has submitted any related artists for ".urldecode($_GET['artist']). " yet :(</div>";
			renderSuggestedSpellings(['artist']);
		} else {
			if (count($relations) == 1) {
				$extra_text = "";
			} else {
				$extra_text = " a few of these ".strval(count($relations))." artists";
			}
			echo "<div class='heading'>if you like ".$artist.", people think you might like".$extra_text.":</div>"; // Only once before the first related artist
			renderArtistList($relations);
		}
	}
} else { // Home page
	renderSearchBar();
	if (isset($_GET['message'])) {
		echo "<div class='heading happy'>".$_GET['message']."</div>";
	}
	renderHomeArtists();
}
	
$buffer = ob_get_clean();
?>
    <!DOCTYPE html> 
<html lang="en">
	<head>
       
		<title>no to algorithms!</title>
    <meta charset="UTF-8"> 
		<meta name="description" content="no to algorithms! human only music recommendations">
     <meta name="viewport" content="width=device-width, initial-scale=1.0" />
		<link rel="canonical" href="https://notoalgorithms.hogwild.uk">
		<style>
    html {
        font-size: 16px;
     }
@media only screen and (max-width: 600px) {
  html {
      font-size: 10px;
  }
}
			body {
				font-family: Helvetica;
				margin: 2rem;
			}
			.page-title {
				text-align: center;
				font-size: 4rem;
    font-weight: unset;
				text-decoration: underline;
				margin: 6rem 0 3rem 0;
			}
h3 {
    font-size: unset;
    font-weight: unset;
    text-decoration: unset;
    margin: unset;
}
			a, a:visited {
				color: rgb(0,0,0);
				text-decoration: none;
			}
a:hover, #search-button:hover {
				color: rgb(100,100,100);
cursor: pointer;
			}
			.artist-name {
				word-wrap: anywhere;
			}
.nta-footer {
                text-align: center;
    flex-basis: 100%;
    margin: 2rem 0 4rem;
                font-size: 2rem;
            }
.button-as-link {
                background: none;
                border: none;
                padding: 0;
                font-size: unset;
                color: #069 !important;
                cursor: pointer;
                text-decoration: none;
            }
.button-as-link:hover {
    text-decoration: underline;
}
			.heading {
				font-size: 2rem;
				text-align: center;
				margin-bottom: 2rem;
			}
			.warning {
				text-decoration: underline;
				text-decoration-line: spelling-error;
			}
			.happy {
				text-decoration: underline;
				text-decoration-line: grammar-error;
			}
			.searchbar {
				display: flex;
				flex-wrap: wrap;
				gap: 1rem;
				justify-content: center;
				margin-bottom: 2rem;
			}
			.searchbox-container {
				display: flex;
			}
			input, .searchbar-button, select {
				font-size: 2rem;
				padding: 1rem;
				border: 0.25rem solid black;
			}
			.searchbar-button {
				background-color: rgb(233, 233, 237);
			}
			#search-button, #submit-button {
				margin-left: -0.25rem;
			}
			.searchbar-text {
				font-size: 2rem;
				margin: auto 0;
			}
			.artist-list, .heading, form {
				max-width: 1080px;
				margin: auto;
			}
			.artist-list {
				display: flex;
				flex-wrap: wrap;
				align-items: baseline;
				gap: 0.25rem;
				justify-content: space-between;
			}
			.info-button {
				position: absolute;
				top: 0;
				left: 0;
				width: 2rem;
				aspect-ratio: 1;
				text-align: center;
				line-height: 2rem;
				border: 0.25rem solid black;
				margin: 1rem;
				font-size: 1.5rem;
				font-weight: bold;
				background-color: white;
				cursor: pointer;
			}
			.report-issue {
				left: 3rem;
			}
			.submitter-count {
				left: unset;
				right: 0;
				width: unset;
				height: 2rem;
				aspect-ratio: unset;
				padding: 0 0.5rem;
			}
			.info-button-open {
				width: unset;
				aspect-ratio: unset;
				text-align: left;
				padding: 0 0.25rem;
				z-index: 1;
			}
		</style>
	</head>
            <body>
<?php echo $buffer; ?>           
            <script>
			var showing_info = false;
const info_button = document.getElementById('info-button');
if (info_button) {
    info_button.addEventListener('click', showInfo);
}
			
			function showInfo() {
				if (showing_info) {
					hideInfo();
					showing_info = false;
				} else {
					var button = document.getElementById('info-button');
					button.innerHTML = `
					&#x2022 this is a platform for finding out about musical artists where the recommendations come ONLY from other real life humans, no algorithms!<br><br>
					&#x2022 when you submit a combination of artists, each one will show up in the search results of the other<br>
					&#x2022 the more times a certain combination is submitted, the bigger each artist's name will be in the other artist's search results<br>
					&#x2022 don't be afraid to submit a combination that already exists, that's the whole point!<br>
					&#x2022 everyone is welcome to submit artist combinations - if you're a real human you can do no wrong but...<br>
                    &#x2022 PLEASE do not spam submissions always relating to the same artist, especially if it's self-promotion<br><br>
					&#x2022 if you have any questions, suggestions, or bug reports please email <a href="mailto:contact@allensynthesis.co.uk">contact@allensynthesis.co.uk</a><br>
					(click again to close)
					
					`;
					button.classList.add('info-button-open');
					showing_info = true;
				}
			}
			
			function hideInfo() {
				var button = document.getElementById('info-button');
				button.innerHTML = "?";
				button.classList.remove('info-button-open');
			}
		</script>
            </body>
</html>
