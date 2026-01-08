<?php
include 'lib/generic_content.php';
ob_start(); // Begin output buffering to allow output to be rendered after html head

openSqlConnection('wildhog_analytics', 'sql_login_wildhog_analytics.php');
recordUserVisit();

$tristan_webpage = file_get_contents('https://www.tristandc.com/population.php');
foreach (explode('strong>',$tristan_webpage) as $strong_element){
if (str_contains($strong_element, 'There are') and str_contains($strong_element, 'Tristan da Cunha Islanders')){
$tristan_inhabitants_text = htmlspecialchars(str_replace('</','',$strong_element));
}
}

$lisboa = json_decode(file_get_contents('http://app.metrolisboa.pt/status/getLinhas.php'),true)['resposta']; 
$amarela = $lisboa['amarela'];
$azul = $lisboa['azul'];
$verde = $lisboa['verde'];
$vermelha = $lisboa['vermelha'];
?>

<!DOCTYPE html>
<html lang='en'>
    <head>
	<link rel='canonical' href='https://hogwild.uk' />
	<meta charset="utf-8">
	<meta name="description" content="Welcome to the Hog Universe. Explore the Hogipedia, walk around Thompson World, or just go hog wild in whatever way feels natural...">
	<meta property="og:title" content="Join The Wild Hogs">
	<meta property="og:description" content="Welcome to the Hog Universe. Explore the Hogipedia, walk around Thompson World, or just go hog wild in whatever way feels natural...">
	<meta property="og:image" content="https://hogwild.uk/favicon/apple-touch-icon.png">
	<meta property="og:url" content="https://hogwild.uk">
	<meta name="viewport" content="width=device-width, initial-scale=1" />
	<link rel="icon" type="image/png" href="favicon/favicon-96x96.png" sizes="96x96" />
	<link rel="icon" type="image/svg+xml" href="favicon/favicon.svg" />
	<link rel="shortcut icon" href="favicon/favicon.ico" />
	<link rel="apple-touch-icon" sizes="180x180" href="favicon/apple-touch-icon.png" />
	<meta name="apple-mobile-web-app-title" content="hogwild.uk" />
	<link rel="manifest" href="favicon/site.webmanifest" />
	<title>Home of The Wild Hogs</title>
	
	<!-- Google tag (gtag.js) -->
	<script async src="https://www.googletagmanager.com/gtag/js?id=G-6BQYQMEP06"></script>
	<script>
	 window.dataLayer = window.dataLayer || [];
	 function gtag(){dataLayer.push(arguments);}
	 gtag('js', new Date());
	</script>
	
	<style>
	 :root {
	     --wiki-grey: rgb(162, 169, 177);
	     --link: #069;
	 }
	 @font-face {
	     font-family: Chozo;
	     src: url(fonts/OtalaHandwritten-Regular.ttf);
	 }
	 body {
	     font-family: Arial;
	     margin: 0;
	     background: white;
	     font-size: 8px;
	 }
	 a, a:visited {
	     color: var(--link);
	     text-decoration: none;
	 }
	 a:hover {
	     text-decoration: underline;
	 }
	 h1 {
	     font-family: Chozo;
	     color: black;
	     margin: 0.5rem 0;
	     font-size: 2.5rem;
	     text-decoration: underline;
	 }
	 h2 {
	     font-size: 2rem;
	     text-align: center;
	     text-decoration: none;
	     margin: 0;
	 }
	 #header-bar {
	     display: flex;
	     width: calc(100% - 1rem);
	     padding: 0 0.5rem;
	     height: 2rem;
	     background-color: #f4f4f4;
	     position: sticky;
	     z-index: 99;
	     top: 0;
	     justify-content: space-between;
	     align-items: center;
	     font-size: 1rem;
	 }   
	 #home-page-message {
	     font-size: 1rem;
	     font-weight: unset;
	 }
	 #home-container {
	     display: flex;
	     gap: 1rem;
	     padding: 1rem;
	 }
	 #drawings-container {
	     display: flex;
	     flex-wrap: wrap;
	     width: 100%;
	     height: fit-content;
	 }
	 .home-section {
	     flex-basis: 25%;
	     flex-grow: 1;
	     position: relative;
	 }
	 .home-section-background {
	     width: 100%;
	     pointer-events: none;
	 }
	 .home-section-link {
	     position: absolute;
	 }
	 .home-section-link img {
	     width: 100%;
	 }
	 .home-section-link:hover {
	     filter: drop-shadow(0 0 10px grey);
	 }
	 #footer {
	     display: flex;
	     justify-content: center;
	     width: 100%;
	     font-size: 1rem;
	     margin: 10rem auto 5rem auto;
	     text-align: center;
	 }
	 .button-cluster {
	     display: flex;
	     flex-wrap: wrap;
	     margin: 0 auto;
	     gap: 1rem;
	     justify-content: center;
	     max-width: 250px;
	     height: fit-content;
	     position: relative;
	 }
	 .button-cluster > a {
	     display: flex;
	     justify-content: center;
	     align-items: center;
	     gap: 1rem;
	     font-size: 1rem;
	     text-decoration: none
	 }
	 .button-cluster > a:hover {
	 }
	 .button-cluster > a:hover:after {
	     content: '<';
	 }
	 .button-cluster > a:hover:before {
	     content: '>';
	 }
	 .vertical-divider {
	     width: 2px;
	     background: var(--wiki-grey);
	 }
	 @media screen and (max-width: 1500px){
	     body {
		 font-size: 11px;
	     }
             .home-section {
		 flex-basis: 50%;
	     }
	 }
	 @media screen and (max-width: 950px){
	     body {
		 font-size: 13px;
	     }
             .home-section {
		 flex-basis: 100%;
	     }
	 }
	 @media screen and (max-width: 750px){
	     #header-bar {
		 display: none;
	     }
	     #home-container {
		 flex-wrap: wrap;
	     }
	 }
	</style>
    </head>

    <body>
	<div id='header-bar'>
	    <div id='mail'></div>
	    <h2 id='home-page-message'><span>welcome to <a class='button-as-link' href='https://hogwild.uk'>hogwild.uk</a></span></h2>
	    <div id='help'></div>
	</div>

	<div id='home-container'>
	    <div class="button-cluster">
		<a href="https://hogwild.uk"><h1>hogwild.uk</h1></a>
		<a href="https://wiki.hogwild.uk"><img src="images/buttons/hogipedia.jpg"></a>
		<a href="https://mosaic.hogwild.uk"><img src="images/buttons/mosaic.jpg"></a>
		<a href="https://fishing.hogwild.uk"><img src="images/buttons/fishing.jpg"></a>
		<a href="https://hogwild.uk/mealdeal"><img src="images/buttons/mealdeal.jpg"></a>
		<a href="https://newno.hogwild.uk"><img src="images/buttons/newno.jpg"></a>
		<a href="https://hogwild.uk/nothingeverhappens"><img src="images/buttons/nothingeverhappens.jpg"></a>
		<a href="https://notoalgorithms.hogwild.uk"><img src="images/buttons/algorithms.jpg"></a>
		<a href="https://hogwild.uk/strobe"><img src="images/buttons/strobe.jpg"></a>
		<a href="https://valve.hogwild.uk"><img src="images/buttons/valve.jpg"></a>
		<a href="https://tw.hogwild.uk"><img src="images/buttons/thompson.jpg"></a>
	    </div>

	    <div class='vertical-divider'></div>
	    
	    <div id='drawings-container'>
		<div class='home-section'>
		    <h2 style='display: none'>The Office</h2>
		    <img class='home-section-background' src='images/home/desk.png' alt='Hand drawn desk with computer'/>
		    <a title='browse the hogipedia' class='home-section-link' href='https://hogwild.uk/wiki' style='left: 36.6%; top: 15.8%; width: 36.2%; height: 25.4%;'>
			<h3 style='display: none;'>Hogipedia</h3>
			<img src='images/home/computer.gif' alt='Hand drawn 90s computer with an animated rotating hog on the screen'/>
		    </a>
		</div>
		<div class='home-section'>
		    <h2 style='display: none'>The Windows</h2>
		    <img class='home-section-background' src='images/home/window.png' alt='Hand drawn windows with houses visible outside and a jigsaw in the foreground'/>
		    <a title='look around thompson world' class='home-section-link' href='https://hogwild.uk/thompson-world' style='left: 8.6%; top: 7.8%; width: 35.6%; height: 58.2%;'>
			<h3 style='display: none;'>Thompson World</h3>
			<img src='images/home/outside.png' alt='Hand drawn houses visible through a sash window'/>
		    </a>
		    <a title='assemble the hog mosaic' class='home-section-link' href='https://hogwild.uk/hogdivmosaic' style='left: 0; bottom: 0.5%; width: 64%; height: 17%;'>
			<h3 style='display: none;'>Hog Mosaic</h3>
			<img src='images/home/jigsaw.png' alt='Hand drawn jigsaw pieces'/>
		    </a>
		</div>

		<div class='home-section'>
		    <h2 style='display: none'>The Playroom</h2>
		    <img class='home-section-background' src='images/home/games.png' style='z-index: 1; position: relative;' alt='Hand drawn set of games including dice and UNO cards in front of a large bath'/>
		    <a title='tristan de cunhas islanders' href='https://www.tristandc.com/population.php' class='home-section-link' style='left: 53%; top: 18%; width: 15%; height: 14%; overflow: hidden; font-family: Chozo; transform: rotate(-5deg)'><?php echo $tristan_inhabitants_text;?></a>
		    <a title='lisbon metro status' href='https://www.metrolisboa.pt/en/' class='home-section-link' style='left: 17%; top: 16%; width: 15%; height: 14%; transform: rotate(-7deg); overflow: hidden; font-family: Chozo'>
			<span style='color: yellow'><?php echo $amarela;?></span>
			<span style='color: blue'><?php echo $azul;?></span>
			<span style='color: green'><?php echo $verde;?></span>
			<span style='color: red'><?php echo $vermelha;?></span>
		    </a>
		    <a title='hook-a-duck in the bath' class='home-section-link' href='https://hogwild.uk/hog-fishing' style='left: 24%; top: 48.8%; width: 70.8%; height: 37.2%;'>
			<h3 style='display: none;'>Hog Fishing</h3>
			<img src='images/home/bath.png' alt='Hand drawn bath full of water with two rubber ducks inside'/>
		    </a>
		    <a title='nothing ever happens - friendly betting' class='home-section-link' href='https://hogwild.uk/nothingeverhappens' style='left: 10.2%; top: 73%; width: 32.4%; height: 26.2%;'>
			<h3 style='display: none;'>Nothing Ever Happens</h3>
			<img src='images/home/dice.png' alt='Hand drawn dice and cup'/>
		    </a>
		    <a title='newno - alternative uno rules' class='home-section-link' href='https://hogwild.uk/newno' style='left: 46.4%; top: 82%; width: 47%; height: 17.4%'>
			<h3 style='display: none;'>Newno</h3>
			<img src='images/home/uno.png' alt='Hand drawn UNO cards'/>
		    </a>
		</div>
		
		<div class='home-section'>
		    <h2 style='display: none'>The Listening Room</h2>
		    <img class='home-section-background' src='images/home/music.png' alt='Hand drawn speakers, CDs, records, and CD player with headphones'/>
		    <a title='no to algorithms! music recs' class='home-section-link' href='https://hogwild.uk/notoalgorithms' style='left: 6%; top: 64.4%; width: 32%; height: 25.8%'>
			<h3 style='display: none;'>No To Algorithms</h3>
			<img src='images/home/cds.png' alt='Hand drawn CDs with low resolution covers'/>
		    </a>
		    <a title='deliberate listening essay' class='home-section-link' href='https://roryjamesallen1.substack.com/p/deliberate-listening' style='left: 42.8%; top: 11%; width: 18.4%; height: 16%'>
			<h3 style='display: none;'>Deliberate Listening</h3>
			<img src='images/home/substack.png' alt='Hand drawn sign showing the Spotify logo crossed out'/>
		    </a>
		</div>

		<p style='flex-basis: 100%; text-align: center; font-size: 1rem;'><a href='hogwild.uk'>hogwild.uk</a> is a <a href='https://maggieappleton.com/garden-history'>digital garden</a> of sorts. if you'd like to have something you made published here, or have any comments on what's here already, please email <a href='https://hogwild.uk/rory'>rory</a></p>

		<div style="margin: 0 auto; width: fit-content; font-size: 1rem; text-align: center; background: red; color: white;">
		    <h2 id="im-chinese" style="font-size: inherit">你是中国人吗?</h2>
		    <form id="china-form" style="display: none" action="submit_note.php" method="post" target="_blank">
			<p>我注意到有大量來自中國的流量，對此現象深感好奇。若中國地區的訪客能分享任何關於本站內容的看法，我將不勝感激！</p>
			<p>請原諒我的文法，我完全不會說任何形式的中文，但我對貴國充滿著驚嘆與敬佩。</p>
			<input type="textarea" maxlength="512" name="note" style="width: 50%; min-height: 5rem"><br><br>
			<input type="hidden" name="ip" value="<?php echo $ip_address ?>">
			<input type="submit" value="提交">
		    </form>
		</div>

	    </div>
	</div>
	
	<div id='footer'>
	    
	</div>
    </body>

    <script>
     function updatePageMessage(text){
	 document.getElementById('home-page-message').innerHTML = text;
     }
     function resetPageMessage(){
	 updatePageMessage("<span>welcome to <a class='button-as-link' href='https://hogwild.uk'>hogwild.uk</a></span>")
     }
     resetPageMessage();
     document.querySelectorAll(".home-section-link").forEach(element => {
	 element.addEventListener("mouseover", () => { updatePageMessage(element.title) });
	 element.addEventListener("mouseout", () => { resetPageMessage() });
     });

     function callAPIs(){
     }

     function showChinaForm(){
	 const form = document.getElementById('china-form')
	 form.style.display = 'block';
	 form.style.padding = '0.5rem';
     }

     document.getElementById('im-chinese').addEventListener('click', showChinaForm);
     
     window.onload = function() {
	 callAPIs();
     };
    </script>
</html>
