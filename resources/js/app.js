import "./bootstrap";

// Import Flatpickr
import flatpickr from "flatpickr";
import "flatpickr/dist/flatpickr.min.css";
import { Indonesian } from "flatpickr/dist/l10n/id.js";
import { initializeFlatpickr } from "./flatpickr-config.js";

// Import custom Flatpickr styles
import "../css/flatpickr-custom.css";

// Make flatpickr available globally
window.flatpickr = flatpickr;
window.flatpickr.l10ns.id = Indonesian;
window.initializeFlatpickr = initializeFlatpickr;
