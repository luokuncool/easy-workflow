<?php

namespace EasyWorkflowBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

/**
 * Class UserController
 * @package EasyWorkflowBundle\Controller
 * @Route("/user")
 */
class UserController extends Controller
{
    /**
     * @Route("/create")
     * @Template()
     */
    public function createAction()
    {
        return array();
    }
}
