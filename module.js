const mix = require('laravel-mix');
const fs = require('fs');

class Module {
    async register(module) {
        const moduleCSS = `./resources/sass/vendor/${module}/${module}.scss`;
        const moduleJS = `./resources/js/vendor/${module}/${module}.js`;
        const moduleImages = `./resources/assets/vendor/${module}/`;

        try {
            fs.statSync(moduleCSS);
            mix.sass(moduleCSS, 'public/vendor/css/');
        } catch (e) {
            console.log(`File ${module}.scss is missing`);
        }

        try {
            fs.statSync(moduleJS);
            mix.js(moduleJS, `public/vendor/js/`);
        } catch (e) {
            console.log(`File ${module}.js is missing`);
        }

        try {
            fs.statSync(moduleImages);
            mix.copy(moduleImages, `public/vendor/img/${module}`);
        } catch (e) {
            console.log(`Images directory ${module} is missing`);
        }
    }
}

mix.extend('module', new Module());
