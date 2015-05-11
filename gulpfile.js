var gulp = require('gulp');
var uglify = require('gulp-uglify');
var sass = require('gulp-ruby-sass');
var prefix = require('gulp-autoprefixer');

gulp.task('default', ['css', 'js']);

gulp.task('css', function() {
    return sass('./assets/scss/', { style: 'compressed' })
        .pipe(prefix({
            browsers: ['last 2 version'],
            cascade: false
        }))
        .pipe(gulp.dest('./src/Resources/css'));
});

gulp.task('js', function() {
    gulp.src('./assets/js/*.js')
        .pipe(uglify())
        .pipe(gulp.dest('./src/Resources/js'));
});

gulp.task('watch', ['css', 'js'], function() {
    gulp.watch('./assets/scss/*.scss', ['css']);
    gulp.watch('./assets/js/*.js', ['js']);
});