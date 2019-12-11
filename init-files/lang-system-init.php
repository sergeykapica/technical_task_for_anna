<?
if(isset($_GET['LANG']))
{
    $langCode = $oDataHandlers->stringCleanFromXSS($_GET['LANG']);
}
else
{
    $langCode = 'ru';
}

if(!file_exists($_SERVER['DOCUMENT_ROOT'] . '/sources/lang/' . $langCode . '/lang.php'))
{
    $langCode = 'ru';
}

require_once($_SERVER['DOCUMENT_ROOT'] . '/sources/lang/' . $langCode . '/lang.php');

function GetMessage($title)
{
    global $MESSAGE;
    
    $message = isset($MESSAGE[$title]) ? $MESSAGE[$title] : false;
    
    return $message;
}

function GetMessageList()
{
    global $MESSAGE;
    
    return json_encode($MESSAGE);
}
?>