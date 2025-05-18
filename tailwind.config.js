import defaultTheme from 'tailwindcss/defaultTheme';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/**/*.blade.php',
        './resources/**/*.js',
        './resources/**/*.vue',
    ],
    theme: {
        extend: {
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
                orelega: ['"Orelega One"', 'cursive'], // добавили под псевдонимом orelega
                nunito: ['"Nunito"', 'bold'],
            },
            colors: {
                normal: '#7e4620',   
                action: '#a4532c',    // кнопки
                actionHover: '#873b1c',
                borderGold: '#c49a6c', // рамки и элементы интерфейса
                comment: '#F6F1E0'
            },
        },
    },
    plugins: [],
};
