<dialog id="modal-users-resumo" class="modal-big">
    <div class="modal-big-header">
        <div class="modal-big-header-title">
            <h2>Usuários Cadastrados hoje.</h2>
        </div>
        <div class="modal-big-header-actions">
            <button type="button" id="btn-fechar-modal-users-resumo" class="btn-close">Fechar</button>
            <button type="button" class="btn-info">Info</button>
        </div>
    </div>
    <div class="modal-big-body">
        <table class="table">
            <thead>
                <tr>
                    <th width="6%" >Id</th>
                    <th width="12%">Nome</th>
                    <th width="6%" >Aluno</th>
                    <th width="6%" >Criado</th>
                    <th width="6%" >Atualizado</th>
                    <th width="6%" >Deletado</th>
                    <th width="30%" >Opções</th>
                </tr>
            </thead>
            <tbody id="tbody-users">
           </tbody>
        </table>
    </div>
    <div class="modal-big-footer">
    </div>
</dialog>

<!--  -->
<?php require('../../common-component/modal-chat.php'); ?>
<?php require('../../common-component/modal-mensalidade.php'); ?>

<!-- JS -->
<script src="../../js/table_users.js?v=1.1"></script>
<script src="../../js/delete_and_edit_users.js?v=1.1"></script>
<script src="../../js/chat.js?v=1.1"></script>
<script src="../../js/mensalidade.js?v=1.1"></script>