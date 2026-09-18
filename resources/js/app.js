/**
 * App.js — Local bundle for all JS dependencies.
 * No CDN needed — everything is bundled via Vite.
 */

import Chart from 'chart.js/auto';
window.Chart = Chart;

import Swal from 'sweetalert2';
window.Swal = Swal;

import AOS from 'aos';
import 'aos/dist/aos.css';
window.AOS = AOS;

import 'trix/dist/trix.css';
import 'trix';

import Cropper from 'cropperjs';
import 'cropperjs/dist/cropper.css';
window.Cropper = Cropper;
