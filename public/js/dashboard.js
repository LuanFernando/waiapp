
const urlCardUserDashboard = '../manager/UserManager.php';
const urlCardDietasDashboard = '../manager/DietManager.php';
const urlCardTreinosDashboard = '../manager/TrainingManager.php';
const urlCardProdutosDashboard = '../manager/ProductManager.php';

beforeSendFunction('show');

// total usuarios
fetch(urlCardUserDashboard)
.then(response => {
    if(!response.ok){
        throw new Error('Erro na solicitação GET');
    }
    return response.json();// Se você espera uma resposta JSON
})
.then(data => {

    beforeSendFunction('hide');
    
    if(document.getElementById('qnt-usuario')){
        document.getElementById('qnt-usuario').textContent = data.totalUsers;
    }
})
.catch(error => {
    console.log('Erro:', error);
});

