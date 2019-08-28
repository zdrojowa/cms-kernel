const mix = require('laravel-mix');
const fs = require('fs');

class Selene {
    name() {
        return ['selene', 'seleneModule', 'module'];
    }

    seleneConfig() {
        return 'selene.json';
    }

    register(vendor) {
        vendor = this.repairSlash(vendor);

        if(!fs.existsSync(vendor)) return;
        if(!fs.existsSync(vendor + this.seleneConfig())) return;

        const selene = JSON.parse(fs.readFileSync(vendor + this.seleneConfig(), 'utf8'));

        selene.assets.forEach((asset) => {
            asset = this.prepareAsset(selene.module, vendor, asset);

            let path;

            if(fs.existsSync(asset.publishedPath)) {
                path = asset.publishedPath;
            }
            else {
                if(fs.existsSync(asset.vendorPath)) {
                    path = asset.vendorPath;
                }
            }

            if(path) {
                mix[asset.type](path, asset.publicPath);
            }
        })
    }

    prepareAsset(module, vendor, asset) {
        switch (asset.type) {
            case "js":
            case "sass":
                asset.path = this.repairSlash(asset.path, true);
                asset.extension = `.${asset.type}`;
                asset.publishedPath = `./resources/${asset.type}/vendor/${module}/${asset.name}${asset.extension}`;
                asset.vendorPath = `${vendor}${asset.path}`;
                asset.publicPath = `./public/selene/${module}/${asset.type}/${asset.name}${asset.extension}`;
                break;
            default:
                asset.publishedPath = `./resources/assets/vendor/${module}/${asset.type}/${asset.name}/`;
                asset.vendorPath = `${vendor}${asset.path}`;
                asset.publicPath = `./public/selene/${module}/assets/${asset.name}`;
                break;
        }

        return asset;
    }

    checkStructure(asset) {
        return !!(asset.name && asset.path && asset.type);
    }

    repairSlash(path, file = false, vendor ) {
        if(path[0] === '/') path = path.substr(1);
        if(path[0] + path[1] !== './') path = './' + path;

        if(!file) {
            if (path[path.length - 1] !== '/') path = path + '/';
        }

        return path;
    }
}

mix.extend('selene', new Selene());
