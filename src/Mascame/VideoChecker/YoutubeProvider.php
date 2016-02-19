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

    protected $checkedLinks = [];

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
     * @param bool|false $country ISO
     * @return bool
     * @throws \Exception
     */
    public function check($id, $country = false) {
        if (! $this->apiKey) return $this->checkByRegex($id);

        if ($this->simpleCheck($id)) {
            if ($country) return $this->checkByCountry($id, $country);

            return true;
        }

        return false;
    }

    /**
     * Use if you don't have API key or you make low volume requests
     *
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
     * If there are results, video exists (you still should take care of country)
     *
     * @param $id
     * @return bool
     */
    protected function simpleCheck($id) {
        $res = $this->apiRequest($id);

        return (isset($res['pageInfo']['totalResults']) && $res['pageInfo']['totalResults'] > 0);
    }

    /**
     * @param $id
     * @param bool|false $country
     * @return bool
     * @throws \Exception
     */
    protected function checkByCountry($id, $country = false) {
        $res = $this->apiRequest($id);

        // If no restriction key we assume its valid
        return (
            ! isset($res['items'][0]['contentDetails']['regionRestriction'])
            || isset($res['items'][0]['contentDetails']['regionRestriction']['allowed']) && in_array($country, $res['items'][0]['contentDetails']['regionRestriction']['allowed'])
            || isset($res['items'][0]['contentDetails']['regionRestriction']['blocked']) && ! in_array($country, $res['items'][0]['contentDetails']['regionRestriction']['blocked'])
        );
    }

    protected function apiRequest($id) {
        if (isset($this->checkedLinks[$id])) return $this->checkedLinks[$id];

        $this->checkedLinks[$id] = json_decode(
            file_get_contents('https://www.googleapis.com/youtube/v3/videos?id=' . $id . '&key=' . $this->apiKey . '&part=contentDetails'),
            true
        );

        return $this->checkedLinks[$id];
    }

}