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
                green: '#3BBAC0',
                black: '#212125',
                white: '#fefdfb',
            },
            backgroundImage: theme => ({
                'hero-auth': "url('/img/hero-auth.png')",
            }),
            gridTemplateColumns: {
                'main': '20% 80%',
                'user': 'auto 1fr 1fr',
                'dm': '33.333333% 1fr',
            },
            gridTemplateRows: {
                'dm': '1fr auto',
            },
            height: {
                dm: 'calc(100vh - 84px)',
                dmmd: 'calc(100vh - 84px - 64px - 80px)'
            },
            width: {
                dm: '200vw',
            }
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
