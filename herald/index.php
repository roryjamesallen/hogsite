<!DOCTYPE html>
<html lang="en">
    <head>
	<meta charset="utf-8">
	<link rel="stylesheet" href="style.css">
	<title>The Hogwild Herald</title>
    </head>
    
    <!-- Google tag (gtag.js) -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-6BQYQMEP06"></script>
    <script>
     window.dataLayer = window.dataLayer || [];
     function gtag(){dataLayer.push(arguments);}
     gtag('js', new Date());

     gtag('config', 'G-6BQYQMEP06');
    </script>

    <style>
     @font-face {
	 font-family: Gothic Pixels;
	 src: url('../fonts/gothic_pixels.ttf');
     }
     @font-face {
	 font-family: Melodica;
	 src: url('../fonts/Melodica.otf');
     }
     :root {
	 --caption: #777777;
	 
	 --image-padding: 1rem;
     }
     body {
	 background: #f4f4f4;
	 font-size: 20px;
	 font-family: Melodica;
     }
     a {
	 color: unset;
     }
     .pad {
	 padding: 0.5rem;
     }
     #newspaper {
	 display: flex;
	 flex-wrap: wrap;
	 gap: 4px;
	 width: min(90vw, 1500px);
	 margin: 0 auto;
     }
     #newspaper > * {
	 background: white;
     }
     #header {
	 display: flex;
	 flex-basis: 100%;
	 justify-content: space-between;
	 color: var(--caption);
     }
     #title {
	 flex-basis: 100%;
	 text-align: center;
	 margin: 0;
	 font-family: Gothic Pixels;
     }
     .article {
	 flex-basis: 40%;
	 flex-grow: 1;
	 text-align: justify;
     }
     .small-article {
	 flex-basis: 10%;
	 font-size: 1rem;
     }
     .article > h3 {
	 margin: 0;
	 flex-grow: 1;
	 display: flex;
	 gap: 0.5rem;
	 align-items: center;
     }
     .article-date {
	 color: var(--caption);
	 font-size: 1rem;
     }
     .article > img {
	 max-height: 250px;
	 float: right;
	 margin: 0 0 var(--image-padding) var(--image-padding);
     }
     .article:not(.small-article) .article-text:first-letter {
	 font-family: Gothic Pixels;
     }
     .article-author {
	 font-size: 1rem;
	 color: var(--caption);
	 margin-top: 0.5rem;
     }
    </style>
    
    <body>
	<div id="newspaper">
	    <div id="header" class="pad">
		<a id="hogwild-link" href="hogwild.uk">hogwild.uk</a>
		<div id="date">Last Updated: Monday 12th January 2026</div>
	    </div>
	    <h1 id="title" class="pad">The Hogwild Herald</h1>
	    
	    <div class="article pad">
		<h3>This is the article's title<span class="article-date">12.01.26</span></h3>
		<img src="images/smoking_hog.jpg">
		<div class="article-text"> Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation <i>ullamco</i> laboris nisi ut aliquip ex ea commodo consequat.<br><br>Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. <strong>Excepteur</strong> sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum. Ut enim ad minima veniam, quis nostrum exercitationem ullam corporis suscipit laboriosam, nisi ut aliquid ex ea commodi consequatur? Quis autem vel eum iure reprehenderit qui in ea voluptate velit esse quam nihil molestiae consequatur, vel illum qui dolorem eum fugiat quo voluptas nulla pariatur?</div>
		<div class="article-author">- The Reverend</div>
	    </div>
	    
	    <div class="article small-article pad">
		<h3>This is the article's title<span class="article-date">12.01.26</span></h3>
		<div class="article-text">
		    Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt. Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, consectetur
		</div>
		<div class="article-author">- Hoops McCann</div>
	    </div>
	    <div class="article pad">
		<h3>This is the article's title<span class="article-date">12.01.26</span></h3>
		<div class="article-text">
		    Ut enim ad minima veniam, quis nostrum exercitationem ullam corporis suscipit laboriosam, nisi ut aliquid ex ea commodi consequatur? Quis autem vel eum iure reprehenderit qui in ea voluptate velit esse quam nihil molestiae consequatur, vel illum qui dolorem eum fugiat quo voluptas nulla pariatur?
		</div>
		<div class="article-author">- The Wrangler</div>
	    </div>
	</div>
    </body>
</html>
