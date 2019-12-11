<?

trait PersonalMethods
{
    public function isUserAuthorized()
    {
        $userData = isset($_SESSION['AUTHORIZED_USER']) ? $_SESSION['AUTHORIZED_USER'] : false;
        
        return $userData;
    }
}