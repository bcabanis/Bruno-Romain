<?php

namespace App\Document;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;

#[MongoDB\Document]
class ChatMessage
{
    #[MongoDB\Id]
    private string $id;

    #[MongoDB\Field(type: 'string')]
    private string $content;

    #[MongoDB\ReferenceOne(targetDocument: Events::class)]
    private ?Events $event = null;


    #[MongoDB\ReferenceOne(targetDocument: Users::class)]
    private ?Users $user = null;

    #[MongoDB\ReferenceOne(targetDocument: ChatMessage::class)]
    private ?ChatMessage $parentMessage = null;

    #[MongoDB\ReferenceOne(targetDocument: ChatMessage::class)]
    private ?ChatMessage $replyToMessage = null;



    #[MongoDB\ReferenceMany(targetDocument: ChatMessage::class, mappedBy: "parentMessage")]

    private Collection $replies;

    public function __construct()
    {
        $this->replies = new ArrayCollection();
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getContent(): string
    {
        return $this->content;
    }

    public function setContent(string $content): void
    {
        $this->content = $content;
    }

    public function getEvent(): ?Events
    {
        return $this->event;
    }

    public function setEvent(?Events $event): void
    {
        $this->event = $event;
    }

    public function getUser(): ?Users
    {
        return $this->user;
    }

    public function setUser(?Users $user): void
    {
        $this->user = $user;
    }

    public function getParentMessage(): ?ChatMessage
    {
        return $this->parentMessage;
    }

    public function setParentMessage(?ChatMessage $parentMessage): void
    {
        $this->parentMessage = $parentMessage;
    }

    /**
     * @return Collection|ChatMessage[]
     */
    public function getReplies(): Collection
    {
        return $this->replies;
    }

    public function addReply(ChatMessage $reply): void
    {
        if (!$this->replies->contains($reply)) {
            $this->replies[] = $reply;
            $reply->setParentMessage($this);
        }
    }

    public function removeReply(ChatMessage $reply): void
    {
        if ($this->replies->contains($reply)) {
            $this->replies->removeElement($reply);
            // Ne pas supprimer la référence parente lors de la suppression de la réponse
            // pour éviter les suppressions en cascade.
        }
    }

    public function getReplyToMessage(): ?ChatMessage
    {
        return $this->replyToMessage;
    }

    public function setReplyToMessage(?ChatMessage $replyToMessage): void
    {
        $this->replyToMessage = $replyToMessage;
    }
}