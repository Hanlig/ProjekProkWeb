document.getElementById("jobApplicationForm").addEventListener("submit", function(event) {
    event.preventDefault(); // Mencegah reload halaman
    
    // Tampilkan pesan sukses
    document.getElementById("successMessage").style.display = "block";

    // Reset formulir setelah pengiriman
    this.reset();

    // Sembunyikan pesan setelah beberapa detik
    setTimeout(function() {
        document.getElementById("successMessage").style.display = "none";
    }, 5000); // Menghilangkan pesan setelah 5 detik
});
