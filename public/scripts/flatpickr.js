document.addEventListener("DOMContentLoaded", function() {
    flatpickr("#date", {
        dateFormat: "d/m/Y", // Format tampilan: Hari/Bulan/Tahun
    });
    flatpickr("#timePicker", {
        enableTime: true,
        noCalendar: true, // Ini akan menghilangkan kalender dan hanya menampilkan pemilih waktu
        dateFormat: "H:i", // Format jam dan menit (24 jam). Anda bisa ubah ke "h:i K" untuk 12 jam.
        time_24hr: true // Ubah ke false jika ingin format 12 jam
    });
});


