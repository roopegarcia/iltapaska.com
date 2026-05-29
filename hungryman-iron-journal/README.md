# Hungryman Iron Journal

A WordPress block theme built for long-form training notes with a restrained old-school gym atmosphere.

## Theme Intent

- Dark iron-era visual language with readable off-white text.
- Strong but calm editorial hierarchy for long posts.
- Mobile-first layout and semantic block templates.
- Lightweight effects only where they add context.

## Weekly Article Structure

In the post editor:

1. Open the inserter and search for `Weekly Training Journal`.
2. Insert the pattern.
3. Fill each recurring section:
   - Current Stats
   - This Week in Training
   - Food / Nutrition Notes
   - Mental Notes
   - Work / Modern Life Notes
   - Iron Archive

The pattern is registered in `functions.php` and uses classes styled in `assets/css/theme.css`:

- `.weekly-log-shell`
- `.weekly-log-heading`
- `.weekly-log-list`
- `.weekly-log-block`

## YouTube VHS Wrapper

Two ways to apply the VHS treatment:

1. Select an Embed block and apply the `Iron VHS` block style.
2. Wrap an Embed block in a Group with class `.iron-vhs-embed`.

Both routes use the same styling in `assets/css/theme.css`.

## Customization Knobs

Edit the `:root` variables in `assets/css/theme.css`.

### Colors and typography

- `--iron-bg`
- `--iron-surface`
- `--iron-text`
- `--iron-muted`
- `--iron-accent`

Theme-wide token defaults are in `theme.json` under `settings.color` and `settings.typography`.

### VHS intensity

- `--vhs-line-opacity`
- `--vhs-noise-opacity`
- `--vhs-tracking-opacity`
- `--vhs-frame-shadow`

To disable movement entirely, keep `prefers-reduced-motion` behavior as-is, or remove the `animation` on `ironVhsTracking`.

## Validation Checklist

- Activate `Hungryman Iron Journal` in WordPress.
- Confirm home, index, and single templates render.
- Insert `Weekly Training Journal` pattern in a new post.
- Embed a YouTube video and apply `Iron VHS`.
- Verify keyboard focus ring visibility and readable contrast.
