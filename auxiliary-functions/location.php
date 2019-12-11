<?

trait Location
{
    public static function getLocationsList()
    {
        $locationsList = simplexml_load_file($_SERVER['DOCUMENT_ROOT'] . '/sources/data-list/peace-countries-towns-list.xml');
        
        $locationsListResult = array();
        
        foreach($locationsList->country as $country)
        {
            $locationsListResult['COUNTRY_LIST'][] = $country;
        }
        
        foreach($locationsList->city as $city)
        {
            $locationsListResult['CITY_LIST'][] = $city;
        }
        
        return $locationsListResult;
    }
}