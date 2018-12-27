<?php

namespace EasyWorkflowBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * LeaveFlow
 *
 * @ORM\Table(name="leave_flow")})
 * @ORM\Entity(repositoryClass="EasyWorkflowBundle\Repository\LeaveFlowRepository")
 */
class LeaveFlow
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
     * @var \DateTime
     *
     * @ORM\Column(name="start_at", type="datetime")
     */
    private $startAt;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="end_at", type="datetime")
     */
    private $endAt;

    /**
     * @var int
     *
     * @ORM\Column(name="type", type="smallint")
     */
    private $type;

    /**
     * @var string
     *
     * @ORM\Column(name="reason", type="text")
     */
    private $reason;

    /**
     * @var int
     *
     * @ORM\Column(name="create_uid", type="integer")
     */
    private $createUid;

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
     * @ORM\OneToOne(targetEntity="EasyWorkflowBundle\Entity\Flow", cascade={"persist"})
     * @ORM\JoinColumn(name="flow_id", referencedColumnName="id")
     */
    private $flow;

    public function __construct()
    {
        $this->flow = new Flow();
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
     * Set startAt
     *
     * @param \DateTime $startAt
     *
     * @return LeaveFlow
     */
    public function setStartAt($startAt)
    {
        $this->startAt = $startAt;

        return $this;
    }

    /**
     * Get startAt
     *
     * @return \DateTime
     */
    public function getStartAt()
    {
        return $this->startAt;
    }

    /**
     * Set endAt
     *
     * @param \DateTime $endAt
     *
     * @return LeaveFlow
     */
    public function setEndAt($endAt)
    {
        $this->endAt = $endAt;

        return $this;
    }

    /**
     * Get endAt
     *
     * @return \DateTime
     */
    public function getEndAt()
    {
        return $this->endAt;
    }

    /**
     * Set type
     *
     * @param integer $type
     *
     * @return LeaveFlow
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return int
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set reason
     *
     * @param string $reason
     *
     * @return LeaveFlow
     */
    public function setReason($reason)
    {
        $this->reason = $reason;

        return $this;
    }

    /**
     * Get reason
     *
     * @return string
     */
    public function getReason()
    {
        return $this->reason;
    }

    /**
     * Set createAt
     *
     * @param \DateTime $createAt
     *
     * @return LeaveFlow
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
     * @return LeaveFlow
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
     * Set createUid
     *
     * @param integer $createUid
     *
     * @return LeaveFlow
     */
    public function setCreateUid($createUid)
    {
        $this->createUid = $createUid;

        return $this;
    }

    /**
     * Get createUid
     *
     * @return int
     */
    public function getCreateUid()
    {
        return $this->createUid;
    }

    /**
     * Set flowId
     *
     * @param integer $flowId
     *
     * @return LeaveFlow
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
     * @return mixed
     */
    public function getFlow()
    {
        return $this->flow;
    }

    /**
     * @param mixed $flow
     */
    public function setFlow($flow)
    {
        $this->flow = $flow;
    }
}

