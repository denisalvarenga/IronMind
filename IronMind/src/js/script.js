document.addEventListener("DOMContentLoaded", function () {

    const pesoInput = document.getElementById("peso");
    const resultadoAgua = document.getElementById("aguaResultado");
    const form = document.querySelector("form");

    if (pesoInput) {

        pesoInput.addEventListener("input", function () {

            const peso = parseFloat(pesoInput.value);

            if (!isNaN(peso) && peso > 0) {
                const aguaLitros = (peso * 35) / 1000;
                resultadoAgua.textContent =
                    "Ingestão diária recomendada: " +
                    aguaLitros.toFixed(2) + " litros";
            } else {
                resultadoAgua.textContent = "";
            }

        });
    }

    if (form) {

        form.addEventListener("submit", function (event) {

            const peso = parseFloat(pesoInput.value);

            if (isNaN(peso) || peso <= 0) {
                alert("Por favor, insira um peso válido.");
                event.preventDefault();
            }

        });

    }

});
