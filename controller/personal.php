<?
require_once($_SERVER['DOCUMENT_ROOT'] . '/auxiliary-functions/data-handlers.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/auxiliary-functions/rendering.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/auxiliary-functions/location.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/auxiliary-functions/personal-methods.php');

$oDataHandlers = new \DataHandlers\ODataHandlers;

require_once($_SERVER['DOCUMENT_ROOT'] . '/init-files/lang-system-init.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/init-files/breadcrumbs-subsystem.php');

class Controller_Personal extends Rendering
{
    use Location;
    use PersonalMethods;
    
    private $dataHandlder;
    private $userData;
	
	public function __construct($page)
	{
        session_start();
        
		global $oDataHandlers;
        
		$page = 'action_' . $page;
		
		$this->dataHandler = $oDataHandlers;
        
        if(method_exists($this, $page))
        { 
            preg_match('/(.+?)\?/', $_SERVER['REQUEST_URI'], $founds);
            
            if(!empty($founds))
            {
                $url = $founds[1];
            }
            else
            {
                $url = $_SERVER['REQUEST_URI'];
            }
            
            $oBreadCrumb = new BreadCrumbs($url);
            
            $requestURL = preg_replace('/LANG=.+?[^&]/', '', $_SERVER['REQUEST_URI']);
            $requestURL = preg_match('/\?/', $requestURL) ? $requestURL : $requestURL . '?';
            
            $defaultVariablesForRendering = array(
                'stylesList' => array('main-style', 'validator-style', 'personal-style'),
                'languagesList' => array(
                    array(
                        'NAME' => 'Русский',
                        'CODE_URL' => $requestURL . 'LANG=ru'
                    ),
                    
                    array(
                        'NAME' => 'English',
                        'CODE_URL' => $requestURL . 'LANG=en'
                    )
                ),
                'breadCrumbString' => $oBreadCrumb->getBreadCrumbString(),
                'title' => GetMessage('PERSONAL_SECTION'),
                'keywords' => GetMessage('PERSONAL_SECTION_KEYWORDS')
            );
            
            if($userData = $this->isUserAuthorized())
            {
                $this->userData = $userData;
                $defaultVariablesForRendering['userAuthorized'] = true;
            }
            else
            {
                $defaultVariablesForRendering['locationsList'] = $this->getLocationsList();
                $this->defaultVariablesForRendering = $defaultVariablesForRendering;
                
                $this->renderPage('/personal/index', array('notAuthorized' => GetMessage('NOT_AUTHORIZED')));
                die();
            }
            
            $this->defaultVariablesForRendering = $defaultVariablesForRendering;
            
            $this->$page();
        }
        else
        {
            echo 'Такой страницы не существует';
        }
	}
    
    public function action_index()
    {
        require_once($_SERVER['DOCUMENT_ROOT'] . '/model/DBObject.php');

        $userData = $this->userData;
        $userData = explode(':', $userData);
        $userData = array(
            'USER_ID' => $userData[0],
            'USER_HASH_PASSWORD' => $userData[1]
        );

        $oDBO = new \DBObjectScope\DBObject();
        $userData = $oDBO->selectUsersList(array(
            'AND' => array(
                'ID' => $userData['USER_ID'],
                'USER_PASSWORD' => $userData['USER_HASH_PASSWORD']
            )
        ));

        if($userData)
        {
            $userData = $userData[0];
            $userData['USER_DATE'] = date('d/m/Y H:i:s', $userData['USER_DATE']);
            $userData['USER_PHOTO'] = $userData['USER_PHOTO'] != '' ? '/upload/users-images/' . $userData['USER_PHOTO'] : '/upload/default-images/default-user.png';

            if(isset($_GET['edit']))
            {
                $fields = array(
                    'settingsEdit' => true,
                    'locationsList' => $this->getLocationsList(),
                    'userData' => $userData
                );

                if(isset($_SESSION['ERROR_FIELDS']))
                {
                    $fields['errorFields'] = json_encode(array(
                        'ERROR_FIELDS' => $_SESSION['ERROR_FIELDS']
                    ));

                    unset($_SESSION['ERROR_FIELDS']);
                }
                else if(isset($_SESSION['ERROR_UPLOAD_IMAGE']))
                {
                    $fields['errorFields'] = json_encode(array(
                        'ERROR_UPLOAD_IMAGE' => $_SESSION['ERROR_UPLOAD_IMAGE']
                    ));

                    unset($_SESSION['ERROR_UPLOAD_IMAGE']);
                }

                if(isset($_GET['PROFILE_EDIT_RESPONSE']))
                {
                    $fields['profileEditResponse'] = $this->dataHandler->stringCleanFromXSS($_GET['PROFILE_EDIT_RESPONSE']);
                }

                $this->renderPage('/personal/index', $fields);
            }
            else
            {
                $this->renderPage('/personal/index', array('userData' => $userData));
            }
        }
        else
        {
            $this->renderPage('/personal/index', array('errorMessage', GetMessage('ERROR_GET_USER_DATA')));
        }
    }
    
    public function action_get_out_private_zone()
    {
        session_destroy();
        
        header('Location: /');
        die();
    }
}

if(isset($_GET['PAGE']))
{
	$page = $oDataHandlers->stringCleanFromXSS($_GET['PAGE']);
}
else
{
	$page = 'index';
}

$controller = new Controller_Personal($page);
?>