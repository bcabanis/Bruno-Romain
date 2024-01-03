<?php

namespace App\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;

#[MongoDB\Document]
class Events
{

    #[MongoDB\Id]
    protected $id;

    
    #[MongoDB\Field(type:"string")]
    protected $category;

    #[MongoDB\Field(type:"string")]
    protected $title;

    #[MongoDB\Field(type:"string")]
    protected $description;

    #[MongoDB\Field(type:"string", name:"date")]
    protected $date;

    #[MongoDB\Field(type:"string")]
    protected $address;

    #[MongoDB\Field(type:"string", name:"image_url")]
    protected $imageUrl;

    #[MongoDB\Field(type:"date", name:"dateFormat")]
    protected $dateFormat;

    #[MongoDB\Field(type:"string", name:"lat")]
    protected $latitude;

    #[MongoDB\Field(type:"string", name:"eventId")]
    protected $eventId;

    #[MongoDB\Field(type:"string", name:"long")]
    protected $longitude;

    #[MongoDB\Field(type:"string", name:"orga")]
    protected $orga;

    #[MongoDB\ReferenceMany(targetDocument: ChatMessage::class, mappedBy: "eventId")]
    private $chatMessages; // Collection des messages de chat associés à l'événement


    // Add getters and setters for each property

    public function getId()
    {
        return $this->id;
    }

    public function getCategory(): ?string
    {
        return $this->category;
    }

    public function getDateFormat(): ?string
    {
        return $this->dateFormat;
    }

    public function getLong(): ?string
    {
        return $this->longitude;
    }

    public function getLat(): ?string
    {
        return $this->latitude;
    }

    public function getOrga(): ?string
    {
        return $this->orga;
    }

    public function setCategory(string $category): self
    {
        $this->category = $category;
        return $this;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;
        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;
        return $this;
    }

    public function getEventDate(): ?string
    {
        return $this->date;
    }

    public function setEventDate(string $date): self
    {
        $this->date = $date;
        return $this;
    }

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(string $address): self
    {
        $this->address = $address;
        return $this;
    }

    public function getImageUrl(): ?string
    {
        return $this->imageUrl;
    }

    public function setImageUrl(string $imageUrl): self
    {
        $this->imageUrl = $imageUrl;
        return $this;
    }

    public function geteventId(): ?string
    {
        return $this->eventId;
    }

    public function seteventId(string $eventId): self
    {
        $this->eventId = $eventId;
        return $this;
    }

    public function setDateFormat(string $dateFormat): self
    {
        $this->dateFormat = $dateFormat;
        return $this;
    }

    public function setLong(string $longitude): self
    {
        $this->longitude = $longitude;
        return $this;
    }

    public function setLat(string $latitude): self
    {
        $this->latitude = $latitude;
        return $this;
    }

    public function setOrga(string $orga): self
    {
        $this->orga = $orga;
        return $this;
    }


    public function getChatMessages()
    {
        return $this->chatMessages;
    }

    public function setChatMessages($chatMessages): void
    {
        $this->chatMessages = $chatMessages;
    }
}

