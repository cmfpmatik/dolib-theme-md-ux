<?php if (!defined('ISLOADEDBYSTEELSHEET')) die('Must be call by steelsheet'); ?>
/* <style type="text/css"> */
 
/* ============================================================================== */
/* Default styles                                                                 */
/* ============================================================================== */
 
:root {
	--colorbackhmenu1: rgb(<?php print $colorbackhmenu1; ?>);
	--colorbackvmenu1: rgb(<?php print $colorbackvmenu1; ?>);
	--colorbacktitle1: rgb(<?php print $colorbacktitle1; ?>);
	--colorbacktabcard1: rgb(<?php print $colorbacktabcard1; ?>);
	--colorbacktabactive: rgb(<?php print $colorbacktabactive; ?>);
	--colorbacklineimpair1: rgb(<?php print $colorbacklineimpair1; ?>);
	--colorbacklineimpair2: rgb(<?php print $colorbacklineimpair2; ?>);
	--colorbacklinepair1: rgb(<?php print $colorbacklinepair1; ?>);
	--colorbacklinepair2: rgb(<?php print $colorbacklinepair2; ?>);
	--colorbacklinepairhover: rgb(<?php print $colorbacklinepairhover; ?>);
	--colorbacklinepairchecked: rgb(<?php print $colorbacklinepairchecked; ?>);
	--colorbacklinebreak: rgb(<?php print $colorbacklinebreak; ?>);
	--colorbackbody: rgb(<?php print $colorbackbody; ?>);
	--colortexttitlenotab: rgb(<?php print $colortexttitlenotab; ?>);
	--colortexttitlenotab2: rgb(<?php print $colortexttitlenotab2; ?>);
	--colortexttitle: rgb(<?php print $colortexttitle; ?>);
	--colortext: rgb(<?php print $colortext; ?>);
	--colortextlink: rgb(<?php print $colortextlink; ?>);
	--colortextbackhmenu: #<?php echo $colortextbackhmenu; ?>;
	--colortextbackvmenu: #<?php print $colortextbackvmenu; ?>;
	--listetotal: #888888;
	--inputbackgroundcolor: #FFF;
	--inputbordercolor: rgba(0,0,0,.2);
	--tooltipbgcolor: <?php print $toolTipBgColor; ?>;
	--tooltipfontcolor : <?php print $toolTipFontColor; ?>;
	--oddevencolor: #202020;
	--colorboxstatsborder: #e0e0e0;
	--dolgraphbg: rgba(255,255,255,0);
	--fieldrequiredcolor: #000055;
	--colortextbacktab: #<?php print $colortextbacktab; ?>;
	--colorboxiconbg: #eee;
	--refidnocolor:#444;
	--tableforfieldcolor:#666;
	--amountremaintopaycolor:#880000;
	--amountpaymentcomplete:#008800;
	--amountremaintopaybackcolor:none;
}

<?php
if (!empty($conf->global->MAIN_THEME_DARKMODEENABLED)) {
	print "@media (prefers-color-scheme: dark) {
	      :root {

	            --colorbackhmenu1: #1d1e20;
	            --colorbackvmenu1: #2b2c2e;
	            --colorbacktitle1: #2b2d2f;
	            --colorbacktabcard1: #38393d;
	            --colorbacktabactive: rgb(220,220,220);
	            --colorbacklineimpair1: #38393d;
	            --colorbacklineimpair2: #2b2d2f;
	            --colorbacklinepair1: #38393d;
	            --colorbacklinepair2: #2b2d2f;
	            --colorbacklinepairhover: #2b2d2f;
	            --colorbacklinepairchecked: #0e5ccd;
	            --colorbackbody: #1d1e20;
	            --tooltipbgcolor: #2b2d2f;
	            --colortexttitlenotab: rgb(220,220,220);
	            --colortexttitlenotab2: rgb(220,220,220);
	            --colortexttitle: rgb(220,220,220);
	            --colortext: rgb(220,220,220);
	            --colortextlink: #4390dc;
	            --colortextbackhmenu: rgb(220,220,220);
	            --colortextbackvmenu: rgb(220,220,220);
				--tooltipfontcolor : rgb(220,220,220);
	            --listetotal: rgb(245, 83, 158);
	            --inputbackgroundcolor: #2b2d2f;
	            --inputbordercolor: rgb(220,220,220);
	            --oddevencolor: rgb(220,220,220);
	            --colorboxstatsborder: rgb(65,100,138);
	            --dolgraphbg: #1d1e20;
	            --fieldrequiredcolor: rgb(250,183,59);
	            --colortextbacktab: rgb(220,220,220);
	            --colorboxiconbg: rgb(36,38,39);
	            --refidnocolor: rgb(220,220,220);
	            --tableforfieldcolor:rgb(220,220,220);
	            --amountremaintopaycolor:rgb(252,84,91);
	            --amountpaymentcomplete:rgb(101,184,77);
	            --amountremaintopaybackcolor:rbg(245,130,46);
				--butactionbg:rbg(255,255,255);
	      }
	    }";
}
?>
