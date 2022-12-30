<?php

namespace blog\entity;

use blog\database\Model;

/**
 * Description of Post
 *
 * @author constancelaloux
 */
class Post extends Model
{

    /**
     * @var type 
     */
    protected $id,
      $idauthor,
      $subject,
      $image,
      $content,
      $createdate,
      $updatedate,
      $slugimage
     ;

    /**
     * Database architecture
     * @return type
     */
    public static function metadata()
    {
        return [
            "table"             => "post",
            "primaryKey"        => "id",
            "columns"           => [
                "id"            => [
                    "type"      => "integer",
                    "property"  => "id"
                ],
                "id_author"            => [
                    "type"      => "integer",
                    "property"  => "idauthor"
                ],
                "create_date"    => [
                    "type"      => "datetime",
                    "property"  => "createdate"
                ],
                "update_date"    => [
                    "type"      => "datetime",
                    "property"  => "updatedate"
                ],
                "subject"    => [
                    "type"      => "string",
                    "property"  => "subject"
                ],
                "content"    => [
                    "type"      => "string",
                    "property"  => "content"
                ],
                "image"    => [
                    "type"      => "string",
                    "property"  => "image"
                ],
                "status"    => [
                    "type"      => "string",
                    "property"  => "status"
                ],
            ]
        ];
    }
    
    /**
     * Getters
     * Currently, the attributes of our objects are inaccessible.
     * We have to create getters to be able to read them, and setters to be able to modify their values.
     * List of getters. I could reuse the functions later.
     * A getter is a method responsible for returning the value of an attribute
    */
    
    /**
     * @return type
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return type
     */
    public function getIdAuthor(): int
    {
        return $this->idauthor;
    }
    
    /**
     * @return type
     */
    public function getSubject(): ?string
    {
        return $this->subject;
    }
        
    /**
     * @return type
     */
    public function getImage(): ?string
    {
        return $this->image;
    }
    
    /**
     * @return type
     */
    public function getSlugImage(): ?string
    {
        return $this->slugimage;
    }

    /**
     * @return type
     */
    public function getContent(): ?string
    {
        return $this->content;
    }

    /**
     * @return type
     */
    public function getCreateDate(): \DateTime
    {
        return $this->createdate;
    }

    /**
     * @return type
     */
    public function getUpdateDate(): ?\DateTime
    {
        return $this->updatedate;
    }

    /**
     * @return type
     */
    public function getStatus(): string
    {
        return $this->status;
    }

    /**
     * Setters
     * A setter is a method responsible for assigning a value to an attribute by checking its integrity 
     * (if you assign the value without any control, you lose all the interest brought by the encapsulation 
     * principle).
    */
        
    /**
     * @param type $id
     */
    public function setId(int $id): void
    {
        $id = (int) $id;

        if ($id > 0)
        {
            $this->id = $id;
        }
    }

    /**
     * @param type $idauthor
     */
    public function setIdAuthor(int $idauthor): void
    {
        $idauthor = (int)$idauthor;
        if ($idauthor > 0)
        {
            $this->idauthor = $idauthor;
        }
    }

    /**
     * @param type $subject
     */
    public function setSubject(string $subject): void
    {
        if(is_string($subject))
        {
            $this->subject = $subject;
        }
    }

    /**
     * @param type $image
     */
    public function setImage(string $image): void
    {
        if(is_string($image))
        {
            $this->image = $image;
        }
    }
    
    
    /**
     * @param type $slugimage
     */
    public function setSlugImage(string $slugimage): void
    {
        if(is_string($slugimage))
        {
            $this->slugimage = $slugimage;
        }
    }

    /**
     * @param type $content
     */
    public function setContent(string $content): void
    {
        if(is_string($content))
        {
            $this->content = $content;
        }
    }

    /**
     * @param type $createdate
     */
    public function setCreateDate(string $createdate): void
    {   
        if(is_string($createdate))
        {
            $this->createdate = new \DateTime($createdate);
        }
    }

    /**
     * @param type $updatedate
     */
    public function setUpdateDate(?string $updatedate): void
    {
        if(is_string($updatedate))
        {
            $this->updatedate = new \DateTime($updatedate);
        }
    }

    /**
     * @param type $status
     */
    public function setStatus(string $status): void
    {
        if(is_string($status))
        {
            $this->status = $status;
        }
    }
}
