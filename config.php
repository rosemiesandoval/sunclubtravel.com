<?php
/**
 * SunClub Travel — new homepage settings
 * ---------------------------------------------------------------
 * Everything you may need to change lives in THIS file.
 * Leave a value as '' (empty) and the page will fall back gracefully.
 * PHP 7.4+ compatible.
 */

return array(

    // ---------- Contact ----------
    'phone_display'   => '1-877-691-3551',
    'phone_tel'       => '+18776913551',
    'address'         => 'Tower 1, Suite 1800, 330 5th Avenue SW, Calgary, AB T2P 0L4',

    // Where quote / callback requests are emailed (comma-separate for several).
    'notify_email'    => 'info@sunclubtravel.com',          // TODO: confirm with Wayne
    // "From" address — use an address on this domain so SiteGround doesn't flag it as spam.
    'from_email'      => 'no-reply@sunclubtravel.com',

    // Optional: GoHighLevel inbound webhook. Every form submission is also POSTed here
    // so leads land in the GHL CRM automatically (Automation > Workflows > Inbound Webhook trigger).
    'ghl_webhook_url' => '',

    // ---------- Captain Sunny ----------
    // URL of the Captain Sunny web chat. Opens inside a pop-up window on the page.
    // The chosen language is appended as ?lang=en|fr|es|zh|ja
    'captain_sunny_url' => '',                               // e.g. https://sunclubmall.com/sunny6/chat.php
    // true  = open the chat inside a pop-up on this page (iframe; the chat site must allow framing)
    // false = open the chat in a new browser tab
    'captain_sunny_embed' => true,

    // ---------- Speak to a Travel Specialist ----------
    // Optional online booking calendar (GHL Calendar / Calendly link). If set, visitors can
    // pick a call time themselves. If empty, they get "Call now" + "Request a call back".
    'specialist_calendar_url' => '',

    // ---------- Booking links ----------
    // Softvoyage direct-booking portal (all-inclusive packages). Copy the URL that the
    // current /package-form/ page loads in its iframe.
    'softvoyage_url'  => 'https://sunclubtravel.com/package-form/',   // TODO: replace with direct Softvoyage link
    'softvoyage_new_tab' => true,

    // Paste the cruise search box embed code from your cruise provider here (the full
    // <script>/<iframe> snippet). If filled, it replaces the cruise quote form in Block 2.
    'cruise_widget_html' => '',

    // ---------- Navigation ----------
    'url_about'     => 'https://sunclubtravel.com/about-sunclub-travel-and-rewards/',
    'url_rewards'   => 'https://www.sunclubrewards.com/en/',
    'url_pay_later' => 'https://sunclubtravel.com/contact-sunclub-travel/',  // TODO: Book Today-Pay Over Time page
    'url_contact'   => 'https://sunclubtravel.com/contact-sunclub-travel/',
    'url_privacy'   => 'https://sunclubtravel.com/privacy-policy/',
    'url_terms'     => 'https://sunclubtravel.com/terms-and-condition/',
    'url_facebook'  => 'https://www.facebook.com/people/SunClub-Travel-and-Rewards/61570224568843/',
    'url_instagram' => 'https://www.instagram.com/sunclubtravelrewards/',

    // ---------- Traveller stories ----------
    // Section stays hidden until at least one real review is added. Example:
    // array('quote' => 'Our trip to Cancun was perfect...', 'name' => 'Maria L.', 'trip' => 'Riviera Maya, 2026'),
    'reviews' => array(),
);
