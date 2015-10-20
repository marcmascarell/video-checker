<?php

namespace Mascame\VideoChecker;

/**
 * Class AbstractChecker
 * @package Mascame\VideoChecker
 */
abstract class AbstractChecker implements CheckerInterface {

    /**
     * @var null
     */
    protected $url = null;

    /**
     * @throws \Exception
     */
    public function __construct() {
        if (! $this->url) {
            throw new \Exception('No url provided for ' . get_called_class());
        }
    }

    /**
     * @param $id
     * @return mixed
     */
    protected function buildURL($id) {
        return str_replace('{id}', $id, $this->url);
    }

    /**
     * @param $id
     * @return bool
     */
    public function check($id) {
        $headers = get_headers($this->buildURL($id));

        if (! $headers) return false;

        return (strpos($headers[0], '200 OK') !== false);
    }
}