module.exports = function(grunt) { 

    var requirejs   = grunt.config('requirejs') || {};
    var clean       = grunt.config('clean') || {};
    var copy        = grunt.config('copy') || {};

    var root        = grunt.option('root');
    var libs        = grunt.option('mainlibs');
    var ext         = require(root + '/tao/views/build/tasks/helpers/extensions')(grunt, root);
    var out         = 'output';

    /**
     * Remove bundled and bundling files
     */
    clean.taoqbbundle = [out];
    
    /**
     * Compile tao files into a bundle 
     */
    requirejs.taoqbbundle = {
        options: {
            baseUrl : '../js',
            dir : out,
            mainConfigFile : './config/requirejs.build.js',
            paths : { 'taoOpenIDAuth' : root + '/taoOpenIDAuth/views/js' },
            modules : [{
                name: 'taoOpenIDAuth/controller/routes',
                include : ext.getExtensionsControllers(['taoOpenIDAuth']),
                exclude : ['mathJax', 'mediaElement'].concat(libs)
            }]
        }
    };

    /**
     * copy the bundles to the right place
     */
    copy.taoqbbundle = {
        files: [
            { src: [out + '/taoOpenIDAuth/controller/routes.js'],  dest: root + '/taoOpenIDAuth/views/js/controllers.min.js' },
            { src: [out + '/taoOpenIDAuth/controller/routes.js.map'],  dest: root + '/taoOpenIDAuth/views/js/controllers.min.js.map' }
        ]
    };

    grunt.config('clean', clean);
    grunt.config('requirejs', requirejs);
    grunt.config('copy', copy);

    // bundle task
    grunt.registerTask('taoqbbundle', ['clean:taoqbbundle', 'requirejs:taoqbbundle', 'copy:taoqbbundle']);
};
