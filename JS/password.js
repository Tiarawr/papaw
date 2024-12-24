    // Ambil elemen-elemen yang diperlukan
    const togglePassword = document.getElementById('toggle-password');
    const passwordField = document.getElementById('password-input');
    const eyeIcon = document.getElementById('eye-icon');

    // Fungsi untuk toggle jenis input password
    togglePassword.addEventListener('click', function () {
        // Periksa apakah password sedang disembunyikan (password type)
        if (passwordField.type === "password") {
            passwordField.type = "text"; // Tampilkan password
            eyeIcon.classList.remove('ri-eye-line'); // Ganti ikon mata terbuka
            eyeIcon.classList.add('ri-eye-off-line'); // Ganti ikon mata tertutup
        } else {
            passwordField.type = "password"; // Sembunyikan password
            eyeIcon.classList.remove('ri-eye-off-line'); // Ganti ikon mata tertutup
            eyeIcon.classList.add('ri-eye-line'); // Ganti ikon mata terbuka
        }
    });

