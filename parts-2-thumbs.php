<?php
//turn on error reporting
error_reporting(E_ALL);

//sets default time zone (this is irrelevant to the operation of this script)
date_default_timezone_set('America/New_York');

echo '<html>
<head>
<title>AutoPartsMan | parts-2-thumbs</title>
</head>
<body>';

//set the folder name that contains the images
$folder_name = "images";

//set the large image max size
$li_max_size = 640;

//set the medium image max size
$mi_max_size = 400;

//set the small image max size
$si_max_size = 150;


//opening this file in your browser will execute the php scripting inside this file
//looks for a directory (folder) named "images" in the same directory level as this file
//scans the "images" folder for jpg images
//creates 3 subfolders in the "images" folder named "large", "medium", and "small"
//copies each image and resizes them to the max sizes that you specify above.
//creates corresponding folders with the same file names as original image (large, medium, small)
//does not affect original images


//loop counter
$fp = 0;

$myfilese = scandir($folder_name);

foreach($myfilese as $mfe)
{
	$ifilename = $mfe;

	if($mfe != '.' && $mfe != '..' && $mfe != '.ftpquota' && is_dir($mfe) === FALSE)
	{
		//process JPG
		if(substr($mfe,-3) == 'JPG' || substr($mfe,-3) == 'jpg')
		{
			if(substr($mfe,-3) == 'JPG' || substr($mfe,-3) == 'jpg')
			{
				$image = imagecreatefromjpeg($folder_name . '/' . $ifilename);
			}

			list($width_orig, $height_orig) = getimagesize($folder_name . '/' . $ifilename);

			$width = $li_max_size;
			$height = $li_max_size;
			
			$ratio_orig = $width_orig/$height_orig;
			if($width/$height > $ratio_orig)
			{
			   $width = $height*$ratio_orig;
			}
			else
			{
			   $height = $width/$ratio_orig;
			}

			$image_p = imagecreatetruecolor($width, $height);
			
			imagecopyresampled($image_p, $image, 0, 0, 0, 0, $width, $height, $width_orig, $height_orig);


			if(!file_exists($folder_name . '/large/'))
			{
				$structure = $folder_name . '/large/';

				if(!mkdir($structure,0777))
				{
					die('Failed to create folder named (large)');
				}
			}

			if(substr($mfe,-3) == 'JPG' || substr($mfe,-3) == 'jpg')
			{
				imagejpeg($image_p, $folder_name . '/large/' . $ifilename, 90);
			}

			$width = $mi_max_size;
			$height = $mi_max_size;

			if($width/$height > $ratio_orig)
			{
			   $width = $height*$ratio_orig;
			}
			else
			{
			   $height = $width/$ratio_orig;
			}

			$image_p = imagecreatetruecolor($width, $height);

			imagecopyresampled($image_p, $image, 0, 0, 0, 0, $width, $height, $width_orig, $height_orig);

			if(!file_exists($folder_name . '/medium/'))
			{
				$structure = $folder_name . '/medium/';

				if(!mkdir($structure, 0777))
				{
					die('Failed to create folder named (medium)');
				}
			}

			if(substr($mfe,-3) == 'JPG' || substr($mfe,-3) == 'jpg')
			{
				imagejpeg($image_p, $folder_name . '/medium/' . $ifilename, 90);
			}

			$width = $si_max_size;
			$height = $si_max_size;

			if($width/$height > $ratio_orig)
			{
			   $width = $height*$ratio_orig;
			}
			else
			{
			   $height = $width/$ratio_orig;
			}

			$image_p = imagecreatetruecolor($width, $height);

			imagecopyresampled($image_p, $image, 0, 0, 0, 0, $width, $height, $width_orig, $height_orig);

			if(!file_exists($folder_name . '/small/'))
			{
				$structure = $folder_name . '/small/';

				if(!mkdir($structure, 0777))
				{
					die('Failed to create folder named (small)');
				}
			}

			if(substr($mfe,-3) == 'JPG' || substr($mfe,-3) == 'jpg')
			{
				imagejpeg($image_p, $folder_name . '/small/' . $ifilename, 90);
			}

			imagedestroy($image_p);
			imagedestroy($image);
			
			$fp++;
		}

	}
}


echo '<br>It appears that you have processed ' . $fp . ' images from the folder &quot;' . $folder_name . '&quot;<br> ';

echo '</body>
</html>';
?>
