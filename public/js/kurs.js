let chartKurs;
function muatKurs(id) {

    // Reset semua nilai
    $('#detail-kode-mata-uang').text('-');
    $('#detail-kurs').text('-');
    $('#detail-perubahan-kurs').text('-');
    $('#detail-tren-kurs').text('-');
    $('#detail-risiko-kurs')
        .text('-')
        .removeClass('bg-success bg-warning bg-danger bg-dark text-dark');
    $('#kurs-tanggal').text('');

    $('#loading-kurs').show();
    $('#konten-kurs').hide();

    muatGrafikKurs(id);

    fetch(`${APP_URL.kurs}/${id}`)
        .then(res => res.json())
        .then(data => {

            if (!data.sukses) {
                $('#detail-kurs').text('Data belum tersedia');
                $('#loading-kurs').hide();
                $('#konten-kurs').show();
                return;
            }

            // Tanggal data
            $('#kurs-tanggal').text('(Data ' + data.tanggal + ')');

            // Kode mata uang
            $('#detail-kode-mata-uang').text(data.kode_mata_uang);

            // Nilai kurs — format angka besar pakai fungsi dari ekonomi.js
            $('#detail-kurs').text(
                formatAngkaKurs(data.kurs_ke_usd) +
                ' ' + data.kode_mata_uang
            );

            // Perubahan persen
            if (data.perubahan_persen !== null) {

                const persen = parseFloat(data.perubahan_persen).toFixed(2);
                const tanda  = persen > 0 ? '+' : '';
                let warna    = 'text-muted';
                let tren     = '→ Stabil';

                if (persen > 0.5) {
                    warna = 'text-danger';
                    tren  = '↑ Melemah';
                } else if (persen < -0.5) {
                    warna = 'text-success';
                    tren  = '↓ Menguat';
                }

                $('#detail-perubahan-kurs').html(
                    `<span class="${warna}">${tanda}${persen}%</span>`
                );

                $('#detail-tren-kurs').html(
                    `<span class="${warna}">${tren}</span>`
                );

            } else {
                $('#detail-perubahan-kurs').text('Belum ada data kemarin');
                $('#detail-tren-kurs').text('-');
            }

            // Badge tingkat risiko
            const badge      = $('#detail-risiko-kurs');
            const warnaBadge = {
                'rendah' : 'bg-success',
                'sedang' : 'bg-warning text-dark',
                'tinggi' : 'bg-danger',
                'kritis' : 'bg-dark',
            };

            badge.text(data.tingkat_risiko)
                 .addClass(warnaBadge[data.tingkat_risiko] ?? 'bg-secondary');

            $('#loading-kurs').hide();
            $('#konten-kurs').show();

        })
        .catch(error => {
            console.error('Gagal ambil data kurs:', error);
            $('#loading-kurs').hide();
            $('#konten-kurs').show();
            $('#detail-kurs').text('Gagal memuat data');
        });
}

// Format angka kurs — berbeda dari formatAngkaBesar di ekonomi.js
function formatAngkaKurs(angka) {
    return parseFloat(angka).toLocaleString('id-ID', {
        minimumFractionDigits : 2,
        maximumFractionDigits : 4,
    });
}

function muatGrafikKurs(idNegara) {

    fetch(`${APP_URL.kurs}/grafik/${idNegara}`)
        .then(res => res.json())
        .then(data => {

            const labels = data.map(item => item.tanggal);
            const values = data.map(item => item.kurs_ke_usd);

            const ctx = document
                .getElementById('grafikKurs')
                .getContext('2d');

            // Hapus grafik lama jika ada
            if (chartKurs) {
                chartKurs.destroy();
            }

            chartKurs = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Kurs ke USD',
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
            console.error('Gagal memuat grafik kurs:', error);
        });
}