(function()
{
    function Validator(currentForm, requiredFields, errorClass, doneClass, params, langMessageList)
    {
        this.currentForm = currentForm;
        this.requiredFields = requiredFields;
        this.errorClass = errorClass;
        this.params = params;
        
        var thisOValidator = this;
        
        for(var rf in thisOValidator.currentForm.querySelectorAll('.' + thisOValidator.requiredFields))
        {
            if(isNaN( rf * 1 ) !== true)
            {
                if(thisOValidator.currentForm.querySelectorAll('.' + thisOValidator.requiredFields)[rf].addEventListener)
                {
                    thisOValidator.currentForm.querySelectorAll('.' + thisOValidator.requiredFields)[rf].addEventListener('focus', function()
                    {
                        var currentInput = this;
                        var parendNode = thisOValidator.params[currentInput.getAttribute('name')] !== undefined && thisOValidator.params[currentInput.getAttribute('name')].parentNode !== undefined ? thisOValidator.params[currentInput.getAttribute('name')].parentNode : undefined;
                        
                        if(parendNode === undefined)
                        {
                            parendNode = currentInput.parentNode;
                        }
                        else
                        {
                            while(!currentInput.classList.contains(parendNode))
                            {
                                currentInput = currentInput.parentNode;
                            }

                            parendNode = currentInput;
                        }
                        
                        let errorNotifies = parendNode.querySelectorAll('.' + errorClass);

                        for(let rn in errorNotifies)
                        {
                            if(isNaN( rn * 1 ) !== true)
                            {
                                parendNode.removeChild(errorNotifies[rn]);
                            }
                        }
                    });
                }
                else
                {
                    thisOValidator.currentForm.querySelectorAll('.' + thisOValidator.requiredFields)[rf].attachEvent('onfocus', function()
                    {
                        var currentInput = this;
                        var parendNode = thisOValidator.params[currentInput.getAttribute('name')].parentNode;
                        
                        if(parendNode === undefined)
                        {
                            parendNode = currentInput.parentNode;
                        }
                        else
                        {
                            while(!currentInput.classList.contains(parendNode))
                            {
                                currentInput = currentInput.parentNode;
                            }

                            parendNode = currentInput;
                        }
                        
                        let errorNotifies = parendNode.querySelectorAll('.' + errorClass);

                        for(let rn in errorNotifies)
                        {
                            if(isNaN( rn * 1 ) !== true)
                            {
                                parendNode.removeChild(errorNotifies[rn]);
                            }
                        }
                    });
                }
            }
        }
        
        this.checkInputs = function()
        {
            for(let p in thisOValidator.params)
            {
                var currentInput = thisOValidator.currentForm.querySelectorAll('.' + thisOValidator.requiredFields + '[name=' + p + ']')[0];
                var currentParams = params[p];

                for(let param in currentParams)
                {
                    if(param == 'placeHolder' && currentParams[param] == currentInput.value)
                    {
                        thisOValidator.generateNotify(currentInput, currentParams[param], 'error');
                        break;
                    }
                    else if(param == 'minSymbolLength' && currentInput.value.length < currentParams[param])
                    {
                        thisOValidator.generateNotify(currentInput, langMessageList.VALIDATOR_MIN_SYMBOLS + ' ' + currentParams[param], 'error');
                        break;
                    }
                    else if(param == 'maxSymbolLength' && currentInput.value.length > currentParams[param])
                    {
                        thisOValidator.generateNotify(currentInput, langMessageList.VALIDATOR_MAX_SYMBOLS + ' ' + currentParams[param], 'error');
                        break;
                    }
                    else if(param == 'isDateFormat' && !/^\d{2}\/\d{2}\/\d{4}$/i.test(currentInput.value))
                    {
                        thisOValidator.generateNotify(currentInput, langMessageList.VALIDATOR_NOT_DATE_FORMAT, 'error');
                        break;
                    }
                    else if(param == 'isEmailFormat' && !/.+@.+?\..+/i.test(currentInput.value))
                    {
                        thisOValidator.generateNotify(currentInput, langMessageList.VALIDATOR_NOT_EMAIL_FORMAT, 'error');
                        break;
                    }
                    else if(param == 'conformityPassword' && currentInput.value != '' && currentInput.value != currentParams[param])
                    {
                        thisOValidator.generateNotify(currentInput, langMessageList.VALIDATOR_PASSWORD_UNCONFORMITY, 'error');
                        break;
                    }
                    else if(param == 'isInicials' && !/^[a-zA-Zа-яА-Я]+\s[a-zA-Zа-яА-Я]+$/i.test(currentInput.value))
                    {
                        thisOValidator.generateNotify(currentInput, langMessageList.VALIDATOR_NOT_CONTAINS_INICIALS, 'error');
                        break;
                    }
                    else if(param == 'isExistence' && currentParams[param] == 'login' || currentParams[param] == 'email')
                    {
                        if(currentParams[param] == 'login')
                        {
                            uploadAndSendData('/ajax/check_existence_data?LOGIN=' + currentInput.value, '', {
                                currentInput: currentInput,
                                thisOValidator: thisOValidator,
                                langMessageList: langMessageList,
                                loader: currentParams.loader,
                                success: function()
                                {
                                    if(this.xhr.responseText == true)
                                    {
                                        this.thisOValidator.generateNotify(this.currentInput, this.langMessageList.VALIDATOR_LOGIN_EXISTENCE, 'error');
                                    }

                                    this.loader.style.display = 'none';
                                }
                            }, 'GET');
                        }
                        else
                        {
                            uploadAndSendData('/ajax/check_existence_data?EMAIL=' + currentInput.value, '', {
                                currentInput: currentInput,
                                thisOValidator: thisOValidator,
                                langMessageList: langMessageList,
                                loader: currentParams.loader,
                                success: function()
                                {
                                    if(this.xhr.responseText == true)
                                    {
                                        this.thisOValidator.generateNotify(this.currentInput, this.langMessageList.VALIDATOR_EMAIL_EXISTENCE, 'error');
                                    }

                                    this.loader.style.display = 'none';

                                    if(this.thisOValidator.lastAction !== undefined)
                                    {
                                        this.thisOValidator.lastAction();
                                    }
                                }
                            }, 'GET');
                        }
                    }
                }
            }
        };
        
        this.generateNotify = function(currentInput, messageText, type, right = '0px')
        {
            if(type === 'error')
            {
                var messageElementWrapper = document.createElement('div');
                let message =
                `
                <div class="error-icon"></div>
                <span>` + messageText + `</span>
                `;
                
                messageElementWrapper.innerHTML = message;
                messageElementWrapper.style.top = currentInput.offsetTop + 'px';
                messageElementWrapper.className = 'error-input';
            }
            else
            {
                var messageElementWrapper = document.createElement('div');
                let message =
                `
                <div class="success-icon"></div>
                <span>` + messageText + `</span>
                `;
                
                messageElementWrapper.innerHTML = message;
                messageElementWrapper.style.top = currentInput.offsetTop + 'px';
                messageElementWrapper.className = 'success-input';
            }
            
            var parendNode = thisOValidator.params[currentInput.getAttribute('name')] !== undefined && thisOValidator.params[currentInput.getAttribute('name')].parentNode !== undefined ? thisOValidator.params[currentInput.getAttribute('name')].parentNode : undefined;
            
            if(parendNode === undefined)
            {
                currentInput.parentNode.appendChild(messageElementWrapper);
            }
            else
            {
                while(!currentInput.classList.contains(parendNode))
                {
                    currentInput = currentInput.parentNode;
                }
                      
                currentInput.appendChild(messageElementWrapper);
            }
            
            setTimeout(function()
            {
                messageElementWrapper.style.right = right;
            }, 10);
        }
    }
    
    window.Validator = Validator;
})();