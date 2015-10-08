Video Checker
=========

[![Latest Stable Version](https://poser.pugx.org/mascame/arrayer/v/stable.svg)](https://packagist.org/packages/mascame/video-checker)
[![License](https://poser.pugx.org/mascame/arrayer/license.svg)](https://packagist.org/packages/mascame/video-checker)

Check if a video is available online.

Installation
--------------

Require this package in your composer.json and run composer update:

    "mascame/video-checker": "1.*"


Usage
--------------

Just use `->check(videoId)` with the provider you want

```php

$yt = new Mascame\VideoChecker\YoutubeProvider();

var_dump($yt->check('C7OfO6r_5m0')); // true
var_dump($yt->check('CWO3Tuo35-o')); // false


$vimeo = new Mascame\VideoChecker\VimeoProvider();

var_dump($vimeo->check(31161781)); // true
var_dump($vimeo->check('34134308a')); // false


$dm = new Mascame\VideoChecker\DailymotionProvider();

var_dump($dm->check('x38rpxc')); // true
var_dump($dm->check('x38rpxc3232')); // false

```

Changelog
----

### 1.0
- Added Youtube, Vimeo & Dailymotion providers


Support
----

If you want to give your opinion, you can send me an [email](mailto:marcmascarell@gmail.com), comment the project directly (if you want to contribute with information or resources) or fork the project and make a pull request.

Also I will be grateful if you want to make a donation, this project hasn't got a death date and it wants to be improved constantly:

[![Website Button](http://www.rahmenversand.com/images/paypal_logo_klein.gif "Donate!")](https://www.paypal.com/cgi-bin/webscr?cmd=_donations&business=marcmascarell%40gmail%2ecom&lc=US&item_name=Arrayer%20Development&no_note=0&currency_code=EUR&bn=PP%2dDonationsBF%3abtn_donateCC_LG%2egif%3aNonHostedGuest&amount=5 "Contribute to the project")


License
----

MIT