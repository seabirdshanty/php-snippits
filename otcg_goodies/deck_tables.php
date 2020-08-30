<?php
/*

Pretty Deck Tables
Displays your collecting decks as featured cards you can click on
to see the full deck in a js/jquery pop-out window
Uses eTCG, Javascript /JQuery and a little CSS

*** NOTE: This REQUIRES the show_colworth.php etcg plugin! ***

function as:

    deckTables('tcg_name','cutedeckcard01','cooldeckcard12','','')
    
      NOTE: The 'cutedeckcard01' image will display, but when cliked on, 
      will pop up into the entire 'cutedeckcard' deck.

      This allows you to feature a favorite card from your collecting deck!

used in the <body> like so:

      <table id="hold"> // begin your table in the HTML. it's not provided by the script!
      .?php
        deckTables('sakura','gardenshowers13','landofdragons09','magicthorns09','rainyerrands03');
        // ^ this will display 4 decks and their featured cards
        deckTables('sakura','chisehatori01','hollyandivy18','winteronly02');
        // ^ this will display 3 decks and 1 filler
        deckTables('sakura','','kino17'); 
        // ^ this will display a filler before a deck, and then 2 fillers after.
        deckTables('sakura','','','',''); 
        //    OR 
        deckTables('sakura'); 
        // ^ will display an empty row
      ?..
      </table>
      
I have also included the styling used on my own tcg post 
as well as the script required to have the popup boxes work
They can be found after the main script

II. (STYLE)
III. (POPOUTSCRIPT)

*/

// I. MAIN PHP SCRIPT 
//    menu for the decorative deck tables
//    Put this in your header!

function deckTables($tcg, $deckA = '', $deckB = '', $deckC = '', $deckD = '') {

  // quick config
  $deckTables_pathos = "./path/to/tcg/cards/"; // path to your tcg cards. EZ

 $deckStacks = array($deckA, $deckB, $deckC, $deckD);
 $deckStacksClean = array($deckA, $deckB, $deckC, $deckD);
 $j = 0;

 for($i = 0; $i < sizeof($deckStacksClean); $i++) {
	 if($deckStacksClean[$i] == '') { //do nothing
	 } else {
		 $deckStacksClean[$i] = substr($deckStacksClean[$i], 0, -2);
		 // echo $deckStacksClean[$i];
	 }
 }


 ?>
		 <tr>
			 <?php foreach($deckStacksClean as $deck) {
          // if the value is empty, display a filler image.
					if($deck === '') { ?>
            
						<td><img src="<?php echo $deckTables_pathos . $tcg . "/filler.png"; ?>" title="..."></td>
		 <?php } else { ?>
			 <td><a onclick="on('<?php echo $deck;?>')"><img src="<?php echo '' . $deckTables_pathos . $tcg . "/" . $deckStacks[$j]; ?>.png" title="<?php echo $deck;?>"></td>
			 <div id="show-<?php echo $deck;?>" class="overlay" onclick="off('<?php echo $deck;?>')">
				<div id="magi-window"><?php show_collecting($tcg,'',$deck) ?></div>
			</div>
		 <?php } // if...else

		 $j++;
	 } //foreach ?>
</tr>
<tr>
 <?php
 
	 foreach($deckStacksClean as $deck) {
		 if($deck === '') {
          ?>
			 <td>&nbsp;</td>
	 <?php } else { ?>
			 <td><?php 
       // show the deckname and its worth, how much is collected!
       show_colworth($tcg, $deck); ?></td>
	 <?php } // if...else
 } // foreach
 ?>
</tr>

<?php

 $j = 0;

} // function() ?>

<!-- II. (STYLE) 
      Here is some starting CSS for your tables, but don't be limited to just this! -->

<style>
/* for deck viewer */
.overlay {
show_colworth.php 
  position: fixed;
  display: none;
  width: 100%;
  height: 100%;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background-color: rgba(255,255,255,0.3);
  z-index: 2;
  cursor: pointer;
}

#magi-window {
	padding: 2em;
	background: white;
	border: 2px solid #ccc;
	border-radius: 2em;
  position: absolute;
  top: 50%;
  left: 50%;
  font-size: 1em;
  color: white;
  transform: translate(-50%,-50%);
  -ms-transform: translate(-50%,-50%);
}

#magi-window h2 { display: none; }

/* for hold */

#hold {
	margin: 0 auto;
}

#hold img {
	border: 1px solid #ccc;
	padding:5px;
	border-radius: 3px;
	background: #fff;
}
</style>

<!-- III. (POPOUTSCRIPT) 
       Put this script at the bottom of your page before the /body tags! -->

<script>
var deck = '';

function on( deck ) {
  document.getElementById("show-" + deck).style.display = "block";
}

function off( deck ) {
  document.getElementById("show-" + deck).style.display = "none";
}
</script>
