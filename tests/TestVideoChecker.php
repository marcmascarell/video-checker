<?php

class TestVideoChecker extends PHPUnit_Framework_TestCase
{
    const FAKE_VIDEO_ID = 'FAKE-VIDEO-ID';

    const YOUTUBE_API_KEY = 'AIzaSyD7BZyj9W0rnCN8yJQd0bH1mGQRbYn9P9c';

    protected $youtubeCountryFail = [
        'GOHXRe9o_Ls',
        'bo2qWi7ENSc',
        'jekBUo2uN8M',
        'Sts3GeZszAI',
        's6mMvBeEPT4',
    ];

    protected $youtubeCountryOk = [
        'SVaD8rouJn0',
        'Zb5IH57SorQ',
        'iopcfR1vI5I',
    ];

    protected $dailymotionOk = [
        'x38qhbu',
        'x38uaw8',
        'x38nx3w',
        'x38spmm',
        'x38a603',
        'x38ugxu'
    ];

    public function testYoutubeOkProvider()
    {
        $this->provider(new \Mascame\VideoChecker\YoutubeProvider(), [
            'SVaD8rouJn0',
            'Zb5IH57SorQ',
            'iopcfR1vI5I',
            '1G4isv_Fylg',
            '1Uw6ZkbsAH8',
        ]);
    }

    public function testYoutubeKoProvider()
    {
        $this->provider(new \Mascame\VideoChecker\YoutubeProvider(), [
            'Q1Im__cEBr0',
            'E9ac6FM4R7o',
            's6mMvBeEPT4'
        ], false);
    }

    public function testYoutubeArrayByCountryProvider()
    {
        $youtubeProvider = new \Mascame\VideoChecker\YoutubeProvider(self::YOUTUBE_API_KEY);

        $ids = array_merge($this->youtubeCountryFail, $this->youtubeCountryOk);

        $results = $youtubeProvider->check($ids, 'ES');

        foreach ($results as $id => $validOrNot) {
            if (in_array($id, $this->youtubeCountryFail)) {
                $this->assertFalse($validOrNot);
            } else {
                $this->assertTrue($validOrNot);
            }
        }
    }

    public function testYoutubeByCountryKoProvider()
    {
        $this->provider(new \Mascame\VideoChecker\YoutubeProvider(self::YOUTUBE_API_KEY), $this->youtubeCountryFail, false, 'ES');
    }

    public function testYoutubeByCountryOkProvider()
    {
        $this->provider(new \Mascame\VideoChecker\YoutubeProvider(self::YOUTUBE_API_KEY), $this->youtubeCountryOk, $assert = true, 'ES');
    }

    public function testVimeoProvider()
    {
        $this->provider(new \Mascame\VideoChecker\VimeoProvider(), [
            '141374353',
            '141518601',
            '106681343',
            '140514801',
            '35925323',
            '33917836'
        ]);
    }

    public function testDailymotionProvider()
    {
        $this->provider(new \Mascame\VideoChecker\DailymotionProvider(), $this->dailymotionOk);
    }

    public function testDailymotionArrayProvider()
    {
        $dailymotionProvider = new \Mascame\VideoChecker\DailymotionProvider();
        $results = $dailymotionProvider->check($this->dailymotionOk);

        foreach ($results as $id => $validOrNot) {
            $this->assertTrue($validOrNot);
        }
    }

    public function provider(\Mascame\VideoChecker\CheckerInterface $provider, $workingVideos = [], $assert = true, $country = 'US')
    {
        foreach ($workingVideos as $video) {
            if ($assert) {
                $this->assertTrue($provider->check($video, $country));
            } else {
                $this->assertFalse($provider->check($video, $country));
            }
        }
    }

}
