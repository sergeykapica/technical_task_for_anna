<?if(isset($registerResponse)):?>
    <?if($registerResponse == 1):?>
        <div class="register-response-notify register-confirmed">
            <div class="response-notify-icon register-confirmed-icon"></div>
            <p class="respnse-notify-text"><?=GetMessage('REGISTER_RESPONSE_SUCCESS');?></p>
        </div>
    <?else:?>
        <div class="register-response-notify register-unconfirmed">
            <div class="response-notify-icon register-unconfirmed-icon"></div>
            <p class="respnse-notify-text"><?=GetMessage('REGISTER_RESPONSE_FAILED');?></p>
        </div>
    <?endif;?>
<?endif;?>
