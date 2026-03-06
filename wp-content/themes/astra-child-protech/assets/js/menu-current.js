/**
 * Marque le lien du menu dont l’URL correspond à la page courante (état actif).
 * Indépendant de WordPress current-menu-item.
 */
(function() {
	function init() {
		var path = window.location.pathname.replace(/\/+$/, '') || '/';
		var header = document.querySelector('.ept-nav-bar, .ast-site-header-wrap, header, .site-header');
		if (!header) return;
		var links = header.querySelectorAll('a[href]');
		links.forEach(function(a) {
			try {
				var href = a.getAttribute('href');
				if (!href || href.indexOf('#') === 0) return;
				var u = new URL(href, window.location.origin);
				if (u.origin !== window.location.origin) return;
				var linkPath = u.pathname.replace(/\/+$/, '') || '/';
				var match = (path === linkPath) || (path === '/' && (linkPath === '/' || linkPath === '/accueil'));
				if (match) {
					a.classList.add('ept-current-link');
					var li = a.closest('li');
					if (li) li.classList.add('ept-current-item');
				}
			} catch (e) {}
		});
	}
	if (document.readyState === 'loading') {
		document.addEventListener('DOMContentLoaded', init);
	} else {
		init();
	}
})();
