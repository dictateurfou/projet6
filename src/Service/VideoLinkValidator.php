<?php
namespace App\Service;

class VideoLinkValidator{
	const YOUTUBEURL = ["youtube.com","youtu.be"];
	const EMBEDYOUTUBEURLBASE = "https://www.youtube.com/embed/";
	const EMBEDDAILYMOTIONBASE = "https://www.dailymotion.com/embed/video/";
	const DAILYMOTIONURL = ["dailymotion.com","dai.ly"];
	const AVAILABLEURL = ["youtube" => self::YOUTUBEURL,"dailymotion" => self::DAILYMOTIONURL];


	public function checkUrl($listUrl){
		$finalList = [];
		foreach ($listUrl as $key => $value){
			$result = $this->checkValidUrl($value);
			if($result !== false){
				array_push($finalList,$result);
			}
		}
		return $finalList;
	}

	private function checkEmbed($url){
		$embed = false;
		if(strpos($url,"embed") == true){
			$embed = true;
		}
		return $embed;
	}

	private function convertYoutubeUrl($url){
		$query = parse_url($url, PHP_URL_QUERY);
		$explodeQuery = explode('&',$query);
		$videoLink = false;
		if($explodeQuery[0] !== ""){
			$video = substr($explodeQuery[0],2);
			$videoLink = self::EMBEDYOUTUBEURLBASE.$video;
		}
		else{
			$linkExplode = explode('/',$url);
			$video = $linkExplode[count($linkExplode) - 1];
			$videoLink = self::EMBEDYOUTUBEURLBASE.$video;
			/*invalid url*/
			if(count($linkExplode) == 1){
				$videoLink = false;
				$url = false;
			}
		}

		if($videoLink == false){
			return $url;
		}
		else{
			return $videoLink;
		}
		
	}

	private function convertDailymotionUrl($url){
		var_dump("passe");
		$linkExplode = explode('/',$url);
		$video = $linkExplode[count($linkExplode) - 1];
		

		//if contain query argument (playlist)
		if(parse_url($url, PHP_URL_QUERY) !== NULL){
			var_dump("argument");
			$video = explode('?',$video)[0];
		}
		$videoLink = self::EMBEDDAILYMOTIONBASE.$video;
		/*invalid url*/
		if(count($linkExplode) == 1){
			$videoLink = false;
		}
		if($videoLink == false){
			return false;
		}
		else{
			return $videoLink;
		}
	}

	private function checkValidUrl($url){
		$result = false;
		$i = 0;
		foreach (self::AVAILABLEURL as $key => $value) {
			$e = 0;
			while(count(self::AVAILABLEURL[$key]) > $e){
				if(strpos($url, self::AVAILABLEURL[$key][$e])){
					$result = $url;
					$embed = $this->checkEmbed($url);
					if($key == "youtube"){
						if($embed == false){
							$result = $this->convertYoutubeUrl($url);
						}
					}
					else if($key == "dailymotion"){
						if($embed == false){
							$result = $this->convertDailymotionUrl($url);
						}
					}
					break;
				}
				$e++;
			}
		}
		return $result;
	}
}