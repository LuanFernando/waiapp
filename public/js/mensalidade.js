const modalMensalidade = document.getElementById('modalMensalidade');
const btnMensalidadeClose = document.getElementById('btnMensalidadeClose');
const urlFinanceiro = '../manager/FinanceManager.php';
const urlFinanceiroResumo = '../../manager/FinanceManager.php';


function mensalidadeUser(id)
{
    carregaInformecoesMensalidadesAluno(id);
    modalMensalidade.showModal();
}

btnMensalidadeClose.addEventListener('click', function(){
    modalMensalidade.close();
    limpaMensalidade();
})

function carregaInformecoesMensalidadesAluno(id)
{
    if(document.getElementById('idAlunoMensalidade')){
        document.getElementById('idAlunoMensalidade').value = id;
    }

    if(document.getElementById('modal-users-resumo')){
        chamaFetchGenerica(id, urlFinanceiroResumo);
    } else {
        chamaFetchGenerica(id, urlFinanceiro);
    }
}

function chamaFetchGenerica(id, url)
{
    console.log(url+'?action=infoMensalidade&idAluno='+id)
    fetch(url+'?action=infoMensalidade&idAluno='+id)
    .then(response => {
        if(!response.ok){
            throw new Error ('Falha na requisição');
        }
        return response.json();
    })
    .then(data => {
        console.log(data);

        if(data.success == 1 && data.warning == 0 && data.error == 0){

            console.log(data.optionYear)
            if(data.optionYear != ''){
                document.getElementById('selectYearMensal').innerHTML = data.optionYear;
            }

            if(data.pago != ''){
                document.getElementById('strongPago').innerHTML = data.pago;
            }

            if(data.pendente != ''){
                document.getElementById('strongPendente').innerHTML = data.pendente;
            }

            if(data.desconto != ''){
                document.getElementById('strongDesconto').innerHTML = data.desconto;
            }

        }else if(data.success == 0 && data.warning == 1 && data.error == 0){
            alert(data.message);
        }else if(data.success == 0 && data.warning == 0 && data.error == 1){
            alert(data.message);
        }
    })
    .catch(error => {
        console.log(error);
    })
}


function limpaMensalidade()
{
    document.getElementById('selectYearMensal').innerHTML = '';
    document.getElementById('strongPago').innerHTML = 'R$ 0,00';
    document.getElementById('strongPendente').innerHTML = 'R$ 0,00';
    document.getElementById('strongDesconto').innerHTML = 'R$ 0,00';

    if(document.getElementById('idAlunoMensalidade')){
        document.getElementById('idAlunoMensalidade').value = '';
    }

    if(document.getElementById('divTable-mensalidade')){
        document.getElementById('divTable-mensalidade').innerHTML = '';
    }
}

if(document.getElementById('selectYearMensal')){
    document.getElementById('selectYearMensal').addEventListener('change', function(){
        if(document.getElementById('idAlunoMensalidade')){
            const ano = document.getElementById('selectYearMensal').value
            const idAluno = document.getElementById('idAlunoMensalidade').value;

            if(document.getElementById('modal-users-resumo')){
                carregaMensalidadePorAno(ano, idAluno, urlFinanceiroResumo);
            } else {
                carregaMensalidadePorAno(ano, idAluno, urlFinanceiro);
            }
            
        }
    })
}

function carregaMensalidadePorAno(ano, idAluno,url)
{
    if(ano != '' && idAluno != '' && url != ''){
        fetch(url+'?action=mensalidadePorAno&ano='+ano+'&idAluno='+idAluno)
        .then(response => {
            if(!response.ok){
                throw new Error('Falha na requisição');
            }
            return response.json();
        })
        .then(data => {
            console.log(data);

            if(data.success == 1 && data.warning == 0 && data.error == 0){
                if(data.table != ''){
                    document.getElementById('divTable-mensalidade').innerHTML = data.table;
                }
            } else if(data.success == 0 && data.warning == 1 && data.error == 0){
                alert(data.message);
            } else if(data.success == 0 && data.warning == 0 && data.error == 1){
                alert(data.message);
            }
        })
        .catch(error => {
            console.log(error);
        })
    }
}