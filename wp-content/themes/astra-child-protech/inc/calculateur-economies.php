<?php
/**
 * Shortcode calculateur d'économies solaire
 *
 * Formule simplifiée : économies ≈ (consommation kWh × tarif ENEO) - (coût solaire amorti).
 * Front: formulaire (facture mensuelle, puissance groupe, ville) → résultat économies/an, payback, kWh produits.
 *
 * @package Astra_Child_Protech
 */

defined( 'ABSPATH' ) || exit;

/**
 * Tarif ENEO indicatif (FCFA/kWh) – à mettre à jour selon année.
 */
function astra_child_protech_get_tarif_eneo_default() {
	return (float) apply_filters( 'protech_tarif_eneo_kwh', 75 );
}

/**
 * Shortcode [protech_calculateur_economies]
 */
function astra_child_protech_shortcode_calculateur( $atts ) {
	$atts = shortcode_atts(
		array(
			'title' => __( 'Simulateur d\'économies', 'astra-child-protech' ),
			'cta'   => __( 'Calculer mes économies', 'astra-child-protech' ),
		),
		$atts,
		'protech_calculateur_economies'
	);

	wp_enqueue_script(
		'protech-calculateur',
		get_stylesheet_directory_uri() . '/assets/js/calculateur-economies.js',
		array( 'jquery' ),
		ASTRA_CHILD_PROTECH_VERSION,
		true
	);

	wp_localize_script( 'protech-calculateur', 'protechCalculateur', array(
		'tarifEneo' => astra_child_protech_get_tarif_eneo_default(),
		'labels'    => array(
			'economies_an' => __( 'Économies estimées / an', 'astra-child-protech' ),
			'payback'      => __( 'Payback estimé', 'astra-child-protech' ),
			'kwh_produits' => __( 'kWh produits / an (est.)', 'astra-child-protech' ),
			'ans'          => __( 'ans', 'astra-child-protech' ),
			'fcfa'         => __( 'FCFA', 'astra-child-protech' ),
		),
	) );

	ob_start();
	?>
	<div class="protech-calculateur" id="protech-calculateur">
		<h3 class="protech-calculateur-title"><?php echo esc_html( $atts['title'] ); ?></h3>
		<form id="protech-calculateur-form" class="protech-calculateur-form">
			<p>
				<label for="protech-facture"><?php esc_html_e( 'Facture ENEO mensuelle (FCFA)', 'astra-child-protech' ); ?></label>
				<input type="number" id="protech-facture" name="facture" min="0" step="1000" placeholder="500000" required>
			</p>
			<p>
				<label for="protech-groupe"><?php esc_html_e( 'Puissance groupe électrogène (kVA)', 'astra-child-protech' ); ?></label>
				<input type="number" id="protech-groupe" name="groupe" min="0" step="10" placeholder="100">
			</p>
			<p>
				<label for="protech-ville"><?php esc_html_e( 'Ville / Zone', 'astra-child-protech' ); ?></label>
				<select id="protech-ville" name="ville">
					<option value="douala">Douala</option>
					<option value="yaounde">Yaoundé</option>
					<option value="bafoussam">Bafoussam</option>
					<option value="bamenda">Bamenda</option>
					<option value="garoua">Garoua</option>
					<option value="autre">Autre</option>
				</select>
			</p>
			<p>
				<button type="submit" class="protech-cta-primary"><?php echo esc_html( $atts['cta'] ); ?></button>
			</p>
		</form>
		<div id="protech-calculateur-resultat" class="resultat" aria-live="polite" style="display:none;"></div>
	</div>
	<?php
	return ob_get_clean();
}
add_shortcode( 'protech_calculateur_economies', 'astra_child_protech_shortcode_calculateur' );
