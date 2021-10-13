<?php

declare(strict_types=1);

namespace Zhuk\LaravelIntercom\Contacts;

final class GenericMessageContact extends AbstractMessageContact
{
    /**
     * {@inheritdoc}
     */
    public function getType(): string
    {
        return 'user';
    }

    /**
     * {@inheritdoc}
     */
    public function getAttribute(): string
    {
        return 'id';
    }
}
