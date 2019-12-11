<?
require_once($_SERVER['DOCUMENT_ROOT'] . '/auxiliary-functions/data-handlers.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/auxiliary-functions/personal-methods.php');

$oDataHandlers = new \DataHandlers\ODataHandlers;

require_once($_SERVER['DOCUMENT_ROOT'] . '/init-files/lang-system-init.php');

class Controller_PersonalAjax
{
    use PersonalMethods;
    
    private $dataHandlder;
	
	public function __construct($page)
	{
        session_start();
        
		global $oDataHandlers;
        
		$page = 'action_' . $page;
		
		$this->dataHandler = $oDataHandlers;
        
        if(method_exists($this, $page))
        { 
            if(!$userData = $this->isUserAuthorized())
            {
                header('Location: /personal');
                die();
            }
            
            $this->userData = $userData;
            
            $this->$page();
        }
        else
        {
            echo 'Такой страницы не существует';
        }
	}
    
    public function action_edit_user_profile()
    {
        if($_SERVER['REQUEST_METHOD'] == 'POST')
        {
            $userData = explode(':', $this->userData);
            
            require_once($_SERVER['DOCUMENT_ROOT'] . '/auxiliary-functions/validator.php');

            $fields = array(
                'USER_INICIALS' => array(
                    'VALUE' => $this->dataHandler->stringCleanFromXSS($_POST['USER_INICIALS']),
                    'VALIDATOR_PARAMS' => array(
                        'minSymbolLength' => 3,
                        'maxSymbolLength' => 200
                    )
                ),
                
                'USER_BIRTHDATE' => array(
                    'VALUE' => $this->dataHandler->stringCleanFromXSS($_POST['USER_BIRTHDATE']),
                    'VALIDATOR_PARAMS' => array(
                        'minSymbolLength' => 10,
                        'maxSymbolLength' => 10,
                        'isDateFormat' => true
                    )
                ),
                
                'USER_EMAIL' => array(
                    'VALUE' => $this->dataHandler->stringCleanFromXSS($_POST['USER_EMAIL']),
                    'VALIDATOR_PARAMS' => array(
                        'minSymbolLength' => 3,
                        'maxSymbolLength' => 100,
                        'isEmailFormat' => true
                    )
                ),
                
                'USER_ABOUT_DESCRIPTION' => array(
                    'VALUE' => $this->dataHandler->stringCleanFromXSS($_POST['USER_ABOUT_DESCRIPTION']),
                    'VALIDATOR_PARAMS' => array(
                        'minSymbolLength' => 3,
                        'maxSymbolLength' => 2000
                    )
                ),
                
                'USER_CONFIRM_PASSWORD' => array(
                    'VALUE' => $this->dataHandler->stringCleanFromXSS($_POST['USER_CONFIRM_PASSWORD']),
                    'VALIDATOR_PARAMS' => array(
                        'conformityPassword' => $this->dataHandler->stringCleanFromXSS($_POST['USER_PASSWORD'])
                    )
                )
            );
            
            $settingsChoiceList = array(
                'SETTINGS_USER_BIRTHDATE' => isset($_POST['USER_BIRTHDATE_CHOICE']) ? $this->dataHandler->stringCleanFromXSS($_POST['USER_BIRTHDATE_CHOICE']) : 0,
                'SETTINGS_USER_COUNTRY' => isset($_POST['USER_COUNTRY_CHOICE']) ? $this->dataHandler->stringCleanFromXSS($_POST['USER_COUNTRY_CHOICE']) : 0,
                'SETTINGS_USER_CITY' => isset($_POST['USER_CITY_CHOICE']) ? $this->dataHandler->stringCleanFromXSS($_POST['USER_CITY_CHOICE']) : 0,
                'SETTINGS_USER_EMAIL' => isset($_POST['USER_EMAIL_CHOICE']) ? $this->dataHandler->stringCleanFromXSS($_POST['USER_EMAIL_CHOICE']) : 0,
                'SETTINGS_USER_DATE' => isset($_POST['USER_REGISTER_DATE_CHOICE']) ? $this->dataHandler->stringCleanFromXSS($_POST['USER_REGISTER_DATE_CHOICE']) : 0,
                'SETTINGS_USER_ABOUT_DESCRIPTION' => isset($_POST['USER_ABOUT_DESCRIPTION_CHOICE']) ? $this->dataHandler->stringCleanFromXSS($_POST['USER_ABOUT_DESCRIPTION_CHOICE']) : 0,
            );

            $validator = new Validator($fields);
            $errors = $validator->checkFields();

            if(!empty($errors))
            {
                $_SESSION['ERROR_FIELDS'] = $errors;
                
                header('Location: /personal?edit=1');
                die();
            }
            
            if($_FILES['USER_PHOTO']['error'] == 0)
            {
                require_once($_SERVER['DOCUMENT_ROOT'] . '/auxiliary-functions/images-upload.php');

                $_FILES['USER_PHOTO']['name'] = $this->dataHandler->stringCleanFromXSS($_FILES['USER_PHOTO']['name']);

                $oUploadImage = new UploadImages;

                if(is_array($imageResult = $oUploadImage->uploadImage($_FILES['USER_PHOTO'], $_SERVER['DOCUMENT_ROOT'] . '/upload/users-images/')) && isset($imageResult['ERROR']))
                {
                    $_SESSION['ERROR_UPLOAD_IMAGE'] = $imageResult['ERROR'];
                
                    header('Location: /personal?edit=1');
                    die();
                }
            }
            else
            {
                $imageResult = false;
            }
            
            $updateFields = array();
            
            foreach($fields as $fieldName => $fieldValue)
            {
                if($fieldName == 'USER_CONFIRM_PASSWORD')
                {
                    if($fieldValue['VALUE'] != '')
                    {
                        $updateFields['USER_PASSWORD'] = $this->dataHandler->setValueHash($fieldValue['VALUE']);
                    }
                }
                else
                {
                    if($fieldName == 'USER_INICIALS')
                    {
                        $userInicials = explode(' ', $fieldValue['VALUE']);
                        
                        $updateFields['USER_NAME'] = $userInicials[0];
                        $updateFields['USER_LAST_NAME'] = $userInicials[1];
                    }
                    else
                    {
                        $updateFields[$fieldName] = $fieldValue['VALUE'];
                    }
                }
            }
            
            $updateFields['USER_COUNTRY'] = $this->dataHandler->stringCleanFromXSS($_POST['USER_COUNTRY']);
            $updateFields['USER_CITY'] = $this->dataHandler->stringCleanFromXSS($_POST['USER_CITY']);
            
            $updateFields = array_merge($updateFields, $settingsChoiceList);
            
            if($imageResult != false)
            {
                $updateFields['USER_PHOTO'] = $imageResult['FILE_NAME'];
            }

            require_once($_SERVER['DOCUMENT_ROOT'] . '/model/DBObject.php');
            
            $oDBO = new \DBObjectScope\DBObject();
            
            if($oDBO->updateUserData($userData[0], $updateFields))
            {
                header('Location: /personal?edit=1&PROFILE_EDIT_RESPONSE=1');
                die();
            }
            else
            {
                header('Location: /personal?edit=1&PROFILE_EDIT_RESPONSE=0');
                die();
            }
        }
    }
}

if(isset($_GET['PAGE']))
{
	$page = $oDataHandlers->stringCleanFromXSS($_GET['PAGE']);
	
	$controller = new Controller_PersonalAjax($page);
}