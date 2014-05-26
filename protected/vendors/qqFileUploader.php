<?php

/**
* Handle file uploads via XMLHttpRequest
*/
class qqUploadedFileXhr {
    /**
* Save the file to the specified path
* @return boolean TRUE on success
*/
    function save($path) {
        $input = fopen("php://input", "r");
        $temp = tmpfile();
        $realSize = stream_copy_to_stream($input, $temp);
        fclose($input);
        
        if ($realSize != $this->getSize()){
            return false;
        }
        
        $target = fopen($path, "w");
        fseek($temp, 0, SEEK_SET);
        stream_copy_to_stream($temp, $target);
        fclose($target);
        
        return true;
    }
    function getName() {
        return $_GET['qqfile'];
    }
    function getSize() {
        if (isset($_SERVER["CONTENT_LENGTH"])){
            return (int)$_SERVER["CONTENT_LENGTH"];
        } else {
            throw new Exception('Getting content length is not supported.');
        }
    }
}

/**
* Handle file uploads via regular form post (uses the $_FILES array)
*/
class qqUploadedFileForm {
    /**
* Save the file to the specified path
* @return boolean TRUE on success
*/
    function save($path) {
        if(!move_uploaded_file($_FILES['qqfile']['tmp_name'], $path)){
            return false;
        }
        return true;
    }
    function getName() {
        return $_FILES['qqfile']['name'];
    }
    function getSize() {
        return $_FILES['qqfile']['size'];
    }
}

class qqFileUploader {
    private $allowedExtensions = array();
    private $sizeLimit = 10485760;
    private $file;

    function __construct(array $allowedExtensions = array(), $sizeLimit = 10485760){
        $allowedExtensions = array_map("mb_strtolower", $allowedExtensions);
            
        $this->allowedExtensions = $allowedExtensions;
        $this->sizeLimit = $sizeLimit;
        
        $this->checkServerSettings();

        if (isset($_GET['qqfile'])) {
            $this->file = new qqUploadedFileXhr();
        } elseif (isset($_FILES['qqfile'])) {
            $this->file = new qqUploadedFileForm();
        } else {
            $this->file = false;
        }
    }
    
    private function checkServerSettings(){
        $postSize = $this->toBytes(ini_get('post_max_size'));
        $uploadSize = $this->toBytes(ini_get('upload_max_filesize'));
        if ($postSize < $this->sizeLimit || $uploadSize < $this->sizeLimit){
            $size = max(1, $this->sizeLimit / 1024 / 1024) . 'M';
            die("{'error':'increase post_max_size and upload_max_filesize to $size'}");
        }
    }
    
    private function toBytes($str){
        $val = trim($str);
        $last = mb_strtolower($str[strlen($str)-1]);
        switch($last) {
            case 'g': $val *= 1024;
            case 'm': $val *= 1024;
            case 'k': $val *= 1024;
        }
        return $val;
    }
    
    /**
* Returns array('success'=>true) or array('error'=>'error message')
*/
    function handleUpload($uploadDirectory, $replaceOldFile = FALSE, $preview = array()){
        if (!is_writable($uploadDirectory)){
            return array('success'=>false, 'error' => "Server error. Upload directory isn't writable.");
        }
        
        if (!$this->file){
            return array('success'=>false, 'error' => 'No files were uploaded.');
        }
        
        $size = $this->file->getSize();
        
        if ($size == 0) {
            return array('success'=>false, 'error' => 'File is empty');
        }
        
        if ($size > $this->sizeLimit) {
            return array('success'=>false, 'error' => 'File is too large');
        }
        
        $pathinfo = pathinfo($this->file->getName());
        $filename = transliterate($pathinfo['filename']);

        //$filename = md5(uniqid());
        $ext = mb_strtolower($pathinfo['extension']);

        if($this->allowedExtensions && !in_array(mb_strtolower($ext), $this->allowedExtensions)){
            $these = implode(', ', $this->allowedExtensions);
            return array('success'=>false, 'error' => 'File has an invalid extension, it should be one of '. $these . '.');
        }
        
        if(!$replaceOldFile){
            /// don't overwrite previous files that were uploaded
            while (file_exists($uploadDirectory . $filename . '.' . $ext)) {
                $filename .= '_' . rand(10, 99);
            }
        }
                        
        $fullPhotoPath = $uploadDirectory . $filename . '.' . $ext;
        $fullNamePreview = $fullPhotoPath;
        
        if ($this->file->save($fullPhotoPath)){
          if (!empty($preview)){ //saving preview
						include_once("sources/php/image/class.upload.php");
														
            foreach ($preview as $key => $image){
              $fullNamePreview = $uploadDirectory . 'thb' . $key . '_' . $filename . '.' . $ext;
							
							$handle = new upload($fullPhotoPath);

							if($handle->uploaded) {
								$handle->file_new_name_body = 'thb' . $key . '_' . $filename;
								$handle->image_resize = (isset($image['resize']) ? $image['resize'] : true);
								$handle->image_y = $image['height'];
								$handle->image_x = $image['width'];
								$handle->jpeg_quality = 90;
								$handle->image_ratio_fill = (empty($image['ratio']) ? 'C' : $image['ratio']);
								$handle->image_ratio_crop = (empty($image['crop']) ? false : $image['crop']);
								
								//маленькие фото не увеличиваются, а заполняются бекграундом
								if (($handle->image_dst_x < $image['width']) && ($handle->image_dst_y < $image['height'])){
									$imgx = floor(($image['width'] - $handle->image_dst_x)/2);
									$imgy = floor(($image['height'] - $handle->image_dst_y)/2);
									
									$handle->image_resize = false;
								  $handle->image_crop = '-'.$imgy.'px -'.$imgx.'px';
								}
																
								$handle->process($uploadDirectory);
								if(!$handle->processed) {
									return array('success'=>false, 'error' => 'Error cropping: '.$handle->error);
								}
							} else {
								return array('success'=>false, 'error' => 'Error cropping not construct!');
							}		
            }
          }          

          return array('success'=>true, 'path'=> $filename.'.'.$ext, 'preview' => $fullNamePreview);
        } else {
          return array('success'=>false, 'error'=> 'Could not save uploaded file.' .
              'The upload was cancelled, or server error encountered');
        }
        
    }
}
?>
