const modalChat = document.getElementById('modalChat');
const btnChatClose = document.getElementById('btnChatClose');
const btnSendMessage = document.getElementById('btnSendMessage');
const btnSendLikeMessage = document.getElementById('btnSendLikeMessage');
const btnSendDesLikeMessage = document.getElementById('btnSendDesLikeMessage');
var urlChatMessage = '../manager/ChatManager.php';
var isResumo = 0;

if(document.getElementById('modal-users-resumo')){
    urlChatMessage = '../../manager/ChatManager.php';
    isResumo = 1;
}

checkInput();

function chat(id){  
    
    beforeSendFunction('show');
    document.getElementById('id-destino').value = id;
    modalChat.showModal();
    getMessage(id);
    beforeSendFunction('hide');
}

btnChatClose.addEventListener('click', function(){
    modalChat.close();
    document.getElementsByClassName('modal-big-body').value = "";
    document.getElementById('id-destino').value = "";
})

btnSendLikeMessage.addEventListener('click', function(){
    let dataChat = {
        'idDestino'  : document.getElementById('id-destino').value,
        'action'     : 'newMessageLike'
    }

    const options = {
        method  : 'POST',
        headers : {
            'Content-Type' : 'application/json'
        },
        body : JSON.stringify(dataChat) // Converte dados em JSON
    }

    fetch(urlChatMessage, options)
    .then(response => {
        if(!response.ok){
            throw new Error ('Falha ao enviar a requisição POST');
        }

        return response.json();
    })
    .then(data => {
        
        if(data.success == 1 && data.warning == 0 && data.error == 0){
            // limpa input
            document.getElementById('chat-message-input').value = "";
            
            // atualiza display de mensagem
            getMessage(document.getElementById('id-destino').value);
        }
        else if(data.success == 0 && data.warning == 1 && data.error == 0){
            alert(data.message);
        }
        else if(data.success == 0 && data.warning == 0 && data.error == 1){
            alert(data.message);
        }

    })
    .catch(error => {
        console.log(error);
    })
})

btnSendMessage.addEventListener('click', function(){
    
    if(document.getElementById('chat-message-input').value !== '' && document.getElementById('id-destino').value !== '')
    {

        let dataChat = {
            'message'    : document.getElementById('chat-message-input').value,
            'idDestino'  : document.getElementById('id-destino').value,
            'action'     : 'newMessage'
        }

        const options = {
            method  : 'POST',
            headers : {
                'Content-Type' : 'application/json'
            },
            body : JSON.stringify(dataChat) // Converte dados em JSON
        }

        fetch(urlChatMessage, options)
        .then(response => {
            if(!response.ok){
                throw new Error ('Falha ao enviar a requisição POST');
            }

            return response.json();
        })
        .then(data => {
            
            if(data.success == 1 && data.warning == 0 && data.error == 0){
                // limpa input
                document.getElementById('chat-message-input').value = "";
                
                // atualiza display de mensagem
                getMessage(document.getElementById('id-destino').value);
            }
            else if(data.success == 0 && data.warning == 1 && data.error == 0){
                alert(data.message);
            }
            else if(data.success == 0 && data.warning == 0 && data.error == 1){
                alert(data.message);
            }

        })
        .catch(error => {
            console.log(error);
        })
    }
})

btnSendDesLikeMessage.addEventListener('click', function(){
    let dataChat = {
        'idDestino'  : document.getElementById('id-destino').value,
        'action'     : 'newMessageDesLike'
    }

    const options = {
        method  : 'POST',
        headers : {
            'Content-Type' : 'application/json'
        },
        body : JSON.stringify(dataChat) // Converte dados em JSON
    }

    fetch(urlChatMessage, options)
    .then(response => {
        if(!response.ok){
            throw new Error ('Falha ao enviar a requisição POST');
        }

        return response.json();
    })
    .then(data => {
        
        if(data.success == 1 && data.warning == 0 && data.error == 0){
            // limpa input
            document.getElementById('chat-message-input').value = "";
            
            // atualiza display de mensagem
            getMessage(document.getElementById('id-destino').value);
        }
        else if(data.success == 0 && data.warning == 1 && data.error == 0){
            alert(data.message);
        }
        else if(data.success == 0 && data.warning == 0 && data.error == 1){
            alert(data.message);
        }

    })
    .catch(error => {
        console.log(error);
    })
})

function checkInput(){
    var inputMessage = document.getElementById('chat-message-input');
    var buttonSend   =  document.getElementById('btnSendMessage'); 

    if(inputMessage.value.trim() !== ''){
        buttonSend.style.pointerEvents  = 'auto';
    }
    else {
        buttonSend.style.pointerEvents  = 'none';
    }
}

function validateInput(){
    var inputMessage = document.getElementById('chat-message-input');
    
    if(inputMessage.value.trim() === ''){
        alert('Por favor, insira uma mensagem antes de clicar em Enviar.');
        return false;
    }

    return true;
}

function getMessage(id)
{
    // Processa as mensagens
    fetch(urlChatMessage+"?action=messages&id="+id+"&resumo="+isResumo)
    .then(response => {
        if(!response.ok){
            throw new Error('Falha na requisição GET');
        }
        return response.json();
    })
    .then(data => {
        if(data.message != null){
            document.getElementById('modal-chat-message').innerHTML = data.message;
        }
    })
    .catch(error => {
        console.log(error);
    })
}