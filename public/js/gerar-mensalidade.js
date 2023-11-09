const numMensalidadeGerar = document.getElementById('numMensalidadeGerar');
const valorMensalidadeGerar = document.getElementById('valorMensalidadeGerar');
const btnGerarMensalidadeGerar = document.getElementById('btnGerarMensalidadeGerar');
const btnGerarMensalidadeCancelar = document.getElementById('btnGerarMensalidadeCancelar');
const modalQuestionGerarMensalidade = document.getElementById('modalQuestionGerarMensalidade');
const btnCancelaPendencia = document.getElementById('btnCancelaPendencia');
const btnBaixaPendencia = document.getElementById('btnBaixaPendencia');
const btnFecharQuestionGerarMensalidade = document.getElementById('btnFecharQuestionGerarMensalidade');

let urlGerarMensalidade = '';

if(document.getElementById('modal-users-resumo')){
    urlGerarMensalidade = "../../manager/FinanceManager.php";
}else{  
    urlGerarMensalidade = "../manager/FinanceManager.php";
}

if(document.getElementById('dataVencimentoMensalidadeGerar')){
    // limitando para que o usuario não possa selecionar datas anteriores a atual.
    var dataVencimentoMensalidadeGeraMin = document.getElementById('dataVencimentoMensalidadeGerar');
    var dataMinima = new Date();
    dataMinima.setDate(dataMinima.getDate()); // + 7 incrementará dias
    var dataMinimaFormatada = dataMinima.toISOString().slice(0, 16);
    dataVencimentoMensalidadeGeraMin.setAttribute('min', dataMinimaFormatada);
}

numMensalidadeGerar.addEventListener('input', function(){
    const valor = parseInt(numMensalidadeGerar.value);
    if(isNaN(valor) || valor < 1){
        numMensalidadeGerar.value = '1';
    } else if(valor > 12){
        numMensalidadeGerar.value = "12";
    }
});

// Mascara de reais 
valorMensalidadeGerar.addEventListener('input', function(){
    // Remove todos os caracteres não númericos
    let valor = valorMensalidadeGerar.value.replace(/\D/g, '');

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
    valorMensalidadeGerar.value = valor;
})

btnFecharQuestionGerarMensalidade.addEventListener('click', function(){
    modalQuestionGerarMensalidade.close();
    modalGerarMensalidade.close();
    limpaFormGerarMensalidade();
})

btnGerarMensalidadeGerar.addEventListener('click', function(){
    if(!validaFormGerarMensalidade()){
        alert('Atenção: Preencha todos os campos!')
        return false;
    }

    var dataForm = {
        'numMensalidade' : document.getElementById('numMensalidadeGerar').value,
        'valorMensalidade' : document.getElementById('valorMensalidadeGerar').value,
        'dataVencimentoBase' : document.getElementById('dataVencimentoMensalidadeGerar').value,
        'idAluno' : document.getElementById('idAlunoMensalidade').value, 
        'action' :'gerarMensalidadeAluno'
    }

    const options = {
        method  : 'POST',
        headers : {
            'Content-Type' : 'application/json'
        },
        body : JSON.stringify(dataForm) // Converte dados em JSON
    }

    beforeSendFunction('show');

    fetch(urlGerarMensalidade,options)
    .then(response => {
        if(!response.ok){
            throw new Error('Falha na requisição');
        }
        return response.json();
    })
    .then(data => {

        beforeSendFunction('hide');
        if(data.success == 1 && data.warning == 0 && data.error == 0){
            alert(data.message);
            modalQuestionGerarMensalidade.close();
            modalGerarMensalidade.close();
            limpaFormGerarMensalidade();
            carregaInformecoesMensalidadesAluno(document.getElementById('idAlunoMensalidade').value);
        }  else if(data.success == 0 && data.warning == 1 && data.error == 0) {
            if(data.pendencias == 1){
                modalGerarMensalidade.close();
                modalQuestionGerarMensalidade.showModal();
            }else{
                alert(data.message);
            }
        } else if(data.success == 0 && data.warning == 0 && data.error == 1){
            alert(data.message);
        }
    })
    .catch(error => {
        console.log('Error: '+error);
    })
})

function validaFormGerarMensalidade(){

    var contCamposObrigatorio = 0;

    if(document.getElementById('numMensalidadeGerar')){
        if(document.getElementById('numMensalidadeGerar').value == 0 || 
        document.getElementById('numMensalidadeGerar').value == null || 
        document.getElementById('numMensalidadeGerar').value == undefined){
            document.getElementById('numMensalidadeGerar').style.borderColor = '#d54d52';
            contCamposObrigatorio +=1;
        } else {
            document.getElementById('numMensalidadeGerar').style.borderColor = '#606c88';
        }
    }

    if(document.getElementById('valorMensalidadeGerar')){
        if(document.getElementById('valorMensalidadeGerar').value.replace(/\D/g, '') == 0 || 
        document.getElementById('valorMensalidadeGerar').value == null || 
        document.getElementById('valorMensalidadeGerar').value == undefined){
            document.getElementById('valorMensalidadeGerar').style.borderColor = '#d54d52';
            contCamposObrigatorio +=1;
        } else {
            document.getElementById('valorMensalidadeGerar').style.borderColor = '#606c88';
        }
    }

    if(document.getElementById('dataVencimentoMensalidadeGerar')){
        if(document.getElementById('dataVencimentoMensalidadeGerar').value == 0 || 
        document.getElementById('dataVencimentoMensalidadeGerar').value == null || 
        document.getElementById('dataVencimentoMensalidadeGerar').value == undefined){
            document.getElementById('dataVencimentoMensalidadeGerar').style.borderColor = '#d54d52';
            contCamposObrigatorio +=1;
        } else {
            document.getElementById('dataVencimentoMensalidadeGerar').style.borderColor = '#606c88'; 
        }
    }
    
    if(contCamposObrigatorio > 0){
        return false;
    } else{
        return true;
    }
}


btnGerarMensalidadeCancelar.addEventListener('click', function(){
    modalGerarMensalidade.close();
    limpaFormGerarMensalidade();
})

function limpaFormGerarMensalidade(){
    document.getElementById('valorMensalidadeGerar').style.borderColor = '#606c88';
    document.getElementById('dataVencimentoMensalidadeGerar').style.borderColor = '#606c88';
    document.getElementById('numMensalidadeGerar').style.borderColor = '#606c88';

    document.getElementById('valorMensalidadeGerar').value = '0,00';
    document.getElementById('dataVencimentoMensalidadeGerar').value = '';
    document.getElementById('numMensalidadeGerar').value = '1';
           
}