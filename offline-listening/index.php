<!DOCTYPE html>
<html>
    <head>
	<title>Rory's Offline Listening Tutorial</title>
	<meta charset="UTF-8">
	<meta name="description" content="How to reject streaming and learn to love listening again (offline).">
	<meta property="og:title" content="Rory's Offline Listening Tutorial">
	<meta property="og:description" content="How to reject streaming and learn to love listening again (offline).">
	<meta property="og:url" content="https://hogwild.uk/offlinemusic">
	<meta name="viewport" content="width=device-width, initial-scale=1"/>
	<link rel="icon" type="image/x-icon" href="favicon.ico"
	<link rel="shortcut icon" href="favicon.ico" />
	<link rel="stylesheet" href="style.css">
    </head>
    
    <!-- Google tag (gtag.js) -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-6BQYQMEP06"></script>
    <script>
     window.dataLayer = window.dataLayer || [];
     function gtag(){dataLayer.push(arguments);}
     gtag('js', new Date());
    </script>
	
    <body>
	<h1>Rory's Offline Listening Tutorial</h1>
	<span><input id="hide-guff" type="checkbox"> Hide Guff</span>
	<span class="guff"><h2>Introduction</h2>
	I have already <a href="https://roryjamesallen1.substack.com/p/deliberate-listening">written my piece</a> about how and why I think streaming affects your engagement and enjoyment with and of the music you listen to, and why I conclude that you should instead listen offline (either using legal or ..irregular methods).<br><br>
	    This tutorial doesn't necessarily encourage any specific behaviour other than listening to music without relying on an internet connection.</span>
	<h2>The Aim</h2>
	This tutorial might not be for you if your aims aren't the same as mine:
	<ul>
	    <li>Be able to download music on my laptop (from paid sites like Bandcamp, unpaid sites/programs, or by ripping CDs that I own)</li>
	    <li>Be able to listen to my entire music library on my phone (iPhone)</li>
	    <li>Not rely on an internet connection to listen to my music</li>
	    <li>Be able to use more devices in future but share the same library</li>
	</ul>
	This tutorial will show you how to achieve all of those aims.
	<h2>The Tools</h2>
	<h3>⬇️ For Getting Music</h3>
	<strong>I use <a href="https://www.slsknet.org/news/node/1">Soulseek</a> for downloading music on my Windows laptop.</strong><br><br>
	One of the best parts about the method I use is that your files are just ..files. This means you can also add files from CD rips, Bandcamp downloads, or anywhere else.
	    <span class="guff">This tutorial will focus on Soulseek as it is easy to use and has never let me down when searching for music I want to download. It is a peer to peer file sharing program, so you download music from a specific other user who is sharing it. To enter the social contract of the program you must also share music you have downloaded.<br><br>
		Treating Soulseek as what it really is, a file sharing service between <i>individuals</i>, is another justification for accessing music in this way - I don't imagine anyone would have a problem with a stranger sharing their CDs with you, so in a world where technological "advancements" in access to music have seemingly only favoured the streaming giants and multinational record labels, I think it's fair to consider this a modern equivalent.</span>
	    <h3>🎧 For Listening To Music</h3>
	    <strong>I use <a href="https://www.foobar2000.org/">foobar2000</a> for listening to music on both my Windows laptop and my iPhone.</strong><br><br>It's very lightweight and easy to use, especially on mobile which is how I normally listen. It does all the organising based on the metadata of the music files themselves so no need to order your folder too meticulously.
	    <span class="guff"><br><br>I find really lightweight players most conducive to deliberate listening (something I outline in my reasoning for using this approach to listening in the first place). Foobar2000 has pretty much no features other than listening to music, although it does have some nice features in that respect including internet radio playing and playlist support.<br><br>Seeing all the albums I have downloaded in one big clean list (that doesn't buffer or drop in quality, <i>ever</i>), makes me much more likely to listen to a full album than the average streaming service and its 'liked songs' and 'daily mix' favouring UI.<br><br>
	    You can of course use any music player of your choice, as the files are just files.</span>
	<h3>📡 For Syncing</h3>
	<strong>I use <a href="https://syncthing.net/downloads/">Syncthing</a> to keep my iPhone's music library up to date with my Windows laptop's. The iOS app is called <a href="https://apps.apple.com/dk/app/synctrain/id6553985316">Synctrain</a>.</strong><br><br>
	This method works similarly to Dropbox or Google Drive in practice, but without limits on storage and without a cloud involved - your devices only transfer files between each other.<span class="guff"><br><br>Alternatively, foobar2000 has an FTP function to transfer all of your music (or selectively), but it requires an FTP client on your computer and won't run automatically. If you don't know what that means, ignore it, and if you do, consider using it if you'd rather only transfer deliberately.</span>
	<h2>Setting Up</h2>
	The basic setup is as follows:
	<ol>
	    <li>Download <a href="https://www.slsknet.org/news/node/1">Soulseek</a> on your computer</li>
	    <li>Decide where to store your music e.g. Users/rory/Music</li>
	    <li>Tell Soulseek this is where your folder is for both downloads and <a href="https://www.slsknet.org/news/node/807">sharing</a></li>
	    <li>Download some music (or move music you already have into this folder)</li>
	    <li>Download <a href="https://syncthing.net/downloads/">Syncthing</a> on your computer</li>
	    <li>Download <a href="https://apps.apple.com/us/app/foobar2000/id1072807669">foobar2000</a> on your phone and skip any setup</li>
	    <li>Download <a href="https://apps.apple.com/dk/app/synctrain/id6553985316">Synctrain</a> on your phone</li>
	    <li>Link your devices respective music folders on Synctrain/Syncthing</li>
	    <li>Set your phone's music folder in Synctrain to <i>receive only</i></li>
	    <li>Wait for your music to sync (app must be open)</li>
	    <li>Add that music folder in foobar2000 settings</li>
	    <li>Enjoy your offline music, synced to your computer</li>
	</ol>
	<ol>
	    <li>
		<h3>Set Soulseek Folders</h3>
		<ol>
		    <li>Once Soulseek is set up and installed, go to Options -> File Sharing</li>
		    <li>Click 'Set Download Folder' at the top and choose your music folder</li>
		    <li>Set the 'Shared folder' to the same folder (important to avoid automatic bans for being a leech)</li>
		    <li>Check 'Don't put downloads in Downloading and Complete folders'</li>
		    <li>Check 'Don't create username folders</li>
		</ol>
		<img src="images/soulseek-set-folders.JPG">
	    </li>
	    <li>
		<h3>Download Some Music</h3>
		<ol>
		    <li>
			Go to the 'Search' tab and type in the name of an artist and or album you want. I personally always add mp3 to the end to filter the lossless formats out because they would qickly fill up my phone storage
			<img src="images/soulseek-search.JPG">
		    </li>
		    <li>
			When you see the album you want in the list (all the expected songs), right click it (highlighted in blue on the screenshot above) and choose Download Folder. Double check the files look right and (optionally) rename the folder to 'Artist - Album' format to be easier to find in a list. Click 'Download Selected' when you've changed the folder name to what you want.
			<img src="images/soulseek-download.JPG">
		    </li>
		    <li>
			Now you can go to your Transfers tab to check on the download. If you tick the 'Clear Complete Downloads' box at the bottom the tracks will disappear from the list when they're done downloading which is nice for keeping track of what's actually still yet to download and what has been done.
			<img src="images/soulseek-downloading.JPG">
		    </li>
		    <li>
			If you want to add music from somewhere other than Soulseek, just name the folder however you're choosing to name them (maybe Artist - Album like I do) and put it in the same music folder. Not only will the later Syncthing steps now transfer this to your phone automatically, but other people on Soulseek will be able to download them so you'll be helping the community and keeping art accessible!
		    </li>
		</ol>
	    </li>
	    <li>
		<h3>Download Synctrain on your phone</h3>
		<ol>
		    <li>
			After it's installed, you'll be able to see the ID of your phone under 'This device's identifier'. Copy this and send it to your computer somehow (in a cloud based notes app or to yourself on Instagram etc)
			<img src="images/synctrain-add-folder.PNG">
		    </li>
		</ol>
	    </li>
	    <li>
		<h3>Download Syncthing on your Computer</h3>
		<ol>
		    <li>Follow the Syncthing setup instructions and give your computer a name (in my example my laptop is called 'stinkpad')</li>
		    <li>
			In the bottom right click 'Add Remote Device'.
			<img src="images/syncthing-remote-device.JPG">
		    </li>
		    <li>
			Enter the ID of your phone that you copied and sent to yourself earlier.<br>Give your phone a name, in my case I called it 'hogphone'.<br>Click 'Save'.
			<img src="images/syncthing-remote-id.JPG">
		    </li>
		    <li>
			Click Add Folder on the home screen.<br>Give the folder a name, I chose to call it 'music' and set the ID as 'music' too for simplicity.<br>Set the path as the same as you used for Soulseek.<br>Don't click 'Save' yet.
			<img src="images/syncthing-folder.JPG">
		    </li>
		    <li>
			Go to the Sharing tab and tick your phone, then click 'Save'.
			<img src="images/syncthing-sharing.JPG">
		    </li>
		    <li>
			Wait for the folder to scan, this will take a while if you added a lot of music already. It won't take as long in future as it'll only scan new changes
			<img src="images/syncthing-scanning.JPG">
		    </li>
		    <li>
			On the right side of the homepage, click your computer's ID to show the QR code.
			<img src="images/syncthing-qr.JPG">
		    </li>
		</ol>
	    </li>
	    <li>
		<h3>Add your Computer on Synctrain (phone)</h3>
		<ol>
		    <li>
			Back on your phone, go to Devices on the bottom tab and click 'Add device...', then click 'Scan using camera...'.<br>If you can't scan using a camera you'll need to copy the ID from your computer to your phone by sending it to yourself like you did for the other connection.<br>When it scans the ID will be filled automatically and you can click the tick in the top right.
			<img src="images/synctrain-read-id.PNG">
		    </li>
		    <li>
			Back on the Synctrain home page ('Start' at the bottom), click Add your first folder.<br>I called it 'music' and also set the ID as 'music'. I really recommend you do the same as it doesn't make any difference to your usage of the app but will mean this tutorial is less likely to become difficult later on.<br>Leave the setting on 'Regular folder' and change the setting to 'All files' at the bottom.
			<img src="images/synctrain-folder-name.PNG">
		    </li>
		    <li>
			Click the folder in the 'Folders' tab on the bottom, and in the top right click the 3 dots and choose 'Folder settings...'
			<img src="images/synctrain-folder-settings.PNG">
		    </li>
		    <li>
			Turn on the connection with your computer to begin syncing the folders. I suggest also turning <i>on</i> 'Receive only' instead of 'Send and receive', which will protect your computer's files from being messed around with by anything that happens on your phone (e.g. another music app adding weird files to the folder).
			<img src="images/synctrain-receive.PNG">
		    </li>
		    <li>
			Now if you click the tick in the top right and go back to the Synctrain home page, you should see downloads begin. Again this might take a while if you have a lot of music. This should work in the background for future downloads but if you want it to sync soon after you download something new on your laptop, you should just open Synctrain and wait for it to download while it's open. Apparently this is due to some weird Apple thing where apps can't run properly in the background for this kind of task.
			<img src="images/synctrain-receiving.PNG">
		    </li>
		</ol>
	    </li>
	    <li>
		<h3>Add the Folder in foobar2000</h3>
		<ol>
		    <li>Open foobar2000 and click settings in the top right, then click Media Library.
			<img src="images/foobar-media.PNG">
		    </li>
		    <li>Click '+ folder' and navigate to your music folder, probably inside the Synctrain folder and then 'music' and  click into the folder and press the tick in the top right.
			<img src="images/foobar-synctrain.PNG">
		    </li>
		    <li>You should now see your whole library inside foobar2000, fully offline and synced to your computer! Ta-daa!
			<img src="images/foobar-library.PNG">
		    </li>
		</ol>
	    </li>
	</ol>
	
	<div style="margin: 3rem 0">If you have any questions at all, or anything else to say, please email me at <a href="mailto:rory@hogwild.uk">rory@hogwild.uk</a></div>
    </body>

    <script>
     const checkbox = document.getElementById('hide-guff');
     function updateGuff(){
	 var display_style = 'unset';
	 if (checkbox.checked){
	     display_style = 'none';
	 }
	 document.querySelectorAll(".guff").forEach(element => {
	     element.style.display = display_style;
	 });
     }
     checkbox.addEventListener("click", updateGuff)
     updateGuff();
    </script>
</html>
