
let urlDeleteUser = "";
if(document.getElementById('modal-users-resumo')){
    urlDeleteUser =  "../../manager/UserManager.php";
}else{
    urlDeleteUser =  "../manager/UserManager.php";
}

let urlEditUser   =  "";
if(document.getElementById('modal-users-resumo')){
    urlEditUser = "../../manager/UserManager.php";
}else{  
    urlEditUser = "../manager/UserManager.php";
}

const modalDeleteUser = document.getElementById('modal-delete-user');
const btnDeleteUserYes = document.getElementById('btnDeleteUserYes');
const btnDeleteUserNo  = document.getElementById('btnDeleteUserNo');

function confirmDeleteUser(id)
{
    beforeSendFunction('show');
    if(id == 0 || id == "" || id == undefined || id == null)
    {
        alert('Não foi possivel identificar o ID do usuário!');
        return false;
    }

    if(document.getElementById('id-users-delete')){
        document.getElementById('id-users-delete').value = id;
    }

    modalDeleteUser.showModal();
    beforeSendFunction('hide');
}

btnDeleteUserYes.addEventListener('click', function(){
    deleteUser();
})

btnDeleteUserNo.addEventListener('click', function(){
    
    // limpa id user delete
    if(document.getElementById('id-users-delete')){
        document.getElementById('id-users-delete').value = "";
    }

    modalDeleteUser.close();
    
})

function deleteUser()
{
    var id = 0;

    if(document.getElementById('id-users-delete'))
    {
        id = document.getElementById('id-users-delete').value;
    }
    
    if(id == 0 || id == "" || id == undefined || id == null)
    {
        alert('Não foi possivel identificar o ID do usuário!');
        return false;
    }

    beforeSendFunction('show');

    fetch(urlDeleteUser+'?action=delete&id='+id)
    .then(response => {
        if(!response.ok){
            throw new Error ('Erro na solicitação GET');
        }
        return response.json();
    })
    .then(data => {
        
        beforeSendFunction('hide');
        if(data.success == 1 && data.warning == 0 && data.error == 0){
            
            // atualiza a tabela de usuers.
            let urlTableUsers = '../manager/UserManager.php?action=listUsers';

            if(document.getElementById('modal-users-resumo')){
                urlTableUsers =  '../../manager/UserManager.php?action=listUsersCurrent';
            }

            fetch(urlTableUsers)
            .then(response => {
                if(!response.ok){
                    throw new Error('Erro na solicitação GET');
                }
                return response.json();
            })
            .then(data => {
                console.log('Responsta da solicitação ', data);
                if(document.getElementById('tbody-users')){
                    document.getElementById('tbody-users').innerHTML = data.listUsers;
                }
            })
            .catch(error => {
                console.log('Erro:', error);
            })

            // Atualizar o campo total de usuário do dashboard
            let urlCardUserDashboard = '../manager/UserManager.php';

            if(document.getElementById('modal-users-resumo')){
                urlCardUserDashboard =  '../../manager/UserManager.php?action=quantResumoUsuario';
            }

            // total usuarios
            fetch(urlCardUserDashboard)
            .then(response => {
            if(!response.ok){
                throw new Error('Erro na solicitação GET');
            }
            return response.json();// Se você espera uma resposta JSON
            })
            .then(data => {
                console.log('Resposta da solicitação GET:', data);

            if(document.getElementById('qnt-usuario')){
                document.getElementById('qnt-usuario').textContent = data.totalUsers;
            }
            })
            .catch(error => {
                console.log('Erro:', error);
            });
                        
            // 
            alert(data.message);

        } else if(data.success == 0 && data.warning == 1 && data.error == 0 && data.message != '') {
            alert(data.message);
        } else if(data.success == 0 && data.warning == 0 && data.error == 1 && data.message != '') {
            alert(data.message);
        }

    })
    .catch(error => {
        console.log('Erro:'+ error);
    })

    // fecha a modal de delete user
    modalDeleteUser.close();
}

function editUser(id)
{
    if(id == 0 || id == "" || id == undefined || id == null)
    {
        alert('Não foi possivel identificar o ID do usuário!');
        return false;
    }

    document.getElementById('id-user-edit').value = id;

    beforeSendFunction('show');

    // faz a requisição - abre o formulario
    fetch(urlEditUser+"?action=editUser&id="+id)
    .then(response => {
        if(!response.ok){
            throw new Error('Erro na solicitação GET');
        }
        return response.json();
    })
    .then(data => {
        console.log(data);

        beforeSendFunction('hide');

        if(data.success == 1 && data.name != ''){

            if(document.getElementById('input-nome')){
                document.getElementById('input-nome').value = data.name;
            }

            if(document.getElementById('input-email')){ 
                document.getElementById('input-email').value = data.email;
            }

            if(document.getElementById('input-aluno')){
                document.getElementById('input-aluno').value = data.student;
            }

            // Abre o formulario
            document.getElementById('modalNewUser').showModal();

        } else if(data.error == 1 && data.message != null){
            alert(data.message);
            return false;
        } else if(data.warning == 1 && data.message != null){
            alert(data.message);
            return false;
        }

    })
    .then(error => {
        console.log(error);
    })

}