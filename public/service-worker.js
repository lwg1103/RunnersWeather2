self.addEventListener('install', function (event) {
    console.log('install event: ', event);
    event.waitUntil(
            caches.open('main-cache')
            .then(function (cache) {
                return cache.addAll(
                        [
                            '/build/app.css',
                            '/build/app.js',
                            '/build/entrypoints.json',
                            '/build/manifest.json',
                            '/build/runtime.js',
                            '/build/vendors~app.js',
                            '/offline.html'
                        ]
                        );
            })
            );
});
self.addEventListener('fetch', event => {
    event.respondWith(
            caches.match(event.request)
            .then(function (response) {
                return response || fetch(event.request);
            })
            .catch(function () {
                return caches.match('/offline.html');
            })
            );
});