<?php

declare(strict_types=1);

namespace Zhuk\LaravelIntercom\Messages;

use Zhuk\LaravelIntercom\Contacts\ContactInterface;
use Zhuk\LaravelIntercom\Exceptions\Exception;

final class EmailMessage implements MessageInterface
{
    public const EMAIL_TEMPLATE_PLAIN = 'plain';
    public const EMAIL_TEMPLATE_PERSONAL = 'personal';

    /**
     * @var string
     */
    private string $message;

    /**
     * @var string
     */
    private string $subject;

    /**
     * @var string
     */
    private string $template;

    /**
     * @var ContactInterface[]
     */
    private array $contacts;

    /**
     * @param string $message
     * @param string $subject
     * @param array  $contacts
     * @param string $template
     *
     * @return void
     */
    public function __construct(
        string $message,
        string $subject,
        array $contacts = [],
        string $template = 'plain'
    ) {
        $this->message = $message;
        $this->subject = $subject;
        $this->contacts = $contacts;
        $this->template = $template;
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

        if (empty($this->subject)) {
            throw new Exception('Subject is empty');
        }

        if (empty($this->template)) {
            throw new Exception('Template is empty');
        }

        $contactsCount = \count($this->contacts);
        if ($contactsCount !== 2) {
            throw new Exception("Dialog should have 2 participants, got {$contactsCount}");
        }

        [ $contactFrom, $contactTo ] = $this->contacts;

        return [
            'message_type' => 'email',
            'subject' => $this->subject,
            'template' => $this->template,
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
