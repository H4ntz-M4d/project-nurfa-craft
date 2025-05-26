$(function() {
    // Fungsi untuk memuat provinsi
    async function loadProvinsi() {
        try {
            const response = await $.ajax({
                url: '/get-provinsi',
                type: 'GET',
                dataType: 'json'
            });

            $('#provinsi').empty();
            $('#provinsi').append('<option value="">Pilih Provinsi</option>');

            $.each(response, function(key, value) {
                $('#provinsi').append(
                    `<option value="${value.name}" data-id="${value.id}">${value.name}</option>`
                );
            });

            // Pilih provinsi lama jika ada
            if (oldProvinsi !== "") {
                $('#provinsi').val(oldProvinsi).trigger('change');
            }
        } catch (error) {
            alert('Gagal memuat data provinsi');
        }
    }

    // Fungsi untuk memuat kabupaten berdasarkan provinsi yang dipilih
    async function loadKabupaten(provinsiId) {
        try {
            const response = await $.ajax({
                url: `/get-kabupaten/${provinsiId}`,
                type: 'GET',
                dataType: 'json'
            });

            $('#kabupaten').empty();
            $('#kabupaten').append('<option value="">Pilih Kabupaten</option>');

            $.each(response, function(key, value) {
                $('#kabupaten').append(
                    `<option value="${value.name}">${value.name}</option>`
                );
            });

            // Pilih kabupaten lama jika ada
            if (oldKabupaten !== "") {
                $('#kabupaten').val(oldKabupaten);
            }
        } catch (error) {
            alert('Gagal memuat data kabupaten');
        }
    }

    // Menangani elemen select
    $('#form-checkout select').on('change', function() {
        const selectName = $(this).attr('name');
        const $errorElement = $(`.error-message[data-for="${selectName}"]`);

        if ($errorElement.length) {
            if ($(this).val() === '') {
                $errorElement.show();
            } else {
                $errorElement.hide();
            }
        }
    });

    // Menangani elemen input
    $('#form-checkout input').on('input', function() {
        const inputName = $(this).attr('name');
        const $errorElement = $(`.error-message[data-for="${inputName}"]`);

        if ($errorElement.length) {
            if ($(this).val().trim() === '') {
                $errorElement.show();
            } else {
                $errorElement.hide();
            }
        }
    });

    // Ketika provinsi diubah
    $('#provinsi').on('change', function() {
        const selectedOption = $(this).find('option:selected');
        const provinsiId = selectedOption.data('id');

        if (provinsiId) {
            $('#kabupaten-container').show();
            loadKabupaten(provinsiId);
        } else {
            $('#kabupaten-container').hide();
            $('#kabupaten').empty();
            $('#kabupaten').append('<option value="">Pilih Kabupaten</option>');
        }
    });

    // Inisialisasi halaman
    async function initialize() {
        await loadProvinsi();
        createOptionGender();
        createDateInput();

        // Jika ada nilai lama untuk provinsi, muat kabupaten terkait
        if (oldProvinsi !== "") {
            $('#provinsi').val(oldProvinsi).trigger('change');
        }
    }

    initialize();
});
