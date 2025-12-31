<!DOCTYPE html>
<html lang="en">
  <head>
     <meta charset="utf-8">
     <meta name="description" content="Scan text and convert words into Wikipedia links where possible.">
     <meta property="og:title" content="Wikify - Add Links">
     <meta property="og:description" content="Scan text and convert words into Wikipedia links where possible.">
     <meta property="og:image" content="">
     <meta property="og:url" content="https://wikify.hogwild.uk">
     <meta name="viewport" content="width=device-width, initial-scale=1"/>
     <link rel="icon" type="image/x-icon" href=""
     <link rel="shortcut icon" href="" />
     <link rel="stylesheet" href="style.css">
     <title>Wikify - Add Links</title>
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
       font-family: Garamond Std;
       src: url('../fonts/GaramondStd.otf');
   }
   body {
       font-family: Arial;
       display: flex;
       flex-wrap: wrap;
       justify-content: center;
       gap: 0.5rem;
       width: min(800px, 95%);
       margin: 50px auto;
   }
   body > * {
       flex-basis: 100%;
       margin: 0;
       font-weight: normal;
   }
   h1 {
       font-family: Garamond Std;
       font-size: 3rem;
       text-align: center;
   }
   #text-input, #text-output {
       min-height: 150px;
       border: 1px solid black;
       box-sizing: border-box;
       font-size: 1rem;
       text-align: left;
       padding: 0.5rem;
   }
   a, a:visited {
       color: #069;
   }
   #copied {
       opacity: 0;
       transition: opacity 0s 2s;
   }
  </style>
  
  <body>
      <h1>Wikify</h1>
      <h2>Add relevant <a href="https://en.wikipedia.org">Wikipedia</a> links to your text (in HTML form)</h2>
      <h3>Type/paste text into the top box, highlight text, then press Alt-W to create a link to its Wikipedia page (if one exists). Clicking the bottom box will automatically copy the HTML to your clipboard.</h3><br>
      <div id="text-input" contenteditable="true"></div>
      <div id="text-output"></div>
      <div id="copied">Copied!</div>
      <div style='width: fit-content; margin: 6rem auto; font-family: Arial; text-align: center;'>A <a class='button-as-link' href='https://hogwild.uk'>hogwild.uk</a> creation</div>
  </body>

  <script>
   const textarea = document.getElementById('text-input');
   const output = document.getElementById('text-output');

   function processWikiJSON(json){
       console.log(json['pages']);
   }
   async function checkLink(link){
       const response = await fetch(link);
       const json = await response.json();
       const page_id = Object.keys(json['query']['pages'])[0];
       if (page_id != -1){
	   return true
       } else {
	   return false
       }
   }
   async function checkIfPageExists(search_term){
       const url = 'https://en.wikipedia.org/w/api.php?action=query&format=json&titles='+search_term+'&origin=*';
       const response = await checkLink(url);
       if (response == true){
	   return 'https://en.wikipedia.org/wiki/'+search_term
       } else {
	   return false
       }
   }
   async function checkWords(){
       output.innerHTML = 'working...';
       const text = textarea.value;
       let output_text = text;

       output.innerHTML = output_text;
   }
   function sanitiseSearchTerm(text){
       return text.trim().replace(' ','_');
   }
   async function replaceSelectedText() {
       var sel, range;
       if (window.getSelection) {
           sel = window.getSelection();
           if (sel.rangeCount) {
	       const selection_string = sel.toString();
	       const url = await checkIfPageExists(sanitiseSearchTerm(selection_string));
	       range = sel.getRangeAt(0);
	       if (url != false){
		   var a = document.createElement('a');
		   var text = document.createTextNode(selection_string);
		   a.appendChild(text);
		   a.href = url;
		   var node = a;
	       } else {
		   var node = document.createTextNode(selection_string);
	       }
	       range.deleteContents();
	       range.insertNode(node);
           }
       } else if (document.selection && document.selection.createRange) {
           range = document.selection.createRange();
           range.text = replacementText;
       }
       updateHTML();
   }
   function updateHTML(){
       output.innerText = textarea.innerHTML;
   }
   function copyOutput(){
       navigator.clipboard.writeText(output.innerText);
       copied.style.opacity = 1;
       setTimeout(() => {
	   copied.style.opacity = 0;
       }, 1000);
   }

   document.body.onkeydown = async function(e) {
       if (e.key === 'w' && event.altKey) {
           replaceSelectedText();
       }
   };
   document.body.onkeyup = function() {
       updateHTML();
   }
   output.addEventListener('mousedown', copyOutput);
  </script>
</html>
