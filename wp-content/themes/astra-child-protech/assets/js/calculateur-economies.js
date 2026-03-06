/**
 * Calculateur d'économies solaire – front
 * Formule simplifiée : facture mensuelle → consommation kWh estimée → économies avec solaire.
 */
(function ($) {
	'use strict';

	var tarifEneo = window.protechCalculateur && window.protechCalculateur.tarifEneo ? window.protechCalculateur.tarifEneo : 75;
	var labels = window.protechCalculateur && window.protechCalculateur.labels ? window.protechCalculateur.labels : {
		economies_an: 'Économies estimées / an',
		payback: 'Payback estimé',
		kwh_produits: 'kWh produits / an (est.)',
		ans: 'ans',
		fcfa: 'FCFA'
	};

	function formatNumber(n) {
		return new Intl.NumberFormat('fr-FR', { maximumFractionDigits: 0 }).format(n);
	}

	function estimateConsommationKwh(factureMensuelleFcfa) {
		// Consommation ≈ facture / tarif (FCFA/kWh)
		if (tarifEneo <= 0) return 0;
		return (factureMensuelleFcfa * 12) / tarifEneo;
	}

	function estimateEconomies(factureMensuelleFcfa, tarif) {
		tarif = tarif || tarifEneo;
		var consoAnuelle = estimateConsommationKwh(factureMensuelleFcfa);
		// Économies brutes si on compense 70% par le solaire (hypothèse conservative)
		var partSolaire = 0.7;
		var economieKwhAn = consoAnuelle * partSolaire;
		var economieFcfaAn = economieKwhAn * tarif;
		// Coût solaire indicatif : ~800 000 FCFA/kWc installé (ordre de grandeur 2026)
		var kwcEstime = Math.min(500, Math.max(10, consoAnuelle / 1500));
		var coutSolaire = kwcEstime * 800000;
		var paybackAn = economieFcfaAn > 0 ? (coutSolaire / economieFcfaAn) : 0;
		return {
			economieFcfaAn: Math.round(economieFcfaAn),
			paybackAn: Math.round(paybackAn * 10) / 10,
			kwhProduitsAn: Math.round(economieKwhAn),
			consoAnuelle: Math.round(consoAnuelle),
			kwcEstime: Math.round(kwcEstime)
		};
	}

	$(function () {
		var $form = $('#protech-calculateur-form');
		var $resultat = $('#protech-calculateur-resultat');
		if (!$form.length || !$resultat.length) return;

		$form.on('submit', function (e) {
			e.preventDefault();
			var facture = parseFloat($('#protech-facture').val(), 10) || 0;
			if (facture <= 0) {
				$resultat.show().html('<p>' + (labels.fcfa ? 'Indiquez une facture mensuelle.' : 'Indiquez une facture mensuelle.') + '</p>');
				return;
			}
			var res = estimateEconomies(facture);
			var html = '<p><strong>' + labels.economies_an + ':</strong> ' + formatNumber(res.economieFcfaAn) + ' ' + (labels.fcfa || 'FCFA') + '</p>' +
				'<p><strong>' + labels.payback + ':</strong> ' + res.paybackAn + ' ' + (labels.ans || 'ans') + '</p>' +
				'<p><strong>' + labels.kwh_produits + ':</strong> ' + formatNumber(res.kwhProduitsAn) + ' kWh</p>';
			$resultat.html(html).show();
		});
	});
})(jQuery);
