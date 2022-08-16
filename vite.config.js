import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel([
            'resources/assets/custom-theme/dark.scss',
            'resources/assets/custom-theme/sidemenu.scss',
            'resources/assets/custom-theme/skin-modes.scss',
            'resources/assets/scss/style.scss',
            'resources/assets/updatestyle/updatestyles.scss',
            'resources/assets/js/custom.js',
            'resources/assets/js/form-browser.js',
            'resources/assets/js/jquery.showmore.js',
            'resources/assets/js/select2.js',
            'resources/assets/js/support/support-admindash.js',
            'resources/assets/js/support/support-articles.js',
            'resources/assets/js/support/support-createticket.js',
            'resources/assets/js/support/support-customer.js',
            'resources/assets/js/support/support-landing.js',
            'resources/assets/js/support/support-sidemenu.js',
            'resources/assets/js/support/support-ticketview.js',
        ]),
    ],
});
