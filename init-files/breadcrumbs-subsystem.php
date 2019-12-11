<?

class BreadCrumbs
{
    protected $urlSegments;
    protected $urlOriginalSegmentsNames;
    
    public function __construct($url)
    {
        $urlSegments = explode('/', $url);
        $urlSegments[0] = '/';
        
        $this->urlSegments = $urlSegments;
        $this->urlOriginalSegmentsNames = array(
            '/' => GetMessage('MAIN_SECTION'),
            'personal' => GetMessage('PERSONAL_SECTION')
        );
    }
    
    public function getBreadCrumbString()
    {
        $breadCrumbString = '';
        $urlSegmentsKeys = array_keys($this->urlSegments);
        $lastKey = array_pop($urlSegmentsKeys);
        
        foreach($this->urlSegments as $uSegmentKey => $uSegmentValue)
        {
            if($uSegmentValue != '' && isset($this->urlOriginalSegmentsNames[$uSegmentValue]))
            {
                $breadCrumbString .= '<a href="/' . ( $uSegmentValue == '/' ? '' : $uSegmentValue ) . '" class="breadcrumb-link">' . $this->urlOriginalSegmentsNames[$uSegmentValue] . '</a>';

                if($uSegmentKey !== $lastKey && $this->urlSegments[1] !== '')
                {
                    $breadCrumbString .= '<span class="breadcrumb-separator">/</span>';
                }
            }
        }
        
        return $breadCrumbString;
    }
}