<?
require_once($_SERVER['DOCUMENT_ROOT'] . '/auxiliary-functions/data-handlers.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/auxiliary-functions/captcha.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/auxiliary-functions/rendering.php');

$oDataHandlers = new \DataHandlers\ODataHandlers;

require_once($_SERVER['DOCUMENT_ROOT'] . '/init-files/lang-system-init.php');

class Controller_Ajax extends Rendering
{
    use Captcha;
    
	private $dataHandlder;
	
	public function __construct($page)
	{
		global $oDataHandlers;
        
		$page = 'action_' . $page;
		
		$this->dataHandler = $oDataHandlers;
        
        if(method_exists($this, $page))
        { 
            $this->$page();
        }
        else
        {
            echo 'Такой страницы не существует';
        }
	}
	
    public function action_test()
    {
        // curl operations
        
        /*$secretKey = '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';
        $url = 'https://api.sendgrid.com/v3/mail/send';
        $headers = array(
            'POST ' . $url . ' HTTP/1.0',
            'Authorization: Bearer ' . $secretKey,
            'Content-Type: application/json'
        );
        
        $jsonData = json_encode(array(
            'personalizations' => array(
                array(
                    'to' => array(
                        array(
                            'email' => 'kermesovich1@gmail.com'
                        )
                    )
                )
            ),
            'from' => array(
                'email' => 'admin@technical-task-for-anna.com'
            ),
            'subject' => 'Hello',
            'content' => array(
                array(
                    'type' => 'text/plain',
                    'value' => 'Test'
                )
            )
        ));
        
        $ci = curl_init($url);
        
        curl_setopt($ci, CURLOPT_HEADER, 1);
        curl_setopt($ci, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ci, CURLOPT_POST, 1);
        curl_setopt($ci, CURLOPT_POSTFIELDS, $jsonData);
        curl_exec($ci);
        
        curl_close($ci);*/
    }
    
	public function action_register_handler()
	{
		if($_SERVER['REQUEST_METHOD'] == 'POST')
		{
            if($this->dataHandler->setValueHash($this->dataHandler->stringCleanFromXSS($_POST['CAPTCHA_CODE'])) == $this->getCurrentCaptchaCode())
            {
                if($_FILES['USER_REGISTER_PHOTO']['error'] == 0)
                {
                    require_once($_SERVER['DOCUMENT_ROOT'] . '/auxiliary-functions/images-upload.php');

                    $_FILES['USER_REGISTER_PHOTO']['name'] = $this->dataHandler->stringCleanFromXSS($_FILES['USER_REGISTER_PHOTO']['name']);

                    $oUploadImage = new UploadImages;

                    if(is_array($imageResult = $oUploadImage->uploadImage($_FILES['USER_REGISTER_PHOTO'], $_SERVER['DOCUMENT_ROOT'] . '/upload/users-images/')) && isset($imageResult['ERROR']))
                    {
                        echo json_encode($imageResult);
                        die();
                    }
                }
                else
                {
                    $imageResult = false;
                }

                require_once($_SERVER['DOCUMENT_ROOT'] . '/auxiliary-functions/validator.php');

                $fields = array(
                    'USER_REGISTER_LOGIN' => array(
                        'VALUE' => $this->dataHandler->stringCleanFromXSS($_POST['USER_REGISTER_LOGIN']),
                        'VALIDATOR_PARAMS' => array(
                            'minSymbolLength' => 3,
                            'maxSymbolLength' => 100,
                            'placeHolder' => GetMessage('USER_REGISTER_LOGIN')
                        )
                    ),

                    'USER_REGISTER_NAME' => array(
                        'VALUE' => $this->dataHandler->stringCleanFromXSS($_POST['USER_REGISTER_NAME']),
                        'VALIDATOR_PARAMS' => array(
                            'minSymbolLength' => 3,
                            'maxSymbolLength' => 100,
                            'placeHolder' => GetMessage('USER_REGISTER_NAME')
                        )
                    ),

                    'USER_REGISTER_LAST_NAME' => array(
                        'VALUE' => $this->dataHandler->stringCleanFromXSS($_POST['USER_REGISTER_LAST_NAME']),
                        'VALIDATOR_PARAMS' => array(
                            'minSymbolLength' => 3,
                            'maxSymbolLength' => 100,
                            'placeHolder' => GetMessage('USER_REGISTER_LAST_NAME')
                        )
                    ),

                    'USER_REGISTER_BIRTHDATE' => array(
                        'VALUE' => $this->dataHandler->stringCleanFromXSS($_POST['USER_REGISTER_BIRTHDATE']),
                        'VALIDATOR_PARAMS' => array(
                            'isDateFormat' => true,
                            'placeHolder' => GetMessage('USER_REGISTER_BIRTHDATE')
                        )
                    ),

                    'USER_REGISTER_COUNTRY' => array(
                        'VALUE' => $this->dataHandler->stringCleanFromXSS($_POST['USER_REGISTER_COUNTRY']),
                        'VALIDATOR_PARAMS' => array(
                            'isEmpty' => true,
                            'placeHolder' => GetMessage('REGISTER_SELECT_COUNTRY')
                        )
                    ),

                    'USER_REGISTER_CITY' => array(
                        'VALUE' => $this->dataHandler->stringCleanFromXSS($_POST['USER_REGISTER_CITY']),
                        'VALIDATOR_PARAMS' => array(
                            'isEmpty' => true,
                            'placeHolder' => GetMessage('REGISTER_SELECT_CITY')
                        )
                    ),

                    'USER_REGISTER_PASSWORD' => array(
                        'VALUE' => $this->dataHandler->stringCleanFromXSS($_POST['USER_REGISTER_PASSWORD']),
                        'VALIDATOR_PARAMS' => array(
                            'minSymbolLength' => 6,
                            'maxSymbolLength' => 100,
                            'placeHolder' => GetMessage('USER_REGISTER_PASSWORD')
                        )
                    ),

                    'USER_REGISTER_CONFIRM_PASSWORD' => array(
                        'VALUE' => $this->dataHandler->stringCleanFromXSS($_POST['USER_REGISTER_CONFIRM_PASSWORD']),
                        'VALIDATOR_PARAMS' => array(
                            'minSymbolLength' => 6,
                            'maxSymbolLength' => 100,
                            'conformityPassword' => $this->dataHandler->stringCleanFromXSS($_POST['USER_REGISTER_PASSWORD']),
                            'placeHolder' => GetMessage('USER_REGISTER_CONFIRM_PASSWORD')
                        )
                    ),

                    'USER_REGISTER_EMAIL' => array(
                        'VALUE' => $this->dataHandler->stringCleanFromXSS($_POST['USER_REGISTER_EMAIL']),
                        'VALIDATOR_PARAMS' => array(
                            'minSymbolLength' => 3,
                            'maxSymbolLength' => 100,
                            'isEmailFormat' => true,
                            'placeHolder' => GetMessage('USER_REGISTER_EMAIL')
                        )
                    )
                );

                $validator = new Validator($fields);
                $errors = $validator->checkFields();

                if(!empty($errors))
                {
                    echo json_encode(array(
                        'ERROR_FIELDS' => $errors
                    ));

                    die();
                }

                $saveFields = array();
                
                foreach($fields as $fieldName => $fieldValue)
                {
                    if($fieldName == 'USER_REGISTER_PASSWORD')
                    {
                        $fieldValue['VALUE'] = $this->dataHandler->setValueHash($fieldValue['VALUE']);
                    }
                    
                    $saveFields[$fieldName] = $fieldValue['VALUE'];
                }
                
                if($imageResult != false)
                {
                    $saveFields['USER_REGISTER_PHOTO'] = $imageResult['FILE_NAME'];
                }
                
                $_SESSION['USER_REGISTER_SAVE_FIELDS'] = $saveFields;
                
                echo json_encode(array(
                    'REGISTER_HANDLER_SUCCESS' => $this->renderHTML('/views/ajax/register-step2.php')
                ));
            }
            else
            {
                echo json_encode(array(
                    'ERROR_CAPTCHA' => GetMessage('ENTER_CAPTCHA_ERROR')
                ));
            }
		}
	}
    
    public function action_register_confirm()
	{
        if($_SERVER['REQUEST_METHOD'] == 'POST')
        {
            if(isset($_SESSION['USER_REGISTER_SAVE_FIELDS']))
            {
                require_once($_SERVER['DOCUMENT_ROOT'] . '/auxiliary-functions/validator.php');

                $fields = array(
                    'USER_ABOUT_DESCRIPTION' => array(
                        'VALUE' => $this->dataHandler->stringCleanFromXSS($_POST['USER_ABOUT_DESCRIPTION']),
                        'VALIDATOR_PARAMS' => array(
                            'minSymbolLength' => 3,
                            'maxSymbolLength' => 2000,
                            'placeHolder' => GetMessage('USER_ABOUT_DECRIPTION')
                        )
                    )
                );

                $validator = new Validator($fields);
                $errors = $validator->checkFields();

                if(!empty($errors))
                {
                    echo json_encode(array(
                        'ERROR_FIELDS' => $errors
                    ));

                    die();
                }
                
                $_SESSION['USER_REGISTER_SAVE_FIELDS']['USER_ABOUT_DESCRIPTION'] = $fields['USER_ABOUT_DESCRIPTION']['VALUE'];
                
                // get register confirm code
                
                require_once($_SERVER['DOCUMENT_ROOT'] . '/auxiliary-functions/generate-code.php');
                
                $confirmCode = GenerateCode::generateRandomCode(32);
                
                // write to session storage
                
                $_SESSION['CONFIRMATION_CODE'] = $this->dataHandler->setValueHash($confirmCode);
                
                // send invitation url and code
                
                require_once($_SERVER['DOCUMENT_ROOT'] . '/auxiliary-functions/mail-sendgrid.php');
                //require_once($_SERVER['DOCUMENT_ROOT'] . '/auxiliary-functions/mail.php');
                
                $variables = array(
                    'HOST' => $_SERVER['HTTP_HOST'],
                    'EMAIL_TEXT' => GetMessage('CONFIRM_EMAIL_INVITATION'),
                    'INVITATION_CODE' => $confirmCode,
                    'REGISTER_FINAL_CONFIRM_URL' => 'http://' . $_SERVER['HTTP_HOST'] . '/register_final_confirm?CONFIRM_CODE=' . $confirmCode,
                    'USER_NAME' => $_SESSION['USER_REGISTER_SAVE_FIELDS']['USER_REGISTER_NAME'],
                    'EMAIL_APPEAL_USER' => GetMessage('APPEAL_USER'),
                );
                
                $content = $this->renderHTML('/views/ajax/mail-letter.php', $variables);
                
                /*$oMail = new Mail();
                $oMail->sendEmail('admin@technical-task-for-anna.com', $_SESSION['USER_REGISTER_SAVE_FIELDS']['USER_REGISTER_EMAIL'], 'Уведомление с сайта ' . $_SERVER['HTTP_HOST'], $content, 'ru')*/
                
                $oMail = new SendGridMail;

                if($oMail->send($_SESSION['USER_REGISTER_SAVE_FIELDS']['USER_REGISTER_EMAIL'], 'Уведомление с сайта ' . $_SERVER['HTTP_HOST'], $content))
                {
                    $emailResult = $this->renderHTML('/views/ajax/send-email-result.php', array(
                        'SEND' => true,
                        'SEND_RESULT_TEXT' => GetMessage('SEND_RESULT_TEXT_SUCCESS'), 
                        'USER_EMAIL' => $_SESSION['USER_REGISTER_SAVE_FIELDS']['USER_REGISTER_EMAIL']
                    ));
                }
                else
                {
                    $emailResult = $this->renderHTML('/views/ajax/send-email-result.php', array('SEND' => false, 'SEND_RESULT_TEXT' => GetMessage('SEND_RESULT_TEXT_ERROR')));
                }
                
                echo json_encode(array(
                    'EMAIL_SEND_RESULT' => $emailResult
                ));
            }
        }
    }
    
    public function action_register_final_confirm_handler()
    {
        if($_SERVER['REQUEST_METHOD'] == 'POST')
        {
            if(isset($_SESSION['USER_REGISTER_SAVE_FIELDS']) && isset($_SESSION['CONFIRMATION_CODE']))
            {
                require_once($_SERVER['DOCUMENT_ROOT'] . '/auxiliary-functions/validator.php');

                $fields = array(
                    'CONFIRMATION_CODE' => array(
                        'VALUE' => $this->dataHandler->stringCleanFromXSS($_POST['CONFIRMATION_CODE']),
                        'VALIDATOR_PARAMS' => array(
                            'minSymbolLength' => 3,
                            'maxSymbolLength' => 2000,
                            'placeHolder' => GetMessage('CONFIRMATION_CODE')
                        )
                    )
                );

                $validator = new Validator($fields);
                $errors = $validator->checkFields();

                if(!empty($errors))
                {
                    echo json_encode(array(
                        'ERROR_FIELDS' => $errors
                    ));

                    die();
                }
                
                if($this->dataHandler->setValueHash($fields['CONFIRMATION_CODE']['VALUE']) == $_SESSION['CONFIRMATION_CODE'])
                {
                    $_SESSION['USER_REGISTER_SAVE_FIELDS']['USER_REGISTER_DATE'] = time();
                    
                    require_once($_SERVER['DOCUMENT_ROOT'] . '/model/DBObject.php');
                    
                    $oDBO = new \DBObjectScope\DBObject();
                    
                    if($oDBO->insertToUsersList($_SESSION['USER_REGISTER_SAVE_FIELDS']))
                    {
                        unset($_SESSION['USER_REGISTER_SAVE_FIELDS']);
                        
                        echo json_encode(array(
                            'REGISTER_SUCCESS' => true
                        ));
                    }
                    else
                    {
                        echo json_encode(array(
                            'REGISTER_FAILED' => true
                        ));
                    }
                }
                else
                {
                    echo json_encode(array(
                        'ERROR_CONFIRMATION_CODE' => true
                    ));
                }
            }
            else
            {
                echo json_encode(array(
                    'REGISTER_CONFIRMED' => true
                ));
            }
        }
    }
    
    public function action_login_handler()
    {
        if($_SERVER['REQUEST_METHOD'] == 'POST')
        {
            if($this->dataHandler->setValueHash($this->dataHandler->stringCleanFromXSS($_POST['CAPTCHA_CODE'])) == $this->getCurrentCaptchaCode())
            {
                require_once($_SERVER['DOCUMENT_ROOT'] . '/auxiliary-functions/validator.php');

                $fields = array(
                    'USER_LOGIN' => array(
                        'VALUE' => $this->dataHandler->stringCleanFromXSS($_POST['USER_LOGIN']),
                        'VALIDATOR_PARAMS' => array(
                            'minSymbolLength' => 3,
                            'maxSymbolLength' => 100,
                            'placeHolder' => GetMessage('ENTER_LOGIN')
                        )
                    ),
                    
                    'USER_PASSWORD' => array(
                        'VALUE' => $this->dataHandler->stringCleanFromXSS($_POST['USER_PASSWORD']),
                        'VALIDATOR_PARAMS' => array(
                            'minSymbolLength' => 6,
                            'maxSymbolLength' => 100,
                            'placeHolder' => GetMessage('ENTER_PASSWORD')
                        )
                    )
                );

                $validator = new Validator($fields);
                $errors = $validator->checkFields();

                if(!empty($errors))
                {
                    echo json_encode(array(
                        'ERROR_FIELDS' => $errors
                    ));

                    die();
                }
                
                $fields['USER_PASSWORD']['VALUE'] = $this->dataHandler->setValueHash($fields['USER_PASSWORD']['VALUE']);
                
                require_once($_SERVER['DOCUMENT_ROOT'] . '/model/DBObject.php');
                
                $condition = array(
                    'AND' => array(
                        'USER_LOGIN' => $fields['USER_LOGIN']['VALUE'],
                        'USER_PASSWORD' => $fields['USER_PASSWORD']['VALUE']
                    )
                );
                
                $oDBO = new \DBObjectScope\DBObject();
                
                if($userData = $oDBO->selectUsersList($condition))
                {
                    $userData = $userData[0];
                    $_SESSION['AUTHORIZED_USER'] = $userData['ID'] . ':' . $userData['USER_PASSWORD'];
                    
                    echo json_encode(array(
                        'SUCCESS_AUTHORIZATE' => true
                    ));
                }
                else
                {
                    echo json_encode(array(
                        'ERROR_AUTHORIZATE' => GetMessage('ERROR_AUTHORIZATE')
                    ));
                }
            }
            else
            {
                echo json_encode(array(
                    'ERROR_CAPTCHA' => GetMessage('ENTER_CAPTCHA_ERROR')
                ));
            }
        }
    }
    
    public function action_check_existence_data()
    {
        if(isset($_GET['LOGIN']))
        {
            require_once($_SERVER['DOCUMENT_ROOT'] . '/model/DBObject.php');
            
            $oDBO = new \DBObjectScope\DBObject();
            
            $condition = array(
                'AND' => array(
                    'USER_LOGIN' => $this->dataHandler->stringCleanFromXSS($_GET['LOGIN'])
                )
            );
            
            if($oDBO->selectUsersList($condition))
            {
                echo true;
            }
            else
            {
                echo false;
            }
        }
        else
        {
            require_once($_SERVER['DOCUMENT_ROOT'] . '/model/DBObject.php');
            
            $oDBO = new \DBObjectScope\DBObject();
            
            $condition = array(
                'AND' => array(
                    'USER_EMAIL' => $this->dataHandler->stringCleanFromXSS($_GET['EMAIL'])
                )
            );
            
            if($oDBO->selectUsersList($condition))
            {
                echo true;
            }
            else
            {
                echo false;
            }
        }
    }
}

if(isset($_GET['PAGE']))
{
	$page = $oDataHandlers->stringCleanFromXSS($_GET['PAGE']);
	
	$controller = new Controller_Ajax($page);
}
?>