$(document).ready(function () {

    $('#negara').select2({
        placeholder: "Cari negara...",
        allowClear: true,
        width: '100%'
    });

    const map = L.map('map').setView([20, 0], 2);

    L.tileLayer('https://{s}.basemaps.cartocdn.com/light_all/{z}/{x}/{y}{r}.png', {
        attribution: '© OpenStreetMap © CARTO'
    }).addTo(map);

    let markers = {};

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
                marker.on('click', function () {
                    $('#negara')
                    .val(String(negara.id))
                    .trigger('change');
                });
            });
        })
        .catch(error => {console.error(error);});

    $('#negara').on('change', function () {
        const id = $(this).val();
        if (!id) {
            map.flyTo([20, 0], 2, {
                animate: true,
                duration: 1.5
            });
            $('#detail-negara').hide();
            return;
        }

        $('#detail-negara').show();
        $('#loading-negara').show();
        $('#konten-negara').hide();

        fetch(`${APP_URL.detail}/${id}`)
            .then(response => response.json())
            .then(negara => {
                $('#detail-nama').text(negara.nama_negara);
                $('#detail-bendera').attr('src',negara.bendera);
                $('#detail-ibukota').text(negara.ibu_kota);
                $('#detail-wilayah').text(negara.wilayah);
                $('#detail-iso').text(negara.kode_iso2 + " / " +negara.kode_iso3);

                $('#favorit-negara-id').val(negara.id);

                $('#loading-negara').hide();
                $('#konten-negara').show();

                loadCuaca(negara.id);
                muatEkonomi(id);
                muatKurs(id); 
                
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
                if (markers[negara.id]) {
                    setTimeout(function () {
                        markers[negara.id].openPopup();
                    }, 1500);
                }
            })
            .catch(error => {
                console.error(error);
                $('#loading-negara').hide();
            });
    });
});