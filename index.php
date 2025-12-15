<?php
include 'lib/generic_content.php';
ob_start(); // Begin output buffering to allow output to be rendered after html head
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <?php //echo $standard_header_content;?>
    <link rel="canonical" href="https://hogwild.uk" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <title>Home of The Wild Hogs</title>
</head>

<style>
  body {
  font-family: Arial;
  margin: 0;
  background: white;
  }
  a, a:visited {
  color: black;
  }
  #header-bar {
  display: flex;
  width: calc(100% - 1rem);
  padding: 0 0.5rem;
  height: 3rem;
  background-color: #f4f4f4;
  position: sticky;
  z-index: 99;
  top: 0;
  justify-content: space-between;
  align-items: center;
  font-size: 1.5rem;
  }   
  #home-page-message {
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
  @media screen and (max-width: 1100px){
  .home-section {
  flex-basis: 50%;
  }
  }
  @media screen and (max-width: 750px){
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
      <img class='home-section-background' src='images/home/games.png'/>
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
</script>
</html>
