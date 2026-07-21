$(document).ready(function () {

    // Select2 untuk dashboard
    if ($('#negara').length) {
        $('#negara').select2({
            placeholder: 'Cari negara...',
            allowClear: true,
            width: '100%'
        });
    }

    // Select2 untuk halaman tren
    if ($('#negara-tren').length) {

        $('#negara-tren').select2({
            placeholder: 'Cari negara...',
            allowClear: true,
            width: '100%'
        });

        $('#negara-tren').on('change', function () {

            const id = $(this).val();

            if (!id) {
                $('#konten-tren').hide();
                return;
            }

            // Tampilkan card hasil tren
            $('#konten-tren').show();

            // Panggil grafik berdasarkan negara
            muatGrafikSkorRisiko(id);
            muatGrafikKurs(id);
            muatGrafikGdp(id);
            muatGrafikInflasi(id);
            muatGrafikPopulasi(id);

        });
    }

});