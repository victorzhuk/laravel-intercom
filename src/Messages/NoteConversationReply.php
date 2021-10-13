<?php

declare(strict_types=1);

namespace Zhuk\LaravelIntercom\Messages;

use Zhuk\LaravelIntercom\Contacts\ContactInterface;
use Zhuk\LaravelIntercom\Exceptions\Exception;

final class NoteConversationReply implements MessageInterface
{
    /**
     * @var string
     */
    private string $message;

    /**
     * @var string
     */
    private string $conversationId;

    /**
     * @var ContactInterface|null
     */
    private ?ContactInterface $contact;

    /**
     * @param string $message
     * @param array  $contacts
     *
     * @return void
     */
    public function __construct(string $message, string $conversationId, ?ContactInterface $contact = null)
    {
        $this->message = $message;
        $this->conversationId = $conversationId;
        $this->contact = $contact;
    }

    /**
     * {@inheritdoc}
     */
    public function getContacts(): array
    {
        return $this->contact
            ? [$this->contact]
            : [];
    }

    /**
     * {@inheritdoc}
     */
    public function addContact(ContactInterface $contact): self
    {
        $this->contact = $contact;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function setContacts(array $contacts): self
    {
        if (!empty($contacts)) {
            $this->contact = $contacts[0];
        }

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

        if ($this->contact === null) {
            throw new Exception('Contact is empty');
        }

        if ($this->contact->getType() !== 'admin') {
            throw new Exception('Note reply allowed only for admins');
        }

        return [
            'message_type' => 'note',
            'body' => $this->message,
            'type' => 'admin',
            'admin_id' => $this->contact->getId(),
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function getConversationId(): ?string
    {
        return $this->conversationId;
    }
}
