<?php

namespace Mascame\VideoChecker;

/**
 * Class YoutubeProvider
 * @package Mascame\VideoChecker
 */
class YoutubeProvider extends AbstractChecker {

    private $apiKey = null;

    protected $url = 'https://www.youtube.com/watch?v={id}';

    protected $checkRegex = "/id=\\\"player-unavailable\\\" class=\\\".*(hid\\s).*?\\\"/";

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
     * @return bool
     */
    public function check($id) {
        return $this->checkByRegex($id);
    }

    /**
     * @param $id
     * @return bool
     */
    public function checkByRegex($id) {
        $contents = file_get_contents(
            $this->buildURL($id, $this->url)
        );

        preg_match($this->checkRegex, $contents, $matches);

        // If there are no matches its not available
        return (empty($matches)) ? false : true;
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

        if (! $this->check($id)) {
            return false;
        }

        $res = json_decode(file_get_contents('https://www.googleapis.com/youtube/v3/videos?id=' . $id . '&key=' . $this->apiKey . '&part=contentDetails'), true);

        // If no restriction key we assume its valid
        return (! isset($res['items'][0]['contentDetails']['regionRestriction'])
            || isset($res['items'][0]['contentDetails']['regionRestriction']['allowed'])
            && in_array($countryLang, $res['items'][0]['contentDetails']['regionRestriction']['allowed']));
    }

}