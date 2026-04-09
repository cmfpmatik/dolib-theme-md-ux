/*
Copyright (c) 2003-2010, CKSource - Frederico Knabben. All rights reserved.
For licensing, see LICENSE.html or http://ckeditor.com/license
*/

CKEDITOR.editorConfig = function( config )
{
    // --- 1. RÉGLAGES DE COMPORTEMENT & UX ---
    config.enterMode = CKEDITOR.ENTER_BR;      // "Entrée" = saut de ligne simple
    config.resize_enabled = true;             // Active le redimensionnement manuel
    config.height = '350px';                   // Hauteur par défaut plus confortable
    config.fullPage = false;                   // Travaille sur des fragments HTML
    
    // Empêche le code PHP d'être corrompu lors de l'édition
    config.protectedSource.push( /<\?[\s\S]*?\?>/g ); 

    // Nettoyage au collage (UX : évite les polices bizarres venant de Word ou Web)
    config.forcePasteAsPlainText = true;      // Mettre à 'true' pour forcer le texte brut
    config.pasteFromWordRemoveFontStyles = true;
    config.pasteFromWordRemoveStyles = true;

    // Amélioration visuelle : Police sans-serif moderne par défaut
    config.contentsCss = 'body { font-family: Arial, Helvetica, sans-serif; font-size: 14px; line-height: 1.6; color: #333; }';

    // Nettoyage de l'interface
    config.removePlugins = 'elementspath,save'; 
    config.removeDialogTabs = 'flash:advanced';
    config.image_previewText = ' '; 
    config.dialog_backgroundCoverColor = 'rgb(255, 254, 253)';

    // --- 2. DÉFINITION DES BARRES D'OUTILS ---

    // Barre complète (Administration)
    config.toolbar_Full = [
        ['Source', 'Maximize', 'Preview', 'ShowBlocks'],
        ['Cut', 'Copy', 'Paste', 'PasteText', 'PasteFromWord'],
        ['Undo', 'Redo', '-', 'Find', 'Replace', '-', 'SelectAll', 'RemoveFormat'],
        ['Image', 'Table', 'HorizontalRule', 'Smiley', 'SpecialChar', 'PageBreak'],
        '/', // Saut de ligne pour la lisibilité
        ['Bold', 'Italic', 'Underline', 'Strike', '-', 'Subscript', 'Superscript'],
        ['NumberedList', 'BulletedList', '-', 'Outdent', 'Indent', 'Blockquote'],
        ['JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock'],
        ['Link', 'Unlink', 'Anchor'],
        ['Styles', 'Format', 'Font', 'FontSize'],
        ['TextColor', 'BGColor']
    ];

    // Barre pour les Emails (Équilibrée)
    config.toolbar_dolibarr_mailings = [
        ['Source', 'Maximize', '-', 'Preview'],
        ['Cut', 'Copy', 'Paste', 'PasteText', '-', 'Undo', 'Redo'],
        ['Format', 'Font', 'FontSize'],
        ['Bold', 'Italic', 'Underline', 'Strike', '-', 'TextColor', 'RemoveFormat'],
        ['NumberedList', 'BulletedList', '-', 'Outdent', 'Indent'],
        ['JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock'],
        ['Link', 'Unlink', 'Image', 'Table', 'SpecialChar']
    ];

    // Barre pour les Notes (Interne)
    config.toolbar_dolibarr_notes = [
        ['Maximize', 'SpellChecker'],
        ['Undo', 'Redo', '-', 'RemoveFormat'],
        ['Bold', 'Italic', 'Underline', 'Strike', '-', 'TextColor'],
        ['NumberedList', 'BulletedList', '-', 'Outdent', 'Indent'],
        ['Link', 'Unlink', 'Image', 'Table', 'HorizontalRule', 'SpecialChar']
    ];

    // Barre pour les lignes de détails (Minimaliste et efficace)
    config.toolbar_dolibarr_details = [
        ['Bold', 'Italic', 'Underline', 'Strike', '-', 'NumberedList', 'BulletedList'],
        ['JustifyLeft', 'JustifyCenter', 'JustifyRight'],
        ['Link', 'Unlink', 'SpecialChar', '-', 'RemoveFormat']
    ];

    // Mode lecture seule
    config.toolbar_dolibarr_readonly = [
        ['Source', 'Maximize', '-', 'Find']
    ];
};
