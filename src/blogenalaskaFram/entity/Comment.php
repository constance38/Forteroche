<?php

namespace blog\entity;

use blog\database\Model;

/**
 * Description of Comment
 *
 * @author constancelaloux
 */
class Comment extends Model
{
    /**
     * @var array
     */
    protected $id,
      $idauthor,
      $idpost,
      $createdate,
      $updatedate,
      $subject,
      $commentContent,
      $status,
      $countclicks
     ;

    /**
     * Database architecture
     * @return type
     */
    public static function metadata()
    {
        return [
            "table"             => "comment",
            "primaryKey"        => "id",
            "columns"           => [
                "id"            => [
                    "type"      => "integer",
                    "property"  => "id"
                ],
                "id_author"     => [
                    "type"      => "integer",
                    "property"  => "idauthor"
                ],
                "id_post"     => [
                    "type"      => "integer",
                    "property"  => "idpost"
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
                    "property"  => "commentContent"
                ],
                "status"    => [
                    "type"      => "string",
                    "property"  => "status"
                ],
                "countclicks"    => [
                    "type"      => "integer",
                    "property"  => "countclicks"
                ],
            ]
        ];
    }
    
    /**
     * Getters
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
    public function getIdAuthor(): ?int
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
    public function getIdPost(): ?int
    {
        return $this->idpost;
    }

    /**
     * @return type
     */
    public function getCommentContent(): ?string
    {
        return $this->commentContent;
    }
    /**
     * @return type
     */
    public function getCreateDate(): ?\DateTime
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
    public function getStatus(): ?string
    {
        return $this->status;
    }
    
    /**
     * @return type
     */
    public function getCountclicks(): int
    {
        return $this->countclicks;
    }

    /**
     * Setters
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
     * @param type $idclient
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
     * @param type $idpost
     */
    public function setIdpost(?int $idpost): void
    {
        $idpost = (int)$idpost;
        if ($idpost > 0)
        {
            $this->idpost = $idpost;
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
     * @param type $countclicks
     */
    public function setCountClicks(?int $countclicks): void
    {
        $countclick = (int)$countclicks;
        $this->countclicks = $countclick;
    }

    /**
     * @param type $content
     */
    public function setCommentContent(string $commentContent): void
    {
        if(is_string($commentContent))
        {
            $this->commentContent = $commentContent;
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
