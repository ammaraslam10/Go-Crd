<?php
error_reporting(0);
/**
 * easy image resize function
 * @param  $file - file name to resize
 * @param  $string - The image data, as a string
 * @param  $width - new image width
 * @param  $height - new image height
 * @param  $proportional - keep image proportional, default is no
 * @param  $output - name of the new file (include path if needed)
 * @param  $delete_original - if true the original image will be deleted
 * @param  $use_linux_commands - if set to true will use "rm" to delete the image, if false will use PHP unlink
 * @param  $quality - enter 1-100 (100 is best quality) default is 100
 * @return boolean|resource
 */
  function smart_resize_image($file,
                              $string             = null,
                              $width              = 0, 
                              $height             = 0, 
                              $proportional       = false, 
                              $output             = 'file', 
                              $delete_original    = true, 
                              $use_linux_commands = false,
  							  $quality = 100
  		 ) {
      
    if ( $height <= 0 && $width <= 0 ) return false;
    if ( $file === null && $string === null ) return false;

    # Setting defaults and meta
    $info                         = $file !== null ? getimagesize($file) : getimagesizefromstring($string);
    $image                        = '';
    $final_width                  = 0;
    $final_height                 = 0;
    list($width_old, $height_old) = $info;
	$cropHeight = $cropWidth = 0;

    # Calculating proportionality
    if ($proportional) {
      if      ($width  == 0)  $factor = $height/$height_old;
      elseif  ($height == 0)  $factor = $width/$width_old;
      else                    $factor = min( $width / $width_old, $height / $height_old );

      $final_width  = round( $width_old * $factor );
      $final_height = round( $height_old * $factor );
    }
    else {
      $final_width = ( $width <= 0 ) ? $width_old : $width;
      $final_height = ( $height <= 0 ) ? $height_old : $height;
	  $widthX = $width_old / $width;
	  $heightX = $height_old / $height;
	  
	  $x = min($widthX, $heightX);
	  $cropWidth = ($width_old - $width * $x) / 2;
	  $cropHeight = ($height_old - $height * $x) / 2;
    }

    # Loading image to memory according to type
    switch ( $info[2] ) {
      case IMAGETYPE_JPEG:  $file !== null ? $image = imagecreatefromjpeg($file) : $image = imagecreatefromstring($string);  break;
      case IMAGETYPE_GIF:   $file !== null ? $image = imagecreatefromgif($file)  : $image = imagecreatefromstring($string);  break;
      case IMAGETYPE_PNG:   $file !== null ? $image = imagecreatefrompng($file)  : $image = imagecreatefromstring($string);  break;
      default: return false;
    }
    
    
    # This is the resizing/resampling/transparency-preserving magic
    $image_resized = imagecreatetruecolor( $final_width, $final_height );
    if ( ($info[2] == IMAGETYPE_GIF) || ($info[2] == IMAGETYPE_PNG) ) {
      $transparency = imagecolortransparent($image);
      $palletsize = imagecolorstotal($image);

      if ($transparency >= 0 && $transparency < $palletsize) {
        $transparent_color  = imagecolorsforindex($image, $transparency);
        $transparency       = imagecolorallocate($image_resized, $transparent_color['red'], $transparent_color['green'], $transparent_color['blue']);
        imagefill($image_resized, 0, 0, $transparency);
        imagecolortransparent($image_resized, $transparency);
      }
      elseif ($info[2] == IMAGETYPE_PNG) {
        imagealphablending($image_resized, false);
        $color = imagecolorallocatealpha($image_resized, 0, 0, 0, 127);
        imagefill($image_resized, 0, 0, $color);
        imagesavealpha($image_resized, true);
      }
    }
    imagecopyresampled($image_resized, $image, 0, 0, $cropWidth, $cropHeight, $final_width, $final_height, $width_old - 2 * $cropWidth, $height_old - 2 * $cropHeight);
	
	
    # Taking care of original, if needed
    if ( $delete_original ) {
      if ( $use_linux_commands ) exec('rm '.$file);
      else @unlink($file);
    }

    # Preparing a method of providing result
    switch ( strtolower($output) ) {
      case 'browser':
        $mime = image_type_to_mime_type($info[2]);
        header("Content-type: $mime");
        $output = NULL;
      break;
      case 'file':
        $output = $file;
      break;
      case 'return':
        return $image_resized;
      break;
      default:
      break;
    }
    
    # Writing image according to type to the output destination and image quality
    switch ( $info[2] ) {
      case IMAGETYPE_GIF:   imagejpeg($image_resized, $output, $quality);    break;
      case IMAGETYPE_JPEG:  imagejpeg($image_resized, $output, $quality);   break;
      case IMAGETYPE_PNG:  imagejpeg($image_resized, $output, $quality);   break;
      /* MODIFIED & ADDED ^ LINE
      case IMAGETYPE_PNG:
        $quality = 9 - (int)((0.9*$quality)/10.0);
        imagepng($image_resized, $output, $quality); 
        break; */
      default: return false;
    }

    return true;
  } 

function image_upload($file, $target_dir = NULL, $target_name = NULL, $imgwidth = NULL, $imgheight = NULL, $proportional = NULL) {

    global $settings;
    if($target_dir == NULL || $target_dir == ""){ $target_dir = $settings['upload_dir']; }
    if($target_name == NULL || $target_name == ""){ $target_name = time(); }
    $target_file = $target_dir . "/" . $target_name . ".jpg";

    // $fileData = pathinfo(basename($file["name"]));
    // Normally $fileData['extension'] would be used ^ but here all file types are jpg ($fileData['extension'] does not have dot)

    $file_temp = $file['tmp_name'];   
    $uploadOk = 0;
    if(file_exists($file['tmp_name'])) 
    {
        // Check if image file is a actual image or fake image
        $check = getimagesize($file_temp);
        if($check!=false) 
        {
            // Check if file already exists
            if (!file_exists($target_file)) 
            {
                // Check file size
                if($file["size"] < 5000000) 
                {
                    // Allow certain file formats
                    $imageFileType = pathinfo($target_file, PATHINFO_EXTENSION);
                    if($imageFileType == "jpg" || $imageFileType == "png" || $imageFileType == "jpeg" || $imageFileType == "gif") 
                    {
                        // if everything is ok, try to upload file
                        if(move_uploaded_file($file["tmp_name"], $_SERVER['DOCUMENT_ROOT'] . $target_file)) 
                        { 
                            smart_resize_image($_SERVER['DOCUMENT_ROOT'] . $target_file, null, $imgwidth, $imgheight, $proportional, $_SERVER['DOCUMENT_ROOT'] . $target_file, false, false, 70);
                            $uploadOk = 1;
                        } else {
                            $message = "Sorry, there was an error uploading your file. Contact admin."; 
                        }
                   } else {
                       $message = "Sorry, only JPG, JPEG, PNG & GIF files are allowed."; 
                   }
              } else {
                 $message = "Sorry, your file is too large. Upload less than 5 MB."; 
              }
          } else {
              $message = "Image exists already. Message admin."; 
          }
      } else {
          $message = "Sorry, your image was not image."; 
      }
   } else {
      $message = "No image was selected."; 
   }
   if($uploadOk == 1) {
	return true;
   } else {
	return $message;
   }
} 
function re_array_files(&$file_post) {

    $file_ary = array();
    $file_count = count($file_post['name']);
    $file_keys = array_keys($file_post);

    for ($i=0; $i<$file_count; $i++) {
        foreach ($file_keys as $key) {
            $file_ary[$i][$key] = $file_post[$key][$i];
        }
    }

    return $file_ary;
}
?>