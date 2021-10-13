<?php

declare(strict_types=1);

namespace Zhuk\LaravelIntercom\Contacts;

final class UserMessageContact extends AbstractMessageContact
{
    public const IDENTIFICATION_METHOD_EMAIL = 'email';
    public const IDENTIFICATION_METHOD_USER_ID = 'user_id';

    /**
     * @var string
     */
    private string $identificationMethod;

    /**
     * @param string $id
     * @param string $identificationMethod
     *
     * @return void
     */
    public function __construct(string $id, string $identificationMethod = 'email')
    {
        parent::__construct($id);

        $this->identificationMethod = $identificationMethod;
    }

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
        return $this->identificationMethod;
    }
}
