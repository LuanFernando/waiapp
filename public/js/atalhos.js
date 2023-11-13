document.addEventListener('keydown', function(event){
    switch(event.key){
        case 'F2': 
        // cancela o evento associado a tecla
        event.preventDefault();
            console.log('F2');
        break;
        case 'F3':
            // cancela o evento associado a tecla
            event.preventDefault();
            console.log('F3');
        break;
        case 'F12':
            // cancela o evento associado a tecla
            event.preventDefault();
            console.log('F12');
        break;
        case 'F10':
            // cancela o evento associado a tecla
            event.preventDefault();
            console.log('F10');
        break;
        case 'F8':
            // cancela o evento associado a tecla
            event.preventDefault();
            console.log('F8');
        break;
        case 'F9':
            // cancela o evento associado a tecla
            event.preventDefault();
            console.log('F9');
        break;
        default:
            break;     
    }
})