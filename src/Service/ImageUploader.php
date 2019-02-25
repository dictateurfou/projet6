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

     public function upload($imageList)
    {
    	/*for one row*/
    	foreach ($imageList as $key => $value) {
    		$valid = $this->checkValidMimeType($value->getFile()->getMimeType());
			if($valid == true){
				$fileName = md5(uniqid()).'.'.$value->getFile()->guessExtension();
				try {
		            $value->getFile()->move($this->getTargetDirectory(), $fileName);
		            $value->setName($fileName);

		        } catch (FileException $e) {
		            // ... handle exception if something happens during file upload
		        }
			}
		}
    }

    public function uploadEdit($trick){
        $imageList = $trick->getImageList();
        foreach ($imageList as $key => $value) {
            if($value->getFile() !== null){
                dump($value);
                $valid = $this->checkValidMimeType($value->getFile()->getMimeType());
                if($valid == true){
                    $fileName = $value->getName();
                    $newFileName = md5(uniqid()).'.'.$value->getFile()->guessExtension();
                    try {
                        $this->deleteFile($fileName);
                        $value->getFile()->move($this->getTargetDirectory(), $newFileName);
                        $value->setName($newFileName);
                        dump($value);
                    } catch(FileException $e){
                        $trick->removeImageList($imageList);
                    }
                }
                else{
                    if($imageList->getName() == null){
                        $trick->removeImageList($imageList);
                    }
                }
            }
        }
    }

    private function deleteFile($name){
        $myFile = $this->getTargetDirectory()."/".$name;
        if(file_exists($myFile)) {
            unlink($myFile) or die("Couldn't delete file");
        }
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