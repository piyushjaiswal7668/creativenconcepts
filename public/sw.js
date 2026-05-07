const CACHE = 'cnc-chat-v5';

const APP_SHELL = [
    '/offline.html',
    '/css/chatify/style.css',
    '/css/chatify/light.mode.css',
    '/css/chatify/dark.mode.css',
    '/js/chatify/code.js',
    '/js/chatify/font.awesome.min.js',
    '/js/chatify/autosize.js',
    '/icons/icon-192.png',
    '/icons/icon-512.png',
];

// ── Install: cache app shell ──────────────────────────────────────────────────
self.addEventListener('install', event => {
    self.skipWaiting();
    event.waitUntil(
        caches.open(CACHE).then(cache => cache.addAll(APP_SHELL))
    );
});

// ── Activate: clear old caches ────────────────────────────────────────────────
self.addEventListener('activate', event => {
    event.waitUntil(
        caches.keys().then(keys =>
            Promise.all(keys.filter(k => k !== CACHE).map(k => caches.delete(k)))
        ).then(() => clients.claim())
    );
});

// ── Fetch: network-first for navigation, cache-first for assets ───────────────
self.addEventListener('fetch', event => {
    const { request } = event;
    const url = new URL(request.url);

    // Only cache GET requests — POST/PUT/DELETE cannot be stored in Cache API
    if (request.method !== 'GET') return;

    // Only handle same-origin requests
    if (url.origin !== location.origin) return;

    // Navigation requests → network first, offline fallback
    if (request.mode === 'navigate') {
        event.respondWith(
            fetch(request).catch(() => caches.match('/offline.html'))
        );
        return;
    }

    // Static assets → cache first, then network
    event.respondWith(
        caches.match(request).then(cached => {
            if (cached) return cached;
            return fetch(request).then(response => {
                if (response && response.status === 200 && response.type === 'basic') {
                    const clone = response.clone();
                    caches.open(CACHE).then(cache => cache.put(request, clone));
                }
                return response;
            });
        })
    );
});

// ── Push notifications ────────────────────────────────────────────────────────
self.addEventListener('push', event => {
    if (!event.data) return;
    let data = {};
    try { data = event.data.json(); } catch (e) { data = { title: 'New message', body: event.data.text() }; }

    event.waitUntil(
        self.registration.showNotification(data.title || 'New message', {
            body:    data.body || 'You have a new message',
            icon:    '/icons/icon-192.png',
            badge:   '/icons/icon-192.png',
            vibrate: [200, 100, 200],
            tag:     'chat-message',
            renotify: true,
            data:    { url: data.url || '/chatify' },
        })
    );
});

// ── Notification click ────────────────────────────────────────────────────────
self.addEventListener('notificationclick', event => {
    event.notification.close();
    const target = event.notification.data?.url || '/chatify';

    event.waitUntil(
        clients.matchAll({ type: 'window', includeUncontrolled: true }).then(list => {
            for (const client of list) {
                if (client.url.includes('/chatify') && 'focus' in client) {
                    client.navigate(target);
                    return client.focus();
                }
            }
            if (clients.openWindow) return clients.openWindow(target);
        })
    );
});
