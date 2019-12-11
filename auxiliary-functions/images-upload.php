<?
class UploadImages
{
    public function uploadImage($image, $pathToDirectoryStorage)
    {
        $allowtype = array('gif', 'jpg', 'jpeg', 'png');
        $fileName = preg_replace('/\s/m', '', $image['name']);
        $tname = explode(".", strtolower($fileName));
        $type = end($tname);
        
        if(in_array($type, $allowtype)) 
        {
            $imageinfo = getimagesize($image['tmp_name']);
            
            if($imageinfo['mime'] != 'image/gif' && $imageinfo['mime'] != 'image/jpeg' && $imageinfo['mime'] != 'image/jpg' && $imageinfo['mime'] != 'image/png')
            {
                return array(
                    'ERROR' => 'Расширение изображения (' . $type . ') не соответствует заданным типам: gif, jpg, jpeg, png'
                );
            }
            
            $fileNewName = basename($fileName, '.' . $type) . time() . '.' . $type;
            
            if(is_uploaded_file($image['tmp_name']))
            {
                $newImage = $this->resizeUploadImage($image['tmp_name'], $imageinfo['mime']);
                
                if($imageinfo['mime'] == 'image/gif' && !imagegif($newImage, $pathToDirectoryStorage . $fileNewName) || $imageinfo['mime'] == 'image/jpeg' && !imagejpeg($newImage, $pathToDirectoryStorage . $fileNewName) || $imageinfo['mime'] == 'image/jpg' && !imagejpeg($newImage, $pathToDirectoryStorage . $fileNewName) || $imageinfo['mime'] == 'image/png' && !imagepng($newImage, $pathToDirectoryStorage . $fileNewName))
                {
                    return array(
                        'ERROR' => 'При загрузке файла возникла ошибка'
                    );
                }
                else
                {
                    $result = array(
                        'FILE_NAME' => $fileNewName
                    );
                    
                    return $result;
                }
            }
        }
        else
        {
            return array(
                'ERROR' => 'Расширение изображения (' . $type . ') не соответствует заданным типам: gif, jpg, jpeg, png'
            );
        }
    }
    
    public function resizeUploadImage($file, $type)
    {
        if($type == 'image/gif')
        {
            $image = imagecreatefromgif($file);
        }
        else if($type == 'image/jpeg' || $type == 'image/jpg')
        {
            $image = imagecreatefromjpeg($file);
        }
        else
        {
            $image = imagecreatefrompng($file);
        }
        
        $imageOriginalWidth = imagesx($image);
        $imageOriginalHeight = imagesy($image);
        $imageMaxWidth = 320;
        $imageMaxHeight = 240;
        $ratioW = $imageOriginalWidth / $imageMaxWidth;
        $ratioH = $imageOriginalHeight / $imageMaxHeight;
        
        $ratioCoefficient = min($ratioH, $ratioW);
        
        
        $imageMaxWithRatioWidth = round($imageOriginalWidth / $ratioCoefficient);
        $imageMaxWithRatioHeight = round($imageOriginalHeight / $ratioCoefficient);
        $outputImageWidth = $imageMaxWithRatioWidth - ( $imageMaxWithRatioWidth - $imageMaxWidth );
        $outputImageHeight = $imageMaxWithRatioHeight - ( $imageMaxWithRatioHeight - $imageMaxHeight );
        
        $offsetW = $imageMaxWithRatioWidth > $imageMaxWidth ? ( $imageMaxWithRatioWidth - $imageMaxWidth ) / 2 : 0;
        $offsetH = $imageMaxWithRatioHeight > $imageMaxHeight ? ( $imageMaxWithRatioHeight - $imageMaxHeight ) / 2 : 0;
        
        $layerWithRatio = imagecreatetruecolor($imageMaxWithRatioWidth, $imageMaxWithRatioHeight);
        $outputLayer = imagecreatetruecolor($outputImageWidth, $outputImageHeight);
        
        imagecopyresampled($layerWithRatio, $image, 0, 0, 0, 0, $imageMaxWithRatioWidth, $imageMaxWithRatioHeight, $imageOriginalWidth, $imageOriginalHeight);
        imagecopy($outputLayer, $layerWithRatio, 0, 0, $offsetW, $offsetH, $outputImageWidth, $outputImageHeight);
        
        return $outputLayer;
    }
}
?>