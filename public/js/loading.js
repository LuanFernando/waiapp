function beforeSendFunction(action) {
    if(action == 'show'){
        if(document.getElementById('modal-users-resumo')){
            document.getElementById('gif-loading').innerHTML = "<img src='../../img/trabalho-em-progresso.gif' style='width: 60px;border-radius: 30px;display: flex;align-content: center;justify-content: center;align-items: center;box-shadow: rgba(0, 0, 0, 0.35) 0px 5px 15px;'>";
        } else {
            document.getElementById('gif-loading').innerHTML = "<img src='../img/trabalho-em-progresso.gif' style='width: 60px;border-radius: 30px;display: flex;align-content: center;justify-content: center;align-items: center;box-shadow: rgba(0, 0, 0, 0.35) 0px 5px 15px;'>";
        }
        document.getElementById('modal-loading').showModal();
    } else if(action == 'hide'){
        if(document.getElementById('modal-users-resumo')){
            document.getElementById('gif-loading').innerHTML = "";
        } else {
            document.getElementById('gif-loading').innerHTML = "";
        }
        document.getElementById('modal-loading').close();
    }
}