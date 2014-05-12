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
      ],
      controllers: [
        'application/controllers/*.php', 
        'application/controllers/admin/*.php', 
        'application/controllers/data/*.php', 
      ],
      helpers: [
        'application/helpers/*.php', 
        'application/helpers/baka_pack/*.php', 
      ],
      libraries: [
        'application/libraries/*.php', 
        'application/libraries/baka_pack/*.php', 
        'application/libraries/Archive/*.php', 
        'application/libraries/Authr/*.php', 
        'application/libraries/Bpmppt/*.php', 
      ],
      models: [
        'application/models/*.php', 
        'application/models/baka_pack/*.php', 
      ],
      views: [
        'application/views/*.php', 
        'application/views/email/*.php', 
        'application/views/pages/*.php', 
        'application/views/prints/*.php', 
      ]
    },

    phpunit: {
      options: {
        configuration: 'phpunit.xml'
        // bootstrap: '<%= phpunit.base.dir %>/bootstrap.php',
        // colors: true,
        // testdox: true,
        // stopOnError: false,
        // stopOnFailure: false,
        // stopOnSkipped: false,
        // stopOnIncomplete: false,
        // strict: true,
        // verbose: true,
        // debug: true,
        // convertErrorsToExceptions: true,
        // convertNoticesToExceptions: true,
        // convertWarningsToExceptions: true
      },
      base: {
        dir: './tests/'
      }
    },

    less: {
      core: {
        options: {
          strictMath: true,
          sourceMap: true,
          outputSourceFiles: true,
          sourceMapURL: 'style.css.map',
          sourceMapFilename: 'asset/css/style.css.map'
        },
        files: {
          "asset/css/style.css": "asset/less/style.less"
        }
      }
    },

    autoprefixer: {
      options: {
        browsers: ['last 2 versions', 'ie 8', 'ie 9', 'android 2.3', 'android 4', 'opera 12']
      },
      core: {
        options: {
          map: true
        },
        src: 'asset/css/style.css',
        dest: 'asset/css/style.css'
      }
    },

    csscomb: {
      options: {
        config: 'asset/less/.csscomb.json'
      },
      core: {
        expand: true,
        cwd: 'asset/css/',
        src: [
          '*.css',
          '!*.min.css'
        ],
        dest: 'asset/css/'
      },
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
        cwd: 'asset/css/',
        src: ['style.css', 'print.css'],
        dest: 'asset/css/',
        ext: '.min.css'
      }
    },

    watch: {
      less:{
        files: 'asset/less/lib/*.less',
        tasks: 'build',
        options: {
          nospawn: true
        }
      }
    }

  });

  require('load-grunt-tasks')(grunt, {scope: 'devDependencies'});
  require('time-grunt')(grunt);

  // Test task.
  var testSubtasks = [];
  // Skip core tests if running a different subset of the test suite
  if (!process.env.BAKA_TEST || process.env.BAKA_TEST === 'php') {
    testSubtasks.push('phptest');
  }
  // Skip HTML validation if running a different subset of the test suite
  else if (!process.env.BAKA_TEST || process.env.BAKA_TEST === 'css') {
    testSubtasks.push('csstest');
  }
  else if (typeof process.env.BAKA_TEST !== 'undefined') {
    testSubtasks.push(['csstest', 'phptest']);
  }

  // grunt.registerTask('watch', ['watch']);
  grunt.registerTask('test', testSubtasks);

  grunt.registerTask('phptest', ['phplint', 'phpunit']);
  grunt.registerTask('csstest', ['less', 'autoprefixer', 'csscomb', 'csslint', 'cssmin']);
  // grunt.registerTask('csstest', ['less:compileStyle', 'csslint']);
  // grunt.registerTask('lint', ['csslint']);
  // grunt.registerTask('build', ['less', 'cssmin']);
  grunt.registerTask('default', ['php']);
}
