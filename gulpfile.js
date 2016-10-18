var gulp        = require('gulp');
var browserSync = require('browser-sync').create();

gulp.task('browser-sync', function() {
    browserSync.init({
        proxy: "easy-workflow.dev",
        files : ["src/**/*.css", "src/**/*.scss"]
    });
});