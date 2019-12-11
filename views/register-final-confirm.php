<div id="register-fconfirm-wrapper">
    <form action="/ajax/register_final_confirm_handler" method="post" id="register-fconfirm-form">
        <section class="authorizate-section">
            <input type="text" name="CONFIRMATION_CODE" value="<?=( isset($confirmationCode) ? $confirmationCode : '' );?>" class="authorizate-input require-input"/>
        </section>
        <section class="authorizate-section">
            <button type="submit" class="submit-buttons half-width">
                <span><?=GetMessage('CONFIRMATION_CODE_BUTTON');?></span>
                <div class="animate-band"></div>
            </button>
            <div class="data-loader register-handler-loader"></div>
        </section>
    </form>
</div>

<script type="text/javascript">
    
    window.onclick = function()
    {
        return false;
    };
    
    function OnDOMContentLoaded()
    {
        window.onclick = null;
        
        setPlaceholderToInput(document.getElementsByName('CONFIRMATION_CODE')[0], '<?=GetMessage('CONFIRMATION_CODE');?>', 'rgba(0, 0, 0, 0.7)');
        
        let langMessageList = JSON.parse('<?=GetMessageList();?>');
        
        let registerFconfirmForm = document.getElementById('register-fconfirm-form'); 
        let registerFconfirmFormParams =
        {
            'CONFIRMATION_CODE':
            {
                minSymbolLength: 32,
                maxSymbolLength: 32,
                placeHolder: '<?=GetMessage('CONFIRMATION_CODE');?>'
            }
        };

        let registerFconfirmFormValidator = new Validator(registerFconfirmForm, 'require-input', 'error-input', 'success-input', registerFconfirmFormParams, langMessageList);
        
        registerFconfirmForm.onsubmit = function()
        {
            let thisForm = this;
            let errorNotifies = thisForm.querySelectorAll('.error-input');

            // remove found elements and form error checking

            removeNodes(errorNotifies);
            registerFconfirmFormValidator.checkInputs();

            errorNotifies = thisForm.querySelectorAll('.error-input');

            if(errorNotifies[0] !== undefined)
            {
                return false;
            }
            
            let data = new FormData(thisForm);
            
            let oSuccess =
            {
                thisForm: thisForm,
                loader: document.getElementsByClassName('register-handler-loader')[0],
                registerFconfirmFormValidator: registerFconfirmFormValidator,
                success: function()
                {
                    var responseData = JSON.parse(this.xhr.responseText);

                    if(responseData.ERROR_FIELDS !== undefined)
                    {
                        for(let ef in responseData.ERROR_FIELDS)
                        {
                            this.registerFconfirmFormValidator.generateNotify(document.getElementsByName(ef)[0], responseData.ERROR_FIELDS[ef].ERROR_MESSAGE, 'error', '25%');
                        }
                    }
                    else if(responseData.ERROR_CONFIRMATION_CODE !== undefined)
                    {
                        this.registerFconfirmFormValidator.generateNotify(document.getElementsByName('CONFIRMATION_CODE')[0], langMessageList.ERROR_CONFIRMATION_CODE, 'error', '25%');
                    }
                    else if(responseData.REGISTER_CONFIRMED !== undefined)
                    {
                        this.registerFconfirmFormValidator.generateNotify(document.getElementsByName('CONFIRMATION_CODE')[0], langMessageList.REGISTER_CONFIRMED, 'error', '25%');
                    }
                    else
                    {
                        if(responseData.REGISTER_SUCCESS !== undefined)
                        {
                            location.assign('/?REGISTER_RESPONSE=1');
                        }
                        else
                        {
                            location.assign('/?REGISTER_RESPONSE=0');
                        }
                    }

                    this.loader.style.display = 'none';
                }
            }

            uploadAndSendData(thisForm.getAttribute('action'), data, oSuccess);
            
            return false;
        };
    }
    
    if(window.addEventListener !== undefined)
    {
        window.addEventListener('load', OnDOMContentLoaded);
    }
    else
    {
        window.attachEvent('onload', OnDOMContentLoaded);
    }
</script>