const modalMensalidade = document.getElementById('modalMensalidade');
const btnMensalidadeClose = document.getElementById('btnMensalidadeClose');
const urlFinanceiro = '../manager/FinanceManager.php';
const urlFinanceiroResumo = '../../manager/FinanceManager.php';
const modalGerarMensalidade = document.getElementById('modalGerarMensalidade');


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
        verificaPendenciasAluno(id,urlFinanceiroResumo,'resumo');
    } else {
        chamaFetchGenerica(id, urlFinanceiro);
        verificaPendenciasAluno(id,urlFinanceiro,'dashboard');
    }

    
}

function chamaFetchGenerica(id, url)
{
    beforeSendFunction('show');
    fetch(url+'?action=infoMensalidade&idAluno='+id)
    .then(response => {
        if(!response.ok){
            throw new Error ('Falha na requisição');
        }
        return response.json();
    })
    .then(data => {
        
        beforeSendFunction('hide');
        if(data.success == 1 && data.warning == 0 && data.error == 0){

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


function verificaPendenciasAluno(id, url, pagina)
{
    beforeSendFunction('show');
    fetch(url+'?action=alertaPendencia&idAluno='+id+'&pagina='+pagina)
    .then(response => {
        if(!response.ok){
            throw new Error ('Falha na requisição');
        }
        return response.json();
    })
    .then(data => {
        beforeSendFunction('hide');
        if(data.success == 1 && data.warning == 0 && data.error == 0){
            if(data.srcImg != '' && data.srcImg != null){
                document.getElementById('alerta-pendencia').innerHTML = data.srcImg;
                document.getElementById('btnGerarMensalidade').style.display = 'none';
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

    if(document.getElementById('alerta-pendencia')){
        document.getElementById('alerta-pendencia').innerHTML = '';
    }

    if(document.getElementById('btnGerarMensalidade')){
        document.getElementById('btnGerarMensalidade').style.display = 'block';
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
        beforeSendFunction('show');

        fetch(url+'?action=mensalidadePorAno&ano='+ano+'&idAluno='+idAluno)
        .then(response => {
            if(!response.ok){
                throw new Error('Falha na requisição');
            }
            return response.json();
        })
        .then(data => {
            
            beforeSendFunction('hide');
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

if(document.getElementById('btnGerarMensalidade')){
    document.getElementById('btnGerarMensalidade').addEventListener('click', function(){
        modalGerarMensalidade.showModal();
    })
}


function pagarMensalidade(id){

    let  urlHtml = "";
    if(document.getElementById('modal-users-resumo')){
        urlHtml = "../../common-component/modals-html/pagar-mensalidade.html";
    } else {
        urlHtml = "../common-component/modals-html/pagar-mensalidade.html";
    }

    // cria modal de forma dinamica.
    createLargeGenericModal('Pagar Mensalidade N°: '+id, urlHtml ,{ idMensalidadeAluno : id ,valorSemFormat : 0}, detalhesPagamento);
}

function cancelarMensalidade(id){

    let  urlHtml = "";
    if(document.getElementById('modal-users-resumo')){
        urlHtml = "../../common-component/modals-html/cancelar-mensalidade.html";
    } else {
        urlHtml = "../common-component/modals-html/cancelar-mensalidade.html";
    }

    // cria modal de forma dinamica.
    createGenericModalMedia('Cancelar Mensalidade N°: '+id, urlHtml ,{ idMensalidadeAluno : id}, null);

}

function detalhesPagamento()
{
    if(document.getElementById('detalhes-pagamento')){
        let idMensalidadeAluno = document.getElementById('idMensalidadeAluno').value;
        var url = '';
    
        if(document.getElementById('modal-users-resumo')){
            url = '../../manager/FinanceManager.php?action=detalhes&idMensalidadeAluno='+idMensalidadeAluno;
        } else {
            url = '../../manager/FinanceManager.php?action=detalhes&idMensalidadeAluno='+idMensalidadeAluno;
        }
    
        console.log(url)

        beforeSendFunction('show');

        fetch(url)
        .then(response => {
            if(!response.ok){
                throw new Error('Falha na requisição');
            }
    
            return response.json();
        })
        .then(data => {
            
            beforeSendFunction('hide');
            console.log(data);
    
            if(data.success == 1 && data.warning == 0 && data.error == 0){
                document.getElementById('detalhes-pagamento').innerHTML = data.detalhes;
                document.getElementById('totalPagar').textContent = data.valorTotal;
                document.getElementById('valorSemFormat').value = data.valorSemFormat;
            } else if(data.success == 0 && data.warning == 1 && data.error == 0){
                alert(data.message);
            } else if(data.success == 0 && data.warning == 0 && data.error == 1){
                alert(data.message);
            }
        })
        .catch(error => {
            console.log('Erro: '+error);
        })
    }
}