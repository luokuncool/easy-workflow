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
    const flowName = 'flow_demo';

    /**
     * @author luokuncool
     * @since  2016年05月18日
     * @Route("/create", name="flow_demo_create", options={"expose"=true})
     */
    public function createAction(Request $request)
    {
        /** @var $router \Symfony\Component\Routing\Router */
        $router = $this->container->get('router');
        /** @var $collection \Symfony\Component\Routing\RouteCollection */
        $collection = $router->getRouteCollection();
        $allRoutes  = $collection->all();

        $routes = array();

        /** @var $params \Symfony\Component\Routing\Route */
        foreach ($allRoutes as $route => $params) {
            $defaults = $params->getDefaults();

            if (isset($defaults['_controller'])) {
                $controllerAction = explode(':', $defaults['_controller']);
                $controller       = $controllerAction[0];
                $instance         = strpos($controller, '.') === false ? new $controller() : $this->get($controller);
                if (!($instance instanceof FlowInterface)) {
                    continue;
                }

                if (!isset($routes[$controller])) {
                    $routes[$controller] = array();
                }

                $routes[$controller][] = $route;
            }
        }
        dump($routes);
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

    /**
     * @inheritdoc
     */
    public function getFlowName()
    {
        return self::flowName;
    }

    /**
     * @Route("/get_next_handler")
     * @inheritdoc
     */
    public function getNextHandler(Request $request)
    {
        return array(
            'nextNodeId'   => '1',
            'nextNodeName' => '下一节点名称',
            'nextHandlers' => array(
                array('id' => 1, 'username' => '用户名')
            ),
        );
    }
}