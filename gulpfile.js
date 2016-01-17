// Modules
var gulp = require('gulp');
var less = require('gulp-less');
var concat = require('gulp-concat');
var minifyCss = require('gulp-cssnano');
var uglify = require('gulp-uglify');
var merge = require('merge2');

// Vars
var basePath = 'src/Gizburdt/Cuztom';

// Styles
gulp.task('styles', function() {
    return gulp.src(basePath + '/assets/less/cuztom.less')
        .pipe(less().on('error', less.logError))
        .pipe(minifyCss())
        .pipe(concat('cuztom.min.css'))
        .pipe(gulp.dest(basePath + 'assets/dist/css'));
});

// Scripts
gulp.task('scripts', function() {
    var jsFiles = [
        basePath + '/assets/vendor/angular/angular.min.js',
        basePath + '/assets/js/cuztom.js',
        basePath + '/assets/js/cuztom-open.js',
        basePath + '/assets/js/cuztom-ui.js',
        basePath + '/assets/js/cuztom-sortable.js',
        basePath + '/assets/js/cuztom-image.js',
        basePath + '/assets/js/cuztom-ajax.js',
        basePath + '/assets/js/cuztom-close.js',
    ];

    return gulp.src(jsFiles)
        .pipe(uglify())
        .pipe(concat('cuztom.min.js'))
        .pipe(gulp.dest(basePath + 'assets/dist/js'));
});

// Watch
gulp.task('watch', function() {
    gulp.watch(basePath + 'assets/less/**/*.less', ['styles']);
    gulp.watch(basePath + 'assets/js/**/*.js', ['scripts']);
});

// Default
gulp.task('default', function() {
    gulp.start('styles', 'scripts');
});