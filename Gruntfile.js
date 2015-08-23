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
                    { from: "class_exists( 'Cuztom' )",     to: "class_exists( '<%= cuztom.prefix %>Cuztom' )" },
                    { from: "register_cuztom_post_type",    to: "register_<%= cuztom.prefix.toLowerCase() %>cuztom_post_type" },
                    { from: "register_cuztom_taxonomy",     to: "register_<%= cuztom.prefix.toLowerCase() %>cuztom_taxonomy" },
                    { from: "get_cuztom_term_meta",         to: "get_<%= cuztom.prefix.toLowerCase() %>cuztom_term_meta" },
                    { from: "the_cuztom_term_meta",         to: "the_<%= cuztom.prefix.toLowerCase() %>cuztom_term_meta" }
                ]
            }
        },
        less: {
            dev: {
                options: {
                    compress: true,
                    yuicompress: true,
                    optimization: 2
                },
                files: { "src/assets/dist/css/cuztom.min.css": "src/assets/less/cuztom.less" }
            }
        },
        concat: {
            dev: {
                src: [
                    'src/assets/vendor/angular/angular.min.js',
                    'src/assets/js/cuztom.js',
                    'src/assets/js/cuztom-ui.js',
                    'src/assets/js/cuztom-sortable.js',
                    'src/assets/js/cuztom-image.js',
                    'src/assets/js/cuztom-ajax.js'
                ],
                dest: 'src/assets/dist/js/cuztom.min.js',
            }
        },
        watch: {
            less: {
                files: ['src/assets/less/**.less'],
                tasks: ['less:dev'],
            },
            scripts: {
                files: ['src/assets/js/**.js'],
                tasks: ['concat:dev'],
            }
        }
    };

    // Set config
    grunt.initConfig(config);

    // Plugins
    require('load-grunt-tasks')(grunt);

    // Default
    grunt.registerTask( 'default', [] );
    grunt.registerTask( 'dev', ['watch'] );
    grunt.registerTask( 'dist', ['less:dev', 'concat:dev'] );
    grunt.registerTask( 'prefix', ['prompt:prefix', 'replace:prefix'] );

};