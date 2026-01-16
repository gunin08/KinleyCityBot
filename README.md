# Kinley City Bot

## Overview
- Single-page showcase site for the Kingston City Hall AI calling agent.
- Includes live dashboard link, demo audio, concept video, architecture image, and testimonial videos.
- Companion PHP dashboard for call sessions and KPIs.

## Project Structure
- **index.html** – main marketing/showcase page.
- **dashboard_upgrade.php** – PHP dashboard (Kinley’s Insights) with KPIs, table, and export.
- **Images/** – logos, architecture image, and team photos.
- **Videos/** – testimonial videos (Chinese, French, Spanish, Hindi).
- **recording.wav** – demo AI conversation audio.

## Key Features (index.html)
- Live dashboard CTA to the calling dashboard.
- Demo AI conversation audio playback.
- Concept video embed.
- Key features grid (includes concurrent call handling).
- Testimonials video grid with language labels and fullscreen click.
- Contacts section with photos and LinkedIn links.

## Run / Preview
- Open `index.html` directly in a browser, or serve the folder with a static server.
- For the dashboard, open `dashboard_upgrade.php` through a PHP-capable server.
- Or run the following Vercel page: `https://kinley-city-bot.vercel.app/#`.

## Notes
- Media paths are expected under `Images/` and `Videos/` (see `index.html`).
- To swap media, replace files and keep the filenames the same, or update the sources in `index.html`.
