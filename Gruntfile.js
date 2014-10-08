/* global module, require */

module.exports = function(grunt) {
  'use strict';

  // Force use of Unix newlines
  grunt.util.linefeed = '\n';
  // Load all grunt development dependencies
  require('load-grunt-tasks')(grunt, {scope: 'devDependencies'});
  // Let see total execution times
  require('time-grunt')(grunt);

  RegExp.quote = function (string) {
    return string.replace(/[-\\^$*+?.()|[\]{}]/g, '\\$&');
  };

  grunt.initConfig({
    pkg: grunt.file.readJSON('package.json'),

    usebanner: {
      options: {
        position: 'top',
        banner: '/*!\n' +
                ' * BPMPPT App v<%= pkg.version %> (<%= pkg.homepage %>)\n' +
                ' * <%= pkg.description %>\n' +
                ' * Copyright 2014 <%= pkg.author.name %> (<%= pkg.author.email %>)\n' +
                ' * Licensed under <%= pkg.license.type %> (<%= pkg.license.url %>)\n' +
                ' */\n'
      },
      css: {
        src: 'asset/css/<%= pkg.name %>*.css'
      },
      js: {
        src: 'asset/js/<%= pkg.name %>*.js'
      }
    },

    clean: {
      css: 'asset/css/<%= pkg.name %>*',
      js: 'asset/js/<%= pkg.name %>*',
      dist: [ '<%= clean.css %>', '<%= clean.js %>' ],
      vendor: [ 'asset/bower' ]
    },

    copy: {
      dist: {
        files: [
          {
            expand: true,
            src: [
              'system/**',
              'application/**',
              '!application/tests/**',
              '!application/vendor/**',
              '!application/storage/{backup,cache,logs,upload}/**',
              'application/storage/{backup,cache,logs,upload}/index.html',
              '!**/**.old',
              '!**/_**'
            ],
            dest: '_dist/'
          },
          {
            expand: true,
            src: [
              'asset/{css,img,js,vendor}/**',
              '!asset/{css,img,js}/src/**',
              '!**/_**'
            ],
            dest: '_dist/'
          },
          {
            expand: true,
            src: [
              '*.{php,sql,sh}',
              '!_*',
              '!appconfig.php',
              '.htaccess',
              'package.json',
              'README.md',
              'LICENSE'
            ],
            dest: '_dist/'
          }
        ]
      },
      vendor: {
        files: [
          {
            expand: true,
            cwd: 'asset/bower/',
            src: [ '**' ],
            dest: 'asset/vendor/'
          }
        ]
      }
    },

    php: {
      serve: {
        options: {
          open: true,
          port: 8088
        }
      }
    },

    phplint: {
      app: [
        'application/core/*.php',
        'application/controllers/**/*.php',
        'application/libraries/**/*.php',
        'application/helper/*.php',
        'application/models/*.php',
        'application/views/*.php',
        'application/views/**/*.php',
        'application/bootigniter/*.php',
        'application/bootigniter/**/*.php'
      ]
    },

    phpunit: {
      options: {
        bin: 'application/vendor/bin/phpunit -c application/tests/phpunit.xml'
      },
      app: {
        dir: 'application/tests'
      }
    },

    less: {
      options: {
        sourceMap: true,
        strictMath: true,
        outputSourceFiles: true
      },
      appScreen: {
        options: {
          sourceMapURL: '<%= pkg.name %>.css.map',
          sourceMapFilename: 'asset/css/<%= pkg.name %>.css.map'
        },
        files: {
          "asset/css/<%= pkg.name %>.css": "asset/css/src/app-screen.less"
        }
      },
      appPrint: {
        options: {
          sourceMapURL: '<%= pkg.name %>-print.css.map',
          sourceMapFilename: 'asset/css/<%= pkg.name %>-print.css.map'
        },
        files: {
          "asset/css/<%= pkg.name %>-print.css": "asset/css/src/app-print.less"
        }
      }
    },

    autoprefixer: {
      options: {
        map: true,
        browsers: [
          'Android 2.3',
          'Android >= 4',
          'Chrome >= 20',
          'Firefox >= 24',
          'Explorer >= 8',
          'iOS >= 6',
          'Opera >= 12',
          'Safari >= 6'
        ]
      },
      app: {
        src: [
          'asset/css/<%= pkg.name %>.css',
          'asset/css/<%= pkg.name %>-print.css'
        ]
      }
    },

    csscomb: {
      options: {
        config: '.csscombrc'
      },
      app: {
        expand: true,
        cwd: 'asset/css/',
        dest: 'asset/css/',
        src: [
          '<%= pkg.name %>.css',
          '<%= pkg.name %>-print.css'
        ]
      }
    },

    csslint: {
      app: {
        options: {
          csslintrc: '.csslintrc'
        },
        src: [
          'asset/css/<%= pkg.name %>.css',
          'asset/css/<%= pkg.name %>-print.css'
        ]
      }
    },

    cssmin: {
      options: {
        report: 'gzip'
      },
      app: {
        files: {
          'asset/css/<%= pkg.name %>.min.css':       'asset/css/<%= pkg.name %>.css',
          'asset/css/<%= pkg.name %>-print.min.css': 'asset/css/<%= pkg.name %>-print.css'
        }
      }
    },

    // concat: {
    //   dev: {
    //     src: [ 'asset/js/src/intro.js', 'asset/js/src/smof-*.js', 'asset/js/src/outro.js' ],
    //     dest: 'asset/js/<%= pkg.name %>.js'
    //   }
    // },

    // jshint: {
    //   options: {
    //     jshintrc: '.jshintrc'
    //   },
    //   dev: {
    //     src: 'asset/js/script.js'
    //   }
    // },

    // jscs: {
    //   options: {
    //     config: '.jscsrc'
    //   },
    //   dev: {
    //     src: 'asset/js/script.js'
    //   }
    // },

    uglify: {
      options: {
        preserveComments: 'some'
      },
      app: {
        src: 'asset/js/src/script.js',
        dest: 'asset/js/<%= pkg.name %>.min.js'
      }
    },

    imagemin: {
      options: {
        optimizationLevel: 3,
        progressive: true,
        interlaced: true
      },
      app: {
        files: [{
          expand: true,
          cwd: 'asset/img/',
          dest: 'asset/img/',
          src: [ '**/*.{png,jpg,gif}' ]
        }]
      }
    },

    sed: {
      versionNumber: {
        path: 'application/*',
        pattern: (function () {
          var old = grunt.option('old');
          return old ? RegExp.quote(old) : old;
        })(),
        replacement: grunt.option('new'),
        recursive: true
      }
    },

    watch: {
      options: {
        nospawn: true,
        livereload: true
      },
      less: {
        files: [ 'asset/css/src/**/*.less', 'asset/css/src/*.less' ],
        tasks: [ 'css-test' ]
      },
      phpTest: {
        files: '<%= phpunit.app.dir %>/**/*Test.php',
        tasks: 'phpunit'
      },
      phpApp: {
        files: '<%= phplint.app %>',
        tasks: 'phplint'
      }
    }

  });


  grunt.registerTask('php-test',    [ 'phplint', 'phpunit' ]);

  grunt.registerTask('css-build',   [ 'less', 'autoprefixer', 'csscomb' ]);
  grunt.registerTask('css-test',    [ 'css-build', 'csslint', 'cssmin' ]);
  grunt.registerTask('css-dist',    [ 'clean:css', 'css-test', 'usebanner:css' ]);

  grunt.registerTask('js-build',    [ 'uglify' ]);
  grunt.registerTask('js-dist',     [ 'clean:js', 'js-build', 'usebanner:js' ]);

  grunt.registerTask('build',       [ 'clean:dist', 'php-test', 'css-test', 'js-build', 'imagemin', 'usebanner' ]);
  grunt.registerTask('dist',        [ 'build', 'preen', 'copy:vendor', 'clean:vendor' ]);
  grunt.registerTask('serve',       [ 'php:serve', 'watch' ]);

  grunt.registerTask('default',     [ 'build' ]);
}
