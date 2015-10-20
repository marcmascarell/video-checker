<?php

class TestVideoChecker extends PHPUnit_Framework_TestCase
{
    const FAKE_VIDEO_ID = 'FAKE-VIDEO-ID';

    public function testYoutubeOkProvider()
    {
        $this->provider(new \Mascame\VideoChecker\YoutubeProvider(), [
            'SVaD8rouJn0',
            'Zb5IH57SorQ',
            's6mMvBeEPT4',
            'iopcfR1vI5I',
            '1G4isv_Fylg',
            '1Uw6ZkbsAH8'
        ]);
    }

    public function testYoutubeKoProvider()
    {
        $this->providerCountry(new \Mascame\VideoChecker\YoutubeProvider(), [
            'GOHXRe9o_Ls',
            'bo2qWi7ENSc',
            'jekBUo2uN8M',
            'Sts3GeZszAI'
        ], false, 'ES');
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
        $this->provider(new \Mascame\VideoChecker\DailymotionProvider(), [
            'x38qhbu',
            'x38uaw8',
            'x38nx3w',
            'x38spmm',
            'x38a603',
            'x38ugxu'
        ]);
    }

    public function provider(\Mascame\VideoChecker\CheckerInterface $provider, $workingVideos = [], $assert = true)
    {
        foreach ($workingVideos as $video) {
            if ($assert) {
                $this->assertTrue($provider->check($video));
            } else {
                $this->assertFalse($provider->check($video));
            }
        }
    }

    public function providerCountry(\Mascame\VideoChecker\CheckerInterface $provider, $workingVideos = [], $assert = true, $country = 'US')
    {
        foreach ($workingVideos as $video) {
            if ($assert) {
                $this->assertTrue($provider->checkByCountry($video, $country));
            } else {
                $this->assertFalse($provider->checkByCountry($video, $country));
            }
        }
    }
}
