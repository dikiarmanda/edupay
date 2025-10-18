/** @type {import('tailwindcss').Config} */
export default {
    content: [
        "./resources/**/*.blade.php",
        "./resources/**/*.js",
        "./resources/**/*.vue",
        "./app/**/*.php",
    ],
    theme: {
        extend: {
            colors: {
                primary: {
                    50: "#f3f0ff",
                    100: "#e9e5ff",
                    200: "#d6ceff",
                    300: "#b8a6ff",
                    400: "#9575ff",
                    500: "#7c3aed",
                    600: "#6d28d9",
                    700: "#5b21b6",
                    800: "#4c1d95",
                    900: "#3b0764",
                    950: "#2e1065",
                },
            },
            fontFamily: {
                sans: ["Inter", "ui-sans-serif", "system-ui", "sans-serif"],
            },
        },
    },
    plugins: [],
};
