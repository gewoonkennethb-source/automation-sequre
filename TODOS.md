# TODOS — Automation SeQure

## 1. Set up test infrastructure
- **What:** PHPUnit for API endpoints (scan.php, book.php validation paths) + Playwright or basic E2E test for booking flow
- **Why:** 3,500+ lines of code with 0 tests. Booking system handles encrypted PII, slot allocation, and email delivery. Regressions (like the false-confirmation bug) can go undetected until a user reports them.
- **Pros:** Catches bugs before deploy, enables safe refactoring, confidence for future changes
- **Cons:** ~2hrs setup with CC, ongoing test maintenance, needs PHP CLI on dev machine
- **Context:** PHP 8+ on TransIP shared hosting. No CI/CD beyond AutoGit (git push = deploy). No package.json, no build tools. Start with: PHPUnit for book.php/scan.php input validation, then a single Playwright E2E test for the full booking flow.
- **Depends on:** Nothing. Can start anytime.

## 2. Create DESIGN.md
- **What:** Document the implicit design system from styles.css (1,342 lines): color tokens, typography scale, spacing, component patterns, responsive breakpoints
- **Why:** Every future change requires reverse-engineering CSS to find existing patterns. Without documentation, pattern drift is inevitable. The design review recommended /design-consultation.
- **Pros:** Faster future development, prevents inconsistency, onboarding for any future collaborator
- **Cons:** ~30min with CC, needs updates when design changes
- **Context:** CSS has well-organized custom properties (--bg, --accent, --surface, etc.), consistent BEM-ish naming, and established component patterns (.section-header, .btn, .case-card, etc.). Run `/design-consultation` to generate DESIGN.md.
- **Depends on:** Nothing. Can run anytime.

## 3. Anti-slop design sprint
- **What:** Address the 5 AI slop markers: (1) purple accent #6C5CE7, (2) 3-column feature grids, (3) Inter font as primary, (4) centered-everything layout, (5) cookie-cutter section rhythm
- **Why:** Site visually matches thousands of AI-generated B2B sites. In a competitive Dutch AI services market, looking "generated" undermines the trust message.
- **Pros:** Stronger brand identity, better first impression, differentiation from competitors
- **Cons:** Visual disruption for existing visitors, significant CSS changes, need to pick a new accent color and possibly a new font
- **Context:** The design review added anti-slop *guidelines* for the current content update (varied section rhythm, break centered layout). This TODO is for the bigger changes: new accent color, new font, reimagined section layouts.
- **Depends on:** TODO #2 (DESIGN.md) — document current system first, then evolve it.
