# Design System — Automation SeQure

## Product Context
- **What this is:** B2B AI services company offering AI automation for entrepreneurs/SMBs and AI governance & compliance for Dutch municipalities
- **Who it's for:** Two audiences: (1) entrepreneurs, CEOs, SMBs wanting AI-powered productivity, (2) municipal decision-makers needing AI Act compliance
- **Space/industry:** Dutch AI services, competitors include Bespoke Automation, ai.nl, Brthrs
- **Project type:** Marketing site with booking system (PHP 8+, TransIP shared hosting)

## Aesthetic Direction
- **Direction:** Industrial Precision — trustworthy and exact, not flashy. The site feels like a well-built instrument, not a template.
- **Decoration level:** Intentional — subtle texture and gradients only where functional (section separation, focus). No blobs, no decorative illustrations.
- **Mood:** Confidence and clarity. The user should feel "this company knows what they're doing" within 3 seconds. Not cold, not warm, just precise.
- **Reference sites:** Brthrs (green accent, numbered steps, distinctive), Bespoke Automation (close competitor, mixed theme), ai.nl (editorial, social proof)

## Typography
- **Display/Hero:** Satoshi (Variable, 900/700) — Geometric but warm. Personality without being loud. Free via Fontshare.
- **Body:** DM Sans (400/500/700) — Excellent readability on dark backgrounds, tabular-nums support for data. Google Fonts.
- **UI/Labels:** DM Sans 500 (same as body, medium weight for emphasis)
- **Data/Tables:** Geist Mono (400/500) — For technical elements, timestamps, code snippets, stats.
- **Code:** Geist Mono
- **Loading:** Fontshare CDN for Satoshi (`https://api.fontshare.com/v2/css?f[]=satoshi@400;500;700;900&display=swap`), Google Fonts for DM Sans and Geist Mono
- **Scale:**
  - H1: `clamp(2.25rem, 4.5vw, 3.5rem)` / leading 1.1
  - H2: `clamp(1.6rem, 3.2vw, 2.375rem)` / leading 1.2
  - H3: `clamp(1.15rem, 1.8vw, 1.35rem)` / leading 1.25
  - Body: `1rem` / leading 1.7
  - Small: `0.875rem` / leading 1.6
  - XS/Mono: `0.75rem` / leading 1.4

## Color
- **Approach:** Restrained — green accent is rare and meaningful, cyan as secondary for technical elements
- **Background:** `#0B0C0F` — near-black, slightly warmer than pure black
- **Background alt:** `#0D0E12` — subtle section differentiation
- **Surface:** `#13151A` — cards, elevated panels
- **Surface elevated:** `#1A1C22` — modals, dropdowns, popovers
- **Heading:** `#E2E4EA` — warm off-white for maximum readability
- **Text:** `#B0B3C0` — body text, comfortable on dark
- **Text muted:** `#8A8DA0` — captions, metadata (WCAG AA compliant ~5:1 on #0B0C0F)
- **Border:** `rgba(255, 255, 255, 0.06)` — subtle separation
- **Border hover:** `rgba(255, 255, 255, 0.12)` — interactive state
- **Accent (green):** `#2ECB6F` — primary action color. Signals safety, compliance, go. Unique in category (no competitor uses green).
- **Accent hover:** `#3DD97F`
- **Accent glow:** `rgba(46, 203, 111, 0.12)` — focus rings, subtle backgrounds
- **Accent muted:** `rgba(46, 203, 111, 0.08)` — card icons, tag backgrounds
- **Secondary (cyan):** `#00B4D8` — technical elements, governance category
- **Secondary glow:** `rgba(0, 180, 216, 0.10)`
- **Semantic:** success `#2ECB6F`, warning `#FFB74D`, error `#FF5F57`, info `#00B4D8`
- **Dark mode:** This IS the dark mode. No light mode planned.

## Spacing
- **Base unit:** 8px
- **Density:** Comfortable
- **Scale:** 2xs(2px) xs(4px) sm(8px) md(16px) lg(24px) xl(32px) 2xl(48px) 3xl(64px)
- **Section padding:** `clamp(72px, 10vw, 120px)` vertical
- **Container max:** 1200px
- **Container padding:** `clamp(20px, 4vw, 24px)`
- **Card padding:** `clamp(24px, 3vw, 36px)`
- **Gap (grid):** 24px

## Layout
- **Approach:** Hybrid — hero and cases break from centered grid (asymmetric), services and FAQ use structured grid
- **Grid:** 12 columns on desktop, 1 column on mobile, 2 columns on tablet where appropriate
- **Max content width:** 1200px
- **Border radius:** Hierarchical scale:
  - sm: 4px (buttons, inputs, tags)
  - md: 8px (card icons, small cards, alerts)
  - lg: 12px (main cards, modals, dropdowns)
  - full: 9999px (pills, avatar circles)
- **Hero layout:** Text left-aligned (60%), event feed right (40%). Not centered.
- **Route cards:** Two-column grid with color-coded top bars (green = automation, cyan = governance)
- **Case cards:** Full-width with three-column phase grid (Situatie / Aanpak / Resultaat)

## Motion
- **Approach:** Minimal-functional — only transitions that aid comprehension
- **Easing:** enter: ease-out, exit: ease-in, move: cubic-bezier(0.4, 0, 0.2, 1)
- **Duration:** micro: 50-100ms (hover states), short: 150ms (button press, toggle), medium: 300ms (dropdown, panel), long: 400-700ms (page transitions, reserved)
- **Specifics:**
  - `--ease: 0.3s cubic-bezier(0.4, 0, 0.2, 1)` — default transition
  - `--ease-fast: 0.15s ease` — hover states, micro-interactions
  - No scroll-driven animations, no choreography
  - Entrance animations on scroll: fade-up only, 300ms, triggered once

## Component Patterns
- **Buttons:** `.btn.btn--primary` (green bg, dark text), `.btn.btn--outline` (border, light text), `.btn.btn--ghost` (text only, accent color). Sizes: `--sm`, default, `--lg`
- **Cards:** `--surface` background, `--border` edges, `--card-pad` padding, `--radius-lg` corners. Hover: border-color transition.
- **Section headers:** `.section-label` (mono, xs, uppercase, accent color) + `.section-title` (Satoshi h2) + optional `.section-subtitle`
- **Trust bar:** Horizontal flex with icon + stat items, border top/bottom
- **Alerts:** Color-coded left accent (success/error/warning/info) with icon + text
- **Forms:** `.form-input` with focus ring (`--accent-glow`), error state (red border + message), success state (green border)
- **Event feed:** Card with pulsing dot header, timestamped list items with colored tags
- **Case cards:** Full-width with header section + three-column phase grid

## Anti-Slop Rules
These patterns are banned from this design system:
- Purple/violet gradients as accent (was: `#6C5CE7`)
- Inter, Roboto, Poppins, Montserrat as primary fonts
- 3-column icon-in-circle feature grids
- Centered-everything layout (hero MUST be left-aligned)
- Uniform border-radius on all elements (use hierarchical scale)
- Gradient buttons as primary CTA (solid green, no gradient)
- Decorative blobs, abstract shapes, or stock illustrations
- Cookie-cutter section rhythm (vary padding, alignment, and density)

## Font Comparison (old vs new)
| Role | Old | New | Why |
|------|-----|-----|-----|
| Display | Inter 800 | Satoshi 900 | Geometric warmth, not generic |
| Body | Inter 400 | DM Sans 400 | Better dark-bg readability |
| Data | Inter 400 | Geist Mono 400 | Signals precision, tabular nums |

## Color Comparison (old vs new)
| Token | Old | New | Why |
|-------|-----|-----|-----|
| --accent | #6C5CE7 (purple) | #2ECB6F (green) | Safety/compliance signal, category-unique |
| --bg | #0A0A0F | #0B0C0F | Slightly warmer |
| --surface | #131320 | #13151A | Less blue, more neutral |
| --heading | #EAEDF6 | #E2E4EA | Warmer off-white |
| --text-light | #6B6F80 | #8A8DA0 | WCAG AA compliant |

## Decisions Log
| Date | Decision | Rationale |
|------|----------|-----------|
| 2026-04-14 | Green (#2ECB6F) as primary accent | Every competitor uses purple/blue. Green = safety, compliance, go. Matches brand promise. |
| 2026-04-14 | Satoshi + DM Sans + Geist Mono | Inter is overused in AI/SaaS. Three-font stack with clear role separation. |
| 2026-04-14 | Asymmetric hero layout | Break centered-everything template feel. Event feed shows product in action. |
| 2026-04-14 | Hierarchical border radius (4/8/12px) | Replaces uniform 16px. Smaller radius = more precise, professional feel. |
| 2026-04-14 | Industrial Precision aesthetic | Trustworthy for municipalities, modern for entrepreneurs. Not flashy, not cold. |
| 2026-04-14 | No light mode | Dark theme differentiates from ai.nl and Brthrs (both light). Consistent brand. |

## Preview
Design system preview with full component specimens and homepage mockup:
`~/.gstack/projects/gewoonkennethb-source-automation-sequre/designs/design-system-20260414/preview.html`
