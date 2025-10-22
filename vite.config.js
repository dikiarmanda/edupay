import { defineConfig } from "vite";
import laravel from "laravel-vite-plugin";
import tailwindcss from "@tailwindcss/vite";

export default defineConfig({
    plugins: [
        laravel({
            input: ["resources/css/app.css", "resources/js/app.js"],
            refresh: true,
        }),
        tailwindcss(),
    ],
    build: {
        rollupOptions: {
            external: [],
            output: {
                globals: {
                    jquery: "$",
                    select2: "Select2",
                },
            },
        },
    },
    define: {
        global: "globalThis",
    },
});
