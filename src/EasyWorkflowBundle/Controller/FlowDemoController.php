<?php

namespace EasyWorkflowBundle\Controller;

use EasyWorkflowBundle\Controller\Interfaces\FlowInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * Class FlowDemoController
 * @package EasyWorkflowBundle\Controller
 * @Route("/flow_demo")
 */
class FlowDemoController extends Controller implements FlowInterface
{
    /**
     * @author luokuncool
     * @since  2016年05月18日
     * @Route("/create", name="flow_demo_create")
     */
    public function createAction()
    {
        return $this->render('@EasyWorkflow/FlowDemo/create.html.twig');
    }

    /**
     * @author Quentin
     * @since  2016年11月18日
     * @Template()
     * @Route("/index")
     */
    public function indexAction()
    {
        return array();
    }
}