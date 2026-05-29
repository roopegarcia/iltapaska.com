You are working on a WordPress project for a personal long-form blog.

Project concept:
Build an old-school iron-era personal blog for a 46-year-old father, web developer and lifter. The guiding editorial line is:

“Just write like an intelligent man leaving notes in the margins of modern life.”

The blog is not a modern influencer fitness brand. It should feel like a dark, serious, old-school gym journal inspired by 1990s bodybuilding/powerlifting culture, especially the atmosphere of Dorian Yates / Blood & Guts: heavy, quiet, disciplined, grainy, industrial, masculine, reflective.

Core content pillars:
1. A 46-year-old dad saying goodbye to 22% body fat and the dad-bod for life.
2. The road to a 100 kg bench press.
3. The road to the 1000 lb club.

Weekly article format:
Each weekly post should support recurring sections:
- Current Stats
- This Week in Training
- Food / Nutrition Notes
- Mental Notes
- Work / Modern Life Notes
- Iron Archive: embedded old-school training video with commentary

Special articles:
Support standalone posts for milestone moments, such as a major PR, box jumps, body composition updates, burnout reflections, or old-school training philosophy.

Design direction:
- Dark, warm black / charcoal background
- Off-white text, slightly aged paper feel
- Serious typography, readable long-form layout
- Industrial gym atmosphere, not neon synthwave
- Subtle grain/noise texture
- Strong headings
- Minimal animations
- No bloated plugins
- Fast, accessible, semantic HTML
- Mobile-first
- SEO-friendly structure
- Restraint is important: do not overdo the retro effects

Important visual feature:
Create a reusable YouTube embed component/block/style where videos are presented with a VHS-style overlay:
- subtle scanlines
- slight grain/noise
- optional tracking-line effect
- dark frame/border
- custom play area styling if possible without breaking accessibility
- the effect must be tasteful and lightweight
- do not make the whole site gimmicky

Technical expectations:
- Use modern WordPress theme/block-theme conventions if this is a theme project.
- If this repo already has an established structure, follow it.
- Keep PHP, SCSS/CSS and JS clean and maintainable.
- Avoid unnecessary dependencies.
- Make the output easy for a WordPress developer to continue editing.
- Prefer progressive enhancement.
- Preserve accessibility: focus states, readable contrast, keyboard navigation, semantic landmarks.
- Preserve performance: no huge assets, no heavy animation libraries.

Please inspect the repository first and then implement the smallest useful first version.

First-pass deliverables:
1. Create or update the theme/global styles for the dark old-school gym aesthetic.
2. Add layout styles for long-form article pages.
3. Add reusable styling/classes for the recurring weekly article sections.
4. Add a VHS YouTube embed wrapper/component/pattern.
5. Add example markup/pattern/template content showing the weekly article structure.
6. Add comments where a developer can easily customize colors, typography and VHS intensity.
7. Update documentation if the repo has a README or theme docs.

Do not:
- Add plugin bloat.
- Add external tracking.
- Add fake AI-generated content at scale.
- Make it look like a SaaS landing page.
- Use neon cyberpunk styling.
- Sacrifice readability for effects.

After implementation:
- Summarize changed files.
- Explain how to use the weekly article structure.
- Explain how to embed a YouTube video with the VHS wrapper.
- Mention any commands/tests/build steps that should be run.