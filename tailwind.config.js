/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './resources/views/**/*.blade.php',
        './resources/js/**/*.js',
        './app/View/Components/**/*.php',
    ],
    theme: {
        extend: {
            colors: {
                // Brand palette — clinical, trustworthy
                primary: {
                    50:  '#eff8ff',
                    100: '#dbeffe',
                    200: '#bfe3fe',
                    300: '#93d1fd',
                    400: '#60b7fb',
                    500: '#3b9af8',
                    600: '#1e7eec',
                    700: '#1668d9',
                    800: '#1854b0',
                    900: '#1a488b',
                    950: '#142d55',
                },
                accent: {
                    50:  '#f0fdfa',
                    100: '#ccfbf1',
                    500: '#14b8a6',
                    600: '#0d9488',
                    700: '#0f766e',
                },
            },
            fontFamily: {
                sans: ['Inter', 'ui-sans-serif', 'system-ui', 'sans-serif'],
            },
            boxShadow: {
                'card': '0 1px 3px 0 rgb(0 0 0 / 0.07), 0 1px 2px -1px rgb(0 0 0 / 0.07)',
                'card-hover': '0 4px 6px -1px rgb(0 0 0 / 0.07), 0 2px 4px -2px rgb(0 0 0 / 0.07)',
            },
            borderRadius: {
                'xl': '0.875rem',
                '2xl': '1.25rem',
            },
        },
    },
    plugins: [
        require('@tailwindcss/forms'),
        require('@tailwindcss/typography'),
    ],
}
