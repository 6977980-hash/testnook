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
define( 'TN_GA4_ID', 'G-RS6YGDD3HR' ); // inc/analytics.php; skipped outside production and in embeds
define( 'TN_CLARITY_ID', '' );  // e.g. abcd1234ef

// Google Search Console verification (the content= value of the meta tag).
// Printed in <head> on every page; empty means the tag is not printed.
define( 'TN_GSC_VERIFICATION', 'LgGNxktmq48vzeArdfmRHnDeMvQ6rIVafW6v0hlVlpg' );

// IndexNow key: served at /<key>.txt and used to ping Bing and friends on
// every content change (inc/indexnow.php). Public by design; empty disables it.
define( 'TN_INDEXNOW_KEY', '00f5e7841c724dd298a04e4d3648544a' );

// Founder / publisher identity (About page, Organization + Person schema).
define( 'TN_FOUNDER_NAME', 'Ali Ahmad' );
define( 'TN_FOUNDER_URL', 'https://www.linkedin.com/in/ali-ahmad-chaudhry-12777486/' );
// Short bio for the author box under every guide (plain text, one or two sentences).
define( 'TN_FOUNDER_BIO', 'Ali Ahmad founded Testnook and runs it. He has worked in IT and with computer hardware, repairs hardware himself and is a keen gamer. He plans every tool and guide, checks each release as described on the How we test page, and corrects pages when readers report a device that behaves differently.' );

// Testnook's own social profiles (full URLs), added to the Organization schema
// as sameAs. Empty until the brand has accounts; the founder's LinkedIn is above.
define( 'TN_SOCIAL_PROFILES', array() );
