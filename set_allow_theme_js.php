<?php
// set_allow_theme_js.php
// Place this file in Dolibarr htdocs and run it from CLI or browser.
// Remove it after use.

 require_once __DIR__.'\..\..\main.inc.php'; // adapte le chemin si besoin

global $db;

$name = 'ALLOW_THEME_JS';
$value = '1';
$type = 'chaine';
$visible = 1;
$note = 'Enable theme js';
$entity = (isset($conf->entity) ? (int)$conf->entity : 0); // 0 = global, ou $conf->entity

// Use MAIN_DB_PREFIX and $db to build a safe query
$table = MAIN_DB_PREFIX.'const';

// Use $db->quote to avoid injection
$sql = "REPLACE INTO `" . $table . "` (`name`,`value`,`type`,`visible`,`note`,`entity`) VALUES ("
    . "'" . $db->escape($name) . "',"
    . "'" . $db->escape($value) . "',"
    . "'" . $db->escape($type) . "',"
    . (int)$visible . ","
    . "'" . $db->escape($note) . "',"
    . (int)$entity
    . ")";

$res = $db->query($sql);

if ($res) {
    echo "Succès : Constante '{$name}' définie à '{$value}' pour entity={$entity}.<br>";
    echo "Vous pouvez maintenant placer votre fichier JS dans theme/votre_theme/votre_theme.js";
} else {
    echo "Erreur SQL: " . $db->lasterror();
}