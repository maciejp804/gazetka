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
                '26': '6.5rem',
                '36': '9rem',
                '37': '9.25rem',
                '37.5': '9.375rem',
                '68': '17rem',
                '70': '17.5rem',
                '71': '17.75rem',
                '72': '18rem',
                '81.5' : '20.375rem',
                '85.5' : '21.375rem',
                '98' : '24.5rem',
                '99' : '24.75rem',
                '100' : '25rem',
                '101'   : '25.25rem',
                '102.5' : '25.625rem',
                '112' : '28rem',
                '116' : '29rem',
                '120' : '30rem',
                '124' : '31rem',
                '126' : '31.5rem',
                '128' : '32rem',
                '132' : '33rem',
                '135' : '33.75rem',
                '136' : '34rem',
                '140' : '35rem',
                '144' : '36rem',
                '148' : '37rem',
                '152' : '38rem',
                '153' : '38.25rem',
                '154' : '38.5rem',
                '156' : '39rem',
                '160' : '40rem', /* prawidłowa*/
                '164' : '41rem',
                '165' : '41.25rem',
                '166' : '41.5rem',
                '168' : '42rem',
                '172' : '43rem',
                '173' : '43.25rem',
                '173.5' : '43.375rem',
                '174.5' : '43.628rem',
                '176' : '44rem',
                '180' : '45rem',
                '184' : '46rem',
                '186' : '46.5rem',
                '193.5' : '48,375rem',

            },
            screens: {
                '3xs' : '320px',
                '2xs' : '375px',
                '1xs' : '425px',
                'xs'  : '475px',
                '2lg' : '1152px',
                "1xl" : '1440px',
                "3xl" : '1545px'
            }
        },
    },
    plugins: [
        forms,
        scrollbar, // Dodaj plugin scrollbar
    ]
};
