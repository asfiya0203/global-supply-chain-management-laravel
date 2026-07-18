function muatEkonomi(id) {

    // Reset semua nilai
    $('#detail-gdp').text('-');
    $('#detail-inflasi').text('-');
    $('#detail-populasi').text('-');
    $('#detail-ekspor').text('-');
    $('#detail-impor').text('-');
    $('#ekonomi-tahun').text('');

    $('#loading-ekonomi').show();
    $('#konten-ekonomi').hide();

    fetch(`${APP_URL.ekonomi}/${id}`)
        .then(res => res.json())
        .then(data => {

            // Tampilkan tahun data
            $('#ekonomi-tahun').text('(Data tahun ' + data.tahun + ')');

            // Format GDP
            $('#detail-gdp').text(
                data.gdp
                    ? '$ ' + formatAngkaBesar(data.gdp)
                    : 'Data tidak tersedia'
            );

            // Format inflasi
            $('#detail-inflasi').text(
                data.inflasi !== null
                    ? parseFloat(data.inflasi).toFixed(2) + ' %'
                    : 'Data tidak tersedia'
            );

            // Format populasi
            $('#detail-populasi').text(
                data.populasi
                    ? formatAngkaBesar(data.populasi) + ' jiwa'
                    : 'Data tidak tersedia'
            );

            // Format ekspor
            $('#detail-ekspor').text(
                data.ekspor
                    ? '$ ' + formatAngkaBesar(data.ekspor)
                    : 'Data tidak tersedia'
            );

            // Format impor
            $('#detail-impor').text(
                data.impor
                    ? '$ ' + formatAngkaBesar(data.impor)
                    : 'Data tidak tersedia'
            );

            $('#loading-ekonomi').hide();
            $('#konten-ekonomi').show();

        })
        .catch(error => {
            console.error('Gagal ambil data ekonomi:', error);
            $('#loading-ekonomi').hide();
            $('#konten-ekonomi').show();
        });
}

// Fungsi bantu format angka besar
function formatAngkaBesar(angka) {

    if (angka >= 1e12) {
        return (angka / 1e12).toFixed(2) + ' T';  // Triliun
    } else if (angka >= 1e9) {
        return (angka / 1e9).toFixed(2) + ' B';   // Miliar
    } else if (angka >= 1e6) {
        return (angka / 1e6).toFixed(2) + ' M';   // Juta
    } else {
        return angka.toLocaleString('id-ID');
    }
}