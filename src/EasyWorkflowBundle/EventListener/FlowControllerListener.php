<?php

namespace EasyWorkflowBundle\EventListener;

use EasyWorkflowBundle\Controller\Interfaces\FlowInterface;
use EasyWorkflowBundle\Entity\Flow;
use EasyWorkflowBundle\Entity\FlowLog;
use EasyWorkflowBundle\Entity\FlowNodes;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\FilterControllerEvent;
use Symfony\Component\HttpKernel\Event\FilterResponseEvent;

class FlowControllerListener
{
    private $container;

    private $controller;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    public function onKernelController(FilterControllerEvent $event)
    {
        $controller = $event->getController();
        $request    = $event->getRequest();

        if (!is_array($controller)) {
            return $controller;
        }
        $this->controller = $controller;

        if ($controller[0] instanceof FlowInterface) {
            $this->nextHandlerFilter($event, $controller[0]);
            if ($request->isMethod(Request::METHOD_POST)) {
                $this->saveFlowData($request, $controller[0]);
            }
        }
        return $controller;
    }

    public function onKernelResponse(FilterResponseEvent $event)
    {
        if (!is_array($this->controller)) {
            return;
        }

        if ($this->controller[0] instanceof FlowInterface) {
            /*$this->container->get('doctrine.dbal.default_connection')->commit();*/
        }
    }

    private function nextHandlerFilter(FilterControllerEvent $event, FlowInterface $controller)
    {
        if (preg_match('#::getNextHandler$#', $event->getRequest()->get('_controller'))) {
            $event->setController(
                function () use ($controller, $event) {
                    $nextNode = $controller->getNextHandler($event->getRequest());
                    $content  = $this->container
                        ->get('twig')
                        ->render('@EasyWorkflow/_next_handlers.html.twig', array('nextNode' => $nextNode));
                    return new Response($content);
                }
            );
        }
    }

    private function saveFlowData(Request $request, FlowInterface $controller)
    {
        $easyWorkflow = $request->get('easyWorkflow');
        $flow         = $this->container
            ->get('doctrine')
            ->getManager()
            ->getRepository('EasyWorkflowBundle:Flow')
            ->find((int)$easyWorkflow['id']);
        /** @var FlowNodes $nextNode */
        $nextNode = $controller->getNextHandler($request);

        if (!$flow) {
            $flow = new Flow();
            $flow->setCreateAt(new \DateTime());
            $flow->setFlowCode($controller->getFlowCode());
        }
        $flow->setCurrentHandlerId((int)$easyWorkflow['nextHandlerId']);
        $flow->setUpdateAt(new \DateTime());
        $flow->setCurrentNodeId($nextNode->getId());

        $flowLog = new FlowLog();
        $flowLog->setFlow($flow)
            ->setNodeId($nextNode->getId())
            ->setReceiveAt(new \DateTime())
            ->setCompleteAt(new \DateTime())
            ->setDescription('description')
            ->setHandlerId(1)
            ->setHandlerName('quentin')
            ->setSerializeInfo(array());
        $controller->setFlowContext('flow', $flow);
        $flow->addFlowLog($flowLog);
    }
}