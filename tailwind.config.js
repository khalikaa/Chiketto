import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
                mini: ['mini-convenie', 'sans-serif'],
            },
            colors: {
                'dark-blue' : '#091732',
                'blue-0' : '#15316b',
                'blue-1' : '#0c2353',
                'blue-2' : '#475779',
                'blue-3' : '#6a7b9f',
                'blue-4' : '#91a4c5',
                'blue-5' : '#bbcae2',
                'blue-6' : '#e0ecff', 
                'blue-w' : '#f1f7ff',
                'grey-1' : '#e4e6e9',
                'grey-2' : '#d0d1d5',
                'blue-grey' : '#959eaf'
            },
            aspectRatio: {
                'custom': '724/340',
            }
        },
    },

    plugins: [forms],
};
