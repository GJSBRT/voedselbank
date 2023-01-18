const defaultTheme = require('tailwindcss/defaultTheme');

/** @type {import('tailwindcss').Config} */
module.exports = {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './vendor/laravel/jetstream/**/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './resources/js/**/*.vue',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Nunito', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                'primary': {
                    900: '#f6701b',
                    800: '#f6701bee',
                    700: '#f6701bcc',
                    600: '#f6701baa',
                    500: '#f6701b88',
                    400: '#f6701b77',
                    300: '#f6701b66',
                    200: '#f6701b55',
                    100: '#f6701b44',
                    50: '#f6701b33',
                }
            },
        },
    },

    plugins: [require('@tailwindcss/forms'), require('@tailwindcss/typography')],
};
