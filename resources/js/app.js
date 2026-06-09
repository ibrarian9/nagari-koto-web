/**
 * App.js — Local bundle for all JS dependencies.
 * No CDN needed — everything is bundled via Vite.
 */

// ─── Chart.js ──────────────────────────────────────
import Chart from 'chart.js/auto';
window.Chart = Chart;

// ─── SweetAlert2 ───────────────────────────────────
import Swal from 'sweetalert2';
window.Swal = Swal;

// ─── AOS (Animate on Scroll) ──────────────────────
import AOS from 'aos';
import 'aos/dist/aos.css';
window.AOS = AOS;

// ─── Trix Editor ───────────────────────────────────
import 'trix/dist/trix.css';
import 'trix';

// ─── Cropper.js ────────────────────────────────────
import Cropper from 'cropperjs';
import 'cropperjs/dist/cropper.css';
window.Cropper = Cropper;
