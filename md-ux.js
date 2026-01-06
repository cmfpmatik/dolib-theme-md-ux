/* 
 * md-ux.js
 * Script du thème md-ux : option B
 * Comportement : d'abord vérifier la présence de la classe `.twocolumns` (après DOM ready).
 * Si absente, utiliser une liste d'URLs en fallback. Affiche une alerte une seule fois.
 */
/* * md-ux.js
 * Script du thème md-ux : option B
 * Comportement : ajoute les raccourcis ET vérifie la présence de la classe `.twocolumns` (après DOM ready).
 */

(function() {
	'use strict';

	// =================================================================================
	// 1. LISTE DES RACCOURCIS (À MODIFIER)
	// =================================================================================
	// Utilisez DOL_URL_ROOT pour le chemin de base (ex: /dolibarr).
	// Le reste du chemin doit être le chemin exact du module.
	const quickLinksData = [
		{ 
            label: "Produits/Services", 
            url: "http://localhost/dolibarr/product/index.php?mainmenu=products&leftmenu=" 
        },
		{ 
            label: "Facturation", 
            url:  "http://localhost/dolibarr/compta/index.php?mainmenu=billing&leftmenu=" 
        },
		{ 
            label: "Accueil Admin", 
            url: "/admin/index.php" 
        },
        // Ajoutez d'autres raccourcis ici :
        // { label: "Nouveau Tiers", url: DOL_URL_ROOT + "/societe/card.php?action=create" }
	];

	// ID du conteneur HTML où seront insérés les liens.
	// Assurez-vous d'avoir bien placé <div id="quick-link-container"></div> dans votre header.
	const targetContainerId = "id-right"; 

	// =================================================================================
	// 2. LOGIQUE D'INJECTION DES LIENS
	// =================================================================================
	function injectQuickLinks(linksData, targetId) {
    const targetElement = document.getElementById(targetId);

    if (!targetElement) {
        if (window.console && console.warn) console.warn("Le conteneur de liens rapides '" + targetId + "' est manquant dans le HTML du thème.");
        return;
    }
    
    // Assurez-vous que DOL_URL_ROOT est accessible globalement ou utilisez une valeur par défaut
    const baseURL = (typeof DOL_URL_ROOT !== 'undefined') ? DOL_URL_ROOT : '/dolibarr'; 

     
    // --- Création de la <div> enveloppante ---
        const wrapperDiv = document.createElement('div');
        // CORRECTION DE L'ERREUR : Passer chaque classe comme argument séparé
        wrapperDiv.classList.add('titre', 'inline-block');
    
    
    
    linksData.forEach(item => {
      
        // --- Correction de l'URL ---
        let finalUrl = item.url;
        // Si l'URL est relative et ne commence pas par le chemin de base (ex: /compta/...),
        // on ajoute baseURL si ce n'est pas déjà un chemin absolu (http://...)
        if (!finalUrl.startsWith('http') && !finalUrl.startsWith(baseURL)) {
             finalUrl = baseURL + finalUrl;
        }

        
        
        const newLink = document.createElement('a');
        newLink.href = finalUrl; // Utilisation de l'URL corrigée
        newLink.textContent = item.label; // Le libellé cliquable
        newLink.title = "Accès rapide à " + item.label;
        newLink.classList.add('custom-nav-shortcut'); 
      
      
        
         // --- Assemblage ---
        wrapperDiv.appendChild(newLink);
        targetElement.appendChild(wrapperDiv);
    });

    if (window.console && console.log) console.log(linksData.length + " liens de raccourcis injectés.");
    
   
}
undefined 

	// =================================================================================
	// 3. LOGIQUE EXISTANTE (avec appel à l'injection)
	// =================================================================================

	function hasTwoColumns() {
		if (window.jQuery) return !!window.jQuery('.twocolumns').length;
		return !!document.querySelector('.twocolumns');
	}

	function urlMatchesList() {
		try {
			var p = window.location.pathname || '';
			if (p.length > 1 && p.slice(-1) === '/') p = p.slice(0, -1);
			var candidates = [
				'/core/tools.php',
				'/hrm/index.php',
				'/compta/bank/list.php',
				'/admin/index.php'
			];
			for (var i = 0; i < candidates.length; i++) {
				// Utilisation de la méthode moderne .endsWith() ou .includes() pour plus de précision
				if (p.endsWith(candidates[i])) return true; 
			}
		} catch (e) {
			if (window.console && console.error) console.error('urlMatchesList error', e);
		}
		return false;
	}

	function doActionsWhenReady() { // Renommée pour être plus générique
		try {
      			// 1. RECHERCHE DE LA ZONE D'EN-TÊTE PRINCIPALE (ID LE PLUS FIABLE POUR LE HAUT)
            // On cible #id-top qui est le conteneur du haut de page.
            const haut = document.querySelector('#id-container'); 
            
            if (haut) {
                
                // 2. CRÉATION DU CONTENEUR DE RACCOURCIS
                const quickLinkContainer = document.createElement('div');
                quickLinkContainer.id = targetContainerId; 
                quickLinkContainer.classList.add('titre','inline-block'); 
                
                // 3. INJECTION du nouveau conteneur AU DÉBUT de la zone d'en-tête (pour être en haut)
                // L'injection se fait en tant que premier enfant de header#id-top
                haut.prepend(quickLinkContainer);
            // Appel de la nouvelle fonction pour INJECTER les liens RAPIDES
            injectQuickLinks(quickLinksData, targetContainerId);
              
              } else {
                 if (window.console && console.warn) console.warn("Le conteneur principal header#id-top n'a pas été trouvé. Injection impossible.");
            }
            
            // Logique de bascule de la barre latérale (Votre code existant)
			var shouldCollapse = false;

			if (hasTwoColumns() || urlMatchesList()) {
				shouldCollapse = true;
			}

			if (shouldCollapse) {
				if (!window._md_ux_alert_shown) {
					window._md_ux_alert_shown = true;
                    // Assurez-vous que jQuery est disponible pour cette ligne si vous l'utilisez
					if (window.jQuery) {
                        window.jQuery("body").toggleClass("sidebar-collapse")
                    } else {
                        // Fallback simple si jQuery n'est pas là
                        document.body.classList.toggle("sidebar-collapse");
                    }
				}
			}
		} catch (e) {
			if (window.console && console.error) console.error('doActionsWhenReady error', e);
		}
	}

	// Attendre le DOM ready (jQuery si disponible, sinon DOMContentLoaded)
	if (window.jQuery) {
		window.jQuery(function() { doActionsWhenReady(); });
	} else {
		if (document.readyState === 'loading') {
			document.addEventListener('DOMContentLoaded', doActionsWhenReady);
		} else {
			doActionsWhenReady();
		}
	}

})();
(function() {
	'use strict';

	// Retourne true si la page contient un élément avec la classe .twocolumns
	function hasTwoColumns() {
		if (window.jQuery) return !!window.jQuery('.twocolumns').length;
		return !!document.querySelector('.twocolumns');
	}

	// Retourne true si l'URL courante correspond à l'une des URLs spéciales
	function urlMatchesList() {
		try {
			var p = window.location.pathname || '';
			if (p.length > 1 && p.slice(-1) === '/') p = p.slice(0, -1);
			var candidates = [
				'/core/tools.php',
				//'/comm/action/index.php',
				//'/ecm/index.php',
				'/hrm/index.php',
				'/compta/bank/list.php',
				'/admin/index.php'
			];
			for (var i = 0; i < candidates.length; i++) {
				if (p.indexOf(candidates[i]) !== -1) return true;
			}
		} catch (e) {
			if (window.console && console.error) console.error('urlMatchesList error', e);
		}
		return false;
	}

	// Fonction exécutée une fois le DOM prêt
	function doAlertWhenReady() {
		try {
			var shouldAlert = false;
			// Option B : d'abord .twocolumns, sinon fallback sur URLs
			if (hasTwoColumns()) {
				shouldAlert = true;
			} else if (urlMatchesList()) {
				shouldAlert = true;
			}

			if (shouldAlert) {
				if (!window._md_ux_alert_shown) {
					window._md_ux_alert_shown = true;
					$("body").toggleClass("sidebar-collapse")
                    
				}
			}
		} catch (e) {
			if (window.console && console.error) console.error('doAlertWhenReady error', e);
		}
	}

	// Attendre le DOM ready (jQuery si disponible, sinon DOMContentLoaded)
	if (window.jQuery) {
		window.jQuery(function() { doAlertWhenReady(); });
	} else {
		if (document.readyState === 'loading') {
			document.addEventListener('DOMContentLoaded', doAlertWhenReady);
		} else {
			doAlertWhenReady();
		}
	}
	

})();