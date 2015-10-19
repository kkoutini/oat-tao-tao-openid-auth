module.exports = function(grunt) { 

    var sass    = grunt.config('sass') || {};
    var watch   = grunt.config('watch') || {};
    var notify  = grunt.config('notify') || {};
    var root    = grunt.option('root') + '/taoOpenIDAuth/views/';

    sass.taoqb = { };
    sass.taoqb.files = { };
    sass.taoqb.files[root + 'css/admin.css'] = root + 'scss/admin.scss';

    watch.taoqbsass = {
        files : [root + 'views/scss/**/*.scss'],
        tasks : ['sass:taoqb', 'notify:taoqbsass'],
        options : {
            debounceDelay : 1000
        }
    };

    notify.taoqbsass = {
        options: {
            title: 'Grunt SASS', 
            message: 'SASS files compiled to CSS'
        }
    };

    grunt.config('sass', sass);
    grunt.config('watch', watch);
    grunt.config('notify', notify);

    //register an alias for main build
    grunt.registerTask('taoqbsass', ['sass:taoqb']);
};
