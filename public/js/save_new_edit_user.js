const btnSaveUser = document.getElementById('btn-save-user');
const urlSaveNewEditUser = '../manager/UserManager.php';

btnSaveUser.addEventListener('click', function(){
    if(!validForm()){
        alert('Preencha todos os campos do formulário!');
        return false;
    }

    if(!validPassword()){
        alert('Confirme a senha novamente!');
        return false;
    }

    let dataForm = {};
    if(document.getElementById('id-user-edit') && document.getElementById('id-user-edit').value != ""){
        dataForm = {
            name     : document.getElementById('input-nome').value,
            email    : document.getElementById('input-email').value,
            student  : document.getElementById('input-aluno').value,
            password : document.getElementById('input-senha').value,
            id       : document.getElementById('id-user-edit').value,
            action   : 'editUser'
        }
    }else{
        dataForm = {
            name     : document.getElementById('input-nome').value,
            email    : document.getElementById('input-email').value,
            student  : document.getElementById('input-aluno').value,
            password : document.getElementById('input-senha').value,
            action   : 'newUser'
        }
    }

    const options = {
        method  : 'POST',
        headers : {
            'Content-Type' : 'application/json'
        },
        body : JSON.stringify(dataForm) // Converte dados em JSON
    }

    fetch(urlSaveNewEditUser, options)
    .then(response => {
        if(!response.ok){
            throw new Error('Erro na solicitação POST');
        }
        return response.json();
    })
    .then(data => {

        if(data.success == 1 && data.warning == 0 && data.error == 0){
            
            // atualiza a tabela de usuers.
            const urlTableUsers = '../manager/UserManager.php?action=listUsers';

            fetch(urlTableUsers)
            .then(response => {
                if(!response.ok){
                    throw new Error('Erro na solicitação GET');
                }
                return response.json();
            })
            .then(data => {
                if(document.getElementById('tbody-users')){
                    document.getElementById('tbody-users').innerHTML = data.listUsers;
                }
            })
            .catch(error => {
                console.log('Erro:', error);
            })

            // Atualizar o campo total de usuário do dashboard
            const urlCardUserDashboard = '../manager/UserManager.php';

            // total usuarios
            fetch(urlCardUserDashboard)
            .then(response => {
            if(!response.ok){
                throw new Error('Erro na solicitação GET');
            }
            return response.json();// Se você espera uma resposta JSON
            })
            .then(data => {

            if(document.getElementById('qnt-usuario')){
                document.getElementById('qnt-usuario').textContent = data.totalUsers;
            }
            })
            .catch(error => {
                console.log('Erro:', error);
            });
                        
            document.getElementById('modalNewUser').close(); // fecha modal

            // limpa formulário
            document.getElementById('input-nome').value = '';
            document.getElementById('input-email').value = '';
            document.getElementById('input-senha').value = '';
            document.getElementById('input-confirme-senha').value = '';

            // Se for edit deve remover o id apos update
            if(document.getElementById('id-user-edit')){
                document.getElementById('id-user-edit').value = "";
            }

            // 
            alert(data.message);

        } else if(data.success == 0 && data.warning == 1 && data.error == 0 && data.message != '') {
            alert(data.message);
        } else if(data.success == 0 && data.warning == 0 && data.error == 1 && data.message != '') {
            alert(data.message);
        }


    })
    .catch(error => {
        console.error('Erro:', error);
    });

})

function validForm(){

    if(document.getElementById('input-nome').value == ""){
        return false;
    }
    if(document.getElementById('input-email').value == ""){
        return false;
    }
    if(document.getElementById('input-aluno').value == ""){
        return false;
    }
    if(document.getElementById('input-senha').value == ""){
        return false;
    }
    if(document.getElementById('input-confirme-senha').value == ""){
        return false;
    }

    return true;
}

function validPassword()
{
    if(document.getElementById('input-senha') && document.getElementById('input-confirme-senha'))
    {
        if(document.getElementById('input-senha').value != document.getElementById('input-confirme-senha').value)
        {
            return false;
        }
    }

    return true;
}