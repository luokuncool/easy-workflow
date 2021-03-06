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
     * @Route("/{page}/page", defaults={"page"=1})
     */
    public function indexAction($page)
    {
        $em         = $this->get('doctrine.orm.entity_manager');
        $query      = $em->createQuery("SELECT g FROM EasyWorkflowBundle:Group g ORDER BY g.id ASC");
        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate($query, $page, $this->getParameter('page.max_items'));
        return $this->render('@EasyWorkflow/Group/index.html.twig', ['pagination' => $pagination]);
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
                $this->addFlash('danger', $this->get('translator')->trans($errors->get(0)->getMessage()));
                $this->addFlash('group', $group);
                return $this->redirectToRoute('group_create');
            } else {
                $em = $this->get('doctrine.orm.entity_manager');
                $em->persist($group);
                $em->flush();
                $this->addFlash('success', '保存成功！');
            }
            return $this->redirectToRoute('group_edit', array('id' => $group->getId()));
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
        $em     = $this->getDoctrine()->getManager();
        $groups = $this->get('session')->getFlashBag()->get('group');
        $group  = array_pop($groups);
        $group OR $group = $em->getRepository('EasyWorkflowBundle:Group')->find($id);
        dump($group->getUsers()->toArray());
        if ($request->isMethod(Request::METHOD_POST)) {
            $group->setGroupName((string)$request->get('groupName'));
            $group->setRoles((array)$request->get('roles'));
            $group->setRemark((string)$request->get('remark'));
            $group->setUpdateAt(new DateTime());
            $validator = $this->get('validator');
            $errors    = $validator->validate($group);
            if ($errors->count()) {
                $this->addFlash('danger', $this->get('translator')->trans($errors->get(0)->getMessage()));
                $this->addFlash('group', $group);
            } else {
                $em->flush();
                $this->addFlash('success', '保存成功！');
            }
            return $this->redirectToRoute('group_edit', array('id' => $id));
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
        if ($group) {
            $em->remove($group);
            $em->flush();
            $this->addFlash('success', '删除成功');
        } else {
            $this->addFlash('warning', '数据不存在！');
        }
        return $this->redirectToRoute('easyworkflow_group_index');
    }
}