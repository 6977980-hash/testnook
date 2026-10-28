<?php
/**
 * Site-wide settings. Change values here, push, and Hostinger deploys them.
 */

defined( 'ABSPATH' ) || exit;

// Brand name shown in the header, titles and schema.
define( 'TN_SITE_NAME', 'Testnook' );

// Short tagline used in the homepage title and schema.
define( 'TN_TAGLINE', 'Free online hardware tests' );

// Public contact address shown on the Contact and Privacy pages.
define( 'TN_CONTACT_EMAIL', 'contact@testnook.com' );

// AdSense. Leave TN_ADS_ENABLED false until AdSense approves the site.
// When approved: set the publisher id (ca-pub-XXXXXXXXXXXXXXXX) and flip the flag.
// ads.txt is then served automatically from the publisher id.
define( 'TN_ADS_ENABLED', false );
define( 'TN_ADSENSE_CLIENT', '' );

// Analytics ids. Empty means the tag is not printed.
define( 'TN_GA4_ID', '' );      // e.g. G-XXXXXXXXXX
define( 'TN_CLARITY_ID', '' );  // e.g. abcd1234ef

// IndexNow key (Phase 6). Empty disables the key file and pings.
define( 'TN_INDEXNOW_KEY', '' );

// Founder / publisher identity (About page, Organization + Person schema).
define( 'TN_FOUNDER_NAME', 'Ali Ahmad' );
define( 'TN_FOUNDER_URL', 'https://www.linkedin.com/in/ali-ahmad-chaudhry-12777486/' );
