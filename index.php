<?php
include 'lib/generic_content.php';
ob_start(); // Begin output buffering to allow output to be rendered after html head

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
</head>

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
  }
  #home-container {
  display: flex;
  flex-wrap: wrap;
  width: 100%;
  }
  .home-section {
  flex-basis: 25%;
  flex-grow: 1;
  }
  .home-section {
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
  margin-top: 10rem;
  text-align: center;
  }
  @media screen and (max-width: 1100px){
  body {
  font-size: 11px;
  }
  .home-section {
  flex-basis: 50%;
  }
  }
  @media screen and (max-width: 750px){
  body {
  font-size: 13px;
  }
  .home-section {
  flex-basis: 100%;
  }
  }
</style>

<body>
  <div id='header-bar'>
    <div id='mail'></div>
    <div id='home-page-message'></div>
    <div id='help'></div>
  </div>

  <div id='home-container'>
    
    <div class='home-section'>
      <img class='home-section-background' src='images/home/desk.png'/>
      <a title='browse the hogipedia' class='home-section-link' href='https://wiki.hogwild.uk' style='left: 36.6%; top: 15.8%; width: 36.2%; height: 25.4%;'>
	<img src='images/home/computer.gif'/>
      </a>
    </div>
    <div class='home-section'>
      <img class='home-section-background' src='images/home/window.png'/>
      <a title='look around thompson world' class='home-section-link' href='https://tw.hogwild.uk' style='left: 8.6%; top: 7.8%; width: 35.6%; height: 58.2%;'>
	<img src='images/home/outside.png'/>
      </a>
      <a title='assemble the hog mosaic' class='home-section-link' href='https://mosaic.hogwild.uk' style='left: 0; bottom: 0.5%; width: 64%; height: 17%;'>
	<img src='images/home/jigsaw.png'/>
      </a>
    </div>
    
    <div class='home-section'>
      <img class='home-section-background' src='images/home/games.png' style='z-index: 1; position: relative;'/>
      <a title='tristan de cunhas islanders' href='https://www.tristandc.com/population.php' class='home-section-link' style='left: 53%; top: 18%; width: 15%; height: 14%; overflow: hidden; font-family: Chozo;'><?php echo $tristan_inhabitants_text;?></a>
      <a title='lisbon metro status' href='https://www.metrolisboa.pt/en/' class='home-section-link' style='left: 17%; top: 16%; width: 15%; height: 14%; transform: rotate(-7deg); overflow: hidden; font-family: Chozo'>
        <span style='color: yellow'><?php echo $amarela;?></span>
	<span style='color: blue'><?php echo $azul;?></span>
	<span style='color: green'><?php echo $verde;?></span>
	<span style='color: red'><?php echo $vermelha;?></span>
      </a>
      <a title='hook-a-duck in the bath' class='home-section-link' href='https://fishing.hogwild.uk' style='left: 24%; top: 48.8%; width: 70.8%; height: 37.2%;'>
	<img src='images/home/bath.png'/>
      </a>
      <a title='nothing ever happens - friendly betting' class='home-section-link' href='https://hogwild.uk/nothingeverhappens' style='left: 10.2%; top: 73%; width: 32.4%; height: 26.2%;'>
	<img src='images/home/dice.png'/>
      </a>
      <a title='newno - alternative uno rules' class='home-section-link' href='https://newno.hogwild.uk' style='left: 46.4%; top: 82%; width: 47%; height: 17.4%'>
	<img src='images/home/uno.png'/>
      </a>
    </div>
    <div class='home-section'>
      <img class='home-section-background' src='images/home/music.png'/>
      <a title='no to algorithms! music recs' class='home-section-link' href='https://notoalgorithms.hogwild.uk' style='left: 6%; top: 64.4%; width: 32%; height: 25.8%'>
	<img src='images/home/cds.png'/>
      </a>
      <a title='deliberate listening essay' class='home-section-link' href='https://roryjamesallen1.substack.com/p/deliberate-listening' style='left: 42.8%; top: 11%; width: 18.4%; height: 16%'>
	<img src='images/home/substack.png'/>
      </a>
    </div>

  </div>
  <div id='footer'>
    <p style='width: 90%'><a href='hogwild.uk'>hogwild.uk</a> is a <a href='https://maggieappleton.com/garden-history'>digital garden</a> of sorts. if you'd like to have something you made published here, or have any comments on what's here already, email <a href='mailto:rory@hogwild.uk'>rory@hogwild.uk</a></p>
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
  
  window.onload = function() {
  callAPIs();
  };
</script>
</html>
