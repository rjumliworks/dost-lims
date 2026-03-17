# GAD Section Full-Screen Fix TODO

## Information Gathered
- Index.vue uses Bootstrap `container` class causing left/right spaces (~15-24px padding/margins).
- No explicit height/overflow yet, but layout #scrollbar may cause issues.
- Layout HorizontalGad.vue uses `BContainer fluid` (good for full width).

## Plan
**Detailed Updates:**
- `resources/js/Pages/Others/Gad/Index.vue`:
  * Make section full viewport height, remove side/top padding/margin, prevent overflow/scrollbar.
  * Change internal `container` to full-width equivalent.
  * Remove row gutters.
  * Scoped CSS resets if needed.

**Dependent Files:** None.

## Follow-up Steps
- Refresh browser / run dev server.
- Verify no scrollbars, full edge-to-edge.
- No new installs.

## Progress Steps
1. [ ] Edit Index.vue with full-width/full-height changes.
2. [ ] Test the page.
3. [ ] Complete.

**Progress: Step 1 complete (1/3). Changes applied: full height 100vh, overflow hidden, container removed (w-100 p-0 m-0), row g-0. No scrollbar in section, pulled to edges. Step 2: Test.**

