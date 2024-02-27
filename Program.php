
<?php 
    class Program {
        protected const API_URI = "https://picsum.photos/v2/list?limit=100";
        protected const MAX_PAGE = 10;
        protected const REQUEST_OPTIONS = [
            CURLOPT_CUSTOMREQUEST => "GET" , 
            CURLOPT_RETURNTRANSFER => true , 
            CURLOPT_FOLLOWLOCATION => true 
        ];
        protected const OUT_DIR = __DIR__.DIRECTORY_SEPARATOR."OUT";
        public function main():void {
            for($counter = 1 ; $counter <= self::MAX_PAGE ; $counter++){
                $uri = static::API_URI."&page=$counter";
                $images = $this->getImages($uri);
                $destination = self::OUT_DIR."/page-{$counter}";
                mkdir($destination);
                foreach($images as $key=>$image){
                    var_dump("execute for page $counter and image $key");
                    $imageId = $image->id ;
                    $imageUrl = $image->download_url;
                    $imageContent = $this->getImage($imageUrl);
                    $imageName = $destination."/$imageId.jpg";
                    file_put_contents($imageName,$imageContent);
                    var_dump("execute for image $key is done ....");
                }
            }

        }
        protected function getImages($url):array {
            $request = curl_init($url);
            curl_setopt_array($request,static::REQUEST_OPTIONS);
            $response = curl_exec($request);
            curl_close($request);
            $images = json_decode($response);
            return $images;
        }
        protected function getImage(string $url):string {
            $request = curl_init($url);
            curl_setopt_array($request,self::REQUEST_OPTIONS);
            $image = curl_exec($request);
            curl_close($request);
            return $image;
        }
    }
?>