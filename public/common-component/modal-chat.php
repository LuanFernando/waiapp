<dialog id="modalChat" class="modal-big">
    <div class="modal-big-header">
        <div class="modal-big-header-title">
            <h2>Chat</h2>
        </div>
        <div class="modal-big-header-actions">
            <!-- <button type="button" class="" id="">Button 1</button> -->
            <button type="button" id="btnChatClose" class="btn-close">Fechar</button>
        </div>
    </div>
    <div class="modal-big-body">
        <div class="modal-chat-message" id="modal-chat-message">

        </div>
        <div class="modal-chat-action">
            <div class="modal-chat-input">
                <input type="hidden" name="id-destino" id="id-destino" value="">
                <textarea name="chat-message-input" id="chat-message-input" cols="80" rows="4" oninput="checkInput()"></textarea>
            </div>
            <div class="action-chat">
                <a href="#" class="btnSendMessage" id="btnSendMessage" onclick="return validateInput()">Enviar</a>
                <a href="#" class="btnSendLikeMessage" id="btnSendLikeMessage">Like</a>
                <a href="#" class="btnSendDesLikeMessage" id="btnSendDesLikeMessage">Deslike</a>
            </div>
        </div>
    </div>
    <div class="modal-big-footer"> </div>
</dialog>

<!-- JS -->