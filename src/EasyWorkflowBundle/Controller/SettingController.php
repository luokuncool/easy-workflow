<?php

namespace EasyWorkflowBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

class SettingController extends Controller
{

    /**
     * @param Request $request
     * @Route("/setting/password")
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function passwordAction(Request $request)
    {
        if (!$request->isMethod(Request::METHOD_POST)) {
            return $this->render('@EasyWorkflow/Setting/password.html.twig');
        }
        $passwordEncoder = $this->get('security.password_encoder');
        $activeUser = $this->get('security.token_storage')->getToken()->getUser();

        if (!$passwordEncoder->isPasswordValid($activeUser, $request->get('oldPassword'))) {
            $this->addFlash('error', '旧密码错误！');
            return $this->redirectToRoute('easyworkflow_setting_password');
        }
        if ($request->get('password') == '') {
            $this->addFlash('error', '请输入新密码！');
            return $this->redirectToRoute('easyworkflow_setting_password');
        }
        if ($request->get('password') != $request->get('confirm')) {
            $this->addFlash('error', '两次输入不一致！');
            return $this->redirectToRoute('easyworkflow_setting_password');
        }

        $em = $this->getDoctrine()->getManager();
        $user = $this->getDoctrine()->getRepository('EasyWorkflowBundle:User')->find($activeUser->getId());
        $user->setPassword($passwordEncoder->encodePassword($user, $request->get('password')));
        $em->flush();

        $this->addFlash('success', '密码修改成功！');
        return $this->redirectToRoute('easyworkflow_setting_password');
    }
}
