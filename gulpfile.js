// Modules
var gulp    = require('gulp'),
    less    = require('gulp-less'),
    concat  = require('gulp-concat'),
    minify  = require('gulp-cssnano'),
    uglify  = require('gulp-uglify'),
    merge   = require('merge2'),
    wrap    = require("gulp-wrap");

// Vars
var basePath = 'src/Gizburdt/Cuztom';

// Styles
gulp.task('styles', function() {
    gulp.src(basePath + '/assets/less/cuztom.less')
        .pipe(less().on('error', function(){ console.log(less.logError); }))
        .pipe(minify())
        .pipe(concat('cuztom.min.css'))
        .pipe(gulp.dest(basePath + '/assets/dist/css'));
});

// Scripts
gulp.task('scripts', function() {
    var jsFiles = [
        basePath + '/assets/js/cuztom.js',
        basePath + '/assets/js/cuztom-ui.js',
        basePath + '/assets/js/cuztom-sortable.js',
        basePath + '/assets/js/cuztom-image.js',
        basePath + '/assets/js/cuztom-ajax.js',
    ];

    var ngFiles = [
        basePath + '/assets/vendor/angular/angular.min.js',
    ];

    gulp.src(jsFiles)
        .pipe(uglify())
        .pipe(concat('cuztom.min.js'))
        .pipe(wrap(('jQuery.noConflict(); jQuery(function($) { var doc = $(document); <%= contents %> });')))
        .pipe(gulp.dest(basePath + '/assets/dist/js'));

    gulp.src(ngFiles)
        .pipe(uglify())
        .pipe(concat('cuztom-angular.min.js'))
        .pipe(gulp.dest(basePath + '/assets/dist/js'));
});

// Watch
gulp.task('watch', function() {
    gulp.watch(basePath + '/assets/less/**/*.less', ['styles']);
    gulp.watch(basePath + '/assets/js/**/*.js', ['scripts']);
});

// Default
gulp.task('default', function() {
    gulp.start('styles', 'scripts');
});