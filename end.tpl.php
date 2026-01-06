<?php
/**
 * Fichier PHP : end.tpl.php
 * * Ce fichier est la fin du template HTML pour ce thème (montheme).
 * Il est chargé par llxFooter() dans la plupart des pages.
 */

// ----------------------------------------------------
// 1. INCLUSION DE VOTRE SCRIPT JS (require_once)
// ----------------------------------------------------
// Ceci garantit que votre formulairetest.js est chargé avant la fermeture du body.
require_once __DIR__ . '/js_includes.php'; 


// ----------------------------------------------------
// 2. FERMETURE DU HTML ET APPEL AU FOOTER STANDARD
// ----------------------------------------------------

// Afficher ici le code HTML (fermeture des balises, etc.) que Dolibarr attend.
// Souvent, la logique du pied de page est appelée par une fonction globale :
if (function_exists('llxFooter')) {
    llxFooter();
}
// Si vous savez que llxFooter() est déjà appelé dans le fichier PHP principal (comme dans ihm.php),
// vous pouvez simplifier l'inclusion :

// Laissez simplement la fermeture des balises HTML si llxFooter() est déjà appelé ailleurs
?>
</body>
</html>