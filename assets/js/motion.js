/* KG Studios v2 motion: 3D hero, scroll scene, cursor, slide counter, game, calculator, consent. Vanilla JS. */
(() => {
	'use strict';
	const $ = (s, r = document) => r.querySelector(s);
	const $$ = (s, r = document) => Array.from(r.querySelectorAll(s));
	const root = document.documentElement;

	// OS-level reduced motion behaves like the manual switch.
	if (matchMedia('(prefers-reduced-motion: reduce)').matches) root.classList.add('reduce-motion');
	const reduce = root.classList.contains('reduce-motion');
	const fine = matchMedia('(hover: hover) and (pointer: fine)').matches;
	const raf = (fn) => { let t = false; return () => { if (!t) { t = true; requestAnimationFrame(() => { t = false; fn(); }); } }; };

	/* Hero lens: follows the pointer, drifts along the lettering when nobody is pointing */
	const name = $('[data-lens]');
	if (name && !reduce) {
		name.classList.add('is-lens');
		const hero = name.closest('[data-hero]');
		let px = 0, py = 0, tx = 0, ty = 0, pr = 0, tr = 0, pointing = false, last = 0;
		const frame = (t) => {
			const r = name.getBoundingClientRect();
			if (pointing) {
				tx = lensX - r.left; ty = lensY - r.top; tr = r.height * 0.75;
			} else {
				tx = r.width * (0.5 + 0.4 * Math.sin(t / 2600)); ty = r.height * (0.5 + 0.22 * Math.sin(t / 1700)); tr = r.height * 0.6;
			}
			px += (tx - px) * 0.12; py += (ty - py) * 0.12; pr += (tr - pr) * 0.1;
			name.style.setProperty('--mx', px.toFixed(1) + 'px');
			name.style.setProperty('--my', py.toFixed(1) + 'px');
			name.style.setProperty('--r', pr.toFixed(1) + 'px');
			requestAnimationFrame(frame);
		};
		let lensX = 0, lensY = 0;
		hero.addEventListener('pointermove', (e) => { lensX = e.clientX; lensY = e.clientY; pointing = true; clearTimeout(last); last = setTimeout(() => { pointing = false; }, 2500); });
		hero.addEventListener('pointerleave', () => { pointing = false; });
		requestAnimationFrame(frame);
	}

	/* Scroll scene: slides drift in 3D, then snap into place. Drives --p from 0 to 1. */
	const scene = $('[data-scene]');
	if (scene && !reduce && matchMedia('(min-width: 901px)').matches) {
		const update = raf(() => {
			const r = scene.getBoundingClientRect();
			const span = r.height - innerHeight;
			const raw = span > 0 ? Math.min(Math.max(-r.top / span, 0), 1) : 1;
			const p = Math.min(raw / 0.8, 1);
			scene.style.setProperty('--p', (1 - Math.pow(1 - p, 3)).toFixed(4));
			scene.dataset.state = p < 0.5 ? 'a' : 'b';
		});
		addEventListener('scroll', update, { passive: true });
		addEventListener('resize', update);
		update();
	}

	/* Cursor with context labels */
	const cur = $('.cursor');
	if (cur && fine && !reduce) {
		const dot = $('span', cur);
		let x = 0, y = 0, tx = 0, ty = 0, running = false;
		const loop = () => {
			x += (tx - x) * 0.22;
			y += (ty - y) * 0.22;
			cur.style.transform = `translate3d(${x}px, ${y}px, 0)`;
			if (Math.abs(tx - x) > 0.1 || Math.abs(ty - y) > 0.1) requestAnimationFrame(loop); else running = false;
		};
		addEventListener('pointermove', (e) => {
			tx = e.clientX; ty = e.clientY;
			cur.classList.add('is-on');
			if (!running) { running = true; requestAnimationFrame(loop); }
		});
		document.addEventListener('pointerover', (e) => {
			const t = e.target.closest('[data-cursor], a, button, input, label, summary');
			const label = t && t.dataset.cursor;
			cur.classList.toggle('is-link', !!label);
			cur.classList.toggle('is-small', !!t && !label);
			dot.dataset.label = label || '';
		});
		root.addEventListener('mouseleave', () => cur.classList.remove('is-on'));
	}

	/* Header takes the ink of the chapter beneath it */
	const header = $('[data-header]');
	if (header) {
		const FIELDS = '.f-ink, .f-paper, .f-gold, .f-teal';
		const sync = raf(() => {
			const under = document.elementsFromPoint(innerWidth / 2, 36).find((el) => !header.contains(el) && el.closest(FIELDS));
			const field = under && under.closest(FIELDS);
			header.dataset.ink = field && field.classList.contains('f-ink') ? 'dark' : 'light';
		});
		addEventListener('scroll', sync, { passive: true });
		addEventListener('resize', sync);
		sync();
	}

	/* Services index: hover, focus or tap a name to swap the sheet beside it */
	$$('[data-index]').forEach((box) => {
		const links = $$('[data-idx]', box);
		const panels = $$('[data-panel]', box);
		const show = (i) => {
			links.forEach((l, k) => l.classList.toggle('is-on', k === i));
			panels.forEach((p, k) => p.classList.toggle('is-on', k === i));
		};
		links.forEach((l, i) => {
			l.addEventListener('mouseenter', () => show(i));
			l.addEventListener('focus', () => show(i));
		});
	});

	/* Fix this slide */
	$$('[data-game]').forEach((stage) => {
		const blocks = $$('.blk', stage);
		const counter = $('[data-game-count]');
		const win = $('[data-game-win]');
		const solve = $('[data-game-solve]');
		let done = 0;
		const put = (b, l, t, rot) => {
			b.style.left = l + '%';
			b.style.top = t + '%';
			b.style.transform = `rotate(${rot}deg)`;
		};
		const lock = (b) => {
			if (b.classList.contains('is-set')) return;
			put(b, +b.dataset.l, +b.dataset.t, 0);
			b.classList.remove('is-drag');
			b.classList.add('is-set');
			done += 1;
			if (counter) counter.textContent = done;
			if (win && done === blocks.length) win.hidden = false;
		};
		blocks.forEach((b) => {
			b.style.width = b.dataset.w + '%';
			b.style.height = b.dataset.h + '%';
			put(b, +b.dataset.sl, +b.dataset.st, +b.dataset.sr);
			let sx = 0, sy = 0, ol = 0, ot = 0, active = false;
			b.addEventListener('pointerdown', (e) => {
				if (b.classList.contains('is-set')) return;
				active = true;
				b.setPointerCapture(e.pointerId);
				b.classList.add('is-drag');
				sx = e.clientX; sy = e.clientY;
				ol = parseFloat(b.style.left); ot = parseFloat(b.style.top);
				b.style.transform = 'rotate(0deg)';
			});
			b.addEventListener('pointermove', (e) => {
				if (!active) return;
				const r = stage.getBoundingClientRect();
				const l = Math.min(Math.max(ol + (e.clientX - sx) / r.width * 100, 0), 100 - +b.dataset.w);
				const t = Math.min(Math.max(ot + (e.clientY - sy) / r.height * 100, 0), 100 - +b.dataset.h);
				b.style.left = l + '%';
				b.style.top = t + '%';
			});
			const end = () => {
				if (!active) return;
				active = false;
				b.classList.remove('is-drag');
				if (Math.abs(parseFloat(b.style.left) - +b.dataset.l) < 6 && Math.abs(parseFloat(b.style.top) - +b.dataset.t) < 8) lock(b);
			};
			b.addEventListener('pointerup', end);
			b.addEventListener('pointercancel', end);
		});
		if (solve) {
			solve.addEventListener('click', () => {
				blocks.filter((b) => !b.classList.contains('is-set')).forEach((b, i) => setTimeout(() => lock(b), i * 160));
			});
		}
	});

	/* Quote calculator: indicative range from the per-slide rates set in the Customizer */
	const K = window.KG || {};
	$$('[data-calc]').forEach((box) => {
		const range = $('[data-calc-slides]', box);
		const num = $('[data-calc-n]', box);
		const out = $('[data-calc-range]', box);
		const cta = $('[data-calc-cta]', box);
		const fmt = (v) => new Intl.NumberFormat('en-IN').format(v);
		const update = () => {
			const s = +range.value;
			num.textContent = s;
			out.textContent = `${K.currency || ''}${fmt(s * K.rateLow)} – ${K.currency || ''}${fmt(s * K.rateHigh)}`;
			const u = new URL(cta.href);
			u.searchParams.set('slides', s);
			u.hash = 'contact';
			cta.href = u.toString();
		};
		range.addEventListener('input', update);
		update();
	});

	/* Cookie consent (Google Consent Mode v2). Analytics stays denied until accepted. */
	const banner = $('.consent');
	if (banner) {
		const stored = () => { try { return localStorage.getItem('kg_consent'); } catch (e) { return null; } };
		const choose = (v) => {
			try { localStorage.setItem('kg_consent', v); } catch (e) { /* storage blocked: choice lasts this page only */ }
			if (window.gtag) window.gtag('consent', 'update', { analytics_storage: v });
			banner.hidden = true;
		};
		if (!stored()) banner.hidden = false;
		$$('[data-consent]').forEach((b) => b.addEventListener('click', () => choose(b.dataset.consent)));
		$$('[data-consent-open]').forEach((b) => b.addEventListener('click', () => { banner.hidden = false; }));
	}

	/* Manual reduce-motion switch (footer) */
	const toggle = $('[data-motion-toggle]');
	if (toggle) {
		toggle.setAttribute('aria-pressed', String(root.classList.contains('reduce-motion')));
		toggle.addEventListener('click', () => {
			try {
				if (root.classList.contains('reduce-motion')) localStorage.removeItem('kg_reduce'); else localStorage.setItem('kg_reduce', '1');
			} catch (e) { /* storage blocked: nothing to persist */ }
			location.reload();
		});
	}
})();
