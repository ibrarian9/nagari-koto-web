{{-- Font Loading API: add .fonts-loaded class when Material Symbols is ready --}}
<script>
if (document.fonts && document.fonts.ready) {
    document.fonts.ready.then(function() {
        document.documentElement.classList.add('fonts-loaded');
    });
} else {
    // Fallback: show icons after a short delay for older browsers
    setTimeout(function() {
        document.documentElement.classList.add('fonts-loaded');
    }, 800);
}
</script>
