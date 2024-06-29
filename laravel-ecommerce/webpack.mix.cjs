let mix = require('laravel-mix');
let browserSync = require('browser-sync-webpack-plugin');

mix.js('resources/js/app.js', 'public/js')
   .sass('resources/sass/app.scss', 'public/css')
   .webpackConfig({
      plugins: [
         new browserSync({
            proxy: 'your-local-domain.test',
            host: '127.0.0.1', // Force IPv4
            port: 3000, // Change the port number if needed
            files: [
               'app/**/*',
               'resources/views/**/*',
               'routes/**/*',
               'public/js/**/*',
               'public/css/**/*'
            ]
         })
      ]
   });