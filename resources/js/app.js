import Alpine from 'alpinejs';
import Collapse from '@alpinejs/collapse';
import AOS from 'aos';
import 'aos/dist/aos.css';
import { gsap } from 'gsap';
import { ScrollTrigger } from 'gsap/ScrollTrigger';

gsap.registerPlugin(ScrollTrigger);

Alpine.plugin(Collapse);

window.Alpine = Alpine;
window.gsap = gsap;
window.ScrollTrigger = ScrollTrigger;

Alpine.start();

const prefersReducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

document.addEventListener('DOMContentLoaded', () => {
    AOS.init({ duration: 700, once: true, offset: 80, disable: prefersReducedMotion });

    initMarquees();
    initRevealGroups();
    initWordReveal();
    initParallax();
    initMagnetic();
    initCustomCursor();
});

/**
 * Duplique le contenu de chaque [data-marquee] pour une boucle infinie sans coupure visible.
 */
function initMarquees() {
    document.querySelectorAll('[data-marquee]').forEach((wrapper) => {
        const track = wrapper.querySelector('.marquee-track');
        if (!track || track.dataset.duplicated) return;
        track.innerHTML += track.innerHTML;
        track.dataset.duplicated = 'true';
    });
}

/**
 * Reveal en cascade : tout groupe [data-reveal-group] anime ses [data-reveal] avec un léger décalage.
 */
function initRevealGroups() {
    if (prefersReducedMotion) return;

    document.querySelectorAll('[data-reveal-group]').forEach((group) => {
        const items = group.querySelectorAll('[data-reveal]');
        if (!items.length) return;

        gsap.to(items, {
            opacity: 1,
            y: 0,
            duration: 0.8,
            ease: 'power3.out',
            stagger: 0.1,
            scrollTrigger: {
                trigger: group,
                start: 'top 85%',
            },
        });
    });

    document.querySelectorAll('[data-reveal]').forEach((el) => {
        if (el.closest('[data-reveal-group]')) return;

        gsap.to(el, {
            opacity: 1,
            y: 0,
            duration: 0.8,
            ease: 'power3.out',
            scrollTrigger: {
                trigger: el,
                start: 'top 88%',
            },
        });
    });
}

/**
 * Révèle un titre mot par mot. Markup attendu : conteneur [data-reveal-words] dont le texte
 * est découpé en <span data-reveal-word> côté Blade.
 */
function initWordReveal() {
    document.querySelectorAll('[data-reveal-words]').forEach((container) => {
        const words = container.querySelectorAll('[data-reveal-word]');
        if (!words.length) return;

        if (prefersReducedMotion) {
            words.forEach((w) => { w.style.opacity = 1; w.style.transform = 'none'; });
            return;
        }

        gsap.to(words, {
            opacity: 1,
            y: 0,
            duration: 0.9,
            ease: 'power3.out',
            stagger: 0.06,
            delay: 0.2,
        });
    });
}

/**
 * Parallax léger sur les éléments marqués [data-parallax].
 */
function initParallax() {
    if (prefersReducedMotion) return;

    document.querySelectorAll('[data-parallax]').forEach((el) => {
        gsap.to(el, {
            yPercent: 12,
            ease: 'none',
            scrollTrigger: {
                trigger: el,
                start: 'top bottom',
                end: 'bottom top',
                scrub: true,
            },
        });
    });
}

/**
 * Effet magnétique : les éléments .magnetic suivent légèrement le curseur au survol.
 */
function initMagnetic() {
    if (prefersReducedMotion || window.matchMedia('(pointer: coarse)').matches) return;

    document.querySelectorAll('.magnetic').forEach((el) => {
        const strength = 0.35;

        el.addEventListener('mousemove', (e) => {
            const rect = el.getBoundingClientRect();
            const x = e.clientX - rect.left - rect.width / 2;
            const y = e.clientY - rect.top - rect.height / 2;
            el.style.transform = `translate(${x * strength}px, ${y * strength}px)`;
        });

        el.addEventListener('mouseleave', () => {
            el.style.transform = 'translate(0, 0)';
        });
    });
}

/**
 * Curseur personnalisé desktop : un anneau qui suit la souris et s'agrandit sur les éléments interactifs.
 */
function initCustomCursor() {
    if (prefersReducedMotion || window.matchMedia('(pointer: coarse)').matches) return;

    const cursor = document.querySelector('[data-cursor]');
    if (!cursor) return;

    document.documentElement.classList.add('has-custom-cursor');

    let mouseX = -100;
    let mouseY = -100;
    let ringX = -100;
    let ringY = -100;

    window.addEventListener('mousemove', (e) => {
        mouseX = e.clientX;
        mouseY = e.clientY;
    });

    const tick = () => {
        ringX += (mouseX - ringX) * 0.18;
        ringY += (mouseY - ringY) * 0.18;
        cursor.style.transform = `translate(${ringX}px, ${ringY}px)`;
        requestAnimationFrame(tick);
    };
    requestAnimationFrame(tick);

    document.querySelectorAll('a, button, .magnetic, input, textarea, select').forEach((el) => {
        el.addEventListener('mouseenter', () => cursor.classList.add('is-active'));
        el.addEventListener('mouseleave', () => cursor.classList.remove('is-active'));
    });
}
