function buscarMateriaPrima(inputId, destinoSelector, endpoint = 'materiaprima_buscar.php') {
    const buscador = document.getElementById(inputId);
    const destino = document.querySelector(destinoSelector);

    if (!buscador || !destino) return;

    buscador.addEventListener('keyup', function() {
        const term = buscador.value.trim();// trim() evita problemas con espacios en blanco al borrar

        //si el input está vacío, pedimos la tabla completa (vuelve la lista completa)
        const url = term === '' 
            ? `${endpoint}` 
            : `${endpoint}?term=${encodeURIComponent(term)}`;


        fetch(url)
            .then(response => response.text())
            .then(data => {
                destino.innerHTML = data;
                // reemplaza el contenido de la tabla con los resultados filtrados o completos
            })
            .catch(error => {
                console.error('Error en búsqueda dinámica:', error);
            });
    });
}

// inicializa la búsqueda dinámica cuando la página carga
document.addEventListener('DOMContentLoaded', function() {
    buscarMateriaPrima('buscador', 'table tbody');
});