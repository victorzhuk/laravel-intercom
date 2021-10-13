<?php

declare(strict_types=1);

namespace Zhuk\LaravelIntercom\Contacts;

final class AdminMessageContact extends AbstractMessageContact
{
    /**
     * {@inheritdoc}
     */
    public function getType(): string
    {
        return 'admin';
    }

    /**
     * {@inheritdoc}
     */
    public function getAttribute(): string
    {
        return 'id';
    }
}
