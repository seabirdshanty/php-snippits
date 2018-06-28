<?php
/* ===============================================
* Name: Trademeter Display
* Date: Feb 2018
* Desc: A script for displaying trademeters
        for Sakura TCG
* By  : Muffy/seabirdshanty
=================================================*/
// Put this code where you'd like your trade meters to display

	$fullMetre = 0;
	$control = 0;
				
	$trady = get_additional('sakura','tradepoints');
	// the eTCG additional feild where you have the number of cards you've traded
				
	$turnedIn = get_additional('sakura','tp_turnedin');
	// the eTCGadditional field where you have the # of trade meters you've turned in


	if($trady > 25) {

		while( $trady > 25 ) {
			++$fullMetre;
			$trady = $trady - 25;
			++$control;
						
			// in case of error
			if($control > 100 ) { break; }
		}

	}


	$fullMetre = $fullMetre - $turnedIn;

	/*
	//If you want an image to display when you've turned in a trade metere, use this
				
	for( $i = 0; $i<$turnedIn; $i++ ) {
		echo "<img src='./path/to/trademeters/turnedin.png' />";
	}
	*/

	for( $j = 0; $j<$fullMetre; $j++ ) {
		echo "<img src='./path/to/trademeters/trademeter25.png' />";
	}

	$tradyF = sprintf("%02d", $trady);
	
	echo "<img src='./path/to/trademeters/trademeter" . $tradyF . ".png' />";
				
?>
