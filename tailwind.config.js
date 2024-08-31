import forms from '@tailwindcss/forms';
import defaultTheme from 'tailwindcss/defaultTheme';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './vendor/robsontenorio/mary/src/View/Components/**/*.php',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Switzer', ...defaultTheme.fontFamily.sans],
                display: ['Instrument Serif', ...defaultTheme.fontFamily.serif],
            },
            colors: {
                'burning-orange': {
                    50: '#fff4ed',
                    100: '#ffe6d4',
                    200: '#ffc8a8',
                    300: '#ffa171',
                    400: '#ff652a',
                    500: '#fe4911',
                    600: '#ef2f07',
                    700: '#c61e08',
                    800: '#9d1a0f',
                    900: '#7e1910',
                    950: '#440806',
                },
                'deep-green': {
                    50: '#f5f6f3',
                    100: '#e8eae1',
                    200: '#cfd5c5',
                    300: '#adb89d',
                    400: '#8a9977',
                    500: '#657752',
                    600: '#4d5e3d',
                    700: '#3d4b31',
                    800: '#323c29',
                    900: '#293222',
                    950: '#171c12',
                },
            },
        },
    },

    plugins: [forms, require('daisyui')],
};
