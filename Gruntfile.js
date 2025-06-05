module.exports = function( grunt ) {
    const pluginSlug = 'coming-soon-mode-by-spectra';
    const pkg = grunt.file.readJSON( 'package.json' );
    const zipName = pluginSlug + '-' + pkg.version + '.zip';

    grunt.initConfig({
        clean: {
            pre: [ 'release/', zipName ],
            post: [ 'release/' ]
        },
        copy: {
            release: {
                expand: true,
                src: [
                    '**',
                    '!node_modules/**',
                    '!src/**',
                    '!assets/js/**',
                    '!package.json',
                    '!package-lock.json',
                    '!Gruntfile.js',
                    '!webpack.config.js',
                    '!.gitignore',
                    '!**/*.md',
                ],
                dest: 'release/' + pluginSlug + '/',
            },
        },
        compress: {
            main: {
                options: {
                    archive: zipName,
                    mode: 'zip'
                },
                expand: true,
                cwd: 'release/',
                src: [ pluginSlug + '/**' ],
                dest: pluginSlug
            }
        }
    });

    grunt.loadNpmTasks('grunt-contrib-clean');
    grunt.loadNpmTasks('grunt-contrib-copy');
    grunt.loadNpmTasks('grunt-contrib-compress');

    grunt.registerTask( 'package', [ 'clean:pre', 'copy', 'compress', 'clean:post' ] );
};
