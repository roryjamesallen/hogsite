<!DOCTYPE html>
<html lang="en">
    <head>
	<base href="https://hogwild.uk/portfolio">
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
	     margin: 0 auto 5rem;
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
	     margin-bottom: 2rem;
	 }
	 .grid-item {
	     flex-basis: 20%;
	     flex-grow: 1;
	     display: flex;
	     border: 2px solid #eee;
	     align-content: start;
	     flex-wrap: wrap;
	     gap: 0.5rem;
	     transition: background 0.2s;
	 }
	 .grid-item:hover {
	     border: 2px solid red;
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
	<p>I'm <a href="https://rory.hogwild.uk">Rory</a>, live in London, UK. I make websites for fun and for for free using the programs/tools listed at the bottom of this page.</p>
	<p>If you have an idea for a site that you want help with or want me to make or think I could incorporate into a site I've already made, please <strong>please</strong> <i>please</i> tell me, I love making websites!!! I answer every single (non spam) email sent to <a href="mailto:rory@hogwild.uk">rory@hogwild.uk</a>.
	</p>
	<h2>The Sites</h2>
	<p>Every live site I have worked on (all but one are solely my work). Listed in alphabetical order.</p><br>
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
		<div class="grid-image" style="--scale-factor: 0.25"><iframe src="https://hogwild.uk/nothingeverhappens"></iframe></div>
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
	<h2 id="the-programs">The Tools</h2>
	<p>I love FOSS (Free Open Source Hardware) and use it where I can. I like it old school and with NO AI EVER.</p>
	<ol>
	    <li>A Dell Laptop (given to me by my friend Johnny) running Linux (<a href="https://www.debian.org/">Debian</a>).</li>
	    <li><a href="https://www.gnu.org/software/emacs/">Emacs</a> for editing all the files - I don't use an IDE or any kind of live testing editor, just refresh the files in <a href="https://en.wikipedia.org/wiki/Firefox">Firefox</a>.</li>
	    <li>A standard <a href="https://en.wikipedia.org/wiki/LAMP_(software_bundle)">LAMP</a> stack for testing the sites locally - all free and easy.</li>
	    <li><a href="https://www.affinity.studio/">Affinity</a> for editing images - sadly not FOSS but free and easy for me to use after using Adobe products for so long.</li>
	    <li><a href="https://git-scm.com/">Git</a> for managing versions and collaborations - irreplaceable and useful for working locally on a site and then making it live.</li>
	</ol>
    </body>
</html>
