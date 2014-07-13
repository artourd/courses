<?php
class VideoAdapter {
    //private static $DEVELOPER_KEY = 'AIzaSyCN82x2ZgblGdNlFCS3awVRg635bkq85I0'; //youtube

    public static function getData($source, $link) {
        switch ($source) {
            case 'youtube': default:
                return self::getYoutubeData($link);
                break;
        }
    }

    public static function getYoutubeData($link, $count = 1) {
        Yii::import('application.vendors.*');
        require_once 'Google/Client.php';
        require_once 'Google/Service/YouTube.php';

        $client = new Google_Client();
        $client->setDeveloperKey(Settings::get('google_api_key'));

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
    
    public static function link2data($source, $link){
        $linkId = self::linkToId($link);

        $data = VideoAdapter::getData($source, $linkId);

        if ($data['success']){
            $photos = $data['data']->getThumbnails();
            
            $result = array(
                'success' => true,
                'title' => $data['data']['title'],
                'desc' => $data['data']['description'],
                'alias' => $linkId,
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
    
    public static function linkToId($link, $source = 'youtube'){
        $linkId = null;
        switch ($source) {
            case 'youtube': default:
                $link1 = explode('?', trim($link));
                $link2 = count($link1) == 2 ? explode('=', $link1[1]) : null;
                $linkId = $link2 && (count($link2) == 2) ? $link2[1] : null;
                break;
        }
        return $linkId;
    }
}    