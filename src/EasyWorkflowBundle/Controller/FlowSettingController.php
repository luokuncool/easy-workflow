<?php

namespace EasyWorkflowBundle\Controller;

use DateTime;
use EasyWorkflowBundle\Controller\Interfaces\FlowInterface;
use EasyWorkflowBundle\Entity\FlowNode;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class FlowSettingController
 * @package EasyWorkflowBundle\Controller
 * @Route("/flow_setting")
 */
class FlowSettingController extends Controller
{
    /**
     * @return array
     * @Route("/index")
     * @Template()
     */
    public function indexAction()
    {
        $flows = $this->getFlows();
        return array('flows' => $flows);
    }

    /**
     * @author luokuncool
     * @since  2016年08月25日
     *
     * @Route("/{flowCode}/detail")
     * @Template()
     * @param $flowCode
     *
     * @return array
     */
    public function flowAction($flowCode)
    {
        $bind['flow']      = $this->getFlows($flowCode);
        $bind['flowNodes'] = $this
            ->getDoctrine()
            ->getRepository('EasyWorkflowBundle:FlowNode')
            ->findBy(array('flowCode' => $flowCode));
        return $bind;
    }

    /**
     * @author luokuncool
     * @since  2016年08月25日
     * @Route("/{flowCode}/create_node")
     * @Template()
     *
     * @param string  $flowCode
     * @param Request $request
     *
     * @return array
     */
    public function createNodeAction($flowCode, Request $request)
    {
        if ($request->isMethod(Request::METHOD_POST)) {
            $flowNode = new FlowNode();
            $flowNode->setFlowCode($flowCode);
            $flowNode->setRoute($request->get('route'));
            $flowNode->setName($request->get('name'));
            $flowNode->setDescription($request->get('description'));
            $flowNode->setCreateAt(new DateTime());
            $flowNode->setUpdateAt(new DateTime());
            $validator = $this->get('validator');
            $errors    = $validator->validate($flowNode);
            if ($errors->count()) {
                $this->addFlash('danger', $this->get('translator')->trans($errors->get(0)->getMessage()));
                $this->addFlash('flowNode', $flowNode);
                return $this->redirectToRoute('easyworkflow_flowsetting_createnode', array('flowCode' => $flowCode));
            } else {
                $em = $this->get('doctrine.orm.entity_manager');
                $em->persist($flowNode);
                $em->flush();
                $this->addFlash('success', '保存成功！');
            }
            return $this->redirectToRoute('easyworkflow_flowsetting_editnode', array('id' => $flowNode->getId()));
        }
        $flowNode = $this->get('session')->getFlashBag()->get('flowNode');
        $flowNode && $flowNode = $flowNode[0];
        $flow = $this->getFlows($flowCode);
        return array('flowNode' => $flowNode, 'flowCode' => $flowCode, 'flow' => $flow);
    }

    /**
     * @author Quentin
     * @since  2016年08月25日
     *
     * @param FlowNode $flowNode
     * @param Request  $request
     * @Template()
     * @Route("/{id}/edit")
     *
     * @return array
     */
    public function editNodeAction(FlowNode $flowNode, Request $request)
    {
        $em = $this->get('doctrine.orm.entity_manager');
        if ($request->isMethod(Request::METHOD_POST)) {
            $flowNode->setRoute($request->get('route'));
            $flowNode->setName($request->get('name'));
            $flowNode->setDescription($request->get('description'));
            $flowNode->setUpdateAt(new DateTime());
            $groups = $this->getDoctrine()
                ->getRepository('EasyWorkflowBundle:Group')
                ->findByIds((array)$request->get('groups'));
            $flowNode->getGroups()->clear();
            $flowNode->addGroup($groups);
            $validator = $this->get('validator');
            $errors    = $validator->validate($flowNode);
            if ($errors->count()) {
                $this->addFlash('danger', $this->get('translator')->trans($errors->get(0)->getMessage()));
                $this->addFlash('flowNode', $flowNode);
            } else {
                $em->flush();
                $this->addFlash('success', '保存成功！');
            }
            return $this->redirectToRoute('easyworkflow_flowsetting_editnode', array('id' => $flowNode->getId()));
        }
        if ($flushFlowNode = $this->get('session')->getFlashBag()->get('flowNode')) {
            $flowNode = $flushFlowNode[0];
        }

        $groups   = $this->getDoctrine()->getRepository('EasyWorkflowBundle:Group')->findAll();
        $flowCode = $flowNode->getFlowCode();
        $flow     = $this->getFlows($flowCode);
        return array('flowNode' => $flowNode, 'flowCode' => $flowCode, 'flow' => $flow, 'groups' => $groups);
    }

    private function getFlows($flowCode = '')
    {
        $router = $this->get('router');
        $routes = $router->getRouteCollection()->all();

        $flows = array();
        foreach ($routes as $route => $params) {
            $defaults = $params->getDefaults();
            if (isset($defaults['_controller'])) {
                $action     = explode(':', $defaults['_controller']);
                $controller = $action[0];
                $instance   = strpos($controller, '.') === false ? new $controller() : $this->get($controller);
                if (!($instance instanceof FlowInterface)) {
                    continue;
                }
                $flows[$controller]['instance'] = $instance;
                $flows[$controller]['name']     = $instance->getFlowName();
                $flows[$controller]['code']     = $instance->getFlowCode();
                $flows[$controller]['routes'][] = $route;
            }
        }
        if ($flowCode) {
            foreach ($flows as $flow) {
                if ($flowCode == $flow['code']) {
                    return $flow;
                }
            }
        }
        return $flows;
    }
}
