document.getElementById('back-button').addEventListener('click', function () {
    const referrer = document.referrer;

    if (referrer && !referrer.includes(window.location.hostname)) {
        // Jika referrer berasal dari domain lain, atau kosong
        window.location.href = '/fallback-url'; // Ganti dengan URL fallback
    } else if (referrer) {
        // Jika ada referrer dan berasal dari domain kita
        window.location.href = referrer;
    } else {
        // Jika tidak ada referrer sama sekali
        window.location.href = '/fallback-url'; // Ganti dengan URL fallback
    }
});
