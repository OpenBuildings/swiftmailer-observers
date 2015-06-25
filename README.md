Swiftmailer Observers
=====================

[![Build Status](https://travis-ci.org/{%repository_name%}.png?branch=master)](https://travis-ci.org/clippings/swiftmailer-observers)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/{%repository_name%}/badges/quality-score.png)](https://scrutinizer-ci.com/g/clippings/swiftmailer-observers/)
[![Code Coverage](https://scrutinizer-ci.com/g/{%repository_name%}/badges/coverage.png)](https://scrutinizer-ci.com/g/clippings/swiftmailer-observers/)
[![Latest Stable Version](https://poser.pugx.org/{%repository_name%}/v/stable.png)](https://packagist.org/packages/clippings/swiftmailer-observers)

Assign bcc for specific email types globally

Instalation
-----------

Install via composer

```
composer require clippings/swiftmailer-observers
```

Usage
-----
```
$mailer->registerPLugin(new ObserversPlugin([
    'test@example.com' => [
        'event1',
        'event2',
    ]
]));

$headers = $message->getHeaders();
$headers->addTextHeader(ObserversPlugin::HEADER, 'event1');

// Will add 'test@example.com' to bcc
$mailer->send($message);
```

License
-------

Copyright (c) 2015, Clippings Ltd. Developed by Ivan Kerin

Under BSD-3-Clause license, read LICENSE file.
