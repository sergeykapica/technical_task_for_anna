<?if(!isset($errorMessage) && isset($userAuthorized)):?>
    <?if(!isset($settingsEdit)):?>
        <div class="profile-wrapper">
            <div class="profile-user-photo" style="background-image: url(<?=$userData['USER_PHOTO'];?>);"></div>
            <div class="profile-data-wrapper">
                <section class="profile-data-section data-section-headline">
                    <span><?=$userData['USER_NAME'] . ' ' . $userData['USER_LAST_NAME'] ;?></span>
                    <a href="/personal?edit=1" class="profile-settings-button"></a>
                </section>
                <?if($userData['SETTINGS_USER_BIRTHDATE'] == 1):?>
                    <section class="profile-data-section">
                        <span class="profile-data-name"><?=GetMessage('USER_BIRTHDATE');?>:</span>
                        <span class="profile-data-value data-user-value"><?=$userData['USER_BIRTHDATE'];?></span>
                    </section>
                <?endif;?>
                <?if($userData['SETTINGS_USER_COUNTRY'] == 1):?>
                    <section class="profile-data-section">
                        <span class="profile-data-name"><?=GetMessage('USER_COUNTRY');?>:</span>
                        <span class="profile-data-value data-user-value"><?=$userData['USER_COUNTRY'];?></span>
                    </section>
                <?endif;?>
                <?if($userData['SETTINGS_USER_CITY'] == 1):?>
                    <section class="profile-data-section">
                        <span class="profile-data-name"><?=GetMessage('USER_CITY');?>:</span>
                        <span class="profile-data-value data-user-value"><?=$userData['USER_CITY'];?></span>
                    </section>
                <?endif;?>
                <?if($userData['SETTINGS_USER_EMAIL'] == 1):?>
                    <section class="profile-data-section">
                        <span class="profile-data-name"><?=GetMessage('USER_EMAIL');?>:</span>
                        <span class="profile-data-value data-user-value"><?=$userData['USER_EMAIL'];?></span>
                    </section>
                <?endif;?>
                <?if($userData['SETTINGS_USER_DATE'] == 1):?>
                    <section class="profile-data-section">
                        <span class="profile-data-name"><?=GetMessage('USER_DATE');?>:</span>
                        <span class="profile-data-value data-user-value"><?=$userData['USER_DATE'];?></span>
                    </section>
                <?endif;?>
                <?if($userData['SETTINGS_USER_ABOUT_DESCRIPTION'] == 1):?>
                    <section class="profile-data-section">
                        <span class="profile-data-name"><?=GetMessage('USER_ABOUT_DESCRIPTION');?>:</span>
                        <span class="profile-data-value data-user-value"><?=$userData['USER_ABOUT_DESCRIPTION'];?></span>
                    </section>
                <?endif;?>
            </div>
        </div>
    <?else:?>
        <div class="profile-wrapper">
            <form action="/personal_ajax/edit_user_profile" method="post" enctype="multipart/form-data" id="profile-edit-form">
                <label>
                    <div class="profile-user-photo user-photo-change" style="background-image: url(<?=$userData['USER_PHOTO'];?>);"></div>
                    <input type="file" name="USER_PHOTO" id="profile-user-photo"/>
                </label>
                <div class="profile-data-wrapper">
                    <section class="profile-data-section data-section-headline">
                        <label>
                        <span class="profile-data-headline profile-input-editable" contenteditable="true"><?=$userData['USER_NAME'] . ' ' . $userData['USER_LAST_NAME'];?></span>
                            <input type="hidden" name="USER_INICIALS" value="<?=$userData['USER_NAME'] . ' ' . $userData['USER_LAST_NAME'];?>" class="input-editable require-input"/>
                        </label>
                    </section>
                    <section class="profile-data-section">
                        <span class="profile-data-name"><?=GetMessage('USER_BIRTHDATE');?>:</span>
                        <div class="pdata-value-wrapper">
                            <span class="profile-data-value profile-input-editable" contenteditable="true"><?=$userData['USER_BIRTHDATE'];?></span>
                            <span class="profile-data-value">
                                <div class="custom-checkbox-wrapper">
                                    <label>
                                        <input type="checkbox" name="USER_BIRTHDATE_CHOICE" value="1" <?=( $userData['SETTINGS_USER_BIRTHDATE'] == 1 ? 'checked' : '' );?> class="custom-checkbox"/>
                                        <div class="custom-checkbox-button"></div>
                                    </label>
                                </div>
                            </span>
                            <input type="hidden" name="USER_BIRTHDATE" value="<?=$userData['USER_BIRTHDATE'];?>" class="input-editable require-input"/>
                        </div>
                    </section>
                    <section class="profile-data-section">
                        <span class="profile-data-name"><?=GetMessage('USER_COUNTRY');?>:</span>
                        <div class="pdata-value-wrapper">
                            <span class="profile-data-value">
                                <div class="authorizate-input div-input div-select"><?=$userData['USER_COUNTRY'];?></div>
                                <?if(isset($locationsList)):?>
                                    <ul class="div-select-list">
                                        <?foreach($locationsList['COUNTRY_LIST'] as $countryID => $country):?>
                                            <li class="div-select-item" data-country-id="<?=$countryID;?>"><?=$country->name;?></li>
                                        <?endforeach;?>
                                    </ul>
                                <?endif;?>
                                <input type="hidden" name="USER_COUNTRY" value="<?=$userData['USER_COUNTRY'];?>" class="authorizate-input require-input select-input"/>
                            </span>
                            <span class="profile-data-value">
                                <div class="custom-checkbox-wrapper">
                                    <label>
                                        <input type="checkbox" name="USER_COUNTRY_CHOICE" value="1" <?=( $userData['SETTINGS_USER_COUNTRY'] == 1 ? 'checked' : '' );?> class="custom-checkbox"/>
                                        <div class="custom-checkbox-button"></div>
                                    </label>
                                </div>
                            </span>
                        </div>
                    </section>
                    <section class="profile-data-section">
                        <span class="profile-data-name"><?=GetMessage('USER_CITY');?>:</span>
                        <div class="pdata-value-wrapper">
                            <span class="profile-data-value">
                                <div class="authorizate-input div-input div-select"><?=$userData['USER_CITY'];?></div>
                                <?if(isset($locationsList)):?>
                                    <ul class="div-select-list">
                                        <?foreach($locationsList['CITY_LIST'] as $cityID => $city):?>
                                            <li class="div-select-item" data-country-id="<?=$cityID;?>"><?=$city->name;?></li>
                                        <?endforeach;?>
                                    </ul>
                                <?endif;?>
                                <input type="hidden" name="USER_CITY" value="<?=$userData['USER_CITY'];?>" class="authorizate-input require-input select-input"/>
                            </span>
                            <span class="profile-data-value">
                                <div class="custom-checkbox-wrapper">
                                    <label>
                                        <input type="checkbox" name="USER_CITY_CHOICE" value="1" <?=( $userData['SETTINGS_USER_CITY'] == 1 ? 'checked' : '' );?> class="custom-checkbox"/>
                                        <div class="custom-checkbox-button"></div>
                                    </label>
                                </div>
                            </span>
                        </div>
                    </section>
                    <section class="profile-data-section">
                        <span class="profile-data-name"><?=GetMessage('USER_EMAIL');?>:</span>
                        <div class="pdata-value-wrapper">
                            <span class="profile-data-value profile-input-editable" contenteditable="true"><?=$userData['USER_EMAIL'];?></span>
                            <input type="hidden" name="USER_EMAIL" value="<?=$userData['USER_EMAIL'];?>" class="input-editable require-input"/>
                            <span class="profile-data-value">
                                <div class="custom-checkbox-wrapper">
                                    <label>
                                        <input type="checkbox" name="USER_EMAIL_CHOICE" value="1" <?=( $userData['SETTINGS_USER_EMAIL'] == 1 ? 'checked' : '' );?> class="custom-checkbox"/>
                                        <div class="custom-checkbox-button"></div>
                                    </label>
                                </div>
                            </span>
                        </div>
                    </section>
                    <section class="profile-data-section">
                        <span class="profile-data-name"><?=GetMessage('USER_DATE');?>:</span>
                        <div class="pdata-value-wrapper">
                            <span class="profile-data-value profile-input-editable"><?=$userData['USER_DATE'];?></span>
                            <span class="profile-data-value">
                                <div class="custom-checkbox-wrapper">
                                    <label>
                                        <input type="checkbox" name="USER_REGISTER_DATE_CHOICE" value="1" <?=( $userData['SETTINGS_USER_DATE'] == 1 ? 'checked' : '' );?> class="custom-checkbox"/>
                                        <div class="custom-checkbox-button"></div>
                                    </label>
                                </div>
                            </span>
                        </div>
                    </section>
                    <section class="profile-data-section">
                        <span class="profile-data-name"><?=GetMessage('USER_CHANGE_PASSWORD');?>:</span>
                        <div class="pdata-value-wrapper">
                            <input type="password" name="USER_PASSWORD" autocomplete="off" class="input-editable require-input profile-input-editable"/>
                        </div>
                    </section>
                    <section class="profile-data-section">
                        <span class="profile-data-name"><?=GetMessage('USER_CONFIRM_PASSWORD');?>:</span>
                        <div class="pdata-value-wrapper">
                            <input type="password" name="USER_CONFIRM_PASSWORD" autocomplete="off" class="input-editable require-input profile-input-editable"/>
                        </div>
                    </section>
                    <section class="profile-data-section">
                        <span class="profile-data-name"><?=GetMessage('USER_ABOUT_DESCRIPTION');?>:</span>
                        <div class="pdata-value-wrapper">
                            <span class="profile-data-value">
                                <textarea name="USER_ABOUT_DESCRIPTION" class="input-editable require-input profile-textarea profile-input-editable"><?=$userData['USER_ABOUT_DESCRIPTION'];?></textarea>
                            </span>
                            <span class="profile-data-value profile-clear-checkbox">
                                <div class="custom-checkbox-wrapper">
                                    <label>
                                        <input type="checkbox" name="USER_ABOUT_DESCRIPTION_CHOICE" value="1" <?=( $userData['SETTINGS_USER_ABOUT_DESCRIPTION'] == 1 ? 'checked' : '' );?> class="custom-checkbox"/>
                                        <div class="custom-checkbox-button"></div>
                                    </label>
                                </div>
                            </span>
                        </div>
                    </section>
                    <section class="profile-data-section">
                        <button type="submit" class="profile-edit-button"><?=GetMessage('PROFILE_EDIT_BUTTON');?></button>
                    </section>
                </div>
            </form>
            
            <?if(isset($profileEditResponse)):?>
                <?if($profileEditResponse == 1):?>
                    <div class="register-response-notify register-confirmed">
                        <div class="response-notify-icon register-confirmed-icon"></div>
                        <p class="respnse-notify-text"><?=GetMessage('PROFILE_EDIT_RESPONSE_SUCCESS');?></p>
                    </div>
                <?else:?>
                    <div class="register-response-notify register-unconfirmed">
                        <div class="response-notify-icon register-unconfirmed-icon"></div>
                        <p class="respnse-notify-text"><?=GetMessage('PROFILE_EDIT_RESPONSE_FAILED');?></p>
                    </div>
                <?endif;?>
            <?endif;?>
        </div>

        <script type="text/javascript" src="/sources/js/dropdown-menu.js"></script>
        <script type="text/javascript" src="/sources/js/validator.js"></script>
        <script type="text/javascript" src="/sources/js/remove-nodes.js"></script>
        <script type="text/javascript" src="/sources/js/init-page.js"></script>

        <script type="text/javascript">
            initLoadPage();
            
            function onLoadPage()
            {
                let langMessageList = JSON.parse('<?=GetMessageList();?>');

                setDropDownMenu(document.getElementsByClassName('div-select'), 'div-select-list', 'select-input');

                let profileEditForm = document.getElementById('profile-edit-form');
                let profileEditFormParams =
                {
                    'USER_INICIALS':
                    {
                        minSymbolLength: 3,
                        maxSymbolLength: 200,
                        isInicials: true
                    },

                    'USER_BIRTHDATE':
                    {
                        minSymbolLength: 10,
                        maxSymbolLength: 10,
                        isDateFormat: true
                    },

                    'USER_EMAIL':
                    {
                        minSymbolLength: 3,
                        maxSymbolLength: 100,
                        isEmailFormat: true,
                        isExistence: 'email',
                        loader: document.getElementById('email-existence-loader')
                    },
                    
                    'USER_ABOUT_DESCRIPTION':
                    {
                        minSymbolLength: 3,
                        maxSymbolLength: 2000,
                        parentNode: 'pdata-value-wrapper'
                    },
                    
                    'USER_CONFIRM_PASSWORD': {}
                };

                let profileEditFormValidator = new Validator(profileEditForm, 'require-input', 'error-input', 'success-input', profileEditFormParams, langMessageList);

                profileEditForm.onsubmit = function()
                {
                    let thisForm = this;
                    let errorNotifies = thisForm.querySelectorAll('.error-input');

                    // remove found elements and form error checking

                    removeNodes(errorNotifies);
                    profileEditFormParams.USER_CONFIRM_PASSWORD.conformityPassword = document.getElementsByName('USER_PASSWORD')[0].value;
                    //profileEditFormValidator.checkInputs();

                    errorNotifies = thisForm.querySelectorAll('.error-input');

                    if(errorNotifies[0] !== undefined)
                    {
                        return false;
                    }
                };

                let profileInputEditable = document.getElementsByClassName('profile-input-editable');

                for(let i in profileInputEditable)
                {
                    if(!isNaN(i * 1))
                    {
                        profileInputEditable[i].onclick = function()
                        {
                            if(window.CustomEvent)
                            {
                                var event = new CustomEvent('focus');
                            }
                            else
                            {
                                var event = document.createEvent('focus');
                                event.initCustomEvent('focus');
                            }

                            var inputEditable = this.parentNode.querySelector('.input-editable');

                            if(inputEditable !== null)
                            {
                                this.parentNode.querySelector('.input-editable').dispatchEvent(event);
                            }
                        };
                        
                        if(profileInputEditable[i].nodeName !== 'INPUT' && profileInputEditable[i].nodeName !== 'TEXTAREA')
                        {
                            profileInputEditable[i].oninput = function()
                            {
                                let thisField = this;
                                let hiddenInput = thisField.parentNode.querySelector('.input-editable');

                                if(hiddenInput !== null)
                                {
                                    hiddenInput.value = thisField.innerText;
                                }
                            };
                        }
                    }
                }
                
                var errorFields = '<?=( isset($errorFields) ? $errorFields : false );?>';
                
                if(errorFields != false)
                {
                    errorFields = JSON.parse(errorFields);
                    
                    if(errorFields.ERROR_FIELDS !== undefined)
                    {
                        for(let i in errorFields.ERROR_FIELDS)
                        {
                            profileEditFormValidator.generateNotify(document.getElementsByName(i)[0], errorFields.ERROR_FIELDS[i].ERROR_MESSAGE, 'error');
                        }
                    }
                    else
                    {
                        profileEditFormValidator.generateNotify(document.getElementsByClassName('profile-edit-button')[0], errorFields.ERROR_UPLOAD_IMAGE, 'error');
                    }
                }
                
                // change photo on the fly
                
                let profileUserPhoto = document.getElementById('profile-user-photo');
                
                profileUserPhoto.onchange = function()
                {
                    var thisPhoto = this;
                    var userPhotoChange = thisPhoto.parentNode.querySelector('.user-photo-change');
                    
                    if(thisPhoto.files[0] !== undefined)
                    {
                        if(/image\/png|image\/jpeg|image\/jpg|image\/gif/i.test(thisPhoto.files[0].type))
                        {
                            (function()
                            {
                                var reader = new FileReader();

                                reader.onload = function(e)
                                {
                                    userPhotoChange.style.backgroundImage = 'url(' + e.target.result + ')';
                                };
                                
                                reader.readAsDataURL(thisPhoto.files[0]);
                            })();
                        }
                    }
                };
            }
                

            if(window.addEventListener !== undefined)
            {
                window.addEventListener('load', onLoadPage);
            }
            else
            {
                window.attachEvent('onload', onLoadPage);
            }
        </script>
    <?endif;?>
<?elseif(!isset($userAuthorized)):?>
    <div class="not-authorized"><?=$notAuthorized;?></div>
<?else:?>
    <div class="error-get-data"><?=$errorMessage;?></div>
<?endif;?>