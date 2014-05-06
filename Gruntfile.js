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
    csslint: {
      options: {
        csslintrc: '.csslintrc'
      },
      src: ['asset/css/style.css']
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
    },
  });

  grunt.loadNpmTasks('grunt-php');
  grunt.loadNpmTasks('grunt-contrib-less');
  grunt.loadNpmTasks('grunt-contrib-watch');
  grunt.loadNpmTasks('grunt-contrib-clean');
  grunt.loadNpmTasks('grunt-contrib-csslint');
  grunt.loadNpmTasks('grunt-contrib-cssmin');

  // grunt.registerTask('watch', ['watch']);
  grunt.registerTask('lint', ['csslint']);
  grunt.registerTask('build', ['less', 'cssmin']);
  grunt.registerTask('default', ['php']);
}
