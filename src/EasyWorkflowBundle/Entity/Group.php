<?php

namespace EasyWorkflowBundle\Entity;

use DateTime;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Group
 *
 * @ORM\Table(name="groups")
 * @ORM\Entity(repositoryClass="EasyWorkflowBundle\Repository\GroupRepository")
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
     * @ORM\Column(name="roles", type="json_array")
     * @Assert\NotBlank(message="群组角色不能为空")
     */
    private $roles;

    /**
     * @var string
     *
     * @ORM\Column(name="remark", type="string", length=255)
     */
    private $remark;

    /**
     * @var DateTime
     *
     * @ORM\Column(name="create_at", type="datetime")
     */
    private $createAt;

    /**
     * @var DateTime
     *
     * @ORM\Column(name="update_at", type="datetime")
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
     */
    public function getRoles()
    {
        return $this->roles;
    }

    public function getRoleNames()
    {
        return array_values($this->roles);
    }


    public function getRoleKeys()
    {
        return array_keys($this->roles);
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
     * @param DateTime $createAt
     *
     * @return Group
     */
    public function setCreateAt(DateTime $createAt)
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
     * @param DateTime $updateAt
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
     * @return DateTime
     */
    public function getUpdateAt()
    {
        return $this->updateAt;
    }
}

