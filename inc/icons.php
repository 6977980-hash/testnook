<?php
/**
 * Inline SVG icons (24x24, stroke = currentColor).
 */

defined( 'ABSPATH' ) || exit;

function tn_icon( $name, $size = 24 ) {
	$paths = array(
		'keyboard'   => '<rect x="2" y="6" width="20" height="12" rx="2"/><path d="M6 10h.01M10 10h.01M14 10h.01M18 10h.01M8 14h8"/>',
		'mouse'      => '<rect x="6" y="3" width="12" height="18" rx="6"/><path d="M12 7v4"/>',
		'controller' => '<path d="M6 11h4M8 9v4M15 12h.01M18 10h.01"/><path d="M17.3 5H6.7a4 4 0 0 0-3.9 3.2l-1 5.3A3 3 0 0 0 4.7 17c.9 0 1.7-.4 2.3-1.1L8.6 14h6.8l1.6 1.9c.6.7 1.4 1.1 2.3 1.1a3 3 0 0 0 2.9-3.5l-1-5.3A4 4 0 0 0 17.3 5z"/>',
		'screen'     => '<rect x="2" y="3" width="20" height="14" rx="2"/><path d="M8 21h8M12 17v4"/>',
		'audio'      => '<path d="M11 5 6 9H2v6h4l5 4V5z"/><path d="M15.5 8.5a5 5 0 0 1 0 7M19 5a10 10 0 0 1 0 14"/>',
		'camera'     => '<path d="M23 7l-7 5 7 5V7z"/><rect x="1" y="5" width="15" height="14" rx="2"/>',
		'benchmark'  => '<circle cx="12" cy="13" r="8"/><path d="M12 9v4l2 2M9 2h6"/>',
		'phone'      => '<rect x="6" y="2" width="12" height="20" rx="2"/><path d="M11 18h2"/>',
		'memory'     => '<path d="M9 3a4 4 0 0 0-4 4 3 3 0 0 0-1 5.5A3 3 0 0 0 6 18a3 3 0 0 0 6 0V7a4 4 0 0 0-3-4z"/><path d="M15 3a4 4 0 0 1 4 4 3 3 0 0 1 1 5.5A3 3 0 0 1 18 18a3 3 0 0 1-6 0"/><path d="M12 7v11"/>',
		'typing'     => '<rect x="2" y="7" width="20" height="12" rx="2"/><path d="M7 15h10M6 11h.01M10 11h.01M14 11h.01M18 11h.01"/><path d="M8 3h8M12 3v4"/>',
		'eye'        => '<path d="M2 12s3.6-7 10-7 10 7 10 7-3.6 7-10 7S2 12 2 12z"/><circle cx="12" cy="12" r="3"/>',
		'system'     => '<rect x="5" y="5" width="14" height="14" rx="2"/><rect x="9" y="9" width="6" height="6"/><path d="M9 2v3M15 2v3M9 19v3M15 19v3M2 9h3M2 15h3M19 9h3M19 15h3"/>',
		'sun'        => '<circle cx="12" cy="12" r="4"/><path d="M12 2v2M12 20v2M4.9 4.9l1.4 1.4M17.7 17.7l1.4 1.4M2 12h2M20 12h2M4.9 19.1l1.4-1.4M17.7 6.3l1.4-1.4"/>',
		'moon'       => '<path d="M21 12.8A9 9 0 1 1 11.2 3 7 7 0 0 0 21 12.8z"/>',
		'menu'       => '<path d="M3 6h18M3 12h18M3 18h18"/>',
		'close'      => '<path d="M18 6 6 18M6 6l12 12"/>',
		'search'     => '<circle cx="11" cy="11" r="7"/><path d="m20 20-3.5-3.5"/>',
		'expand'     => '<path d="M8 3H5a2 2 0 0 0-2 2v3M21 8V5a2 2 0 0 0-2-2h-3M3 16v3a2 2 0 0 0 2 2h3M16 21h3a2 2 0 0 0 2-2v-3"/>',
		'shield'     => '<path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/><path d="m9 12 2 2 4-4"/>',
		'code'       => '<path d="m16 18 6-6-6-6M8 6l-6 6 6 6"/>',
		'info'       => '<circle cx="12" cy="12" r="10"/><path d="M12 16v-4M12 8h.01"/>',
		'book'       => '<path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20V3H6.5A2.5 2.5 0 0 0 4 5.5v14z"/><path d="M4 19.5A2.5 2.5 0 0 0 6.5 22H20v-5"/>',
	);
	if ( ! isset( $paths[ $name ] ) ) {
		return '';
	}
	return '<svg class="icon" width="' . (int) $size . '" height="' . (int) $size . '" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" focusable="false">' . $paths[ $name ] . '</svg>';
}
