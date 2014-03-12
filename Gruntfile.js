module.exports = function(grunt) {
  // 'use strict';

  grunt.loadNpmTasks('grunt-php');
  grunt.loadNpmTasks('grunt-contrib-less');
  grunt.loadNpmTasks('grunt-contrib-watch');

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
        tasks: 'less',
        options: {
          nospawn: true
        }
      }
    },
  });

  grunt.registerTask('watch', ['less', 'watch']);
  grunt.registerTask('default', ['php']);
}
