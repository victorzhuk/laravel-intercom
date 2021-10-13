<?php

declare(strict_types=1);

namespace Zhuk\LaravelIntercom\Messages;

use Zhuk\LaravelIntercom\Contacts\ContactInterface;

interface MessageInterface
{
    /**
     * @return ContactInterface[]
     */
    public function getContacts(): array;

    /**
     * @param ContactInterface $contact
     *
     * @return MessageInterface
     */
    public function addContact(ContactInterface $contact): self;

    /**
     * @param ContactInterface[] $contacts
     *
     * @return MessageInterface
     */
    public function setContacts(array $contacts): self;

    /**
     * @return array
     */
    public function getBody(): array;

    /**
     * @return string|null
     */
    public function getConversationId(): ?string;
}
