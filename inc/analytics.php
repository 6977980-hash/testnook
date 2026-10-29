<?php
/**
 * Google Analytics 4 (gtag.js), printed early in <head> on every page.
 *
 * Skipped when TN_GA4_ID is empty, outside production (WP_ENVIRONMENT_TYPE
 * local/development/staging), inside ?embed=1 iframes (those visits belong to
 * the host site) and for logged-in admins (so Ali's own checks do not count).
 *
 * Consent Mode v2 defaults: ad and analytics storage are denied in the EEA, the
 * UK and Switzerland until a consent message (the AdSense / Funding Choices
 * CMP) grants them, so GA4 sends cookieless pings there; elsewhere they are
 * granted. ads_data_redaction strips ad identifiers while ad_storage is denied.
 */

defined( 'ABSPATH' ) || exit;

/** Regions where consent is required before storage (EEA + UK + CH). */
const TN_CONSENT_REGIONS = array( 'AT', 'BE', 'BG', 'HR', 'CY', 'CZ', 'DK', 'EE', 'FI', 'FR', 'DE', 'GR', 'HU', 'IS', 'IE', 'IT', 'LV', 'LI', 'LT', 'LU', 'MT', 'NL', 'NO', 'PL', 'PT', 'RO', 'SK', 'SI', 'ES', 'SE', 'GB', 'CH' );

function tn_ga4_enabled() {
	return TN_GA4_ID
		&& 'production' === wp_get_environment_type()
		&& ! tn_is_embed()
		&& ! current_user_can( 'manage_options' );
}

add_action(
	'wp_head',
	function () {
		if ( ! tn_ga4_enabled() ) {
			return;
		}
		$denied  = array(
			'ad_storage'         => 'denied',
			'ad_user_data'       => 'denied',
			'ad_personalization' => 'denied',
			'analytics_storage'  => 'denied',
			'region'             => TN_CONSENT_REGIONS,
			'wait_for_update'    => 500,
		);
		$granted = array(
			'ad_storage'         => 'granted',
			'ad_user_data'       => 'granted',
			'ad_personalization' => 'granted',
			'analytics_storage'  => 'granted',
		);
		printf( "<script async src=\"https://www.googletagmanager.com/gtag/js?id=%s\"></script>\n", esc_attr( rawurlencode( TN_GA4_ID ) ) );
		echo "<script>window.dataLayer=window.dataLayer||[];function gtag(){dataLayer.push(arguments);}"
			. "gtag('consent','default'," . wp_json_encode( $denied ) . ');'
			. "gtag('consent','default'," . wp_json_encode( $granted ) . ');'
			. "gtag('set','ads_data_redaction',true);"
			. "gtag('js',new Date());gtag('config'," . wp_json_encode( TN_GA4_ID ) . ");</script>\n"; // phpcs:ignore WordPress.Security.EscapeOutput
	},
	2
);
