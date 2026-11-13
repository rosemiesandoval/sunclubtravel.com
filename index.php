<?php
/* SunClub Travel & Rewards — new homepage (Blocks 1–3). PHP 7.4+ */
$cfg = require __DIR__ . '/config.php';

function e($s) { return htmlspecialchars((string)$s, ENT_QUOTES, 'UTF-8'); }

/* Logo slot: shows assets/img/logos/<file> if it exists, otherwise the name as text. */
function logo_slot($file, $name, $class = '') {
    $path = 'assets/img/logos/' . $file;
    $out  = '<span class="logo-slot ' . e($class) . '">';
    if (is_file(__DIR__ . '/' . $path)) {
        $out .= '<img src="' . e($path) . '" alt="' . e($name) . '" loading="lazy">';
    } else {
        $out .= '<span class="logo-text">' . e($name) . '</span>';
    }
    return $out . '</span>';
}

$sent      = isset($_GET['sent']) ? $_GET['sent'] : '';
$sunnyUrl  = trim($cfg['captain_sunny_url']);
$calUrl    = trim($cfg['specialist_calendar_url']);
$svTarget  = $cfg['softvoyage_new_tab'] ? ' target="_blank" rel="noopener"' : '';
$languages = array('en' => 'English', 'fr' => 'French', 'es' => 'Spanish', 'zh' => 'Mandarin', 'ja' => 'Japanese');
$year      = date('Y');
?><!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>SunClub Travel &amp; Rewards | Meet Captain Sunny, Western Canada's first AI Travel Concierge</title>
<meta name="description" content="Plan your next vacation with Captain Sunny, Western Canada's first AI travel concierge, and SunClub's experienced travel specialists. Book all-inclusive packages, cruises, tours and flights and earn SunClub Reward Points.">
<link rel="canonical" href="https://sunclubtravel.com/">
<meta property="og:title" content="Meet Captain Sunny | SunClub Travel & Rewards">
<meta property="og:description" content="Your next great vacation starts with a conversation. Book your vacation. Earn SunClub Reward Points.">
<meta property="og:image" content="https://sunclubtravel.com/assets/img/hero-captain-sunny.jpg">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@700;800;900&family=Nunito+Sans:wght@400;600;700;800&display=swap" rel="stylesheet">
<link rel="stylesheet" href="assets/css/style.css?v=1">
</head>
<body>

<?php if ($sent === '1'): ?>
<div class="flash" role="status">Thank you! Your request was sent. A SunClub travel specialist will contact you shortly. <button class="flash-x" aria-label="Close" onclick="this.parentNode.remove()">&times;</button></div>
<?php elseif ($sent === '0'): ?>
<div class="flash flash-err" role="alert">Sorry, something went wrong. Please call us at <a href="tel:<?= e($cfg['phone_tel']) ?>"><?= e($cfg['phone_display']) ?></a>. <button class="flash-x" aria-label="Close" onclick="this.parentNode.remove()">&times;</button></div>
<?php endif; ?>

<!-- ================= HEADER ================= -->
<header class="site-header">
  <div class="wrap header-inner">
    <a href="./" class="brand" aria-label="SunClub Travel & Rewards home">
      <img src="assets/img/sunclub-logo.png" alt="SunClub Travel & Rewards" width="200" height="88">
    </a>
    <button class="nav-toggle" aria-expanded="false" aria-controls="main-nav" aria-label="Menu"><span></span><span></span><span></span></button>
    <nav id="main-nav" class="main-nav">
      <a href="<?= e($cfg['url_about']) ?>">About Us</a>
      <a href="<?= e($cfg['url_rewards']) ?>" class="nav-pill" target="_blank" rel="noopener">Join SunClub Rewards</a>
      <a href="<?= e($cfg['url_pay_later']) ?>">Book Today-Pay Over Time</a>
      <a href="<?= e($cfg['url_contact']) ?>">Contact Us</a>
    </nav>
  </div>
</header>

<main>

<!-- ================= BLOCK 1: HERO ================= -->
<section class="hero">
  <div class="hero-art" aria-hidden="true">
    <img src="assets/img/hero-captain-sunny.jpg" alt="">
    <div class="bubble">Where would<br>you love to go?</div>
  </div>
  <div class="wrap hero-inner">
    <div class="hero-copy">
      <h1><span class="h-meet">Meet</span> <span class="h-name">Captain Sunny</span></h1>
      <p class="hero-sub">Western Canada's first AI Travel Concierge</p>
      <p class="hero-lead">Your next great vacation starts with a conversation.<br>Plan with Captain Sunny and our experienced travel specialists.</p>
      <div class="btn-row">
        <button class="btn btn-yellow js-chat" data-lang="en"><?php include __DIR__ . '/assets/img/icon-chat.svg'; ?> Chat with Captain Sunny</button>
        <button class="btn btn-outline-light js-specialist">Speak to a Travel Specialist</button>
      </div>
      <ul class="lang-list" aria-label="Chat in your language">
        <?php foreach ($languages as $code => $label): ?>
          <li><button class="js-chat" data-lang="<?= e($code) ?>"><?= e($label) ?></button></li>
        <?php endforeach; ?>
      </ul>
      <a href="<?= e($cfg['url_rewards']) ?>" class="reward-bar" target="_blank" rel="noopener">
        <?php include __DIR__ . '/assets/img/icon-gift.svg'; ?>
        <span>Book your vacation. Earn <strong>SunClub Reward Points.</strong></span>
      </a>
    </div>
  </div>
</section>

<!-- ================= BLOCK 1: ALL-INCLUSIVE BOOKING ================= -->
<section class="wrap section-tight">
  <div class="book-card">
    <div class="book-copy">
      <p class="eyebrow">Your next sun getaway starts here</p>
      <h2>Book Your All-Inclusive Vacation <span class="yellow">Online, Instantly</span></h2>
      <p class="book-lead">Live pricing and direct online booking with Canada's leading package providers.</p>
      <p>Search, compare, and lock in the best rates on sun getaways, flights, and resort packages across Mexico, the Caribbean, and beyond. Book directly through our secure portal backed by full agency support.</p>
      <a href="<?= e($cfg['softvoyage_url']) ?>"<?= $svTarget ?> class="btn btn-yellow btn-lg">
        <?php include __DIR__ . '/assets/img/icon-search.svg'; ?> Search &amp; Book Packages Now <span aria-hidden="true">&rarr;</span>
      </a>
      <p class="fine"><em>Earn SunClub Reward Points on eligible bookings.</em></p>
    </div>
    <div class="book-art"><img src="assets/img/all-inclusive-resort.jpg" alt="All-inclusive resort pool with palm trees" loading="lazy"></div>
  </div>
  <div class="partner-strip">
    <p class="strip-title">Official Direct Booking Partner For:</p>
    <div class="logo-row">
      <?= logo_slot('westjet-vacations.png', 'WestJet Vacations') ?>
      <?= logo_slot('sunwing-vacations.png', 'Sunwing Vacations') ?>
      <?= logo_slot('air-canada-vacations.png', 'Air Canada Vacations') ?>
      <?= logo_slot('transat.png', 'Transat') ?>
    </div>
  </div>
</section>

<!-- ================= BLOCK 2: CRUISES ================= -->
<section class="wrap section" id="cruises">
  <div class="cruise-card">
    <div class="cruise-head">
      <div>
        <p class="eyebrow">Your cruise. Our expertise. More rewards.</p>
        <h2>Exceptional Cruise Fares.<br><span class="yellow">Extra Perks. More Rewards.</span></h2>
        <p class="cruise-sub">Your go-to team for personalized cruise bookings.</p>
      </div>
      <img class="cruise-ship" src="assets/img/cruise-ship.jpg" alt="Cruise ship sailing past a Mediterranean village" loading="lazy">
    </div>
    <div class="cruise-body">
      <div class="cruise-benefits">
        <p class="cruise-intro">Tell us where you want to sail. Our cruise specialists compare available fares and promotions to find the right ship, stateroom and value for you.</p>
        <ul class="checks">
          <li><strong>Competitive Cruise Fares</strong><span>Access to current promotions and select group offers.</span></li>
          <li><strong>Upgrades &amp; Onboard Extras</strong><span>Ask about stateroom upgrades, onboard credits, drink packages and gratuities on select sailings.</span></li>
          <li><strong>SunClub Reward Points</strong><span>Earn points on eligible bookings, alongside applicable cruise line loyalty benefits.</span></li>
          <li><strong>Personalized Expert Support</strong><span>From choosing your voyage to getting ready to sail.</span></li>
        </ul>
        <a href="<?= e($cfg['url_rewards']) ?>" class="reward-bar reward-bar-sm" target="_blank" rel="noopener">
          <?php include __DIR__ . '/assets/img/icon-gift.svg'; ?>
          <span>Book your cruise. Earn <strong>SunClub Reward Points.</strong></span>
        </a>
      </div>

      <div class="cruise-form-card" id="cruise-quote">
      <?php if (trim($cfg['cruise_widget_html']) !== ''): ?>
        <h3>Find Your Perfect Cruise</h3>
        <div class="cruise-widget"><?= $cfg['cruise_widget_html'] /* trusted embed code from config */ ?></div>
      <?php else: ?>
        <h3>Let's Find Your Perfect Cruise</h3>
        <p class="form-sub">Request your personalized quote &amp; available perks.</p>
        <form class="quote-form js-quote-form" action="quote-request.php" method="post" novalidate>
          <input type="hidden" name="form_type" value="cruise">
          <div class="hp" aria-hidden="true"><label>Leave empty <input type="text" name="website" tabindex="-1" autocomplete="off"></label></div>
          <div class="frow">
            <label for="cr-dest">Destination</label>
            <select id="cr-dest" name="destination">
              <option value="">Caribbean, Alaska, Europe &amp; more</option>
              <option>Caribbean</option><option>Alaska</option><option>Mediterranean / Europe</option>
              <option>Northern Europe &amp; Baltic</option><option>Mexican Riviera</option><option>Hawaii</option>
              <option>Asia &amp; Japan</option><option>South Pacific / Australia</option><option>River Cruise</option>
              <option>Not sure yet</option>
            </select>
          </div>
          <div class="frow">
            <label for="cr-line">Preferred Cruise Line</label>
            <select id="cr-line" name="cruise_line">
              <option value="">Any cruise line</option>
              <option>Royal Caribbean International</option><option>Princess Cruises</option><option>Holland America Line</option>
              <option>Celebrity Cruises</option><option>Norwegian Cruise Line</option><option>Carnival Cruise Line</option><option>MSC Cruises</option>
            </select>
          </div>
          <div class="frow">
            <label for="cr-month">Sailing Month / Year</label>
            <input id="cr-month" type="month" name="sailing_month">
          </div>
          <div class="frow">
            <label for="cr-room">Stateroom Preference</label>
            <select id="cr-room" name="stateroom">
              <option value="">Interior, Oceanview, Balcony or Suite</option>
              <option>Interior</option><option>Oceanview</option><option>Balcony</option><option>Suite</option>
            </select>
          </div>
          <div class="frow">
            <label for="cr-name">Your Name</label>
            <input id="cr-name" type="text" name="name" placeholder="Enter your full name" required autocomplete="name">
          </div>
          <div class="frow-2">
            <div><label for="cr-email">Email Address</label><input id="cr-email" type="email" name="email" placeholder="Enter your email address" required autocomplete="email"></div>
            <div><label for="cr-phone">Phone (optional)</label><input id="cr-phone" type="tel" name="phone" placeholder="Enter your phone number" autocomplete="tel"></div>
          </div>
          <button type="submit" class="btn btn-yellow btn-block">Request My Cruise Quote &amp; Perks <span aria-hidden="true">&rarr;</span></button>
          <p class="form-note">No obligation. Personalized service.</p>
          <p class="form-msg" role="status" aria-live="polite"></p>
        </form>
      <?php endif; ?>
      </div>
    </div>
  </div>

  <div class="partner-strip partner-strip-plain">
    <h3 class="strip-heading">Explore the World with Leading Cruise Lines</h3>
    <div class="logo-row logo-row-wrap">
      <?= logo_slot('royal-caribbean.png', 'Royal Caribbean International') ?>
      <?= logo_slot('princess.png', 'Princess Cruises') ?>
      <?= logo_slot('holland-america.png', 'Holland America Line') ?>
      <?= logo_slot('celebrity.png', 'Celebrity Cruises') ?>
      <?= logo_slot('norwegian.png', 'Norwegian Cruise Line') ?>
      <?= logo_slot('carnival.png', 'Carnival Cruise Line') ?>
      <?= logo_slot('msc.png', 'MSC Cruises') ?>
    </div>
  </div>
</section>

<!-- ================= BLOCK 2: EXPLORE ================= -->
<section class="wrap section">
  <div class="section-head">
    <h2>How would you like to explore?</h2>
    <p>Cruises, worldwide tours and flights&mdash;planned around you.</p>
  </div>
  <div class="cards-3">
    <article class="ex-card">
      <img src="assets/img/card-cruises.jpg" alt="Cruise ship in an Alaskan glacier bay" loading="lazy">
      <div class="ex-body"><h3>Cruises</h3><p>Ocean and river journeys, from Alaska to the Mediterranean.</p>
      <a href="#cruise-quote" class="btn btn-yellow btn-block">Explore Cruises</a></div>
    </article>
    <article class="ex-card">
      <img src="assets/img/card-tours.jpg" alt="Colourful coastal village in Europe" loading="lazy">
      <div class="ex-body"><h3>Worldwide Tours</h3><p>Guided adventures, cultural discoveries and custom itineraries.</p>
      <button class="btn btn-yellow btn-block js-quote" data-trip="Worldwide Tour">Explore Tours</button></div>
    </article>
    <article class="ex-card">
      <img src="assets/img/card-air.jpg" alt="Airplane flying above the clouds at sunset" loading="lazy">
      <div class="ex-body"><h3>Air Ticketing</h3><p>Domestic and international flights, with help from our team.</p>
      <button class="btn btn-yellow btn-block js-quote" data-trip="Flights">Request Flight Options</button></div>
    </article>
  </div>
</section>

<!-- ================= BLOCK 3: HOW IT WORKS ================= -->
<section class="how">
  <div class="wrap">
    <h2 class="center">AI inspiration. Personal travel expertise.</h2>
    <ol class="steps">
      <li><?php include __DIR__ . '/assets/img/icon-chat.svg'; ?><div><h3>1. Share your travel dreams</h3><p>Chat with Captain Sunny in your preferred language.</p></div></li>
      <li><?php include __DIR__ . '/assets/img/icon-calendar.svg'; ?><div><h3>2. Plan with our specialists</h3><p>Our team helps refine your itinerary and booking options.</p></div></li>
      <li><?php include __DIR__ . '/assets/img/icon-gift.svg'; ?><div><h3>3. Book and earn rewards</h3><p>Earn SunClub Reward Points when you book.</p></div></li>
    </ol>
    <div class="center"><button class="btn btn-yellow js-chat" data-lang="en"><?php include __DIR__ . '/assets/img/icon-chat.svg'; ?> Chat with Captain Sunny</button></div>
  </div>
</section>

<section class="wrap section-tight">
  <div class="rewards-banner">
    <div class="rewards-copy">
      <?php include __DIR__ . '/assets/img/icon-gift.svg'; ?>
      <div>
        <h2>Your next trip comes with rewards.</h2>
        <p>Join SunClub Rewards and earn points on eligible bookings.</p>
        <a href="<?= e($cfg['url_rewards']) ?>" class="btn btn-yellow" target="_blank" rel="noopener">Join SunClub Rewards</a>
      </div>
    </div>
    <img src="assets/img/rewards-lake.jpg" alt="Mountain lake with canoes at a dock" loading="lazy">
  </div>
</section>

<?php if (!empty($cfg['reviews'])): ?>
<section class="wrap section">
  <div class="section-head"><h2>Traveller stories</h2><p>Real experiences from SunClub travellers.</p></div>
  <div class="cards-3">
    <?php foreach ($cfg['reviews'] as $r): ?>
      <figure class="review">
        <blockquote><?= e($r['quote']) ?></blockquote>
        <figcaption><span class="r-name"><?= e($r['name']) ?></span><?php if (!empty($r['trip'])): ?> &bull; <?= e($r['trip']) ?><?php endif; ?></figcaption>
      </figure>
    <?php endforeach; ?>
  </div>
</section>
<?php endif; ?>

<section class="cta-band">
  <div class="wrap center">
    <h2>Ready to plan your next getaway?</h2>
    <p>Start with Captain Sunny or speak with a travel specialist.</p>
    <div class="btn-row btn-row-center">
      <button class="btn btn-yellow js-chat" data-lang="en"><?php include __DIR__ . '/assets/img/icon-chat.svg'; ?> Chat with Captain Sunny</button>
      <button class="btn btn-outline-dark js-quote" data-trip="">Request a Travel Quote</button>
    </div>
  </div>
</section>

<section class="wrap section">
  <div class="members">
    <h2 class="members-title">We are proud members of</h2>
    <div class="logo-row">
      <?= logo_slot('iata-tids.png', 'IATA TIDS', 'logo-lg') ?>
      <?= logo_slot('travel-leaders-network.png', 'Travel Leaders Network', 'logo-lg') ?>
      <?= logo_slot('clia.png', 'CLIA — Cruise Lines International Association', 'logo-lg') ?>
    </div>
  </div>
</section>

</main>

<!-- ================= FOOTER ================= -->
<footer class="site-footer">
  <div class="wrap footer-grid">
    <div class="f-brand">
      <span class="f-logo"><img src="assets/img/sunclub-logo.png" alt="SunClub Travel & Rewards" width="180" height="79"></span>
      <p>Travel inspiration.<br>Personal service.<br>Rewarding journeys.</p>
    </div>
    <div><h4>Explore</h4><a href="#cruise-quote">Cruises</a><button class="link js-quote" data-trip="Worldwide Tour">Worldwide Tours</button><button class="link js-quote" data-trip="Flights">Air Ticketing</button></div>
    <div><h4>SunClub</h4><a href="<?= e($cfg['url_about']) ?>">About Us</a><a href="<?= e($cfg['url_rewards']) ?>" target="_blank" rel="noopener">SunClub Rewards</a><a href="<?= e($cfg['url_contact']) ?>">Contact Us</a></div>
    <div><h4>Information</h4><a href="<?= e($cfg['url_privacy']) ?>">Privacy Policy</a><a href="<?= e($cfg['url_terms']) ?>">Terms &amp; Conditions</a><a href="tel:<?= e($cfg['phone_tel']) ?>"><?= e($cfg['phone_display']) ?></a></div>
  </div>
  <div class="wrap f-bottom">
    <a href="https://sunclubtravel.com" class="f-domain">SunClubTravel.com</a>
    <p class="f-small"><?= e($cfg['address']) ?> &nbsp;|&nbsp; &copy; <?= $year ?> SunClub Travel &amp; Rewards
      &nbsp;|&nbsp; <a href="<?= e($cfg['url_facebook']) ?>" target="_blank" rel="noopener">Facebook</a>
      &nbsp;|&nbsp; <a href="<?= e($cfg['url_instagram']) ?>" target="_blank" rel="noopener">Instagram</a></p>
  </div>
</footer>

<!-- ================= MODALS ================= -->
<div class="modal" id="chat-modal" role="dialog" aria-modal="true" aria-labelledby="chat-title" hidden>
  <div class="modal-box modal-chat">
    <button class="modal-x" data-close aria-label="Close">&times;</button>
    <h3 id="chat-title">Chat with Captain Sunny</h3>
    <?php if ($sunnyUrl !== ''): ?>
      <iframe class="chat-frame" title="Captain Sunny chat" data-src="<?= e($sunnyUrl) ?>" allow="microphone; clipboard-write"></iframe>
    <?php else: ?>
      <div class="chat-fallback">
        <img src="assets/img/hero-captain-sunny.jpg" alt="" width="120">
        <p><strong>Captain Sunny is getting ready for take-off!</strong><br>Our AI concierge chat is launching soon. In the meantime, a SunClub travel specialist would love to help.</p>
        <button class="btn btn-yellow js-specialist">Speak to a Travel Specialist</button>
      </div>
    <?php endif; ?>
  </div>
</div>

<div class="modal" id="specialist-modal" role="dialog" aria-modal="true" aria-labelledby="spec-title" hidden>
  <div class="modal-box">
    <button class="modal-x" data-close aria-label="Close">&times;</button>
    <h3 id="spec-title">Speak to a Travel Specialist</h3>
    <p class="form-sub">Choose what works best for you.</p>
    <div class="spec-options">
      <?php if ($calUrl !== ''): ?>
        <a class="spec-opt" href="<?= e($calUrl) ?>" target="_blank" rel="noopener"><?php include __DIR__ . '/assets/img/icon-calendar.svg'; ?><span><strong>Book a call time</strong>Pick a time that suits you</span></a>
      <?php endif; ?>
      <a class="spec-opt" href="tel:<?= e($cfg['phone_tel']) ?>"><?php include __DIR__ . '/assets/img/icon-phone.svg'; ?><span><strong>Call now</strong><?= e($cfg['phone_display']) ?> (toll-free)</span></a>
    </div>
    <h4 class="or-line"><span>or request a call back</span></h4>
    <form class="quote-form js-quote-form" action="quote-request.php" method="post" novalidate>
      <input type="hidden" name="form_type" value="callback">
      <div class="hp" aria-hidden="true"><label>Leave empty <input type="text" name="website" tabindex="-1" autocomplete="off"></label></div>
      <div class="frow-2">
        <div><label for="cb-name">Your Name</label><input id="cb-name" type="text" name="name" required autocomplete="name"></div>
        <div><label for="cb-phone">Phone</label><input id="cb-phone" type="tel" name="phone" required autocomplete="tel"></div>
      </div>
      <div class="frow-2">
        <div><label for="cb-email">Email</label><input id="cb-email" type="email" name="email" required autocomplete="email"></div>
        <div><label for="cb-time">Best time to call</label>
          <select id="cb-time" name="best_time"><option>Anytime</option><option>Morning</option><option>Afternoon</option><option>Evening</option></select></div>
      </div>
      <div class="frow"><label for="cb-msg">What trip are you thinking about? (optional)</label><textarea id="cb-msg" name="message" rows="2"></textarea></div>
      <button type="submit" class="btn btn-yellow btn-block">Request a Call Back</button>
      <p class="form-msg" role="status" aria-live="polite"></p>
    </form>
  </div>
</div>

<div class="modal" id="quote-modal" role="dialog" aria-modal="true" aria-labelledby="quote-title" hidden>
  <div class="modal-box">
    <button class="modal-x" data-close aria-label="Close">&times;</button>
    <h3 id="quote-title">Request a Travel Quote</h3>
    <p class="form-sub">Tell us about your trip and a specialist will get back to you.</p>
    <form class="quote-form js-quote-form" action="quote-request.php" method="post" novalidate>
      <input type="hidden" name="form_type" value="quote">
      <div class="hp" aria-hidden="true"><label>Leave empty <input type="text" name="website" tabindex="-1" autocomplete="off"></label></div>
      <div class="frow-2">
        <div><label for="q-trip">Trip type</label>
          <select id="q-trip" name="trip_type"><option value="">Choose one</option><option>All-Inclusive Package</option><option>Cruise</option><option>Worldwide Tour</option><option>Flights</option><option>Other</option></select></div>
        <div><label for="q-dest">Destination</label><input id="q-dest" type="text" name="destination" placeholder="Where would you love to go?"></div>
      </div>
      <div class="frow-2">
        <div><label for="q-dates">Travel dates</label><input id="q-dates" type="text" name="dates" placeholder="e.g. March 2027, 7 nights"></div>
        <div><label for="q-trav">Travellers</label><input id="q-trav" type="text" name="travellers" placeholder="e.g. 2 adults, 1 child"></div>
      </div>
      <div class="frow"><label for="q-name">Your Name</label><input id="q-name" type="text" name="name" required autocomplete="name"></div>
      <div class="frow-2">
        <div><label for="q-email">Email</label><input id="q-email" type="email" name="email" required autocomplete="email"></div>
        <div><label for="q-phone">Phone (optional)</label><input id="q-phone" type="tel" name="phone" autocomplete="tel"></div>
      </div>
      <div class="frow"><label for="q-msg">Anything else? (optional)</label><textarea id="q-msg" name="message" rows="2"></textarea></div>
      <button type="submit" class="btn btn-yellow btn-block">Send My Request <span aria-hidden="true">&rarr;</span></button>
      <p class="form-note">No obligation. Personalized service.</p>
      <p class="form-msg" role="status" aria-live="polite"></p>
    </form>
  </div>
</div>

<script>window.SUNCLUB = { sunnyUrl: <?= json_encode($sunnyUrl) ?>, sunnyEmbed: <?= $cfg['captain_sunny_embed'] ? 'true' : 'false' ?> };</script>
<script src="assets/js/main.js?v=1"></script>
</body>
</html>
