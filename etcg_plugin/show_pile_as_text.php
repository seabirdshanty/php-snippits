<?php 
  // eTCG plugin
	// Shows a pile as text instead of images.
  // Great if you don't ahve the bandwith to host images
  // or your pile is too big to show all the images
  //
  // used as show_cards_txt('sakura','trade','')
	


function show_cards_txt( $tcg, $category, $unique = 0 ) {

	$database = new Database;
	$sanitize = new Sanitize;
	$tcg = $sanitize->for_db($tcg);
	$category = $sanitize->for_db($category);
	$altname = strtolower(str_replace(' ','',$tcg));

	$tcginfo = $database->get_assoc("SELECT * FROM `tcgs` WHERE `name`='$tcg' LIMIT 1");
	$tcgid = $tcginfo['id'];
	$cardsurl = $tcginfo['cardsurl'];
	$format = $tcginfo['format'];

	$cards = $database->get_assoc("SELECT `cards`, `format` FROM `cards` WHERE `tcg`='$tcgid' AND `category`='$category' LIMIT 1");
	if ( $cards['format'] != 'default' ) { $format = $cards['format']; }

	if ( $cards['cards'] === '' ) { }
	else {

		$cards = explode(',',$cards['cards']);
		if ( $unique == 1 ) { $cards = array_unique($cards); }

		foreach ( $cards as $card ) {

			$card = trim($card);
			echo $card." ";

		}

	}

} ?php>
