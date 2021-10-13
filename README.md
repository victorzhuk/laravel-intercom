# laravel-intercom

![GitHub](https://img.shields.io/github/license/victorzhuk/laravel-intercom)
![GitHub release (latest SemVer including pre-releases)](https://img.shields.io/github/v/release/victorzhuk/laravel-intercom?include_prereleases)
![GitHub commits since latest release (by date including pre-releases)](https://img.shields.io/github/commits-since/victorzhuk/laravel-intercom/latest?include_prereleases)

> Laravel notification driver and bindings of [PHP Intercom API](https://github.com/intercom/intercom-php)

## Installation

Via composer:

```bash
composer require zhuk/laravel-intercom
```

## API usage

Add service config in `config/services.php` and setup envs like

```php
<?php

return [
    // ...
    'intercom' => [
        'token' => \env('INTERCOM_API_KEY'),
        'password' => \env('INTERCOM_PASSWORD'),
        'admin_user_id' => \env('INTERCOM_ADMIN_USER_ID'),
        'headers' => [
            'Intercom-Version' => '2.3',
        ],
    ],
// ...
];
```

Than use dependency injection for `IntercomClient::class`
Refer to [Intercom PHP](https://github.com/intercom/intercom-php) for usage information.

## Notification usage

Define class like

```php
final class CommonIntercomNotification extends Notification implements NotificationInterface
{
    use Queueable;

    /**
     * @var string
     */
    private string $messageText;

    /**
     * @param string $message
     *
     * @return void
     */
    public function __construct(string $message)
    {
        $this->messageText = $message;
    }

    /**
     * @param mixed $notifiable
     *
     * @return array
     */
    public function via($notifiable)
    {
        return ['intercom'];
    }

    /**
     * @param mixed $notifiable
     *
     * @return IntercomMessage
     */
    public function toIntercom($notifiable): MessageInterface
    {
        return new InappMessage($this->messageText);
    }
}
```

and for example in `User` class  define method returning `ContactInterface`. Don\`t forget `use Notifiable`

```php
final class User
{
    use Notifiable;

    // ...

    public function routeNotificationForIntercom($notification): ContactInterface
    {
        return new GenericMessageContact($this->intercom_contact_id);
    }
}

```
