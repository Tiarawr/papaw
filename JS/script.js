// Scroll up
const scrollUp = () => {
    const scrollUpButton = document.getElementById('scroll-up'); // Ganti nama variabel untuk menghindari konflik
    // Jika elemen ditemukan dan scroll lebih dari 350 viewport height, tambahkan kelas 'show-scroll'
    if (scrollUpButton) {
        window.scrollY >= 350 ? scrollUpButton.classList.add('show-scroll')
                              : scrollUpButton.classList.remove('show-scroll')
    }
}

// Scroll Sections Active link
const sections = document.querySelectorAll('section[id]');

const setActiveLink = () => {
    const currentUrl = window.location.href;

    sections.forEach(section => {
        const sectionId = section.getAttribute('id');
        const sectionLink = document.querySelector(`.nav_menu a[href="${currentUrl}#${sectionId}"]`);

        if (sectionLink) {
            sectionLink.classList.add('active_link');
        }
    });
};

window.addEventListener('load', setActiveLink);
window.addEventListener('hashchange', setActiveLink);


// Scroll reveal Animation
const sr = Scrollreveal ({
    origin: 'top',
    distance: '60px',
    duration: 2500,
    delay: 300,
})

sr.reveal('.home_data, .footer')
sr.reveal('.home_pet', {delay: 700, distance: '100px', origin: 'right'})
sr.reveal('.adopsi_data', {origin: 'right'})
sr.reveal('.adopsi_img', {origin: 'left'})


// Autocomplete form
$(document).ready(function () {
    // Menangani input cari alamat
    $('#alamat').on('input', function () {
        var query = $(this).val();
        if (query.length > 2) {
            $.get('path_to_this_file.php', { q: query }, function (data) {
                var alamatData = JSON.parse(data);
                var resultHTML = '';

                if (alamatData.length > 0) {
                    alamatData.forEach(function (alamat) {
                        resultHTML += '<div class="alamat-item" data-id="' + alamat.id_alamat + '" data-address="' + alamat.full_address + '">' + alamat.full_address + '</div>';
                    });
                    $('#alamat-result').html(resultHTML).show();
                } else {
                    $('#alamat-result').html('<div>No results found</div>').show();
                }
            });
        } else {
            $('#alamat-result').hide();
        }
    });

    // Menangani pemilihan alamat dari hasil autocomplete
    $(document).on('click', '.alamat-item', function () {
        var address = $(this).data('address');
        var idAlamat = $(this).data('id');
        
        $('#alamat').val(address);
        $('#id_alamat').val(idAlamat);
        $('#alamat-result').hide();
    });

    // Menyembunyikan hasil autocomplete jika pengguna klik di luar
    $(document).click(function (e) {
        if (!$(e.target).closest('#alamat').length) {
            $('#alamat-result').hide();
        }
    });
});

