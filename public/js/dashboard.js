$(document).ready(function () {

    // Inisialisasi Select2
    $('#negara').select2({
        placeholder: "Cari negara...",
        allowClear: true,
        width: '100%'
    });

    // Jika dashboard dibuka dari halaman favorit
    if ($('#negara').val()) {
        $('#negara').trigger('change');
    }

    // Inisialisasi peta
    const map = L.map('map').setView([20, 0], 2);

    L.tileLayer('https://{s}.basemaps.cartocdn.com/light_all/{z}/{x}/{y}{r}.png', {
        attribution: '© OpenStreetMap © CARTO'
    }).addTo(map);

    let markers = {};

    // Ambil koordinat negara untuk marker peta
    fetch(APP_URL.koordinat)
        .then(response => response.json())
        .then(data => {
            data.forEach(negara => {

                const marker = L.marker([
                    negara.latitude,
                    negara.longitude
                ]).addTo(map);

                marker.bindPopup(`
                    <strong>${negara.nama_negara}</strong><br>
                    ${negara.ibu_kota}
                `);

                markers[negara.id] = marker;

                // Klik marker => pilih negara di Select2
                marker.on('click', function () {
                    $('#negara')
                        .val(String(negara.id))
                        .trigger('change');
                });
            });
        })
        .catch(error => {
            console.error('Gagal memuat koordinat negara:', error);
        });

    // Event ketika negara dipilih
    $('#negara').on('change', function () {

        const id = $(this).val();

        // Jika tidak ada negara dipilih
        if (!id) {

            map.flyTo([20, 0], 2, {
                animate: true,
                duration: 1.5
            });

            $('#detail-negara').hide();

            // Reset card skor risiko
            $('#skor-total').text('-');
            $('#level-risiko')
                .text('-')
                .removeClass('bg-success bg-warning bg-danger text-dark')
                .addClass('bg-secondary');

            return;
        }

        // Tampilkan loading
        $('#detail-negara').show();
        $('#loading-negara').show();
        $('#konten-negara').hide();

        // Ambil detail negara
        fetch(`${APP_URL.detail}/${id}`)
            .then(response => response.json())
            .then(negara => {

                // Isi data negara
                $('#detail-nama').text(negara.nama_negara);
                $('#detail-bendera').attr('src', negara.bendera);
                $('#detail-ibukota').text(negara.ibu_kota);
                $('#detail-wilayah').text(negara.wilayah);
                $('#detail-iso').text(
                    negara.kode_iso2 + " / " + negara.kode_iso3
                );

                // Isi ID untuk tombol simpan favorit
                $('#favorit-negara-id').val(negara.id);

                // Sembunyikan loading, tampilkan konten
                $('#loading-negara').hide();
                $('#konten-negara').show();

                // Panggil fungsi lain
                loadCuaca(negara.id);
                muatEkonomi(id);
                muatKurs(id);
                muatSkorRisiko(id);

                muatGrafikSkorRisiko(id);
                muatGrafikKurs(id);
                muatGrafikGdp(id);
                muatGrafikInflasi(id);
                muatGrafikPopulasi(id);

                // Pindahkan peta ke negara yang dipilih
                map.flyTo(
                    [
                        negara.latitude,
                        negara.longitude
                    ],
                    5,
                    {
                        animate: true,
                        duration: 1.5
                    }
                );

                // Buka popup marker setelah animasi selesai
                if (markers[negara.id]) {
                    setTimeout(function () {
                        markers[negara.id].openPopup();
                    }, 1500);
                }
            })
            .catch(error => {
                console.error('Gagal memuat detail negara:', error);
                $('#loading-negara').hide();
            });
    });

    if ($('#negara').val()) {
    $('#negara').trigger('change');
}
});

// =========================
// FUNGSI MUAT SKOR RISIKO
// =========================
function muatSkorRisiko(id) {

    fetch(`${APP_URL.skorRisiko}/${id}`)
        .then(response => response.json())
        .then(data => {

            // Tampilkan skor total
            $('#skor-total').text(data.skor_total ?? '-');

            // Tampilkan level risiko
            const badge = $('#level-risiko');

            badge
                .text(data.level_risiko ?? '-')
                .removeClass('bg-success bg-warning bg-danger text-dark bg-secondary');

            if (data.level_risiko === 'rendah') {
                badge.addClass('bg-success');
            } else if (data.level_risiko === 'sedang') {
                badge.addClass('bg-warning text-dark');
            } else if (data.level_risiko === 'tinggi') {
                badge.addClass('bg-danger');
            } else {
                badge.addClass('bg-secondary');
            }

            $('#skor-cuaca').text(formatSkor(data.skor_cuaca));
            $('#skor-bencana').text(formatSkor(data.skor_bencana));
            $('#skor-berita').text(formatSkor(data.skor_berita));
            $('#skor-kurs').text(formatSkor(data.skor_kurs));
            $('#skor-ekonomi').text(formatSkor(data.skor_ekonomi));
        })
        .catch(error => {
            console.error('Gagal memuat skor risiko:', error);

            // Reset jika gagal
            $('#skor-total').text('-');
            $('#level-risiko')
                .text('-')
                .removeClass('bg-success bg-warning bg-danger text-dark')
                .addClass('bg-secondary');
                $('#skor-cuaca').text(data.skor_cuaca);
            $('#skor-cuaca').text('-');
            $('#skor-bencana').text('-');
            $('#skor-berita').text('-');
            $('#skor-kurs').text('-');
            $('#skor-ekonomi').text('-');
        });
}

function formatSkor(angka) {
    const nilai = parseFloat(angka);

    // Jika tidak ada angka
    if (isNaN(nilai)) return '-';

    // Jika desimalnya .00, tampilkan tanpa desimal
    if (nilai % 1 === 0) {
        return nilai.toLocaleString('id-ID', {
            minimumFractionDigits: 0,
            maximumFractionDigits: 0
        });
    }

    // Jika ada desimal, tampilkan 2 angka di belakang koma
    return nilai.toLocaleString('id-ID', {
        minimumFractionDigits: 2,
        maximumFractionDigits: 2
    });
}