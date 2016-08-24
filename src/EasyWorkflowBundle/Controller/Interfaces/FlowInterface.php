<?php
/**
 *
 * @package    Action
 * @author     Quentin
 * @since      2016/5/18 11:07
 */

namespace EasyWorkflowBundle\Controller\Interfaces;


use Symfony\Component\HttpFoundation\Request;

interface FlowInterface
{
    /**
     * 获取流程名
     * @return mixed
     */
    public function getFlowName();

    /**
     * 获取下一处理节点及处理人
     * @param Request $request
     *
     * @return mixed
     */
    public function getNextHandler(Request $request);
}