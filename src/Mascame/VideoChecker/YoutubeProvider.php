<?php

namespace Mascame\VideoChecker;

/**
 * Class YoutubeProvider
 * @package Mascame\VideoChecker
 */
class YoutubeProvider extends AbstractChecker {

    private $apiKey = null;

    /**
     * @var string
     */
    protected $url = 'http://img.youtube.com/vi/{id}/0.jpg';

    /**
     * @param null $apiKey
     * @throws \Exception
     */
    public function __construct($apiKey = null) {
        parent::__construct();

        $this->apiKey = $apiKey;
    }

    /**
     * @param $id
     * @param $countryLang ISO country lang
     * @return bool
     */
    public function checkByCountry($id, $countryLang = false)
    {
        if (! $this->apiKey) {
            throw new \Exception('No API key provided for ' . get_called_class());
        }

        if (! parent::check($id)) {
            return false;
        }

        $res = json_decode(file_get_contents('https://www.googleapis.com/youtube/v3/videos?id=' . $id . '&key=' . $this->apiKey . '&part=contentDetails'), true);

        return (! isset($res['items'][0]['contentDetails']['regionRestriction'])
                || in_array($countryLang, $res['items'][0]['contentDetails']['regionRestriction']['allowed']));
    }

}