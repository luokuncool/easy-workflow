<?php

namespace EasyWorkflowBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * FlowLog
 *
 * @ORM\Table(
 *   name="flow_logs",
 *   indexes={
 *     @ORM\Index(name="flow_id", columns={"flow_id"}),
 *     @ORM\Index(name="node_id", columns={"node_id"}),
 *     @ORM\Index(name="handler_id", columns={"handler_id"})
 *   }
 * )
 * @ORM\Entity(repositoryClass="EasyWorkflowBundle\Repository\FlowLogRepository")
 */
class FlowLog
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
     * @var int
     *
     * @ORM\Column(name="flow_id", type="integer")
     */
    private $flowId;

    /**
     * @var int
     *
     * @ORM\Column(name="node_id", type="integer")
     */
    private $nodeId;

    /**
     * @var int
     *
     * @ORM\Column(name="handler_id", type="integer")
     */
    private $handlerId;

    /**
     * @var string
     *
     * @ORM\Column(name="handler_name", type="string", length=255)
     */
    private $handlerName;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="receive_at", type="datetime")
     */
    private $receiveAt;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="complete_at", type="datetime")
     */
    private $completeAt;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text")
     */
    private $description;

    /**
     * @var array
     *
     * @ORM\Column(name="serialize_info", type="array")
     */
    private $serializeInfo;


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
     * Set flowId
     *
     * @param integer $flowId
     *
     * @return FlowLog
     */
    public function setFlowId($flowId)
    {
        $this->flowId = $flowId;

        return $this;
    }

    /**
     * Get flowId
     *
     * @return int
     */
    public function getFlowId()
    {
        return $this->flowId;
    }

    /**
     * Set nodeId
     *
     * @param integer $nodeId
     *
     * @return FlowLog
     */
    public function setNodeId($nodeId)
    {
        $this->nodeId = $nodeId;

        return $this;
    }

    /**
     * Get nodeId
     *
     * @return int
     */
    public function getNodeId()
    {
        return $this->nodeId;
    }

    /**
     * Set handlerId
     *
     * @param integer $handlerId
     *
     * @return FlowLog
     */
    public function setHandlerId($handlerId)
    {
        $this->handlerId = $handlerId;

        return $this;
    }

    /**
     * Get handlerId
     *
     * @return int
     */
    public function getHandlerId()
    {
        return $this->handlerId;
    }

    /**
     * Set handlerName
     *
     * @param string $handlerName
     *
     * @return FlowLog
     */
    public function setHandlerName($handlerName)
    {
        $this->handlerName = $handlerName;

        return $this;
    }

    /**
     * Get handlerName
     *
     * @return string
     */
    public function getHandlerName()
    {
        return $this->handlerName;
    }

    /**
     * Set receiveAt
     *
     * @param \DateTime $receiveAt
     *
     * @return FlowLog
     */
    public function setReceiveAt($receiveAt)
    {
        $this->receiveAt = $receiveAt;

        return $this;
    }

    /**
     * Get receiveAt
     *
     * @return \DateTime
     */
    public function getReceiveAt()
    {
        return $this->receiveAt;
    }

    /**
     * Set completeAt
     *
     * @param \DateTime $completeAt
     *
     * @return FlowLog
     */
    public function setCompleteAt($completeAt)
    {
        $this->completeAt = $completeAt;

        return $this;
    }

    /**
     * Get completeAt
     *
     * @return \DateTime
     */
    public function getCompleteAt()
    {
        return $this->completeAt;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return FlowLog
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
     * Set serializeInfo
     *
     * @param array $serializeInfo
     *
     * @return FlowLog
     */
    public function setSerializeInfo($serializeInfo)
    {
        $this->serializeInfo = $serializeInfo;

        return $this;
    }

    /**
     * Get serializeInfo
     *
     * @return array
     */
    public function getSerializeInfo()
    {
        return $this->serializeInfo;
    }
}

