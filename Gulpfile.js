var elixer = require("laravel-elixir");

elixer.config.assetsDir = 'public/';

elixer(function(mix) {
    mix.styles(
        [
            'bootstrap.min.css',
            'font-awesome.min.css',
            'style.css',
            'media.css',

        ],
        'public/css/styles.css',
        'public/css'
    )

    mix.scripts(
        [
            'libs.js',
            'wall.js',
            'bootstrap.min.js',
            'component.js',
        ],
        'public/js/scripts.js',
        'public/js'
    )
});

