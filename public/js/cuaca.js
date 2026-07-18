function loadCuaca(idNegara)
{
    fetch(`${APP_URL.cuaca}/${idNegara}`)
    .then(response => response.json())
    .then(cuaca => {

        $('#detail-suhu').text(cuaca.suhu + ' °C');
        $('#detail-hujan').text(cuaca.curah_hujan + ' mm');
        $('#detail-angin').text(cuaca.kecepatan_angin + ' km/jam');
        $('#detail-kondisi').text(cuaca.kondisi_cuaca);

        $('#detail-risiko-cuaca')
            .removeClass('bg-success bg-warning bg-danger text-dark');

        if (cuaca.tingkat_risiko === 'rendah') {
            $('#detail-risiko-cuaca').addClass('bg-success');
        } else if (cuaca.tingkat_risiko === 'sedang') {
            $('#detail-risiko-cuaca').addClass('bg-warning text-dark');
        } else {
            $('#detail-risiko-cuaca').addClass('bg-danger');
        }

        $('#detail-risiko-cuaca').text(cuaca.tingkat_risiko);

    })
    .catch(function(error){

        console.log(error);

    });
}