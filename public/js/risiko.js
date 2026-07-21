let chartSkorRisiko;

function muatGrafikSkorRisiko(idNegara) {

    fetch(`${APP_URL.skorRisiko}/${idNegara}`)
        .then(res => res.json())
        .then(data => {

            const labels = data.map(item => item.tanggal);
            const values = data.map(item => item.skor_total);

            const canvas = document.getElementById('grafikSkorRisiko');
            if (!canvas) return;

            const ctx = canvas.getContext('2d');

            // Hapus grafik lama jika ada
            if (chartSkorRisiko) {
                chartSkorRisiko.destroy();
            }

            chartSkorRisiko = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Skor Risiko',
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
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            max: 100,
                            ticks: {
                                stepSize: 10
                            }
                        }
                    }
                }
            });

        })
        .catch(error => {
            console.error('Gagal memuat grafik skor risiko:', error);
        });
}