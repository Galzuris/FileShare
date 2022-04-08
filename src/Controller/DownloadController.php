<?php

namespace App\Controller;

use App\Interfaces\FileEntityFindByUidInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;

class DownloadController extends AbstractController
{
    /**
     * @Route("/{uid}", name="download", methods={"GET"})
     * @param string $uid
     * @param FileEntityFindByUidInterface $repository
     * @return Response
     */
    public function download(string $uid, FileEntityFindByUidInterface $repository): Response
    {
        $entity = $repository->findByUid($uid);
        if (!$entity) {
            throw new NotFoundHttpException();
        }

        $response = new BinaryFileResponse($entity->getPath());
        $response->headers->set('Content-Disposition', 'attachment; filename="' . $entity->getName() . '"');

        return $response;
    }
}