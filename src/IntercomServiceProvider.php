<?php

declare(strict_types=1);

namespace Zhuk\LaravelIntercom;

use Illuminate\Contracts\Config\Repository;
use Illuminate\Contracts\Container\Container;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\ServiceProvider;
use Intercom\IntercomClient;
use Zhuk\LaravelIntercom\Exceptions\Exception;

final class IntercomServiceProvider extends ServiceProvider
{
    private const CHANNEL_DRIVER_NAME = 'intercom';

    /**
     * {@inheritdoc}
     */
    public function boot(): void
    {
        if (!$this->app->has(IntercomClient::class)) {
            $this->app->bind(
                IntercomClient::class,
                static function (Container $app): IntercomClient {
                    /** @var Repository */
                    $config = $app->get('config');

                    /** @var string|null */
                    $intercomToken = $config->get('services.intercom.token', null);

                    if ($intercomToken === null) {
                        throw new Exception('Intercom token should not be null');
                    }

                    return new IntercomClient(
                        $intercomToken,
                        $config->get('services.intercom.password', null),
                        $config->get('services.intercom.headers', []),
                    );
                }
            );
        }
    }

    /**
     * {@inheritdoc}
     */
    public function register(): void
    {
        Notification::extend(
            self::CHANNEL_DRIVER_NAME,
            /**
             * @return mixed
             */
            static fn (Container $app) => $app->make(Channel::class)
        );
    }
}
