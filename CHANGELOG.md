# Changelog

All notable changes to `volet-feature-board` will be documented in this file.

## v1.1.0 - 2025-11-17

### What's Changed

* Bump stefanzweifel/git-auto-commit-action from 6 to 7 by @dependabot[bot] in https://github.com/mydnic/volet-feature-board/pull/9
* Add out of the box notification when a new Feature is submitted by @mydnic in https://github.com/mydnic/volet-feature-board/pull/10

### Upgrade

Just add this to your config file :

```php
    'mail_notification' => [
        'enabled' => true,
        'send_mails_to' => [
            // List of emails to send the notification to
            // 'admin@example.com',
        ],
        'class' => \Mydnic\VoletFeatureBoard\Notifications\NewFeatureNotification::class,
    ],

```
**Full Changelog**: https://github.com/mydnic/volet-feature-board/compare/v1.0.2...v1.1.0

## v1.0.2 - 2025-09-04

### What's Changed

* Bump stefanzweifel/git-auto-commit-action from 5 to 6 by @dependabot[bot] in https://github.com/mydnic/volet-feature-board/pull/5
* Bump aglipanci/laravel-pint-action from 2.5 to 2.6 by @dependabot[bot] in https://github.com/mydnic/volet-feature-board/pull/6
* Bump actions/checkout from 4 to 5 by @dependabot[bot] in https://github.com/mydnic/volet-feature-board/pull/7
* Add missing isUserAuthor() into HasAuthorTrait by @kermitsxb in https://github.com/mydnic/volet-feature-board/pull/8

### New Contributors

* @kermitsxb made their first contribution in https://github.com/mydnic/volet-feature-board/pull/8

**Full Changelog**: https://github.com/mydnic/volet-feature-board/compare/v1.0.1...v1.0.2

## v1.0.1 - 2025-05-13

### What's Changed

* Bump dependabot/fetch-metadata from 2.3.0 to 2.4.0 by @dependabot in https://github.com/mydnic/volet-feature-board/pull/2
* Use label when defined by @mydnic in https://github.com/mydnic/volet-feature-board/pull/4

### New Contributors

* @mydnic made their first contribution in https://github.com/mydnic/volet-feature-board/pull/4

**Full Changelog**: https://github.com/mydnic/volet-feature-board/compare/v1.0.0...v1.0.1
