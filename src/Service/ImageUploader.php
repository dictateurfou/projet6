<?php
namespace App\Service;

use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class ImageUploader{
	private $targetDirectory;
	const VALIDTYPE = ["image/jpeg","image/png"];

 	public function __construct($targetDirectory)
    {
        $this->targetDirectory = $targetDirectory;
    }

     public function upload($file)
    {
    	$UploadedFileList = [];
    	/*for one row*/
    	foreach ($file as $key => $value) {
    		//$this->checkValidMimeType($value);
    		/*for file in row*/
    		foreach ($value as $key2 => $value2) {
    			$valid = $this->checkValidMimeType($value2->getMimeType());
    			if($valid == true){
    				$fileName = md5(uniqid()).'.'.$value2->guessExtension();
    				try {
			            $value2->move($this->getTargetDirectory(), $fileName);
			            array_push($UploadedFileList,$fileName);
			        } catch (FileException $e) {
			            // ... handle exception if something happens during file upload
			        }
    			}
    		}
		}

        return $UploadedFileList;
    }

    private function checkValidMimeType($fileType)
    {
    	$i = 0;
    	$valid = false;
    	while(count(self::VALIDTYPE) > $i){
    		if(self::VALIDTYPE[$i] == $fileType){
    			$valid = true;
    			break;
    		}
    		$i++;
    	}
    	return $valid;
    }

    public function getTargetDirectory()
    {
        return $this->targetDirectory;
    }
}