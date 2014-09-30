/* global module, require */
module.exports = function(grunt) {
  'use strict';

  // Force use of Unix newlines
  grunt.util.linefeed = '\n';
  // Load all grunt development dependencies
  require('load-grunt-tasks')(grunt, {scope: 'devDependencies'});
  // Let see total execution times
  require('time-grunt')(grunt);

  grunt.initConfig({
    pkg: grunt.file.readJSON('package.json'),

    php: {
      dev: {
        options: {
          open: true,
          port: 8088
        }
      }
    },

    phplint: {
      dev: [
        'application/core/*.php',
        'application/controllers/**/*.php',
        'application/libraries/**/*.php',
        'application/models/**/*.php',
        'application/views/**/*.php'
      ],
      bi: [
        'application/bootigniter/*.php',
        'application/bootigniter/**/*.php',
        '!application/bootigniter/_*.php',
        '!application/bootigniter/_vendor/'
      ]
    },

    phpunit: {
      options: {
        bin: 'vendor/bin/phpunit'
      },
      dev: {
        dir: './application/tests'
      }
    },

    less: {
      options: {
        strictMath: true,
        outputSourceFiles: true
      },
      dev: {
        files: {
          "asset/css/style.css": "asset/less/style.less",
          "asset/css/print.css": "asset/less/print.less"
        }
      }
    },

    autoprefixer: {
      options: {
        browsers: [
          'Android 2.3',
          'Android >= 4',
          'Chrome >= 20',
          'Firefox >= 24',
          'Explorer >= 8',
          'iOS >= 6',
          'Opera >= 12',
          'Safari >= 6'
        ],
        map: true
      },
      style: {
        src: 'asset/css/style.css',
        dest: 'asset/css/style.css'
      },
      print: {
        src: 'asset/css/print.css',
        dest: 'asset/css/print.css'
      }
    },

    csscomb: {
      options: {
        config: 'asset/less/.csscomb.json'
      },
      dev: {
        expand: true,
        cwd: 'asset/css/',
        dest: 'asset/css/',
        src: [ '*.css', '!*.min.css' ]
      }
    },

    csslint: {
      dev: {
        options: {
          csslintrc: 'asset/less/.csslintrc'
        },
        src: [ 'asset/css/*.css', '!asset/css/*.min.css' ]
      }
    },

    cssmin: {
      dev: {
        expand: true,
        report: 'gzip',
        cwd: 'asset/css/',
        dest: 'asset/css/',
        src: ['style.css', 'print.css'],
        ext: '.min.css'
      }
    },

    watch: {
      options: {
        nospawn: true,
        livereload: true
      },
      less: {
        files: [ 'asset/less/**/*.less', 'asset/less/*.less' ],
        tasks: [ 'cssdist' ]
      },
      phpTest: {
        files: '<%= phpunit.dev.dir %>/**/*Test.php',
        tasks: 'phpunit'
      },
      phpCore: {
        files: '<%= phplint.dev %>',
        tasks: 'phplint'
      }
    }

  });

  grunt.registerTask('build',   ['cssdist', 'phpdist']);
  grunt.registerTask('phpdist', ['phplint', 'phpunit']);
  grunt.registerTask('cssdist', ['less', 'autoprefixer', 'csscomb', 'csslint', 'cssmin']);
  grunt.registerTask('default', ['php:dev', 'watch']);
}
