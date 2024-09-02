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
        container: {
            center: true,
            padding: '1rem',
            screens: {
                DEFAULT: '1024px',
                sm: '640px',
                md: '768px',
            },
        },
        extend: {
            fontFamily: {
                sans: ['Switzer', ...defaultTheme.fontFamily.sans],
                display: ['Instrument Serif', ...defaultTheme.fontFamily.serif],
            },
            colors: {
                'base-headings': 'var(--base-headings)',
                'base-muted': 'var(--base-muted)',
                'base-front': 'var(--base-front)',
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

    daisyui: {
        themes: [
            {
                burning: {
                    primary: '#18181B',
                    secondary: '#3F3F46',
                    accent: '#ff652a',
                    'accent-content': '#ffe6d4',
                    neutral: '#18181B',
                    'base-100': '#FAFAFA',
                    'base-200': '#F4F4F5',
                    'base-300': '#E4E4E7',
                    'base-content': '#3f3f46',
                    '--base-front': '#FFFFFF',
                    '--base-headings': '#18181b',
                    '--base-muted': '#a1a1aa',
                },
            },
        ],
    },

    plugins: [forms, require('daisyui')],
};
