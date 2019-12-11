            </div>
        
            <?if(!isset($userAuthorized)):?>
                <div class="authorizate-container opacity-fade-out">
                    <div class="authorizate-forms-container">
                        <div>
                            <button class="authorizate-buttons enter-button"><?=GetMessage('LOGIN_TITLE');?></button>
                            <div class="authorizate-form-container login">
                                <form action="/ajax/login_handler" method="post" id="login-form" class="authorizate-forms">
                                    <section class="authorizate-section">
                                        <input type="text" name="USER_LOGIN" class="authorizate-input require-input"/>
                                    </section>
                                    <section class="authorizate-section">
                                        <input type="password" name="USER_PASSWORD" class="authorizate-input require-input" autocomplete="off"/>
                                    </section>
                                    <section class="authorizate-section">
                                        <div class="captcha-image-wrapper">
                                            <img src="/get_captcha_image" class="authorizate-captcha"/>
                                            <div class="data-loader login-captcha-loader"></div>
                                            <div class="captcha-image-background"></div>
                                        </div>
                                        <input type="text" name="CAPTCHA_CODE" class="authorizate-input require-input" autocomplete="off"/>
                                    </section>
                                    <section class="authorizate-section">
                                        <button type="submit" class="submit-buttons half-width">
                                            <span><?=GetMessage('LOGIN_BUTTON_TITLE');?></span>
                                            <div class="animate-band"></div>
                                        </button>
                                        <div class="data-loader login-handler-loader"></div>
                                    </section>
                                </form>
                            </div>
                        </div>
                        <div>
                            <button class="authorizate-buttons register-button"><?=GetMessage('REGISTER_TITLE');?></button>
                            <div class="authorizate-form-container register">
                                <form action="/ajax/register_handler" method="post" id="register-form" class="authorizate-forms">
                                    <section class="authorizate-section">
                                        <input type="text" name="USER_REGISTER_LOGIN" class="authorizate-input require-input"/>
                                        <div class="data-loader existence-data-loader" id="login-existence-loader"></div>
                                    </section>
                                    <section class="authorizate-section">
                                        <input type="text" name="USER_REGISTER_NAME" class="authorizate-input require-input"/>
                                    </section>
                                    <section class="authorizate-section">
                                        <input type="text" name="USER_REGISTER_LAST_NAME" class="authorizate-input require-input"/>
                                    </section>
                                    <section class="authorizate-section">
                                        <input type="text" name="USER_REGISTER_BIRTHDATE" class="authorizate-input require-input"/>
                                        <i class="authorizate-input-detail"><?=GetMessage('USER_REGISTER_BIRTHDATE_DETAIL');?></i>
                                    </section>
                                    <section class="authorizate-section">
                                        <div class="authorizate-input div-input div-select"><?=GetMessage('REGISTER_SELECT_COUNTRY');?></div>
                                        <?if(isset($locationsList)):?>
                                            <ul class="div-select-list">
                                                <?foreach($locationsList['COUNTRY_LIST'] as $countryID => $country):?>
                                                    <li class="div-select-item" data-country-id="<?=$countryID;?>"><?=$country->name;?></li>
                                                <?endforeach;?>
                                            </ul>
                                        <?endif;?>
                                        <input type="hidden" name="USER_REGISTER_COUNTRY" class="authorizate-input require-input select-input"/>
                                    </section>
                                    <section class="authorizate-section">
                                        <div class="authorizate-input div-input div-select"><?=GetMessage('REGISTER_SELECT_CITY');?></div>
                                        <?if(isset($locationsList)):?>
                                            <ul class="div-select-list">
                                                <?foreach($locationsList['CITY_LIST'] as $cityID => $city):?>
                                                    <li class="div-select-item" data-city-id="<?=$cityID;?>"><?=$city->name;?></li>
                                                <?endforeach;?>
                                            </ul>
                                        <?endif;?>
                                        <input type="hidden" name="USER_REGISTER_CITY" class="authorizate-input require-input select-input"/>
                                    </section>
                                    <section class="authorizate-section">
                                        <input type="password" name="USER_REGISTER_PASSWORD" class="authorizate-input require-input" autocomplete="off"/>
                                    </section>
                                    <section class="authorizate-section">
                                        <input type="password" name="USER_REGISTER_CONFIRM_PASSWORD" class="authorizate-input require-input" autocomplete="off"/>
                                    </section>
                                    <section class="authorizate-section">
                                        <input type="text" name="USER_REGISTER_EMAIL" class="authorizate-input require-input"/>
                                        <div class="data-loader existence-data-loader" id="email-existence-loader"></div>
                                    </section>
                                    <section class="authorizate-section">
                                        <label>
                                            <div class="authorizate-input div-input select-file-wrapper">
                                                <div class="authorizate-file-icon"></div>
                                                <div class="select-file-title file-title"><?=GetMessage('REGISTER_SELECT_FILE');?></div>
                                                <div class="select-file-title file-name"></div>
                                            </div>
                                            <input type="file" name="USER_REGISTER_PHOTO" id="user-photo"/>
                                        </label>
                                    </section>
                                    <section class="authorizate-section">
                                        <div class="captcha-image-wrapper">
                                            <img src="/get_captcha_image" class="authorizate-captcha"/>
                                            <div class="data-loader register-captcha-loader"></div>
                                            <div class="captcha-image-background"></div>
                                        </div>
                                        <input type="text" name="CAPTCHA_CODE" class="authorizate-input require-input" autocomplete="off"/>
                                    </section>
                                    <section class="authorizate-section">
                                        <button type="submit" class="submit-buttons half-width">
                                            <span><?=GetMessage('REGISTER_BUTTON_TITLE');?></span>
                                            <div class="animate-band"></div>
                                        </button>
                                        <div class="data-loader register-handler-loader"></div>
                                    </section>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <script type="text/javascript" src="/sources/js/input-placeholder.js"></script>
                <script type="text/javascript" src="/sources/js/animate-methods.js"></script>
                <script type="text/javascript" src="/sources/js/validator.js"></script>
                <script type="text/javascript" src="/sources/js/upload-and-send-data-ajax.js"></script>
                <script type="text/javascript" src="/sources/js/remove-nodes.js"></script>

                <script type="text/javascript">
                    window.onload = function()
                    {
                        // set placeholders for fields

                        setPlaceholderToInput(document.getElementsByName('USER_LOGIN')[0], '<?=GetMessage('ENTER_LOGIN');?>', 'rgba(0, 0, 0, 0.7)');
                        setPlaceholderToInput(document.getElementsByName('USER_PASSWORD')[0], '<?=GetMessage('ENTER_PASSWORD');?>', 'rgba(0, 0, 0, 0.7)');
                        setPlaceholderToInput(document.getElementsByName('CAPTCHA_CODE')[0], '<?=GetMessage('ENTER_CAPTCHA_CODE');?>', 'rgba(0, 0, 0, 0.7)');
                        setPlaceholderToInput(document.getElementsByName('USER_REGISTER_LOGIN')[0], '<?=GetMessage('USER_REGISTER_LOGIN');?>', 'rgba(0, 0, 0, 0.7)');
                        setPlaceholderToInput(document.getElementsByName('USER_REGISTER_NAME')[0], '<?=GetMessage('USER_REGISTER_NAME');?>', 'rgba(0, 0, 0, 0.7)');
                        setPlaceholderToInput(document.getElementsByName('USER_REGISTER_LAST_NAME')[0], '<?=GetMessage('USER_REGISTER_LAST_NAME');?>', 'rgba(0, 0, 0, 0.7)');
                        setPlaceholderToInput(document.getElementsByName('USER_REGISTER_BIRTHDATE')[0], '<?=GetMessage('USER_REGISTER_BIRTHDATE');?>', 'rgba(0, 0, 0, 0.7)');
                        setPlaceholderToInput(document.getElementsByName('USER_REGISTER_COUNTRY')[0], '<?=GetMessage('REGISTER_SELECT_COUNTRY');?>', 'rgba(0, 0, 0, 0.7)');
                        setPlaceholderToInput(document.getElementsByName('USER_REGISTER_CITY')[0], '<?=GetMessage('REGISTER_SELECT_CITY');?>', 'rgba(0, 0, 0, 0.7)');
                        setPlaceholderToInput(document.getElementsByName('USER_REGISTER_PASSWORD')[0], '<?=GetMessage('USER_REGISTER_PASSWORD');?>', 'rgba(0, 0, 0, 0.7)');
                        setPlaceholderToInput(document.getElementsByName('USER_REGISTER_CONFIRM_PASSWORD')[0], '<?=GetMessage('USER_REGISTER_CONFIRM_PASSWORD');?>', 'rgba(0, 0, 0, 0.7)');
                        setPlaceholderToInput(document.getElementsByName('USER_REGISTER_EMAIL')[0], '<?=GetMessage('USER_REGISTER_EMAIL');?>', 'rgba(0, 0, 0, 0.7)');
                        setPlaceholderToInput(document.getElementsByName('CAPTCHA_CODE')[1], '<?=GetMessage('ENTER_CAPTCHA_CODE');?>', 'rgba(0, 0, 0, 0.7)');

                        let authorizateButtons = document.getElementsByClassName('authorizate-buttons');

                        function slideAuthorizateForm()
                        {
                            let thisButton = this;
                            let authorizateContainer = thisButton.parentNode.querySelectorAll('.authorizate-form-container')[0];

                            if(authorizateContainer.slideOpen === undefined)
                            {
                                authorizateContainer.slideOpen = false;
                            }

                            if(authorizateContainer.slideOpen === false)
                            {
                                animate.slideDown(authorizateContainer);

                                thisButton.style.backgroundColor = '#FFC875';
                                authorizateContainer.slideOpen = true;

                                let captchaImage = authorizateContainer.querySelector('.authorizate-captcha');
                                captchaImage.setAttribute('src', captchaImage.getAttribute('src'));

                                let captchaImageWrapper = captchaImage.parentNode;
                                var captchaImageBackground = captchaImageWrapper.querySelector('.captcha-image-background');
                                captchaImageBackground.style.display = 'block';

                                var captchaLoader = captchaImageWrapper.querySelector('.data-loader');
                                captchaLoader.style.display = 'block';

                                captchaImage.onload = function()
                                {
                                    captchaLoader.style.display = 'none';
                                    captchaImageBackground.style.display = 'none';
                                };
                            }
                            else
                            {
                                animate.slideUp(authorizateContainer);

                                thisButton.style.backgroundColor = '';
                                authorizateContainer.slideOpen = false;
                            }
                        }

                        for(let i = 0; i < authorizateButtons.length; i++)
                        {
                            if(authorizateButtons[i].addEventListener)
                            {
                                authorizateButtons[i].addEventListener('click', slideAuthorizateForm);
                            }
                            else
                            {
                                authorizateButtons[i].attachEvent('onclick', slideAuthorizateForm);
                            }

                            let authorizateContainer = authorizateButtons[i].parentNode.querySelectorAll('.authorizate-form-container')[0];

                            authorizateContainer.originalHeight = authorizateContainer.clientHeight;
                            authorizateContainer.style.height = 0;
                        }

                        let langMessageList = JSON.parse('<?=GetMessageList();?>');

                        // handler for login form

                        let loginForm = document.getElementById('login-form');
                        let loginFormParams =
                        {
                            'USER_LOGIN':
                            {
                                minSymbolLength: 3,
                                maxSymbolLength: 100,
                                placeHolder: '<?=GetMessage('ENTER_LOGIN');?>'
                            },

                            'USER_PASSWORD':
                            {
                                minSymbolLength: 6,
                                maxSymbolLength: 100,
                                placeHolder: '<?=GetMessage('ENTER_PASSWORD');?>'
                            },

                            'CAPTCHA_CODE':
                            {
                                minSymbolLength: 7,
                                maxSymbolLength: 7,
                                placeHolder: '<?=GetMessage('ENTER_CAPTCHA_CODE');?>'
                            }
                        };

                        let loginFormValidator = new Validator(loginForm, 'require-input', 'error-input', 'success-input', loginFormParams, langMessageList);

                        loginForm.onsubmit = function()
                        {
                            let thisForm = this;
                            let errorNotifies = thisForm.querySelectorAll('.error-input');

                            // remove found elements and form error checking

                            removeNodes(errorNotifies);
                            loginFormValidator.checkInputs();

                            errorNotifies = thisForm.querySelectorAll('.error-input');

                            if(errorNotifies[0] !== undefined)
                            {
                                return false;
                            }

                            let data = new FormData(thisForm);

                            let oSuccess =
                            {
                                thisForm: thisForm,
                                loader: document.getElementsByClassName('login-handler-loader')[0],
                                loginFormValidator: loginFormValidator,
                                success: function()
                                {
                                    var responseData = JSON.parse(this.xhr.responseText);

                                    if(responseData.ERROR_FIELDS !== undefined)
                                    {
                                        for(let ef in responseData.ERROR_FIELDS)
                                        {
                                            this.loginFormValidator.generateNotify(document.getElementsByName(ef)[0], responseData.ERROR_FIELDS[ef].ERROR_MESSAGE, 'error');
                                        }
                                    }
                                    else if(responseData.ERROR_CAPTCHA !== undefined)
                                    {
                                        this.loginFormValidator.generateNotify(document.getElementsByName('CAPTCHA_CODE')[0], responseData.ERROR_CAPTCHA, 'error');
                                    }
                                    else if(responseData.ERROR_AUTHORIZATE !== undefined)
                                    {
                                        this.loginFormValidator.generateNotify(document.getElementsByName('USER_PASSWORD')[0], responseData.ERROR_AUTHORIZATE, 'error');
                                    }
                                    else
                                    {
                                        location.assign('/personal');
                                    }

                                    this.loader.style.display = 'none';
                                }
                            }

                            uploadAndSendData(thisForm.getAttribute('action'), data, oSuccess);

                            return false;
                        };

                        // select file handler

                        let userPhoto = document.getElementById('user-photo');

                        userPhoto.onchange = function()
                        {
                            document.getElementsByClassName('file-name')[0].innerText = this.files[0].name;
                        };

                        // handler for register form

                        let registerForm = document.getElementById('register-form');
                        let registerFormParams =
                        {
                            'USER_REGISTER_LOGIN':
                            {
                                minSymbolLength: 3,
                                maxSymbolLength: 100,
                                placeHolder: '<?=GetMessage('USER_REGISTER_LOGIN');?>',
                                isExistence: 'login',
                                loader: document.getElementById('login-existence-loader')
                            },

                            'USER_REGISTER_NAME':
                            {
                                minSymbolLength: 3,
                                maxSymbolLength: 100,
                                placeHolder: '<?=GetMessage('USER_REGISTER_NAME');?>'
                            },

                            'USER_REGISTER_LAST_NAME':
                            {
                                minSymbolLength: 3,
                                maxSymbolLength: 100,
                                placeHolder: '<?=GetMessage('USER_REGISTER_LAST_NAME');?>'
                            },

                            'USER_REGISTER_BIRTHDATE':
                            {
                                isDateFormat: true,
                                placeHolder: '<?=GetMessage('USER_REGISTER_BIRTHDATE');?>'
                            },

                            'USER_REGISTER_COUNTRY':
                            {
                                placeHolder: '<?=GetMessage('REGISTER_SELECT_COUNTRY');?>'
                            },

                            'USER_REGISTER_CITY':
                            {
                                placeHolder: '<?=GetMessage('REGISTER_SELECT_CITY');?>'
                            },

                            'USER_REGISTER_PASSWORD':
                            {
                                minSymbolLength: 6,
                                maxSymbolLength: 100, 
                                placeHolder: '<?=GetMessage('USER_REGISTER_PASSWORD');?>'
                            },

                            'USER_REGISTER_CONFIRM_PASSWORD':
                            {
                                minSymbolLength: 6,
                                maxSymbolLength: 100,
                                placeHolder: '<?=GetMessage('USER_REGISTER_CONFIRM_PASSWORD');?>'
                            },

                            'USER_REGISTER_EMAIL':
                            {
                                minSymbolLength: 3,
                                maxSymbolLength: 100,
                                isEmailFormat: true,
                                placeHolder: '<?=GetMessage('USER_REGISTER_EMAIL');?>',
                                isExistence: 'email',
                                loader: document.getElementById('email-existence-loader')
                            },

                            'CAPTCHA_CODE':
                            {
                                minSymbolLength: 7,
                                maxSymbolLength: 7,
                                placeHolder: '<?=GetMessage('ENTER_CAPTCHA_CODE');?>'
                            }
                        };

                        let registerFormValidator = new Validator(registerForm, 'require-input', 'error-input', 'success-input', registerFormParams, langMessageList);

                        registerForm.onsubmit = function()
                        {
                            var thisForm = this;
                            var errorNotifies = thisForm.querySelectorAll('.error-input');

                            // form error checking

                            removeNodes(errorNotifies);
                            registerFormParams.USER_REGISTER_CONFIRM_PASSWORD.conformityPassword = document.getElementsByName('USER_REGISTER_PASSWORD')[0].value;
                            registerFormValidator.lastAction = function()
                            {
                                errorNotifies = thisForm.querySelectorAll('.error-input');

                                if(errorNotifies[0] !== undefined)
                                {
                                    return false;
                                }

                                let data = new FormData(thisForm);
                                let userRegisterPhoto = document.getElementsByName('USER_REGISTER_PHOTO')[0];

                                if(userRegisterPhoto.files[0] !== undefined)
                                {
                                    data.append(userRegisterPhoto.getAttribute('name'), userRegisterPhoto.files[0]);
                                }

                                let oSuccess =
                                {
                                    thisForm: thisForm,
                                    loader: document.getElementsByClassName('register-handler-loader')[0],
                                    registerFormValidator: registerFormValidator,
                                    success: function()
                                    {
                                        var responseData = JSON.parse(this.xhr.responseText);

                                        if(responseData.ERROR_FIELDS !== undefined)
                                        {
                                            for(let ef in responseData.ERROR_FIELDS)
                                            {
                                                this.registerFormValidator.generateNotify(document.getElementsByName(ef)[0], responseData.ERROR_FIELDS[ef].ERROR_MESSAGE, 'error');
                                            }
                                        }
                                        else if(responseData.ERROR_CAPTCHA !== undefined)
                                        {
                                            this.registerFormValidator.generateNotify(document.getElementsByName('CAPTCHA_CODE')[1], responseData.ERROR_CAPTCHA, 'error');
                                        }
                                        else
                                        {
                                            let registerStep2Content = responseData.REGISTER_HANDLER_SUCCESS;
                                            let registerStep2Element = document.createElement('div');
                                            registerStep2Element.innerHTML = registerStep2Content;

                                            this.thisForm.parentNode.replaceChild(registerStep2Element, this.thisForm);

                                            // set handlers for confirm register form

                                            setPlaceholderToInput(document.getElementsByName('USER_ABOUT_DESCRIPTION')[0], langMessageList.USER_ABOUT_DECRIPTION, 'rgba(0, 0, 0, 0.7)');

                                            let registerConfirmForm = document.getElementById('register-confirm-form');
                                            let registerConfirmFormParams =
                                            {
                                                'USER_ABOUT_DESCRIPTION':
                                                {
                                                    minSymbolLength: 3,
                                                    maxSymbolLength: 2000,
                                                    placeHolder: langMessageList.USER_ABOUT_DECRIPTION
                                                }
                                            };

                                            let registerConfirmFormValidator = new Validator(registerConfirmForm, 'require-input', 'error-input', 'success-input', registerConfirmFormParams, langMessageList);

                                            registerConfirmForm.onsubmit = function()
                                            {
                                                let thisForm = this;
                                                let errorNotifies = thisForm.querySelectorAll('.error-input');

                                                // form error checking

                                                removeNodes(errorNotifies);
                                                registerConfirmFormValidator.checkInputs();

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
                                                    registerConfirmFormValidator: registerConfirmFormValidator,
                                                    success: function()
                                                    {
                                                        var responseData = JSON.parse(this.xhr.responseText);

                                                        if(responseData.ERROR_FIELDS !== undefined)
                                                        {
                                                            for(let ef in responseData.ERROR_FIELDS)
                                                            {
                                                                this.registerConfirmFormValidator.generateNotify(document.getElementsByName(ef)[0], responseData.ERROR_FIELDS[ef].ERROR_MESSAGE, 'error');
                                                            }
                                                        }
                                                        else
                                                        {
                                                            let emailSendResultContent = responseData.EMAIL_SEND_RESULT;
                                                            let emailSendResultElement = document.createElement('div');
                                                            emailSendResultElement.innerHTML = emailSendResultContent;

                                                            this.thisForm.parentNode.replaceChild(emailSendResultElement, this.thisForm);  
                                                        }

                                                        this.loader.style.display = 'none';
                                                    }
                                                }

                                                uploadAndSendData(thisForm.getAttribute('action'), data, oSuccess);

                                                return false;
                                            };

                                        }

                                        this.loader.style.display = 'none';
                                    }
                                }

                                uploadAndSendData(thisForm.getAttribute('action'), data, oSuccess);
                            };

                            registerFormValidator.checkInputs();

                            return false;
                        };

                        let authorizateButton = document.getElementsByClassName('authorizate-button')[0];
                        var authorizateContainer = document.getElementsByClassName('authorizate-container')[0];

                        authorizateButton.onclick = function()
                        {
                            authorizateContainer.classList.remove('opacity-fade-out');
                            authorizateContainer.classList.add('opacity-fade-in');
                        };

                        authorizateContainer.onclick = function(e)
                        {
                            let thisContainer = this;
                            let target = e.target;

                            if(thisContainer == target)
                            {
                                thisContainer.classList.add('opacity-fade-out');
                                thisContainer.classList.remove('opacity-fade-in');
                            }
                        };
                    };
                </script>
            <?endif;?>

            <script type="text/javascript" src="/sources/js/dropdown-menu.js"></script>

            <script type="text/javascript">
                function onloadWindow()
                {
                    // set dropDown menu functionality

                    let dropDownParams =
                    {
                        additionalMethods:
                        {
                            classOfElement: 'dropdown-additional-methods',
                            onopen: function(button)
                            {
                                button.classList.remove('lc-icon-close');
                                button.classList.add('lc-icon-open');
                            },
                            onclose: function(button)
                            {
                                button.classList.remove('lc-icon-open');
                                button.classList.add('lc-icon-close');
                            }
                        }
                    };

                    setDropDownMenu(document.getElementsByClassName('div-select'), 'div-select-list', 'div-select', 'select-input', dropDownParams);
                }

                if(window.addEventListener !== undefined)
                {
                    window.addEventListener('load', onloadWindow);
                }
                else
                {
                    window.attachEvent('onload', onloadWindow);
                }

            </script>

            <?/* Footer */?>

            <footer id="main-footer">
                <section class="main-footer-section">
                    Lorem Ipsum - это текст-"рыба", часто используемый в печати и вэб-дизайне. Lorem Ipsum является стандартной "рыбой" для текстов на латинице с начала XVI века. В то время некий безымянный печатник создал большую коллекцию размеров и форм шрифтов, используя Lorem Ipsum для распечатки образцов. Lorem Ipsum не только успешно пережил без заметных изменений пять веков, но и перешагнул в электронный дизайн. Его популяризации в новое время послужили публикация листов Letraset с образцами Lorem Ipsum в 60-х годах и, в более недавнее время, программы электронной вёрстки типа Aldus PageMaker, в шаблонах которых используется Lorem Ipsum.
                </section>
                <section class="main-footer-section">
                    <div class="author-copyright">Create by Marchello &#169;</div>
                    
                    <?if(isset($userAuthorized)):?>
                        <a href="/personal" class="personal-section-link"><?=GetMessage('PERSONAL_SECTION_LINK');?></a>
                    <?endif;?>
                </section>
            </footer>
        </div>
    </body>
</html>