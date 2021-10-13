<?php

declare(strict_types=1);

namespace Zhuk\LaravelIntercom\Contacts;

interface ContactInterface
{
    /**
     * @return string
     */
    public function getType(): string;

    /**
     * @return string
     */
    public function getAttribute(): string;

    /**
     * @return string
     */
    public function getId(): string;
}
