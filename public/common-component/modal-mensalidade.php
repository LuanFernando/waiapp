<dialog id="modalMensalidade" class="modal-big">
    <div class="modal-big-header">
        <div class="modal-big-header-title">
            <h2>Mensalidade</h2>
            <div class="alerta-pendencia" id="alerta-pendencia" >

            </div>
        </div>
        <div class="modal-big-header-actions">

            <input type="hidden" name="idAlunoMensalidade" id="idAlunoMensalidade" value="">

            <div class="divGerar">
                <button type="button" id="btnGerarMensalidade">Gerar Mensalidade</button>
            </div>

            <div class="divPagarTodas">
                <button type="button" id="btnPagarTodas">Pagar Todas</button>
            </div>

            <div class="divCancelarTodas">
                <button type="button" id="btnCancelarTodas">Cancelar Todas</button>
            </div>

            <div class="divSelectYear">
                <label for="">ANO</label>
                <select class="selectYear" id="selectYearMensal">
                </select>
            </div>

            <button type="button" id="btnMensalidadeClose" class="btn-close">Fechar</button>
        </div>
    </div>
    <div class="modal-big-body">
        <div class="lengenda-valores-mensalidades">
            <div class="legenda-total">
                <strong>Total</strong>
                <p>últimos anos</p>
            </div>
            <div class="item-legenda">
                <label for="">Pago(R$)</label>
                <strong id="strongPago">0,00</strong>
            </div>
            <div class="item-legenda">
                <label for="">Pendente(R$)</label>
                <strong id="strongPendente">0,00</strong>
            </div>
            <div class="item-legenda">
                <label for="">Desconto(R$)</label>
                <strong id="strongDesconto">0,00</strong>
            </div>
        </div>

        <div class="table-mensalidade" id="divTable-mensalidade">

        </div>
    </div>
    <div class="modal-big-footer"> </div>
</dialog>

<!-- JS -->