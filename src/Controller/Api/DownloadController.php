<?php

namespace App\Controller\Api;

use App\Interfaces\FileEntityFindByUidInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

/**
 * @Route("/api/", name="api_file")
 * Class UploadController
 * @package App\Controller\Api
 */
class DownloadController extends AbstractController
{
    /**
     * @Route("file/{uid}", methods={"GET"}, name="_download")
     * @param string $uid
     * @param FileEntityFindByUidInterface $repository
     * @return JsonResponse
     */
    public function download(string $uid, FileEntityFindByUidInterface $repository)
    {
        $entity = $repository->findByUid($uid);
        if (!$entity) {
            throw new NotFoundHttpException('Файл не найден');
        }

        return $this->json([
            'name' => $entity->getName(),
            'path' => $this->generateUrl('download', ['uid' => $uid], UrlGeneratorInterface::ABSOLUTE_URL),
            'timestamp' => $entity->getCreatedTimestamp(),
        ]);
    }
}
