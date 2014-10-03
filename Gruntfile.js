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
      js: 'asset/js/<%= pkg.name %>*'
    },

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
        '!application/bootigniter/_*.php'
      ]
    },

    phpunit: {
      options: {
        bin: 'application/vendor/bin/phpunit -c application/tests/phpunit.xml'
      },
      dev: {
        dir: 'application/tests'
      }
    },

    less: {
      options: {
        strictMath: true,
        outputSourceFiles: true
      },
      dev: {
        files: {
          "asset/css/<%= pkg.name %>.css": "asset/less/style.less",
          "asset/css/<%= pkg.name %>-print.css": "asset/less/print.less"
        }
      },
      build: {
        options: {
          compress: true,
          cleancss: true,
          sourceMap: true,
          sourceMapRootpath: 'asset/less/',
          report: 'gzip'
        },
        files: {
          "asset/css/<%= pkg.name %>.min.css": "asset/less/style.less",
          "asset/css/<%= pkg.name %>-print.min.css": "asset/less/print.less"
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
        ]
      },
      dev: {
        src: [
          'asset/css/<%= pkg.name %>.min.css',
          'asset/css/<%= pkg.name %>-print.min.css',
          'asset/css/<%= pkg.name %>.css',
          'asset/css/<%= pkg.name %>-print.css'
        ]
      }
    },

    csscomb: {
      options: {
        config: '.csscombrc'
      },
      dev: {
        expand: true,
        cwd: 'asset/css/',
        dest: 'asset/css/',
        src: [ '<%= pkg.name %>.css', '<%= pkg.name %>-print.css' ]
      }
    },

    csslint: {
      dev: {
        options: {
          csslintrc: '.csslintrc'
        },
        src: [ 'asset/css/<%= pkg.name %>.css', 'asset/css/<%= pkg.name %>-print.css' ]
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
      dev: {
        src: 'asset/js/script.js',
        dest: 'asset/js/<%= pkg.name %>.min.js'
      }
    },

    imagemin: {
      options: {
        optimizationLevel: 3,
        progressive: true,
        interlaced: true
      },
      dev: {
        files: [{
          expand: true,
          cwd: 'asset/img/',
          dest: 'asset/img/',
          src: [ '**/*.{png,jpg,gif}' ]
        }]
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


  grunt.registerTask('build', [
    'cssdist',
    'phpdist',
    'imagemin'
  ]);

  grunt.registerTask('phpdist', [
    'phplint',
    'phpunit'
  ]);

  grunt.registerTask('cssdist', [
    'less',
    'autoprefixer',
    'csscomb',
    'csslint'
  ]);

  grunt.registerTask('default', [
    'php:dev',
    'watch'
  ]);
}
