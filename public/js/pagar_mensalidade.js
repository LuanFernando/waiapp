const inputEntrada = document.getElementById('inputEntrada');
const inputDesconto = document.getElementById('inputDesconto');

inputDesconto.value = '0,00';
inputEntrada.value  = '0,00';

inputEntrada.addEventListener('input', function(){
    // Remove todos os caracteres não númericos
    let valor = inputEntrada.value.replace(/\D/g, '').replace(/^0+/, '');

    if(valor == 0){
        valor = '0,00';
    } else{
        // Formata o valor como moeda R$
        if(valor.length > 2){
            valor = valor.replace(/(\d{1,})(\d{2})$/, '$1,$2');
        } else if(valor.length === 2){
            valor = `0,${valor}`;
        } else if(valor.length === 1) {
            valor = `0,0${valor}`;
        }
    }

    // Atualiza o valor 
    inputEntrada.value = valor;
})

inputEntrada.addEventListener('blur', function(){
    calculaTroco();
})

inputDesconto.addEventListener('input', function(){
    // Remove todos os caracteres não númericos
    let valor = inputDesconto.value.replace(/\D/g, '').replace(/^0+/, '');

    if(valor == 0){
        valor = '0,00';
    } else{
        // Formata o valor como moeda R$
        if(valor.length > 2){
            valor = valor.replace(/(\d{1,})(\d{2})$/, '$1,$2');
        } else if(valor.length === 2){
            valor = `0,${valor}`;
        } else if(valor.length === 1) {
            valor = `0,0${valor}`;
        }
    }

    // Atualiza o valor 
    inputDesconto.value = valor;
})

inputDesconto.addEventListener('blur', function(){
    calculoDescontoReais();
})


function changeSelect()
{
    // selectPagamento
    let payment = document.getElementById('selectPagamento').value;
    var inputEntrada = document.getElementById('inputEntrada');


    if(payment == 1){
        // dinheiro
        inputEntrada.disabled = false;
    } else if(payment == 2){
        // cartão
        inputEntrada.disabled  = true;
        calculoDescontoReais();
        inputEntrada.value = document.getElementById('hiddenTotalPagar').value;
    } else if(payment == 3) {
        //pix
        inputEntrada.disabled  = true;
        calculoDescontoReais();
        inputEntrada.value = document.getElementById('hiddenTotalPagar').value;
    }
}

function calculoDescontoReais()
{
    // Remove todos os caracteres não númericos
    let valorTotalPagar = document.getElementById('valorSemFormat').value.replace(/\D/g, '').replace(/^0+/, '');
    let valorDesconto = inputDesconto.value.replace(/\D/g, '').replace(/^0+/, '');

    if(valorDesconto == 0){
        valorDesconto = '0.00';
    } else{
        if(valorDesconto.length > 2){
            valorDesconto = valorDesconto.replace(/(\d{1,})(\d{2})$/, '$1,$2');
        } else if(valorDesconto.length === 2){
            valorDesconto = `0.${valorDesconto}`;
        } else if(valorDesconto.length === 1) {
            valorDesconto = `0.0${valorDesconto}`;
        }
    }

    if(valorTotalPagar == 0){
        valorTotalPagar = '0.00';
    } else{
        if(valorTotalPagar.length > 2){
            valorTotalPagar = valorTotalPagar.replace(/(\d{1,})(\d{2})$/, '$1,$2');
        } else if(valorTotalPagar.length === 2){
            valorTotalPagar = `0.${valorTotalPagar}`;
        } else if(valorTotalPagar.length === 1) {
            valorTotalPagar = `0.0${valorTotalPagar}`;
        }
    }

    // calcula o desconto e seta o valor para campo desconto
    if(parseFloat(valorDesconto) > parseFloat(valorTotalPagar)){
        alert('O valor do desconto não pode ser superior ao valor total do produto!');
        inputDesconto.value = '0,00';
        return false;
    } else {
        var valorComDesconto = parseFloat(valorTotalPagar) - parseFloat(valorDesconto);
        
        document.getElementById('hiddenTotalPagar').value  = valorComDesconto.toFixed(2).replace('.', ',');
        document.getElementById('totalPagar').innerHTML    = "R$ "+valorComDesconto.toFixed(2).replace('.', ',');
        document.getElementById('td-desconto').textContent = valorDesconto.replace('.', ',');

        let payment = document.getElementById('selectPagamento').value;

        if(payment == 2 || payment == 3){
            inputEntrada.value = document.getElementById('hiddenTotalPagar').value;
        }
    }

    calculaTroco();
}

function calculaTroco()
{
    let payment = document.getElementById('selectPagamento').value;

    if(payment == 1){
        // dinheiro
        var totalPagar   = document.getElementById('hiddenTotalPagar').value;
        var inputEntrada = document.getElementById('inputEntrada').value;
        var troco = parseFloat(inputEntrada) - parseFloat(totalPagar);

        if(parseFloat(troco) > 0){
            document.getElementById('troco').innerHTML = 'R$ '+troco.toFixed(2).replace('.', ',');
        } else if(parseFloat(troco) < 0){
            alert('O valor de entrada é menor que o valor total do produto!');
            document.getElementById('troco').innerHTML = 'R$ 0,00';
            return false;
        } else {
            document.getElementById('troco').innerHTML = 'R$ 0,00';
        }
    } else {
        document.getElementById('troco').innerHTML = 'R$ 0,00';
    }
}
