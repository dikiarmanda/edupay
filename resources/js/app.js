import "./bootstrap";

// Import Flatpickr
import flatpickr from "flatpickr";
import "flatpickr/dist/flatpickr.min.css";
import { Indonesian } from "flatpickr/dist/l10n/id.js";
import { initializeFlatpickr } from "./flatpickr-config.js";

// Import custom Flatpickr styles
import "../css/flatpickr-custom.css";

// Import Select2
import $ from "jquery";
import "select2";
import "select2/dist/css/select2.min.css";

// Import custom Select2 styles
import "../css/select2-custom.css";

import { createIcons, icons } from "lucide";

document.addEventListener("DOMContentLoaded", () => {
    createIcons({ icons });
});

// Make flatpickr available globally
window.flatpickr = flatpickr;
window.flatpickr.l10ns.id = Indonesian;
window.initializeFlatpickr = initializeFlatpickr;

// Make jQuery and Select2 available globally
window.$ = window.jQuery = $;
