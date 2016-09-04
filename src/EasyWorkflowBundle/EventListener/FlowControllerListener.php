<?php

namespace EasyWorkflowBundle\EventListener;


use EasyWorkflowBundle\Controller\Interfaces\FlowInterface;
use EasyWorkflowBundle\Entity\Flow;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
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
        $request = $event->getRequest();

        if (!is_array($controller)) {
            return;
        }
        $this->controller = $controller;

        if ($controller[0] instanceof FlowInterface) {
            $this->nextHandlerFilter($event, $controller[0]);
            /*$this->container->get('doctrine.dbal.default_connection')->beginTransaction();
            $this->container->get('doctrine.dbal.default_connection')->insert('test.tmp', array('val' => rand(1111, 9999)));*/
            $nextNode = $controller[0]->getNextHandler($request);
            $flow = new Flow();
            dump($request->get('nextHandlerId'));
            $flow->setCurrentHandlerId($request->get('nextHandlerId'));
            $flow->setCreateAt(new \DateTime());
            $flow->setUpdateAt(new \DateTime());
            $flow->setFlowCode($controller[0]->getFlowCode());
            $flow->setCurrentNodeId($nextNode->getId());
            $controller[0]->setFlowContext('flow', $flow);

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

    /**
     * @param FilterControllerEvent $event
     * @param FlowInterface         $controller
     */
    private function nextHandlerFilter(FilterControllerEvent $event, FlowInterface $controller)
    {
        if (preg_match('#::getNextHandler$#', $event->getRequest()->get('_controller'))) {
            $event->setController(
                function () use ($controller, $event) {
                    $nextNode = $controller->getNextHandler($event->getRequest());
                    $content      = $this->container
                        ->get('twig')
                        ->render('@EasyWorkflow/_next_handlers.html.twig', array('nextNode' => $nextNode));
                    return new Response($content);
                }
            );
        }
    }
}