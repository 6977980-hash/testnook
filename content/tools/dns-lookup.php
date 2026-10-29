<?php
defined( 'ABSPATH' ) || exit;

return array(
	'title'          => 'DNS Lookup',
	'seo_title'      => 'DNS Lookup: Check A, MX, TXT, NS & CNAME Records Online',
	'description'    => 'Free DNS lookup tool. Check A, AAAA, MX, TXT, NS, CNAME, SOA and CAA records, compare Cloudflare and Google answers, and find the fastest public DNS server.',
	'intro'          => 'Look up the DNS records of any domain straight from your browser: the IP addresses it points to, its mail servers, TXT records such as SPF and site verification, name servers and more. Compare two public resolvers to see whether a DNS change has spread, and time eight public DNS servers to find the fastest one from where you are.',
	'trust'          => 'Nothing is sent to Testnook',
	'device'         => 'any',
	'ads'            => 'standard',
	'styles'         => array( 'system' ),
	'scripts'        => array( 'net', 'dns-lookup' ),
	'embed_height'   => 900,
	'tool'           => '<div class="tool-stage sy-stage">
	<div class="dn-form">
		<input type="text" id="dn-name" placeholder="example.com" value="" autocomplete="off" autocapitalize="off" spellcheck="false" inputmode="url" aria-label="Domain name, web address or IP address">
		<select id="dn-type" aria-label="Record type"><option value="ALL">All common</option><option>A</option><option>AAAA</option><option>CNAME</option><option>MX</option><option>TXT</option><option>NS</option><option>SOA</option><option>CAA</option><option>SRV</option><option>HTTPS</option><option>PTR</option></select>
		<button type="button" class="btn btn-primary" id="dn-go">Look up</button>
	</div>
	<div class="btn-row"><div class="seg" role="group" aria-label="DNS resolver"><button type="button" data-dn-res="cloudflare" aria-pressed="true">Cloudflare</button><button type="button" data-dn-res="google" aria-pressed="false">Google</button><button type="button" data-dn-res="both" aria-pressed="false">Compare both</button></div></div>
	<p class="sy-note">Try: <a href="#" data-dn-example="wikipedia.org">wikipedia.org</a> &middot; <a href="#" data-dn-example="gmail.com" data-dn-t="MX">gmail.com MX</a> &middot; <a href="#" data-dn-example="google.com" data-dn-t="TXT">google.com TXT</a> &middot; <a href="#" data-dn-example="8.8.8.8">8.8.8.8 (reverse)</a></p>
	<div id="dn-out"></div>
	<p class="sy-label">Which DNS server is fastest for you?</p>
	<button type="button" class="btn" id="dn-speed">Test DNS server speed</button>
	<div id="dn-speed-wrap" hidden><div class="sy-scroll"><table class="sy-table"><thead><tr><th>Resolver</th><th>Address</th><th>Median</th><th class="dn-barcol">Speed</th></tr></thead><tbody id="dn-speed-body"></tbody></table></div></div>
</div>
<p class="tool-status" id="dn-status" aria-live="polite">Enter a domain and press Look up.</p>',
	'howto'          => array(
		'Type a domain such as <strong>example.com</strong>. You can also paste a full web address; the page takes the host name from it. Type an IP address for a reverse (PTR) lookup.',
		'Pick a record type, or keep <strong>All common</strong> to see A, AAAA, CNAME, MX, NS, TXT, SOA and CAA at once.',
		'Press <strong>Look up</strong>. Choose <strong>Compare both</strong> to ask Cloudflare and Google at the same time and see whether they agree.',
		'Press <strong>Test DNS server speed</strong> to time eight public DNS resolvers from your connection; the shortest bar is the fastest for you.',
	),
	'howto_title'    => 'How to look up DNS records',
	'results'        => '<table><thead><tr><th>Record</th><th>What it holds</th></tr></thead><tbody>
<tr><td><strong>A</strong></td><td>The IPv4 address of the site, such as 93.184.215.14. Several A records spread visitors over several servers.</td></tr>
<tr><td><strong>AAAA</strong></td><td>The IPv6 address. No AAAA record means the site is reachable over IPv4 only.</td></tr>
<tr><td><strong>CNAME</strong></td><td>An alias: "www.example.com is really example.net". The lookup then follows it to the final address.</td></tr>
<tr><td><strong>MX</strong></td><td>The mail servers that receive email for the domain. The lower number is tried first.</td></tr>
<tr><td><strong>TXT</strong></td><td>Free text, mostly used for email security (SPF, DKIM, DMARC) and to prove ownership to Google, Microsoft and other services.</td></tr>
<tr><td><strong>NS</strong></td><td>The name servers in charge of the domain, usually at your registrar, host or Cloudflare.</td></tr>
<tr><td><strong>SOA</strong></td><td>The zone\'s admin record: main name server, contact and a serial number that rises with each change.</td></tr>
<tr><td><strong>CAA</strong></td><td>Which certificate authorities may issue HTTPS certificates for the domain.</td></tr>
<tr><td><strong>PTR</strong></td><td>Reverse DNS: the host name an IP address points back to.</td></tr>
</tbody></table>
<p><strong>TTL</strong> is how long other servers may cache the answer. After you change a record, the old answer can stay in caches for up to the old TTL, which is why changes take time to "propagate". <strong>Status</strong> NXDOMAIN means the domain does not exist; SERVFAIL usually means its name servers are broken or its DNSSEC signature failed. <strong>DNSSEC validated</strong> means the answer was cryptographically signed and checked.</p>',
	'extra'          => array(
		array(
			'Why Cloudflare and Google can give different answers',
			'<p>Each public resolver keeps its own cache. Right after you change a record, one may still hold the old value until its TTL runs out while the other already has the new one; <strong>Compare both</strong> shows this at a glance. Big sites and content networks also answer differently depending on where the question comes from, to send you to a nearby server, so different IPs for google.com or netflix.com are normal and not a fault.</p>',
			'different-answers',
		),
		array(
			'About the DNS server speed test',
			'<p>The speed test sends the same small DNS questions for popular domains to eight public resolvers, one after another, using DNS over HTTPS (the encrypted way browsers can talk to DNS). It reports the median time. That mostly shows how close each provider\'s nearest server is to you, which is the main thing that makes DNS fast. Your router and operating system may use plain DNS on port 53 instead, which can be a few milliseconds quicker, but the order of the resolvers is usually the same. Your provider\'s own DNS is not in the list because browsers cannot reach it this way; it is often fast but may be less reliable.</p>
<p>Once you know the fastest, see our guide on <a href="/how-to-change-dns-server/">how to change your DNS server</a> on Windows, Mac, Android, iPhone and your router.</p>',
			'dns-speed',
		),
	),
	'fixes'          => array(
		array( 'My new A record still shows the old IP', 'Caches keep the old answer until its TTL runs out. Check the TTL in the result, wait that long, and look again with Compare both. Lower the TTL to 300 seconds a day before a planned move next time.' ),
		array( 'Email is not arriving at my domain', 'Look up the MX records: they must point to your mail provider\'s servers exactly as its setup page says. Check the TXT records for one SPF record (starting <code>v=spf1</code>) and a DMARC record at <code>_dmarc.yourdomain.com</code>.' ),
		array( 'The lookup says NXDOMAIN for my domain', 'The domain is not registered, has expired, or its name servers are not set at the registrar. Check the NS records at the registrar and the expiry date.' ),
		array( 'Every lookup fails with an error', 'Some networks and ad blockers block DNS over HTTPS. Try another network, or allow cloudflare-dns.com and dns.google.' ),
	),
	'faq'            => array(
		array( 'What is a DNS lookup?', 'It asks the Domain Name System for the records of a domain, such as the IP address a name points to or the servers that take its email. Your device does this every time you open a website.' ),
		array( 'How do I check if my DNS changes have propagated?', 'Look up the record with Compare both. When Cloudflare and Google both return the new value, most of the internet has it. Some providers\' caches can lag behind until the old TTL runs out.' ),
		array( 'What is the fastest DNS server?', 'It depends on where you are. Cloudflare (1.1.1.1), Google (8.8.8.8) and Quad9 (9.9.9.9) are usually the quickest worldwide. Press Test DNS server speed to measure them from your own connection.' ),
		array( 'Can changing DNS make my internet faster?', 'It can make websites start loading a little sooner, because names resolve faster, but it does not change your download speed or ping in games. It can also fix sites that do not open because of a broken provider DNS.' ),
		array( 'What is reverse DNS?', 'Reverse DNS (a PTR record) turns an IP address back into a host name. Mail servers use it to check senders. Type an IP address into the box to look it up.' ),
		array( 'Does this tool use my own DNS settings?', 'No. Lookups go from your browser straight to Cloudflare or Google over HTTPS, so they show what the public internet sees, not your router\'s or provider\'s cache.' ),
	),
	'related'        => array( 'what-is-my-ip', 'internet-speed-test', 'ping-test', 'webrtc-leak-test', 'what-is-my-browser', 'device-info', 'what-is-my-user-agent', 'webgl-test' ),
	'updated'        => '2026-10-29',
);
