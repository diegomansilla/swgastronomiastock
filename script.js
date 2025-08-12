let index = 1;
$(document).ready(function() {
    $('#tablaPlatos').DataTable({
        language: {
            url: "//cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json"
        }
    });
});

function agregarIngrediente() {
    const container = document.getElementById("ingredientes-container");
    const nuevo = document.createElement("div");
    nuevo.innerHTML = `
        <input type="hidden" name="ingredientes[${index}][id]" value="0">
        <input type="text" name="ingredientes[${index}][nombre]" placeholder="Ingrediente" required>
        <input type="text" name="ingredientes[${index}][cantidad]" placeholder="Cantidad" required>
    `;
    container.appendChild(nuevo);
    index++;
}

