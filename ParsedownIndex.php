<?php
/* Parsedown Index 
Uses Parsedown (https://github.com/erusev/parsedown) to display pages on your site, 
so youre only really editing markdown files.
Do I know how to optimize this?? No.


http://website.com/misc.md can be seen with http://website.com/?misc and so forth.
!!! .MD PAGES DO NOT REDIRECT AUTOMATICLY you must use mod_rewrite in Apache/httpaccess for that !!!
Also includes an error page for files not found (its very simple though)
Just makes things easier lol

REQUIRES PARSEDOWN and HEADER/FOOTER FILES. 
or just slam the whole design into one file if you so wish.

*/

# header for your header needs
require_once( './header.htm' );
# puts in parsedown immedietely.
include_once( './Parsedown.php' );

if (!$_SERVER['QUERY_STRING']) {
#if no query string is present...
	
	$Parsedown = new Parsedown();
	$MyPage = file_get_contents('index.md');
	# gets a default index.md file
	echo Parsedown::instance()
	   ->setBreaksEnabled(true) # enables automatic line breaks
	   ->text($MyPage);

} else {
  $kiminoURLwa = $_SERVER['QUERY_STRING'];
  # grabs the string from the url
  $kiminoURLwa = strtolower(str_ireplace('', '', substr($kiminoURLwa, 0, 40)));
  # sanitizes query string.
	
  if(!file_exists($kiminoURLwa . '.md')) {
	# checks if the file actually exists, and if not errors.
		echo "<h2>Whoops!</h2><br>";
		echo "<font color=\"red\">ERR 404: File not found.</font><br>";
  } else {
	# if file exists, displays it!
	$Parsedown = new Parsedown();
	$MyPage = file_get_contents($kiminoURLwa . '.md');
	echo Parsedown::instance()
	   ->setBreaksEnabled(true) # enables automatic line breaks
	   ->text($MyPage);
  }# if(!file_exists) ... else

}
	
#Footer for your footer needs
require_once( './footer.htm' );

?>
