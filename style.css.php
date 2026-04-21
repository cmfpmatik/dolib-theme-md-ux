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
if (!defined('NOREQUIRESOC'))
    define('NOREQUIRESOC', '1');
//if (! defined('NOREQUIRETRAN')) define('NOREQUIRETRAN','1');	// Not disabled because need to do translations
if (!defined('NOCSRFCHECK'))
    define('NOCSRFCHECK', 1);
if (!defined('NOTOKENRENEWAL'))
    define('NOTOKENRENEWAL', 1);
if (!defined('NOLOGIN'))
    define('NOLOGIN', 1);	// File must be accessed by logon page so without login
//if (! defined('NOREQUIREMENU'))   define('NOREQUIREMENU',1);  // We need top menu content
if (!defined('NOREQUIREHTML'))
    define('NOREQUIREHTML', 1);
if (!defined('NOREQUIREAJAX'))
    define('NOREQUIREAJAX', '1');
define('ALLOW_THEME_JS', '1');
define('ISLOADEDBYSTEELSHEET', '1');

session_cache_limiter(FALSE);

require_once '../../main.inc.php';
require_once DOL_DOCUMENT_ROOT . '/core/lib/functions2.lib.php';
//$morejs=array("/js/mdux.js");
//llxHeader('','mdux','','','','',$morejs,'',0,0);


// Load user to have $user->conf loaded (not done into main because of NOLOGIN constant defined)
if (empty($user->id) && !empty($_SESSION['dol_login']))
    $user->fetch('', $_SESSION['dol_login']);

// Load new boxes

// Load JS files required by theme
require_once DOL_DOCUMENT_ROOT . '/theme/md-ux/set_allow_theme_js.php';

// Define css type
header('Content-type: text/css');
// Important: Following code is to avoid page request by browser and PHP CPU at each Dolibarr page access.
if (empty($dolibarr_nocache))
    header('Cache-Control: max-age=3600, public, must-revalidate');
else
    header('Cache-Control: no-cache');

// On the fly GZIP compression for all pages (if browser support it). Must set the bit 3 of constant to 1.
if (isset($conf->global->MAIN_OPTIMIZE_SPEED) && ($conf->global->MAIN_OPTIMIZE_SPEED & 0x04)) {
    ob_start("ob_gzhandler");
}


if (GETPOST('lang'))
    $langs->setDefaultLang(GETPOST('lang', 'aZ09')); // If language was forced on URL
if (GETPOST('theme'))
    $conf->theme = GETPOST('theme');  // If theme was forced on URL
$langs->load("main", 0, 1);
$right = ($langs->trans("DIRECTION") == 'rtl' ? 'left' : 'right');
$left = ($langs->trans("DIRECTION") == 'rtl' ? 'right' : 'left');

$path = '';  // This value may be used in future for external module to overwrite theme
$theme = 'md-ux'; // Value of theme
if (!empty($conf->global->MAIN_OVERWRITE_THEME_RES)) {
    $path = '/' . $conf->global->MAIN_OVERWRITE_THEME_RES;
    $theme = $conf->global->MAIN_OVERWRITE_THEME_RES;
}

// Define image path files and other constants
$fontlist = 'roboto,arial,tahoma,verdana,helvetica'; //$fontlist='verdana,helvetica,arial,sans-serif';
$img_head = '';
$img_button = dol_buildpath($path . '/theme/' . $theme . '/img/button_bg.png', 1);
$dol_hide_leftmenu = $conf->dol_hide_leftmenu;
$dol_optimize_smallscreen = $conf->dol_optimize_smallscreen;
$dol_no_mouse_hover = $conf->dol_no_mouse_hover;


//$conf->global->THEME_ELDY_ENABLE_PERSONALIZED=0;
//$user->conf->THEME_ELDY_ENABLE_PERSONALIZED=0;
//var_dump($user->conf->THEME_ELDY_RGB);
// Colors
$colorbackhmenu1 = '250,250,250';   // topmenu
$colorbackvmenu1 = '255,255,255';   // vmenu
$colortopbordertitle1 = '';	 // top border of tables-lists title. not defined = default to colorbackhmenu1
$colorbacktitle1 = '230,230,230';   // title of tables-lists
$colorbacktabcard1 = '255,255,255';  // card
$colorbacktabactive = '234,234,234';
$colorbacklineimpair1 = '240,240,240'; // line impair
$colorbacklineimpair2 = '255,255,255'; // line impair
$colorbacklinepair1 = '250,250,250'; // line pair
$colorbacklinepair2 = '248,248,248'; // line pair
$colorbacklinepairhover = '244,244,244'; // line pair
$colorbackbody = '248,248,248';
$colortexttitlenotab = '90,90,90';
$colortexttitle = '20,20,20';
$colortext = '0,0,0';
$colortextlink = '0,0,120';
$fontsize = '13';
$fontsizesmaller = '11';
$usegradient = 0;
$useboldtitle = (isset($conf->global->THEME_ELDY_USEBOLDTITLE) ? $conf->global->THEME_ELDY_USEBOLDTITLE : 1);
$borderwith = 2;
$badgeWarning = 'red';
$badgeDanger = 'red';

// Case of option always editable
if (!isset($conf->global->THEME_ELDY_BACKBODY))
    $conf->global->THEME_ELDY_BACKBODY = $colorbackbody;
if (!isset($conf->global->THEME_ELDY_TOPMENU_BACK1))
    $conf->global->THEME_ELDY_TOPMENU_BACK1 = $colorbackhmenu1;
if (!isset($conf->global->THEME_ELDY_VERMENU_BACK1))
    $conf->global->THEME_ELDY_VERMENU_BACK1 = $colorbackvmenu1;
if (!isset($conf->global->THEME_ELDY_BACKTITLE1))
    $conf->global->THEME_ELDY_BACKTITLE1 = $colorbacktitle1;
if (!isset($conf->global->THEME_ELDY_USE_HOVER))
    $conf->global->THEME_ELDY_USE_HOVER = $colorbacklinepairhover;
if (!isset($conf->global->THEME_ELDY_USE_CHECKED))
    $conf->global->THEME_ELDY_USE_CHECKED = $colorbacklinepairchecked;
if (!isset($conf->global->THEME_ELDY_LINEBREAK))
    $conf->global->THEME_ELDY_LINEBREAK = $colorbacklinebreak;
if (!isset($conf->global->THEME_ELDY_TEXTTITLENOTAB))
    $conf->global->THEME_ELDY_TEXTTITLENOTAB = $colortexttitlenotab;
if (!isset($conf->global->THEME_ELDY_TEXTLINK))
    $conf->global->THEME_ELDY_TEXTLINK = $colortextlink;

// Case of option editable only if option THEME_ELDY_ENABLE_PERSONALIZED is on
if (empty($conf->global->THEME_ELDY_ENABLE_PERSONALIZED)) {
    // 90A4AE, 607D8B, 455A64, 37474F
    $conf->global->THEME_ELDY_VERMENU_BACK1 = '255,255,255'; // vmenu
    $conf->global->THEME_ELDY_BACKTABCARD1 = '255,255,255';  // card
    $conf->global->THEME_ELDY_BACKTABACTIVE = '234,234,234';
    $conf->global->THEME_ELDY_LINEIMPAIR1 = '255,255,255';
    $conf->global->THEME_ELDY_LINEIMPAIR2 = '255,255,255';
    $conf->global->THEME_ELDY_LINEPAIR1 = '250,250,250';
    $conf->global->THEME_ELDY_LINEPAIR2 = '248,248,248';
    $conf->global->THEME_ELDY_LINEPAIRHOVER = '238,246,252';
    $conf->global->THEME_ELDY_USE_HOVER = '238,246,252';
    $conf->global->THEME_ELDY_TEXT = '0,0,0';
    $conf->global->THEME_ELDY_FONT_SIZE1 = '0.8em';
    $conf->global->THEME_ELDY_FONT_SIZE2 = '11';
}


// Case of option availables only if THEME_ELDY_ENABLE_PERSONALIZED is on
$colorbackhmenu1 = empty($user->conf->THEME_ELDY_ENABLE_PERSONALIZED) ? (empty($conf->global->THEME_ELDY_TOPMENU_BACK1) ? $colorbackhmenu1 : $conf->global->THEME_ELDY_TOPMENU_BACK1) : (empty($user->conf->THEME_ELDY_TOPMENU_BACK1) ? $colorbackhmenu1 : $user->conf->THEME_ELDY_TOPMENU_BACK1);
$colorbackvmenu1 = empty($user->conf->THEME_ELDY_ENABLE_PERSONALIZED) ? (empty($conf->global->THEME_ELDY_VERMENU_BACK1) ? $colorbackvmenu1 : $conf->global->THEME_ELDY_VERMENU_BACK1) : (empty($user->conf->THEME_ELDY_VERMENU_BACK1) ? $colorbackvmenu1 : $user->conf->THEME_ELDY_VERMENU_BACK1);
$colortopbordertitle1 = empty($user->conf->THEME_ELDY_ENABLE_PERSONALIZED) ? (empty($conf->global->THEME_ELDY_TOPBORDER_TITLE1) ? $colortopbordertitle1 : $conf->global->THEME_ELDY_TOPBORDER_TITLE1) : (empty($user->conf->THEME_ELDY_TOPBORDER_TITLE1) ? $colortopbordertitle1 : $user->conf->THEME_ELDY_TOPBORDER_TITLE1);
$colorbacktitle1 = empty($user->conf->THEME_ELDY_ENABLE_PERSONALIZED) ? (empty($conf->global->THEME_ELDY_BACKTITLE1) ? $colorbacktitle1 : $conf->global->THEME_ELDY_BACKTITLE1) : (empty($user->conf->THEME_ELDY_BACKTITLE1) ? $colorbacktitle1 : $user->conf->THEME_ELDY_BACKTITLE1);
$colorbacktabcard1 = empty($user->conf->THEME_ELDY_ENABLE_PERSONALIZED) ? (empty($conf->global->THEME_ELDY_BACKTABCARD1) ? $colorbacktabcard1 : $conf->global->THEME_ELDY_BACKTABCARD1) : (empty($user->conf->THEME_ELDY_BACKTABCARD1) ? $colorbacktabcard1 : $user->conf->THEME_ELDY_BACKTABCARD1);
$colorbacktabactive = empty($user->conf->THEME_ELDY_ENABLE_PERSONALIZED) ? (empty($conf->global->THEME_ELDY_BACKTABACTIVE) ? $colorbacktabactive : $conf->global->THEME_ELDY_BACKTABACTIVE) : (empty($user->conf->THEME_ELDY_BACKTABACTIVE) ? $colorbacktabactive : $user->conf->THEME_ELDY_BACKTABACTIVE);
$colorbacklineimpair1 = empty($user->conf->THEME_ELDY_ENABLE_PERSONALIZED) ? (empty($conf->global->THEME_ELDY_LINEIMPAIR1) ? $colorbacklineimpair1 : $conf->global->THEME_ELDY_LINEIMPAIR1) : (empty($user->conf->THEME_ELDY_LINEIMPAIR1) ? $colorbacklineimpair1 : $user->conf->THEME_ELDY_LINEIMPAIR1);
$colorbacklineimpair2 = empty($user->conf->THEME_ELDY_ENABLE_PERSONALIZED) ? (empty($conf->global->THEME_ELDY_LINEIMPAIR2) ? $colorbacklineimpair2 : $conf->global->THEME_ELDY_LINEIMPAIR2) : (empty($user->conf->THEME_ELDY_LINEIMPAIR2) ? $colorbacklineimpair2 : $user->conf->THEME_ELDY_LINEIMPAIR2);
$colorbacklinepair1 = empty($user->conf->THEME_ELDY_ENABLE_PERSONALIZED) ? (empty($conf->global->THEME_ELDY_LINEPAIR1) ? $colorbacklinepair1 : $conf->global->THEME_ELDY_LINEPAIR1) : (empty($user->conf->THEME_ELDY_LINEPAIR1) ? $colorbacklinepair1 : $user->conf->THEME_ELDY_LINEPAIR1);
$colorbacklinepair2 = empty($user->conf->THEME_ELDY_ENABLE_PERSONALIZED) ? (empty($conf->global->THEME_ELDY_LINEPAIR2) ? $colorbacklinepair2 : $conf->global->THEME_ELDY_LINEPAIR2) : (empty($user->conf->THEME_ELDY_LINEPAIR2) ? $colorbacklinepair2 : $user->conf->THEME_ELDY_LINEPAIR2);
$colorbacklinepairhover = empty($user->conf->THEME_ELDY_ENABLE_PERSONALIZED) ? (empty($conf->global->THEME_ELDY_LINEPAIRHOVER) ? $colorbacklinepairhover : $conf->global->THEME_ELDY_LINEPAIRHOVER) : (empty($user->conf->THEME_ELDY_LINEPAIRHOVER) ? $colorbacklinepairhover : $user->conf->THEME_ELDY_LINEPAIRHOVER);
$colorbackbody = empty($user->conf->THEME_ELDY_ENABLE_PERSONALIZED) ? (empty($conf->global->THEME_ELDY_BACKBODY) ? $colorbackbody : $conf->global->THEME_ELDY_BACKBODY) : (empty($user->conf->THEME_ELDY_BACKBODY) ? $colorbackbody : $user->conf->THEME_ELDY_BACKBODY);
$colortexttitlenotab = empty($user->conf->THEME_ELDY_ENABLE_PERSONALIZED) ? (empty($conf->global->THEME_ELDY_TEXTTITLENOTAB) ? $colortexttitlenotab : $conf->global->THEME_ELDY_TEXTTITLENOTAB) : (empty($user->conf->THEME_ELDY_TEXTTITLENOTAB) ? $colortexttitlenotab : $user->conf->THEME_ELDY_TEXTTITLENOTAB);
$colortexttitle = empty($user->conf->THEME_ELDY_ENABLE_PERSONALIZED) ? (empty($conf->global->THEME_ELDY_TEXTTITLE) ? $colortext : $conf->global->THEME_ELDY_TEXTTITLE) : (empty($user->conf->THEME_ELDY_TEXTTITLE) ? $colortexttitle : $user->conf->THEME_ELDY_TEXTTITLE);
$colortext = empty($user->conf->THEME_ELDY_ENABLE_PERSONALIZED) ? (empty($conf->global->THEME_ELDY_TEXT) ? $colortext : $conf->global->THEME_ELDY_TEXT) : (empty($user->conf->THEME_ELDY_TEXT) ? $colortext : $user->conf->THEME_ELDY_TEXT);
$colortextlink = empty($user->conf->THEME_ELDY_ENABLE_PERSONALIZED) ? (empty($conf->global->THEME_ELDY_TEXTLINK) ? $colortext : $conf->global->THEME_ELDY_TEXTLINK) : (empty($user->conf->THEME_ELDY_TEXTLINK) ? $colortextlink : $user->conf->THEME_ELDY_TEXTLINK);

$fontsize = empty($user->conf->THEME_ELDY_ENABLE_PERSONALIZED) ? (empty($conf->global->THEME_ELDY_FONT_SIZE1) ? $fontsize : $conf->global->THEME_ELDY_FONT_SIZE1) : (empty($user->conf->THEME_ELDY_FONT_SIZE1) ? $fontsize : $user->conf->THEME_ELDY_FONT_SIZE1);
$fontsizesmaller = empty($user->conf->THEME_ELDY_ENABLE_PERSONALIZED) ? (empty($conf->global->THEME_ELDY_FONT_SIZE2) ? $fontsize : $conf->global->THEME_ELDY_FONT_SIZE2) : (empty($user->conf->THEME_ELDY_FONT_SIZE2) ? $fontsize : $user->conf->THEME_ELDY_FONT_SIZE2);


if (empty($colortopbordertitle1))
    $colortopbordertitle1 = $colorbackhmenu1;


$colorbackvmenu1 = join(',', colorStringToArray($colorbackvmenu1)); // Normalize value to 'x,y,z'
$tmppart = explode(',', $colorbackvmenu1);
$tmpval = (!empty($tmppart[0]) ? $tmppart[0] : 0) + (!empty($tmppart[1]) ? $tmppart[1] : 0) + (!empty($tmppart[2]) ? $tmppart[2] : 0);
if ($tmpval <= 460) {
    $colortextbackvmenu = 'FFFFFF';
} else {
    $colortextbackvmenu = '000000';
}

$colorbacktitle1 = join(',', colorStringToArray($colorbacktitle1)); // Normalize value to 'x,y,z'
$tmppart = explode(',', $colorbacktitle1);
if ($colortexttitle == '') {
    $tmpval = (!empty($tmppart[0]) ? $tmppart[0] : 0) + (!empty($tmppart[1]) ? $tmppart[1] : 0) + (!empty($tmppart[2]) ? $tmppart[2] : 0);
    if ($tmpval <= 460) {
        $colortexttitle = 'FFFFFF';
        $colorshadowtitle = '888888';
    } else {
        $colortexttitle = '101010';
        $colorshadowtitle = 'FFFFFF';
    }
}

$colorbacktabcard1 = join(',', colorStringToArray($colorbacktabcard1)); // Normalize value to 'x,y,z'
$tmppart = explode(',', $colorbacktabcard1);
$tmpval = (!empty($tmppart[0]) ? $tmppart[0] : 0) + (!empty($tmppart[1]) ? $tmppart[1] : 0) + (!empty($tmppart[2]) ? $tmppart[2] : 0);
if ($tmpval <= 460) {
    $colortextbacktab = 'FFFFFF';
} else {
    $colortextbacktab = '111111';
}

// Format color value to match expected format (may be 'FFFFFF' or '255,255,255')
$colorbackhmenu1 = join(',', colorStringToArray($colorbackhmenu1));
$colorbackvmenu1 = join(',', colorStringToArray($colorbackvmenu1));
$colorbacktitle1 = join(',', colorStringToArray($colorbacktitle1));
$colorbacktabcard1 = join(',', colorStringToArray($colorbacktabcard1));
$colorbacktabactive = join(',', colorStringToArray($colorbacktabactive));
$colorbacklineimpair1 = join(',', colorStringToArray($colorbacklineimpair1));
$colorbacklineimpair2 = join(',', colorStringToArray($colorbacklineimpair2));
$colorbacklinepair1 = join(',', colorStringToArray($colorbacklinepair1));
$colorbacklinepair2 = join(',', colorStringToArray($colorbacklinepair2));
if ($colorbacklinepairhover != '')
    $colorbacklinepairhover = join(',', colorStringToArray($colorbacklinepairhover));
$colorbackbody = join(',', colorStringToArray($colorbackbody));
$colortexttitlenotab = join(',', colorStringToArray($colortexttitlenotab));
$colortexttitle = join(',', colorStringToArray($colortexttitle));
$colortext = join(',', colorStringToArray($colortext));
$colortextlink = join(',', colorStringToArray($colortextlink));

$nbtopmenuentries = $menumanager->showmenu('topnb');

print '/*' . "\n";
//var_dump($_SESSION['leftmenu']);
print 'leftmenu=' . $_SESSION['leftmenu'] . "\n";
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
/* Variables CSS natives pour les styles par défaut */
/* ============================================================================== */
:root {
--color-back-body: <?php print $colorbackbody; ?>;
--font-size-base: <?php print $fontsize; ?>;
--font-family-base: <?php print $fontlist; ?>;
--direction: <?php print $langs->trans("DIRECTION"); ?>;
--tooltip-width: <?php print dol_size(300, 'width'); ?>px;
--login-margin-top: <?php echo $dol_optimize_smallscreen ? '30' : '60' ?>px;
--color-text-back-vmenu: #<?php echo $colortextbackvmenu; ?>;
--font-size-smaller: <?php echo $fontsizesmaller; ?>px;
--url-object-user: url('<?php echo dol_buildpath($path . '/theme/' . $theme . '/img/object_user.png', 1); ?>');
--url-lock: url('<?php echo dol_buildpath($path . '/theme/' . $theme . '/img/lock.png', 1); ?>');
}

/*
* ATTENTION: Les règles CSS de cette section ont été transférées dans style.css.
* Nous ne gardons ici exceptionnellement que les règles où le NOM de la propriété
* CSS change dynamiquement (margin-left vs margin-right), car les CSS variables
* ne peuvent pas être utilisées dans les noms de propriétés.
*/

.left {text-align: <?php print $left; ?>;}
.right {text-align: <?php print $right; ?>;padding: 0 1em;}

div.divsearchfield {
float: <?php print $left; ?>;
margin-<?php print $right; ?>: 12px;
margin-<?php print $left; ?>: 2px;
margin-top: 4px;
margin-bottom: 4px;
padding-left: 2px;
}
/* ============================================================================== */
/* Styles to hide objects */
/* ============================================================================== */

/* Note: Les classes statiques telles que .clearboth, .hideobject, ont été transférées dans style.css */

/* rule for not too small screen only (Media query dynamique) */
@media only screen and (min-width: <?php echo round($nbtopmenuentries * 13 * 3.4, 0) + 7; ?>px)
{
.minwidth100 { min-width: 100px; }
.minwidth200 { min-width: 200px; }
.minwidth300 { min-width: 300px; }
.minwidth400 { min-width: 400px; }
.minwidth500 { min-width: 500px; }
.minwidth50imp { min-width: 50px !important; }
.minwidth100imp { min-width: 100px !important; }
.minwidth200imp { min-width: 200px !important; }
.minwidth300imp { min-width: 300px !important; }
.minwidth400imp { min-width: 400px !important; }
.minwidth500imp { min-width: 500px !important; }
}

/* Fin de la section CSS to hide objects */


/* ============================================================================== */
/* Styles de positionnement des zones */
/* ============================================================================== */


.underbanner {
border-bottom: <?php echo $borderwith; ?>px solid rgb(<?php echo $colortopbordertitle1 ?>);
}
.tdhrthin {
margin: 0;
padding-bottom: 0 !important;
}


/* ============================================================================== */
/* Menu top et 1ere ligne tableau */
/* ============================================================================== */

<?php
$minwidthtmenu = 66;   /* minimum width for one top menu entry */
$heightmenu = 48;   /* height of top menu, part with image */
$heightmenu2 = 48;  /* height of top menu, ârt with login  */
$disableimages = 0;
$maxwidthloginblock = 110;
if (!empty($conf->global->THEME_TOPMENU_DISABLE_IMAGE)) {
    $heightmenu = 30;
    $disableimages = 1;
    $maxwidthloginblock = 180;
    $minwidthtmenu = 0;
}
?>

div.tmenusep {
<?php if ($disableimages) { ?>
    display: none;
<?php } ?>
}

/* Classes div.tmenudisabled to ul.tmenu moved to style.css */
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
/* Dropdown and menu_titre classes moved to style.css */
<?php include dol_buildpath($path . '/theme/' . $theme . '/main_menu_fa_icons.inc.php', 0); ?>

<?php
// Add here more div for other menu entries. moduletomainmenu=array('module name'=>'name of class for div')

$moduletomainmenu = array(
    'user' => '',
    'syslog' => '',
    'societe' => 'companies',
    'projet' => 'project',
    'propale' => 'commercial',
    'commande' => 'commercial',
    'produit' => 'products',
    'service' => 'products',
    'stock' => 'products',
    'don' => 'accountancy',
    'tax' => 'accountancy',
    'banque' => 'accountancy',
    'facture' => 'accountancy',
    'compta' => 'accountancy',
    'accounting' => 'accountancy',
    'adherent' => 'members',
    'import' => 'tools',
    'export' => 'tools',
    'mailing' => 'tools',
    'contrat' => 'commercial',
    'ficheinter' => 'commercial',
    'deplacement' => 'commercial',
    'fournisseur' => 'companies',
    'barcode' => '',
    'fckeditor' => '',
    'categorie' => '',
);
$mainmenuused = 'home';
foreach ($conf->modules as $val) {
    $mainmenuused .= ',' . (isset($moduletomainmenu[$val]) ? $moduletomainmenu[$val] : $val);
}
//var_dump($mainmenuused);
$mainmenuusedarray = array_unique(explode(',', $mainmenuused));

$generic = 1;
// Put here list of menu entries when the div.mainmenu.menuentry was previously defined
$divalreadydefined = array('home', 'companies', 'products', 'commercial', 'externalsite', 'accountancy', 'project', 'tools', 'members', 'agenda', 'ftp', 'holiday', 'hrm', 'bookmark', 'cashdesk', 'ecm', 'geoipmaxmind', 'gravatar', 'clicktodial', 'paypal', 'webservices', 'websites');
// Put here list of menu entries we are sure we don't want
$divnotrequired = array('multicurrency', 'salaries', 'margin', 'opensurvey', 'paybox', 'expensereport', 'incoterm', 'prelevement', 'propal', 'workflow', 'notification', 'supplier_proposal', 'cron', 'product', 'productbatch', 'expedition');
foreach ($mainmenuusedarray as $val) {
    if (empty($val) || in_array($val, $divalreadydefined))
        continue;
    if (in_array($val, $divnotrequired))
        continue;
    //print "XXX".$val;
    // Search img file in module dir
    $found = 0;
    $url = '';
    foreach ($conf->file->dol_document_root as $dirroot) {
        if (file_exists($dirroot . "/" . $val . "/img/" . $val . ".png")) {
            $url = dol_buildpath('/' . $val . '/img/' . $val . '.png', 1);
            $found = 1;
            break;
        }
    }
    // Img file not found
    if (!$found) {
        $url = dol_buildpath($path . '/theme/' . $theme . '/img/menus/generic' . $generic . ".png", 1);
        $found = 1;
        if ($generic < 4)
            $generic++;
        print "/* A mainmenu entry was found but img file " . $val . ".png not found (check /" . $val . "/img/" . $val . ".png), so we use a generic one */\n";
    }
}
// End of part to add more div class css
?>

/* Login */

/* Login body moved to style.css */

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

/* login utilities and forms moved to style.css */
/* span-icons moved to style.css */
/*
.span-icon-user input, .span-icon-password input {
margin-right: 30px;
}
*/


/* End bootstrap */

<?php if (!empty($conf->global->MAIN_BUTTON_HIDE_UNAUTHORIZED)) { ?>
    .butActionRefused {
    display: none;
    }
<?php } ?>

/* --*/

/* ============================================================================== */
/* blockUI */
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
/* Datatable */
/* ============================================================================== */

table.dataTable tr.odd td.sorting_1, table.dataTable tr.even td.sorting_1 {
background: none !important;
}
.sorting_asc { background: url('<?php echo dol_buildpath('/theme/' . $theme . '/img/sort_asc.png', 1); ?>') no-repeat
center right !important; }
.sorting_desc { background: url('<?php echo dol_buildpath('/theme/' . $theme . '/img/sort_desc.png', 1); ?>') no-repeat
center right !important; }
.sorting_asc_disabled { background:
url('<?php echo dol_buildpath('/theme/' . $theme . '/img/sort_asc_disabled.png', 1); ?>') no-repeat center right
!important; }
.sorting_desc_disabled { background:
url('<?php echo dol_buildpath('/theme/' . $theme . '/img/sort_desc_disabled.png', 1); ?>') no-repeat center right
!important; }
.dataTables_paginate {
margin-top: 8px;
}
.paginate_button_disabled {
opacity: 1 !important;
color: #888 !important;
cursor: default !important;
}
.paginate_disabled_previous:hover, .paginate_enabled_previous:hover, .paginate_disabled_next:hover,
.paginate_enabled_next:hover
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



/* ============================================================================== */
/* POS */
/* ============================================================================== */

.menu_choix1 a {
background: url('<?php echo dol_buildpath($path . '/theme/' . $theme . '/img/menus/money.png', 1) ?>') top left
no-repeat;
background-position-y: 15px;
}
.menu_choix2 a {
background: url('<?php echo dol_buildpath($path . '/theme/' . $theme . '/img/menus/home.png', 1) ?>') top left
no-repeat;
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

/* Demo */
img.demothumb {
box-shadow: 2px 2px 8px #888;
margin-bottom: 4px;
margin-right: 20px;
margin-left: 10px;
}

/* Public */
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
width: 300px;
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
table.valid { position: absolute;
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

#mainmenua_billing .mainmenuaspan, #mainmenutd_accountancy .mainmenuaspan, #mainmenua_bank .mainmenuaspan,
#mainmenua_products .mainmenuaspan {display: none!important;}
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
font-size: <?php print is_numeric($fontsize) ? ($fontsize + 3) . 'px' : $fontsize; ?> !important;
}
}
/* ============================================================================== */
/* Custom styles for Main page <?php print $_SERVER['ORIG_PATH_INFO']; ?> */
/* ============================================================================== */
/* ============================================================================== */
/* Custom styles pages for <?php print $_SESSION['leftmenu']; ?> */
/* ============================================================================== */

<?php if ($_SESSION['leftmenu'] == 'customers_bills_checks' or $_SESSION['leftmenu'] == 'checks_bis') { ?>
    form.nocellnopadd{width: 99%;display: block;}
    form {width: 46%;display: inline-table;margin: 2em;}
    div.tabsAction {position: inherit;margin: 1em auto;text-align: center;}
    form#actionbookmark{margin: 0px;width:99%;}
<?php } ?>
<?php if ($_SESSION['leftmenu'] == 'home' or $_SESSION['leftmenu'] == 'home') { ?>
    .box .nohover:hover {background-color: white !important;}
    table.noborder td {padding:0!important}
<?php } ?>
<?php if ($_SESSION['leftmenu'] == '' and $_SESSION['mainmenu'] == 'billing') { ?>
    .fichethirdleft br {display:none;}
    .fichethirdleft .div-table-responsive-no-min {
    width: 47%;
    display: inline-block;
    margin: 0 1% 1% 1%;}
<?php } ?>

<?php

// Include the global.inc.php that include the badges, btn, info-box, dropdown, progress...
require __DIR__ . '/global.inc.php';


if (is_object($db))
    $db->close();

/* ====================== MLB PART ============================ */
/* =========================================================== */

require __DIR__ . '/style.css';
?>