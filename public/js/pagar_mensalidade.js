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
