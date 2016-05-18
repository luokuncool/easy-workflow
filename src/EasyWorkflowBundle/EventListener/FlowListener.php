<?php

namespace EasyWorkflowBundle\EventListener;


use EasyWorkflowBundle\Controller\Interfaces\FlowInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Event\FilterControllerEvent;

class FlowListener
{
    private $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    public function onKernelController(FilterControllerEvent $event)
    {
        $controller = $event->getController();

        if (!is_array($controller)) {
            return;
        }

        if ($controller[0] instanceof FlowInterface) {
            if ($event->getRequest()->isXmlHttpRequest()) {
                $event->setController(
                    function () {
                        return JsonResponse::create($_SERVER);
                    }
                );
            }
        }
    }
}