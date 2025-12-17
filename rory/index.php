<!DOCTYPE html>
<html lang='en'>
    <head>
	<link rel='canonical' href='https://hogwild.uk' />
	<meta charset="utf-8">
	<meta name="description" content="About me, what I'm into and what I've been making">
	<meta property="og:title" content="Rory">
	<meta property="og:description" content="About me, what I'm into and what I've been making">
	<meta property="og:image" content="favicon.png">
	<meta property="og:url" content="https://hogwild.uk/rory">
	<meta name="viewport" content="width=device-width, initial-scale=1" />
	<link rel="icon" type="image/png" href="favicon.png" sizes="512x512" />
	<link rel="shortcut icon" href="favicon.png" />
	<link rel="apple-touch-icon" sizes="512x512" href="favicon.png" />
	<meta name="apple-mobile-web-app-title" content="Rory" />
	<title>Rory</title>

	<style>
	 :root {
	     --wiki-grey: rgb(162, 169, 177);
	     --link: #069;
	 }
	 @font-face {
	     font-family: Google Sans Code;
	     src: url(https://hogwild.uk/fonts/GoogleSansCode.ttf);
	 }
	 body {
	     width: min(800px, 90%);
	     margin: 0 auto;
	     font-family: Google Sans Code;
	 }
	 #page-header {
	     text-align: center;
	     padding: 1rem 0;
	     border-bottom: 1px solid var(--wiki-grey);
	 }
	 h1, h2, h3, h4, h5 {
	     display: flex;
	     align-items: center;
	     gap: 1rem;
	 }
	 h3 {
	     font-size: unset;
	 }
	 a, a:visited {
	     color: var(--link);
	     text-decoration: none;
	 }
	 ol {
	     //padding: 0;
	 }
	 ol > li {
	     border-top: 1px solid var(--wiki-grey);
	     margin-bottom: 1rem;
	 }
	 ol li img, ul li img {
	     margin: 1rem 0;
	 }
	 .garden {
	     width: fit-content;
	     color: var(--wiki-grey);
	     font-size: 0.75rem;
	     padding: 0.25rem;
	     border: 1px solid #eee;
	 }
	 a:hover {
	     text-decoration: underline;
	 }
	 .hide-numbers {
	     list-style-type: none;
	 }
	 .did-flex {
	     display: flex;
	     gap: 1rem;
	     align-items: center;
	 }
	 .did-image {
	     width: 50px;
	     height: 50px;
	 }
	 .collapsible > h2, .collapsible > h3, .collapsible > h4, .collapsible > h5 {
	     cursor: pointer;
	 }
	 .collapsed *:not(h2, h2 *, h3, h3 *, h4, h4 *, h5, h5 *) {
	     display: none;
	 }
	</style>
    </head>
    <!-- Google tag (gtag.js) -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-6BQYQMEP06"></script>
    <script>
     window.dataLayer = window.dataLayer || [];
     function gtag(){dataLayer.push(arguments);}
     gtag('js', new Date());
    </script>

    <body>
	<div id="page-header">this is my <a href="https://maggieappleton.com/garden-history">digital garden</a>, you can click on the headings to expand each section!</div>
	<div class="collapsible" id="me">
	    <h2>Me<div class="garden">🌱 16.12.25 🌿 17.12.25</div></h2>
	    <img src="favicon.png" width="200px"/>
	    <div class="collapsible" id="about">
		<h3>About</h3>
		<span>My name is Rory Allen, I am <span id="age">(loading)</span> old. You can email me at <a href="mailto:rory@hogwild.uk">rory@hogwild.uk</a> - I like to be emailed and aim to respond to every one that I get! </span>
	    </div>
	    <div class="collapsible">
		<h3>Currently Into</h3>
		<span>I have been using <a href="https://www.pi.fyi/">Perfectly Imperfect</a> when I feel like scrolling (eventually maybe I won't even have the urge) and it's great, I find myself far more often clicking into something and it inspiring me to do something worthwhile or research something rather than just encouraging people to stick on the feed</span>
	    </div>
	    <div class="collapsible">
		<div class="collapsible">
		<h3>Music</h3>
		<ul class="hide-numbers">
		    <li class="collapsible"><h4>Guitar</h4><span>Played since I was 11 or 12.
			My first guitar was a blue Squier Strat, since then I have had only the two I still own: A red & black Gibson Junior and an Ovation Applause</span>
		    </li>
		    <li class="collapsible"><h4>Bass</h4><span>I still don't think of myself as a bassist but I've played/play bass in <a href="https://otalaband.com">Otala</a> and <a href="https://www.instagram.com/foolbandofficial/">Fool</a>.
			I originally played a messy DIY machine made from an eBay neck and bridge and the body of my old Squier electric which I chiseled out.
			It had approximately 1.5cm of action and gave me blisters every time I played it.
			Pictured below at Fuel on the 27th Jan 2023, playing with Bloodworm, Horse Mouth, and Plaster.
			<br><img src="squier.jpg" width="200px"/><br>
			I sold it for parts when my lovely parents bought me my Yamaha 5 String as a graduation present.</span>
		    </li>
		    <li class="collapsible"><h4>Modular Synth</h4><span>I first started getting into synths with a Korg Monologue around when I started uni in 2019,
			but soon started messing with modular and developing stuff under <a href="https://allensynthesis.co.uk">Allen Synthesis</a>
			after seeing <a href="https://www.youtube.com/watch?v=8WDNgfnZ3HM&list=RD8WDNgfnZ3HM&start_radio=1">Ann Annie covering Debussy</a> on a modular.
			I currently work for ALM which feels amazing as I'd seen their stuff for as long as I'd been interested in modular.
			Still can't really play keys but I can "sound design" alright and make beats and remixes in a cracked copy of ableton</span>
		    </li>
		</ul>
	    </div>
	    <div class="collapsible">
		<h3>Software</h3>
		<ul class="hide-numbers">
		    <li class="collapsible"><h4>Blender</h4><span>I've been using Blender since I was about 14 when my friend Toby and I managed to convince the school IT department that it was educational enough to be pre-installed on the school systems. Since then it's changed and modernised a ridiculous amount (I remember the switch from 2.79 to 2.8...) and is one of the most incredible outputs of the <a href="https://en.wikipedia.org/wiki/Free_and_open-source_software">FOSS</a> community in my opinion.</span>
		    </li>
		    <li class="collapsible"><h4>Emacs</h4><span>When I started working at ALM I used the first Mac of my life and got shown what <a href="https://www.gnu.org/software/emacs/">Emacs</a> is and why it's useful, and although it's a little archaic I have learned to love it and feel accomplished when I can work on something without needing to touch a mouse.</span>
		    </li>
		    <li class="collapsible"><h4>Affinity</h4><span>I only started using <a href="https://www.affinity.studio/">Affinity</a> when it became free in late 2025, but it's a great alternative to Adobe slop (which I had previously pirated/used at work. Cracked CS6 was manageable, the new cloud stuff that changes every time you open it is NOT. Wish it was actually open-source but it's great for normal artists that it's free and can open Adobe files!</span>
		    </li>
		</ul>
	    </div>
	</div>
	<div class="collapsible">
	    <h2>This Page<div class="garden">🌱 16.12.25</div></h2>
	    <div class="collapsible">
		<h3>Concept</h3>
		<span>I only started learning about <a href="https://maggieappleton.com/garden-history">digital gardens</a> as a concept a few months after starting to develop <a href="https://hogwild.uk">hogwild.uk</a> and realised that it was the way to describe what I wanted to do and why I wanted to do it. This page is just a splinter from the main site that's for my more personal messing around. I think it's a really cool idea and I hope more people start to use them to claw back a bit of human interaction from an internet that's increasingly becoming a conversation between LLMs that real people just look at.</span>
	    </div>
	    <div class="collapsible">
		<h3>Programming</h3><span>I'm using a Dell laptop (thanks Johnny) running Linux (<a href="https://www.debian.org/">Debian</a>). I'm using <a href="https://www.gnu.org/software/emacs/">Emacs</a> as my code editor (using <a href="https://web-mode.org/">web-mode</a> for styling while editing) and just checking the page content in <a href="https://www.firefox.com/en-GB/">Firefox</a> as I go. I like working without any packages when I'm developing web stuff as much as I can, just pure HTML, CSS, JavaScript, and sometimes PHP. The font I'm using on this page is <a href="https://fonts.google.com/specimen/Google+Sans+Code">Google Sans Code</a>, a free to use one that I like a lot</span>
	    </div>
	    <div class="collapsible">
		<h3>🌱?</h3><span>I'm using a similar method of labelling my stuff on this page as the writer of the digital gardens article I find the most useful for understanding the idea:
		    <ul>
			<li>🌱 When I first 'planted' something on the page</li>
			<li>🌿 When I last edited a section (if different to planting date)</li>
			<li>🌳 Stuff I think is pretty complete and unlikely to change much</li>
		    </ul></span>
	    </div>
	</div>
	<div class="collapsible">
	    <h2>Life Story<div class="garden">🌱 16.12.25</div></h2>
	    <input type="checkbox" id="reverse-life-story" autocomplete="off">
	    <label for="reverse-life-story">oldest first</label>
	    <ol id="life-story" class="hide-numbers reversible">
		<li><h3>Oct 2025</h3> <a href="https://hogwild.uk/">hogwild.uk</a> goes live</li>
		<li><h3>May 2025</h3>Move <i>back</i> in with Issy to our new house in Tooting. #aweomse
		    <br><img src="tooting.jpg"/>
		</li>
		<li><h3>Dec 2024</h3>Started working at <a href="https://busycircuits.com/">ALM</a>! Love it!</li>
		<li><h3>Oct 2024</h3>Moved to London to live in a rank shared house (nice room though) but without Issy... :(</li>
		<li><h3>May 2024</h3>Moved in with Issy to Sharrow Lane, Sheffield
		    <br><img src="sharrow.jpg"/>
		</li>
		<li><h3>Oct 2023</h3>Played Left of the Dial in Rotterdam (see Rig pic above). Amazing festival and one of the best things we've ever done as a band. Sang <a href="https://www.youtube.com/watch?v=fr4NSDBtK6o&list=RDfr4NSDBtK6o&start_radio=1">Jesse by Geese</a> in the karaoke room and made good use of the open bar for artists, not necessarily in that order... We played 3 sets over 3 days and slept in the rig thanks to the ferry cancellation.
		    <br><img src="lotd.jpg"/>
		</li>
		<li><h3>Sep 2023</h3>Start at <a href="https://www.pclairtechnology.com/">PCL</a>, a pretty dry job but made some nice friends James & Cole and learned about the world of full time work</li>
		<li><h3>Jul 2023</h3>Moved into <a href="https://hogwild.uk/thompson-world">Thompson World</a> with Ruby, Danny, Itay, and Tom</li>
		<li><h3>Jun 2022</h3>Moved to Sheffield to live with my school friends Johnny & Toby</li>
		<li><h3>Jan/Feb 2022</h3>Started playing with Otala and playing gigs in and around <a href="https://maps.app.goo.gl/ythS87pwhko1HRjg7">Nottingham</a> a lot more often</li>
		<li><h3>Apr 2021</h3>Started to make synth stuff under the name <a href="https://allensynthesis.co.uk/">Allen Synthesis</a></li>
		<li><h3>Dec 2020</h3>Bought my second car - <a href="https://wiki.hogwild.uk/?page=the-rig">The Rig</a>. Pictured driving to Rotterdam to play <a href="https://leftofthedial.nl/">Left of the Dial</a> with my band <a href="https://otalaband.com/">Otala</a> (at the time Oscar, Charlotte, Jack, Fin, and me) in Oct 2022:
		    <br><img src="rig.jpg"/>
		</li>
		<li><h3>Aug/Sep/Oct 2020</h3>Started making music with Oscar under 'Comic Book Sandpaper' (a stupid name we came up with to make sure we didn't encounter the anonymity problems faced by Oscar's previous band Sketch, and probably submliminally because it reminded us of our shared love of <a href="https://www.youtube.com/watch?v=jCyKRfGI8lA&list=RDjCyKRfGI8lA&start_radio=1&t=2402s">Car Seat Headrest</a>)</li>
		<li><h3>Jun 2020</h3>Bought my first car, a 1996 Corsa B in green from <a href="https://share.google/09bSfRuc0rr4DhOlL">Richardsons of Congleton</a>. It had a sunroof and a 16V engine.
		    <br><img src="corsa.jpg"/>
		</li>
		<li><h3>Mar 2020</h3>Pandemic hit, moved home #epicfail</li>
		<li><h3>Oct 2019</h3>Start uni at <a href="https://en.wikipedia.org/wiki/Loughborough_University">Loughborough</a> (shithole!!! if anyone in sixth form tells you to "pick based on the course because that's what you're there for, the city comes second", take it with a fat pinch of salt)</li>
		<li><h3>Sep 2017</h3>Start A-Levels. I picked:
		    <ul>
			<li>Computer Science (made a shopping list website with map solving for the fastest route around the shop)</li>
			<li>Physics</li>
			<li>Product Design (made a wallace & gromit themed board game with magnetic lasers and pewter playing pieces)</li>
			<li>Maths (only did this for 1 year AS level)</li>
		    </ul>
		</li>
		<li><h3>Sep 2015</h3>Start GCSEs. I picked:
		    <ul>
			<li>Triple Science</li>
			<li>Spanish</li>
			<li>Geography</li>
			<li>Graphic Products (stupid name for product design DT)</li>
			<li>Computer Science</li>
		    </ul>
		</li>
		<li><h3>Sep 2012</h3>Finish at Whirley and start secondary school at The Fallibroome Academy</li>
		<li><h3>Sep 2005</h3>Start term at Whirley Primary School. Street view of me, my sister Rowan, and my Dad outside our house in 2009:
		    <br><img src="whirley.jpg"/>
		</li>
		<li><h3>Sep 2000</h3>Born in <a href="https://en.wikipedia.org/wiki/Macclesfield_District_General_Hospital">Macclesfield General Hospital</a> to Dunc and BJ Allen. Had jaundice #fail
		    <br><img src="baby.jpg"/>
		</li>
	    </ul>
	</div>
	<div class="collapsible">
	    <h2>Desert Island Discs <a href="https://en.wikipedia.org/wiki/Desert_Island_Discs">?</a><div class="garden">🌱 16.12.25</div></h2>
	    <ol class="hide-numbers">
		<li class="did-flex">
		    <img class="did-image" src="itigtwof.jpg"/>
		    <span><h3><a href="https://www.youtube.com/watch?v=MVEMQ_SCc6w&list=RDMVEMQ_SCc6w&start_radio=1">I Think It's Going To Work Out Fine - Ry Cooder</a></h3>This song evokes the feeling its name describes. Ry Cooder can make a guitar sing more soulfully than any words could. I'm not sure the rest of this list is ordered but I know that this is #1 every time.</span>
		</li>
		<li class="did-flex">
		    <img class="did-image" src="willin.jpg"/>
		    <span><h3><a href="https://www.youtube.com/watch?v=zcrEWRLk3CE&list=RDzcrEWRLk3CE&start_radio=1">Willin' - Little Feat</a></h3>I've found America 🇺🇸 very interesting for most of my life, probably partly thanks to the stories my Dad has told me about his time living in Florida <a href="https://jkeworks.com/history/">repairing vintage aircraft</a>, and this song reminds me both of him and of the caricature of the USA that I dream(ed) of.</span>
		</li>
		<li class="did-flex">
		    <img class="did-image" src="pavement.jpg"/>
		    <span><h3><a href="https://www.youtube.com/watch?v=LjWoeq2-2AU&list=RDLjWoeq2-2AU&start_radio=1">Black Out - Pavement</a></h3>Continuing on the imaginary exploration of a country I've never been to, this track feels like the other side of America, watching the slacker skateboard types killing time to avoid the ennui of suburbia.</span>
		</li>
		<li class="did-flex">
		    <img class="did-image" src="wilco.jpg"/>
		    <span><h3><a href="https://www.youtube.com/watch?v=Epbu2z3o28w&list=RDEpbu2z3o28w&start_radio=1">Impossible Germany - Wilco</a></h3>One of my favourite guitar soloes and seeing it live in <a href="https://wilcoworld.net/tour_date_type/5-sept-2023-manchester-uk-the-bridgewater-hall/">Manchester</a> was nothing short of transcendental. I listened to this album (as well as <a href="https://www.youtube.com/watch?v=3RQcPC8KY_g&list=PLC80P4gsPr-Z-Ry7aMiTWXCWHWy56AmiB&pp=0gcJCbAEOCosWNin">YHF</a>) a lot during the final two weeks of cramming for my final degree coursework, so listening to this reminds me of my breaks, when I'd walk around <a href="https://maps.app.goo.gl/MCQHahEty5HTW5rz7">The Ponderosa</a> and look at the sky blue sky.</span>
		</li>
		<li class="did-flex">
		    <img class="did-image" src="brj.jpg"/>
		    <span><h3><a href="https://www.youtube.com/watch?v=dOhaGfiGAUY&list=RDdOhaGfiGAUY&start_radio=1">Tell Me You Don't Love Me Watching - Bill Ryder-Jones</a></h3>My friend Johnny put this album on when we were planning a walking expedition, probably soon after it came out so 2015/16, and I've loved it ever since. His voice is so soft and real that he manages to make the questionable narrative of a song like this sound romantic. Also, finally a British artist in the list!</span>
		</li>
		<li class="did-flex">
		    <img class="did-image" src="denver.jpg"/>
		    <span><h3><a href="https://www.youtube.com/watch?v=BZpRobzuLck&list=RDBZpRobzuLck&start_radio=1">Leaving On A Jet Plane - John Denver</a></h3>This one reminds me of going with my Mum and Sister to pick up my Dad from Manchester Airport when he'd been away for work, and also of Scout camps at <a href="https://www.mcscouts.org.uk/barnswood">Barnswood</a>.</span>
		</li>
		<li class="did-flex">
		    <img class="did-image" src="morrison.jpg"/>
		    <span><h3><a href="https://www.youtube.com/watch?v=igK2ME-0jh4&list=RDigK2ME-0jh4&start_radio=1">Saint Dominic's Preview - Van Morrison</a></h3>This is one of the first songs my girlfriend Issy shared with me when we had just started talking, and one of many that revealed how much we have in common. I listened to this song a lot during the late winter of 2022, walking between my flat in Netherthorpe and hers near the top of <a href="https://www.google.com/maps/place/Sheffield+Botanical+Gardens/@53.3740468,-1.4953867,572m/data=!3m1!1e3!4m6!3m5!1s0x487982720050901f:0x6edabb0d419de894!8m2!3d53.3721581!4d-1.4976433!16zL20vMDFfODRu?authuser=1&entry=ttu&g_ep=EgoyMDI1MTIwOS4wIKXMDSoKLDEwMDc5MjA3M0gBUAM%3D">The Botanical Gardens.</a></span>
		</li>
		<li class="did-flex">
		    <img class="did-image" src="gosh.jpg"/>
		    <span><h3><a href="https://www.youtube.com/watch?v=hTGJfRPLe08&list=RDhTGJfRPLe08&start_radio=1">Gosh - Jamie xx</a></h3>One of my favourite electronic tracks. Listening usually makes me want to make music of my own.</span>
		</li>
	    </ol>
	</div>
    </body>

    <script>
     function toggleCollapse(element){
	 if (element.classList.contains("collapsed")){
	     element.classList.remove("collapsed");
	 } else {
	     element.classList.add("collapsed");
	 }
     }
     function toggleReverse(element){
	 const listItems = Array.from(element.querySelectorAll('.reversible > li'));
	 listItems.reverse().forEach(item => element.appendChild(item));
     }
     function updateAge(){
	 const time_now_s = Math.floor(Date.now() / 1000);
	 const age_s = time_now_s - 969714040;
	 const age_y = Math.floor(age_s / 31536000);
	 document.getElementById("age").innerText = age_y + ' Years (' + age_s + ' Seconds)';
     }
     
     document.querySelectorAll(".reversible").forEach(element => {
	 var toggle_id = "reverse-" + element.id;
	 var toggle = document.getElementById(toggle_id);
	 toggle.addEventListener("click", () => { toggleReverse(element) });
     });
     
     document.querySelectorAll(".collapsible").forEach(element => {
	 if (!["me","about"].includes(element.id)){
	     element.classList.add("collapsed");
	 }
	 element.querySelectorAll("h2,h3,h4,h5")[0].addEventListener("click", () => { toggleCollapse(element) });
     });

     updateAge();
     setInterval(updateAge, 1000);
    </script>
</html>
