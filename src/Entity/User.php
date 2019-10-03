<?php

namespace App\Entity;


use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Annotation\ApiSubresource;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;



/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 * @ApiResource(
 * normalizationContext={"groups"={"get_role_user"}},
 *    collectionOperations={
 *          "get"={
 *              "method"="GET",
 *              "path"="/users",
 *              "normalization_context"= {
 *                  "groups"={"get_role_user"}
 *              }
 *          },
 *          "post"={
 *              "method"="POST",
 *              "path"="/users/{id}",
 *              "access_control"="is_granted('ROLE_ADMIN')",
 *              "access_control_message"="Vous n'avez pas les droits d'accéder à cette ressource",
 *              "denormalization_context"= {
 *                  "groups"={"post_role_admin"}
 *              }
 *      },
 * },
 * 
 *    itemOperations={
 *          "get"={
 *              "method"="GET",
 *              "path"="/users/{id}",
 *              "access_control"="( is_granted('ROLE_ADMIN') or is_granted('ROLE_USER') and object == user )",
 *              "access_control_message"="Vous n'avez pas les droits d'accéder à cette ressource",
 *              "normalization_context"= {
 *                  "groups"={"get_role_user"}
 *              }
 *          }, 
 *      
 *          "put"={
 *              "method"="PUT",
 *              "path"="/users/{id}",
 *              "access_control"="( is_granted('ROLE_ADMIN') or is_granted('ROLE_USER') and object == user )",
 *              "access_control_message"="Vous n'avez pas les droits d'accéder à cette ressource",
 *              "denormalization_context"= {
 *                  "groups"={"put_role_admin"}
 *              },             
 *              "normalization_context"= {
 *                  "groups"={"get_role_user"}
 *              }
 *          },
 *          "delete"={
 *              "method"="DELETE", 
 *              "path"="/users/{id}",
 *              "access_control"="is_granted('ROLE_ADMIN')",
 *              "access_control_message"="Vous n'avez pas les droits d'accéder à cette ressource"
 *          }
 *      }
 * )
 */

class User implements UserInterface
{

    const DEFAULT_ROLE = "ROLE_USER";
    const ROLE_ADMIN = 'ROLE_ADMIN';


    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"get_role_user","post_role_admin","put_role_admin"})
     */
    private $nom;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"get_role_user","post_role_admin","put_role_admin"})
     */
    private $prenom;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"get_role_user","post_role_admin","put_role_admin"})
     */
    private $adresse;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"get_role_user","post_role_admin","put_role_admin"})
     */
    private $codeCommune;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"get_role_user","post_role_admin","put_role_admin"})
     */
    private $mail;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $telephone;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"post_role_admin","put_role_admin"})
     */
    private $password;

    /**
     * @ORM\Column(type="json_array", nullable=true)
     * @Groups({"get_role_user","get_role_admin","post_role_admin","put_role_admin"})
     */
    private $roles = [];

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $message;

    public function __construct()
    {
     
        $leRole =[self::DEFAULT_ROLE];
        $this->roles= $leRole;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(?string $prenom): self
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function getAdresse(): ?string
    {
        return $this->adresse;
    }

    public function setAdresse(?string $adresse): self
    {
        $this->adresse = $adresse;

        return $this;
    }

    public function getCodeCommune(): ?string
    {
        return $this->codeCommune;
    }

    public function setCodeCommune(?string $codeCommune): self
    {
        $this->codeCommune = $codeCommune;

        return $this;
    }

    public function getMail(): ?string
    {
        return $this->mail;
    }

    public function setMail(?string $mail): self
    {
        $this->mail = $mail;

        return $this;
    }

    public function getTelephone(): ?string
    {
        return $this->telephone;
    }

    public function setTelephone(?string $telephone): self
    {
        $this->telephone = $telephone;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }


    public function __toString()
    {
        return (string) $this->nom ." ". $this->prenom 
        . " ". $this->adresse ." ". $this->codeCommune . " ". $this->message;
    }


        /**
     * Returns the roles granted to the user.
     *
     *     public function getRoles()
     *     {
     *         return ['ROLE_USER'];
     *     }
     *
     * Alternatively, the roles might be stored on a ``roles`` property,
     * and populated in any number of different ways when the user object
     * is created.
     *
     * @return (Role|array)[] The user roles
     */
    public function getRoles(): array {
        $roles =  $this->roles;
        $roles[] = 'DEFAULT_ROLE';
        return array_unique($roles);
    }
    /**
     * affecte les roles des utilisateurs
     * 
     * @param arrray $roles
     * @return self
     */

    public function setRoles(array $roles):self {
       $this->roles = $roles;
       return $this;
    }
        
        /**
         * Returns the salt that was originally used to encode the password.
         *
         * This can return null if the password was not encoded using a salt.
         *
         * @return string|null The salt
         */
        public function getSalt(){

            return null;
        }

        /**
         * Returns the username used to authenticate the user.
         *
         * @return string The username
         */
        public function getUsername() {
            return $this->getMail();
        }
    
        
        public function eraseCredentials(){}

        public function getMessage(): ?string
        {
            return $this->message;
        }

        public function setMessage(?string $message): self
        {
            $this->message = $message;

            return $this;
        }
}
