<?php
class VideoAdapter {
    private static $DEVELOPER_KEY = 'AIzaSyDrEVQwrxxXd_jFAx-cFj6cCzqQxJVY4Vo'; //youtube

    public static function getData($source, $link) {
        switch ($source) {
            case 'youtube':
                return self::getYoutubeData($link);
                break;

            default:
                break;
        }
    }

    public static function getYoutubeData($link) {
        Yii::import('application.vendors.*');
        require_once 'Google/Client.php';
        require_once 'Google/Service/YouTube.php';

        $client = new Google_Client();
        $client->setDeveloperKey(self::$DEVELOPER_KEY);

        $youtube = new Google_Service_YouTube($client);
        $error = null;
      
        try {
            $searchResponse = $youtube->search->listSearch('id,snippet', array('q' => $link, 'maxResults' => 1));
        } catch (Google_ServiceException $e) {
            $error = $e->getMessage();
        } catch (Google_Exception $e) {
            $error = $e->getMessage();
        }
         
        return array(
            'success' => empty($error),
            'error' => $error,
            'data' => empty($error) ? $searchResponse['items'][0]['snippet'] : null);
    }
}    