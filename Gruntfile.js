module.exports = function(grunt) {

    // Config
    var config = {  
        pkg: grunt.file.readJSON('package.json'),
        prompt: {
            prefix: {
                options: {
                    questions: [
                        {
                            config: 'cuztom.prefix',
                            type: 'input',
                            message: 'PREFIX:',
                            default: 'Prefix_'
                        }
                    ]
                }
            }
        },
        replace: {
            prefix: {
                src: ['src/*.php'],
                overwrite: true,
                replacements: [{
                    from: 'class Cuztom',
                    to: "class <%= cuztom.prefix %>Cuztom"
                }, {
                    from: 'Cuztom::',
                    to: "<%= cuztom.prefix %>Cuztom::"
                }]
            }
        }
    };

    // Set config
    grunt.initConfig(config);

    // Plugins
    require('load-grunt-tasks')(grunt);

    // Default
    grunt.registerTask( 'default', [] );
    grunt.registerTask( 'prefix', ['prompt:prefix', 'replace:prefix'] );

};