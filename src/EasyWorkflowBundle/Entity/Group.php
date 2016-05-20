<?php

namespace EasyWorkflowBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Group
 *
 * @ORM\Table(name="group")
 * @ORM\Entity(repositoryClass="EasyWorkflowBundle\Repository\Entity\GroupRepository")
 */
class Group
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="group_name", type="string", length=255, unique=true)
     * @Assert\NotBlank(message="group.not_blank.group_name")
     */
    private $groupName;

    /**
     * @var string
     *
     * @ORM\Column(name="roles", type="text")
     */
    private $roles;

    /**
     * @var string
     *
     * @ORM\Column(name="remark", type="string", length=255)
     */
    private $remark;

    /**
     * @var int
     *
     * @ORM\Column(name="create_at", type="integer")
     */
    private $createAt;

    /**
     * @var int
     *
     * @ORM\Column(name="update_at", type="integer")
     */
    private $updateAt;


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set groupName
     *
     * @param string $groupName
     *
     * @return Group
     */
    public function setGroupName($groupName)
    {
        $this->groupName = $groupName;

        return $this;
    }

    /**
     * Get groupName
     *
     * @return string
     */
    public function getGroupName()
    {
        return $this->groupName;
    }

    /**
     * Set roles
     *
     * @param string $roles
     *
     * @return Group
     */
    public function setRoles($roles)
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * Get roles
     *
     * @return string
     */
    public function getRoles()
    {
        return $this->roles;
    }

    /**
     * Set remark
     *
     * @param string $remark
     *
     * @return Group
     */
    public function setRemark($remark)
    {
        $this->remark = $remark;

        return $this;
    }

    /**
     * Get remark
     *
     * @return string
     */
    public function getRemark()
    {
        return $this->remark;
    }

    /**
     * Set createAt
     *
     * @param integer $createAt
     *
     * @return Group
     */
    public function setCreateAt($createAt)
    {
        $this->createAt = $createAt;

        return $this;
    }

    /**
     * Get createAt
     *
     * @return int
     */
    public function getCreateAt()
    {
        return $this->createAt;
    }

    /**
     * Set updateAt
     *
     * @param integer $updateAt
     *
     * @return Group
     */
    public function setUpdateAt($updateAt)
    {
        $this->updateAt = $updateAt;

        return $this;
    }

    /**
     * Get updateAt
     *
     * @return int
     */
    public function getUpdateAt()
    {
        return $this->updateAt;
    }
}

