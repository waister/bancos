var gulp = require('gulp');
var less = require('gulp-less');
var path = require('path');
var uglify = require('gulp-uglify');
var uglifycss = require('gulp-uglifycss');
var watch = require('gulp-watch');


gulp.task('less', function () {
    return gulp.src('./assets/less/*.less')
        .pipe(less({
            paths: [ path.join(__dirname, 'less', 'includes') ]
        }))
        .pipe(uglifycss({
            "maxLineLen": 80,
            "uglyComments": true
        }))
        .pipe(gulp.dest('./public/css'));
});

gulp.task('uglify', function() {
    return gulp.src('./assets/js/*.js')
        .pipe(uglify())
        .pipe(gulp.dest('./public/js'));
});

gulp.task('watch', function() {
    gulp.watch('./assets/less/*.less', ['less']);
    gulp.watch('./assets/js/*.js', ['uglify']);
});


gulp.task('copy', function() {
    gulp.src('./node_modules/jquery/dist/jquery.min.js')
        .pipe(uglify())
        .pipe(gulp.dest('./public/js'));
});

gulp.task('default', [ 'less', 'uglify', 'copy' ]);
