console.log('ekonomi.js berhasil dimuat');

// =====================================================
// VARIABEL GRAFIK
// =====================================================
let chartGdp;
let chartInflasi;
let chartPopulasi;

// =====================================================
// MUAT DATA EKONOMI (CARD)
// =====================================================
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

// =====================================================
// FUNGSI BANTU FORMAT ANGKA BESAR
// =====================================================
function formatAngkaBesar(angka) {

    angka = parseFloat(angka);

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

// =====================================================
// GRAFIK GDP
// =====================================================
function muatGrafikGdp(id) {

    fetch(`${APP_URL.ekonomiGrafikGdp}/${id}`)
        .then(res => res.json())
        .then(data => {

            const labels = data.map(item => item.tahun);
            const values = data.map(item => item.gdp);

            const canvas = document.getElementById('grafikGdp');
            if (!canvas) return;

            const ctx = canvas.getContext('2d');

            // Hapus grafik lama jika ada
            if (chartGdp) {
                chartGdp.destroy();
            }

            chartGdp = new Chart(ctx, {
    type: 'line',
    data: {
        labels: labels,
        datasets: [{
            label: 'GDP',
            data: values,
            borderColor: '#311046',
            backgroundColor: 'rgba(49, 16, 70, 0.1)',
            tension: 0.3,
            fill: true,
            pointBackgroundColor: '#ff9800',
            pointRadius: 4
        }]
    },
    options: {
        responsive: true,
        plugins: {
            legend: {
                display: false
            }
        },
        scales: {
            y: {
                beginAtZero: false
            }
        }
    }
});

        })
        .catch(error => {
            console.error('Gagal memuat grafik GDP:', error);
        });
}

// =====================================================
// GRAFIK INFLASI
// =====================================================
function muatGrafikInflasi(id) {

    fetch(`${APP_URL.ekonomiGrafikInflasi}/${id}`)
        .then(res => res.json())
        .then(data => {

            const labels = data.map(item => item.tahun);
            const values = data.map(item => item.inflasi);

            const canvas = document.getElementById('grafikInflasi');
            if (!canvas) return;

            const ctx = canvas.getContext('2d');

            if (chartInflasi) {
                chartInflasi.destroy();
            }

            chartInflasi = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Inflasi',
                        data: values,
                        borderColor: '#ff9800',
                        backgroundColor: 'rgba(255, 152, 0, 0.1)',
                        tension: 0.3,
                        fill: true,
                        pointBackgroundColor: '#ff9800',
                        pointRadius: 4
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            display: false
                        }
                    }
                }
            });

        })
        .catch(error => {
            console.error('Gagal memuat grafik Inflasi:', error);
        });
}

// =====================================================
// GRAFIK POPULASI
// =====================================================
function muatGrafikPopulasi(id) {

    fetch(`${APP_URL.ekonomiGrafikPopulasi}/${id}`)
        .then(res => res.json())
        .then(data => {

            const labels = data.map(item => item.tahun);
            const values = data.map(item => item.populasi);

            const canvas = document.getElementById('grafikPopulasi');
            if (!canvas) return;

            const ctx = canvas.getContext('2d');

            if (chartPopulasi) {
                chartPopulasi.destroy();
            }

            chartPopulasi = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Populasi',
                        data: values,
                        borderColor: '#311046',
                        backgroundColor: 'rgba(49, 16, 70, 0.1)',
                        tension: 0.3,
                        fill: true,
                        pointBackgroundColor: '#311046',
                        pointRadius: 4
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            display: false
                        }
                    }
                }
            });

        })
        .catch(error => {
            console.error('Gagal memuat grafik Populasi:', error);
        });
}