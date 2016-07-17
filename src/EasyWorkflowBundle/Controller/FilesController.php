<?php

namespace EasyWorkflowBundle\Controller;

use MongoId;
use Pagerfanta\Adapter\MongoAdapter;
use Pagerfanta\Pagerfanta;
use Pagerfanta\View\TwitterBootstrap3View;
use Pagerfanta\View\TwitterBootstrapView;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
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
     * @Route("/{page}/index", defaults={"page"=1})
     */
    public function indexAction($page)
    {
        $gridFS     = $this->getMongoGridFS();
        $cursor     = $gridFS->find()->sort(array('uploadDate' => -1));
        $adapter    = new MongoAdapter($cursor);
        $pagerfanta = new Pagerfanta($adapter);

        $pagerfanta->setMaxPerPage($this->getParameter('page.max_items'));
        $pagerfanta->setCurrentPage($page);


        $files   = array();
        $results = $pagerfanta->getCurrentPageResults();
        while ($file = $results->getNext()) {
            $file->file['size'] = number_format($file->file['length'] / (1024 * 1024), 3) . 'M';
            $files[]            = $file;
        }

        if ($files) {
            $view     = new TwitterBootstrap3View();
            $options  = array('proximity' => 2, 'prev_message' => '&laquo;&nbsp;上一页', 'next_message' => '下一页&nbsp;&raquo;');
            $pageView = $view->render($pagerfanta, function ($page) {
                return $this->generateUrl('easyworkflow_files_index', array('page' => $page));
            }, $options);
        } else {
            $pageView = '';
        }


        return $this->render('@EasyWorkflow/Files/index.html.twig', array('files' => $files, 'pageView' => $pageView));
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
        /*foreach ($request->files as $name => $file) {
            $id  = $grid->storeUpload($name, array('mimeType' => $file->getMimeType()));
            $row = $grid->findOne(array('_id' => $id));
            $row->getFilename();
        }*/
        $uploadName = 'file';

        $id  = $grid->storeUpload($uploadName, array('mimeType' => $request->files->get($uploadName)->getMimeType()));
        $row = $grid->findOne(array('_id' => $id));

        if ($request->get('isPasteUpload')) {
            return new JsonResponse(array('filename' => $row->getFilename(), 'row' => $row));
        } else {
            $this->addFlash('success', '文件上传成功');
            return $this->redirectToRoute('easyworkflow_files_index');
        }
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
