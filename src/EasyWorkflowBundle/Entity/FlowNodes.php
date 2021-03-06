<?php

namespace EasyWorkflowBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\JoinTable;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * FlowNodes
 *
 * @ORM\Table(name="flow_nodes")
 * @ORM\Entity(repositoryClass="EasyWorkflowBundle\Repository\FlowNodesRepository")
 */
class FlowNodes
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
     * @ORM\Column(name="flow_code", type="string", length=255)
     * @Assert\NotBlank(message="流程编码不能为空")
     */
    private $flowCode;


    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     * @Assert\NotBlank(message="节点名称不能为空")
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="route", type="string", length=255)
     * @Assert\NotBlank(message="请选择节点路由")
     */
    private $route;


    /**
     * @ORM\ManyToMany(targetEntity="EasyWorkflowBundle\Entity\Group")
     * @JoinTable(
     *   name="flow_nodes_groups",
     *   joinColumns={@ORM\JoinColumn(name="flow_node_id", referencedColumnName="id")},
     *   inverseJoinColumns={@ORM\JoinColumn(name="group_id", referencedColumnName="id")}
     * )
     */
    private $groups;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=255)
     */
    private $description;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="create_at", type="datetime")
     */
    private $createAt;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="update_at", type="datetime")
     */
    private $updateAt;

    public function __construct()
    {
        $this->groups = new ArrayCollection();
    }

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
     * Set name
     *
     * @param string $name
     *
     * @return FlowNodes
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set route
     *
     * @param string $route
     *
     * @return FlowNodes
     */
    public function setRoute($route)
    {
        $this->route = $route;

        return $this;
    }

    /**
     * Get route
     *
     * @return string
     */
    public function getRoute()
    {
        return $this->route;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return FlowNodes
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set createAt
     *
     * @param \DateTime $createAt
     *
     * @return FlowNodes
     */
    public function setCreateAt($createAt)
    {
        $this->createAt = $createAt;

        return $this;
    }

    /**
     * Get createAt
     *
     * @return \DateTime
     */
    public function getCreateAt()
    {
        return $this->createAt;
    }

    /**
     * Set updateAt
     *
     * @param \DateTime $updateAt
     *
     * @return FlowNodes
     */
    public function setUpdateAt($updateAt)
    {
        $this->updateAt = $updateAt;

        return $this;
    }

    /**
     * Get updateAt
     *
     * @return \DateTime
     */
    public function getUpdateAt()
    {
        return $this->updateAt;
    }

    /**
     * @return string
     */
    public function getFlowCode()
    {
        return $this->flowCode;
    }

    /**
     * @param string $flowCode
     */
    public function setFlowCode($flowCode)
    {
        $this->flowCode = $flowCode;
    }

    public function addGroup($groups)
    {
        if ($groups instanceof Group) {
            $groups = [$groups];
        }
        foreach ($groups as $group) {
            $this->groups->add($group);
        }
    }

    public function getGroups()
    {
        return $this->groups;
    }
}

