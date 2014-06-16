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
                src: ['src/**/*.php'],
                overwrite: true,
                replacements: [
                    { from: 'class Cuztom',                 to: "class <%= cuztom.prefix %>Cuztom" }, 
                    { from: 'new Cuztom',                   to: "new <%= cuztom.prefix %>Cuztom" }, 
                    { from: 'extends Cuztom',               to: "extends <%= cuztom.prefix %>Cuztom" }, 
                    { from: 'instanceof Cuztom',            to: "instanceof <%= cuztom.prefix %>Cuztom" }, 
                    { from: 'Cuztom::',                     to: "<%= cuztom.prefix %>Cuztom::" }, 
                    { from: 'Cuztom_Field::',               to: "<%= cuztom.prefix %>Cuztom_Field::" }, 
                    { from: "$class = 'Cuztom_Field_'",     to: "$class = '<%= cuztom.prefix %>Cuztom_Field_'" }, 
                    { from: "register_cuztom_post_type",    to: "register_<%= cuztom.prefix.toLowerCase() %>cuztom_post_type" },
                    { from: "register_cuztom_taxonomy",     to: "register_<%= cuztom.prefix.toLowerCase() %>cuztom_taxonomy" }, 
                    { from: "get_cuztom_term_meta",         to: "get_<%= cuztom.prefix.toLowerCase() %>cuztom_term_meta" }, 
                    { from: "the_cuztom_term_meta",         to: "the_<%= cuztom.prefix.toLowerCase() %>cuztom_term_meta" }
                ]                
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