
const urlCardUserDashboard = '../../manager/UserManager.php?action=quantResumoUsuario';

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