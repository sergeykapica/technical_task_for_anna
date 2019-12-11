<?
session_start();
require_once($_SERVER['DOCUMENT_ROOT'] . '/auxiliary-functions/data-handlers.php');

$oDataHandlers = new \DataHandlers\ODataHandlers;

trait Captcha 
{
    public function getCaptchaImage()
    {
        global $oDataHandlers;
        
        // Get random symbols
        
        $symbolsList = range('a', 'z');
        $countSymbols = 6;
        $symbolsString = '';

        for($i = 0; $i <= $countSymbols; $i++)
        {
            $symbolsString .= $symbolsList[rand(0, ( count($symbolsList) - 1 ))];
        }
        
        $_SESSION['CAPTCHA_CODE'] = $oDataHandlers->setValueHash($symbolsString);
        
        $imageWidth = 150;
        $imageHeight = 60;
        
        $im = imagecreatetruecolor($imageWidth, $imageHeight);
 
        // colors for captcha
        
        $white = imagecolorallocate($im, 255, 255, 255);
        $grey = imagecolorallocate($im, 105, 105, 105);
        $black = imagecolorallocate($im, 0, 0, 0);

        imagefilledrectangle($im, 0, 0, $imageWidth, $imageHeight, $white);

        // Path to font

        $font = $_SERVER['DOCUMENT_ROOT'] . '/sources/fonts/test.ttf';

        // Draw text
        
        imagettftext($im, 30, 15, 10, 60, $grey, $font, $symbolsString);

        // prevent cache on client side
        
        header("Expires: Wed, 1 Jan 1997 00:00:00 GMT");
        header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
        header("Cache-Control: no-store, no-cache, must-revalidate");
        header("Cache-Control: post-check=0, pre-check=0", false);
        header("Pragma: no-cache");

        // send image to browser 
        
        header ("Content-type: image/png");
        imagepng($im);
        imagedestroy($im);
    }
    
    public function getCurrentCaptchaCode()
    {
        $captchaCode = isset($_SESSION['CAPTCHA_CODE']) ? $_SESSION['CAPTCHA_CODE'] : false;
        
        return $captchaCode;
    }
    
    public function action_get_captcha_image()
    {
        $this->getCaptchaImage();
    }
}