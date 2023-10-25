
const btnLoggoff = document.getElementById('loggoff');
const modalLoggoff = document.getElementById('modal-loggoff');
const btnLoggoffYes = document.getElementById('btnLoggoffYes');
const btnLoggoffNo = document.getElementById('btnLoggoffNo');

btnLoggoff.addEventListener('click', function() {
    modalLoggoff.showModal();
})

btnLoggoffYes.addEventListener('click' ,function() {
    window.location.replace('/auth.php?action=loggoff');
})

btnLoggoffNo.addEventListener('click',function(){
    modalLoggoff.close();
})
