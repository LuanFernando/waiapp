const urlTableUsers = '../manager/UserManager.php?action=listUsers';
const urlTableUsersCurrent = '../../manager/UserManager.php?action=listUsersCurrent';

if(document.getElementById('modal-users-resumo')){
    
    console.log('here')
    fetch(urlTableUsersCurrent)
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

} else if(document.getElementById('modalCrudUsers')){

    console.log('aqui')
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

}
