/* SunClub Travel — homepage interactions (no dependencies) */
(function () {
  'use strict';
  var cfg = window.SUNCLUB || {};
  var lastFocus = null;

  /* ---- Mobile nav ---- */
  var toggle = document.querySelector('.nav-toggle');
  var nav = document.getElementById('main-nav');
  if (toggle && nav) {
    toggle.addEventListener('click', function () {
      var open = nav.classList.toggle('open');
      toggle.setAttribute('aria-expanded', open ? 'true' : 'false');
    });
  }

  /* ---- Modals ---- */
  function openModal(id) {
    document.querySelectorAll('.modal').forEach(function (m) { m.hidden = true; });
    var m = document.getElementById(id);
    if (!m) return;
    lastFocus = document.activeElement;
    m.hidden = false;
    document.body.style.overflow = 'hidden';
    var f = m.querySelector('input:not([type=hidden]):not([tabindex="-1"]), select, iframe, .btn, .modal-x');
    if (f) setTimeout(function () { f.focus(); }, 30);
  }
  function closeModal(m) {
    m.hidden = true;
    document.body.style.overflow = '';
    if (lastFocus) lastFocus.focus();
  }
  document.querySelectorAll('.modal').forEach(function (m) {
    m.addEventListener('click', function (e) {
      if (e.target === m || e.target.hasAttribute('data-close')) closeModal(m);
    });
  });
  document.addEventListener('keydown', function (e) {
    if (e.key !== 'Escape') return;
    var open = document.querySelector('.modal:not([hidden])');
    if (open) closeModal(open);
  });

  /* ---- Captain Sunny chat ---- */
  function chatUrl(lang) {
    if (!cfg.sunnyUrl) return '';
    return cfg.sunnyUrl + (cfg.sunnyUrl.indexOf('?') === -1 ? '?' : '&') + 'lang=' + encodeURIComponent(lang || 'en') + '&src=website';
  }
  document.querySelectorAll('.js-chat').forEach(function (b) {
    b.addEventListener('click', function () {
      var url = chatUrl(b.getAttribute('data-lang'));
      if (url && !cfg.sunnyEmbed) { window.open(url, '_blank', 'noopener'); return; }
      var frame = document.querySelector('#chat-modal .chat-frame');
      if (frame && url && frame.getAttribute('src') !== url) frame.setAttribute('src', url);
      openModal('chat-modal');
    });
  });

  /* ---- Travel specialist ---- */
  document.querySelectorAll('.js-specialist').forEach(function (b) {
    b.addEventListener('click', function () { openModal('specialist-modal'); });
  });

  /* ---- General quote (pre-selects trip type) ---- */
  document.querySelectorAll('.js-quote').forEach(function (b) {
    b.addEventListener('click', function () {
      var trip = b.getAttribute('data-trip');
      var sel = document.getElementById('q-trip');
      if (sel && trip) sel.value = trip;
      openModal('quote-modal');
    });
  });

  /* ---- Form submit via fetch (falls back to normal POST without JS) ---- */
  document.querySelectorAll('.js-quote-form').forEach(function (form) {
    form.addEventListener('submit', function (e) {
      e.preventDefault();
      var msg = form.querySelector('.form-msg');
      var ok = true;
      form.querySelectorAll('[required]').forEach(function (el) {
        var bad = !el.value.trim() || (el.type === 'email' && !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(el.value));
        el.classList.toggle('invalid', bad);
        if (bad) ok = false;
      });
      if (!ok) { msg.className = 'form-msg err'; msg.textContent = 'Please fill in the highlighted fields.'; return; }

      var btn = form.querySelector('button[type=submit]');
      var label = btn.innerHTML;
      btn.disabled = true; btn.textContent = 'Sending…';
      msg.className = 'form-msg'; msg.textContent = '';

      fetch(form.action, { method: 'POST', body: new FormData(form), headers: { 'X-Requested-With': 'fetch' } })
        .then(function (r) { return r.json(); })
        .then(function (d) {
          if (d.ok) {
            form.reset();
            msg.className = 'form-msg ok';
            msg.textContent = 'Thank you! A SunClub travel specialist will contact you shortly.';
            if (window.gtag) window.gtag('event', 'generate_lead', { form_type: form.form_type ? form.form_type.value : '' });
            if (window.fbq) window.fbq('track', 'Lead');
          } else {
            msg.className = 'form-msg err';
            msg.textContent = d.error || 'Sorry, something went wrong. Please call 1-877-691-3551.';
          }
        })
        .catch(function () {
          msg.className = 'form-msg err';
          msg.textContent = 'Sorry, something went wrong. Please call 1-877-691-3551.';
        })
        .then(function () { btn.disabled = false; btn.innerHTML = label; });
    });
  });
})();
