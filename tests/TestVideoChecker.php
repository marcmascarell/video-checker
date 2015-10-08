<?php

class TestVideoChecker extends PHPUnit_Framework_TestCase
{
    const FAKE_VIDEO_ID = 'FAKE-VIDEO-ID';

    public function testYoutubeProvider()
    {
        $this->provider(new \Mascame\VideoChecker\YoutubeProvider(), [
            'SVaD8rouJn0',
            'Zb5IH57SorQ',
            's6mMvBeEPT4',
            'iopcfR1vI5I',
            '1G4isv_Fylg',
            '1Uw6ZkbsAH8',
        ]);
    }

    public function testVimeoProvider()
    {
        $this->provider(new \Mascame\VideoChecker\VimeoProvider(), [
            '141374353',
            '141518601',
            '106681343',
            '140514801',
            '35925323',
            '33917836',
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
            'x38ugxu',
        ]);
    }

    public function provider(\Mascame\VideoChecker\CheckerInterface $provider, $workingVideos = [])
    {
        foreach ($workingVideos as $video) {
            $this->assertTrue($provider->check($video));
        }

        $this->assertFalse($provider->check(self::FAKE_VIDEO_ID . rand()));
        $this->assertFalse($provider->check(self::FAKE_VIDEO_ID . rand()));
        $this->assertFalse($provider->check(self::FAKE_VIDEO_ID . rand()));
    }
}
