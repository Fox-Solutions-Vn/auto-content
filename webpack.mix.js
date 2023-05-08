let mix = require('laravel-mix');

const path = require('path');
let directory = path.basename(path.resolve(__dirname));

const source = 'platform/plugins/' + directory;
const dist = 'public/vendor/core/plugins/' + directory;

mix
    .js(source + '/resources/assets/js/auto-content.js', dist + '/js')
    .js(source + '/resources/assets/js/settings.js', dist + '/js')

if (mix.inProduction()) {
    mix
        .copy(dist + '/js/auto-content.js', source + '/public/js')
        .copy(dist + '/js/settings.js', source + '/public/js');
}
