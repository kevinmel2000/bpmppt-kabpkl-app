module.exports = function(grunt) {
  'use strict';

  // Force use of Unix newlines
  grunt.util.linefeed = '\n';

  grunt.initConfig({
    // Metadata.
    pkg: grunt.file.readJSON('package.json'),
    php: {
      dist: {
        options: {
          keepalive: true,
          open: true,
            port: 8088
        }
      }
    },
    less: {
      compileCore: {
        // options: {
        //   strictMath: true,
        //   sourceMap: true,
        //   outputSourceFiles: true,
        //   sourceMapURL: 'style.css.map',
        //   sourceMapFilename: 'asset/css/style.css.map'
        // },
        files: {
          "asset/css/style.css": "asset/less/style.less"
        }
      },
      minify: {
        options: {
          cleancss: true,
          report: 'min'
        },
        files: {
          'asset/css/style.min.css': 'asset/css/style.css',
        }
      }
    },
    watch: {
      less:{
        files: 'asset/less/lib/*.less',
        tasks: 'less'
      }
    },
  });

  grunt.loadNpmTasks('grunt-php');
  grunt.loadNpmTasks('grunt-contrib-less');
  grunt.loadNpmTasks('grunt-contrib-watch');

  // grunt.registerTask('default', ['less', 'watch']);
  grunt.registerTask('default', ['php']);
}