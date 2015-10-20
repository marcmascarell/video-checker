<?php

namespace Mascame\VideoChecker;

/**
 * Class YoutubeProvider
 * @package Mascame\VideoChecker
 */
class YoutubeProvider extends AbstractChecker {

    const YOUTUBE_KEY = "";

    /**
     * @param $id
     * @param $countryLang ISO country lang
     * @return bool
     */
    public function checkByCountry($id, $countryLang = false)
    {
        if (!parent::check($id)) {
            return false;
        } else {
            $res = json_decode(file_get_contents('https://www.googleapis.com/youtube/v3/videos?id=' . $id . '&key=' . self::YOUTUBE_KEY . '&part=contentDetails'), true);

            if (in_array($countryLang, $res['items'][0]['contentDetails']['regionRestriction']['allowed'])) {
                return true;
            } else {
                return false;
            }
        }
    }

    /**
     * @var string
     */
    protected $url = 'http://img.youtube.com/vi/{id}/0.jpg';

}