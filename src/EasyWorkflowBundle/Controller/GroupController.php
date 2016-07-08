<?php

namespace EasyWorkflowBundle\Controller;

use DateTime;
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
        $groups = $this->get('doctrine')->getRepository('EasyWorkflowBundle:Group')->findAll();
        return $this->render('@EasyWorkflow/Group/index.html.twig', ['groups' => $groups]);
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
            $group->setRemark($request->get('remark'));
            $group->setCreateAt(new DateTime());
            $group->setUpdateAt(new DateTime());
            $validator = $this->get('validator');
            $errors    = $validator->validate($group);
            if ($errors->count()) {
                $this->addFlash('error', $errors->get(0)->getMessage());
                $this->addFlash('group', $group);
                return $this->redirectToRoute('group_create');
            }
            $em = $this->get('doctrine.orm.entity_manager');
            $em->persist($group);
            $em->flush();
        }
        $group = $this->get('session')->getFlashBag()->get('group');
        $group && $group = $group[0];
        $roles = $this->getParameter('roles');
        return $this->render('@EasyWorkflow/Group/create.html.twig', array('roles' => $roles, 'group' => $group));
    }

    /**
     * @Route("/{id}/edit", name="group_edit")
     * @param         $id
     *
     * @param Request $request
     *
     * @return Response
     */
    public function editAction($id, Request $request)
    {
        $em    = $this->getDoctrine()->getManager();
        $group = $em->getRepository('EasyWorkflowBundle:Group')->find($id);
        dump($group);
        if ($request->isMethod(Request::METHOD_POST)) {
            $group->setGroupName($request->get('groupName'));
            $group->setRoles($request->get('roles'));
            $group->setRemark($request->get('remark'));
            $group->setUpdateAt(new DateTime());
            $validator = $this->get('validator');
            $errors    = $validator->validate($group);
            if ($errors->count()) {
                $this->addFlash('error', $errors->get(0)->getMessage());
                $this->addFlash('group', $group);
                return $this->redirectToRoute('group_create');
            }
            $em->flush();
        }
        $roles = $this->getParameter('roles');
        return $this->render('@EasyWorkflow/Group/edit.html.twig', array('roles' => $roles, 'group' => $group));
    }

    /**
     * @author Quentin
     * @since  2016年11月18日
     *
     * @param $id
     *
     * @return RedirectResponse
     * @Route("/{id}/delete", name="group_delete")
     */
    public function deleteAction($id)
    {
        $em    = $this->getDoctrine()->getManager();
        $group = $em->getRepository('EasyWorkflowBundle:Group')->find($id);
        $em->remove($group);
        $this->addFlash('notice', 'group.success');
        return $this->redirectToRoute('group_index');
    }
}