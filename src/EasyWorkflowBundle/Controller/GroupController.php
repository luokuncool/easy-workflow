<?php

namespace EasyWorkflowBundle\Controller;

use EasyWorkflowBundle\Entity\Group;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

/**
 * 群组管理
 * Class GroupController
 * @package EasyWorkflowBundle\Controller
 * @Route("/group")
 */
class GroupController extends Controller
{
    /**
     * @Route("/", name="group")
     * @Route("/index", name="group_index")
     */
    public function indexAction()
    {
        return $this->render('@EasyWorkflow/Group/index.html.twig');
    }

    /**
     * @Route("/create", name="group_create")
     */
    public function createAction()
    {
        $group = new Group();
        $group->setGroupName('aaa');
        $validator = $this->get('validator');
        /*$errors = $validator->validate($group);
        dump($errors);
        if ($errors->count()) {
            $this->addFlash('error', $errors->get(0)->getMessage());
        }*/

        $roles = $this->getParameter('roles');
        return $this->render('@EasyWorkflow/Group/create.html.twig', array('roles' => $roles));
    }

    /**
     * @Route("edit", name="group_edit")
     */
    public function editAction()
    {
        return $this->render('@EasyWorkflow/Group/edit.html.twig');
    }

    /**
     * @author Quentin
     * @since  2016年11月18日
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     * @Route("/delete", name="group_delete")
     */
    public function deleteAction()
    {
        $this->addFlash('notice', 'group.success');
        return $this->redirectToRoute('group_index');
    }
}