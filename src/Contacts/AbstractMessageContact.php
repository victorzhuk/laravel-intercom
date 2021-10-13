<?php

declare(strict_types=1);

namespace Zhuk\LaravelIntercom\Contacts;

abstract class AbstractMessageContact implements ContactInterface
{
    /**
     * @var string
     */
    private string $id;

    /**
     * @param string $id
     *
     * @return void
     */
    public function __construct(string $id)
    {
        $this->id = $id;
    }

    /**
     * {@inheritdoc}
     */
    final public function getId(): string
    {
        return $this->id;
    }
}
