<?php
/* 

SUberGallery.php

I honestly just copied this from my website
Abuses UberGallery and turns it into a full fledged gallery script... sorta
Honestly I just didnt like any other gallery script
'Cause I couldn't incorperate it into my own code
So here I am, Sam I am!

Requires UberGallery, using the Uber-Naked theme.
Coded for Bootstrap

NOTE: THIS VERSION IS OUTDATED! 
Please visit my UberGallery fork for a more updated version:
https://github.com/seabirdshanty/SUberGallery

*/
session_start();

if(!$_GET["gal"] && $_GET["page"] ) { 
	// This allows pagnation to work.
	$newpage = "gallery.php?gal=" . $_SESSION["gal-check"] . "&page=" . $_GET["page"] ;
	// echo $newpage;
	header("Location: $newpage");
	die();
}

	// I.. don't know why this is needed
	// but the script breaks without it. Enjoy.
	$galpal = 'artbook';
	
	// Include the UberGallery class
	include('resources/UberGallery.php');

	// Initialize the UberGallery object
	$gallery = new UberGallery();

	// Your gallery path to all your images.
	// Each folder in this path will be a new gallery
	$galleyPath = "./gal/";

	// Your Header Here. Gotta be a-head of the game
	include_once('header.htm');
	
	if (!$_SERVER['QUERY_STRING'] && !$_GET["gal"]) { ?>
		<section>
	 	<h1>Gallery</h1>
		<p> Its a gallery! Woo.</p>
			<p style="text-align:left">
					<ul style="list-style-image: url(./img/folder.gif);">
					<?php /////////////////////////////////////////////
					
					$munchyMenu = array_diff(scandir($galleyPath, 1), array('..', '.'));
					foreach($munchyMenu as &$forgetMe) {
						if(is_dir($galleyPath.$forgetMe) == true) {
								echo "<li><a href=\"?gal=".$forgetMe."\">$forgetMe</a></li>";
						}
					}

					// unset or perish
					unset($forgetMe);
					
					?>
					</ul>
					</p>
		</section>
	<?php


		} elseif($_GET["gal"] != "") {?>
		<section style="text-align:center;>
			<nav aria-label="breadcrumb">
					  
		<?php
					
					$_SESSION["gal-check"] = $galpal = $_GET["gal"];
					// Initialize the gallery array
					// prepare your ass
					// echo "DEBUG: Hi! I'm looking for images from $galleyPath".$_GET["gal"]."!<br />";
					
					?>
					
				<ol class="breadcrumb arr-right"> 
					<li class="breadcrumb-item "><a href="gallery.php">Gallery</a></li>
					<?
						
					if(strpos($galpal,"/")) {
						// echo "DEBUG: This gallery is a subdirectory!<br />";
						$galleyBabies = explode('/', $galpal);
						$galleyBabiesDeus = sizeof($galleyBabies);
						$i == 0;
						foreach ($galleyBabies as &$memes) { $i++;?>
								
						<li class="breadcrumb-item<?php 
								if($galleyBabiesDeus == $i) { 
									echo " active"; }?>" aria-current="page">
								<?php if($galleyBabiesDeus != $i) { ?><a href="?gal=<?php echo $memes; ?>"><?php echo $memes; ?></a><?php } else { echo $memes; } ?>
								
						<?php
						}
							
						unset($memes); // break the reference with the last element
						
					} else { 
						
						
						?>
					<li class="breadcrumb-item active" aria-current="page"><?php echo $_GET["gal"]; ?></li>
					<?php } ?>
				
						
					  </ol>
					</nav>
					
					<p>
					<ul style="list-style-image: url(./img/folder.gif);text-align:left">
					<?php /////////////////////////////////////////////
					
					$testingBabey = array_diff(scandir($galleyPath.$galpal), array('..', '.'));
					foreach($testingBabey as &$forgetMe) {
						if(is_dir($galleyPath.$galpal."/".$forgetMe) == true) {
								echo "<li><a href=\"?gal=$galpal/".$forgetMe."\">$forgetMe</a></li>";
						}
					}
					unset($forgetMe);
					
					?>
					</ul>
					</p>
					
					
					
		<?php
	
					
					$galleryArray = $gallery->readImageDirectory($galleyPath.$_GET["gal"]);
					
					// Define theme path
					if (!defined('THEMEPATH')) {
							define('THEMEPATH', $gallery->getThemePath());
					}

					// Set path to theme index
					$themeIndex = $gallery->getThemePath(true) . '/index.php';

					// Initialize the theme
					if (file_exists($themeIndex)) {
							include($themeIndex);
					} else {
							die('ERROR: Failed to initialize theme');
					}

					?>
					</section>
					<?php

			}

			// Your Footer Here. Something is... afoot
			include_once('footer.htm'); 

			?>
