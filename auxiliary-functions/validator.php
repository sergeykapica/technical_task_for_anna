<?
class Validator
{
    public $fields;
    
    public function __construct($fields)
    {
        $this->fields = $fields;
    }
    
    public function checkFields()
    {
        $fieldsWithError = array();
        
        foreach($this->fields as $fieldName => $field)
        {
            foreach($field['VALIDATOR_PARAMS'] as $paramName => $paramValue)
            {
                if($paramName == 'minSymbolLength' && strlen($field['VALUE']) < $paramValue)
                {
                    $fieldsWithError[$fieldName] = array(
                        'ERROR_MESSAGE' => GetMessage('VALIDATOR_MIN_SYMBOLS') . ' ' . $paramValue
                    );
                    
                    break;
                }
                else if($paramName == 'maxSymbolLength' && strlen($field['VALUE']) > $paramValue)
                {
                    $fieldsWithError[$fieldName] = array(
                        'ERROR_MESSAGE' => GetMessage('VALIDATOR_MAX_SYMBOLS') . ' ' . $paramValue
                    );
                    
                    break;
                }
                else if($paramName == 'isDateFormat' && !preg_match('/^\d{2}\/\d{2}\/\d{4}$/i', $field['VALUE']))
                {
                    $fieldsWithError[$fieldName] = array(
                        'ERROR_MESSAGE' => GetMessage('VALIDATOR_NOT_DATE_FORMAT')
                    );
                    
                    break;
                }
                else if($paramName == 'isEmailFormat' && !preg_match('/.+@.+?\..+/i', $field['VALUE']))
                {
                    $fieldsWithError[$fieldName] = array(
                        'ERROR_MESSAGE' => GetMessage('VALIDATOR_NOT_EMAIL_FORMAT')
                    );
                    
                    break;
                }
                else if($paramName == 'isEmpty' && empty($field['VALUE']))
                {
                    $fieldsWithError[$fieldName] = array(
                        'ERROR_MESSAGE' => GetMessage('VALIDATOR_FIELD_EMPTY')
                    );
                    
                    break;
                }
                else if($paramName == 'conformityPassword' && $field['VALUE'] != '' && $field['VALUE'] != $paramValue)
                {
                    $fieldsWithError[$fieldName] = array(
                        'ERROR_MESSAGE' => GetMessage('VALIDATOR_PASSWORD_UNCONFORMITY')
                    );
                    
                    break;
                }
                else if($paramName == 'placeHolder' && $field['VALUE'] == $paramValue)
                {
                    $fieldsWithError[$fieldName] = array(
                        'ERROR_MESSAGE' => $paramValue
                    );
                    
                    break;
                }
            }
        }
        
        return $fieldsWithError;
    }
}
?>