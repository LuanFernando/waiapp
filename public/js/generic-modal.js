
const genericModalMedia = document.getElementById('genericModalMedia');
const largeGenericModal = document.getElementById('largeGenericModal');
const btnLargeGenericModalClose = document.getElementById('btnLargeGenericModalClose');
const btnGenericModalMediaClose = document.getElementById('btnGenericModalMediaClose');

function createLargeGenericModal(title, pathHtml, listHiddenFields, callback){

    $("#bodyLargeGenericModal").load(pathHtml, function(response, status, xhr){

        if(status == "error"){
            alert('Erro durante o carregamento:', xhr.status, xhr.statusText);
        } else {
            // Este código será executado após o carregamento completo do HTML
            document.getElementById("titleLargeGenericModal").innerHTML = title.toString();
    
            // Verifica e cria os campos ocultos de forma dinamica.
            if(listHiddenFields && Object.keys(listHiddenFields).length > 0){
                for (var chave in listHiddenFields) {
                    if(listHiddenFields.hasOwnProperty(chave)){
                        //cria um elemento inpt hidden
                        var inputHidden = document.createElement("input");

                        // define os atributos do input
                        inputHidden.type  = "hidden";
                        inputHidden.name  = chave;
                        inputHidden.id    = chave;
                        inputHidden.value = listHiddenFields[chave];
                        document.getElementById("bodyGenericModalMediaModal").appendChild(inputHidden);
                    }
                }
            }

            // Apos carregar todo o conteudo na modal generica abre a modal.
            largeGenericModal.showModal();

            // executa a função
            if(callback != null){
                callback();
            }
        }
    });
        
}

function createGenericModalMedia(title, pathHtml, listHiddenFields, callback){

    $("#bodyGenericModalMediaModal").load(pathHtml, function(response, status, xhr){
        if(status == "error"){
            alert('Erro durante o carregamento:', xhr.status, xhr.statusText);
        } else {
            // Este código será executado após o carregamento completo do HTML
            document.getElementById("titleGenericModalMediaModal").innerHTML = title.toString();
    
            // Verifica e cria os campos ocultos de forma dinamica.
            if(listHiddenFields && Object.keys(listHiddenFields).length > 0){
                for (var chave in listHiddenFields) {
                    if(listHiddenFields.hasOwnProperty(chave)){
                        //cria um elemento inpt hidden
                        var inputHidden = document.createElement("input");

                        // define os atributos do input
                        inputHidden.type  = "hidden";
                        inputHidden.name  = chave;
                        inputHidden.id    = chave;
                        inputHidden.value = listHiddenFields[chave];
                        document.getElementById("bodyGenericModalMediaModal").appendChild(inputHidden);
                    }
                }
            }

            // Apos carregar todo o conteudo na modal generica abre a modal.
            genericModalMedia.showModal();

            // executa a função
            if(callback != null){
                callback();
            }
        }
    });

}

btnLargeGenericModalClose.addEventListener('click', function(){
    largeGenericModal.close();
})

btnGenericModalMediaClose.addEventListener('click', function(){
    genericModalMedia.close();
})