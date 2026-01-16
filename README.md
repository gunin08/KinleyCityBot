# Kinley City Bot

## Overview
Kingston City Hall receives many calls for information that already exists on its website, but residents often prefer speaking to someone because it is faster and easier than searching online. Support is also limited to business hours, so people who need help in the evening or on weekends cannot get answers right away. On top of that, calls are handled by different staff members with varying experience, which can lead to inconsistent information. Finally, call insights that could inform service improvements and city planning are often lost, incomplete, or hard to analyze when recorded manually.

My solution is a 24/7 AI calling agent for Kingston City Hall. It would provide instant, consistent answers sourced from approved city information, and support multilingual conversations (English, French, Hindi, Spanish, and more) to improve accessibility and inclusion. The system would also create a secure data funnel that stores call audio, transcripts, call reasons, and summaries, generating actionable insights about residents’ biggest needs and pain points to support better services, surveys, and planning.

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
