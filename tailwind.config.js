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
                poppins : ['Poppins', ...defaultTheme.fontFamily.sans],
                lidlSemibold : ['Lidl Font Cond Pro Semibold',...defaultTheme.fontFamily.sans],
                lidl : ['Lidl Font Cond Pro',...defaultTheme.fontFamily.sans],
            },
            width : {
                '116' : '29rem',
            },
            height : {
                '136' : '38rem',
                '135' : '37.5rem'
            }
        },
    },

    plugins: [forms],
};
