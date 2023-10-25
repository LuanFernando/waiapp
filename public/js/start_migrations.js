    function startMigrations()
    {
        fetch('migrations.php')
        .then(response => response.text())
        .then(data => {
            document.getElementById('conteudo').style.background ="#606c88";
            document.getElementById('conteudo').innerHTML = data;
        });
    }