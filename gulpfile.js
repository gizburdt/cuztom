var elixir = require('laravel-elixir');
var replace = require('gulp-replace');

elixir.config.sourcemaps = false;

elixir(function(mix) {
    mix.less([
        'vendor/datetimepicker/jquery.datetimepicker.css',
        'less/cuztom.less',
    ], 'assets/dist/css/cuztom.min.css', 'assets/');

    mix.scripts([
        'vendor/vue/dist/vue.js',
        'vendor/datetimepicker/build/jquery.datetimepicker.full.js',
        'js/cuztom-open.js',
        'js/cuztom-ui.js',
        'js/cuztom-sortable.js',
        'js/cuztom-media.js',
        'js/cuztom-close.js',
    ], 'assets/dist/js/cuztom.min.js', 'assets/');
});

gulp.task('prefix', function(){
    gulp.src('./src/**')
        .pipe(replace('Gizburdt', 'Gizzy'))
        .pipe(gulp.dest('./src'));
});