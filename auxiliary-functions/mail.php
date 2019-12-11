<?
require($_SERVER['DOCUMENT_ROOT'] . '/auxiliary-functions/php-mailer/PhpMailerAutoload.php');

class Mail
{
    public $oPHPMailer;
    
    public function __construct()
    {
        $this->oPHPMailer = new PHPMailer\PHPMailer\PHPMailer;
        $this->oPHPMailer->isSMTP();
        $this->oPHPMailer->Host = 'smtp.gmail.com';
        $this->oPHPMailer->SMTPAuth = true;
        $this->oPHPMailer->Username = 'kermesovich1@gmail.com';
        $this->oPHPMailer->Password = 'kermes1960';
        $this->oPHPMailer->SMTPSecure = 'ssl';
        $this->oPHPMailer->Port = 465;
        $this->oPHPMailer->SMTPOptions = array(
            'ssl' => array(
                'verify_peer' => false,
                'verify_peer_name' => false,
                'allow_self_signed' => true
            )
        );
        $this->oPHPMailer->CharSet = 'UTF-8';
    }
    
    public function sendEmail($from, $to, $subject, $message, $lang, $html = true)
    {
        $this->oPHPMailer->setFrom($from, $subject);
        $this->oPHPMailer->addAddress($to);
        $this->oPHPMailer->Subject = $subject;
        $this->oPHPMailer->Body = $message;
        $this->oPHPMailer->setLanguage($lang);
        $this->oPHPMailer->isHTML($html);
        
        return $this->oPHPMailer->send();
    }
}