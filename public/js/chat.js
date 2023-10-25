const modalChat = document.getElementById('modalChat');
const btnChatClose = document.getElementById('btnChatClose');

function chat(id){    
    modalChat.showModal();
}

btnChatClose.addEventListener('click', function(){
    modalChat.close();
    document.getElementsByClassName('modal-big-body').value = "";
})