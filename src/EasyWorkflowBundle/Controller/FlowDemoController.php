<?php

namespace EasyWorkflowBundle\Controller;

use DateTime;
use EasyWorkflowBundle\Controller\Interfaces\FlowInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class FlowDemoController
 * @package EasyWorkflowBundle\Controller
 * @Route("/flow_demo")
 */
class FlowDemoController extends Controller implements FlowInterface
{
    const FLOW_CODE = 'flow_demo';

    const FLOW_NAME = '示例流程';

    /**
     * {@inheritdoc}
     */
    public function getFlowCode()
    {
        return self::FLOW_CODE;
    }

    /**
     * {@inheritdoc}
     */
    public function getFlowName()
    {
        return self::FLOW_NAME;
    }

    /**
     * @Route("/get_next_handler")
     * {@inheritdoc}
     */
    public function getNextHandler(Request $request)
    {
        $nodeId = 1;
        return $this->getDoctrine()->getRepository('EasyWorkflowBundle:FlowNodes')->findWithHandlers($nodeId);
        return array(
            'nextNodeId'   => '1',
            'nextNodeName' => '下一节点名称',
            'nextHandlers' => array(
                array('id' => 1, 'username' => '用户名')
            ),
        );
    }

    /**
     * @author luokuncool
     * @since  2016年05月18日
     * @Route("/create", name="flow_demo_create", options={"expose"=true})
     *
     * @param Request $request
     *
     * @return Response
     */
    public function createAction(Request $request)
    {
        return $this->render('@EasyWorkflow/FlowDemo/create.html.twig');
    }

    /**
     * @author Quentin
     * @since  2016年11月18日
     * @Template()
     * @Route("/index", options={"expose"=true})
     */
    public function indexAction()
    {
        return array();
    }
}