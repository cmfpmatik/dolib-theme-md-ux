/**
 * Fichier JavaScript : formulairetest.js
 * CORRIGÉ : Corrections de la cible URL et du sélecteur ID.
 */

// Utilisez VAR ici si vous conservez ce bloc. Sinon, supprimez-le et utilisez l'IIFE ci-dessous.
if (typeof formulaireHTML === "undefined") {
    var formulaireHTML = `
        <div class="form-container">
            <h2>Contactez-nous (Formulaire non fonctionnel ici)</h2>
            </div>
    `;
}

// ----------------------------------------------------------------------
// SOLUTON RETENUE : Isoler toute la logique dans une portée (scope) unique (IIFE).
// ----------------------------------------------------------------------
console.log("--- DEBUG : formulairetest.js CHARGÉ ! ---"); 
(function() {
    'use strict';
    // Déclaration LOCALISÉE pour éviter les erreurs de redéclaration (const est dans l'IIFE)
    const formulaireHTML = `
        <div class="form-container">
            <h2>Contactez-nous</h2>
            <form id="contactForm">
                <div class="form-group">
                    <label for="nom">Nom :</label>
                    <input type="text" id="nom" name="nom" required>
                    <div class="error" id="nomError"></div>
                </div>
                <button type="submit">Envoyer le message</button>
            </form>
        </div>
    `;
   

    function injectFormulaireAvant(cibleSelector, htmlContent) {
        const cibleElement = document.querySelector(cibleSelector);

        if (cibleElement) {
            console.log("DEBUG SÉLECTEUR TROUVÉ : " + cibleSelector);
            const conteneurForm = document.createElement('div');
            conteneurForm.id = 'form-container-injected';
            conteneurForm.classList.add('center');
            conteneurForm.insertAdjacentHTML('afterbegin', htmlContent);
            
            // Ligne pour injecter en BAS (à la fin du contenu)
            cibleElement.insertAdjacentElement('beforeend', conteneurForm); 
            
            console.log("Formulaire injecté en FIN de : " + cibleSelector);
        } else {
            console.error("DEBUG SÉLECTEUR ÉCHEC : L'élément " + cibleSelector + " N'A PAS ÉTÉ TROUVÉ.");
        }
    }

    function attacherValidationFormulaire() {
        // ... (votre code) ...
    }

    /**
     * Fonction exécutée lorsque le DOM est prêt (ou après le setTimeout).
     */
    function doActionsWhenReady() {
        try {
            console.log("DEBUG URL PATH : " + window.location.pathname);
            
            if (window.location.pathname.endsWith('/admin/ihm.php')) {
                
                console.log("DEBUG PAGE CIBLE : OK. Tentative d'injection.");
                
                // --- LISTE DES SÉLECTEURS À TESTER PAR ORDRE DE PRÉFÉRENCE ---
                const selectorsToTry = [
                    'div.fiche', 
                    '#id-right', 
                    'div.fichearearef', // Un autre conteneur possible dans Dolibarr
                    'body' // L'élément le plus sûr (doit fonctionner)
                ]; 
                
                let injectionSuccess = false;

                for (const selector of selectorsToTry) {
                    // Tente l'injection avec le sélecteur actuel
                    injectFormulaireAvant(selector, formulaireHTML);
                    
                    // Vérifie si l'injection a réussi
                    if (document.querySelector('#form-container-injected')) {
                        injectionSuccess = true;
                        console.log(`Injection réussie avec le sélecteur : ${selector}`);
                        break; // Arrête la boucle dès que l'injection est faite
                    }
                }

                if (injectionSuccess) {
                    attacherValidationFormulaire();
                } else {
                    console.error("ÉCHEC FATAL : Le formulaire n'a pu être injecté sur aucun sélecteur.");
                }

            } else {
                console.warn("DEBUG PAGE NON CIBLE : L'injection est ignorée pour cette page.");
            }
        } catch (e) {
            if (window.console && console.error) console.error('doActionsWhenReady error', e);
        }
    }

    // --- DÉCLENCHEUR FINAL AVEC TIMEOUT ---
    setTimeout(doActionsWhenReady, 500); // 0.5s de délai

})();