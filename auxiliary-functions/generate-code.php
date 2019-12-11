<?

class GenerateCode
{
    public static function generateRandomCode($length)
    {
        global $oDataHandlers;
        
        $code = '';
        $codeLength = $length;
        $words = range('a', 'z');
        $numbers = range(0, 9);
        $allSymbols = array_merge($words, $numbers);

        for($i = 0; $i < $codeLength; $i++)
        {
            $code .= $allSymbols[rand(0, ( count($allSymbols) - 1 ))];
        }
        
        return $code;
    }
}