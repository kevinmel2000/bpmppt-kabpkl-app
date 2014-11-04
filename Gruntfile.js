/* global module, require */

module.exports = function(grunt) {
  'use strict';

  var packageName = 'BPMPPT App'
  var copyrightHolder = 'BPMPPT Kab. Pekalongan'
  var year = grunt.template.today("yyyy")

  // Force use of Unix newlines
  grunt.util.linefeed = '\n'
  // Load all grunt development dependencies
  require('load-grunt-tasks')(grunt, {scope: 'devDependencies'})
  // Let see total execution times
  require('time-grunt')(grunt)

  grunt.initConfig({
    pkg: grunt.file.readJSON('package.json'),

    usebanner: {
      options: {
        position: 'top',
        banner: '/*!\n' +
                ' * ' + packageName + ' v<%= pkg.version %> (<%= pkg.homepage %>)\n' +
                ' * <%= pkg.description %>\n' +
                ' * Copyright (c) 2013-' + year +' ' + copyrightHolder + ', <%= pkg.author.name %>\n' +
                ' * Licensed under <%= pkg.license.type %> (<%= pkg.license.url %>)\n' +
                ' */\n'
      },
      css: { src: 'asset/css/<%= pkg.name %>*.css' },
      js: { src: 'asset/js/<%= pkg.name %>*.js' }
    },

    clean: {
      css: 'asset/css/<%= pkg.name %>*',
      js: 'asset/js/<%= pkg.name %>*',
      vendor: 'asset/vendor',
      backup: 'asset/bower.old',
      dist: [ '<%= clean.css %>', '<%= clean.js %>' ]
    },

    copy: {
      dist: {
        options: {
          process: function (content) {
            var home     = grunt.config('pkg.homepage')
            var name     = grunt.config('pkg.author.name')
            var lcnsType = grunt.config('pkg.license.type')
            var version  = grunt.config('pkg.version')

            return content
              .replace(/@PACKAGE/g,    packageName + ' v' + version + ' (' + home + ')')
              .replace(/@AUTHOR/g,     name + ' (' + grunt.config('pkg.author.email') + ')')
              .replace(/@COPYRIGHT/g,  '2013-' + year + ' ' + copyrightHolder + ', ' + name)
              .replace(/@LICENSE/g,    lcnsType + ' (' + grunt.config('pkg.license.url') + ')')
          }
        },
        expand: true,
        src: [
          '{system,application}/**',
          '!application/{tests,vendor}/**',
          '!application/storage/{backup,cache,logs,upload}/**',
          'application/storage/{backup,cache,logs,upload}/index.html',
          'asset/{css,js,vendor}/**',
          '!asset/{css,js}/src/**',
          '*.{php,sql,sh}',
          '!appconfig.php',
          '.htaccess',
          'package.json',
          'README.md',
          'LICENSE',
          '!**/*.old',
          '!**/_**',
          '!*.old',
          '!_**'
        ],
        dest: '_dist/'
      },
      distImg: {
        expand: true,
        cwd: 'asset/img/',
        src: [
          '**',
          '!**/*.old',
          '!**/_**',
          '!*.old',
          '!_**'
        ],
        dest: '_dist/asset/img/'
      },
      devJs: {
        src: 'asset/js/src/script.js',
        dest: 'asset/js/<%= pkg.name %>.js'
      },
      vendorBackup: {
        expand: true,
        cwd: 'asset/bower/',
        src: [ '**' ],
        dest: 'asset/bower.old/'
      },
      vendorDist: {
        expand: true,
        cwd: 'asset/bower/',
        src: [ '**' ],
        dest: 'asset/vendor/'
      },
      vendorRestore: {
          expand: true,
          cwd: 'asset/bower.old/',
          src: [ '**' ],
          dest: 'asset/bower/'
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

    jshint: {
      options: {
        jshintrc: '.jshintrc'
      },
      dev: {
        src: 'asset/js/src/*.js'
      }
    },

    jscs: {
      options: {
        config: '.jscsrc'
      },
      dev: {
        src: 'asset/js/src/*.js'
      }
    },

    uglify: {
      options: {
        preserveComments: 'some'
      },
      app: {
        src: 'asset/js/<%= pkg.name %>.js',
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
        expand: true,
        cwd: 'asset/img/',
        dest: 'asset/img/',
        src: [ '**/*.{png,jpg,gif,svg}' ]
      },
      vendor: {
        expand: true,
        cwd: 'asset/vendor/',
        dest: 'asset/vendor/',
        src: [ '**/*.{png,jpg,gif,svg}' ]
      }
    },

    lineending: {
      vendor: {
        options: {
          overwrite: true,
          eol: 'lf'
        },
        files: [{
          expand: true,
          cwd: 'asset/vendor',
          src: [ '**/*.{js,css,svg,less}' ],
          dest: 'asset/vendor/'
        }]
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
      js: {
        files: 'asset/js/src/*.js',
        tasks: 'js-test'
      },
      imgApp: {
        files: '<%= imagemin.app.cwd %>/**/*.{png,jpg,gif,svg}',
        tasks: 'newer:imagemin:app'
      },
      imgVendor: {
        files: '<%= imagemin.vendor.cwd %>/**/*.{png,jpg,gif,svg}',
        tasks: 'newer:imagemin:vendor'
      },
      phpApp: {
        files: '<%= phplint.app %>',
        tasks: 'newer:phplint'
      },
      phpTest: {
        files: '<%= phpunit.app.dir %>/**/*Test.php',
        tasks: 'phpunit'
      }
    }

  })

  grunt.registerTask('php-test',  [ 'phplint', 'phpunit' ])

  grunt.registerTask('css-build', [ 'less', 'autoprefixer', 'csscomb' ])
  grunt.registerTask('css-test',  [ 'css-build', 'csslint', 'cssmin' ])
  grunt.registerTask('css-dist',  [ 'clean:css', 'css-test', 'usebanner:css' ])

  grunt.registerTask('js-build',  [ 'copy:devJs' ])
  grunt.registerTask('js-test',   [ 'js-build', 'jshint', 'jscs', 'uglify' ])
  grunt.registerTask('js-dist',   [ 'clean:js', 'js-test', 'usebanner:js' ])

  grunt.registerTask('img-dist',  [ 'newer:imagemin:app', 'newer:imagemin:vendor' ])

  grunt.registerTask('bower',     [ 'clean:vendor', 'copy:vendorBackup', 'preen', 'copy:vendorDist', 'copy:vendorRestore', 'clean:backup' ])
  grunt.registerTask('build',     [ 'clean:dist', 'php-test', 'css-test', 'js-test', 'usebanner' ])
  grunt.registerTask('dist',      [ 'build', 'bower', 'lineending:vendor', 'img-dist', 'copy:dist', 'copy:distImg' ])
  grunt.registerTask('serve',     [ 'php:serve', 'watch' ])

  grunt.registerTask('default',   [ 'build' ])
}
