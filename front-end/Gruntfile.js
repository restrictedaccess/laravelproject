/**
 * Pegara's Brain Salvation
 */

'use strict';

module.exports = function (grunt) {
  var RE_USE_STRICT_STATEMENT = /(^|\n)[ \t]*('use strict'|"use strict");?\s*/g;
  var RE_CONSOLE_METHODS = /console.[\w]+\(.*?(\w*\(.*\))*\);/g;
  var BANNER_TEMPLATE_STRING = "/*! <%= pkg.name %> - v<%= pkg.version %> ( <%= grunt.template.today(\"yyyy-mm-dd\") %> ) - <%= pkg.license %> */";
  var BUILD_ORDERED_LIST = [
    'dev/javascript/wall/main.js',
    'dev/javascript/wall/util/dispatcher.js',
    'dev/javascript/wall/util/string.js',
    'dev/javascript/wall/util/date.js',
    'dev/javascript/wall/util/url.js',
    'dev/javascript/wall/util/fetch.js',
    'dev/javascript/wall/util/put.js',
    'dev/javascript/wall/util/dimension.js',
    'dev/javascript/wall/util/validation.js',
    'dev/javascript/wall/widget/elements.js',
    'dev/javascript/wall/widget/form.js',
    'dev/javascript/wall/widget/surveyModule.js',
    'dev/javascript/wall/page/all.js',
    'dev/javascript/wall/page/rrs.js',
    'dev/javascript/wall/page/profile.js',
    'dev/javascript/wall/page/survey.js',
    'dev/javascript/wall/page/score.js'
  ];
  var BUILD_ORDERED_LIST_LIB = [
    'dev/javascript/libs/jquery/jquery.js',
    'dev/javascript/libs/lodash/lodash.js',
    'dev/javascript/libs/fastclick/fastclick.js',
    'dev/javascript/libs/jsrender/jsrender.js',
    'dev/javascript/libs/Chart.js/Chart.js',
    'dev/javascript/libs/countUp.js/countUp.min.js',
    'dev/javascript/libs/jquery-validation/jquery.validate.js'
  ];

  /*
   * Project Configuration.
   */
  grunt.initConfig({
    pkg: grunt.file.readJSON('package.json'),
    bower: {
      install: {
        options: {
          targetDir: 'dev/javascript/libs',
          layout: 'byType', // Options: byType, byComponent
          install: true,
          verbose: false,
          cleanTargetDir: true,
          cleanBowerDir: false
        }
      }
    },
    connect: {
      wall: {
        options: {
          debug: true,
          port: 9003,
          base: 'build/',
          directory: 'build/',
          livereload: true
        }
      }
    },
    assemble: {
      options: {
        assets: 'build/public/',
        layoutdir: 'dev/html/layout',
        partials: 'dev/html/partial/*.hbs',
        data: 'dev/html/data/*.json'
      },
      wall: {
        expand: true,
        cwd: 'dev/html/page',
        src: ['**.hbs', '**/*.hbs'],
        dest: 'build/'
      }
    },
    prettify: {
      moc: {
        options: {
          "indent": 1,
          "indent_char": "  "
        },
        expand: true,
        cwd: 'build/',
        ext: '.html',
        src: ['*.html'],
        dest: 'build/'
      }
    },
    compass: {
      options: {
        raw: 'Encoding.default_external = \'utf-8\'\n',
      },
      wall: {
        options: {
          httpPath: 'build',
          sassDir: 'dev/stylesheet',
          cssDir: 'build/public/css',
          specify: 'dev/stylesheet/style.scss',
          force: true
        }
      }
    },
    autoprefixer: {
      options: {
        browsers: ['last 2 versions', 'ie 9', 'ie 10', 'ios >= 6', 'android >= 2.3']
      },
      multipul_files: {
        expand: true,
        flatten: true,
        src: 'build/public/css/*.css',
        dest: 'build/public/css/'
      }
    },
    cssmin: {
      minify: {
        expand: true,
        cwd: 'build/public/css/',
        src: ['*.css', '!*.min.css'],
        dest: 'build/public/css/',
        ext: '.min.css'
      }
    },
    uglify: {
      options: {
        report: 'min',
        preserveComments: 'some'
      },
      wall: {
        options: {
          sourceMap: 'build/public/js/wall.map.js',
          sourceMappingURL: 'wall.map.js',
          sourceMapPrefix: 2
        },
        files: {
          'build/public/js/wall.min.js': ['build/public/js/wall.js']
        }
      },
      libs: {
        files: {
          'build/public/js/libs.min.js': ['build/public/js/libs.js']
        }
      }
    },
    minjson: {
      compile: {
        files: {
          'build/data/data.min.json': 'build/data/data.json'
        }
      }
    },
    license_collection: {
      wall: {
        src: BUILD_ORDERED_LIST_LIB,
        dest: 'build/public/js/license.js'
      }
    },
    concat: {
      options: {
        stripBanners: true,
        banner: [BANNER_TEMPLATE_STRING, '(function(window) {', '', '', ''].join('\n'),
        footer: ['', '})(this);'].join('\n')
      },
      dev_wall: {
        src: BUILD_ORDERED_LIST,
        dest: 'build/public/js/wall.js'
      },
      wall: {
        src: BUILD_ORDERED_LIST,
        dest: 'build/public/js/wall.js',
        options: {
          stripBanners: true,
          banner: [BANNER_TEMPLATE_STRING, '(function(window) {', '', '', ''].join('\n'),
          footer: ['', '})(this);'].join('\n'),
          process: function (content) {
            return content.replace(RE_USE_STRICT_STATEMENT, '$1').replace(RE_CONSOLE_METHODS, '');
          }
        }
      },
      libs: {
        src: BUILD_ORDERED_LIST_LIB,
        dest: 'build/public/js/libs.js',
        options: {
          stripBanners: true,
          banner: '',
          footer: ''
        }
      },
      license: {
        src: ['build/public/js/license.js', 'build/public/js/libs.min.js'],
        dest: 'build/public/js/libs.min.js',
        options: {
          stripBanners: true,
          banner: '',
          footer: ''
        }
      },
      data: {
        src: ['dev/javascript/data/form-*.json'],
        dest: 'build/data/data.json',
        options: {
          banner: '{\n',
          footer: '}',
          separator: ',\n'
        }
      }
    },
    copy: {
      images: {
        files: [{
          expand: true,
          cwd: 'dev/images',
          src: ['**/*.{png,jpg,svg,ico}'],
          dest: 'build/public/images'
        }]
      },
      fonts: {
        expand: true,
        flatten: true,
        cwd: 'dev/fonts',
        src: ['*.{eot,svg,ttf,woff,woff2}'],
        dest: 'build/public/fonts'
      }
    },
    sprite: {
      icon: {
        src: 'dev/images/sprite/icons/*.png',
        dest: 'build/public/images/sprite/sprite.png',
        retinaSrcFilter: ['dev/images/sprite/icons/*@2x.png'],
        retinaDest: 'build/public/images/sprite/sprite@2x.png',
        destCss: 'dev/stylesheet/sprite/_icon.scss',
        imgPath: '../images/sprite/sprite.png',
        retinaImgPath: '../images/sprite/sprite@2x.png',
        padding: 4
      }
    },
    clean: {
      moc: ['build/*.html'],
      css: ['build/public/css/*.css'],
      js: ['build/public/js/*.js'],
    },
    watch: {
      options: {
        livereload: true
      },
      mocbuild: {
        files: ['dev/html/**/*.hbs', 'dev/html/page/**/*.hbs', 'dev/html/data/*.json'],
        tasks: ['mocbuild']
      },
      cssbuild: {
        files: ['dev/stylesheet/**/*.scss'],
        tasks: ['cssbuild']
      },
      jsbuild: {
        files: [BUILD_ORDERED_LIST],
        tasks: ['concat:dev_wall']
      },
      data: {
        files: ['dev/javascript/data/form-*.json'],
        tasks: ['concat:data', 'minjson']
      },
      sprite: {
        files: ['dev/images/sprite/icons/*.png'],
        tasks: ['sprite']
      }
    },

  });

  /*
   * load NPM tasks
   */
  grunt.loadNpmTasks('grunt-bower-task');
  grunt.loadNpmTasks('grunt-contrib-clean');
  grunt.loadNpmTasks('grunt-assemble');
  grunt.loadNpmTasks('grunt-prettify');
  grunt.loadNpmTasks('grunt-contrib-compass');
  grunt.loadNpmTasks('grunt-autoprefixer');
  grunt.loadNpmTasks('grunt-contrib-cssmin');
  grunt.loadNpmTasks('grunt-contrib-concat');
  grunt.loadNpmTasks('grunt-contrib-uglify');
  grunt.loadNpmTasks('grunt-license-collection');
  grunt.loadNpmTasks('grunt-contrib-watch');
  grunt.loadNpmTasks('grunt-contrib-copy');
  grunt.loadNpmTasks('grunt-spritesmith');
  grunt.loadNpmTasks('grunt-contrib-connect');
  grunt.loadNpmTasks('grunt-minjson');

  /*
   * Default tasks
   */
  grunt.registerTask('mocbuild', [
    'clean:moc',
    'assemble',
    'prettify:moc',
  ]);

  grunt.registerTask('cssbuild', [
    'clean:css',
    'compass:wall',
    'autoprefixer',
    'cssmin',
  ]);

  grunt.registerTask('jsbuild', [
    'clean:js',
    'concat:libs',
    'concat:wall',
    'concat:data',
    'uglify',
    'minjson',
    'license_collection:wall',
    'concat:license',
  ]);

  grunt.registerTask('dev', [
    'bower',
    'mocbuild',
    'sprite',
    'cssbuild',
    'jsbuild',
  ]);

  grunt.registerTask('build', [
    'mocbuild',
    'sprite',
    'cssbuild',
    'jsbuild',
    'copy',
  ]);

  grunt.registerTask('server', [
    'build',
    'connect:wall',
    'watch'
  ]);
};
