import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';
import scrollbar from 'tailwind-scrollbar';

/** @type {import('tailwindcss').Config} */



export default {

    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],
    safelist: [
        'text-white',
        'rounded-t-3xl',
        'rounded-b-lg',
        'rounded-3xl',
        'border-t',
        'border-l',
        'border-r',
        'border-gray-200',
        'hidden',
        'flex',
        'text-amber-600',
        'bg-yellow-600',
        'bg-red-500',
        'bg-green-500',
        'bg-blue-500',
        'duration-3000',
    ],


    theme: {
        extend: {
            animation: {
                pulse: 'pulse 1.5s infinite ease-in-out',
            },
            transitionDuration: {
                '2000': '2000ms',
                '3000': '3000ms',
            },
            keyframes: {
                pulse: {
                    '0%, 100%': { transform: 'scale(1)', opacity: '1' },
                    '50%': { transform: 'scale(1.1)', opacity: '0.7' },
                },
            },
            colors : {
                'white-50' : '#F7F7F7',
                'blue-550' : '#007ABB',
            },
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
                poppins : ['Poppins', ...defaultTheme.fontFamily.sans],
                lidlSemibold : ['Lidl Font Cond Pro Semibold',...defaultTheme.fontFamily.sans],
                lidl : ['Lidl Font Cond Pro',...defaultTheme.fontFamily.sans],
                ubuntu : ['Ubuntu', ...defaultTheme.fontFamily.sans],
            },
            borderWidth: {
                '1': '0.0625rem'
            }
            ,
            fontSize: {
                '1xs' : '0.625rem',
                '1xl' : '1.375rem',
                'extreme' : ['4rem', '3rem']
            },
            width : {
                '0.5' : '0.125rem',
                '2.5' : '0.75rem',
                '11.25' : '2.813rem',
                '18' : '4.5rem',
                '19' : '4.75rem',
                '29' : '7.25rem',
                '30' : '7.5rem',
                '34' : '8.5rem',
                '42' : '10.5rem',
                '44' : '11rem',
                '46' : '11.5rem',
                '50' : '12.5rem',
                '58' : '13.5rem',
                '75'  : '300px',
                '79.5' : '318px',
                '102.5' : '25.625rem',
                '110.75': '27.6875rem',
                '112' : '28rem', /* 448px */
                '116' : '29rem', /* 464px */
                '152' : '38rem', /* 608px */
                '184' : '46rem',
                '224' : '56rem', /* 896px */
                '238' : '59.5rem',
                '257' : '64.25rem', /* 1028px*/
                '265' : '66.25rem', /* 1060px */
                '280' : '70rem', /* 1120px */
                '288' : '72rem', /* 1152px */
                '312' : '78rem', /* 1248px */
                '320' : '80rem', /* 1280px */
                '356' : '89rem'  /* 1424px */

            },
            minWidth: {
                '265' : '66.25rem', /* 1060px */
                '280' : '70rem', /* 1120px */
            },
            maxWidth: {
                '8xl': '88.75rem', /* 1420px */
            },
            height : {
                '0.5' : '2px',
                '10.5' : '2.625rem',
                '11.25' : '45px',
                '81.5' : '20.375rem',
                '85.5' : '21.375rem',
                '98' : '24.5rem',
                '99' : '24.75rem',
                '100' : '25rem',
                '101'   : '25.25rem',
                '102.5' : '25.625rem',
                '135' : '37.5rem',
                '136' : '38rem',
                '140' : '40rem',
                '179.25' : '44,8125rem',
                '184' : '46rem'

            },
            screens: {
                '3xs' : '320px',
                '2xs' : '375px',
                '1xs' : '425px',
                'xs'  : '475px',
                '2lg' : '1152px',
                "1xl" : '1440px'
            }
        },
    },
    plugins: [
        forms,
        scrollbar, // Dodaj plugin scrollbar
    ]
};
