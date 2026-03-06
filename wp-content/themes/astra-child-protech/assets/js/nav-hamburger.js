/**
 * Menu hamburger mobile – toggle ouverture/fermeture.
 */
(function() {
	function init() {
		var btn = document.getElementById('ept-nav-hamburger');
		var navBar = document.querySelector('.ept-nav-bar');
		var menu = document.getElementById('ept-nav-menu-dropdown');
		if (!btn || !navBar || !menu) return;

		function toggleMenu() {
			var isOpen = navBar.classList.contains('ept-nav-open');
			navBar.classList.toggle('ept-nav-open', !isOpen);
			btn.setAttribute('aria-expanded', !isOpen);
			btn.setAttribute('aria-label', !isOpen ? 'Fermer le menu' : 'Ouvrir le menu');
			if (!isOpen) {
				document.body.style.overflow = 'hidden';
			} else {
				document.body.style.overflow = '';
			}
		}

		function closeMenu() {
			navBar.classList.remove('ept-nav-open');
			btn.setAttribute('aria-expanded', 'false');
			btn.setAttribute('aria-label', 'Ouvrir le menu');
			document.body.style.overflow = '';
		}

		btn.addEventListener('click', toggleMenu);

		/* Fermer au clic sur un lien (navigation) */
		menu.addEventListener('click', function(e) {
			if (e.target.matches('a')) {
				closeMenu();
			}
		});

		/* Fermer au clic à l'extérieur */
		document.addEventListener('click', function(e) {
			if (navBar.classList.contains('ept-nav-open') && !navBar.contains(e.target) && !btn.contains(e.target)) {
				closeMenu();
			}
		});

		/* Fermer avec Escape */
		document.addEventListener('keydown', function(e) {
			if (e.key === 'Escape' && navBar.classList.contains('ept-nav-open')) {
				closeMenu();
			}
		});

		/* Réinitialiser au resize (retour desktop) */
		window.addEventListener('resize', function() {
			if (window.innerWidth > 1024) {
				closeMenu();
			}
		});
	}
	if (document.readyState === 'loading') {
		document.addEventListener('DOMContentLoaded', init);
	} else {
		init();
	}
})();
