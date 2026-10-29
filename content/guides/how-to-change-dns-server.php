<?php
defined( 'ABSPATH' ) || exit;
return array(
	'title'       => 'How to Change Your DNS Server (Windows, Mac, Phone, Router)',
	'seo_title'   => 'How to Change DNS Server on Windows, Mac, Android & iPhone',
	'description' => 'Step-by-step: change your DNS server to Cloudflare, Google or Quad9 on Windows, Mac, Android, iPhone, your router and your browser, and check that it worked.',
	'blurb'       => 'Switch to a faster or more private DNS server on every device, and check that the change worked.',
	'hub'         => 'system',
	'tool'        => 'dns-lookup',
	'tools'       => array( 'what-is-my-ip' ),
	'published'   => '2026-10-29',
	'updated'     => '2026-10-29',
	'intro'       => 'Your DNS server turns names like testnook.com into the IP addresses your device connects to. By default it is your internet provider\'s, which can be slow, unreliable or filtered. Switching to a public resolver such as Cloudflare, Google or Quad9 takes two minutes and can make websites start loading faster and fix sites that will not open. Here is how to do it on each device, and how to check it worked.',
	'summary'     => array(
		'Popular choices: <strong>Cloudflare 1.1.1.1 and 1.0.0.1</strong>, <strong>Google 8.8.8.8 and 8.8.4.4</strong>, <strong>Quad9 9.9.9.9 and 149.112.112.112</strong> (Quad9 also blocks known malicious domains).',
		'Change it on the <strong>router</strong> to cover every device at home, or on one <strong>device</strong>: Windows network settings, Mac Wi-Fi details, Android Private DNS, iPhone Configure DNS.',
		'Pick the fastest for you with the DNS server speed test in the <a href="/dns-lookup/">DNS lookup</a> tool.',
		'DNS changes how fast sites <strong>start</strong> loading and which sites resolve. It does not change download speed or game ping.',
	),
	'sections'    => array(
		array(
			'Why change your DNS server?',
			'<p>Every time you open a site or an app connects somewhere, your device first asks a DNS resolver for the address. A slow resolver adds a delay before anything loads; a broken one makes sites fail with "server not found" even though the internet works. Common reasons to switch:</p>
<ul>
<li><strong>Speed:</strong> a resolver close to you with a large cache answers in a few milliseconds.</li>
<li><strong>Reliability:</strong> provider DNS servers sometimes go down while the rest of the line works.</li>
<li><strong>Privacy:</strong> some public resolvers keep fewer logs and support encrypted DNS.</li>
<li><strong>Security:</strong> Quad9, Cloudflare for Families (1.1.1.2) and others block known malware and phishing domains.</li>
</ul>
<p>It will not raise your Mbps or lower your ping in a match. If those are the problem, see <a href="/what-is-a-good-internet-speed/">what is a good internet speed</a> and <a href="/how-to-reduce-ping/">how to reduce ping</a>.</p>',
			'why',
		),
		array(
			'Which DNS server to choose',
			'<table><thead><tr><th>Provider</th><th>IPv4</th><th>IPv6</th><th>Encrypted DNS name</th></tr></thead><tbody>
<tr><td>Cloudflare</td><td>1.1.1.1, 1.0.0.1</td><td>2606:4700:4700::1111, 2606:4700:4700::1001</td><td>one.one.one.one</td></tr>
<tr><td>Google Public DNS</td><td>8.8.8.8, 8.8.4.4</td><td>2001:4860:4860::8888, 2001:4860:4860::8844</td><td>dns.google</td></tr>
<tr><td>Quad9 (blocks malicious domains)</td><td>9.9.9.9, 149.112.112.112</td><td>2620:fe::fe, 2620:fe::9</td><td>dns.quad9.net</td></tr>
</tbody></table>
<p>All three are fast worldwide. Which is fastest for you depends on where their nearest servers are. Open the <a href="/dns-lookup/">DNS lookup</a> and press <strong>Test DNS server speed</strong>: it times eight public resolvers from your connection and sorts them. Pick the fastest and use the second fastest as the backup address.</p>',
			'choose',
		),
		array(
			'Change DNS on Windows 11 and 10',
			'<p><strong>Windows 11:</strong> open Settings &gt; Network &amp; internet, click <strong>Wi-Fi</strong> (then your network\'s properties) or <strong>Ethernet</strong>. Next to <strong>DNS server assignment</strong>, click <strong>Edit</strong>, switch Automatic (DHCP) to <strong>Manual</strong>, turn on IPv4, and enter the preferred and alternate DNS. Set <strong>DNS over HTTPS</strong> to On (automatic template) for an encrypted connection. Repeat for IPv6 if your connection has it, then Save.</p>
<p><strong>Windows 10:</strong> open Control Panel &gt; Network and Internet &gt; Network and Sharing Center &gt; Change adapter settings. Right-click your connection &gt; Properties, select <strong>Internet Protocol Version 4 (TCP/IPv4)</strong> &gt; Properties, choose "Use the following DNS server addresses", enter the two addresses and click OK.</p>
<p>Afterwards, open Command Prompt and run <code>ipconfig /flushdns</code> to clear the old cached answers.</p>',
			'windows',
		),
		array(
			'Change DNS on Mac, iPhone and iPad',
			'<p><strong>Mac:</strong> open System Settings &gt; Network, click <strong>Wi-Fi</strong> (or Ethernet), then <strong>Details</strong> next to your network. Choose <strong>DNS</strong>, click <strong>+</strong> under DNS Servers and add the two addresses, remove the old ones with <strong>-</strong>, and click OK.</p>
<p><strong>iPhone and iPad:</strong> open Settings &gt; Wi-Fi and tap the <strong>(i)</strong> next to your network. Tap <strong>Configure DNS</strong>, choose <strong>Manual</strong>, delete the existing servers, tap Add Server for each new address and tap Save. This applies to that Wi-Fi network only; repeat for other networks. Mobile data keeps the carrier\'s DNS unless you use a DNS app or profile, such as Cloudflare\'s 1.1.1.1 app.</p>',
			'apple',
		),
		array(
			'Change DNS on Android',
			'<p>Android 9 and newer have <strong>Private DNS</strong>, which encrypts DNS and works on both Wi-Fi and mobile data. Open Settings &gt; Network &amp; internet (or Connections &gt; More connection settings on Samsung) &gt; <strong>Private DNS</strong>. Choose <strong>Private DNS provider hostname</strong> and type one of: <code>one.one.one.one</code>, <code>dns.google</code> or <code>dns.quad9.net</code>. Save. Note that Private DNS takes a hostname, not an IP address like 1.1.1.1.</p>
<p>If a network blocks encrypted DNS (some hotel and work Wi-Fi), the phone shows "Couldn\'t connect"; switch Private DNS back to Automatic on that network.</p>',
			'android',
		),
		array(
			'Change DNS on your router or in your browser',
			'<p><strong>Router:</strong> changing it here covers every device at home, including TVs and consoles that have no DNS setting. Open the router\'s admin page (often <code>192.168.0.1</code> or <code>192.168.1.1</code>; the address and login are usually on a label underneath), find the <strong>WAN</strong>, <strong>Internet</strong> or <strong>DHCP</strong> settings, and replace the DNS servers there. Some provider routers lock this setting; in that case set DNS on each device instead.</p>
<p><strong>Browser only:</strong> Chrome: Settings &gt; Privacy and security &gt; Security &gt; <strong>Use secure DNS</strong>, choose a provider. Edge: Settings &gt; Privacy, search, and services &gt; Security &gt; Use secure DNS. Firefox: Settings &gt; Privacy &amp; Security &gt; DNS over HTTPS, choose Increased or Max Protection. This changes DNS for that browser only.</p>',
			'router-browser',
		),
		array(
			'Check that it worked',
			'<p>Reload a few sites; they should open normally. To confirm which resolver you now use, Cloudflare offers a check page at <code>1.1.1.1/help</code>. Then run the speed test in the <a href="/dns-lookup/">DNS lookup</a> tool again to compare. If some sites stop working after the change, a router or network may be forcing its own DNS, or a site may rely on your provider\'s DNS (rare, mostly provider portals); switch back to Automatic to confirm.</p>
<p>If you use a VPN, it normally sets its own DNS while connected, so your manual setting applies only when the VPN is off. Check your <a href="/what-is-my-ip/">IP address</a> and run the <a href="/webrtc-leak-test/">WebRTC leak test</a> to make sure the VPN covers everything.</p>',
			'check',
		),
	),
	'faq'         => array(
		array( 'What is the fastest DNS server?', 'It depends on where you are. Cloudflare, Google and Quad9 are usually the fastest worldwide. The DNS server speed test in our DNS lookup tool measures them from your connection.' ),
		array( 'Is it safe to change my DNS server?', 'Yes, using a well-known provider such as Cloudflare, Google or Quad9. You can switch back to Automatic at any time. Avoid unknown DNS servers, which could send you to fake sites.' ),
		array( 'Will changing DNS make my internet faster?', 'It can make sites start loading slightly sooner and fix lookups that fail, but download speed and ping stay the same.' ),
		array( 'Is 1.1.1.1 better than 8.8.8.8?', 'Both are fast and reliable. Cloudflare says it deletes its resolver logs within 25 hours; Google keeps some logs for longer. Speed depends on your location: test both.' ),
		array( 'Does changing DNS hide my browsing?', 'Encrypted DNS (DNS over HTTPS or Private DNS) hides lookups from your network and provider, but sites still see your IP address. For that you need a VPN.' ),
		array( 'Do I need to restart after changing DNS?', 'Usually not. Flush the DNS cache (ipconfig /flushdns on Windows) or turn Wi-Fi off and on, and reload the browser.' ),
	),
	'sources'     => array(
		array( 'Cloudflare: Set up 1.1.1.1', 'https://developers.cloudflare.com/1.1.1.1/setup/' ),
		array( 'Google Public DNS: Get started', 'https://developers.google.com/speed/public-dns/docs/using' ),
		array( 'Quad9: Service addresses and features', 'https://www.quad9.net/service/service-addresses-and-features' ),
		array( 'Cloudflare: 1.1.1.1 public DNS resolver privacy commitments', 'https://developers.cloudflare.com/1.1.1.1/privacy/public-dns-resolver/' ),
	),
	'ads'         => 'standard',
);
