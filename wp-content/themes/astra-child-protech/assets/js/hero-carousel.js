/**
 * Carrousel hero : 5 slides, défilement auto 4 s, indicateurs (points) synchronisés et cliquables
 */
(function() {
	function run() {
		var track = document.getElementById('hero-carousel-track');
		var dotsContainer = document.getElementById('hero-carousel-dots');
		if (!track) return;
		var total = 5;
		var index = 0;
		var dots = dotsContainer ? dotsContainer.querySelectorAll('button') : [];
		var timer = null;

		function setSlide(i) {
			index = (i + total) % total;
			track.style.transform = 'translateX(-' + (index * 20) + '%)';
			dots.forEach(function(btn, j) {
				btn.classList.remove('bg-protech-gold', 'ring-2', 'ring-white', 'ring-offset-2');
				btn.classList.add('bg-white/40');
				if (j === index) {
					btn.classList.remove('bg-white/40');
					btn.classList.add('bg-protech-gold', 'ring-2', 'ring-white', 'ring-offset-2', 'ring-offset-transparent');
				}
			});
		}

		function next() {
			setSlide(index + 1);
		}

		function startTimer() {
			if (timer) clearInterval(timer);
			timer = setInterval(next, 4000);
		}

		setSlide(0);
		dots.forEach(function(btn, i) {
			btn.addEventListener('click', function() {
				setSlide(i);
				startTimer();
			});
		});
		startTimer();
	}
	if (document.readyState === 'loading') {
		document.addEventListener('DOMContentLoaded', run);
	} else {
		run();
	}
})();
