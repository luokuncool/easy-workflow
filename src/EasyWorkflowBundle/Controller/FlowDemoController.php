<?php

namespace EasyWorkflowBundle\Controller;

use DateTime;
use EasyWorkflowBundle\Controller\Interfaces\FlowInterface;
use EasyWorkflowBundle\Entity\Flow;
use EasyWorkflowBundle\Entity\LeaveFlow;
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

    /** @var  array $flowContext */
    private $flowContext;

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
        $flowId = (int)$request->get('flowId');
        if ($flowId == 0) {
            $nodeId = 2;
        } else {
            $flow = $this->getDoctrine()->getRepository('EasyWorkflowBundle:Flow')->find($flowId);
        }
        $nodeId = 1;
        return $this->getDoctrine()->getRepository('EasyWorkflowBundle:FlowNodes')->findWithHandlers($nodeId);
    }

    /**
     * @author luokuncool
     * @since  2016年05月18日
     * @Route("/create")
     *
     * @param Request $request
     *
     * @return Response
     */
    public function createAction(Request $request)
    {
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $em = $this->getDoctrine()->getManager();
        if ($request->isMethod(Request::METHOD_POST)) {
            $leaveFlow = new LeaveFlow();
            $leaveFlow
                ->setType((int)$request->get('type'))
                ->setStartAt(new DateTime($request->get('startAt')))
                ->setEndAt(new DateTime($request->get('endAt')))
                ->setCreateUid($user->getId())
                ->setReason($request->get('reason'))
                ->setCreateAt(new DateTime())
                ->setUpdateAt(new DateTime())
                ->setFlow($this->getFlowContext('flow'));
            $em->persist($leaveFlow);
            $em->flush();
        }
        $nextNode = $this->getNextHandler($request);
        return $this->render('@EasyWorkflow/FlowDemo/create.html.twig', ['nextNode' => $nextNode, 'query' => ['flowId' => 8]]);
    }

    /**
     * @param LeaveFlow $leaveFlow
     * @param Request   $request
     *
     * @return array
     * @Route("/{flowId}/check/")
     * @Template()
     *
     */
    public function checkAction(LeaveFlow $leaveFlow, Request $request)
    {
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $em = $this->getDoctrine()->getManager();
        if ($request->isMethod(Request::METHOD_POST)) {
            $leaveFlow
                ->setUpdateAt(new DateTime());
            $em->persist($leaveFlow);
            $em->flush();
        }
        $nextNode = $this->getNextHandler($request);
        return ['nextNode' => $nextNode, 'query' => ['flowId' => 8]];
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

    public function setFlowContext($key, $val)
    {
        $this->flowContext[$key] = $val;
    }

    public function getFlowContext($key = '')
    {
        if ($key) {
            return $this->flowContext[$key];
        }
        return $this->flowContext;
    }
}