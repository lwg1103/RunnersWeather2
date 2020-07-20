self.addEventListener('install', function (event) {
    console.log('install event: ', event);
    event.waitUntil(
            caches.open('main-cache')
            .then(function (cache) {
                return cache.addAll(
                        [
                            '//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css',
                            'https://fonts.googleapis.com/css?family=Libre+Baskerville:400,700',
                            '//netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css',
                            '/images/icon192.png',
                            '/images/icon512.png',
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