<?php
include 'lib/generic_content.php';
ob_start(); // Begin output buffering to allow output to be rendered after html head
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <?php echo $standard_header_content;?>
    <link rel="canonical" href="https://hogwild.uk" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <title>Home of The Wild Hogs</title>
</head>

<style>
  body {
  font-family: Arial;
  }
  a, a:visited {
  color: black;
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
  min-width: 300px;
  max-width: 700px;
  }
  .home-section-background {
  width: 100%;
  }
  .home-section-container a:hover .home-section-image:not(.no-hover) {
  filter: drop-shadow(0 0 10px grey);;
  }
</style>

<body>
  <div id='header-bar'>
    <div id='mail'>🖂</div>
    <div id='home-page-message'></div>
    <div id='help'>⍰</div>
  </div>

  <div id='home-container'>
    <div class='home-section'>
      <img class='home-section-background' src='images/home/desk.png'/>
    </div>
    <div class='home-section'>
      <img class='home-section-background' src='images/home/window.png'/>
    </div>
    <div class='home-section'>
      <img class='home-section-background' src='images/home/games.png'/>
    </div>
    <div class='home-section'>
      <img class='home-section-background' src='images/home/music.png'/>
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
