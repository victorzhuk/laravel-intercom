<?php

declare(strict_types=1);

namespace Zhuk\LaravelIntercom;

use Illuminate\Contracts\Config\Repository;
use Intercom\IntercomClient;
use Zhuk\LaravelIntercom\Contacts\AdminMessageContact;
use Zhuk\LaravelIntercom\Contacts\ContactInterface;
use Zhuk\LaravelIntercom\Exceptions\Exception;

/**
 * Class IntercomNotificationChannel.
 */
final class Channel
{
    /**
     * @var IntercomClient
     */
    private IntercomClient $client;

    /**
     * @var Repository
     */
    private Repository $config;

    /**
     * @param IntercomClient $client
     * @param Repository     $config
     *
     * @return void
     */
    public function __construct(IntercomClient $client, Repository $config)
    {
        $this->client = $client;
        $this->config = $config;
    }

    /**
     * @param mixed                 $notifiable
     * @param NotificationInterface $notification
     *
     * @return void
     *
     * @throws Exception
     */
    public function send($notifiable, NotificationInterface $notification): void
    {
        $message = $notification->toIntercom($notifiable);

        /** @var string|null */
        $adminContactId = $this->config->get('services.intercom.admin_contact_id');
        $contacts = $message->getContacts();

        $conversationId = $message->getConversationId();
        if ($conversationId !== null) {
            if (empty($contacts) && $adminContactId !== null) {
                $message->addContact(new AdminMessageContact($adminContactId));
            }

            $this->client->conversations->replyToConversation(
                $conversationId,
                $message->getBody()
            );
        } else {
            if (\count($contacts) === 1 && $adminContactId !== null) {
                array_unshift($contacts, new AdminMessageContact($adminContactId));
            }

            if (empty($contacts) && $adminContactId !== null) {
                /** @var ContactInterface|null */
                $to = $notifiable->routeNotificationFor('intercom');
                if ($to) {
                    $contacts = [
                        new AdminMessageContact($adminContactId),
                        $to,
                    ];
                }
            }

            $message->setContacts($contacts);

            $this->client->messages->create(
                $message->getBody()
            );
        }
    }
}
