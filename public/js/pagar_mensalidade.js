const inputEntrada = document.getElementById('inputEntrada');
const inputDesconto = document.getElementById('inputDesconto');

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
        alert('O valor do desconto não pode ser superior ao valor do produto!');
        inputDesconto.value = '0,00';
    } else {
        var valorComDesconto = parseFloat(valorTotalPagar) - parseFloat(valorDesconto);
        
        document.getElementById('totalPagar').innerHTML = "R$ "+valorComDesconto.toFixed(2).replace('.', ',');
        document.getElementById('td-desconto').textContent = valorDesconto.replace('.', ',');
    }

})


// selectPagamento -  dinheiro obriga informar o valor de entrada, cartão e pix seta o valor de total no input de entrada.