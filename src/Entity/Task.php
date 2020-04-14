<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Task
 *
 * @ORM\Table(name="task", uniqueConstraints=@ORM\UniqueConstraint(name="id_UNIQUE", columns={"id"}))
 * @ORM\Entity
 * @ORM\Entity(repositoryClass="App\Repository\TaskRepository")
 */
class Task
{
    const STATUS_NEW  = 'new';
    const STATUS_COMPLETED = 'completed';

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var int
     *
     * @ORM\Column(name="user_id", type="integer", nullable=false)
     */
    private $userId;

    /**
     * @var int
     *
     * @ORM\Column(name="timestamp", type="datetime", nullable=false)
     * @ORM\Version
     */
    private $timestamp;

    /**
     * @var string|null
     *
     * @ORM\Column(name="text", type="string", length=500)
     */
    private $text;

    /**
     * @var string
     *
     * @ORM\Column(name="status", columnDefinition="ENUM('new', 'completed')")
     */
    private $status;


    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $userId
     * @return Task
     */
    public function setUserId($userId)
    {
        $this->userId = $userId;

        return $this;
    }

    /**
     * @return int
     */
    public function getUserId()
    {
        return $this->userId;
    }

    /**
     * @return int
     */
    public function getTimestamp()
    {
        return $this->timestamp->getTimestamp();
    }

    /**
     * @param string $text
     * @return Task
     */
    public function setText($text)
    {
        $this->text = $text;

        return $this;
    }

    /**
     * @return string
     */
    public function getText()
    {
        return $this->text;
    }

    /**
     * @param string $status
     * @return Task
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
    }

    public function toArray(){
        return [
            'id' => $this->getId(),
            'userId' => $this->getUserId(),
            'timestamp' => $this->getTimestamp(),
            'text' => $this->getText(),
            'status' => $this->getStatus()
        ];
    }

}