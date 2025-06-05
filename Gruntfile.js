module.exports = function( grunt ) {
    const pluginSlug = 'coming-soon-mode-by-spectra';

    grunt.initConfig({
        clean: {
            release: ['release/']
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
                    archive: pluginSlug + '.zip',
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

    grunt.registerTask('package', ['clean', 'copy', 'compress']);
};
