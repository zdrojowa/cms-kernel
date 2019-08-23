const mix = require('laravel-mix');
const fs = require('fs');

class Module {
    async register(module, vendor) {
        const assets = new Map([
            ['js', `./resources/js/vendor/${module}/${module}.js`],
            ['css', `./resources/sass/vendor/${module}/${module}.scss`],
            ['img', `./resources/assets/vendor/${module}/`],
        ]);

        const vendorAssets = new Map([
            ['js', `${vendor}/resources/assets/js/${module}.js`],
            ['css', `${vendor}/resources/assets/sass/${module}.scss`],
            ['img', `${vendor}/resources/assets/img`],
        ]);

        assets.forEach((val, key) => {
            let file = val;
            console.log(key);
            if (!fs.existsSync(val)) {
                if (!fs.existsSync(vendorAssets.get(key))) console.log(key + ' missing');

                file = vendorAssets.get(key);
            }


            switch (key) {
                case 'js':
                    mix.js(file, `public/vendor/js/`);
                    break;
                case 'css':
                    mix.sass(file, 'public/vendor/css/');
                    break;
                case 'img':
                    mix.copy(file, `public/vendor/img/${module}`);
                    break;
            }

        });
    }
}

mix.extend('module', new Module());
