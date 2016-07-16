<?php

namespace EasyWorkflowBundle\Controller;

use MongoId;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class FilesController
 * @package EasyWorkflowBundle\Controller
 * @Route("/files")
 */
class FilesController extends Controller
{
    /**
     * @return Response
     * @Route("/")
     */
    public function indexAction()
    {
        $gridFS = $this->getMongoGridFS();
        $cursor = $gridFS->find();
        $files  = array();
        while ($file = $cursor->getNext()) {
            $file->file['size'] = number_format($file->file['length'] / (1024 * 1024), 3) . 'M';
            $files[]            = $file;
        }
        return $this->render('@EasyWorkflow/Files/index.html.twig', array('files' => $files));
    }

    /**
     * @param Request $request
     * @Route("/upload2mongo", methods={"POST"})
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function upload2mongoAction(Request $request)
    {
        $grid = $this->getMongoGridFS();
        /** @var \Symfony\Component\HttpFoundation\File\UploadedFile $file */
        foreach ($request->files as $name => $file) {
            $id  = $grid->storeUpload($name, array('mimeType' => $file->getMimeType()));
            $row = $grid->findOne(array('_id' => $id));
            $row->getFilename();
        }
        $this->addFlash('success', '文件上传成功');
        return $this->redirectToRoute('easyworkflow_files_index');
    }

    /**
     * @Route("/upload_view")
     */
    public function uploadViewAction()
    {
        return $this->render('@EasyWorkflow/Files/uploadView.html.twig');
    }

    /**
     * @param $id
     * @Route("/{id}/read")
     *
     * @return Response
     */
    public function readAction($id)
    {
        $grid     = $this->getMongoGridFS();
        $file     = $grid->findOne(array('_id' => new MongoId($id)));
        $response = new Response($file->getBytes());
        $response->headers->set('Content-Type', $file->file['mimeType']);
        $response->headers->set('Content-Disposition', "filename={$file->getFilename()}");
        $secondsToCache = 3600;
        $ts             = gmdate("D, d M Y H:i:s", time() + $secondsToCache) . " GMT";
        $response->headers->set('Expires', $ts);
        $response->headers->set('Cache-Control', "max-age=$secondsToCache");
        $response->headers->set('Pragma', 'cache');
        return $response;
    }

    /**
     * @param $id
     * @Route("/{id}/delete")
     *
     * @return Response
     */
    public function delete($id)
    {
        $grid = $this->getMongoGridFS();
        $grid->remove(array('_id' => new MongoId($id)));
        $this->addFlash('success', '删除成功');
        return $this->redirectToRoute('easyworkflow_files_index');
    }

    /**
     * @return \MongoGridFS
     */
    protected function getMongoGridFS()
    {
        return $this->get('mongo_client')
            ->selectDB($this->getParameter('database_name'))
            ->getGridFS();
    }
}
