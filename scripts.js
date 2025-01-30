// precio planes y paquetes
const PRECIOS = {
    planes: {
        1: 9.99, // basico
        2: 13.99, // estandar
        3: 17.99, // premium
    },
    paquetes: {
        0: 0.00, // ninguno
        1: 6.99, // deporte
        2: 7.99, // cine
        3: 4.99, // infantil
    },
};

// calculo del coste mensual desglosado
function calcularCosto() {
    // obtenenmos los valores
    const plan = document.getElementById("plan").value;
    const paquete = document.getElementById("paquete").value;
    const duracion = document.getElementById("duracion").value;

    // costo base
    let costoBase = PRECIOS.planes[plan];

    // costo del paquete adicional
    let costoPaquete = PRECIOS.paquetes[paquete];

    // costo total
    let costoTotal = costoBase + costoPaquete;

    // enseñar costo total
    document.getElementById("total").textContent = `${costoTotal.toFixed(2)}€`;
}

// escuchar cambios en los campos
document.getElementById("plan").addEventListener("change", calcularCosto);
document.getElementById("paquete").addEventListener("change", calcularCosto);
document.getElementById("duracion").addEventListener("change", calcularCosto);

// calcular el costo inicial al cargar la página
window.addEventListener("load", calcularCosto);

