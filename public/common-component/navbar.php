<?php $pagina_atual = $_SERVER['REQUEST_URI']; // Resgata a página atual antes de carregar informações obrigatorias de cada pagina  ?>

<?php
    include_once('modal-loggoff.php');

    // Só incluirá o modal-delete-user , nas páginas de dahboard, resumo
    if(strpos($pagina_atual, 'dashboard') !== false && !strpos($pagina_atual, 'configuracoes') !== false && !strpos($pagina_atual, 'resumo') !== false){
        include_once('modal-delete-user.php');
    }
    else if(strpos($pagina_atual, 'dashboard') !== false && strpos($pagina_atual, 'resumo') !== false){
        include_once('modal-delete-user.php');
    }
    
?>
    

<nav class="navbar">
    <h3><?php echo $nameApp; ?></h3>
    <ul>
        <li><a href="/dashboard">Dashboard</a></li>
        <li><a href="/dashboard/configuracoes">Configurações</a></li>

        <?php 
        // O caminho da store, muda de acordo com  a pagina atual.
        if(strpos($pagina_atual, 'dashboard') !== false && !strpos($pagina_atual, 'configuracoes') !== false && !strpos($pagina_atual, 'resumo') !== false){ ?>
            <li><a href="../store" target="_blank">Loja</a></li>
        <?php } elseif(strpos($pagina_atual, 'dashboard') !== false && strpos($pagina_atual, 'configuracoes') !== false && !strpos($pagina_atual, 'resumo') !== false) { ?>

            <li><a href="../../store" target="_blank">Loja</a></li>
        <?php } elseif(strpos($pagina_atual, 'dashboard') !== false && strpos($pagina_atual, 'resumo') !== false) { ?>

            <li><a href="../../store" target="_blank">Loja</a></li>
        <?php } ?>

        <li><a href="/dashboard/resumo">Resumo</a></li>
        <li><a href="#" id="loggoff">Sair</a></li>
    </ul>
</nav>


<?php if(strpos($pagina_atual, 'dashboard') !== false && !strpos($pagina_atual, 'configuracoes') !== false && !strpos($pagina_atual, 'resumo') !== false){ ?>

    <label class="info-pagina-atual"><?= $pagina_atual; ?></label>
    <script src="../js/loggoff.js?v=1.4"></script>

<?php } elseif(strpos($pagina_atual, 'dashboard') !== false && strpos($pagina_atual, 'configuracoes') !== false && !strpos($pagina_atual, 'resumo') !== false) { ?>

    <label class="info-pagina-atual"><?= $pagina_atual; ?></label>
    <script src="../../js/loggoff.js?v=1.5"></script>
    
<?php } elseif(strpos($pagina_atual, 'dashboard') !== false && strpos($pagina_atual, 'resumo') !== false) { ?>
    
    <label class="info-pagina-atual"><?= $pagina_atual; ?></label>
    <script src="../../js/loggoff.js?v=1.6"></script>
    
<?php } else { ?>
    <label class="info-pagina-atual"><?= $pagina_atual; ?></label>

<?php } ?>

