<!DOCTYPE html>
<html lang="en">
    <head>
	<meta charset="utf-8">
	<meta name="description" content="A list of websites created by Rory Allen.">
	<meta property="og:title" content="Rory Allen's Websites">
	<meta property="og:description" content="A list of websites created by Rory Allen.">
	<meta property="og:url" content="https://portfolio.hogwild.uk">
	<meta name="viewport" content="width=device-width, initial-scale=1"/>
	<meta property="og:image" content="../rory/favicon.png">
	<link rel="icon" type="image/png" href="../rory/favicon.png" sizes="512x512" />
	<link rel="shortcut icon" href="../rory/favicon.png" />
	<link rel="apple-touch-icon" sizes="512x512" href="../rory/favicon.png" />
	<meta name="apple-mobile-web-app-title" content="Rory Allen's Websites" />
	<base href="hogwild.uk/portfolio">
	
	<title>Rory Allen's Websites</title>
	<style>
	 @font-face {
	     font-family: Melodica;
	     src: url('../fonts/Melodica.otf');
	 }
	 html {
	     font-size: 20px;
	 }
	 body {
	     font-family: Melodica;
	     width: min(800px, 90vw);
	     margin: 0 auto;
	 }
	 h1 {
	     text-align: center;
	     margin-top: 2rem;
	 }
	 p, h2 {
	     margin: 0 0 0.5rem;
	 }
	 a {
	     color: #069;
	 }
	 #main-grid {
	     display: flex;
	     flex-wrap: wrap;
	     gap: 1rem;
	     margin-bottom: 5rem;
	 }
	 .grid-item {
	     flex-basis: 20%;
	     flex-grow: 1;
	     border: 2px solid #eee;
	     display: flex;
	     align-content: start;
	     flex-wrap: wrap;
	     gap: 0.5rem;
	     transition: background 0.2s;
	 }
	 .grid-item:hover {
	     background: #eee;
	 }
	 @media only screen and (max-width: 900px){
	     .grid-item {
		 flex-basis: 45%;
	     }
	 }
	 @media only screen and (max-width: 750px){
	     .grid-item {
		 flex-basis: 100%;
	     }
	 }
	 .grid-item > * {
	     flex-basis: 100%;
	 }
	 .grid-item > h3 {
	     margin: 0 0.5rem;
	 }
	 .grid-item > p {
	     margin: 0 0.5rem 0.5rem;
	 }
	 .grid-image {
	     overflow: hidden;
	 }
	 iframe {
	     border: none;
	     transform: scale(var(--scale-factor));
	     width: calc(1/var(--scale-factor) * 100%);
	     height: calc(1/var(--scale-factor) * 100%);
	     transform-origin: 0 0;
	 }
	</style>
    </head>

    <!-- Google tag (gtag.js) -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-6BQYQMEP06"></script>
    <script>
     window.dataLayer = window.dataLayer || [];
     function gtag(){dataLayer.push(arguments);}
     gtag('js', new Date());

     gtag('config', 'G-6BQYQMEP06');
    </script>
  
    <body>
	<h1>Rory Allen's Websites</h1>
	<h2>Me</h2>
	<p>I'm <a href="https://rory.hogwild.uk">Rory</a>, live in London, UK. I make websites for fun and for for free using <a href="https://www.gnu.org/software/emacs/">Emacs</a> on a DELL laptop that my friend gave me which is now running <a href="https://www.debian.org/">Debian</a>. Old school baby - NO AI EVER</p>
	<p>If you have an idea for a site that you want help with or want me to make or think I could incorporate into a site I've already made, please <strong>please</strong> <i>please</i> tell me, I love making websites!!!.
	</p>
	<h2>The Sites</h2>
	<p>Every live site I have worked on (all but one are solely my work). Listed in alphabetical order.</p>
	<div id="main-grid">
	    
	    <div class="grid-item">
		<div class="grid-image" style="--scale-factor: 0.5"><iframe src="https://hogwild.uk"></iframe></div>
		<h3><a href="https://hogwild.uk">Hogwild.uk</a></h3>
		<p>Scrollable map based homepage for the imaginary universe of The Wild Hogs</p>
	    </div>
	    <div class="grid-item">
		<div class="grid-image" style="--scale-factor: 0.25"><iframe src="https://wiki.hogwild.uk"></iframe></div>
		<h3><a href="https://wiki.hogwild.uk">Hogipedia</a></h3>
		<p>Wikipedia style lore library for The Wild Hog universe</p>
	    </div>
	    <div class="grid-item">
		<div class="grid-image" style="--scale-factor: 0.15"><iframe src="https://hogwild.uk/hog-fishing"></iframe></div>
		<h3><a href="https://hogwild.uk/hog-fishing">Hook-A-Duck</a></h3>
		<p>Fishing for ducks in the Thompson World bath</p>
	    </div>
	    <div class="grid-item">
		<div class="grid-image" style="--scale-factor: 0.2"><iframe src="https://hogwild.uk/mealdeal"></iframe></div>
		<h3><a href="https://hogwild.uk/mealdeal">Meal Deal Maker</a></h3>
		<p>Name your favourite Tesco meal deals</p>
	    </div>
	    <div class="grid-item">
		<div class="grid-image" style="--scale-factor: 0.25"><iframe src="https://hogwild.uk/newno"></iframe></div>
		<h3><a href="https://hogwild.uk/newno">Newno</a></h3>
		<p>A rulebook for my friends' house UNO rules</p>
	    </div>
	    <div class="grid-item">
		<div class="grid-image" style="--scale-factor: 0.1"><iframe src="https://hogwild.uk/nothingeverhappens"></iframe></div>
		<h3><a href="https://hogwild.uk/nothingeverhappens">Nothing Ever Happens</a></h3>
		<p>Moneyless betting between friends</p>
	    </div>
	    <div class="grid-item">
		<div class="grid-image" style="--scale-factor: 0.1"><iframe src="https://notoalgorithms.hogwild.uk"></iframe></div>
		<h3><a href="https://notoalgorithms.hogwild.uk">No To Algorithms!</a></h3>
		<p>Humans only music recommendations</p>
	    </div>
	    <div class="grid-item">
		<div class="grid-image" style="--scale-factor: 0.15"><iframe src="https://otalaband.com"></iframe></div>
		<h3><a href="https://otalaband.com">Otala</a></h3>
		<p>My band's website including automatic gig counting</p>
	    </div>
	    <div class="grid-item">
		<div class="grid-image" style="--scale-factor: 0.25"><iframe src="https://otalaband.com/otaladle"></iframe></div>
		<h3><a href="https://otalaband.com/otaladle">Otaladle</a></h3>
		<p>Stupid Wordle clone, you can guess what the word is</p>
	    </div>
	    <div class="grid-item">
		<div class="grid-image" style="--scale-factor: 0.2"><iframe src="https://hogwild.uk/strobe"></iframe></div>
		<h3><a href="https://hogwild.uk/strobe">Strobe</a></h3>
		<p>Make your screen strobe with set speed and colours</p>
	    </div>
	    <div class="grid-item">
		<div class="grid-image" style="--scale-factor: 0.25"><iframe src="https://valve.hogwild.uk"></iframe></div>
		<h3><a href="https://valve.hogwild.uk">The Valve That Failed</a></h3>
		<p>Experimental collaborative site with Jack McInnes</p>
	    </div>
	    <div class="grid-item">
		<div class="grid-image" style="--scale-factor: 0.5"><iframe src="https://hogwild.uk/thompson-world/?garden.x=27&garden.y=155"></iframe></div>
		<h3><a href="https://hogwild.uk/thompson-world">Thompson World</a></h3>
		<p>A hand drawn interactive recreation of our old shared house in Sheffield</p>
	    </div>
	</div>
    </body>
</html>
