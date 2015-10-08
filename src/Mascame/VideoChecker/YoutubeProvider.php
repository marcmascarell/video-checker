<?php

namespace Mascame\VideoChecker;

/**
 * Class YoutubeProvider
 * @package Mascame\VideoChecker
 */
class YoutubeProvider extends AbstractChecker {

    /**
     * @var string
     */
    protected $url = 'http://img.youtube.com/vi/{id}/0.jpg';

}