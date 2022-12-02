<?php
  /*
  SAILORERROR.PHP - A simple error page script.
  
  Lets you grab error code pages using query strings
  i.e. error.php?404 will grab you a 404 page
  Bad codes won't let you brew coffee.
  
  Written in the .htaccess file as
    ErrorDocument 400 error.php?400
    ErrorDocument 401 error.php?401
    (... ect)
  
  Made for my site @ solstice.party.
  */

  // If no query, ask for a teapot
	if(!$_SERVER['QUERY_STRING']) { $_SERVER['QUERY_STRING'] = 418; }

  // grab Query and force into an integer. Strings will result in 0.
	$showError = (int) $_SERVER['QUERY_STRING'];

  // Anything below 300 or above 600 asks for a teapot.
	if ($showError <= 300 || $showError >= 600) {
		$showError = 418;
	}

  // img path
	$imgPath ="https://a.solstice.party/pb/pixels/sailormoon/";
  
  // case switch for err#, text, and image.
	switch($showError) {
		case 400: $text = "Bad Request"; $img = "mn33.gif"; break;
		case 401: $text = "Unauthorized"; $img ="cm30a.gif";  break;
		case 403: $text = "Forbidden"; $img ="cm30a.gif"; break;
		case 404: $text = "Not found"; $img =" ";  break; // No image bc I wanted 2 for this.
		case 410: $text = "Gone"; $img ="aniSA.gif"; break;
		case 418: $text = "I'm a Teapot!"; $img ="cmoon29.gif"; break; // Short and stout...
		case 500: $text = "Foul Call"; $img ="mn41.gif"; break;
		case 502: $text = "Bad Gateway"; $img ="mn41.gif"; break;
		default:
			$text = "Silence Glaive!"; $img ="aniSA.gif"; break; // Default needed for defaults.
		break;
	}

?>


<!DOCTYPE html>
<html lang="en">
  <head>
    <title>ERROR</title>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		
	<!-- Google Fonts -->
		<link rel="preconnect" href="https://fonts.googleapis.com">
		<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
		<link href="https://fonts.googleapis.com/css2?family=Press+Start+2P&display=swap" rel="stylesheet">
    <!-- bootstrap requirements -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" integrity="sha384-WskhaSGFgHYWDcbwN70/dfYBj47jz9qbsMId/iRN3ewGhXQFZCSftd1LZCfmhktB" crossorigin="anonymous">
    <!-- // end requirements -->

		<style>
      html {
			  box-sizing: border-box;
			  margin: 0;
			  padding: 0;
			}
      
			body {
				height: 100%;
				width: 100%;
				overflow:  hidden;
				margin: 0;
				padding: 0;
			}
		
			* {
				font-family: 'Press Start 2P', cursive;
				font-size: 14px;
				color: #000;
			}

			a, a:hover, a:visited {
				 color: #280900
			}

			main {
				margin-top: 2em;
			}
			
		</style>

  </head>
  <body>
<main style="text-align:center;">
	<?php if($showError == 404) { ?>
	    <img src="<?php echo $imgPath; ?>mn54.gif" />
      <img src="<?php echo $imgPath; ?>starf64.gif"></a>
	<?php } else { 
			echo '<img src="' . $imgPath . $img . '" />'; 
			}
	?>
	<br />
	ERR <?php echo $showError . ": " . $text; ?>
</main>
</body>
</html>
