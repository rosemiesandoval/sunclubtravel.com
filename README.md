# SunClub Travel — New Homepage

This page follows Wayne's design blocks 1–3. It's plain PHP, CSS and JS. It needs no WordPress and no database, and it runs on PHP 7.4 and up.

## ⚠️ Upload it to a test folder first

sunclubtravel.com currently runs on **WordPress**. If you upload this `index.php` straight into `public_html`, it will **replace the WordPress homepage file and break the current site**.

1. In SiteGround, go to **Site Tools → File Manager → public_html** and create a folder called `new`.
2. Upload everything in this zip into `public_html/new/`.
3. Preview it at **https://sunclubtravel.com/new/** and share that link with Wayne.
4. Go live once it's approved (ask before doing this, because it changes the live homepage). Two options:
   - Option A: In WordPress, create a page and redirect `/` to `/new/` with a redirect plugin.
   - Option B: Rename WordPress's `index.php` to `index-wp.php`, then move these files up into `public_html`. Keep the other WordPress pages working, or move them first.

## Settings in `config.php`
| Setting | What it does |
|---|---|
| `captain_sunny_url` | Web address of the Captain Sunny chat. Every "Chat with Captain Sunny" button and language link opens it, with `?lang=en/fr/es/zh/ja` added. If it's left empty, visitors see a "launching soon → speak to a specialist" message. |
| `captain_sunny_embed` | `true` opens the chat in a pop-up on the page. The chat site must allow framing. `false` opens it in a new tab. |
| `specialist_calendar_url` | Optional GHL or Calendly booking link. It adds a "Book a call time" option to "Speak to a Travel Specialist". |
| `ghl_webhook_url` | Optional GHL inbound webhook. Every form is also sent into the GHL CRM. |
| `notify_email` / `from_email` | Who receives quote and call-back emails. `from_email` should be an @sunclubtravel.com address. |
| `softvoyage_url` | The direct Softvoyage booking link for "Search & Book Packages Now". |
| `cruise_widget_html` | Paste the cruise provider's search-box embed code here. It replaces the cruise quote form. |
| `reviews` | Real customer reviews. The "Traveller stories" section stays hidden until you add at least one. |

## Logos
Put official logo files (PNG or SVG, transparent background) into `assets/img/logos/` using these names. Each logo appears automatically. Until then, the company name shows as text.

- Booking partners: `westjet-vacations.png`, `sunwing-vacations.png`, `air-canada-vacations.png`, `transat.png`
- Cruise lines: `royal-caribbean.png`, `princess.png`, `holland-america.png`, `celebrity.png`, `norwegian.png`, `carnival.png`, `msc.png`
- Memberships: `iata-tids.png`, `travel-leaders-network.png`, `clia.png`

Download these from each partner's agent portal or media kit. Don't copy them from the ChatGPT mock-ups, because those are AI-redrawn versions of the logos and aren't accurate.

## Images
The images in `assets/img/` were cropped from Wayne's mock-ups to use for now. Replace them with high-resolution versions, keeping the same file names. The most important ones are `sunclub-logo.png` (the new logo with the bigger arch) and `hero-captain-sunny.jpg`.

## Forms
Forms post to `quote-request.php`, which:
- emails the request
- sends it to GHL, if a webhook is set
- saves a backup row in `data/leads.csv`, which is protected from public access by `data/.htaccess`

Spam protection uses a honeypot field and a 20-second rate limit.
