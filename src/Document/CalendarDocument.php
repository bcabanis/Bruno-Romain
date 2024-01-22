<?php

namespace App\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;

#[MongoDB\Document]
class Calendar 
{
    #[MongoDB\Id]
    public string $id;

    #[MongoDB\Field(type: 'date')]
    private \DateTime $start;

    #[MongoDB\Field(type: 'date')]
    private \DateTime $end;

    #[MongoDB\Field(type: 'string')]
    private string $title;

    public function getId(): string
    {
        return $this->id;
    }
}



















