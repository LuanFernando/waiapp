<dialog id="modalGerarMensalidade">
    <div class="modal-gerarmensalidade-content">
        <div class="modal-gerarmensalidade-title">
            <p>Informe os valores nos campos abaixo:</p>
        </div>
        <div class="modal-gerarmensalidade-body">
            <div class="modal-gerar-mensalidade-form">
                <label for="">Número de Mensalidade:</label>
                <input type="number" id="numMensalidadeGerar" name="numMensalidadeGerar" min="1" max="12" value="">
            </div>
            <div class="modal-gerar-mensalidade-form">
                <label for="">Valor da Mensalidade: (R$)</label>
                <input type="text" id="valorMensalidadeGerar" name="valorMensalidadeGerar" value="0,00">
            </div>
            <div class="modal-gerar-mensalidade-form">
                <label for="">Data do Vencimento(Data base):</label>
                <input type="datetime-local" name="dataVencimentoMensalidadeGerar" id="dataVencimentoMensalidadeGerar">
            </div>
        </div>
        <div class="modal-gerarmensalidade-actions">
            <button type="button" id="btnGerarMensalidadeGerar" class="btn-Gerar">Gerar Mensalidade</button>
            <button type="button" id="btnGerarMensalidadeCancelar" class="btn-Cancelar">Cancelar</button>
        </div>
    </div>
</dialog>