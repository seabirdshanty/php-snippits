<?php
/* ===============================================
* Name: Cupids Arrow Through Your Heart!
* Date: Feb 2018
* Desc: A script for printing charts of Sakura 
*        oTCG's COUPON system.
* By  : Muffy/seabirdshanty
=================================================*/

/* ===============================================

Example seen at my own post: 
    http://tcg.seabird.me/sakura.php?coupons
    
I've done my best to explain how this works,
but if you're still confused, You can always
hit me up in Sakura's/The Online TCG Discord.

EVERYTHING in this code is commented on,
so it should be easy if you want to modify it
or something!


  Contents
  ---------------------------------
    I.    HOW TO SET UP
    II.   POPULATE YOUR CHARTS
        1. Coupons
        2. Coupon Usage
    III.  STYLIZATION (extra)
    IV.   CONFIG
    
    
----------------------------------
  I. HOW TO SET UP
----------------------------------

1. Make a new empty TCG specifically for coupons.
   -> Do not allow auto-upload
   -> Image format is .gif
   -> TCG url+directory can be whatever
      (Maybe i'll implement it where the settings here
      are through eTCG, but I havent figured out how
      to do that.)
      
   It MIGHT work using a not-empty TCG,
   but you're going to be stuck with cluttered
   placeholders for everything.
      
2. Modify the settings in this file
    The config can be found below this entire commented 
    section! I tried to keep it incapsuled in the
    function so the globals don't kill one another.
    
3. Include this file into your page where you
   want coupons to show up.
   
      include_once('cupid.php');

4. Display the coupon charts wherever you'd like.

      display_coupon('NORMAL',$reg);
      display_coupon('LIMITED EDTION',$ltd);
      display_coupon('RARE',$rare);
  
  You can change the title to whatever you want;
  If you want 'Normal' coupons to be called 'Cute', 
  just change that text.
    
  These charts will be empty at first, and thats ok!
  Once you start earning coupons and populating
  the mock TCG you have for the coupons, it'll
  populate itself.


----------------------------------
  II. POPULATE YOUR CHARTS
----------------------------------

+ COUPONS ------ +

For every new coupon you get, make a NEW
CATEGORY of cards in eTCG

    -> Name: coupon name i.e. "adoptionchange"
    -> Worth: 1
    -> Auto-Upload: No
    
To populate the count for that coupon, just 
enter an x and comma for the number of those 
coupons you own in the "Cards" form
    
I.e. if you own 3 adoptionchange coupons, the
Cards for would have only "x, x, x"

+ USAGE COUNTERS ----- +

For every coupon that has a usage counter,
make a new ADDITIONAL FEILD in the TCG
SETTINGS.
    -> New Field Name: [couponname]_use
    -> " " Value: (0/[# of uses])
    
I.e, If you have a weeklygamerewards, which
has 4 uses, you would put "weeklygamerewards_use"
as the name and (0/4) as the value.

If the coupon has no use count, the script
will automaticly put "--" instead.


----------------------------------
  III. Stylization Extra
----------------------------------

If you want, you can stylize the blank div
that exists within this script to look like
"empty"/blank coupons.

It keeps your chart looking organized instead
of shrunk when its empty. Just paste this
into your stylesheet and modify the colors
to your liking!

<style>
  .cupid .faux {
    margin: 0 auto;
    width: 108px;
    // height: 78px; 
    //     Use the above height if you want the faux
    //     div's to have the same height as normal 
    //     coupon images.
    //     Otherwise, leave the below height for it to
    //     just be a placeholder sliver.
    height: 1px;
    border: 1px dotted #ccc; // faux coupon border color 
    padding: 1px;
    background: #fff;
  }

  .cupid .fauxL {
    background: #faefef; // internal background color 
    width: 100%;
    height: 100%;
    color:ddacac;
  }
</style>


=============================================== 
* Now that you've read through it all:
* You can delete this entire commented section
* To save space on your server.
* (Just leave the credits at the top)
* Thank you for using my script!
=============================================== */

// Array's of all the coupons
// If Sakura adds anymore coupons, just put the names here.
// Regular
$reg = ['adoptionchange','adoptiondiscount','bogo50',
        'choicecard','customforumrank','hanamicard',
        'donatespecialdeck','newprofilebadge',
        'profilebadgereplacement'];
// Limited
$ltd = ['2deckdonations','additionaladoption','additionalboxset',
        'deckrequest','biweeklygamerewards','deckmasteryrewards',
        'donationrewards','forumgamerewards','weeklygamerewards'];
// Rare
$rare = ['additionalboxsetfreebie','additionalhanamideck',
         'extrareleasepulls','customlegendbadge','instantmastery',
         'nodonationrestrictions','personalplayerachievement', 
         'doublereleasepulls'];


function display_coupon($title = '', $arr = '') {


  ////////////////////////////////////////////////
  // IV. CONFIG:
  ///////////////////////////////////////////////
  $myCouponTCG = "sakura_coupon";
  // the name for your coupon section in eTCG
  // It should be distinct!
  
	$imgpath = "/path/to/coupon/images";
  // absolute path to images on the server
  // This is to check if the coupon image exists
  // If you don't have the coupon, it won't search for it,
  // and the coupon image will not show up.
  
	$imgdir = "http://url.path.to/coupon/images";
  // URL to images
  // This is to display the coupon image in the chart
	//////////////////////////////////////////////
	if(!$arr) {
    // If they don't exist, don't show 'em.
		echo $arr."<em>Those coupons don't exist.</em>";
	} else {

		?>
		<table class="cupid">
		<tr><th colspan="3"><h1><?php echo $title; ?> COUPONS</h1></th></tr>
		<tr><th class="coupon">COUPON</th><th class="indy">OWN</th><th class="indy">USES</th></tr>

		<?php

		foreach ($arr as &$value) {
			$own = cardcount($myCouponTCG,'',$value);
      // This checks the CARD COUNT of the coupons catagory
			if(!$own) { $own = 0; }
			$use = get_additional($myCouponTCG,$value.'_use');
      // Checks if the coupon has a # of uses
			if(!$use) {
        // if not, make it empty
				if(!$own) { $use = '--'; }
				else { $use =  $own; }
			}
			?>


			<tr>
				<td>
				<?php
          // checks if the file exists
          // if it doesn't make a faux coupon
          // if it does, populate tih the image
					if (!file_exists($imgpath.$value.'.png') || $own == 0 ) {  ?>
					<div class="faux"><div class="fauxL"></div></div>
					<?}
					else { ?>
					<img src="<?php echo $imgdir.$value; ?>.png"></td>
					<?php } ?>
				<td><?php echo $own; ?></td>
				<td><?php echo $use; ?></td>
			</tr>

			<?php
		}

    // DO NOT TOUCH ///////////
		unset($value);
		///////////////////////////

		?>
		</table>

<?php }} ?>
