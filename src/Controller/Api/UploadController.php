<?php

namespace App\Controller\Api;

use App\Domain\Interfaces\FileUploadProcessorInterface;
use App\Utils\TypeMapper;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

/**
 * @Route("/api/", name="api_file")
 * Class UploadController
 * @package App\Controller\Api
 */
class UploadController extends AbstractController
{
    /**
     * @Route("file", methods="POST", name="_upload")
     * @param Request $request
     * @param FileUploadProcessorInterface $uploadProcessor
     * @return JsonResponse
     */
    function upload(Request $request, FileUploadProcessorInterface $uploadProcessor)
    {
        /** @var UploadedFile $file */
        $file = $request->files->get('file', null);
        if (!$file) {
            throw new BadRequestHttpException('file field required');
        }

        $fileEntity = TypeMapper::UploadedToFileRequestEntity($file);
        $result = $uploadProcessor->processUpload($fileEntity);

        return $this->json([
            'code' => $result->getCode(),
            'url' => $this->generateUrl('download', ['uid' => $result->getCode()], UrlGeneratorInterface::ABSOLUTE_URL),
        ]);
    }
}