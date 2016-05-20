<?php

namespace EasyWorkflowBundle\Controller;

use EasyWorkflowBundle\Entity\Group;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
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
     * @param Request $request
     *
     * @return RedirectResponse|Response
     */
    public function createAction(Request $request)
    {
        if ($request->isMethod(Request::METHOD_POST)) {
            $group = new Group();
            $group->setGroupName($request->get('groupName'));
            $group->setRoles($request->get('roles'));
            $validator = $this->get('validator');
            $errors    = $validator->validate($group);
            if ($errors->count()) {
                $this->addFlash('error', $errors->get(0)->getMessage());
            }
            $this->addFlash('group', $group);
            return $this->redirectToRoute('group_create');
        }
        $group = $this->get('session')->getFlashBag()->get('group');
        $group && $group = $group[0];
        $roles = $this->getParameter('roles');
        return $this->render('@EasyWorkflow/Group/create.html.twig', array('roles' => $roles, 'group' => $group));
    }

    /**
     * @Route("/{id}/edit", name="group_edit")
     * @param $id
     * @return Response
     */
    public function editAction($id)
    {
        $group = $this->getDoctrine()->getRepository('EasyWorkflowBundle:Group')->find($id);
        return $this->render('@EasyWorkflow/Group/edit.html.twig', array('group' => $group));
    }

    /**
     * @author Quentin
     * @since  2016年11月18日
     * @return RedirectResponse
     * @Route("/delete", name="group_delete")
     */
    public function deleteAction()
    {
        $this->addFlash('notice', 'group.success');
        return $this->redirectToRoute('group_index');
    }
}