<?php

namespace EasyWorkflowBundle\EventListener;


use EasyWorkflowBundle\Controller\Interfaces\FlowInterface;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Event\FilterControllerEvent;

class ControllerBeforeListener
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

        if ($token = $this->container->get('security.token_storage')->getToken()) {
            $activeUser = $token->getUser();
            $this->container->get('twig')->addGlobal('activeUser', $activeUser);
        }

        if ($controller[0] instanceof FlowInterface) {

        }
    }
}