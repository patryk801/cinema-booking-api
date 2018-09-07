<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Image;
use AppBundle\Service\FileUploader;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * @Security("is_anonymous() or is_authenticated()")
 */
class ImagesController extends FOSRestController
{
    private $imagesDirectory;
    private $imageBaseUrl;
    private $fileUploader;

    public function __construct(string $imagesDirectory, string $imageBaseUrl, FileUploader $fileUploader)
    {
        $this->imagesDirectory = $imagesDirectory;
        $this->imageBaseUrl = $imageBaseUrl;
        $this->fileUploader = $fileUploader;
    }

    /**
     * @Rest\NoRoute()
     * @Security("is_authenticated()")
     */
    public function postImageAction(Request $request)
    {
        $file = $request->files->get('file');
        $fileName = $this->fileUploader->uploadImage($file, $this->imagesDirectory);
        if(!is_null($fileName))
        {
            $image = new Image();
            $image
                ->setDescription($request->request->get('description'))
                ->setUrl($this->imageBaseUrl.$fileName);
            $em = $this->getDoctrine()->getManager();
            $em->persist($image);
            $em->flush();

            return $this->view($image, Response::HTTP_CREATED);
        }
    }
}