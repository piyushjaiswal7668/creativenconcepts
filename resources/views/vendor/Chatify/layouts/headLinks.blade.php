<title>{{ config('chatify.name') }}</title>

{{-- PWA manifest --}}
<link rel="manifest" href="/manifest.json">

{{-- Meta tags --}}
<meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
<meta name="theme-color" content="#6C63FF">
<meta name="id" content="{{ $id }}">
<meta name="messenger-color" content="{{ $messengerColor }}">
<meta name="messenger-theme" content="{{ $dark_mode }}">
<meta name="csrf-token" content="{{ csrf_token() }}">
<meta name="url" content="{{ url('').'/'.config('chatify.routes.prefix') }}" data-user="{{ Auth::user()->id }}">

{{-- iOS PWA meta tags --}}
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
<meta name="apple-mobile-web-app-title" content="C&amp;C Chat">
<link rel="apple-touch-icon" href="/icons/icon-192.png">

{{-- scripts --}}
<script
  src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="{{ asset('js/chatify/font.awesome.min.js') }}"></script>
<script src="{{ asset('js/chatify/autosize.js') }}"></script>
<script src='https://unpkg.com/nprogress@0.2.0/nprogress.js'></script>

{{-- styles --}}
<link rel='stylesheet' href='https://unpkg.com/nprogress@0.2.0/nprogress.css'/>
<link href="{{ asset('css/chatify/style.css') }}" rel="stylesheet" />
<link href="{{ asset("css/chatify/{$dark_mode}.mode.css") }}" rel="stylesheet" />

{{-- Setting messenger primary color to css --}}
<style>
    :root {
        --primary-color: {{ $messengerColor }};
    }
</style>

{{-- Browser Notifications --}}
<style>
#push-bell-btn {
    background: none; border: none; cursor: pointer;
    color: inherit; padding: 0 6px; font-size: 1rem;
    opacity: 0.6; transition: opacity .2s;
}
#push-bell-btn:hover { opacity: 1; }
#push-bell-btn.notif-on  { opacity: 1; color: #4CAF50; }
#push-bell-btn.notif-off { opacity: 1; color: #f44336; }
</style>
<script>
(function () {
    if (!('Notification' in window)) return;

    function updateBell() {
        const btn = document.getElementById('push-bell-btn');
        if (!btn) return;
        const p = Notification.permission;
        btn.classList.remove('notif-on', 'notif-off');
        if (p === 'granted') {
            btn.classList.add('notif-on');
            btn.title = 'Notifications ON';
            btn.innerHTML = '<i class="fas fa-bell"></i>';
        } else if (p === 'denied') {
            btn.classList.add('notif-off');
            btn.title = 'Notifications blocked — click the 🔒 in the address bar to allow';
            btn.innerHTML = '<i class="fas fa-bell-slash"></i>';
        } else {
            btn.title = 'Click to enable notifications';
            btn.innerHTML = '<i class="fas fa-bell"></i>';
        }
    }

    window.enablePushNotifications = function () {
        if (Notification.permission === 'denied') {
            alert('Notifications are blocked.\nClick the 🔒 icon in the address bar → allow Notifications → refresh the page.');
            return;
        }
        Notification.requestPermission().then(updateBell);
    };

    // Show a notification when a message arrives and tab is not focused.
    // When a SW is registered Chrome requires showNotification() via the SW
    // instead of new Notification() — otherwise it silently does nothing.
    window.showChatNotification = function (senderName, messageText, chatUrl) {
        if (Notification.permission !== 'granted' || !document.hidden) return;
        const opts = {
            body:      messageText || 'Sent you a message',
            icon:      '/icons/icon-192.png',
            badge:     '/icons/icon-192.png',
            tag:       'chat-' + Date.now(),
            renotify:  true,
            data:      { url: chatUrl },
        };
        if ('serviceWorker' in navigator && navigator.serviceWorker.controller) {
            navigator.serviceWorker.ready.then(function (reg) {
                reg.showNotification(senderName, opts);
            });
        } else {
            const n = new Notification(senderName, opts);
            n.onclick = function () { window.focus(); window.location.href = chatUrl; n.close(); };
            setTimeout(function () { n.close(); }, 6000);
        }
    };

    document.addEventListener('DOMContentLoaded', updateBell);
})();
</script>

{{-- PWA: register service worker --}}
<script>
if ('serviceWorker' in navigator) {
    window.addEventListener('load', function () {
        navigator.serviceWorker.register('/sw.js', { scope: '/' })
            .then(function (reg) {
                console.log('[SW] Registered, scope:', reg.scope);
            })
            .catch(function (err) {
                console.warn('[SW] Registration failed:', err);
            });
    });
}
</script>
