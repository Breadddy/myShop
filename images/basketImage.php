<?php
header("Content-type: image/jpeg"); 
$img = imagecreatefromjpeg("basket.jpg");
$font="helvica";
$red = imageColorAllocate($img, 255, 0, 0);
$white = imageColorAllocate($img, 255, 255, 255);
if(isset($_COOKIE['basket']))
{   $basket = unserialize(base64_decode($_COOKIE['basket']));
    $k=count($basket);
    putenv('GDFONTPATH=' . realpath('.'));
    if($k>100)
        {   
            imagefilledellipse($img, 255, 370, 350, 230,$white);
            imagettftext ( $img , 130 , 0 , 110 , 420 , $red , $font , "$k" );
        }
    else if($k>9)
    {
        imagefilledellipse($img, 342, 355, 210, 170,$white);
        imagettftext ( $img , 130 , 0 , 230 , 420 , $red , $font , "$k" );
    }
    else if($k>0)
    {
        imagefilledellipse($img, 350, 355, 120, 150,$white);
        imagettftext ( $img , 130 , 0 , 300 , 420 , $red , $font , "$k" );
    }
}
imagejpeg($img);