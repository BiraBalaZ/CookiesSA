function calcularTotal() {
    let totalGeral = 0;
    const precoPorCaixa = 10.00;
    let cookies = document.getElementById("cookies").childElementCount;

    for (let i = 1; i <= cookies; i++) {
        let quantidade = document.getElementById("quantidade_sabor" + i).value;
        let totalPorSabor = quantidade * precoPorCaixa;
        document.getElementById("total_sabor" + i).innerText = "R$ " + totalPorSabor.toFixed(2);
        totalGeral += totalPorSabor;
    }

    document.getElementById("total_geral").innerText = "Total: R$ " + totalGeral.toFixed(2);
}

function verificarCPF() {
    const cpf = document.getElementById("cpf").value;
    const cpfValido = validarCPF(cpf);

    if (!cpfValido) {
        alert("CPF inválido. Por favor, insira um CPF válido.");
        return false; // Impede o envio do formulário
    }

    return true; // CPF válido, permite envio do formulário
}

function validarCPF(cpf) {
    cpf = cpf.replace(/[^\d]+/g, ''); // Remove caracteres não numéricos
    if (cpf.length !== 11 || /^(\d)\1+$/.test(cpf)) {
        return false;
    }

    let soma = 0;
    let resto;

    for (let i = 1; i <= 9; i++) {
        soma += parseInt(cpf.substring(i - 1, i)) * (11 - i);
    }

    resto = (soma * 10) % 11;

    if (resto === 10 || resto === 11) {
        resto = 0;
    }

    if (resto !== parseInt(cpf.substring(9, 10))) {
        return false;
    }

    soma = 0;

    for (let i = 1; i <= 10; i++) {
        soma += parseInt(cpf.substring(i - 1, i)) * (12 - i);
    }

    resto = (soma * 10) % 11;

    if (resto === 10 || resto === 11) {
        resto = 0;
    }

    return resto === parseInt(cpf.substring(10, 11));
}