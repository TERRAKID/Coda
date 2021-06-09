const defaultTheme = require('tailwindcss/defaultTheme');
const colors = require('tailwindcss/colors');

module.exports = {
    purge: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './vendor/laravel/jetstream/**/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './resources/js/**/*.vue',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Raleway', ...defaultTheme.fontFamily.sans],
                serif: ['Merriweather', ...defaultTheme.fontFamily.serif],
                detail: ['Domine', ...defaultTheme.fontFamily.serif],
            },
            colors: {
                blue: {
                    primary: '#3766AF',
                    secondary: '#5779BB',
                },
                purple: '#7C217E',
                purpleDark: '#53207c',
                green: '#3BBAC0',
                greenDark: '#3b7fbf',
                black: '#212125',
                white: '#fefdfb',
            },
            backgroundImage: theme => ({
                'hero-auth': "url('/img/hero-auth.png')",
            }),
            gridTemplateColumns: {
                'main': '20% 80%',
            },
            maxWidth: {
                '1/4': '25%',
                '1/2': '50%',
                '3/4': '75%',
                'full': '100%',
            },
            borderRadius: {
                'large': '50px',
            },
        },
    },

    variants: {
        extend: {
            opacity: ['disabled'],
            ringWidth: ['active'],
            ringColor: ['active'],
        },
    },

    plugins: [require('@tailwindcss/forms'), require('@tailwindcss/typography')],
};
