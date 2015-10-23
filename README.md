Swiftmailer Observers
=====================

[![Build Status](https://travis-ci.org/clippings/swiftmailer-observers.svg?branch=master)](https://travis-ci.org/clippings/swiftmailer-observers)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/clippings/swiftmailer-observers/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/clippings/swiftmailer-observers/?branch=master)
[![Code Coverage](https://scrutinizer-ci.com/g/clippings/swiftmailer-observers/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/clippings/swiftmailer-observers/?branch=master)
[![Latest Stable Version](https://poser.pugx.org/clippings/swiftmailer-observers/v/stable)](https://packagist.org/packages/clippings/swiftmailer-observers)

Assign bcc for specific email types globally

Installation
------------

Install via composer

```
composer require clippings/swiftmailer-observers
```

Usage
-----

```php
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
