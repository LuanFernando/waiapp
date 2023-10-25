<dialog id="modalNewUser" class="modal-big">
    <div class="modal-big-header">
        <div class="modal-big-header-title">
            <h2>Novo Usuário</h2>
        </div>
        <div class="modal-big-header-actions">
            <button type="button" class="btn-new-user" id="btn-save-user">Salvar</button>
            <button type="button" id="btnNewUserClose" class="btn-close">Fechar</button>
        </div>
    </div>
    <div class="modal-big-body">

    <form action="#" method="post" id="formNewUser">

        <input type="hidden" name="id-user-edit" id="id-user-edit" value=""> 

        <div class="row">
            <div class="col-6">
                <div class="form-input">
                    <label for="input-nome">Nome:</label>
                    <input type="text" id="input-nome" name="input-nome">
                </div>
            </div>
    
            <div class="col-6">
                <div class="form-input">
                    <label for="input-email">E-mail:</label>
                    <input type="email" id="input-email" name="input-email">
                </div>
            </div>
    
            <div class="col-6">
                <div class="form-input">
                    <label for="input-aluno">Aluno:</label>
                    <select name="input-aluno" id="input-aluno">
                        <option value="S">Sim</option>
                        <option value="N">Não</option>
                    </select>
                </div>
            </div>
        </div>


        <div class="row">
            <div class="col-6">
                <div class="form-input">
                    <label for="input-senha">Senha:</label>
                    <input type="password" id="input-senha" name="input-senha">
                </div>
            </div>
            
            <div class="col-6">
                <div class="form-input">
                    <label for="input-confirme-senha">Confirme a senha:</label>
                    <input type="password" id="input-confirme-senha" name="input-confirme-senha">
                </div>        
            </div>
        </div>
        
    </form>

    </div>
    <div class="modal-big-footer">
    </div>
</dialog>

<!-- JS -->
<script src="../js/save_new_edit_user.js?v=1.1"></script>