import Echo from 'laravel-echo';

window.Pusher = require('pusher-js');

window.Echo = new Echo({
    broadcaster: 'pusher',
    key: window.Laravel.pusherKey,
    cluster: window.Laravel.pusherCluster,
    forceTLS: false,
});
