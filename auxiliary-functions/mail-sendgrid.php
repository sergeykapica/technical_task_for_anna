<?

class SendGridMail
{
    private $siteParams = array(
        'SECRET_KEY' => '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',
        'FROM' => 'admin@technical-task-for-anna.com'
    );
    
    public function send($to, $subject, $content)
    {
        $url = 'https://api.sendgrid.com/v3/mail/send';
        $headers = array(
            'POST ' . $url . ' HTTP/1.0',
            'Authorization: Bearer ' . $this->siteParams['SECRET_KEY'],
            'Content-Type: application/json'
        );
        
        $jsonData = json_encode(array(
            'personalizations' => array(
                array(
                    'to' => array(
                        array(
                            'email' => $to
                        )
                    )
                )
            ),
            'from' => array(
                'email' => $this->siteParams['FROM']
            ),
            'subject' => $subject,
            'content' => array(
                array(
                    'type' => 'text/html',
                    'value' => $content
                )
            )
        ));
        
        $ci = curl_init($url);
        
        curl_setopt($ci, CURLOPT_HEADER, 1);
        curl_setopt($ci, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ci, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ci, CURLOPT_POST, 1);
        curl_setopt($ci, CURLOPT_POSTFIELDS, $jsonData);
        curl_exec($ci);
        
        if(curl_errno($ci))
        {
            return false;
        }
        else
        {
            curl_close($ci);
            
            return true;
        }
    }
}