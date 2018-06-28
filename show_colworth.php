function show_colworth($tcg, $deckname = '') {
	// eTCG plugin
	// Shows the worth of a specific collecting deck with thier name
	// without showing the deck
	// Usefull for collection pages!
	// put this at the end of your func.php
	
	// used as show_colworth('sakura','chii');
	
	if($deckname == '') {
		die();
	}
	
	$database = new Database;
	$sanitize = new Sanitize;
	$tcg = $sanitize->for_db($tcg);
	
	$tcginfo = $database->get_assoc("SELECT * FROM `tcgs` WHERE `name`='$tcg' LIMIT 1");
	$tcgid = $tcginfo['id'];
	$cardsurl = $tcginfo['cardsurl'];
	$format = $tcginfo['format'];
	
	$deckname =  $sanitize->for_db($deckname);
	$result = $database->query("SELECT * FROM `collecting` WHERE `tcg` = '$tcgid' AND `mastered` = '0' AND `deck` = '$deckname' ORDER BY `sort`, `worth`"); 
	
	while ( $row = mysqli_fetch_assoc($result) ) {
		$cards = explode(',',$row['cards']);
		if ( $row['format'] != 'default' ) { $format = $row['format']; }
				
		array_walk($cards, 'trim_value');
			
		if ( $row['cards'] == '' ) { $count = 0; } else { $count = count($cards); }
		
		
		echo $deckname. ' <br />(' .count($cards). '/'.$row['count'].')';
		
	}
}
