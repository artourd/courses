<?php
class VideoAdapter {
    private static $DEVELOPER_KEY = 'AIzaSyCN82x2ZgblGdNlFCS3awVRg635bkq85I0'; //youtube

    public static function getData($source, $link) {
        switch ($source) {
            case 'youtube':
                return self::getYoutubeData($link);
                break;

            default:
                break;
        }
    }

    public static function getYoutubeData($link, $count = 1) {
        Yii::import('application.vendors.*');
        require_once 'Google/Client.php';
        require_once 'Google/Service/YouTube.php';

        $client = new Google_Client();
        $client->setDeveloperKey(self::$DEVELOPER_KEY);

        $youtube = new Google_Service_YouTube($client);
        $error = null;
      
        try {
            $searchResponse = $youtube->search->listSearch('id,snippet', array('q' => $link, 'maxResults' => $count));
        } catch (Google_ServiceException $e) {
            $error = $e->getMessage();
        } catch (Google_Exception $e) {
            $error = $e->getMessage();
        }
         
        if ($count == 1){
            return array(
                'success' => empty($error),
                'error' => $error,
                'data' => empty($error) ? $searchResponse['items'][0]['snippet'] : null);
        } else {
            return array(
                'success' => empty($error),
                'error' => $error,
                'items' => empty($error) ? $searchResponse['items'] : null);            
        }
    }
    
    public static function link2data($source, $linkf){
        $link1 = explode('?', $linkf);
        $link2 = explode('=', $link1[1]); 
        $link = $link2[1];

        $data = VideoAdapter::getData($source, $link);

        if ($data['success']){
            $photos = $data['data']->getThumbnails();

            $result = array(
                'success' => true,
                'title' => $data['data']['title'],
                'desc' => $data['data']['description'],
                'alias' => $data['data']['channelId'],
                'picture' => $photos['high']['url'],
                'thumb' => $photos['medium']['url'],
                'ico' => $photos['default']['url'],
                );
        } else {
            $result = array(
                'success' => false,
                'error' => $data['error'],
                );
        }        
        return $result;
    }
}    