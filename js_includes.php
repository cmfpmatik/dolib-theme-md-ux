<?php
/**
 * Fichier PHP : js_includes.php
 */

if (defined('DOL_URL_ROOT')) {
    // REMPLACEZ 'montheme' par le nom réel de votre thème
    $theme_name = 'md-ux'; 
    $js_file = '/theme/' . $theme_name . '/formulairetest.js';
    
    echo '<script type="text/javascript" src="'.DOL_URL_ROOT . $js_file.'"></script>'."\n";
}
?>