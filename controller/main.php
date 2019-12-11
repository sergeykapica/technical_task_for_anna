<?
require_once($_SERVER['DOCUMENT_ROOT'] . '/auxiliary-functions/data-handlers.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/auxiliary-functions/rendering.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/auxiliary-functions/captcha.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/auxiliary-functions/location.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/auxiliary-functions/personal-methods.php');

$oDataHandlers = new \DataHandlers\ODataHandlers;

require_once($_SERVER['DOCUMENT_ROOT'] . '/init-files/lang-system-init.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/init-files/breadcrumbs-subsystem.php');

class Controller_Main extends Rendering
{
    use Captcha;
    use Location;
    use PersonalMethods;
    
	private $dataHandlder;
	
	public function __construct($page)
	{
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
                'stylesList' => array('main-style', 'validator-style'),
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
                'title' => GetMessage('MAIN_SECTION'),
                'keywords' => GetMessage('MAIN_SECTION_KEYWORDS')
            );
            
            if($this->isUserAuthorized())
            {
                $defaultVariablesForRendering['userAuthorized'] = true;
            }
            else
            {
                $defaultVariablesForRendering['locationsList'] = $this->getLocationsList();
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
        if(isset($_GET['REGISTER_RESPONSE']))
        {
            $this->renderPage('index', array('registerResponse' => $this->dataHandler->stringCleanFromXSS($_GET['REGISTER_RESPONSE'])));
        }
        else
        {
		  $this->renderPage('index');
        }
	}
    
    public function action_register_final_confirm()
    {
        if(isset($_GET['CONFIRM_CODE']))
        {
            $this->renderPage('register-final-confirm', array('confirmationCode' => $this->dataHandler->stringCleanFromXSS($_GET['CONFIRM_CODE'])));
        }
        else
        {
            $this->renderPage('register-final-confirm');
        }
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

$controller = new Controller_Main($page);
?>