'use strict';

var gulp        = require('gulp'),
    browserSync = require('browser-sync');

gulp.task('browser-sync', function () {
    browserSync({
        proxy: "easy-workflow.dev",
        files: ["{src,web}/**/*.{css,scss,js,twig}"]
    });
});