/**
 * Modal resumo de usuarios
 * */ 
const btnModalUsersResumo = document.getElementById('btn-modal-users-resumo');
const modalUsersResumo = document.getElementById('modal-users-resumo');
const btnFecharModalUsersResumo = document.getElementById('btn-fechar-modal-users-resumo');

if(btnModalUsersResumo){
    btnModalUsersResumo.addEventListener('click', function(){
        modalUsersResumo.showModal();
    })
}

if(btnFecharModalUsersResumo){
    btnFecharModalUsersResumo.addEventListener('click', function(){
        modalUsersResumo.close();
    })
}

/**
 * Modal CRUD usuário
 * */ 
const btnCrudUsers = document.getElementById('btnCrudUsers');
const modalCrudUsers = document.getElementById('modalCrudUsers');
const btnCrudUsersClose = document.getElementById('btnCrudUsersClose');

if(btnCrudUsers){
    btnCrudUsers.addEventListener('click', function(){
        modalCrudUsers.showModal();
    });
}

if(btnCrudUsersClose){
    btnCrudUsersClose.addEventListener('click', function(){
        modalCrudUsers.close();
    })
}


const btnNewUser =  document.getElementById('btnNewUser');
const modalNewUser = document.getElementById('modalNewUser');
const btnNewUserClose = document.getElementById('btnNewUserClose');
const btnNewUserSave = document.getElementById('btnNewUserSave');
const btnNewUserUpdate = document.getElementById('btnNewUserUpdate');
const btnNewUserDelete = document.getElementById('btnNewUserDelete');

if(btnNewUser){
    btnNewUser.addEventListener('click', function(){
        modalNewUser.showModal();
    })
}

if(btnNewUserClose){
    btnNewUserClose.addEventListener('click', function(){
        modalNewUser.close();
        clearForm('modalNewUser');
    })
}

if(btnNewUserSave){
    
}

if(btnNewUserUpdate){
    
}

if(btnNewUserDelete){
    
}

/**
 * Final Modal CRUD usuário
 * */ 


/**
 * A função abaixo limpa os dados do formulario
 * @param name
 * */ 
function clearForm(name)
{
    if(name == 'modalNewUser')
    {
        document.getElementById('input-nome').value = '';
        document.getElementById('input-email').value = '';
        document.getElementById('input-senha').value = '';
        document.getElementById('input-confirme-senha').value = '';
    }
}