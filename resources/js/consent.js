/**
 * Consentement aux traceurs (mesure d'audience et publicité).
 *
 * Aucun script tiers (GTM, GA4, Meta, LinkedIn) n'est chargé tant que le
 * visiteur n'a pas cliqué « Accepter ». Les valeurs par défaut de Google
 * Consent Mode v2 (tout à « denied ») sont posées dans le <head> du layout ;
 * les identifiants arrivent via window.oyetechTrackers.
 *
 * Le choix est mémorisé 6 mois puis redemandé ; il reste modifiable à tout
 * moment via le lien « Gérer les cookies » du footer.
 */

const STORAGE_KEY = 'oyetech-consent';
const MAX_AGE_MS = 1000 * 60 * 60 * 24 * 182;

export function readConsent() {
    try {
        const stored = JSON.parse(localStorage.getItem(STORAGE_KEY) || 'null');
        if (!stored || Date.now() - stored.at > MAX_AGE_MS) return null;
        return stored.value;
    } catch {
        return null;
    }
}

function saveConsent(value) {
    try {
        localStorage.setItem(STORAGE_KEY, JSON.stringify({ value, at: Date.now() }));
    } catch {
        // Stockage indisponible (navigation privée…) : le bandeau sera simplement redemandé.
    }
}

function injectScript(src) {
    const script = document.createElement('script');
    script.async = true;
    script.src = src;
    document.head.appendChild(script);
}

let trackersLoaded = false;

function loadTrackers() {
    if (trackersLoaded) return;
    trackersLoaded = true;

    const ids = window.oyetechTrackers || {};
    const gtag = window.gtag;

    gtag('consent', 'update', {
        ad_storage: 'granted',
        ad_user_data: 'granted',
        ad_personalization: 'granted',
        analytics_storage: 'granted',
    });

    if (ids.gtm) {
        window.dataLayer.push({ 'gtm.start': Date.now(), event: 'gtm.js' });
        injectScript(`https://www.googletagmanager.com/gtm.js?id=${encodeURIComponent(ids.gtm)}`);
    }

    if (ids.ga4) {
        injectScript(`https://www.googletagmanager.com/gtag/js?id=${encodeURIComponent(ids.ga4)}`);
        gtag('js', new Date());
        gtag('config', ids.ga4);
    }

    if (ids.metaPixel) {
        /* eslint-disable */
        !function(f,b,e,v,n,t,s){if(f.fbq)return;n=f.fbq=function(){n.callMethod?
        n.callMethod.apply(n,arguments):n.queue.push(arguments)};if(!f._fbq)f._fbq=n;
        n.push=n;n.loaded=!0;n.version='2.0';n.queue=[];t=b.createElement(e);t.async=!0;
        t.src=v;s=b.getElementsByTagName(e)[0];s.parentNode.insertBefore(t,s)}(window,
        document,'script','https://connect.facebook.net/en_US/fbevents.js');
        /* eslint-enable */
        window.fbq('init', ids.metaPixel);
        window.fbq('track', 'PageView');
    }

    if (ids.linkedin) {
        window._linkedin_partner_id = ids.linkedin;
        window._linkedin_data_partner_ids = window._linkedin_data_partner_ids || [];
        window._linkedin_data_partner_ids.push(ids.linkedin);
        injectScript('https://snap.licdn.com/li.lms-analytics/insight.min.js');
    }
}

/** Efface les cookies de mesure déjà posés (passage de « Accepter » à « Refuser »). */
function clearTrackerCookies() {
    const host = window.location.hostname;
    const domains = ['', host, `.${host}`, `.${host.replace(/^www\./, '')}`];

    document.cookie.split(';').forEach((cookie) => {
        const name = cookie.split('=')[0].trim();
        if (!/^(_ga|_gid|_gat|_fbp|_fbc|li_|lidc|bcookie|AnalyticsSyncHistory|UserMatchHistory)/.test(name)) return;
        domains.forEach((domain) => {
            document.cookie = `${name}=; Max-Age=0; path=/${domain ? `; domain=${domain}` : ''}`;
        });
    });
}

/** Composant Alpine du bandeau de consentement. */
export function cookieConsent() {
    return {
        open: false,

        init() {
            const consent = readConsent();
            if (consent === 'granted') loadTrackers();
            this.open = consent === null;
        },

        reopen() {
            this.open = true;
            this.$nextTick(() => this.$refs.title?.focus());
        },

        accept() {
            saveConsent('granted');
            this.open = false;
            loadTrackers();
        },

        refuse() {
            const wasGranted = trackersLoaded;
            saveConsent('denied');
            this.open = false;

            if (wasGranted) {
                window.gtag('consent', 'update', {
                    ad_storage: 'denied',
                    ad_user_data: 'denied',
                    ad_personalization: 'denied',
                    analytics_storage: 'denied',
                });
                clearTrackerCookies();
                // Les scripts déjà chargés ne peuvent pas être déchargés : on recharge la page.
                window.location.reload();
            }
        },
    };
}
