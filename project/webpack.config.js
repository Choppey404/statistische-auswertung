var Encore = require('@symfony/webpack-encore');
var dotenv = require('dotenv');

Encore
    // the project directory where compiled assets will be stored
    .setOutputPath('public/build/')

    // the public path used by the web server to access the previous directory
    .setPublicPath('/build')

    .cleanupOutputBeforeBuild()

    .enableSourceMaps(!Encore.isProduction())

    .copyFiles({
        from: './assets/img',
        to: 'images/[path][name].[hash:8].[ext]'
    })


    // uncomment to create hashed filenames (e.g. app.abc123.css)
    .enableVersioning(Encore.isProduction())

    .addEntry('app', './assets/js/app.js')

    // uncomment if you use Sass/SCSS files
    .enableSassLoader(() => {
        const envs = dotenv.config({path: './.env.local'}).parsed;
        const imagePath = Encore.isProduction() ? `../img/${envs['DEPLOY_ENVIRONMENT']}/logo.png` : `../../img/${envs['DEPLOY_ENVIRONMENT']}/logo.png`

        return {
            additionalData: '$logo_url: "' + imagePath + '";',
        }
    })

    // uncomment for legacy applications that require $/jQuery as a global variable
    .autoProvidejQuery()
;

module.exports = Encore.getWebpackConfig();
