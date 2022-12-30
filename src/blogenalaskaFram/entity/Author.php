<?php

namespace blog\entity;

use blog\database\Model;

/**
 * Description of Author
 * The role of the author class is to represent an author present in BDD. It has no role to manage them.
 */
class Author extends Model
{
    
    /**
     * We use the Hydrator trait so that our Author object can be hydrated
     * Hydration = assign values ​​to attributes passed in parameters.
     * An array of data must be passed to the function (hence the prefix "array")
     * this must make it possible to assign the attributes of the object the corresponding values, passed in parameter in an array
     */

      protected $id,
            $password,
            $username,
            $firstname,
            $surname,
            $status,
            $image,
            $slugimag;
    
    /**
     * Here, the builder requests the initial strength and damage for the character you just created.
     * It will therefore be necessary to specify it as a parameter in pdoConnection.
     * It only remains to implement the constructor so that we can directly hydrate our object when instantiating the class.
     * To do this, add a parameter: $ data. Then call the hydrate () method directly.
    */

    public function isValid()
    {
        return !(empty($this->password) || empty($this->username) || empty($this->surname)|| empty($this->firstname));
    }
    
    public static function metadata()
    {
        return [
            "table"             => "author",
            "primaryKey"        => "id",
            "columns"           => [
                "id"            => [
                    "type"      => "integer",
                    "property"  => "id"
                ],
                "surname"            => [
                    "type"      => "string",
                    "property"  => "surname"
                ],
                "firstname"            => [
                    "type"      => "string",
                    "property"  => "firstname"
                ],
                "username"            => [
                    "type"      => "string",
                    "property"  => "username"
                ],
                "password"    => [
                    "type"      => "string",
                    "property"  => "password"
                ],
                "status"    => [
                    "type"      => "string",
                    "property"  => "status"
                ],
                "image"    => [
                    "type"      => "string",
                    "property"  => "image"
                ],
            ]
        ];
    }

    /**
     * Getters
     * Currently, the attributes of our objects are inaccessible.
     * You have to create getters to be able to read them, and setters to be able to modify their values.
     * List of getters. I could reuse the functions later. a getter is a method responsible for returning 
     * the value of an attribute
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
    public function getPassword(): ?string
    {
        return $this->password;

    }

    /**
     * @return type
     */
    public function getUsername(): ?string
    {
        return $this->username;
    }

    /**
     * @return type
     */
    public function getSurname(): ?string
    {
        return $this->surname;
    }

    /**
     * @return type
     */
    public function getFirstname(): ?string
    {
        return $this->firstname;
    }
    
    /**
     * @return type
     */
    public function getStatus(): string
    {
        return $this->status;
    }
    
    /**
     * 
     * @return type
     */
    public function getImage(): ?string
    {
        return $this->image;
    }

    /**
     * @return type
     */
    public function getSlugImag(): ?string
    {
        return $this->slugimag;
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
     * @param type $surname
     */
    public function setSurname(string $surname): void
    {
        if(is_string($surname) || !empty($surname))
        {
            $this->surname = $surname;
        }
    }

    /**
     * @param type $password
     */
    public function setPassword(?string $password): void
    {
        if (is_string($password) || !empty($password))
        {
            $this->password = $password;
        }
    }

    /**
     * @param type $username
     */
    public function setUsername(string $username): void
    {
        if(is_string($username) || !empty($username))
        {
            $this->username = $username;
        }
    }

    /**
     * 
     * @param type $image
     */
    public function setImage(string $image): void
    {
        if(is_string($image) || !empty($image))
        {
            $this->image = $image;
        }
    }

    /**
     * @param type $firstname
     */
    public function setFirstname(string $firstname): void
    {
        if(is_string($firstname) || !empty($firstname))
        {
            $this->firstname = $firstname;
        }
    }
    
    /**
     * @param type $status
     */
    public function setStatus(string $status): void
    {
        if(is_string($status) || !empty($status))
        {
            $this->status = $status;
        }
    }
    
    /**
     * @param type $slugimag
     */
    public function setSlugImag(string $slugimag): void
    {
        if(is_string($slugimag))
        {
            $this->slugimag = $slugimag;
        }
    }
}
