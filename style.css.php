<?php
/* Copyright (C) 2004-2015	Laurent Destailleur	<eldy@users.sourceforge.net>
 * Copyright (C) 2006		Rodolphe Quiedeville	<rodolphe@quiedeville.org>
 * Copyright (C) 2007-2017	Regis Houssin			<regis.houssin@capnetworks.com>
 * Copyright (C) 2011		Philippe Grand			<philippe.grand@atoo-net.com>
 * Copyright (C) 2012		Juanjo Menent			<jmenent@2byte.es>
 * Copyright (C) 2015		Alexandre Spangaro	<aspangaro.dolibarr@gmail.com>
 * Copyright (C) 2017-2022	Oarces DEV				<dev@oarces.com>
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program. If not, see <http://www.gnu.org/licenses/>.
 */
// memo e6e6e6

/**
 * 		\file       htdocs/theme/md-ux/style.css.php
 * 		\brief      File for CSS style sheet Md (Modern Design UX)
 */
//if (! defined('NOREQUIREUSER')) define('NOREQUIREUSER','1');	// Not disabled because need to load personalized language
//if (! defined('NOREQUIREDB'))   define('NOREQUIREDB','1');	// Not disabled to increase speed. Language code is found on url.
if (!defined('NOREQUIRESOC')) define('NOREQUIRESOC', '1');
//if (! defined('NOREQUIRETRAN')) define('NOREQUIRETRAN','1');	// Not disabled because need to do translations
if (!defined('NOCSRFCHECK')) define('NOCSRFCHECK', 1);
if (!defined('NOTOKENRENEWAL')) define('NOTOKENRENEWAL', 1);
if (!defined('NOLOGIN'))
		define('NOLOGIN', 1);	// File must be accessed by logon page so without login
//if (! defined('NOREQUIREMENU'))   define('NOREQUIREMENU',1);  // We need top menu content
if (!defined('NOREQUIREHTML')) define('NOREQUIREHTML', 1);
if (!defined('NOREQUIREAJAX')) define('NOREQUIREAJAX', '1');

define('ISLOADEDBYSTEELSHEET', '1');

session_cache_limiter(FALSE);

require_once '../../main.inc.php';
require_once DOL_DOCUMENT_ROOT . '/core/lib/functions2.lib.php';
//$morejs=array("/js/mdux.js");
//llxHeader('','mdux','','','','',$morejs,'',0,0);


// Load user to have $user->conf loaded (not done into main because of NOLOGIN constant defined)
if (empty($user->id) && !empty($_SESSION['dol_login'])) $user->fetch('', $_SESSION['dol_login']);

// Load new boxes

// Define css type
header('Content-type: text/css');
// Important: Following code is to avoid page request by browser and PHP CPU at each Dolibarr page access.
if (empty($dolibarr_nocache)) header('Cache-Control: max-age=3600, public, must-revalidate');
else header('Cache-Control: no-cache');

// On the fly GZIP compression for all pages (if browser support it). Must set the bit 3 of constant to 1.
if (isset($conf->global->MAIN_OPTIMIZE_SPEED) && ($conf->global->MAIN_OPTIMIZE_SPEED & 0x04)) {
	ob_start("ob_gzhandler");
}


if (GETPOST('lang'))
		$langs->setDefaultLang(GETPOST('lang', 'aZ09')); // If language was forced on URL
if (GETPOST('theme')) $conf->theme = GETPOST('theme');  // If theme was forced on URL
$langs->load("main", 0, 1);
$right		 = ($langs->trans("DIRECTION") == 'rtl' ? 'left' : 'right');
$left		 = ($langs->trans("DIRECTION") == 'rtl' ? 'right' : 'left');

$path	 = '';  // This value may be used in future for external module to overwrite theme
$theme	 = 'md-ux'; // Value of theme
if (!empty($conf->global->MAIN_OVERWRITE_THEME_RES)) {
	$path	 = '/' . $conf->global->MAIN_OVERWRITE_THEME_RES;
	$theme	 = $conf->global->MAIN_OVERWRITE_THEME_RES;
}

// Define image path files and other constants
$fontlist					 = 'roboto,arial,tahoma,verdana,helvetica'; //$fontlist='verdana,helvetica,arial,sans-serif';
$img_head					 = '';
$img_button					 = dol_buildpath($path . '/theme/' . $theme . '/img/button_bg.png', 1);
$dol_hide_leftmenu			 = $conf->dol_hide_leftmenu;
$dol_optimize_smallscreen	 = $conf->dol_optimize_smallscreen;
$dol_no_mouse_hover			 = $conf->dol_no_mouse_hover;


//$conf->global->THEME_ELDY_ENABLE_PERSONALIZED=0;
//$user->conf->THEME_ELDY_ENABLE_PERSONALIZED=0;
//var_dump($user->conf->THEME_ELDY_RGB);
// Colors
$colorbackhmenu1		 = '250,250,250';   // topmenu
$colorbackvmenu1		 = '255,255,255';   // vmenu
$colortopbordertitle1	 = '';	 // top border of tables-lists title. not defined = default to colorbackhmenu1
$colorbacktitle1		 = '230,230,230';   // title of tables-lists
$colorbacktabcard1		 = '255,255,255';  // card
$colorbacktabactive		 = '234,234,234';
$colorbacklineimpair1	 = '240,240,240'; // line impair
$colorbacklineimpair2	 = '255,255,255'; // line impair
$colorbacklinepair1		 = '250,250,250'; // line pair
$colorbacklinepair2		 = '248,248,248'; // line pair
$colorbacklinepairhover	 = '244,244,244'; // line pair
$colorbackbody			 = '248,248,248';
$colortexttitlenotab	 = '90,90,90';
$colortexttitle			 = '20,20,20';
$colortext				 = '0,0,0';
$colortextlink			 = '0,0,120';
$fontsize				 = '13';
$fontsizesmaller		 = '11';
$usegradient			 = 0;
$useboldtitle			 = (isset($conf->global->THEME_ELDY_USEBOLDTITLE) ? $conf->global->THEME_ELDY_USEBOLDTITLE : 1);
$borderwith				 = 2;
$badgeWarning			 = 'red';
$badgeDanger			 = 'red';

// Case of option always editable
if (! isset($conf->global->THEME_ELDY_BACKBODY)) $conf->global->THEME_ELDY_BACKBODY=$colorbackbody;
if (! isset($conf->global->THEME_ELDY_TOPMENU_BACK1)) $conf->global->THEME_ELDY_TOPMENU_BACK1=$colorbackhmenu1;
if (! isset($conf->global->THEME_ELDY_VERMENU_BACK1)) $conf->global->THEME_ELDY_VERMENU_BACK1=$colorbackvmenu1;
if (! isset($conf->global->THEME_ELDY_BACKTITLE1)) $conf->global->THEME_ELDY_BACKTITLE1=$colorbacktitle1;
if (! isset($conf->global->THEME_ELDY_USE_HOVER)) $conf->global->THEME_ELDY_USE_HOVER=$colorbacklinepairhover;
if (! isset($conf->global->THEME_ELDY_USE_CHECKED)) $conf->global->THEME_ELDY_USE_CHECKED=$colorbacklinepairchecked;
if (! isset($conf->global->THEME_ELDY_LINEBREAK)) $conf->global->THEME_ELDY_LINEBREAK=$colorbacklinebreak;
if (! isset($conf->global->THEME_ELDY_TEXTTITLENOTAB)) $conf->global->THEME_ELDY_TEXTTITLENOTAB=$colortexttitlenotab;
if (! isset($conf->global->THEME_ELDY_TEXTLINK)) $conf->global->THEME_ELDY_TEXTLINK=$colortextlink;

// Case of option editable only if option THEME_ELDY_ENABLE_PERSONALIZED is on
if (empty($conf->global->THEME_ELDY_ENABLE_PERSONALIZED)) {
	// 90A4AE, 607D8B, 455A64, 37474F
	$conf->global->THEME_ELDY_VERMENU_BACK1	 = '255,255,255'; // vmenu
	$conf->global->THEME_ELDY_BACKTABCARD1	 = '255,255,255';  // card
	$conf->global->THEME_ELDY_BACKTABACTIVE	 = '234,234,234';
	$conf->global->THEME_ELDY_LINEIMPAIR1	 = '255,255,255';
	$conf->global->THEME_ELDY_LINEIMPAIR2	 = '255,255,255';
	$conf->global->THEME_ELDY_LINEPAIR1		 = '250,250,250';
	$conf->global->THEME_ELDY_LINEPAIR2		 = '248,248,248';
	$conf->global->THEME_ELDY_LINEPAIRHOVER	 = '238,246,252';
	$conf->global->THEME_ELDY_USE_HOVER		 = '238,246,252';
	$conf->global->THEME_ELDY_TEXT			 = '0,0,0';
	$conf->global->THEME_ELDY_FONT_SIZE1	 = '0.8em';
	$conf->global->THEME_ELDY_FONT_SIZE2	 = '11';
}


// Case of option availables only if THEME_ELDY_ENABLE_PERSONALIZED is on
$colorbackhmenu1		 = empty($user->conf->THEME_ELDY_ENABLE_PERSONALIZED) ? (empty($conf->global->THEME_ELDY_TOPMENU_BACK1) ? $colorbackhmenu1 : $conf->global->THEME_ELDY_TOPMENU_BACK1) : (empty($user->conf->THEME_ELDY_TOPMENU_BACK1) ? $colorbackhmenu1 : $user->conf->THEME_ELDY_TOPMENU_BACK1);
$colorbackvmenu1		 = empty($user->conf->THEME_ELDY_ENABLE_PERSONALIZED) ? (empty($conf->global->THEME_ELDY_VERMENU_BACK1) ? $colorbackvmenu1 : $conf->global->THEME_ELDY_VERMENU_BACK1) : (empty($user->conf->THEME_ELDY_VERMENU_BACK1) ? $colorbackvmenu1 : $user->conf->THEME_ELDY_VERMENU_BACK1);
$colortopbordertitle1	 = empty($user->conf->THEME_ELDY_ENABLE_PERSONALIZED) ? (empty($conf->global->THEME_ELDY_TOPBORDER_TITLE1) ? $colortopbordertitle1 : $conf->global->THEME_ELDY_TOPBORDER_TITLE1) : (empty($user->conf->THEME_ELDY_TOPBORDER_TITLE1) ? $colortopbordertitle1 : $user->conf->THEME_ELDY_TOPBORDER_TITLE1);
$colorbacktitle1		 = empty($user->conf->THEME_ELDY_ENABLE_PERSONALIZED) ? (empty($conf->global->THEME_ELDY_BACKTITLE1) ? $colorbacktitle1 : $conf->global->THEME_ELDY_BACKTITLE1) : (empty($user->conf->THEME_ELDY_BACKTITLE1) ? $colorbacktitle1 : $user->conf->THEME_ELDY_BACKTITLE1);
$colorbacktabcard1		 = empty($user->conf->THEME_ELDY_ENABLE_PERSONALIZED) ? (empty($conf->global->THEME_ELDY_BACKTABCARD1) ? $colorbacktabcard1 : $conf->global->THEME_ELDY_BACKTABCARD1) : (empty($user->conf->THEME_ELDY_BACKTABCARD1) ? $colorbacktabcard1 : $user->conf->THEME_ELDY_BACKTABCARD1);
$colorbacktabactive		 = empty($user->conf->THEME_ELDY_ENABLE_PERSONALIZED) ? (empty($conf->global->THEME_ELDY_BACKTABACTIVE) ? $colorbacktabactive : $conf->global->THEME_ELDY_BACKTABACTIVE) : (empty($user->conf->THEME_ELDY_BACKTABACTIVE) ? $colorbacktabactive : $user->conf->THEME_ELDY_BACKTABACTIVE);
$colorbacklineimpair1	 = empty($user->conf->THEME_ELDY_ENABLE_PERSONALIZED) ? (empty($conf->global->THEME_ELDY_LINEIMPAIR1) ? $colorbacklineimpair1 : $conf->global->THEME_ELDY_LINEIMPAIR1) : (empty($user->conf->THEME_ELDY_LINEIMPAIR1) ? $colorbacklineimpair1 : $user->conf->THEME_ELDY_LINEIMPAIR1);
$colorbacklineimpair2	 = empty($user->conf->THEME_ELDY_ENABLE_PERSONALIZED) ? (empty($conf->global->THEME_ELDY_LINEIMPAIR2) ? $colorbacklineimpair2 : $conf->global->THEME_ELDY_LINEIMPAIR2) : (empty($user->conf->THEME_ELDY_LINEIMPAIR2) ? $colorbacklineimpair2 : $user->conf->THEME_ELDY_LINEIMPAIR2);
$colorbacklinepair1		 = empty($user->conf->THEME_ELDY_ENABLE_PERSONALIZED) ? (empty($conf->global->THEME_ELDY_LINEPAIR1) ? $colorbacklinepair1 : $conf->global->THEME_ELDY_LINEPAIR1) : (empty($user->conf->THEME_ELDY_LINEPAIR1) ? $colorbacklinepair1 : $user->conf->THEME_ELDY_LINEPAIR1);
$colorbacklinepair2		 = empty($user->conf->THEME_ELDY_ENABLE_PERSONALIZED) ? (empty($conf->global->THEME_ELDY_LINEPAIR2) ? $colorbacklinepair2 : $conf->global->THEME_ELDY_LINEPAIR2) : (empty($user->conf->THEME_ELDY_LINEPAIR2) ? $colorbacklinepair2 : $user->conf->THEME_ELDY_LINEPAIR2);
$colorbacklinepairhover	 = empty($user->conf->THEME_ELDY_ENABLE_PERSONALIZED) ? (empty($conf->global->THEME_ELDY_LINEPAIRHOVER) ? $colorbacklinepairhover : $conf->global->THEME_ELDY_LINEPAIRHOVER) : (empty($user->conf->THEME_ELDY_LINEPAIRHOVER) ? $colorbacklinepairhover : $user->conf->THEME_ELDY_LINEPAIRHOVER);
$colorbackbody			 = empty($user->conf->THEME_ELDY_ENABLE_PERSONALIZED) ? (empty($conf->global->THEME_ELDY_BACKBODY) ? $colorbackbody : $conf->global->THEME_ELDY_BACKBODY) : (empty($user->conf->THEME_ELDY_BACKBODY) ? $colorbackbody : $user->conf->THEME_ELDY_BACKBODY);
$colortexttitlenotab	 = empty($user->conf->THEME_ELDY_ENABLE_PERSONALIZED) ? (empty($conf->global->THEME_ELDY_TEXTTITLENOTAB) ? $colortexttitlenotab : $conf->global->THEME_ELDY_TEXTTITLENOTAB) : (empty($user->conf->THEME_ELDY_TEXTTITLENOTAB) ? $colortexttitlenotab : $user->conf->THEME_ELDY_TEXTTITLENOTAB);
$colortexttitle			 = empty($user->conf->THEME_ELDY_ENABLE_PERSONALIZED) ? (empty($conf->global->THEME_ELDY_TEXTTITLE) ? $colortext : $conf->global->THEME_ELDY_TEXTTITLE) : (empty($user->conf->THEME_ELDY_TEXTTITLE) ? $colortexttitle : $user->conf->THEME_ELDY_TEXTTITLE);
$colortext				 = empty($user->conf->THEME_ELDY_ENABLE_PERSONALIZED) ? (empty($conf->global->THEME_ELDY_TEXT) ? $colortext : $conf->global->THEME_ELDY_TEXT) : (empty($user->conf->THEME_ELDY_TEXT) ? $colortext : $user->conf->THEME_ELDY_TEXT);
$colortextlink			 = empty($user->conf->THEME_ELDY_ENABLE_PERSONALIZED) ? (empty($conf->global->THEME_ELDY_TEXTLINK) ? $colortext : $conf->global->THEME_ELDY_TEXTLINK) : (empty($user->conf->THEME_ELDY_TEXTLINK) ? $colortextlink : $user->conf->THEME_ELDY_TEXTLINK);

$fontsize				 = empty($user->conf->THEME_ELDY_ENABLE_PERSONALIZED) ? (empty($conf->global->THEME_ELDY_FONT_SIZE1) ? $fontsize : $conf->global->THEME_ELDY_FONT_SIZE1) : (empty($user->conf->THEME_ELDY_FONT_SIZE1) ? $fontsize : $user->conf->THEME_ELDY_FONT_SIZE1);
$fontsizesmaller		 = empty($user->conf->THEME_ELDY_ENABLE_PERSONALIZED) ? (empty($conf->global->THEME_ELDY_FONT_SIZE2) ? $fontsize : $conf->global->THEME_ELDY_FONT_SIZE2) : (empty($user->conf->THEME_ELDY_FONT_SIZE2) ? $fontsize : $user->conf->THEME_ELDY_FONT_SIZE2);


if (empty($colortopbordertitle1)) $colortopbordertitle1 = $colorbackhmenu1;


$colorbackvmenu1 = join(',', colorStringToArray($colorbackvmenu1)); // Normalize value to 'x,y,z'
$tmppart		 = explode(',', $colorbackvmenu1);
$tmpval			 = (!empty($tmppart[0]) ? $tmppart[0] : 0) + (!empty($tmppart[1]) ? $tmppart[1] : 0) + (!empty($tmppart[2]) ? $tmppart[2] : 0);
if ($tmpval <= 460) {
	$colortextbackvmenu = 'FFFFFF';
} else {
	$colortextbackvmenu = '000000';
}

$colorbacktitle1 = join(',', colorStringToArray($colorbacktitle1)); // Normalize value to 'x,y,z'
$tmppart		 = explode(',', $colorbacktitle1);
if ($colortexttitle == '') {
	$tmpval = (!empty($tmppart[0]) ? $tmppart[0] : 0) + (!empty($tmppart[1]) ? $tmppart[1] : 0) + (!empty($tmppart[2]) ? $tmppart[2] : 0);
	if ($tmpval <= 460) {
		$colortexttitle		 = 'FFFFFF';
		$colorshadowtitle	 = '888888';
	} else {
		$colortexttitle		 = '101010';
		$colorshadowtitle	 = 'FFFFFF';
	}
}

$colorbacktabcard1	 = join(',', colorStringToArray($colorbacktabcard1)); // Normalize value to 'x,y,z'
$tmppart			 = explode(',', $colorbacktabcard1);
$tmpval				 = (!empty($tmppart[0]) ? $tmppart[0] : 0) + (!empty($tmppart[1]) ? $tmppart[1] : 0) + (!empty($tmppart[2]) ? $tmppart[2] : 0);
if ($tmpval <= 460) {
	$colortextbacktab = 'FFFFFF';
} else {
	$colortextbacktab = '111111';
}

// Format color value to match expected format (may be 'FFFFFF' or '255,255,255')
$colorbackhmenu1		 = join(',', colorStringToArray($colorbackhmenu1));
$colorbackvmenu1		 = join(',', colorStringToArray($colorbackvmenu1));
$colorbacktitle1		 = join(',', colorStringToArray($colorbacktitle1));
$colorbacktabcard1		 = join(',', colorStringToArray($colorbacktabcard1));
$colorbacktabactive		 = join(',', colorStringToArray($colorbacktabactive));
$colorbacklineimpair1	 = join(',', colorStringToArray($colorbacklineimpair1));
$colorbacklineimpair2	 = join(',', colorStringToArray($colorbacklineimpair2));
$colorbacklinepair1		 = join(',', colorStringToArray($colorbacklinepair1));
$colorbacklinepair2		 = join(',', colorStringToArray($colorbacklinepair2));
if ($colorbacklinepairhover != '')
		$colorbacklinepairhover	 = join(',', colorStringToArray($colorbacklinepairhover));
$colorbackbody			 = join(',', colorStringToArray($colorbackbody));
$colortexttitlenotab	 = join(',', colorStringToArray($colortexttitlenotab));
$colortexttitle			 = join(',', colorStringToArray($colortexttitle));
$colortext				 = join(',', colorStringToArray($colortext));
$colortextlink			 = join(',', colorStringToArray($colortextlink));

$nbtopmenuentries = $menumanager->showmenu('topnb');

print '/*' . "\n";
//var_dump($_SESSION['leftmenu']);
print 'leftmenu=' . $_SESSION['leftmenu'] ."\n";
print 'colorbackbody=' . $colorbackbody . "\n";
print 'colorbackvmenu1=' . $colorbackvmenu1 . "\n";
print 'colorbackhmenu1=' . $colorbackhmenu1 . "\n";
print 'colorbacktitle1=' . $colorbacktitle1 . "\n";
print 'colorbacklineimpair1=' . $colorbacklineimpair1 . "\n";
print 'colorbacklineimpair2=' . $colorbacklineimpair2 . "\n";
print 'colorbacklinepair1=' . $colorbacklinepair1 . "\n";
print 'colorbacklinepair2=' . $colorbacklinepair2 . "\n";
print 'colorbacklinepairhover=' . $colorbacklinepairhover . "\n";
print '$colortexttitlenotab=' . $colortexttitlenotab . "\n";
print '$colortexttitle=' . $colortexttitle . "\n";
print '$colortext=' . $colortext . "\n";
print '$colortextlink=' . $colortextlink . "\n";
print '$colortextbackvmenu=' . $colortextbackvmenu . "\n";
print 'dol_hide_leftmenu=' . $dol_hide_leftmenu . "\n";
print 'dol_optimize_smallscreen=' . $dol_optimize_smallscreen . "\n";
print 'dol_no_mouse_hover=' . $dol_no_mouse_hover . "\n";
print 'dol_screenwidth=' . $_SESSION['dol_screenwidth'] . "\n";
print 'dol_screenheight=' . $_SESSION['dol_screenheight'] . "\n";
print 'fontsize=' . $fontsize . "\n";
print 'nbtopmenuentries=' . $nbtopmenuentries . "\n";
print '*/' . "\n";
?>

/* ============================================================================== */
/* Default styles                                                                 */
/* ============================================================================== */


body {
background: rgb(<?php print $colorbackbody; ?>);
color: var(--colortext);
line-height: 1.4;
font-size: <?php print $fontsize ?>;
font-family: <?php print $fontlist ?>;
margin-top: 0;
margin-bottom: 0;
margin-right: 0;
margin-left: 0;
<?php print 'direction: ' . $langs->trans("DIRECTION") . ";\n"; ?>
}

input:focus, textarea:focus, button:focus, select:focus {
box-shadow: 0 0 4px #8091BF;
/* TODO Remove shadow on focus. Use instead border-bottom: 1px solid #aaa !important; To disable with select2 too. */
}
textarea.cke_source:focus
{
box-shadow: none;
}

input, input.flat, textarea, textarea.flat, form.flat select, select, select.flat, .dataTables_length label select {
font-size: <?php print $fontsize ?>;
font-family: <?php print $fontlist ?>;
border: 1px solid #C0C0C0;
margin: 0px 0px 0px 0px;
}

input, textarea, select {
border-radius:2px;
border:solid 1px rgba(0,0,0,.3);
border-top:solid 1px rgba(0,0,0,.3);
border-bottom:solid 1px rgba(0,0,0,.2);
background-color: #FFF;
/* box-shadow: 1px 1px 1px rgba(0,0,0,.2) inset;*/
padding:4px;
margin-left:1px;
margin-bottom:1px;
margin-top:1px;
}
input.removedassigned  {
padding: 2px !important;
vertical-align: text-bottom;
margin-bottom: -3px;
}
input.smallpadd {	/* Used for timesheet input */
padding-left: 1px !important;
padding-right: 1px !important;
}
input.buttongen {vertical-align: middle;}
#builddoc_generatebutton {margin-top: -50px;}
span.timesheetalreadyrecorded input {
/*font-size: smaller;*/
border: none;
/*background:	transparent;*/
}

select.flat, form.flat select {
font-weight: normal;
}
.optiongrey, .opacitymedium {
opacity: 0.5;
}
.opacityhigh {
opacity: 0.2;
}
.opacitytransp {
opacity: 0;
}
select:invalid { color: gray; }
input:disabled {
background:#f4f4f4;
}

input.liste_titre {
box-shadow: none !important;
}
.listactionlargetitle .liste_titre {
line-height: 24px;
}
input.removedfile {
padding: 0px !important;
border: 0px !important;
vertical-align: text-bottom;
}
textarea:disabled {
background:#f4f4f4;
}
input[type=file ]    { background-color: transparent; border-top: none; border-left: none; border-right: none; box-shadow: none; }
input[type=checkbox] { background-color: transparent; border: none; box-shadow: none; }
input[type=radio]    { background-color: transparent; border: none; box-shadow: none; }
input[type=image]    { background-color: transparent; border: none; box-shadow: none; }
input[type=text]     { min-width: 20px; }
input:-webkit-autofill {
background-color: #FBFFEA !important;
background-image:none !important;
-webkit-box-shadow: 0 0 0 50px #FBFFEA inset;
}
::-webkit-input-placeholder { color:#ccc; }
:-moz-placeholder { color:#bbb; } 			/* firefox 18- */
::-moz-placeholder { color:#bbb; } 			/* firefox 19+ */
:-ms-input-placeholder { color:#ccc; } 		/* ie */
input:-moz-placeholder { color:#ccc; }

fieldset { border: 1px solid #AAAAAA !important; }
.login_center.center{background-image: inherit!important;}

.button, sbmtConnexion {
font-family: <?php print $fontlist ?>;font-size:1em;
border-color: #c5c5c5;
border-color: rgba(0, 0, 0, 0.15) rgba(0, 0, 0, 0.15) rgba(0, 0, 0, 0.25);
display: inline-block;
padding: 4px 14px;
margin-bottom: 0;
margin-top: 0;
text-align: center;
cursor: pointer;
color: #333333;
text-shadow: 0 1px 1px rgba(255, 255, 255, 0.75);
background-color: #f5f5f5;
background-image: -moz-linear-gradient(top, #ffffff, #e6e6e6);
background-image: -webkit-gradient(linear, 0 0, 0 100%, from(#ffffff), to(#e6e6e6));
background-image: -webkit-linear-gradient(top, #ffffff, #e6e6e6);
background-image: -o-linear-gradient(top, #ffffff, #e6e6e6);
background-image: linear-gradient(to bottom, #ffffff, #e6e6e6);
background-repeat: repeat-x;

border-color: #e6e6e6 #e6e6e6 #bfbfbf;
border-color: rgba(0, 0, 0, 0.1) rgba(0, 0, 0, 0.1) rgba(0, 0, 0, 0.25);
border: 1px solid #bbbbbb;
border-bottom-color: #a2a2a2;

border-radius: 2px;
box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.2), 0 1px 2px rgba(0, 0, 0, 0.05);
}
.button:focus  {
-moz-box-shadow: 0px 0px 6px 1px rgba(0, 0, 60, 0.2), 0px 0px 0px rgba(60,60,60,0.1);
-webkit-box-shadow: 0px 0px 6px 1px rgba(0, 0, 60, 0.2), 0px 0px 0px rgba(60,60,60,0.1);
box-shadow: 0px 0px 6px 1px rgba(0, 0, 60, 0.2), 0px 0px 0px rgba(60,60,60,0.1);
}
.button:hover   {
-moz-box-shadow: 0px 0px 6px 1px rgba(0, 0, 0, 0.2), 0px 0px 0px rgba(60,60,60,0.1);
-webkit-box-shadow: 0px 0px 6px 1px rgba(0, 0, 0, 0.2), 0px 0px 0px rgba(60,60,60,0.1);
box-shadow: 0px 0px 6px 1px rgba(0, 0, 0, 0.2), 0px 0px 0px rgba(60,60,60,0.1);
}
.button:disabled {
opacity: 0.4;
box-shadow: none;
-webkit-box-shadow: none;
-moz-box-shadow: none;
cursor: auto;
}
.buttonRefused {
pointer-events: none;
cursor: default;
opacity: 0.4;
box-shadow: none;
-webkit-box-shadow: none;
-moz-box-shadow: none;
}

.inline-block{display:inline-block;padding: 0.1em 0.5em;}

.left {text-align: <?php print $left; ?>;}
.right {text-align: <?php print $right; ?>;padding: 0 1em;}

.nobold {
font-weight: normal !important;
}
.nounderline {
text-decoration: none;
}
.cursorpointer {cursor: pointer;}
.cursormove{cursor: move;}
.badge {
display: inline-block;
padding: 2px 5px;
font-size: 10px;
font-weight: 700;
line-height: 0.9em;
color: #fff;
text-align: center;
white-space: nowrap;
vertical-align: baseline;
background-color: #777;
border-radius: 10px;
}
.badge.badge-warning {background-color: orange;}
.badge.badge-danger {background-color: red;}
.movable {
cursor: move;
}

.borderrightlight
{
border-right: 1px solid #f4f4f4;
}
#formuserfile {
margin-top: 4px;
}
#formuserfile_link {
margin-left: 1px;
}
.listofinvoicetype {
height: 28px;
vertical-align: middle;
}
div.divsearchfield {
float: <?php print $left; ?>;
margin-<?php print $right; ?>: 12px;
margin-<?php print $left; ?>: 2px;
margin-top: 4px;
margin-bottom: 4px;
padding-left: 2px;
}
div.confirmmessage {padding-top: 3em;}
div.myavailability {
padding-top: 6px;
}
.googlerefreshcal {
padding-top: 4px;
padding-bottom: 4px;
}
.checkallactions {
vertical-align: top;
margin-top: 6px;
margin-left: 4px;
}
.selectlimit, .marginrightonly {
margin-right: 10px !important;
}
.strikefordisabled {
text-decoration: line-through;
}
.tdoverflow {
max-width: 0;
overflow: hidden;
text-overflow: ellipsis;
white-space: nowrap;
}
.tdoverflowmax100 {
max-width: 100px;
overflow: hidden; 
text-overflow: ellipsis;
white-space: nowrap;
}
.tdoverflowmax300 {
max-width: 300px;
overflow: hidden;
text-overflow: ellipsis;
white-space: nowrap;
}
.tdoverflowauto {
max-width: 0;
overflow: auto;
}
.tablelistofcalendars {
margin-top: 25px !important;
}
.amountalreadypaid {
}
.amountpaymentcomplete {
color: #008800;
font-weight: bold;
}
.amountremaintopay {
color: #880000;
font-weight: bold;
}
.amountremaintopayback {
font-weight: bold;
}
.savingdocmask {
margin-top: 6px;
margin-bottom: 12px;
}

/* DOL_XXX for future usage (when left menu has been removed). If we do not use datatable */
/*.table-responsive {
width: calc(100% - 330px);
margin-bottom: 15px;
overflow-y: hidden;
-ms-overflow-style: -ms-autohiding-scrollbar;
}*/
/* Style used for most tables */
.div-table-responsive, .div-table-responsive-no-min {

min-height: 0.01%;
}
/* Style used for full page tables with field selector and no content after table (priority before previous for such tables) */
div.fiche>form>div.div-table-responsive, div.fiche>form>div.div-table-responsive-no-min {

}
div.fiche>form>div.div-table-responsive {
min-height: 350px;
}

.font-status4 {
    color: #55a580 !important;
}
/* ============================================================================== */
/* Styles to hide objects                                                         */
/* ============================================================================== */

.clearboth  { clear:both; }
.hideobject { display: none; }
.minwidth50  { min-width: 50px; }
/* rule for not too small screen only */
@media only screen and (min-width: <?php echo round($nbtopmenuentries * 13 * 3.4, 0) + 7; ?>px)
{
.minwidth100 { min-width: 100px; }
.minwidth200 { min-width: 200px; }
.minwidth300 { min-width: 300px; }
.minwidth400 { min-width: 400px; }
.minwidth500 { min-width: 500px; }
.minwidth50imp  { min-width: 50px !important; }
.minwidth100imp { min-width: 100px !important; }
.minwidth200imp { min-width: 200px !important; }
.minwidth300imp { min-width: 300px !important; }
.minwidth400imp { min-width: 400px !important; }
.minwidth500imp { min-width: 500px !important; }
}
.maxwidth25  { max-width: 25px; }
.maxwidth50  { max-width: 50px; }
.maxwidth75  { max-width: 75px; }
.maxwidth100 { max-width: 100px; }
.maxwidth150 { max-width: 150px; }
.maxwidth200 { max-width: 200px; }
.maxwidth300 { max-width: 300px; }
.maxwidth400 { max-width: 400px; }
.maxwidth500 { max-width: 500px; }
.maxwidth50imp  { max-width: 50px !important; }
.minheight20 { min-height: 20px; }
.minheight40 { min-height: 40px; }
.titlefieldcreate { width: 20%; }
.titlefield       { width: 25%; }
.titlefieldmiddle { width: 50%; }
.imgmaxwidth180 { max-width: 180px; }


/* Force values for small screen 1400 */
@media only screen and (max-width: 1400px)
{
.titlefield { width: 30% !important; }
.titlefieldcreate { width: 30% !important; }
.minwidth50imp  { min-width: 50px !important; }
.minwidth100imp { min-width: 100px !important; }
.minwidth200imp { min-width: 200px !important; }
.minwidth300imp { min-width: 300px !important; }
.minwidth400imp { min-width: 300px !important; }
.minwidth500imp { min-width: 300px !important; }
}

/* Force values for small screen 1000 */
@media only screen and (max-width: 1000px)
{
.maxwidthonsmartphone { max-width: 100px; }
.minwidth50imp  { min-width: 50px !important; }
.minwidth100imp { min-width: 50px !important; }
.minwidth200imp { min-width: 100px !important; }
.minwidth300imp { min-width: 100px !important; }
.minwidth400imp { min-width: 100px !important; }
.minwidth500imp { min-width: 100px !important; }
}

/* Force values for small screen 570 */
@media only screen and (max-width: 570px)
{
.tdoverflowonsmartphone {
max-width: 0;
overflow: hidden;
text-overflow: ellipsis;
white-space: nowrap;
}
div.fiche {
margin-top: 12px !important;
}
div.titre {
line-height: 2em;
}
.border tbody tr, .border tbody tr td, div.tabBar table.border tr {
height: 40px !important;
}

.quatrevingtpercent, .inputsearch {
width: 95%;
}

input, input[type=text], input[type=password], select, textarea     {
min-width: 20px;
min-height: 1.4em;
line-height: 1.4em;
padding: .4em .1em;
border: 1px solid #BBB;
/* max-width: inherit; why this */
}

.hideonsmartphone { display: none; }
.noenlargeonsmartphone { width : 50px !important; display: inline !important; }
.maxwidthonsmartphone, #search_newcompany.ui-autocomplete-input { max-width: 100px; }
.maxwidth50onsmartphone { max-width: 40px; }
.maxwidth75onsmartphone { max-width: 50px; }
.maxwidth100onsmartphone { max-width: 70px; }
.maxwidth150onsmartphone { max-width: 120px; }
.maxwidth200onsmartphone { max-width: 200px; }
.maxwidth300onsmartphone { max-width: 300px; }
.maxwidth400onsmartphone { max-width: 400px; }
.minwidth50imp  { min-width: 50px !important; }
.minwidth100imp { min-width: 50px !important; }
.minwidth200imp { min-width: 50px !important; }
.minwidth300imp { min-width: 50px !important; }
.minwidth400imp { min-width: 50px !important; }
.minwidth500imp { min-width: 50px !important; }
.titlefield { width: auto; }
.titlefieldcreate { width: auto; }

#tooltip {
position: absolute;
width: <?php print dol_size(300, 'width'); ?>px;
}

/* intput, input[type=text], */
select {
width: 98%;
min-width: 40px;
}

div.divphotoref {
padding-right: 5px;
}
img.photoref, div.photoref {
border: none;
-moz-box-shadow: none;
-webkit-box-shadow: none;
box-shadow: none;
padding: 4px;
height: 20px;
width: 20px;
object-fit: contain;
}

div.statusref {
padding-right: 10px;
}
}
.linkobject { cursor: pointer; }



/* ============================================================================== */
/* Styles for dragging lines                                                      */
/* ============================================================================== */

.dragClass {
color: #002255;
}
td.showDragHandle {
cursor: move;
}
.tdlineupdown {
white-space: nowrap;
min-width: 10px;
}


/* ============================================================================== */
/* Styles de positionnement des zones                                             */
/* ============================================================================== */

#id-container {margin-top: 0px;margin-bottom: 0px;margin-left: 120px;display: block;}
#id-top {width: 100%;display: block;overflow-y: auto;height: 100%;background-color: #fff;}
#id-left {height: 100%;position: fixed;width: 210px;display: block;overflow-y: auto;overflow-x: hidden;background: #fff;padding-top:10em;border-right: 1px solid rgba(0,0,0,0.3);}

.side-nav {
background: #FFF;
border-left: 1px solid rgba(0,0,0,0.3);
box-shadow: 3px 0 6px -2px #eee;

color: #333;
display: block;
font-family: "RobotoDraft","Roboto",sans-serif;
left: 120px;
position: fixed;
top: 0;
bottom: 0px;
z-index: 90;
-webkit-transform: translateZ(0);
-moz-transform: translateZ(0);
-ms-transform: translateZ(0);
-o-transform: translateZ(0);
transform: translateZ(0);
-webkit-transform-style: preserve-3d;
-moz-transform-style: preserve-3d;
-ms-transform-style: preserve-3d;
-o-transform-style: preserve-3d;
transform-style: preserve-3d;
-webkit-transition-delay: 0.1s;
-moz-transition-delay: 0.1s;
transition-delay: 0.1s;
-webkit-transition-duration: 0.2s;
-moz-transition-duration: 0.2s;
transition-duration: 0.2s;
-webkit-transition-property: -webkit-transform;
-moz-transition-property: -moz-transform;
transition-property: transform;
-webkit-transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
-moz-transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
-webkit-overflow-scrolling: touch;
}
.side-nav-vert {position: fixed;z-index: 150;height:100%;background-color: rgb(248,248,248);max-width: 120px;}

div.fiche {margin-top:5em;margin-left:220px;margin-right:2em;margin-bottom:1em;display: block;}
.sidebar-collapse div.fiche {margin-left: 2em;}

div.twocolumns {display: flex;width: 100%;}
div.fichehalfleft, div.fichehalfright, div.fichethirdleft, div.fichetwothirdright  {
width: 48%;
margin: 1% auto;
display: block;
}

/* For table into table into card */
div.ficheaddleft tr.liste_titre:first-child td table.nobordernopadding td, div.nopadding {
padding: 0 0 0 0;
}
div.nopadding {
padding: 0 !important;
}

.containercenter {
display : table;
margin : 0px auto;
}

#pictotitle {
margin-right: 8px;
margin-bottom: 4px;
}
.pictoobjectwidth {
width: 14px;
}
.pictosubstatus {
padding-left: 2px;
padding-right: 2px;
}
.pictostatus {
width: 15px;
vertical-align: middle;
margin-top: -3px
}
.pictowarning, .pictopreview {
padding-left: 3px;
}
.colorthumb {
padding-left: 1px !important;
padding-right: 1px;
padding-top: 1px;
padding-bottom: 1px;
width: 44px;
}
div.attacharea {
padding-top: 10px;
padding-bottom: 10px;
}
div.arearef {
padding-top: 2px;
padding-bottom: 5px;
margin-bottom: 10px;
}
div.arearefnobottom {
padding-top: 2px;
padding-bottom: 4px;
}
div.heightref {
min-height: 80px;
}
div.divphotoref {
padding-right: 20px;
}
div.statusref {
float: right;
padding-left: 12px;
margin-top: 8px;
margin-bottom: 10px;
clear: both;
}
img.photoref, div.photoref {
border: 1px solid #CCC;
-moz-box-shadow: 3px 3px 4px #DDD;
-webkit-box-shadow: 3px 3px 4px #DDD;
box-shadow: 3px 3px 4px #DDD;
padding: 4px;
height: 80px;
width: 80px;
object-fit: contain;
}
img.fitcontain {
object-fit: contain;
}
div.photoref {
display:table-cell;
vertical-align:middle;
text-align:center;
}
img.photorefnoborder {
padding: 2px;
height: 48px;
width: 48px;
object-fit: contain;
border: 1px solid #CCC;
}
.underrefbanner {
}
.underbanner {
border-bottom: <?php echo $borderwith; ?>px solid rgb(<?php echo $colortopbordertitle1 ?>);
}
.tdhrthin {
margin: 0;
padding-bottom: 0 !important;
}


/* ============================================================================== */
/* Menu top et 1ere ligne tableau                                                 */
/* ============================================================================== */

<?php
$minwidthtmenu		 = 66;   /* minimum width for one top menu entry */
$heightmenu			 = 48;   /* height of top menu, part with image */
$heightmenu2		 = 48;  /* height of top menu, ârt with login  */
$disableimages		 = 0;
$maxwidthloginblock	 = 110;
if (!empty($conf->global->THEME_TOPMENU_DISABLE_IMAGE)) {
	$heightmenu			 = 30;
	$disableimages		 = 1;
	$maxwidthloginblock	 = 180;
	$minwidthtmenu		 = 0;
}
?>

div.tmenusep {
<?php if ($disableimages) { ?>
	display: none;
<?php } ?>
}

div.tmenudisabled, a.tmenudisabled {
opacity: 0.6;
}
a.tmenudisabled:link, a.tmenudisabled:visited, a.tmenudisabled:hover, a.tmenudisabled:active, a.tmenu:link, a.tmenu:visited, a.tmenu:hover, a.tmenu:active, a.tmenusel:link, a.tmenusel:visited, a.tmenusel:hover, a.tmenusel:active {
font-weight: normal;white-space: nowrap;color: #000;text-decoration: none !important;text-overflow: ellipsis;
}

a.tmenudisabled:link, a.tmenudisabled:visited, a.tmenudisabled:hover, a.tmenudisabled:active {
padding: 0px 5px 0px 5px;
cursor: not-allowed;
}

a.tmenu:link, a.tmenu:visited, a.tmenu:hover, a.tmenu:active {
display:block;
}

a.tmenusel:link, a.tmenusel:visited, a.tmenusel:hover, a.tmenusel:active {
padding: 0px 5px 0px 5px;
margin: 0px 0px 0px 0px;
}


ul.tmenu {	/* t r b l */
padding: 0px 0px 0px 0px;
margin: 0px 0px 0px 0px;
list-style: none;
display: block;
height: auto;
min-height: 100%;
}
ul.tmenu li {width: 100%;height:60px}
li.tmenu, li.tmenusel {
<?php print $minwidthtmenu ? 'min-width: ' . $minwidthtmenu . 'px;' : ''; ?>
text-align: center;
vertical-align: bottom;
<?php if (empty($conf->global->MAIN_MENU_INVERT)) { ?>
	float: <?php print $left; ?>;
	<?php if (!$disableimages) { ?>
		height: <?php print $heightmenu; ?>px;
	<?php } else { ?>
		padding: 0px 0px 0px 0px;
	<?php }
}
?>
position:relative;
display: block;
margin: 0px 0px 0px 0px;
font-weight: normal;padding: 0.5em 0;
}
li.tmenusel {background: rgb(<?php echo $colorbackhmenu1 ?>);}

li.tmenusel, li.tmenu:hover {opacity: .50; /* show only a slight shadow */}
.tmenuend .tmenuleft { width: 0px; }
.tmenuend { display: none; }
div.tmenucenter
{
padding-left: 0px;
padding-right: 0px;
<?php if ($disableimages) { ?>
	padding-top: 10px;
	height: 26px;
<?php } else { ?>
	padding-top: 2px;
	height: <?php print $heightmenu; ?>px;
<?php } ?>
width: 100%;
}
div.menu_titre {
padding-bottom: 2px;
overflow: hidden;
text-overflow: ellipsis;
}
.sidebar-collapse #id-left, .sidebar-collapse .login_block {display: none;}
.tmenusel:hover,#id-left,.login_block{display:block;}
.dropdown-menu{display:none}
.open .dropdown-menu{display: block;background-color: #fff;height: 100%;position: fixed;width: 182px;left: 93px;font-size: 0.9em;}
.dropdown-menu:hover {color: #000;}
.dropdown-menu > .user-footer {background-color: #f9f9f9;padding: 10px;}
.dropdown-menu > .user-body, .dropdown-body {
    padding: 15px;background-color: #FFF;
    border-bottom: 1px solid #f4f4f4;
    border-top: 1px solid #dddddd;
    white-space: normal;
}
#topmenuloginmoreinfo-btn {
    display: block;
    text-aling: right;
    color: #666;
    cursor: pointer;
}
#topmenuloginmoreinfo {
    display: none;
    clear: both;
}
.dropdown-menu > .user-header {
   background-color: #f9f9f9;
}
.dropdown-user-image {
    border-radius: 50%;
    vertical-align: middle;
    z-index: 5;
    height: 90px;
    width: 90px;
    border: 3px solid;
        border-top-color: currentcolor;
        border-right-color: currentcolor;
        border-bottom-color: currentcolor;
        border-left-color: currentcolor;
    border-color: transparent;
    border-color: rgba(255, 255, 255, 0.2);
    max-width: 100%;
    max-height: 100%;padding:1em;
}
        <?php include dol_buildpath($path.'/theme/'.$theme.'/main_menu_fa_icons.inc.php', 0); ?>

	<?php
// Add here more div for other menu entries. moduletomainmenu=array('module name'=>'name of class for div')

	$moduletomainmenu	 = array('user'			 => '', 'syslog'		 => '', 'societe'		 => 'companies', 'projet'		 => 'project', 'propale'		 => 'commercial', 'commande'		 => 'commercial',
		'produit'		 => 'products', 'service'		 => 'products', 'stock'			 => 'products',
		'don'			 => 'accountancy', 'tax'			 => 'accountancy', 'banque'		 => 'accountancy', 'facture'		 => 'accountancy', 'compta'		 => 'accountancy', 'accounting'	 => 'accountancy', 'adherent'		 => 'members', 'import'		 => 'tools', 'export'		 => 'tools', 'mailing'		 => 'tools',
		'contrat'		 => 'commercial', 'ficheinter'	 => 'commercial', 'deplacement'	 => 'commercial',
		'fournisseur'	 => 'companies',
		'barcode'		 => '', 'fckeditor'		 => '', 'categorie'		 => '',
	);
	$mainmenuused		 = 'home';
	foreach ($conf->modules as $val) {
		$mainmenuused .= ',' . (isset($moduletomainmenu[$val]) ? $moduletomainmenu[$val] : $val);
	}
//var_dump($mainmenuused);
	$mainmenuusedarray = array_unique(explode(',', $mainmenuused));

	$generic			 = 1;
// Put here list of menu entries when the div.mainmenu.menuentry was previously defined
	$divalreadydefined	 = array('home', 'companies', 'products', 'commercial', 'externalsite', 'accountancy', 'project', 'tools', 'members', 'agenda', 'ftp', 'holiday', 'hrm', 'bookmark', 'cashdesk', 'ecm', 'geoipmaxmind', 'gravatar', 'clicktodial', 'paypal', 'webservices', 'websites');
// Put here list of menu entries we are sure we don't want
	$divnotrequired		 = array('multicurrency', 'salaries', 'margin', 'opensurvey', 'paybox', 'expensereport', 'incoterm', 'prelevement', 'propal', 'workflow', 'notification', 'supplier_proposal', 'cron', 'product', 'productbatch', 'expedition');
	foreach ($mainmenuusedarray as $val) {
		if (empty($val) || in_array($val, $divalreadydefined)) continue;
		if (in_array($val, $divnotrequired)) continue;
		//print "XXX".$val;
		// Search img file in module dir
		$found	 = 0;
		$url	 = '';
		foreach ($conf->file->dol_document_root as $dirroot) {
			if (file_exists($dirroot . "/" . $val . "/img/" . $val . ".png")) {
				$url	 = dol_buildpath('/' . $val . '/img/' . $val . '.png', 1);
				$found	 = 1;
				break;
			}
		}
		// Img file not found
		if (!$found) {
			$url	 = dol_buildpath($path . '/theme/' . $theme . '/img/menus/generic' . $generic . ".png", 1);
			$found	 = 1;
			if ($generic < 4) $generic++;
			print "/* A mainmenu entry was found but img file " . $val . ".png not found (check /" . $val . "/img/" . $val . ".png), so we use a generic one */\n";
		}
	}
// End of part to add more div class css
	?>

/* Login */

.bodylogin
{
background: #f0f0f0;
}
.login_vertical_align {
padding: 10px;
}
form#login {
margin-top: <?php echo $dol_optimize_smallscreen ? '30' : '60' ?>px;
margin-bottom: 30px;
font-size: 1.4em;
vertical-align: middle;
}
.login_table_title {max-width: 530px;color: #CCC !important;font-size: 0;display: none;visibility: hidden;}
.login_table label {
text-shadow: 1px 1px 1px #FFF;
}
.login_table {
margin: 2em auto;  /* Center */
padding-left:6px;
padding-right:6px;
padding-top:16px;
padding-bottom:12px;
max-width: 560px;
background-color: #FFFFFF;

-moz-box-shadow: 0 4px 23px 5px rgba(0, 0, 0, 0.2), 0 2px 6px rgba(60,60,60,0.15);
-webkit-box-shadow: 0 4px 23px 5px rgba(0, 0, 0, 0.2), 0 2px 6px rgba(60,60,60,0.15);
box-shadow: 0 4px 23px 5px rgba(0, 0, 0, 0.2), 0 2px 6px rgba(60,60,60,0.15);
/*-moz-box-shadow: 3px 2px 20px #CCC;
-webkit-box-shadow: 3px 2px 20px #CCC;
box-shadow: 3px 2px 20px #CCC;*/

border-radius: 4px;
border:solid 1px rgba(80,80,80,.4);
border-top:solid 1px f8f8f8;
}
.login_table input#username, .login_table input#password, .login_table input#securitycode{
border: none;
border-bottom: solid 1px rgba(180,180,180,.4);
padding: 1em;
margin-left: 18px;
margin-top: 1em;
}
.login_table input#username:focus, .login_table input#password:focus, .login_table input#securitycode:focus {
outline: none !important;
/* box-shadow: none;
-webkit-box-shadow: 0 0 0 50px #FFF inset;
box-shadow: 0 0 0 50px #FFF inset;*/
}
.login_main_message {
text-align: center;
max-width: 570px;
margin-bottom: 10px;
}
.login_main_message .error {
border: 1px solid #caa;
padding: 10px;
}
div#login_left, div#login_right {
display: inline-block;
min-width: 245px;
padding-top: 10px;
padding-left: 16px;
padding-right: 16px;
text-align: center;
vertical-align: middle;
}
div#login_right select#entity {
margin-top: 10px;
}
table.login_table tr td table.none tr td {
padding: 2px;
}
table.login_table_securitycode {
border-spacing: 0px;
}
table.login_table_securitycode tr td {
padding-left: 0px;
padding-right: 4px;
}
#securitycode {
min-width: 60px;
}
#img_securitycode {
border: 1px solid #f4f4f4;
}
#img_logo, .img-logo {
max-width: 170px;
max-height: 90px;
}

div.login_block {
border-left: 1px solid rgba(0,0,0,0.3);
padding-top: 5px;
<?php print $left; ?>: 120px;
top: 0px;
position: fixed;
z-index: 10;
text-align: center;
vertical-align: middle;
background: #FFF;
width: 210px;
height: 6em;
}
div.login_block table {
display: inline;
}
div.login {
white-space:nowrap;
font-weight: bold;
float: right;
}
div.login a {
color: #<?php echo $colortextbackvmenu; ?>;
}
div.login a:hover {
color: #<?php echo $colortextbackvmenu; ?>;
text-decoration:underline;
}
div.login_block_other div.inline-block {margin: 0.2em 0;}
div.login_block_other { padding-top: 1em;z-index: -1 !important;position: relative;}
div.login_block_other span.fa,div.login_block_other span.fas,a#dolicalcbutton{font-size: 22px;font-weight: 900;font-family: "Font Awesome 5 Free";color: #000000;}
a#dolicalcbutton::before {content: "\f1ec";}
a#dolicalcbutton img{display:none;}
.login_block_elem {float: right;vertical-align: top;height: 1em;}

.fa-fw{padding: 0 0.2em 0 0;}
/*.fa, .fas {font-weight: 600!important;}*/
.fas.fa-arrows-alt, .fas.fa-window-close {margin: 0.3em;font-size: 1.2em;}
.atoplogin{
color: #<?php echo $colortextbackvmenu; ?> !important;
}
.alogin, .alogin:hover {
color: #888 !important;
font-weight: normal !important;
font-size: <?php echo $fontsizesmaller; ?>px !important;
}
.alogin:hover, span.atoplogin:hover,a#dolicalcbutton:hover{color:#CCC!important}
img.login, img.printer, img.entity {
/* padding: 0px 0px 0px 4px; */
/* margin: 0px 0px 0px 8px; */
text-decoration: none;
color: white;
font-weight: bold;
}
img.loginphoto {
border-radius: 5px;
margin-top: -4px;
width: 20px;
height: 20px;
}

.span-icon-user {
background-image: url(<?php echo dol_buildpath($path . '/theme/' . $theme . '/img/object_user.png', 1); ?>);
background-repeat: no-repeat;
}
.span-icon-password {
background-image: url(<?php echo dol_buildpath($path . '/theme/' . $theme . '/img/lock.png', 1); ?>);
background-repeat: no-repeat;
}
/*
.span-icon-user input, .span-icon-password input {
margin-right: 30px;
}
*/

/* ============================================================================== */
/* Menu gauche                                                                    */
/* ============================================================================== */

div.vmenu, td.vmenu {
margin-<?php print $right; ?>: 2px;
padding: 0px;
}

.vmenu {margin-left: 4px;}
.vmenusearchselectcombo {width: 99%;}

.menu_contenu {
padding-top: 4px;
padding-bottom: 3px;
overflow: hidden;
text-overflow: ellipsis;
}
#menu_contenu_logo { padding-right: 4px; }
.companylogo { padding-top: 4px; }
.searchform { padding-top: 8px; }

a.vmenu:link, a.vmenu:visited, a.vmenu:hover, a.vmenu:active { white-space: nowrap; font-family: <?php print $fontlist ?>; text-align: <?php print $left; ?>; }
font.vmenudisabled  { font-size:<?php print $fontsize ?>; font-family: <?php print $fontlist ?>; text-align: <?php print $left; ?>; font-weight: bold; color: #aaa; margin-left: 4px; }
a.vmenu:link, a.vmenu:visited { color: #<?php echo $colortextbackvmenu; ?>; }

a.vsmenu:link, a.vsmenu:visited, a.vsmenu:hover, a.vsmenu:active, span.vsmenu { font-size:<?php print $fontsizesmaller ?>; font-family: <?php print $fontlist ?>; text-align: <?php print $left; ?>; font-weight: normal; color: #202020; margin: 1px 1px 1px 8px; }
font.vsmenudisabled { font-size:<?php print $fontsize ?>; font-family: <?php print $fontlist ?>; text-align: <?php print $left; ?>; font-weight: normal; color: #aaa; }
a.vsmenu:link, a.vsmenu:visited { color: #<?php echo $colortextbackvmenu; ?>; white-space: nowrap; }
font.vsmenudisabledmargin { margin: 1px 1px 1px 8px; }

a.help:link, a.help:visited, a.help:hover, a.help:active, span.help { font-size:<?php print $fontsizesmaller ?>px; font-family: <?php print $fontlist ?>; text-align: <?php print $left; ?>; font-weight: normal; color: #666666; text-decoration: none; }


div.blockvmenupair, div.blockvmenuimpair, div.blockvmenubookmarks
{
font-family: <?php print $fontlist ?>;
color: #000000;
text-align: <?php print $left; ?>;
text-decoration: none;
padding-left: 5px;
padding-right: 1px;
padding-top: 3px;
padding-bottom: 3px;
margin: 1px 0px 8px 0px;

padding-bottom: 10px;
border-bottom: 1px solid #e0e0e0;
}
a.vsmenu.addbookmarkpicto {
padding-right: 10px;
}

div.blockvmenusearch
{
color: #000000;
text-align: <?php print $left; ?>;
text-decoration: none;
padding-left: 5px;
padding-right: 1px;
padding-top: 3px;
padding-bottom: 3px;
margin: 1px 0px 8px 0px;
padding-bottom: 10px;padding-top: 10px;
border-bottom: 1px solid #f4f4f4;border-top: 1px solid #e0e0e0;
}
div.blockvmenusearchphone
{
border-bottom: none;
margin-bottom: 0px;
}

div.blockvmenuhelp
{
<?php if (empty($conf->dol_optimize_smallscreen)) { ?>
	font-family: <?php print $fontlist ?>;
	color: #000000;
	text-align: center;
	text-decoration: none;
	padding-left: 0px;
	padding-right: 8px;
	padding-top: 3px;
	padding-bottom: 3px;
	margin: 4px 0px 0px 0px;
<?php } else { ?>
	display: none;
<?php } ?>
}


td.barre {
border-right: 1px solid #000000;
border-bottom: 1px solid #000000;
background: #b3c5cc;
font-family: <?php print $fontlist ?>;
color: #000000;
text-align: <?php print $left; ?>;
text-decoration: none;
}

td.barre_select {
background: #b3c5cc;
color: #000000;
}

td.photo {
background: #F4F4F4;
color: #000000;
border: 1px solid #bbb;
}

/* ============================================================================== */
/* Panes for Main                                                   */
/* ============================================================================== */

/*
*  PANES and CONTENT-DIVs
*/

#mainContent, #leftContent .ui-layout-pane {
padding:    0px;
overflow:	auto;
}

#mainContent, #leftContent .ui-layout-center {
padding:    0px;
position:   relative; /* contain floated or positioned elements */
overflow:   auto;  /* add scrolling to content-div */
}


/* ============================================================================== */
/* Toolbar for ECM or Filemanager                                                 */
/* ============================================================================== */

.largebutton {
background-image: -o-linear-gradient(bottom, rgba(200,200,200,0.1) 0%, rgba(255,255,255,0.3) 120%) !important;
background-image: -moz-linear-gradient(bottom, rgba(200,200,200,0.1) 0%, rgba(255,255,255,0.3) 120%) !important;
background-image: -webkit-linear-gradient(bottom, rgba(200,200,200,0.1) 0%, rgba(255,255,255,0.3) 120%) !important;
background-image: -ms-linear-gradient(bottom, rgba(200,200,200,0.1) 0%, rgba(255,255,255,0.3) 120%) !important;
background-image: linear-gradient(bottom, rgba(200,200,200,0.1) 0%, rgba(255,255,255,0.3) 120%) !important;

background: #FFF;
background-repeat: repeat-x !important;
border: 1px solid #CCC !important;

-moz-border-radius: 2px 2px 2px 2px !important;
-webkit-border-radius: 2px 2px 2px 2px !important;
border-radius: 2px 2px 2px 2px !important;
-moz-box-shadow: 2px 2px 4px #f4f4f4;
-webkit-box-shadow: 2px 2px 4px #f4f4f4;
box-shadow: 2px 2px 4px #f4f4f4;

padding: 0 4px 0 4px !important;
min-height: 32px;
}


a.toolbarbutton {
margin-top: 0px;
margin-left: 4px;
margin-right: 4px;
height: 30px;
}
img.toolbarbutton {
margin-top: 1px;
height: 30px;
}

/* ============================================================================== */
/* Panes for ECM or Filemanager                                                   */
/* ============================================================================== */

#containerlayout .layout-with-no-border {
border: 0 !important;
border-width: 0 !important;
}

#containerlayout .layout-padding {
padding: 2px !important;
}

/*
*  PANES and CONTENT-DIVs
*/
#containerlayout .ui-layout-pane { /* all 'panes' */
background: #FFF;
border:     1px solid #BBB;
/* DO NOT add scrolling (or padding) to 'panes' that have a content-div,
otherwise you may get double-scrollbars - on the pane AND on the content-div
*/
padding:    0px;
overflow:   auto;
}
/* (scrolling) content-div inside pane allows for fixed header(s) and/or footer(s) */
#containerlayout .ui-layout-content {
padding:    10px;
position:   relative; /* contain floated or positioned elements */
overflow:   auto; /* add scrolling to content-div */
}


/*
*  RESIZER-BARS
*/
.ui-layout-resizer  { /* all 'resizer-bars' */
width: <?php echo (empty($conf->dol_optimize_smallscreen) ? '8' : '24'); ?>px !important;
}
.ui-layout-resizer-hover    {   /* affects both open and closed states */
}
/* NOTE: It looks best when 'hover' and 'dragging' are set to the same color,
otherwise color shifts while dragging when bar can't keep up with mouse */
/*.ui-layout-resizer-open-hover ,*/ /* hover-color to 'resize' */
.ui-layout-resizer-dragging {   /* resizer beging 'dragging' */
background: #f4f4f4;
width: <?php echo (empty($conf->dol_optimize_smallscreen) ? '8' : '24'); ?>px;
}
.ui-layout-resizer-dragging {   /* CLONED resizer being dragged */
border-left:  1px solid #BBB;
border-right: 1px solid #BBB;
}
/* NOTE: Add a 'dragging-limit' color to provide visual feedback when resizer hits min/max size limits */
.ui-layout-resizer-dragging-limit { /* CLONED resizer at min or max size-limit */
background: #E1A4A4; /* red */
}
.ui-layout-resizer-closed {
background-color: #f4f4f4;
}
.ui-layout-resizer-closed:hover {
background-color: #EEDDDD;
}
.ui-layout-resizer-sliding {    /* resizer when pane is 'slid open' */
opacity: .10; /* show only a slight shadow */
}
.ui-layout-resizer-sliding-hover {  /* sliding resizer - hover */
opacity: 1.00; /* on-hover, show the resizer-bar normally */
}
/* sliding resizer - add 'outside-border' to resizer on-hover */
/* this sample illustrates how to target specific panes and states */
/*.ui-layout-resizer-north-sliding-hover  { border-bottom-width:  1px; }
.ui-layout-resizer-south-sliding-hover  { border-top-width:     1px; }
.ui-layout-resizer-west-sliding-hover   { border-right-width:   1px; }
.ui-layout-resizer-east-sliding-hover   { border-left-width:    1px; }
*/

/*
*  TOGGLER-BUTTONS
*/
.ui-layout-toggler {
<?php if (empty($conf->dol_optimize_smallscreen)) { ?>
	border-top: 1px solid #AAA; /* match pane-border */
	border-right: 1px solid #AAA; /* match pane-border */
	border-bottom: 1px solid #AAA; /* match pane-border */
	background-color: #f4f4f4;
	top: 5px !important;
<?php } else { ?>
	diplay: none;
<?php } ?>
}
.ui-layout-toggler-open {
height: 54px !important;
width: <?php echo (empty($conf->dol_optimize_smallscreen) ? '7' : '22'); ?>px !important;
-moz-border-radius:0px 10px 10px 0px;
-webkit-border-radius:0px 10px 10px 0px;
border-radius:0px 10px 10px 0px;
}
.ui-layout-toggler-closed {
height: <?php echo (empty($conf->dol_optimize_smallscreen) ? '54' : '2'); ?>px !important;
width: <?php echo (empty($conf->dol_optimize_smallscreen) ? '7' : '22'); ?>px !important;
-moz-border-radius:0px 10px 10px 0px;
-webkit-border-radius:0px 10px 10px 0px;
border-radius:0px 10px 10px 0px;
}
.ui-layout-toggler .content {	/* style the text we put INSIDE the togglers */
color:          #666;
font-size:      12px;
font-weight:    bold;
width:          100%;
padding-bottom: 0.35ex; /* to 'vertically center' text inside text-span */
}

/* hide the toggler-button when the pane is 'slid open' */
.ui-layout-resizer-sliding .ui-layout-toggler {
display: none;
}

.ui-layout-north {
height: <?php print (empty($conf->dol_optimize_smallscreen) ? '54' : '21'); ?>px !important;
}


/* ECM */

#containerlayout .ecm-layout-pane { /* all 'panes' */
background: #FFF;
border:     1px solid #BBB;
/* DO NOT add scrolling (or padding) to 'panes' that have a content-div,
otherwise you may get double-scrollbars - on the pane AND on the content-div
*/
padding:    0px;
overflow:   auto;
}
/* (scrolling) content-div inside pane allows for fixed header(s) and/or footer(s) */
#containerlayout .ecm-layout-content {
padding:    10px;
position:   relative; /* contain floated or positioned elements */
overflow:   auto; /* add scrolling to content-div */
}

.ecm-layout-toggler {
border-top: 1px solid #AAA; /* match pane-border */
border-right: 1px solid #AAA; /* match pane-border */
border-bottom: 1px solid #AAA; /* match pane-border */
background-color: #CCC;
}
.ecm-layout-toggler-open {
height: 48px !important;
width: 6px !important;
-moz-border-radius:0px 10px 10px 0px;
-webkit-border-radius:0px 10px 10px 0px;
border-radius:0px 10px 10px 0px;
}
.ecm-layout-toggler-closed {
height: 48px !important;
width: 6px !important;
}

.ecm-layout-toggler .content {	/* style the text we put INSIDE the togglers */
color:          #666;
font-size:      12px;
font-weight:    bold;
width:          100%;
padding-bottom: 0.35ex; /* to 'vertically center' text inside text-span */
}
#ecm-layout-west-resizer {
width: 6px !important;
}

.ecm-layout-resizer  { /* all 'resizer-bars' */
border:         1px solid #BBB;
border-width:   0;
}
.ecm-layout-resizer-closed {
}

.ecm-in-layout-center {
border-left: 1px !important;
border-right: 0px !important;
border-top: 0px !important;
}

.ecm-in-layout-south {
border-top: 0px !important;
border-left: 0px !important;
border-right: 0px !important;
border-bottom: 0px !important;
padding: 4px 0 4px 4px !important;
}



/* ============================================================================== */
/* Onglets                                                                        */
/* ============================================================================== */
div.tabs {
text-align: <?php print $left; ?>;
margin-left: 6px !important;
margin-right: 6px !important;
clear:both;
height:100%;
}
div.tabsElem { margin-top: 6px; }		/* To avoid overlap of tabs when not browser */

div.tabBar {
color: #<?php echo $colortextbacktab; ?>;
padding-top: <?php echo ($dol_optimize_smallscreen ? '4' : '16'); ?>px;
padding-left: <?php echo ($dol_optimize_smallscreen ? '4' : '16'); ?>px;
padding-right: <?php echo ($dol_optimize_smallscreen ? '4' : '16'); ?>px;
padding-bottom: <?php echo ($dol_optimize_smallscreen ? '4' : '14'); ?>px;
margin: 0px 0px 14px 0px;
-moz-border-radius:3px;
-webkit-border-radius: 3px;
border-radius: 3px;
border-right: 1px solid #BBB;
border-bottom: 1px solid #BBB;
border-left: 1px solid #BBB;
border-top: 1px solid #CCC;
width: auto;

background: rgb(<?php echo $colorbacktabcard1; ?>);

/*
<?php if (empty($dol_optimize_smallscreen)) { ?>
	-moz-box-shadow: 3px 3px 4px #f4f4f4;
	-webkit-box-shadow: 3px 3px 4px #f4f4f4;
	box-shadow: 3px 3px 4px #f4f4f4;
<?php } ?>
*/
}

div.popuptabset {padding: 6px;background: #fff;border: 1px solid #888;}
div.popuptab {padding-top: 3px;padding-bottom: 3px;padding-left: 5px;padding-right: 5px;}

a.tabTitle {
clear: both;
display: block;

color:rgba(0,0,0,.5);
margin-<?php print $right; ?>: 10px;
text-shadow:1px 1px 1px #ffffff;
font-family: <?php print $fontlist ?>;
font-weight: bold;
padding: 4px 6px 2px 6px;
margin: 0px 6px;
text-decoration: none;
white-space: nowrap;
}

a.tab:link, a.tab:visited, a.tab:hover, a.tab#active {
font-family: <?php print $fontlist ?>;
padding: 7px 9px 7px;
margin: 0em 0.2em;
text-decoration: none;
white-space: nowrap;

/*-moz-border-radius:3px 3px 0px 0px;
-webkit-border-radius:3px 3px 0px 0px;
border-radius:3px 3px 0px 0px;

-moz-box-shadow: 0 -1px 4px rgba(0,0,0,.1);
-webkit-box-shadow: 0 -1px 4px rgba(0,0,0,.1);
box-shadow: 0 -1px 4px rgba(0,0,0,.1);

border-bottom: none;
border-right: 1px solid #CCCCCC;
border-left: 1px solid #f4f4f4;
border-top: 1px solid #D8D8D8;
*/

background-image: none !important;
}


.tabunactive {	/* We add some border on tabunactive to avoid change of position of title when switching tabs (border of tabunactive = border of tabactive) */
border-right: 1px solid rgb(<?php echo $colorbackbody; ?>);
border-left: 1px solid rgb(<?php echo $colorbackbody; ?>);
}

.tabactive, a.tab#active {
color: #<?php echo $colortextbacktab; ?> !important;
background: rgb(<?php echo $colorbacktabcard1; ?>) !important;

border-right: 1px solid #AAA !important;
border-left: 1px solid #AAA !important;
border-top: 2px solid #111 !important;
/*
-moz-box-shadow: 0 -1px 4px rgba(0,0,0,.1);
-webkit-box-shadow: 0 -1px 4px rgba(0,0,0,.1);
box-shadow: 0 -1px 4px rgba(0,0,0,.1);

-moz-border-radius:3px 3px 0px 0px;
-webkit-border-radius:3px 3px 0px 0px;
border-radius:3px 3px 0px 0px;
*/
}
a.tab:hover
{
/*
background: rgba(<?php echo $colorbacktabcard1; ?>, 0.5)  url(<?php echo dol_buildpath($path . '/theme/' . $theme . '/img/nav-overlay3.png', 1); ?>) 50% 0 repeat-x;
color: #<?php echo $colortextbacktab; ?>;
*/
text-decoration: underline;
}
a.tabimage {
color: #434956;
font-family: <?php print $fontlist ?>;
text-decoration: none;
white-space: nowrap;
}

td.tab {
background: #dee7ec;
}

span.tabspan {
background: #dee7ec;
color: #434956;
font-family: <?php print $fontlist ?>;
padding: 0px 6px;
margin: 0em 0.2em;
text-decoration: none;
white-space: nowrap;
-moz-border-radius:3px 3px 0px 0px;
-webkit-border-radius:3px 3px 0px 0px;
border-radius:3px 3px 0px 0px;

border-<?php print $right; ?>: 1px solid #555555;
border-<?php print $left; ?>: 1px solid #D8D8D8;
border-top: 1px solid #D8D8D8;
}

/* ============================================================================== */
/* Boutons actions                                                                */
/* ============================================================================== */

div.divButAction {
vertical-align: top;
}

span.butAction, span.butActionDelete {
cursor: pointer;
}


/* Prepare for bootstrap look */
.button, .butAction, .butActionDelete, .butActionRefused {
border-color: #c5c5c5;
border-color: rgba(0, 0, 0, 0.15) rgba(0, 0, 0, 0.15) rgba(0, 0, 0, 0.25);
display: inline-block;
padding: 0.4em 0.7em;
margin: 0.4em 0.9em !important;
line-height: 20px;
text-align: center;
vertical-align: middle;
cursor: pointer;
color: #333333 !important;
text-decoration: none !important;
text-shadow: 0 1px 1px rgba(255, 255, 255, 0.75);
background-color: #f5f5f5;
background-image: -moz-linear-gradient(top, #ffffff, #e6e6e6);
background-image: -webkit-gradient(linear, 0 0, 0 100%, from(#ffffff), to(#e6e6e6));
background-image: -webkit-linear-gradient(top, #ffffff, #e6e6e6);
background-image: -o-linear-gradient(top, #ffffff, #e6e6e6);
background-image: linear-gradient(to bottom, #ffffff, #e6e6e6);
background-repeat: repeat-x;
border-color: #e6e6e6 #e6e6e6 #bfbfbf;
border-color: rgba(0, 0, 0, 0.1) rgba(0, 0, 0, 0.1) rgba(0, 0, 0, 0.25);
border: 1px solid #bbbbbb;
border-bottom-color: #a2a2a2;
border-radius: 2px;
box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.2), 0 1px 2px rgba(0, 0, 0, 0.05);
}

.butAction {
color: #ffffff !important;
text-shadow: 0 -1px 0 rgba(0, 0, 0, 0.25);
background-color: #006dcc;
background-image: -moz-linear-gradient(top, #0088cc, #0044cc);
background-image: -webkit-gradient(linear, 0 0, 0 100%, from(#0088cc), to(#0044cc));
background-image: -webkit-linear-gradient(top, #0088cc, #0044cc);
background-image: -o-linear-gradient(top, #0088cc, #0044cc);
background-image: linear-gradient(to bottom, #0088cc, #0044cc);
background-repeat: repeat-x;
border-color: #0044cc #0044cc #002a80;
border-color: rgba(0, 0, 0, 0.1) rgba(0, 0, 0, 0.1) rgba(0, 0, 0, 0.25);
}
.button:disabled, .butAction:disabled {
color: #666 !important;
text-shadow: none;
border-color: #555;
cursor: not-allowed;

background-color: #f5f5f5;
background-image: -moz-linear-gradient(top, #ffffff, #e6e6e6);
background-image: -webkit-gradient(linear, 0 0, 0 100%, from(#ffffff), to(#e6e6e6));
background-image: -webkit-linear-gradient(top, #ffffff, #e6e6e6);
background-image: -o-linear-gradient(top, #ffffff, #e6e6e6);
background-image: linear-gradient(to bottom, #ffffff, #e6e6e6);
background-repeat: repeat-x
}

.butActionDelete, .buttonDelete {
color: #ffffff !important;
text-shadow: 0 -1px 0 rgba(0, 0, 0, 0.25);
background-color: #cc6d00;
background-image: -moz-linear-gradient(top, #cc8800, #cc4400);
background-image: -webkit-gradient(linear, 0 0, 0 100%, from(#cc8800), to(#cc4400));
background-image: -webkit-linear-gradient(top, #cc8800, #cc4400);
background-image: -o-linear-gradient(top, #cc8800, #cc4400);
background-image: linear-gradient(to bottom, #cc8800, #cc4400);
background-repeat: repeat-x;
border-color: #cc4400 #cc4400 #802a00;
border-color: rgba(0, 0, 0, 0.1) rgba(0, 0, 0, 0.1) rgba(0, 0, 0, 0.25);
}
a.butAction:link, a.butAction:visited, a.butAction:hover, a.butAction:active {
color: #FFFFFF;
}

.butActionRefused {
color: #AAAAAA !important;
cursor: not-allowed !important;
}

a.butAction:hover, a.butActionDelete:hover, a.butActionRefused:hover {
text-decoration: none;
}
a.butAction:hover, a.butActionDelete:hover {
opacity: 0.9;
}

/* End bootstrap */

<?php if (!empty($conf->global->MAIN_BUTTON_HIDE_UNAUTHORIZED)) { ?>
	.butActionRefused {
	display: none;
	}
<?php } ?>



/* ============================================================================== */
/* Tables                                                                         */
/* ============================================================================== */

.allwidth {
width: 100%;
}

#undertopmenu {
background-repeat: repeat-x;
margin-top: 6px;
}


.paddingrightonly {
border-collapse: collapse;
border: 0px;
margin-left: 0px;
padding-<?php print $left; ?>: 0px !important;
padding-<?php print $right; ?>: 4px !important;
}
.nocellnopadd {
list-style-type:none;
margin: 0px !important;
padding: 0px !important;
}
tr.nocellnopadd td.nobordernopadding, tr.nocellnopadd td.nocellnopadd
{
border: 0px;
}

.notopnoleft {
border-collapse: collapse;
border: 0px;
padding-top: 0px;
padding-<?php print $left; ?>: 0px;
padding-<?php print $right; ?>: 16px;
padding-bottom: 4px;
margin-right: 0px 0px;
}
.notopnoleftnoright {border: 0px;padding: 0;margin: 0 0 2em 0 !important;}


table.border, table.dataTable, .table-border, .table-border-col, .table-key-border-col, .table-val-border-col, div.border {
<?php if (empty($noborderline)) { ?>
	border: 1px solid #f4f4f4;
<?php } ?>
border-collapse: collapse !important;
padding: 1px 2px 1px 3px;			/* t r b l */
}
table.borderplus {
border: 1px solid #BBB;
}

.border tbody tr, .border tbody tr td, div.tabBar table.border tr {
height: 20px;
}

table.border td, div.border div div.tagtd {
padding: 2px 2px 2px 2px;
border: 1px solid #f0f0f0;
border-collapse: collapse;
}

td.border, div.tagtable div div.border {
border-top: 1px solid #000000;
border-right: 1px solid #000000;
border-bottom: 1px solid #000000;
border-left: 1px solid #000000;
}

.table-key-border-col {
/* width: 25%; */
vertical-align:top;
}
.table-val-border-col {
width:auto;
}


/* Main boxes */

table.liste, table.noborder, table.formdoc, div.noborder {
width: 100%;
/*min-width: 515px;*/
border-collapse: separate !important;
border-spacing: 0px;

border-top-width: <?php echo $borderwith ?>px;
border-top-color: rgb(<?php echo $colortopbordertitle1 ?>);
border-top-style: solid;

border-bottom-width: 1px;
border-bottom-color: #BBB;
border-bottom-style: solid;

margin: 0px 0px 8px 0px;

-moz-border-radius: 0.1em;
-webkit-border-radius: 0.1em;
border-radius: 0.1em;
}
table.noborder tr, div.noborder form {
border-top-color: #FEFEFE;

border-right-width: 1px;
border-right-color: #BBBBBB;
border-right-style: solid;

border-left-width: 1px;
border-left-color: #BBBBBB;
border-left-style: solid;
height: 3em;
}
table.paddingtopbottomonly tr td {
padding-top: 1px;
padding-bottom: 2px;
}

.liste_titre_add td, .liste_titre_add th, .liste_titre_add .tagtd
{
border-top-width: 2px;
border-top-color: rgb(<?php echo $colortopbordertitle1 ?>);
border-top-style: solid;
}
.liste_titre_add td, .liste_titre_add .tagtd
{
border-top-width: 1px;
border-top-color: rgb(<?php echo $colortopbordertitle1 ?>);
border-top-style: solid;
}

table.liste th, table.noborder th, table.nobordernopadding tr td{
padding: 8px 1em;			/* t r b l */
}

div.noborder form, div.noborder form div {
padding: 4px 3px 4px 3px;			/* t r b l */
}

table.liste td, div.noborder form div {padding: 0.7em}
div.liste_titre_bydiv .divsearchfield {
padding: 2px 1px 2px 0px;			/* t r b l */
}

table.nobordernopadding {
border-collapse: collapse !important;
border: 0px;
}
table.nobordernopadding tr {
border: 0px !important;
padding: 0px 0px !important;
}
table.nobordernopadding tr td {
border: 0px;
height: 21px;
}
table.border tr td table.nobordernopadding tr td {
padding-top: 0px;
padding-bottom: 0px;
}
td.borderright {
border: none;	/* to erase value for table.nobordernopadding td */
border-right-width: 1px !important;
border-right-color: #BBB !important;
border-right-style: solid !important;
}

/* For table with no filter before */
table.listwithfilterbefore {
border-top: none !important;
}

.tagtable, .table-border { display: table; }
.tagtr, .table-border-row  { display: table-row; }
.tagtd, .table-border-col, .table-key-border-col, .table-val-border-col { display: table-cell; }

/* Pagination */
div.refidpadding  {
padding-top: 3px;
}
div.refid  {
color: #766;

}

div.pagination li.litext a {
border: none;
padding-right: 10px;
padding-left: 4px;
font-weight: bold;
}
div.pagination li.noborder a:hover {
border: none;
background-color: transparent;
}
div.pagination li a,
div.pagination li span {
	padding: 0.4em;
}
div.pagination li:first-child a,
div.pagination li:first-child span {
margin-left: 0;
border-top-left-radius: 4px;
border-bottom-left-radius: 4px;
}

div.pagination li a:hover,
div.pagination li span:hover,
div.pagination li a:focus,
div.pagination li span:focus {
color: #000;
background-color: #eee;
border-color: #ddd;
}
div.pagination li .active a,
div.pagination li .active span,
div.pagination li .active a:hover,
div.pagination li .active span:hover,
div.pagination li .active a:focus,
div.pagination li .active span:focus {
z-index: 2;
color: #fff;
cursor: default;
background-color: <?php $colorbackhmenu1 ?>;
border-color: #337ab7;
}
div.pagination .disabled span,
div.pagination .disabled span:hover,
div.pagination .disabled span:focus,
div.pagination .disabled a,
div.pagination .disabled a:hover,
div.pagination .disabled a:focus {
color: #777;
cursor: not-allowed;
background-color: #fff;
border-color: #ddd;
}
div.pagination li.pagination .active {
text-decoration: underline;
}
div.pagination li.paginationafterarrows {
margin-left: 10px;
}
.paginationatbottom {
margin-top: 9px;
}

/* Prepare to remove class pair - impair
.noborder > tbody > tr:nth-child(even) td {
background: linear-gradient(bottom, rgb(<?php echo $colorbacklineimpair1; ?>) 85%, rgb(<?php echo $colorbacklineimpair2; ?>) 100%);
background: -o-linear-gradient(bottom, rgb(<?php echo $colorbacklineimpair1; ?>) 85%, rgb(<?php echo $colorbacklineimpair2; ?>) 100%);
background: -moz-linear-gradient(bottom, rgb(<?php echo $colorbacklineimpair1; ?>) 85%, rgb(<?php echo $colorbacklineimpair2; ?>) 100%);
background: -webkit-linear-gradient(bottom, rgb(<?php echo $colorbacklineimpair1; ?>) 85%, rgb(<?php echo $colorbacklineimpair2; ?>) 100%);
background: -ms-linear-gradient(bottom, rgb(<?php echo $colorbacklineimpair1; ?>) 85%, rgb(<?php echo $colorbacklineimpair2; ?>) 100%);
font-family: <?php print $fontlist ?>;
border: 0px;
margin-bottom: 1px;
color: #202020;
min-height: 18px;
}

.noborder > tbody > tr:nth-child(odd) td {
background: linear-gradient(bottom, rgb(<?php echo $colorbacklinepair1; ?>) 85%, rgb(<?php echo $colorbacklinepair2; ?>) 100%);
background: -o-linear-gradient(bottom, rgb(<?php echo $colorbacklinepair1; ?>) 85%, rgb(<?php echo $colorbacklinepair2; ?>) 100%);
background: -moz-linear-gradient(bottom, rgb(<?php echo $colorbacklinepair1; ?>) 85%, rgb(<?php echo $colorbacklinepair2; ?>) 100%);
background: -webkit-linear-gradient(bottom, rgb(<?php echo $colorbacklinepair1; ?>) 85%, rgb(<?php echo $colorbacklinepair2; ?>) 100%);
background: -ms-linear-gradient(bottom, rgb(<?php echo $colorbacklinepair1; ?>) 85%, rgb(<?php echo $colorbacklinepair2; ?>) 100%);
font-family: <?php print $fontlist ?>;
border: 0px;
margin-bottom: 1px;
color: #202020;
}
*/

/* Set the color for hover lines */
.noborder > tbody > tr:nth-child(2n+1):not(.liste_titre), .liste > tbody > tr:nth-child(2n+1):not(.liste_titre), div:not(.fichecenter):not(.fichehalfleft):not(.fichehalfright):not(.ficheaddleft) > .border > tbody > tr:nth-of-type(2n+1):not(.liste_titre), .liste > tbody > tr:nth-of-type(2n+1):not(.liste_titre), div:not(.fichecenter):not(.fichehalfleft):not(.fichehalfright):not(.ficheaddleft) .oddeven.tagtr:nth-of-type(2n+1):not(.liste_titre){
background-color: rgb(240,240,240);}

.oddeven:hover {opacity: 0.6;/*color: #ccc;*/}
.oddeven.nohover:hover {opacity: 1;}
.oddeven.tredited:hover {opacity: 1;}
.odd:hover, .impair:hover, .even:hover, .pair:hover, .even:hover, .pair:hover, table.dataTable tr.even:hover, table.dataTable tr.odd:hover, .box_pair:hover, .box_impair:hover
{
<?php if ($colorbacklinepairhover) { ?>
	background: rgb(<?php echo $colorbacklinepairhover; ?>) !important;
<?php } ?>
}

.odd, .impair, .nohover .odd:hover, .nohover .impair:hover, tr.odd td.nohover, tr.impair td.nohover,  tr.box_pair td.nohover, tr.box_impair td.nohover
{
font-family: <?php print $fontlist ?>;
border: 0px;
margin-bottom: 1px;
color: #202020;
min-height: 18px; /* seems to not be used */

background: #<?php echo colorArrayToHex(colorStringToArray($colorbacklineimpair1)); ?>;
}
#GanttChartDIV {
background: #<?php echo colorArrayToHex(colorStringToArray($colorbacklineimpair1)); ?>;
}

.even, .pair, .nohover .even:hover, .nohover .pair:hover, tr.even td.nohover, tr.pair td.nohover {
font-family: <?php print $fontlist ?>;
margin-bottom: 1px;
color: #202020;

background-color: #<?php echo colorArrayToHex(colorStringToArray($colorbacklinepair1)); ?>;
}
table.dataTable tr.odd {
background-color: #<?php echo colorArrayToHex(colorStringToArray($colorbacklinepair1)); ?> !important;
}

/* For no hover style */
table.nohover tr.impair, table.nohover tr.pair, table.nohover tr.impair td, table.nohover tr.pair td, tr.nohover td, form.nohover, form.nohover:hover {
background-color: #<?php echo colorArrayToHex(colorStringToArray($colorbacklineimpair1)); ?> !important;
}
tr.nohoverpair td {
background-color: #<?php echo colorArrayToHex(colorStringToArray($colorbacklinepair1)); ?> !important;
}

table.dataTable td {
padding: 5px 2px 5px 3px !important;
}
tr.even td, tr.pair td, tr.odd td, tr.impair td, form.odd div.tagtd, form.impair div.tagtd, form.pair div.tagtd, div.impair div.tagtd, div.pair div.tagtd, div.liste_titre div.tagtd {
padding: 5px 2px 5px 3px;
border-bottom: 1px solid #eee;
}
form.pair, form.impair {
font-weight: normal;
}
tr.even:last-of-type td, tr.pair:last-of-type td, tr.odd:last-of-type td, tr.impair:last-of-type td {
border-bottom: 0px !important;
}
tr.even td .nobordernopadding tr td, tr.pair td .nobordernopadding tr td, tr.impair td .nobordernopadding tr td, tr.odd td .nobordernopadding tr td {
border-bottom: 0px !important;
}
td.nobottom, td.nobottom {
border-bottom: 0px !important;
}
div.liste_titre .tagtd {
vertical-align: middle;
}
div.liste_titre {
min-height: 26px !important;	/* We cant use height because it's a div and it should be higher if content is more. but min-height doe not work either for div */

padding-top: 2px;
padding-bottom: 2px;

/*border-right-width: 1px;
border-right-color: #BBB;
border-right-style: solid;

border-left-width: 1px;
border-left-color: #BBB;
border-left-style: solid;*/

border-top-width: 1px;
border-top-color: #BBB;
border-top-style: solid;
}
div.liste_titre_bydiv {
border-top-width: <?php echo $borderwith ?>px;
border-top-color: rgb(<?php echo $colortopbordertitle1 ?>);
border-top-style: solid;

box-shadow: none;
border-collapse: collapse;
display: table;
padding: 2px 0px 2px 0;
width: 100%;
}
tr.liste_titre, tr.liste_titre_sel, form.liste_titre, form.liste_titre_sel, table.dataTable.tr{height: 40px !important;}
tr.liste_titre_filter, div.liste_titre, tr.liste_titre, tr.liste_titre_sel, form.liste_titre, form.liste_titre_sel, table.dataTable thead tr
{
<?php if ($usegradient) { ?>
	background-image: -o-linear-gradient(bottom, rgba(0,0,0,0.1) 0%, rgba(250,250,250,0.3) 100%);
	background-image: -moz-linear-gradient(bottom, rgba(0,0,0,0.1) 0%, rgba(250,250,250,0.3) 100%);
	background-image: -webkit-linear-gradient(bottom, rgba(0,0,0,0.1) 0%, rgba(250,250,250,0.3) 100%);
	background-image: -ms-linear-gradient(bottom, rgba(0,0,0,0.1) 0%, rgba(250,250,250,0.3) 100%);
	background-image: linear-gradient(bottom, rgba(0,0,0,0.1) 0%, rgba(250,250,250,0.3) 100%);
<?php } else { ?>
	background: rgb(<?php echo $colorbacktitle1; ?>)!important;
<?php } ?>
font-weight: <?php echo $useboldtitle ? 'bold' : 'normal'; ?>;

color: rgb(<?php echo $colortexttitle; ?>);
font-family: <?php print $fontlist ?>;
border-bottom: 1px solid #FDFFFF;
text-align: left;
}
tr.liste_titre th, tr.liste_titre td, th.liste_titre, form.liste_titre div, div.liste_titre
{
border-bottom: 1px solid #<?php echo ($colorbacktitle1 == '255,255,255' ? 'BBBBBB' : 'FDFFFF'); ?>;
}
tr.liste_titre th, th.liste_titre, tr.liste_titre td, td.liste_titre, form.liste_titre div, div.liste_titre
{
font-family: <?php print $fontlist ?>;
font-weight: <?php echo $useboldtitle ? 'bold' : 'normal'; ?>;
vertical-align: middle;
}
tr.liste_titre th a, th.liste_titre a, tr.liste_titre td a, td.liste_titre a, form.liste_titre div a, div.liste_titre a {
text-shadow: none !important;
}
tr.liste_titre_topborder td {
border-top-width: <?php echo $borderwith; ?>px;
border-top-color: rgb(<?php echo $colortopbordertitle1 ?>);
border-top-style: solid;
}
.liste_titre td a {
text-shadow: none !important;
color: rgb(<?php echo $colortexttitle; ?>);
}
.liste_titre td a.notasortlink {
color: rgb(<?php echo $colortextlink; ?>);
}
.liste_titre td a.notasortlink:hover {
background: transparent;
}
tr.liste_titre td.liste_titre {		/* For last line of table headers only */
border-bottom: 1px solid rgb(<?php echo $colortopbordertitle1 ?>);
}

div.liste_titre {
padding-left: 3px;
}
tr.liste_titre_sel th, th.liste_titre_sel, tr.liste_titre_sel td, td.liste_titre_sel, form.liste_titre_sel div
{
font-family: <?php print $fontlist ?>;
font-weight: normal;
border-bottom: 1px solid #FDFFFF;
text-decoration: underline;
}
input.liste_titre {
background: transparent;
border: 0px;
}

.noborder tr.liste_total, .noborder tr.liste_total td, tr.liste_total, form.liste_total {height: 3em;}
.noborder tr.liste_total td, tr.liste_total td, form.liste_total div {
/* border-top: 1px solid #f4f4f4; */
color: #332266;
font-weight: normal;
white-space: nowrap;
padding: 4px;
height: 20px;
}
tr.liste_sub_total, tr.liste_sub_total td {
border-bottom: 2px solid #aaa;
}

.tableforservicepart1 .impair, .tableforservicepart1 .pair, .tableforservicepart2 .impair, .tableforservicepart2 .pair {
background: #FFF;
}
.tableforservicepart1 tbody tr td, .tableforservicepart2 tbody tr td {
border-bottom: none;
}

.paymenttable, .margintable {
border-top-width: <?php echo $borderwith ?>px !important;
border-top-color: rgb(<?php echo $colortopbordertitle1 ?>) !important;
border-top-style: solid !important;
margin: 0px 0px 0px 0px !important;
}
.paymenttable tr td:first-child, .margintable tr td:first-child
{
padding-left: 2px;
}
.margintable td {
border: 0px !important;
}

/* Disable shadows */
.noshadow {
-moz-box-shadow: 0px 0px 0px #f4f4f4 !important;
-webkit-box-shadow: 0px 0px 0px #f4f4f4 !important;
box-shadow: 0px 0px 0px #f4f4f4 !important;
}

div.tabBar .noborder {border: 2px solid rgb(240,240,240);
/*-moz-box-shadow: 0px 0px 0px #f4f4f4 !important;
-webkit-box-shadow: 0px 0px 0px #f4f4f4 !important;
box-shadow: 0px 0px 0px #f4f4f4 !important;*/
}
div .tdtop {
vertical-align: top !important;
padding-top: 5px !important;
padding-bottom: 0px;
}

#tablelines tr.liste_titre td, .paymenttable tr.liste_titre td, .margintable tr.liste_titre td, .tableforservicepart1 tr.liste_titre td {
border-bottom: 1px solid #AAA !important;
}


/*
*  Boxes
*/
.boxtable br {margin: 0.2em 0;}
.boxstats, .boxstats130 {
display: inline-block;
margin: 3px;
padding: 3px 0;vertical-align: super;
box-shadow: 3px 3px 4px #f4f4f4;
text-align: center;
text-overflow: ellipsis;
width: 120px;
}
.boxstatsindicator.thumbstat150 { width: 11em;position: relative;}
.boxstats130 {width: inherit;height: 7em;border-radius: 2px;border: 1px solid #CCC;box-shadow: none;}
.valignmiddle.dashboardlineindicator {

    position: absolute;
    bottom: 4px;

}
span.boxstatstext img.inline-block {
    display: block;
    margin: -15px auto 5px auto;
    border: 1px solid #ccc;
    background: #FFF;
}
@media only screen and (max-width: 767px)
{
.boxstats, .boxstats130 {width: 100px;}
}

.boxstats:hover, .boxstats130:hover  {
box-shadow: 0px 0px 8px 0px rgba(0,0,0,0.20);
}
span.boxstatstext {line-height: 18px;clear: right;display: block;}
span.boxstatstext + br {width: 100%;display: block;}
a.dashboardlineindicatorlate.dashboardlineko {position: absolute;bottom: 4px;}
/*.tdboxstats.nohover.flexcontainer {display: flow-root;flex-wrap: wrap;}*/
.tdboxstats.nohover.flexcontainer .boxstatsindicator.thumbstat {margin: 0;}
span.boxstatsindicator {
font-size: 110%;
font-weight: normal;
}
span.dashboardlineindicator, span.dashboardlineindicatorlate {
font-size: 120%;
font-weight: bold;
}
span.dashboardlineok {
color: #008800;
}
span.dashboardlineko {
color: #880000;
font-weight: bold;
}
.boxtable {
margin-bottom: 8px !important;
}
.tdboxstats {
text-align: center;
}

.box {
padding-right: 0px;
padding-left: 0px;
padding-bottom: 12px;
}
.dashboardlineindicatorlate.dashboardlineko {margin: -24px 0 0 45px;display: block;background-color: #FFF;}
span.dashboardlineindicator {margin: 0 40px 0 0;}
a.dashboardlineindicatorlate img {margin: 0 0 0 2px;}
 a span.dashboardlineindicator.dashboardlineok {margin: 0;}
span.dashboardlineindicator.dashboardlineok {margin: 0;}
tr.box_titre {
height: 26px !important;

/* TO MATCH BOOTSTRAP */
/*background: #ddd;
color: #000 !important; */

/* TO MATCH ELDY */
<?php if ($usegradient) { ?>
	background-image: -o-linear-gradient(bottom, rgba(0,0,0,0.1) 0%, rgba(250,250,250,0.3) 100%);
	background-image: -moz-linear-gradient(bottom, rgba(0,0,0,0.1) 0%, rgba(250,250,250,0.3) 100%);
	background-image: -webkit-linear-gradient(bottom, rgba(0,0,0,0.1) 0%, rgba(250,250,250,0.3) 100%);
	background-image: -ms-linear-gradient(bottom, rgba(0,0,0,0.1) 0%, rgba(250,250,250,0.3) 100%);
	background-image: linear-gradient(bottom, rgba(0,0,0,0.1) 0%, rgba(250,250,250,0.3) 100%);
<?php } else { ?>
	background: rgb(<?php echo $colorbacktitle1; ?>);
<?php } ?>

background-repeat: repeat-x;
color: rgb(<?php echo $colortexttitle; ?>);
font-family: <?php print $fontlist ?>, sans-serif;
font-weight: <?php echo $useboldtitle ? 'bold' : 'normal'; ?>;
border-bottom: 1px solid #FDFFFF;
white-space: nowrap;
}

tr.box_titre td.boxclose {
width: 30px;
}

tr.box_impair {
background: -o-linear-gradient(bottom, rgb(<?php echo $colorbacklineimpair1; ?>) 85%, rgb(<?php echo $colorbacklineimpair2; ?>) 100%);
background: -moz-linear-gradient(bottom, rgb(<?php echo $colorbacklineimpair1; ?>) 85%, rgb(<?php echo $colorbacklineimpair2; ?>) 100%);
background: -webkit-linear-gradient(bottom, rgb(<?php echo $colorbacklineimpair1; ?>) 85%, rgb(<?php echo $colorbacklineimpair2; ?>) 100%);
background: -ms-linear-gradient(bottom, rgb(<?php echo $colorbacklineimpair1; ?>) 85%, rgb(<?php echo $colorbacklineimpair2; ?>) 100%);
background: linear-gradient(bottom, rgb(<?php echo $colorbacklineimpair1; ?>) 85%, rgb(<?php echo $colorbacklineimpair2; ?>) 100%);
font-family: <?php print $fontlist ?>;
}

tr.box_pair {
font-family: <?php print $fontlist ?>;

background-color: #f9f9f9;
}

tr.box_pair td, tr.box_impair td {
padding: 4px;
}
tr.box_pair:not(:last-child) td, tr.box_impair:not(:last-child) td {
border-bottom: 1px solid #eee;
}
.noborderbottom {
border-bottom: none !important;
}

.formboxfilter {
vertical-align: middle;
margin-bottom: 6px;
}
.formboxfilter input[type=image]
{
top: 5px;
position: relative;
}
.boxfilter {
margin-bottom: 2px;
margin-right: 1px;
}

.prod_entry_mode_free, .prod_entry_mode_predef {
height: 26px !important;
vertical-align: middle;
}





/*
*   Ok, Warning, Error
*/
.ok      { color: #114466; }
.warning { color: #887711; }
.error   { color: #550000 !important; font-weight: bold; }

div.ok {
color: #114466;
}

/* Warning message */
div.warning {
color: #302020;
padding: 0.3em 0.3em 0.3em 0.3em;
margin: 0.5em 0em 0.5em 0em;
border: 1px solid #e0d0b0;
-moz-border-radius:3px;
-webkit-border-radius: 3px;
border-radius: 3px;
background: #EFDF9A;
text-shadow: 0 1px 0 rgba(255, 255, 255, 0.5);
}

/* Error message */
div.error {
color: #550000; font-weight: bold;
padding: 0.3em 0.3em 0.3em 0.3em;
margin: 0.5em 0em 0.5em 0em;
border: 1px solid #DC9CAB;
-moz-border-radius:3px;
-webkit-border-radius: 3px;
border-radius: 3px;
background: #EFCFCF;
}

/* Info admin */
div.info {
color: #303035;
padding: 0.4em 0.4em 0.4em 0.4em;
margin: 0.5em 0em 0.5em 0em;
border: 1px solid #e0e0e0;
-moz-border-radius: 4px;
-webkit-border-radius: 4px;
border-radius: 4px;
background: #EaE4Ea;
text-shadow: 0 1px 0 rgba(255, 255, 255, 0.5);
}

div.warning a, div.info a, div.error a {
color: rgb(<?php echo $colortext; ?>);
}

/*
*   Liens Payes/Non payes
*/

a.normal:link { font-weight: normal }
a.normal:visited { font-weight: normal }
a.normal:active { font-weight: normal }
a.normal:hover { font-weight: normal }

a.impayee:link { font-weight: bold; color: #550000; }
a.impayee:visited { font-weight: bold; color: #550000; }
a.impayee:active { font-weight: bold; color: #550000; }
a.impayee:hover { font-weight: bold; color: #550000; }



/*
*  Other
*/

.product_line_stock_ok { color: #002200; }
.product_line_stock_too_low { color: #664400; }

.fieldrequired { font-weight: bold; color: #000055; }
.widthpictotitle { width: 47px; text-align: left;}

.dolgraphtitle { margin-top: 6px; margin-bottom: 4px; }
.dolgraphtitlecssboxes { margin: 0px; }
.legendColorBox, .legendLabel { border: none !important; }
div.dolgraph div.legend, div.dolgraph div.legend div { background-color: rgba(255,255,255,0) !important; }
div.dolgraph div.legend table tbody tr { height: auto; }
td.legendColorBox { padding: 2px 2px 2px 0 !important; }
td.legendLabel { padding: 2px 2px 2px 0 !important; }

.photo {
border: 0px;
}
.photowithmargin {
margin-bottom: 2px;
margin-top: 2px;
}
.photowithmargin {
/*	-webkit-box-shadow: 0px 0px 3px #777;
-moz-box-shadow: 0px 0px 3px #777;
box-shadow: 0px 0px 3px #777;*/
}
.photointoolitp {
margin-top: 8px;
float: left;
/*text-align: center; */
}
.photodelete {
margin-top: 6px !important;
}

.logo_setup
{
content:url(<?php echo dol_buildpath($path . '/theme/' . $theme . '/img/logo_setup.svg', 1) ?>);	/* content is used to best fit the container */
display: inline-block;
}
.nographyet
{
content:url(<?php echo dol_buildpath($path . '/theme/' . $theme . '/img/nographyet.svg', 1) ?>);
display: inline-block;
opacity: 0.1;
background-repeat: no-repeat;
}
.nographyettext
{
opacity: 0.5;
}

div.titre {
font-family: <?php print $fontlist ?>;
font-weight: bold;
color: rgb(<?php print $colortexttitlenotab; ?>);
text-decoration: none;
/* text-shadow: 1px 1px 2px #FFFFFF; */
<?php print (empty($conf->dol_optimize_smallscreen) ? '' : 'margin-top: 4px;'); ?>
}

#dolpaymenttable { width: 600px; font-size: 13px; }
#tablepublicpayment { border: 1px solid #CCCCCC !important; width: 100%; }
#tablepublicpayment .CTableRow1  { background-color: #F0F0F0 !important; }
#tablepublicpayment tr.liste_total { border-bottom: 1px solid #CCCCCC !important; }
#tablepublicpayment tr.liste_total td { border-top: none; }

#divsubscribe { width: 700px; }
#tablesubscribe { width: 100%; }


/*
* Effect Postit
*/
.effectpostit
{
position: relative;
}
.effectpostit:before, .effectpostit:after
{
z-index: -1;
position: absolute;
content: "";
bottom: 15px;
left: 10px;
width: 50%;
top: 80%;
max-width:300px;
background: #777;
-webkit-box-shadow: 0 15px 10px #777;
-moz-box-shadow: 0 15px 10px #777;
box-shadow: 0 15px 10px #777;
-webkit-transform: rotate(-3deg);
-moz-transform: rotate(-3deg);
-o-transform: rotate(-3deg);
-ms-transform: rotate(-3deg);
transform: rotate(-3deg);
}
.effectpostit:after
{
-webkit-transform: rotate(3deg);
-moz-transform: rotate(3deg);
-o-transform: rotate(3deg);
-ms-transform: rotate(3deg);
transform: rotate(3deg);
right: 10px;
left: auto;
}



/* ============================================================================== */
/* Formulaire confirmation (When Ajax JQuery is used)                             */
/* ============================================================================== */

.ui-dialog-titlebar {
}
.ui-dialog-content {
font-size: 1.5em !important;
}

/* ============================================================================== */
/* Formulaire confirmation (When HTML is used)                                    */
/* ============================================================================== */

table.valid {
border-top: solid 1px #E6E6E6;
border-<?php print $left; ?>: solid 1px #E6E6E6;
border-<?php print $right; ?>: solid 1px #444444;
border-bottom: solid 1px #555555;
padding-top: 0px;
padding-left: 0px;
padding-right: 0px;
padding-bottom: 0px;
margin: 0px 0px;
background: #D5BAA8;
}

.validtitre {
background: #D5BAA8;
font-weight: bold;
}


/* ============================================================================== */
/* Tooltips                                                                       */
/* ============================================================================== */

#tooltip {
position: absolute;
width: <?php print dol_size(450, 'width'); ?>px;
border-top: solid 1px #BBBBBB;
border-<?php print $left; ?>: solid 1px #BBBBBB;
border-<?php print $right; ?>: solid 1px #444444;
border-bottom: solid 1px #444444;
padding: 2px;
z-index: 3000;
background-color: #EFCFAA;
opacity: 1;
-moz-border-radius:0px;
-webkit-border-radius: 0px;
border-radius: 0px;
}

#tiptip_content {
-moz-border-radius:0px;
-webkit-border-radius: 0px;
border-radius: 0px;
background-color: rgb(255,255,255);
/*    background-color: rgb(252,248,246);
background-color: rgba(252,248,246,0.95);*/
line-height: 1.4em;
min-width: 200px;
}

/* ============================================================================== */
/* Calendar                                                                       */
/* ============================================================================== */

img.datecallink { padding-left: 2px !important; padding-right: 2px !important; }

.ui-datepicker-trigger {
vertical-align: middle;
cursor: pointer;
}

.bodyline {
-moz-border-radius: 4px;
-webkit-border-radius: 4px;
border-radius: 4px;
border: 1px #E4ECEC outset;
padding: 0px;
margin-bottom: 5px;
}
table.dp {
width: 180px;
background-color: #FFFFFF;
/*border-top: solid 2px #f4f4f4;
border-<?php print $left; ?>: solid 2px #f4f4f4;
border-<?php print $right; ?>: solid 1px #222222;
border-bottom: solid 1px #222222; */
padding: 0px;
border-spacing: 0px;
border-collapse: collapse;
}
.dp td, .tpHour td, .tpMinute td{padding:2px; font-size:10px;}
/* Barre titre */
.dpHead,.tpHead,.tpHour td:Hover .tpHead{
font-weight:bold;
background-color: #888;
color:white;
font-size:11px;
cursor:auto;
}
/* Barre navigation */
.dpButtons,.tpButtons {
text-align:center;
background-color: #888;
color:#FFFFFF;
font-weight:bold;
cursor:pointer;
}
.dpButtons:Active,.tpButtons:Active{border: 1px outset black;}
.dpDayNames td,.dpExplanation {background-color:#D9DBE1; font-weight:bold; text-align:center; font-size:11px;}
.dpExplanation{ font-weight:normal; font-size:11px;}
.dpWeek td{text-align:center}

.dpToday,.dpReg,.dpSelected{
cursor:pointer;
}
.dpToday{font-weight:bold; color:black; background-color:#f4f4f4;}
.dpReg:Hover,.dpToday:Hover{background-color:black;color:white}

/* Jour courant */
.dpSelected{background-color:#0B63A2;color:white;font-weight:bold; }

.tpHour{border-top:1px solid #f4f4f4; border-right:1px solid #f4f4f4;}
.tpHour td {border-left:1px solid #f4f4f4; border-bottom:1px solid #f4f4f4; cursor:pointer;}
.tpHour td:Hover {background-color:black;color:white;}

.tpMinute {margin-top:5px;}
.tpMinute td:Hover {background-color:black; color:white; }
.tpMinute td {background-color:#D9DBE1; text-align:center; cursor:pointer;}

/* Bouton X fermer */
.dpInvisibleButtons
{
border-style:none;
background-color:transparent;
padding:0px;
font-size:9px;
border-width:0px;
color: #eee;
vertical-align:middle;
cursor: pointer;
}
.datenowlink
{
color: rgb(<?php print $colortextlink; ?>);
}

.categtextwhite, .treeview .categtextwhite.hover {
color: #fff !important;
}
.categtextblack {
color: #000 !important;
}


/* ============================================================================== */
/*  Afficher/cacher                                                               */
/* ============================================================================== */

div.visible {display: block;}
div.hidden {display: none;}
tr.visible {display: block;}
td.hidden {display: none;}

/* ============================================================================== */
/*  Module website                                                                */
/* ============================================================================== */

.websitebar {
border-bottom: 1px solid #888;
background: #eee;
}
.websitebar .button, .websitebar .buttonDelete
{
padding: 2px 4px 2px 4px !important;
margin: 2px 4px 2px 4px  !important;
line-height: normal;
}
.websiteselection {
display: inline-block;
padding-left: 10px;
vertical-align: middle;
line-height: 29px;
}
.websitetools {
float: right;
height: 28px;
}
.websiteinputurl {
display: inline-block;
vertical-align: top;
}
.websiteiframenoborder {
border: 0px;
}
a.websitebuttonsitepreview img {
width: 26px;
display: inline-block;
}
.websiteiframenoborder {
border: 0px;
}


/* ============================================================================== */
/*  Module agenda                                                                 */
/* ============================================================================== */

table.cal_month    { border-spacing: 0px; }
table.cal_month td:first-child  { border-left: 0px; }
table.cal_month td:last-child   { border-right: 0px; }
.cal_current_month { border-top: 0; border-left: solid 1px #E0E0E0; border-right: 0; border-bottom: solid 1px #E0E0E0; }
.cal_current_month_peruserleft { border-top: 0; border-left: solid 2px #6C7C7B; border-right: 0; border-bottom: solid 1px #E0E0E0; }
.cal_current_month_oneday { border-right: solid 1px #E0E0E0; }
.cal_other_month   { border-top: 0; border-left: solid 1px #C0C0C0; border-right: 0; border-bottom: solid 1px #C0C0C0; }
.cal_other_month_peruserleft { border-top: 0; border-left: solid 2px #6C7C7B !important; border-right: 0; }
.cal_current_month_right { border-right: solid 1px #E0E0E0; }
.cal_other_month_right   { border-right: solid 1px #C0C0C0; }
.cal_other_month   { opacity: 0.6; background: #EAEAEA; padding-<?php print $left; ?>: 2px; padding-<?php print $right; ?>: 1px; padding-top: 0px; padding-bottom: 0px; }
.cal_past_month    { opacity: 0.6; background: #EEEEEE; padding-<?php print $left; ?>: 2px; padding-<?php print $right; ?>: 1px; padding-top: 0px; padding-bottom: 0px; }
.cal_current_month { background: #FFFFFF; border-left: solid 1px #E0E0E0; padding-<?php print $left; ?>: 2px; padding-<?php print $right; ?>: 1px; padding-top: 0px; padding-bottom: 0px; }
.cal_current_month_peruserleft { background: #FFFFFF; border-left: solid 2px #6C7C7B; padding-<?php print $left; ?>: 2px; padding-<?php print $right; ?>: 1px; padding-top: 0px; padding-bottom: 0px; }
.cal_today         { background: #FDFDF0; border-left: solid 1px #E0E0E0; border-bottom: solid 1px #E0E0E0; padding-<?php print $left; ?>: 2px; padding-<?php print $right; ?>: 1px; padding-top: 0px; padding-bottom: 0px; }
.cal_today_peruser { background: #FDFDF0; border-right: solid 1px #E0E0E0; border-bottom: solid 1px #E0E0E0; padding-<?php print $left; ?>: 2px; padding-<?php print $right; ?>: 1px; padding-top: 0px; padding-bottom: 0px; }
.cal_today_peruser_peruserleft { background: #FDFDF0; border-left: solid 2px #6C7C7B; border-right: solid 1px #E0E0E0; border-bottom: solid 1px #E0E0E0; padding-<?php print $left; ?>: 2px; padding-<?php print $right; ?>: 1px; padding-top: 0px; padding-bottom: 0px; }
.cal_past          { }
.cal_peruser       { padding: 0px; }
.cal_impair        { background: #F8F8F8; }
.cal_today_peruser_impair { background: #F8F8F0; }
.peruser_busy      { background: #CC8888; }
.peruser_notbusy   { background: #EEDDDD; opacity: 0.5; }
table.cal_event    { border: none; border-collapse: collapse; margin-bottom: 1px; -webkit-border-radius: 3px; border-radius: 3px;
min-height: 20px;
}
table.cal_event td { border: none; padding-<?php print $left; ?>: 2px; padding-<?php print $right; ?>: 2px; padding-top: 0px; padding-bottom: 0px; }
table.cal_event td.cal_event { padding: 4px 4px !important; }
table.cal_event td.cal_event_right { padding: 4px 4px !important; }
.event {padding: 0.51em;}
ul.cal_event       { padding-right: 2px; padding-top: 1px; border: none; list-style-type: none; margin: 0 auto; padding-left: 0px; padding-start: 0px; -khtml-padding-start: 0px; -o-padding-start: 0px; -moz-padding-start: 0px; -webkit-padding-start: 0px; }
li.cal_event       { border: none; list-style-type: none; }
.cal_event a:link    { color: #111111; font-size: 11px; font-weight: normal !important; }
.cal_event a:visited { color: #111111; font-size: 11px; font-weight: normal !important; }
.cal_event a:active  { color: #111111; font-size: 11px; font-weight: normal !important; }
.cal_event a:hover   { color: #111111; font-size: 11px; font-weight: normal !important; color:rgba(255,255,255,.75); }
.cal_event_busy      { }
.cal_peruserviewname { max-width: 100px; height: 22px; }


/* ============================================================================== */
/*  Ajax - Liste deroulante de l'autocompletion                                   */
/* ============================================================================== */

.ui-widget-content { border: solid 1px rgba(0,0,0,.3); background: #fff !important; }

.ui-autocomplete-loading { background: white url(<?php echo dol_buildpath($path . '/theme/' . $theme . '/img/working.gif', 1) ?>) right center no-repeat; }
.ui-autocomplete {
position:absolute;
width:auto;
font-size: 1.0em;
background-color:white;
border:1px solid #888;
margin:0px;
/*	       padding:0px; This make combo crazy */
}
.ui-autocomplete ul {
list-style-type:none;
margin:0px;
padding:0px;
}
.ui-autocomplete ul li.selected { background-color: #D3E5EC;}
.ui-autocomplete ul li {
list-style-type:none;
display:block;
margin:0;
padding:2px;
height:18px;
cursor:pointer;
}

/* ============================================================================== */
/*  jQuery - jeditable                                                            */
/* ============================================================================== */

.editkey_textarea, .editkey_ckeditor, .editkey_string, .editkey_email, .editkey_numeric, .editkey_select, .editkey_autocomplete {
background: url(<?php echo dol_buildpath($path . '/theme/' . $theme . '/img/edit.png', 1) ?>) right top no-repeat;
cursor: pointer;
}
.editkey_datepicker {
background: url(<?php echo dol_buildpath($path . '/theme/' . $theme . '/img/calendar.png', 1) ?>) right center no-repeat;
cursor: pointer;
}
.editval_textarea.active:hover, .editval_ckeditor.active:hover, .editval_string.active:hover, .editval_email.active:hover, .editval_numeric.active:hover, .editval_select.active:hover, .editval_autocomplete.active:hover, .editval_datepicker.active:hover {
background: white;
cursor: pointer;
}
.viewval_textarea.active:hover, .viewval_ckeditor.active:hover, .viewval_string.active:hover, .viewval_email.active:hover, .viewval_numeric.active:hover, .viewval_select.active:hover, .viewval_autocomplete.active:hover, .viewval_datepicker.active:hover {
background: white;
cursor: pointer;
}
.viewval_hover {
background: white;
}

/* ============================================================================== */
/* Admin Menu                                                                     */
/* ============================================================================== */
/* CSS for treeview */
.treeview ul { background-color: transparent !important; margin-top: 0; }
.treeview li { background-color: transparent !important; padding: 0 0 0 16px !important; min-height: 20px; }
.treeview .hover { color: rgb(<?php print $colortextlink; ?>) !important; text-decoration: underline !important; }

/* ============================================================================== */
/*  Show Excel tabs                                                               */
/* ============================================================================== */

.table_data
{
border-style:ridge;
border:1px solid;
}
.tab_base
{
background:#C5D0DD;
font-weight:bold;
border-style:ridge;
border: 1px solid;
cursor:pointer;
}
.table_sub_heading
{
background:#CCCCCC;
font-weight:bold;
border-style:ridge;
border: 1px solid;
}
.table_body
{
background:#F0F0F0;
font-weight:normal;
font-family:sans-serif;
border-style:ridge;
border: 1px solid;
border-spacing: 0px;
border-collapse: collapse;
}
.tab_loaded
{
background:#222222;
color:white;
font-weight:bold;
border-style:groove;
border: 1px solid;
cursor:pointer;
}


/* ============================================================================== */
/*  CSS for color picker                                                          */
/* ============================================================================== */

A.color, A.color:active, A.color:visited {
position : relative;
display : block;
text-decoration : none;
width : 10px;
height : 10px;
line-height : 10px;
margin : 0px;
padding : 0px;
border : 1px inset white;
}
A.color:hover {
border : 1px outset white;
}
A.none, A.none:active, A.none:visited, A.none:hover {
position : relative;
display : block;
text-decoration : none;
width : 10px;
height : 10px;
line-height : 10px;
margin : 0px;
padding : 0px;
cursor : default;
border : 1px solid #b3c5cc;
}
.tblColor {
display : none;
}
.tdColor {
padding : 1px;
}
.tblContainer {
background-color : #b3c5cc;
}
.tblGlobal {
position : absolute;
top : 0px;
left : 0px;
display : none;
background-color : #b3c5cc;
border : 2px outset;
}
.tdContainer {
padding : 5px;
}
.tdDisplay {
width : 50%;
height : 20px;
line-height : 20px;
border : 1px outset white;
}
.tdDisplayTxt {
width : 50%;
height : 24px;
line-height : 12px;
font-family : <?php print $fontlist ?>;
font-size : 8pt;
color : black;
text-align : center;
}
.btnColor {
width : 100%;
font-family : <?php print $fontlist ?>;
font-size : 10pt;
padding : 0px;
margin : 0px;
}
.btnPalette {
width : 100%;
font-family : <?php print $fontlist ?>;
font-size : 8pt;
padding : 0px;
margin : 0px;
}


/* Style to overwrites JQuery styles */
.ui-menu .ui-menu-item a {
text-decoration:none;
display:block;
padding:.2em .4em;
line-height:1.5;
zoom:1;
font-weight: normal;
font-family:<?php echo $fontlist; ?>;
font-size:1em;
}
.ui-widget {
font-family:<?php echo $fontlist; ?>;
font-size:<?php echo $fontsize; ?>;
}
.ui-button { margin-left: -2px; <?php print (preg_match('/chrome/', $conf->browser->name) ? 'padding-top: 1px;' : ''); ?> }
.ui-button-icon-only .ui-button-text { height: 8px; }
.ui-button-icon-only .ui-button-text, .ui-button-icons-only .ui-button-text { padding: 2px 0px 6px 0px; }
.ui-button-text
{
line-height: 1em !important;
}
.ui-autocomplete-input { margin: 0; padding: 4px; }


/* ============================================================================== */
/*  CKEditor                                                                      */
/* ============================================================================== */

.cke_editable
{
margin: 5px !important;
}
.cke_editor table, .cke_editor tr, .cke_editor td
{
border: 0px solid #FF0000 !important;
}
span.cke_skin_kama { padding: 0 !important; }
.cke_wrapper { padding: 4px !important; }
a.cke_dialog_ui_button
{
font-family: <?php print $fontlist ?> !important;
background-image: url(<?php echo $img_button ?>) !important;
background-position: bottom !important;
border: 1px solid #C0C0C0 !important;
-moz-border-radius:0px 2px 0px 2px !important;
-webkit-border-radius:0px 2px 0px 2px !important;
border-radius:0px 2px 0px 2px !important;
-moz-box-shadow: 3px 3px 4px #f4f4f4 !important;
-webkit-box-shadow: 3px 3px 4px #f4f4f4 !important;
box-shadow: 3px 3px 4px #f4f4f4 !important;
}
.cke_dialog_ui_hbox_last
{
vertical-align: bottom ! important;
}
.cke_editable
{
line-height: 1.4 !important;
margin: 6px !important;
}
a.cke_dialog_ui_button_ok span {
text-shadow: none !important;
color: #333 !important;
}


/* ============================================================================== */
/*  File upload                                                                   */
/* ============================================================================== */
.template-upload {height: 72px !important;}


/* ============================================================================== */
/*  Holiday                                                                       */
/* ============================================================================== */

#types .btn {
cursor: pointer;
}

#types .btn-primary {
font-weight: bold;
}

#types form {
padding: 20px;
}

#types label {
display:inline-block;
width:100px;
margin-right: 20px;
padding: 4px;
text-align: right;
vertical-align: top;
}

#types input.text, #types textarea {
width: 400px;
}

#types textarea {
height: 100px;
}



/* ============================================================================== */
/*  JSGantt                                                                       */
/* ============================================================================== */

div.scroll2 {
width: <?php print isset($_SESSION['dol_screenwidth']) ? max($_SESSION['dol_screenwidth'] - 830, 450) : '450'; ?>px !important;
}


/* ============================================================================== */
/*  jFileTree                                                                     */
/* ============================================================================== */


.fileview {
width: 99%;
height: 99%;
background: #FFF;
padding-left: 2px;
padding-top: 4px;
font-weight: normal;
}

div.filedirelem {
position: relative;
display: block;
text-decoration: none;
}

ul.filedirelem {
padding: 2px;
margin: 0 5px 5px 5px;
}
ul.filedirelem li {
list-style: none;
padding: 2px;
margin: 0 10px 20px 10px;
width: 160px;
height: 120px;
text-align: center;
display: block;
float: <?php print $left; ?>;
border: solid 1px #f4f4f4;
}

.ui-layout-north {}

ul.ecmjqft {
line-height: 16px;
padding: 0px;
margin: 0px;
font-weight: normal;
}


ul.ecmjqft a {
line-height: 16px;
vertical-align: middle;
color: #333;
padding: 0px 0px;
font-weight:normal;
display: inline-block !important;
/*	float: left;*/
}
ul.ecmjqft a:active {
font-weight: bold !important;
}
ul.ecmjqft a:hover {
text-decoration: underline;
}


/* Core Styles */
.ecmjqft LI.directory { font-weight:normal; background: url(<?php echo dol_buildpath($path . '/theme/common/treemenu/folder2.png', 1); ?>) left top no-repeat; }
.ecmjqft LI.expanded { font-weight:normal; background: url(<?php echo dol_buildpath($path . '/theme/common/treemenu/folder2-expanded.png', 1); ?>) left top no-repeat; }
.ecmjqft LI.wait { font-weight:normal; background: url(<?php echo dol_buildpath('/theme/' . $theme . '/img/working.gif', 1); ?>) left top no-repeat; }


/* ============================================================================== */
/*  jNotify                                                                       */
/* ============================================================================== */

.jnotify-container {
position: fixed !important;
	top: auto !important;
	bottom: 4px !important;
text-align: center;
min-width: <?php echo $dol_optimize_smallscreen ? '200' : '480'; ?>px;
width: auto;
max-width: 1024px;
padding-left: 1em !important;
padding-right: 1em !important;
}

/* use or not ? */
div.jnotify-background {
opacity : 0.95 !important;
-moz-box-shadow: 2px 2px 4px #888 !important;
-webkit-box-shadow: 2px 2px 4px #888 !important;
box-shadow: 2px 2px 4px #888 !important;
}

/* ============================================================================== */
/*  blockUI                                                                      */
/* ============================================================================== */


div.dolEventValid h1, div.dolEventValid h2 {
color: #567b1b;
background-color: #e3f0db;
padding: 5px 5px 5px 5px;
text-align: left;
}
div.dolEventError h1, div.dolEventError h2 {
color: #a72947;
background-color: #d79eac;
padding: 5px 5px 5px 5px;
text-align: left;
}

/* ============================================================================== */
/*  Maps                                                                          */
/* ============================================================================== */

.divmap, #google-visualization-geomap-embed-0, #google-visualization-geomap-embed-1, google-visualization-geomap-embed-2 {
/*    -moz-box-shadow: 0px 0px 10px #AAA;
-webkit-box-shadow: 0px 0px 10px #AAA;
box-shadow: 0px 0px 10px #AAA; */
}


/* ============================================================================== */
/*  Datatable                                                                     */
/* ============================================================================== */

table.dataTable tr.odd td.sorting_1, table.dataTable tr.even td.sorting_1 {
background: none !important;
}
.sorting_asc  { background: url('<?php echo dol_buildpath('/theme/' . $theme . '/img/sort_asc.png', 1); ?>') no-repeat center right !important; }
.sorting_desc { background: url('<?php echo dol_buildpath('/theme/' . $theme . '/img/sort_desc.png', 1); ?>') no-repeat center right !important; }
.sorting_asc_disabled  { background: url('<?php echo dol_buildpath('/theme/' . $theme . '/img/sort_asc_disabled.png', 1); ?>') no-repeat center right !important; }
.sorting_desc_disabled { background: url('<?php echo dol_buildpath('/theme/' . $theme . '/img/sort_desc_disabled.png', 1); ?>') no-repeat center right !important; }
.dataTables_paginate {
margin-top: 8px;
}
.paginate_button_disabled {
opacity: 1 !important;
color: #888 !important;
cursor: default !important;
}
.paginate_disabled_previous:hover, .paginate_enabled_previous:hover, .paginate_disabled_next:hover, .paginate_enabled_next:hover
{
font-weight: normal;
}
.paginate_enabled_previous:hover, .paginate_enabled_next:hover
{
text-decoration: underline !important;
}
.paginate_active
{
text-decoration: underline !important;
}
.paginate_button
{
font-weight: normal !important;
text-decoration: none !important;
}
.paging_full_numbers {
height: inherit !important;
}
.paging_full_numbers a.paginate_active:hover, .paging_full_numbers a.paginate_button:hover {
background-color: #DDD !important;
}
.paging_full_numbers, .paging_full_numbers a.paginate_active, .paging_full_numbers a.paginate_button {
background-color: #FFF !important;
border-radius: inherit !important;
}
.paging_full_numbers a.paginate_button_disabled:hover, .paging_full_numbers a.disabled:hover {
background-color: #FFF !important;
}
.paginate_button, .paginate_active {
border: 1px solid #ddd !important;
padding: 6px 12px !important;
margin-left: -1px !important;
line-height: 1.42857143 !important;
margin: 0 0 !important;
}

/* For jquery plugin combobox */
/* Disable this. It breaks wrapping of boxes
.ui-corner-all { white-space: nowrap; } */

.ui-state-disabled, .ui-widget-content .ui-state-disabled, .ui-widget-header .ui-state-disabled, .paginate_button_disabled {
opacity: .35;
background-image: none;
}

div.dataTables_length {
float: right !important;
padding-left: 8px;
}
div.dataTables_length select {
background: #fff;
}
.dataTables_wrapper .dataTables_paginate {
padding-top: 0px !important;
}


/* ============================================================================== */
/*  Select2                                                                       */
/* ============================================================================== */
.select2-container .select2-choice > .select2-chosen {
margin-right: 23px;
}
.select2-container .select2-choice .select2-arrow {
border-radius: 0;
}
.select2-container .select2-choice {
color: #000;
}
.selectoptiondisabledwhite {
background: #FFFFFF !important;
}

.select2-choice,
.select2-drop.select2-drop-above.select2-drop-active,
.select2-container-active .select2-choice,
.select2-container-active .select2-choices,
.select2-dropdown-open.select2-drop-above .select2-choice,
.select2-dropdown-open.select2-drop-above .select2-choices,
.select2-container-multi.select2-container-active .select2-choices
{
border: 1px solid #aaa;
}
.select2-disabled
{
color: #888;
}
.select2-drop-active
{
border: 1px solid #aaa;
border-top: none;
}
a span.select2-chosen
{
font-weight: normal !important;
}
.select2-container .select2-choice {
background-image: none;
height: 24px;
line-height: 24px;
}
.select2-choices .select2-search-choice {
border: 1px solid #aaa !important;
}
.select2-results .select2-no-results, .select2-results .select2-searching, .select2-results .select2-ajax-error, .select2-results .select2-selection-limit
{
background: #FFFFFF;
}
.select2-results {
max-height:	400px;
}
.css-searchselectcombo ul.select2-results {
max-height:	none;
}
.select2-container-multi.select2-container-disabled .select2-choices {
background-color: #FFFFFF;
background-image: none;
border: none;
cursor: default;
}
.select2-container-multi .select2-choices .select2-search-choice {
margin-bottom: 3px;
}
/* To emulate select 2 style */
.select2-container-multi-dolibarr .select2-choices-dolibarr .select2-search-choice-dolibarr {
padding: 2px 5px 1px 5px;
margin: 0 0 2px 3px;
position: relative;
line-height: 13px;
color: #333;
cursor: default;
border: 1px solid #ddd;
border-radius: 3px;
-webkit-box-shadow: 0 0 2px #fff inset, 0 1px 0 rgba(0, 0, 0, 0.05);
box-shadow: 0 0 2px #fff inset, 0 1px 0 rgba(0, 0, 0, 0.05);
background-clip: padding-box;
-webkit-touch-callout: none;
-webkit-user-select: none;
-moz-user-select: none;
-ms-user-select: none;
user-select: none;
background-color: #e4e4e4;
background-image: -webkit-gradient(linear, 0% 0%, 0% 100%, color-stop(20%, #f4f4f4), color-stop(50%, #f0f0f0), color-stop(52%, #e8e8e8), color-stop(100%, #eee));
background-image: -webkit-linear-gradient(top, #f4f4f4 20%, #f0f0f0 50%, #e8e8e8 52%, #eee 100%);
background-image: -moz-linear-gradient(top, #f4f4f4 20%, #f0f0f0 50%, #e8e8e8 52%, #eee 100%);
background-image: linear-gradient(to bottom, #f4f4f4 20%, #f0f0f0 50%, #e8e8e8 52%, #eee 100%);
}
.select2-container-multi-dolibarr .select2-choices-dolibarr .select2-search-choice-dolibarr a {
font-weight: normal;
}
.select2-container-multi-dolibarr .select2-choices-dolibarr li {
float: left;
list-style: none;
}
.select2-container-multi-dolibarr .select2-choices-dolibarr {
height: auto !important;
height: 1%;
margin: 0;
padding: 0 5px 0 0;
position: relative;
cursor: text;
overflow: hidden;
}


/* ============================================================================== */
/*  For categories                                                                */
/* ============================================================================== */

.noborderoncategories {
border: none !important;
border-radius: 5px !important;
box-shadow: none;
-webkit-box-shadow: none !important;
box-shadow: none !important;
}
span.noborderoncategories a, li.noborderoncategories a {
line-height: normal;
}
span.noborderoncategories {
padding: 3px 5px 0px 5px;
}
.categtextwhite, .treeview .categtextwhite.hover {
color: #fff !important;
}
.categtextblack {
color: #000 !important;
}


/* ============================================================================== */
/*  Multiselect with checkbox                                                     */
/* ============================================================================== */

ul.ulselectedfields {
z-index: 90;			/* To have the select box appears on first plan even when near buttons are decorated by jmobile */
}
dl.dropdown {
margin:0px;
padding:0px;
}
.dropdown dd, .dropdown dt {
margin:0px;
padding:0px;
}
.dropdown ul {
margin: -1px 0 0 0;
text-align: left;
}
.dropdown dd {
position:relative;
}
.dropdown dt a {
display:block;
overflow: hidden;
border:0;
}
.dropdown dt a span, .multiSel span {
cursor:pointer;
display:inline-block;
padding: 0 3px 2px 0;
}
.dropdown dd ul {
background-color: #FFF;
border: 1px solid #888;
display:none;
right:0px;						/* pop is align on right */
padding: 2px 15px 2px 5px;
position:absolute;
top:2px;
list-style:none;
max-height: 300px;
overflow: auto;
}
.dropdown span.value {
display:none;
}
.dropdown dd ul li {
white-space: nowrap;
font-weight: normal;
padding: 2px;
}
.dropdown dd ul li input[type="checkbox"] {
margin-right: 3px;
}
.dropdown dd ul li a, .dropdown dd ul li span {
padding: 3px;
display: block;
}
.dropdown dd ul li span {
color: #888;
}
.dropdown dd ul li a:hover {
background-color:#fff;
}


/* ============================================================================== */
/*  JMobile                                                                       */
/* ============================================================================== */

li.ui-li-divider .ui-link {
color: #FFF !important;
}
.ui-btn {
margin: 0.1em 2px
}
a.ui-link, a.ui-link:hover, .ui-btn:hover, span.ui-btn-text:hover, span.ui-btn-inner:hover {
text-decoration: none !important;
}
.ui-body-c {
background: #fff;
}

.ui-btn-inner {
min-width: .4em;
padding-left: 6px;
padding-right: 6px;
font-size: <?php print $fontsize ?>;
/* white-space: normal; */		/* Warning, enable this break the truncate feature */
}
.ui-btn-icon-right .ui-btn-inner {
padding-right: 30px;
}
.ui-btn-icon-left .ui-btn-inner {
padding-left: 30px;
}
.ui-select .ui-btn-icon-right .ui-btn-inner {
padding-right: 30px;
}
.ui-select .ui-btn-icon-left .ui-btn-inner {
padding-left: 30px;
}
.ui-select .ui-btn-icon-right .ui-icon {
right: 8px;
}
.ui-btn-icon-left > .ui-btn-inner > .ui-icon, .ui-btn-icon-right > .ui-btn-inner > .ui-icon {
margin-top: -10px;
}
select {
/* display: inline-block; */	/* We can't set this. This disable ability to make */
/* TODO modified by jmobile, replace jmobile with pure css*/
overflow:hidden;
white-space: nowrap;			/* Enabling this make behaviour strange when selecting the empty value if this empty value is '' instead of '&nbsp;' */
text-overflow: ellipsis;
}
.fiche .ui-controlgroup {
margin: 0px;
padding-bottom: 0px;
}
div.ui-controlgroup-controls div.tabsElem
{
margin-top: 2px;
}
div.ui-controlgroup-controls div.tabsElem a
{
-moz-box-shadow: 0 -3px 6px rgba(0,0,0,.2);
-webkit-box-shadow: 0 -3px 6px rgba(0,0,0,.2);
box-shadow: 0 -3px 6px rgba(0,0,0,.2);
}
div.ui-controlgroup-controls div.tabsElem a#active {
-moz-box-shadow: 0 -3px 6px rgba(0,0,0,.3);
-webkit-box-shadow: 0 -3px 6px rgba(0,0,0,.3);
box-shadow: 0 -3px 6px rgba(0,0,0,.3);
}

a.tab span.ui-btn-inner
{
border: none;
padding: 0;
}

.ui-link {
color: rgb(<?php print $colortext; ?>);
}
.liste_titre .ui-link {
color: rgb(<?php print $colortexttitle; ?>) !important;
}

a.ui-link {
word-wrap: break-word;
}

/* force wrap possible onto field overflow does not works */
.formdoc .ui-btn-inner
{
white-space: normal;
overflow: hidden;
text-overflow: clip; /* "hidden" : do not exists as a text-overflow value (https://developer.mozilla.org/fr/docs/Web/CSS/text-overflow) */
}

/* Warning: setting this may make screen not beeing refreshed after a combo selection */
/*.ui-body-c {
background: #fff;
}*/

div.ui-radio, div.ui-checkbox
{
display: inline-block;
border-bottom: 0px !important;
}
.ui-checkbox input, .ui-radio input {
height: auto;
width: auto;
margin: 4px;
position: static;
}
div.ui-checkbox label+input, div.ui-radio label+input {
position: absolute;
}
.ui-mobile fieldset
{
padding-bottom: 10px; margin-bottom: 4px; border-bottom: 1px solid #AAAAAA !important;
}

ul.ulmenu {
border-radius: 0;
-webkit-border-radius: 0;
}

.ui-field-contain label.ui-input-text {
vertical-align: middle !important;
}
.ui-mobile fieldset {
border-bottom: none !important;
}

/* Style for first level menu with jmobile */
.ui-li .ui-btn-inner a.ui-link-inherit, .ui-li-static.ui-li {
padding: 1em 15px;
display: block;
}
.ui-btn-up-c {
font-weight: normal;
}
.ui-focus, .ui-btn:focus {
-moz-box-shadow: none;
-webkit-box-shadow: none;
box-shadow: none;
}
.ui-bar-b {
/*border: 1px solid #888;*/
border: none;
background: none;
text-shadow: none;
color: rgb(<?php print $colortexttitlenotab; ?>) !important;
}
.ui-bar-b, .lilevel0 {
background-repeat: repeat-x;
border: none;
background: none;
text-shadow: none;
color: rgb(<?php print $colortexttitlenotab; ?>) !important;
}
.alilevel0 {
font-weight: normal !important;
}

.ui-li.ui-last-child, .ui-li.ui-field-contain.ui-last-child {
border-bottom-width: 0px !important;
}
.alilevel0 {
color: rgb(<?php echo $colortexttitle; ?>) !important;
}
.ulmenu {
box-shadow: none !important;
border-bottom: 1px solid #444;
}
.ui-btn-icon-right {
border-right: 1px solid #ccc !important;
}
.ui-body-c {
border: 1px solid #ccc;
text-shadow: none;
}
.ui-btn-up-c, .ui-btn-hover-c {
/* border: 1px solid #ccc; */
text-shadow: none;
}
.ui-body-c .ui-link, .ui-body-c .ui-link:visited, .ui-body-c .ui-link:hover {
color: rgb(<?php print $colortextlink; ?>);
}
.ui-btn-up-c .vsmenudisabled {
color: #<?php echo $colorshadowtitle; ?> !important;
text-shadow: none !important;
}
/*
.ui-btn-up-c {
background: transparent;
}
*/
div.tabsElem a.tab {
background: transparent;
}

.alilevel1 {
color: rgb(<?php print $colortexttitlenotab; ?>) !important;
}
.lilevel1 {
border-top: 2px solid #444;
background: #fff ! important;
}
.lilevel1 div div a {
font-weight: bold !important;
}
.lilevel2
{
padding-left: 22px;
background: #fff ! important;
}
.lilevel3
{
padding-left: 54px;
background: #fff ! important;
}



/* ============================================================================== */
/*  POS                                                                           */
/* ============================================================================== */

.menu_choix1 a {
background: url('<?php echo dol_buildpath($path . '/theme/' . $theme . '/img/menus/money.png', 1) ?>') top left no-repeat;
background-position-y: 15px;
}
.menu_choix2 a {
background: url('<?php echo dol_buildpath($path . '/theme/' . $theme . '/img/menus/home.png', 1) ?>') top left no-repeat;
background-position-y: 15px;
}
.menu_choix1,.menu_choix2 {
font-size: 1.4em;
text-align: left;
border: 1px solid #666;
margin-right: 20px;
}
.menu_choix1 a, .menu_choix2 a {
display: block;
color: #fff;
text-decoration: none;
padding-top: 18px;
padding-left: 54px;
font-size: 14px;
height: 40px;
}
.menu_choix1 a:hover,.menu_choix2 a:hover {
color: #6d3f6d;
}
.menu li.menu_choix1 {
padding-top: 6px;
padding-right: 10px;
padding-bottom: 2px;
}
.menu li.menu_choix2 {
padding-top: 6px;
padding-right: 10px;
padding-bottom: 2px;
}

/*  Demo  */
img.demothumb {
box-shadow: 2px 2px 8px #888;
margin-bottom: 4px;
margin-right: 20px;
margin-left: 10px;
}

/*  Public                                     */
/* The theme for public pages */
.public_body {margin: 20px;}
.public_border {border: 1px solid #888;}


li.tmenu, li.tmenusel {
min-width: 30px;
}
div.tmenucenter {
text-overflow: clip;
}

#tooltip {
position: absolute;
width: <?php print dol_size(300, 'width'); ?>px;
}
select {
width: 98%;
min-width: 0 !important;
}
.fiche select {width: inherit;}
div.divphotoref {
padding-right: 5px;
}
img.photoref, div.photoref {
border: none;
-moz-box-shadow: none;
-webkit-box-shadow: none;
box-shadow: none;
padding: 4px;
height: 20px;
width: 20px;
object-fit: contain;
}

}
div.login_block_user, div.login_block_other {display: inline-block;}
#addNote {left: 0.5em!important;}
table.valid {    position: absolute;
top: 0;
width: 100%;
left: 0;
z-index: 99999;
bottom: 0;
height: 100%;background-color:rgba(213, 186, 168, 0.48);
}
table.valid tbody {width: 50%;
display: block;
margin: 15% auto;
border: 1px solid #FFF;
padding: 1em;
background-color: #D5BAA8;}

div.tabsAction{
position: fixed;
top: 0;right: 0;
background-color: rgba(255, 255, 255, 0.5);
padding: 0.5em;
border: 1px solid rgb(224, 224, 224);
margin: 0px 14px;
max-width : 100%;
}
#blockvmenusearch input.button {width: 50px !important;margin: 0;}

#mainmenua_billing .mainmenuaspan, #mainmenutd_accountancy .mainmenuaspan, #mainmenua_bank .mainmenuaspan, #mainmenua_products .mainmenuaspan {display: none!important;}
#mainmenua_accountancy::after {content: 'Financier';}
#mainmenua_bank::after {content: 'Bancaires';}
#mainmenua_products::after {content: 'Marchandises';}
#mainmenua_billing::after {content: 'Facturation';}

.breadCrumbHolder.module {margin-left: 270px;}
.sidebar-collapse .breadCrumbHolder.module {margin-left: 120px;}
.breadCrumb {padding-left: 1em !important;width: 98%!important;}
#breadCrumb ul li.first {display:none;}
#breadCrumb.breadCrumb ul li span,.breadCrumb ul li a {display: inherit!important;float: inherit !important;}
#breadCrumb ul {
    max-width: 100%;
    display: block;
}

/* ============================================================================== */
/* CSS style used for small screen                                                */
/* ============================================================================== */

.imgopensurveywizard{padding: 0 4px 0 4px;}

@media only screen and (max-width: 1400px){
table.liste, table.noborder, table.formdoc, div.noborder {min-width: 350px;}
td.nohover div.fichecenter {display:block;}
}

@media only screen and (max-width: 1010px){
div.twocolumns {display: block;}
div.fichecenter {display:block;}
div.fichehalfleft, div.fichehalfright, div.fichethirdleft, div.fichetwothirdright {width: 98%;}
}

@media only screen and (max-width: 767px){
.menu_choix1 a, .menu_choix2 a {
background-size: 36px 36px;
background-position-y: 6px;
padding-left: 40px;
}
.menu li.menu_choix1, .menu li.menu_choix2 {
padding-left: 4px;
padding-right: 0;
}
.liste_articles {
margin-right: 0 !important;
}
.imgopensurveywizard, .imgautosize { width:95%; height: auto; }
#tooltip {
position: absolute;
width: <?php print dol_size(350, 'width'); ?>px;
}
img.demothumb {
box-shadow: 1px 1px 4px #BBB;
margin-right: 6px;
margin-left: 4px;
width: 80px;
}
div.tabBar {
padding-left: 0px;
padding-right: 0px;
-moz-border-radius: 0;
-webkit-border-radius: 0;
border-radius: 0px;
border-right: none;
border-left: none;
}
}

@media screen and (max-width: 900px){
.side-nav #id-left .vmenu div {display: inline-block;}
.menu_contenu.menu_contenu_societe_soc,.menu_contenu.menu_contenu_societe_soc,#blockvmenuhelp {display:none!important;}
#blockvmenusearch {clear: both;width: 98%;}
}

@media screen and (max-width: 640px){
	div.login_block {right: 20px;width: 107px;border: 0;left: inherit;top: 110px;}
	#mainmenutd_companylogo, .breadCrumbHolder,.login_block_user {display:none!important;}
	ul.tmenu {width: 100%;border-right: 1px solid rgba(0,0,0,0.3);border-left: 1px solid rgba(0,0,0,0.3);background-color: #FFF;height: 180px;}
	.login_block_other .login_block_elem a {padding-right: 1em !important;}
	.side-nav-vert {top: 0;position: fixed;z-index: 150;width: 100%;height: 180px;overflow: hidden;max-width: 100%;}
	#id-container {margin-top: 180px;margin-left: 0;}
	div.tabsAction {position: inherit!important;}
	#blockvmenubookmarks {display:none!important;}
	ul.tmenu li {margin: 1em;width: initial!important;width: inherit;max-width: 30px;}
}
/* STATUS BADGES */

/* STATUS0 */
.badge-status0 {
        color: #999999 !important;
        border-color: #cbd3d3;
        background-color: #fff;
}
.font-status0 {
        color: #fff !important;
}
.badge-status0.focus, .badge-status0:focus {
    outline: 0;
    box-shadow: 0 0 0 0.2rem rgba(255,255,255,0.5);
}
.badge-status0:focus, .badge-status0:hover {
    color: #999999 !important;
        border-color: #b2baba;
}

/* STATUS1 */
.badge-status1 {
        color: #ffffff !important;
        background-color: #bc9526;
}
.font-status1 {
        color: #bc9526 !important;
}
.badge-status1.focus, .badge-status1:focus {
    outline: 0;
    box-shadow: 0 0 0 0.2rem rgba(188,149,38,0.5);
}
.badge-status1:focus, .badge-status1:hover {
    color: #ffffff !important;
}

/* COLORBLIND STATUS1 */
body[class*="colorblind-"] .badge-status1 {
        color: #000 !important;
        background-color: #e4e411;
}
body[class*="colorblind-"] .font-status1 {
        color: #e4e411 !important;
}
body[class*="colorblind-"] .badge-status1.focus, body[class*="colorblind-"] .badge-status1:focus {
    outline: 0;
    box-shadow: 0 0 0 0.2rem rgba(228,228,17,0.5);
}
body[class*="colorblind-"] .badge-status1:focus, body[class*="colorblind-"] .badge-status1:hover {
    color: #000 !important;
}

/* STATUS2 */
.badge-status2 {
        color: #ffffff !important;
        background-color: #9c9c26;
}
.font-status2 {
        color: #9c9c26 !important;
}
.badge-status2.focus, .badge-status2:focus {
    outline: 0;
    box-shadow: 0 0 0 0.2rem rgba(156,156,38,0.5);
}
.badge-status2:focus, .badge-status2:hover {
    color: #ffffff !important;
}

/* STATUS3 */
.badge-status3 {
        color: #212529 !important;
        border-color: #bca52b;
        background-color: #fff;
}
.font-status3 {
        color: #fff !important;
}
.badge-status3.focus, .badge-status3:focus {
    outline: 0;
    box-shadow: 0 0 0 0.2rem rgba(255,255,255,0.5);
}
.badge-status3:focus, .badge-status3:hover {
    color: #212529 !important;
        border-color: #a38c12;
}

/* STATUS4 */
.badge-status4 {
        color: #ffffff !important;
        background-color: #55a580;
}
.font-status4 {
        color: #55a580 !important;
}
.badge-status4.focus, .badge-status4:focus {
    outline: 0;
    box-shadow: 0 0 0 0.2rem rgba(85,165,128,0.5);
}
.badge-status4:focus, .badge-status4:hover {
    color: #ffffff !important;
}

/* COLORBLIND STATUS4 */
body[class*="colorblind-"] .badge-status4 {
        color: #000 !important;
        background-color: #37de5d;
}
body[class*="colorblind-"] .font-status4 {
        color: #37de5d !important;
}
body[class*="colorblind-"] .badge-status4.focus, body[class*="colorblind-"] .badge-status4:focus {
    outline: 0;
    box-shadow: 0 0 0 0.2rem rgba(55,222,93,0.5);
}
body[class*="colorblind-"] .badge-status4:focus, body[class*="colorblind-"] .badge-status4:hover {
    color: #000 !important;
}

/* STATUS5 */
.badge-status5 {
        color: #999999 !important;
        border-color: #cad2d2;
        background-color: #fff;
}
.font-status5 {
        color: #fff !important;
}
.badge-status5.focus, .badge-status5:focus {
    outline: 0;
    box-shadow: 0 0 0 0.2rem rgba(255,255,255,0.5);
}
.badge-status5:focus, .badge-status5:hover {
    color: #999999 !important;
        border-color: #b1b9b9;
}

/* STATUS6 */
.badge-status6 {
        color: #777777 !important;
        background-color: #cad2d2;
}
.font-status6 {
        color: #cad2d2 !important;
}
.badge-status6.focus, .badge-status6:focus {
    outline: 0;
    box-shadow: 0 0 0 0.2rem rgba(202,210,210,0.5);
}
.badge-status6:focus, .badge-status6:hover {
    color: #777777 !important;
}

/* STATUS7 */
.badge-status7 {
        color: #212529 !important;
        border-color: #baa32b;
        background-color: #fff;
}
.font-status7 {
        color: #fff !important;
}
.badge-status7.focus, .badge-status7:focus {
    outline: 0;
    box-shadow: 0 0 0 0.2rem rgba(255,255,255,0.5);
}
.badge-status7:focus, .badge-status7:hover {
    color: #212529 !important;
        border-color: #a18a12;
}

/* COLORBLIND STATUS7 */
body[class*="colorblind-"] .badge-status7 {
        color: #212529 !important;
        border-color: #37de5d;
        background-color: #fff;
}
body[class*="colorblind-"] .font-status7 {
        color: #fff !important;
}
body[class*="colorblind-"] .badge-status7.focus, body[class*="colorblind-"] .badge-status7:focus {
    outline: 0;
    box-shadow: 0 0 0 0.2rem rgba(255,255,255,0.5);
}
body[class*="colorblind-"] .badge-status7:focus, body[class*="colorblind-"] .badge-status7:hover {
    color: #212529 !important;
        border-color: #1ec544;
}

/* STATUS8 */
.badge-status8 {
        color: #ffffff !important;
        background-color: #993013;
}
.font-status8 {
        color: #993013 !important;
}
.badge-status8.focus, .badge-status8:focus {
    outline: 0;
    box-shadow: 0 0 0 0.2rem rgba(153,48,19,0.5);
}
.badge-status8:focus, .badge-status8:hover {
    color: #ffffff !important;
}

/* STATUS9 */
.badge-status9 {
        color: #999999 !important;
        background-color: #e7f0f0;
}
.font-status9 {
        color: #e7f0f0 !important;
}
.badge-status9.focus, .badge-status9:focus {
    outline: 0;
    box-shadow: 0 0 0 0.2rem rgba(231,240,240,0.5);
}
.badge-status9:focus, .badge-status9:hover {
    color: #999999 !important;
}

/* STATUS1B */
.badge-status1b {
        color: #212529 !important;
        border-color: #bc9526;
        background-color: #fff;
}
.font-status1b {
        color: #fff !important;
}
.badge-status1b.focus, .badge-status1b:focus {
    outline: 0;
    box-shadow: 0 0 0 0.2rem rgba(255,255,255,0.5);
}
.badge-status1b:focus, .badge-status1b:hover {
    color: #212529 !important;
        border-color: #a37c0d;
}

/* STATUS4B */
.badge-status4b {
        color: #212529 !important;
        border-color: #55a580;
        background-color: #fff;
}
.font-status4b {
        color: #fff !important;
}
.badge-status4b.focus, .badge-status4b:focus {
    outline: 0;
    box-shadow: 0 0 0 0.2rem rgba(255,255,255,0.5);
}
.badge-status4b:focus, .badge-status4b:hover {
    color: #212529 !important;
        border-color: #3c8c67;
}
.wrapcolumntitle.liste_titre_sel[title="Nom du tiers"] {
    min-width: 380px;
}

.breadCrumb ul li span {
    display: inline-block;padding: 4px 6px;
}
.breadCrumb ul li a {
    padding: 0 20px;
}
td.linecoledit a, td.linecoldelete a {
    font-size: 2em;
}
.fa.fa-search-plus, .fa.fa-file-pdf-o.paddingright,.fas.fa-trash,.fas.fa-print {
    font-size: 1.5em;
    vertical-align: text-bottom;
}
#id-top .atoplogin, #photologo____thumbs_logo_web_mini_png, .userimg, img.userphoto {height: 100%;width: auto;height: 2em;vertical-align: bottom;}
.boxstatsindicator {display: inline-grid;margin: 1em 0.5em;}

@media print {
.side-nav,.hideonprint,div.tmenudiv,div#tmenu_tooltip,div.login_block,.vmenu {display: none;}
#id-container, .fiche {margin:0.5em!important;}
body {font-size:120%;color:black;background-color: #FFFFFF;}
}

<?php if (GETPOST("optioncss") == 'print') { ?>
	body { background-color: #FFFFFF;}
	.tabsAction, .side-nav,.hideonprint,div.tmenudiv,div#tmenu_tooltip,div.login_block,.vmenu {display: none!important;}
	#id-container, .fiche {margin:0.5em!important;}
	
<?php } ?>

.highlight, .highlight a {
    font-weight: 800 !important;
}

/* */
/* Custom styles pages for explicit attribut */
/* */

form[name="expensereport"] td.left {
    max-height: 6em;
    display: block;
    overflow: auto;
    padding: 0.5em;
}
/* Force values for small screen 570 */
@media only screen and (max-width: 570px)
{
	.box-flex-item {
		margin: 3px 2px 3px 2px !important;
	}
	div.refidno {
		font-size: <?php print is_numeric($fontsize) ? ($fontsize + 3).'px' : $fontsize; ?> !important;
	}
}
/* ============================================================================== */
/* Custom styles for Main page <?php print $_SERVER['ORIG_PATH_INFO']; ?>                  */
/* ============================================================================== */
/* ============================================================================== */
/* Custom styles pages for <?php print $_SESSION['leftmenu']; ?>                  */
/* ============================================================================== */

<?php  if ($_SESSION['leftmenu'] == 'customers_bills_checks' or $_SESSION['leftmenu'] ==  'checks_bis') { ?>
form.nocellnopadd{width: 99%;display: block;}
form {width: 46%;display: inline-table;margin: 2em;}
div.tabsAction {position: inherit;margin: 1em auto;text-align: center;}
form#actionbookmark{margin: 0px;width:99%;}
<?php } ?>
<?php  if ($_SESSION['leftmenu'] == 'home' or $_SESSION['leftmenu'] ==  'home') { ?>
.box .nohover:hover {background-color: white !important;}
table.noborder td {padding:0!important}
<?php } ?>
<?php  if ($_SESSION['leftmenu'] == '' and $_SESSION['mainmenu'] ==  'billing') { ?>
	.fichethirdleft br {display:none;}
	.fichethirdleft .div-table-responsive-no-min {
    width: 47%;
    display: inline-block;
    margin: 0 1% 1% 1%;}
<?php } ?>

<?php 

// Include the global.inc.php that include the badges, btn, info-box, dropdown, progress...
require __DIR__.'/global.inc.php';


if (is_object($db)) $db->close();

	/* ====================== MLB PART ============================ */
/* =========================================================== */

require __DIR__.'/style_MLB.css';
?>
