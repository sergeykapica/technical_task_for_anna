<form action="/ajax/register_confirm" method="post" id="register-confirm-form">
    <section class="authorizate-section">
        <textarea name="USER_ABOUT_DESCRIPTION" class="authorizate-input authorizate-textarea require-input"></textarea>
    </section>
    <section class="authorizate-section">
        <button type="submit" class="submit-buttons half-width">
            <span><?=GetMessage('REGISTER_CONTINUE_BUTTON');?></span>
            <div class="animate-band"></div>
        </button>
        <div class="data-loader register-handler-loader"></div>
    </section>
</form>