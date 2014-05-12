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
      classes: {
        dir: 'tests/'
      },
      options: {
        bootstrap: './tests/bootstrap.php',
        colors: true,
        testdox: true,
        stopOnError: false,
        stopOnFailure: false,
        stopOnSkipped: false,
        stopOnIncomplete: false,
        strict: true,
        verbose: true,
        debug: true,
        logJson: 'phpunit.log.json'
      } 
    },

    less: {
      compileCore: {
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
        src: 'asset/css/style.css'
      }
    },

    csslint: {
      options: {
        csslintrc: 'asset/less/.csslintrc'
      },
      src: ['asset/css/style.css']
    },

    csscomb: {
      options: {
        config: 'asset/less/.csscomb.json'
      },
      dist: {
        expand: true,
        cwd: 'asset/css/',
        src: ['*.css', '!*.min.css'],
        dest: 'asset/css/'
      },
    },

    cssmin: {
      minify: {
        expand: true,
        cwd: 'asset/css/',
        src: ['style.css'],
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

  // grunt.registerTask('watch', ['watch']);
  grunt.registerTask('phptest', ['phplint', 'phpunit']);
  grunt.registerTask('lint', ['csslint']);
  grunt.registerTask('build', ['less', 'cssmin']);
  grunt.registerTask('default', ['php']);
}
