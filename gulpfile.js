var elixir = require('laravel-elixir'),
    replace = require('gulp-replace'),
    prompt = require('gulp-prompt');

elixir.config.sourcemaps = false;

elixir(function(mix) {
    mix.sass([
        'vendor/datetimepicker/jquery.datetimepicker.css',
        'scss/cuztom.scss',
    ], 'assets/dist/css/cuztom.min.css', 'assets/');

    mix.scripts([
        'vendor/vue/dist/vue.min.js',
        'vendor/datetimepicker/build/jquery.datetimepicker.full.js',

        'js/components/repeatable.js',
        'js/components/bundle.js',
        'js/components/media.js',

        'js/cuztom-open.js',
        'js/cuztom-ui.js',
        'js/cuztom-vue.js',
        'js/cuztom-close.js',
    ], 'assets/dist/js/cuztom.min.js', 'assets/');
});

gulp.task('prefix', function(){
    gulp.src('./src/**')
        .pipe(prompt.prompt({
            type: 'input',
            name: 'prefix',
            message: 'Prefix?'
        }, function(result) {
            gulp.src('./src/**')
                .pipe(replace('Gizburdt', result.prefix))
                .pipe(gulp.dest('./src'));
        }));
});