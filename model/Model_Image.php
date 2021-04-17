<?php
namespace Model;

use Engine\Model_Base;
use Engine\Image;

class Model_Image extends Model_Base {
	/**
	*	
	*	@param filename string
	*	@param width 
	*	@param height
	*	@param type char [default, w, h]
	*				default = scale with white space, 
	*				w = fill according to width, 
	*				h = fill according to height
	*	
	*/
	public function resize($filename, $width, $height, $type = "") {
        require_once HELPER_DIR . 'utf8.php';

		if (!file_exists(IMAGES_DIR . $filename) || !is_file(IMAGES_DIR . $filename)) {
			$filename = "noimage.jpg";
		} 
		
		$info = pathinfo($filename);
		
		$extension = $info['extension'];
		
		$old_image = $filename;
		$new_image = 'cache/' . utf8_substr($filename, 0, utf8_strrpos($filename, '.')) . '-' . $width . 'x' . $height . $type .'.' . $extension;

		if (!file_exists(IMAGES_DIR . $new_image) || (filemtime(IMAGES_DIR . $old_image) > filemtime(IMAGES_DIR . $new_image))) {
			$path = '';
			
			$directories = explode('/', dirname(str_replace('../', '', $new_image)));
			
			foreach ($directories as $directory) {
				$path = $path . '/' . $directory;
				
				if (!file_exists(IMAGES_DIR . $path)) {
					@mkdir(IMAGES_DIR . $path, 0777);
				}		
			}

			list($width_orig, $height_orig) = getimagesize(IMAGES_DIR . $old_image);

			if ($width_orig != $width || $height_orig != $height) {
				$image = new Image(IMAGES_DIR . $old_image);
				$image->resize($width, $height, $type);
				$image->save(IMAGES_DIR . $new_image);
			} else {
				copy(IMAGES_DIR . $old_image, IMAGES_DIR . $new_image);
			}
		}

        return $new_image;
	}
}
