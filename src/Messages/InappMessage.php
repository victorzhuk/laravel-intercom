<?php

declare(strict_types=1);

namespace Zhuk\LaravelIntercom\Messages;

use Zhuk\LaravelIntercom\Contacts\ContactInterface;
use Zhuk\LaravelIntercom\Exceptions\Exception;

final class InappMessage implements MessageInterface
{
    /**
     * @var string
     */
    private string $message;

    /**
     * @var ContactInterface[]
     */
    private array $contacts;

    /**
     * @param string $message
     * @param array  $contacts
     *
     * @return void
     */
    public function __construct(string $message, array $contacts = [])
    {
        $this->message = $message;
        $this->contacts = $contacts;
    }

    /**
     * {@inheritdoc}
     */
    public function getContacts(): array
    {
        return $this->contacts;
    }

    /**
     * {@inheritdoc}
     */
    public function addContact(ContactInterface $contact): self
    {
        $this->contacts[] = $contact;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function setContacts(array $contacts): self
    {
        $this->contacts = $contacts;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getBody(): array
    {
        if (empty($this->message)) {
            throw new Exception('Message body is empty');
        }

        $contactsCount = \count($this->contacts);
        if ($contactsCount !== 2) {
            throw new Exception("One by one dialog should have only 2 participants, got {$contactsCount}");
        }

        [ $contactFrom, $contactTo ] = $this->contacts;

        return [
            'message_type' => 'innapp',
            'body' => $this->message,
            'from' => [
                'type' => $contactFrom->getType(),
                $contactFrom->getAttribute() => $contactFrom->getId(),
            ],
            'to' => [
                'type' => $contactTo->getType(),
                $contactTo->getAttribute() => $contactTo->getId(),
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function getConversationId(): ?string
    {
        return null;
    }
}
