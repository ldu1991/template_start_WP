'use strict';

var gulp            = require('gulp'),
    plumber         = require("gulp-plumber"),
    uglify          = require('gulp-uglify'),
    concat          = require('gulp-concat'),
    imagemin        = require('gulp-imagemin'),
    pngquant        = require('imagemin-pngquant'),
    sass            = require('gulp-sass'),
    sourcemaps      = require('gulp-sourcemaps'),
    autoprefixer    = require('gulp-autoprefixer'),
    cmq             = require('gulp-combine-mq'),
    csso            = require('gulp-csso'),
    spritesmith     = require('gulp.spritesmith'),
    watch           = require('gulp-watch'),
    gulpSequence    = require('gulp-sequence'),
    browserSync     = require('browser-sync').create(),
    upmodul         = require("gulp-update-modul"),
    update          = require('gulp-update')();

var path = {
    src: {
        sassAll: 'assets/css/scss/**/*.scss',
        sassGen: 'assets/css/scss/[^_]*.scss',
        js: 'assets/js/libs/**/*.js',
        img: 'assets/images/dev/**/*',
        imgSprite: 'assets/images/sprites/*.*',
        imgSpritePath: 'assets/images/sprite.png',
        files: '**/*.php',
        domain: 'agi.ld',
    },
    build: {
        css: 'assets/css/',
        js: 'assets/js/',
        img: 'assets/images/',
        imgSprite: 'assets/images/',
        scssSprite: 'assets/css/scss/',
    }
};

var onError = function (e) {
    console.log(e);
    this.emit('end');
};

gulp.task('server', function() {
  browserSync.init({
    proxy: path.src.domain,
    notify: false,
    port: 9000
  });

  browserSync.watch(path.src.files).on('change', browserSync.reload);
});

// development
gulp.task('sass:dev', function() {
    gulp.src(path.src.sassGen)
        .pipe(plumber({errorHandler: onError}))
        .pipe(sourcemaps.init())
        .pipe(sass())
        .pipe(sourcemaps.write('.'))
        .pipe(gulp.dest(path.build.css))
        .pipe(browserSync.stream());
});

// production
gulp.task('sass:prod', function() {
    gulp.src(path.src.sassGen)
        .pipe(plumber({errorHandler: onError}))
        .pipe(sass())
        .pipe(cmq({beautify: false}))
        .pipe(autoprefixer(['last 40 versions', '> 5%', 'ie 6-9', 'iOS 7'], {cascade: true}))
        .pipe(csso())
        .pipe(gulp.dest(path.build.css));
});

gulp.task('js', function() {
    gulp.src([path.src.js, 'assets/js/main.js'])
        .pipe(sourcemaps.init())
        .pipe(concat('scripts.js'))
        .pipe(sourcemaps.write('.'))
        .pipe(gulp.dest(path.build.js));

    gulp.src([path.src.js, 'assets/js/main.js'])
        .pipe(sourcemaps.init())
        .pipe(concat('scripts.min.js'))
        .pipe(uglify())
        .pipe(sourcemaps.write('.'))
        .pipe(gulp.dest(path.build.js))
        .pipe(browserSync.stream());
});

gulp.task('img', function() {
    gulp.src(path.src.img)
        .pipe(imagemin({
            interlaced: true,
            progressive: true,
            svgoPlugins: [{removeViewBox: false}],
            use: [pngquant()]
        }))
        .pipe(gulp.dest(path.build.img));
});

gulp.task('sprite', function () {
    var spriteData =
        gulp.src(path.src.imgSprite)
            .pipe(plumber({errorHandler: onError}))
            .pipe(spritesmith({
                imgName: 'sprite.png',
                imgPath: path.build.imgSpritePath,
                cssTemplate: 'assets/images/spritesmith.scsstemplate',
                cssName: '_sprite.scss',
                algorithm: 'binary-tree', //top-down
                cssFormat: 'scss_maps',
                padding: 20,
            }));

    spriteData.img.pipe(gulp.dest(path.build.imgSprite));
    return spriteData.css.pipe(gulp.dest(path.build.scssSprite)).pipe(browserSync.stream());
});

gulp.task('watch', function () {
	gulp.watch(path.src.sassAll, ['sass:dev']);
	gulp.watch([path.src.js, 'assets/js/main.js'], ['js']);
    gulp.watch(path.src.imgSprite, ['sprite']);
});

gulp.task('dev', gulpSequence('sass:dev', 'js', ['watch', 'server']));

gulp.task('prod', ['sass:prod', 'js', 'img']);

gulp.task('update-modul', function () {
    gulp.src('package.json')
    .pipe(upmodul('latest, true'));
});

gulp.task('update', function () {
  gulp.watch('package.json').on('change', function (file) {
    update.write(file);
  });
})
