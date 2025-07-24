function buscarMateriaPrima(inputId, destinoSelector, endpoint = 'materiaprima_buscar.php') {
    const buscador = document.getElementById(inputId);
    const destino = document.querySelector(destinoSelector);

    if (!buscador || !destino) return;

    buscador.addEventListener('keyup', function() {
        const term = buscador.value;

        fetch(`${endpoint}?term=${encodeURIComponent(term)}`)
            .then(response => response.text())
            .then(data => {
                destino.innerHTML = data;
            })
            .catch(error => {
                console.error('Error en búsqueda dinámica:', error);
            });
    });
}