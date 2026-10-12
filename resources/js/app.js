import Alpine from 'alpinejs';
import Collapse from '@alpinejs/collapse';
import AOS from 'aos';
import 'aos/dist/aos.css';
import { gsap } from 'gsap';
import { ScrollTrigger } from 'gsap/ScrollTrigger';
import { cookieConsent } from './consent';

gsap.registerPlugin(ScrollTrigger);

Alpine.plugin(Collapse);

window.Alpine = Alpine;
window.gsap = gsap;
window.ScrollTrigger = ScrollTrigger;

const prefersReducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

/**
 * Compteur animé en amélioration progressive : la valeur finale est rendue côté serveur
 * (visible sans JavaScript) ; l'animation 0 → valeur ne se joue qu'à l'entrée dans l'écran.
 */
Alpine.data('countUp', (target) => ({
    count: target,
    init() {
        if (prefersReducedMotion) return;

        ScrollTrigger.create({
            trigger: this.$el,
            start: 'top 90%',
            once: true,
            onEnter: () => {
                const start = performance.now();
                const step = (now) => {
                    const progress = Math.min((now - start) / 1200, 1);
                    this.count = Math.floor(progress * target);
                    if (progress < 1) requestAnimationFrame(step);
                };
                this.count = 0;
                requestAnimationFrame(step);
            },
        });
    },
}));

Alpine.data('cookieConsent', cookieConsent);

Alpine.start();

document.addEventListener('DOMContentLoaded', () => {
    AOS.init({ duration: 700, once: true, offset: 80, disable: prefersReducedMotion });

    initMarquees();
    initRevealGroups();
    initParallax();
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
