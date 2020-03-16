// Load plugins
var pkg = require('./package.json'),
    secrets = require('./secrets.json'),
    gulp = require('gulp'),
	gutil = require('gulp-util'),
    changed = require('gulp-changed'),
    cleancss = require('gulp-clean-css'),
    concat = require('gulp-concat'),
    ftp = require('vinyl-ftp'),
    rename = require('gulp-rename'),
    sass = require('gulp-sass'),
    sourcemaps = require('gulp-sourcemaps'),
    uglify = require('gulp-uglify-es').default;

//Create FTP connection
var conn = ftp.create({
    host: secrets.ftphost,
    user: secrets.ftpusername,
    password: secrets.ftppassword,
    parallel: 5,
	log: gutil.log
});

var development = pkg.environment != 'production';

// Main Task
gulp.task('default', function() {
    gulp.watch(pkg.sourceFiles, ['source']);
    gulp.watch(['src/**/*.scss'], ['stylesheets']);
    gulp.watch(['src/**/*.js'], ['javascript']);
});

gulp.task('source', function() {
    gulp.src(pkg.sourceFiles)
        .pipe(changed('./dist/'))
        .pipe(gulp.dest('./dist/'))
        //.pipe(conn.dest(secrets.ftppath));
});

gulp.task('stylesheets', function() {
    var compileSass = gulp.src('src/scss/app.scss');

    if(development)
        compileSass = compileSass.pipe(sourcemaps.init());

    compileSass = compileSass
        .pipe(sass({ style: 'compressed' }).on('error', sass.logError))
        .pipe(concat('app.css'))
        .pipe(rename({ suffix: '.min' }))
        .pipe(cleancss({ keepBreaks: false }));

    if(development)
        compileSass = compileSass.pipe(sourcemaps.write());

    compileSass.pipe(gulp.dest('./dist/css'));
    // compileSass.pipe(conn.dest(secrets.ftppath + '/css'));
});

gulp.task('javascript', function() {

    var taskCompileSrc = gulp
        .src(["src/**/*.js", "!src/**/*.standalone.js"]);

    var taskCompileStandalone = gulp
        .src(['src/**/**/**.standalone.js'])

    if(development) {
        taskCompileSrc = taskCompileSrc
            .pipe(sourcemaps.init());
        taskCompileStandalone = taskCompileStandalone
            .pipe(sourcemaps.init());
    }

    taskCompileSrc = taskCompileSrc
        .pipe(concat('app.js'))
        .pipe(rename({ suffix: '.min' }))
        .pipe(uglify());
    
    taskCompileStandalone = taskCompileStandalone
        .pipe(rename({ suffix: '.min' }))
        .pipe(uglify());

    if(development) {
        taskCompileSrc = taskCompileSrc
            .pipe(sourcemaps.write());
        taskCompileStandalone = taskCompileStandalone
            .pipe(sourcemaps.write());
    }

    taskCompileSrc = taskCompileSrc
        .pipe(gulp.dest('./dist/js'));

    taskCompileStandalone = taskCompileStandalone
        .pipe(gulp.dest('./dist/js'));
});

gulp.task('deploy', [
    'stylesheets',
    'javascript'
], function() {
    // gulp.src(pkg.sourceFiles)
    //     .pipe(conn.dest(secrets.ftppath));
});