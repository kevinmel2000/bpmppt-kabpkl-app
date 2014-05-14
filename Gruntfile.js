module.exports = function(grunt) {
  'use strict';

  grunt.initConfig({
    // Metadata.
    php: {
      test: {
        options: {
          keepalive: true,
          open: true,
          port: 8088
        }
      }
    },

    phplint: {
      cores: [
        'application/core/*.php',
        'application/controllers/*.php',
        'application/controllers/admin/*.php',
        'application/helpers/*.php',
        'application/helpers/baka_pack/*.php',
        'application/libraries/*.php',
        'application/libraries/baka_pack/*.php',
        'application/libraries/Archive/**/*.php',
        'application/libraries/Authr/**/*.php',
      ],
      products: [
        'application/controllers/data/*.php',
        'application/libraries/Bpmppt/*.php',
        'application/libraries/Bpmppt/**/*.php',
        'application/views/*.php',
        'application/views/**/*.php',
        'application/views/**/**/*.php',
      ]
    },

    phpunit: {
      options: {
        bootstrap: '<%= phpunit.base.dir %>/bootstrap.php',
        colors: true,
        stopOnError: false,
        stopOnFailure: false,
        stopOnSkipped: false,
        stopOnIncomplete: false,
        // strict: true,
        verbose: true,
        convertErrorsToExceptions: true,
        convertNoticesToExceptions: true,
        convertWarningsToExceptions: true
      },
      base: {
        dir: './tests'
      }
    },

    less: {
      options: {
        strictMath: true,
        outputSourceFiles: true
      },
      core: {
        files: {
          "asset/css/style.css": "asset/less/style.less",
          "asset/css/print.css": "asset/less/print.less"
        }
      }
    },

    autoprefixer: {
      options: {
        browsers: ['last 2 versions', 'ie 8', 'ie 9', 'android 2.3', 'android 4', 'opera 12'],
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
      core: {
        expand: true,
        cwd: 'asset/css/',
        dest: 'asset/css/',
        src: [
          '*.css',
          '!*.min.css'
        ]
      }
    },

    csslint: {
      options: grunt.file.readJSON('asset/less/.csslintrc'),
      core: [
        'asset/css/*.css',
        '!asset/css/*.min.css',
        '!asset/css/install.css'
      ]
    },

    cssmin: {
      core: {
        expand: true,
        report: 'gzip',
        cwd: 'asset/css/',
        src: ['style.css', 'print.css'],
        dest: 'asset/css/',
        ext: '.min.css'
      }
    },

    watch: {
      options: {
        nospawn: true
      },
      less: {
        files: [
          'asset/less/**/*.less',
          'asset/less/*.less'
        ],
        tasks: [
          'less',
          'autoprefixer',
          'csscomb',
          'csslint'
        ]
      },
      phpTest: {
        files: [
          'tests/**/*Test.php',
          'tests/*Test.php'
        ],
        tasks: 'phpunit'
      },
      phpCore: {
        files: [
          'application/**/**/*.php',
          'application/**/*.php',
          'application/*.php'
        ],
        tasks: 'phplint'
      }
    }

  });

  require('load-grunt-tasks')(grunt, {scope: 'devDependencies'});
  require('time-grunt')(grunt);

  // Test task.
  var testSubtasks = [];
  // Skip core tests if running a different subset of the test suite
  if (!process.env.BAKA_TEST || process.env.BAKA_TEST === 'php') {
    testSubtasks = testSubtasks.concat(['phptest']);
  }
  // Skip HTML validation if running a different subset of the test suite
  else if (!process.env.BAKA_TEST || process.env.BAKA_TEST === 'css') {
    testSubtasks = testSubtasks.concat(['csstest']);
  }
  else if (typeof process.env.BAKA_TEST !== 'undefined') {
    testSubtasks = testSubtasks.concat(['csstest', 'phptest']);
  }

  // grunt.registerTask('watch', ['watch']);
  grunt.registerTask('testdist', ['csstest', 'phptest']);

  grunt.registerTask('phptest', ['phplint', 'phpunit']);
  grunt.registerTask('csstest', ['less', 'autoprefixer', 'csscomb', 'csslint', 'cssmin']);
  // grunt.registerTask('csstest', ['less:compileStyle', 'csslint']);
  // grunt.registerTask('lint', ['csslint']);
  // grunt.registerTask('build', ['less', 'cssmin']);
  grunt.registerTask('default', ['php']);
}
