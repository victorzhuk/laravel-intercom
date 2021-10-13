<?php

declare(strict_types=1);

namespace Zhuk\LaravelIntercom;

use Zhuk\LaravelIntercom\Messages\MessageInterface;

interface NotificationInterface
{
    /**
     * @param mixed $notifiable
     *
     * @return MessageInterface
     */
    public function toIntercom($notifiable): MessageInterface;
}
