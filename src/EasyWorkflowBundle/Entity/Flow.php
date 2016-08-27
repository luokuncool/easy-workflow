<?php

namespace EasyWorkflowBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Flow
 *
 * @ORM\Table(name="flows")
 * @ORM\Entity(repositoryClass="EasyWorkflowBundle\Repository\FlowRepository")
 */
class Flow
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
     */
    private $flowCode;

    /**
     * @var int
     *
     * @ORM\Column(name="current_node_id", type="integer")
     */
    private $currentNodeId;

    /**
     * @var int
     *
     * @ORM\Column(name="current_handler_id", type="integer")
     */
    private $currentHandlerId;

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
     * Set currentHandlerId
     *
     * @param integer $currentHandlerId
     *
     * @return Flow
     */
    public function setCurrentHandlerId($currentHandlerId)
    {
        $this->currentHandlerId = $currentHandlerId;

        return $this;
    }

    /**
     * Get currentHandlerId
     *
     * @return int
     */
    public function getCurrentHandlerId()
    {
        return $this->currentHandlerId;
    }

    /**
     * Set createAt
     *
     * @param \DateTime $createAt
     *
     * @return Flow
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
     * @return Flow
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
     * Set flowName
     *
     * @param string $flowCode
     *
     * @return Flow
     */
    public function setFlowCode($flowCode)
    {
        $this->flowCode = $flowCode;

        return $this;
    }

    /**
     * Get flowName
     *
     * @return string
     */
    public function getFlowCode()
    {
        return $this->flowCode;
    }

    /**
     * @return int
     */
    public function getCurrentNodeId()
    {
        return $this->currentNodeId;
    }

    /**
     * @param int $currentNodeId
     */
    public function setCurrentNodeId($currentNodeId)
    {
        $this->currentNodeId = $currentNodeId;
    }
}

