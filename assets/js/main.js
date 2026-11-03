/* KG Studios theme scripts. Vanilla JS, no dependencies. */
(() => {
	'use strict';
	const $ = (s, r = document) => r.querySelector(s);
	const $$ = (s, r = document) => Array.from(r.querySelectorAll(s));
	const reduce = matchMedia('(prefers-reduced-motion: reduce)').matches;
	const fine = matchMedia('(hover: hover) and (pointer: fine)').matches;

	/* Header: stuck state, hide on scroll down, scroll progress */
	const header = $('[data-header]');
	const bar = $('.progress i');
	let lastY = 0, ticking = false;
	const onScroll = () => {
		const y = scrollY;
		const max = document.documentElement.scrollHeight - innerHeight;
		if (bar) bar.style.transform = `scaleX(${max > 0 ? y / max : 0})`;
		if (header) {
			header.classList.toggle('is-stuck', y > 20);
			const open = $('.nav.is-open');
			header.classList.toggle('is-hidden', y > lastY && y > 400 && !open);
		}
		lastY = y;
		ticking = false;
	};
	addEventListener('scroll', () => { if (!ticking) { ticking = true; requestAnimationFrame(onScroll); } }, { passive: true });
	onScroll();

	/* Mobile menu */
	const burger = $('.burger');
	const nav = $('#nav');
	if (burger && nav) {
		const set = (open) => {
			nav.classList.toggle('is-open', open);
			burger.setAttribute('aria-expanded', String(open));
			document.body.style.overflow = open ? 'hidden' : '';
		};
		burger.addEventListener('click', () => set(!nav.classList.contains('is-open')));
		nav.addEventListener('click', (e) => { if (e.target.closest('a')) set(false); });
		addEventListener('keydown', (e) => { if (e.key === 'Escape') set(false); });
	}

	/* Scroll reveal */
	const reveals = $$('[data-reveal]');
	if ('IntersectionObserver' in window && !reduce) {
		const io = new IntersectionObserver((entries) => {
			entries.forEach((en) => { if (en.isIntersecting) { en.target.classList.add('is-in'); io.unobserve(en.target); } });
		}, { threshold: 0.12, rootMargin: '0px 0px -6% 0px' });
		reveals.forEach((el) => io.observe(el));
	} else {
		reveals.forEach((el) => el.classList.add('is-in'));
	}

	/* Count-up numbers */
	$$('[data-count]').forEach((el) => {
		if (reduce || !('IntersectionObserver' in window)) return;
		const end = parseFloat(el.dataset.count);
		const pre = el.dataset.prefix || '', suf = el.dataset.suffix || '';
		const io = new IntersectionObserver(([en]) => {
			if (!en.isIntersecting) return;
			io.disconnect();
			const t0 = performance.now(), dur = 1400;
			const tick = (t) => {
				const p = Math.min((t - t0) / dur, 1);
				el.textContent = pre + Math.round(end * (1 - Math.pow(1 - p, 3))) + suf;
				if (p < 1) requestAnimationFrame(tick);
			};
			requestAnimationFrame(tick);
		}, { threshold: 0.6 });
		io.observe(el);
	});

	/* Parallax orbs */
	const orbs = $$('[data-parallax]');
	if (orbs.length && !reduce) {
		addEventListener('scroll', () => {
			orbs.forEach((o) => { o.style.transform = `translate3d(0, ${scrollY * parseFloat(o.dataset.parallax)}px, 0)`; });
		}, { passive: true });
	}

	/* 3D tilt + magnetic buttons (pointer devices only) */
	if (fine && !reduce) {
		$$('.tilt').forEach((el) => {
			el.addEventListener('pointermove', (e) => {
				const r = el.getBoundingClientRect();
				const x = (e.clientX - r.left) / r.width - 0.5;
				const y = (e.clientY - r.top) / r.height - 0.5;
				el.style.transition = 'transform .08s linear, border-color .3s, box-shadow .4s';
				el.style.transform = `perspective(900px) rotateX(${(-y * 6).toFixed(2)}deg) rotateY(${(x * 8).toFixed(2)}deg) translateY(-4px)`;
			});
			el.addEventListener('pointerleave', () => {
				el.style.transition = 'transform .6s cubic-bezier(.2,.7,.2,1), border-color .3s, box-shadow .4s';
				el.style.transform = '';
			});
		});
		$$('.magnet').forEach((el) => {
			el.addEventListener('pointermove', (e) => {
				const r = el.getBoundingClientRect();
				el.style.transform = `translate(${(e.clientX - r.left - r.width / 2) * 0.2}px, ${(e.clientY - r.top - r.height / 2) * 0.3}px)`;
			});
			el.addEventListener('pointerleave', () => { el.style.transform = ''; });
		});
	}

	/* Hero rotating audience line + image stack */
	const cycle = (nodes, ms) => {
		if (nodes.length < 2 || reduce) return;
		let i = 0;
		setInterval(() => {
			nodes[i].classList.remove('is-on');
			i = (i + 1) % nodes.length;
			nodes[i].classList.add('is-on');
		}, ms);
	};
	const rot = $('[data-rotator]');
	if (rot) cycle($$('span', rot), 3600);
	const stack = $('[data-rotator-img]');
	if (stack) cycle($$('img', stack), 3600);

	/* Before / after sliders */
	$$('[data-ba]').forEach((fig) => {
		const range = $('.ba__range', fig);
		const set = () => fig.style.setProperty('--pos', range.value + '%');
		range.addEventListener('input', set);
		set();
		if (!reduce && 'IntersectionObserver' in window) {
			// Nudge the handle once when it scrolls into view to hint it is draggable.
			const io = new IntersectionObserver(([en]) => {
				if (!en.isIntersecting) return;
				io.disconnect();
				const t0 = performance.now();
				const step = (t) => {
					const p = Math.min((t - t0) / 1600, 1);
					range.value = 50 + Math.sin(p * Math.PI * 2) * 22 * (1 - p);
					set();
					if (p < 1) requestAnimationFrame(step); else { range.value = 50; set(); }
				};
				requestAnimationFrame(step);
			}, { threshold: 0.7 });
			io.observe(fig);
		}
	});

	/* Testimonials slider */
	$$('[data-slider]').forEach((sl) => {
		const track = $('.slider__track', sl);
		const dots = $$('.slider__dots button', sl);
		let i = 0, timer;
		const go = (n) => {
			i = (n + dots.length) % dots.length;
			track.style.transform = `translateX(${-i * 100}%)`;
			dots.forEach((d, k) => d.setAttribute('aria-selected', String(k === i)));
		};
		const auto = () => { clearInterval(timer); if (!reduce) timer = setInterval(() => go(i + 1), 7000); };
		dots.forEach((d, k) => d.addEventListener('click', () => { go(k); auto(); }));
		let x0 = null;
		sl.addEventListener('pointerdown', (e) => { x0 = e.clientX; });
		sl.addEventListener('pointerup', (e) => {
			if (x0 !== null && Math.abs(e.clientX - x0) > 40) { go(i + (e.clientX < x0 ? 1 : -1)); auto(); }
			x0 = null;
		});
		sl.addEventListener('mouseenter', () => clearInterval(timer));
		sl.addEventListener('mouseleave', auto);
		auto();
	});

	/* Multi-step lead form */
	$$('[data-steps]').forEach((form) => {
		const steps = $$('.lead__step', form);
		const pips = $$('.lead__progress i', form);
		let cur = 0;
		const show = (n) => {
			cur = n;
			steps.forEach((s, k) => s.classList.toggle('is-active', k === n));
			pips.forEach((p, k) => p.classList.toggle('is-done', k <= n));
		};
		form.addEventListener('click', (e) => {
			if (e.target.closest('[data-next]') && cur < steps.length - 1) show(cur + 1);
			if (e.target.closest('[data-prev]') && cur > 0) show(cur - 1);
		});
		// A status note after submit means the user already reached the last step; show it there.
		show($('.lead__note', form) ? steps.length - 1 : 0);
	});
})();
