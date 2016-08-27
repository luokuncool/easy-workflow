<?php

namespace EasyWorkflowBundle\Controller\Interfaces;

use Symfony\Component\HttpFoundation\Request;

interface FlowInterface
{
    /**
     * 获取流程名
     * @return string
     */
    public function getFlowName();

    /**
     * 获取流程编号
     * @return string
     */
    public function getFlowCode();

    /**
     * 获取下一处理节点及处理人
     *
     * @param Request $request
     *
     * @return array
     */
    public function getNextHandler(Request $request);
}