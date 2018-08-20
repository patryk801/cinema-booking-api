<?php

namespace AppBundle\Controller;

use AppBundle\Entity\EntityMerger;
use AppBundle\Entity\Image;
use AppBundle\Entity\Movie;
use AppBundle\Exception\ValidationException;
use AppBundle\Resource\Filtering\Movie\MovieFilterDefinitionFactory;
use AppBundle\Resource\Pagination\Movie\MoviePagination;
use AppBundle\Resource\Pagination\PageFactory;
use AppBundle\Service\FileUploader;
use FOS\RestBundle\Controller\ControllerTrait;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Validator\ConstraintViolationListInterface;

class MoviesController extends AbstractController
{
    use ControllerTrait;

    private $entityMerger;
    private $moviePagination;
    private $fileUploader;
    private $imagesDirectory;
    private $imageBaseUrl;

    public function __construct(string $imagesDirectory, string $imageBaseUrl, EntityMerger $entityMerger, MoviePagination $moviePagination, FileUploader $fileUploader)
    {
        $this->entityMerger = $entityMerger;
        $this->moviePagination = $moviePagination;
        $this->fileUploader = $fileUploader;
        $this->imagesDirectory = $imagesDirectory;
        $this->imageBaseUrl = $imageBaseUrl;
    }

    public function getMoviesAction(Request $request)
    {
        $page = PageFactory::createFromRequest($request);
        $movieFilterDefinition = MovieFilterDefinitionFactory::createFromRequest($request);

        return $this->moviePagination->paginate($page, $movieFilterDefinition);
    }

    public function getMovieAction(?Movie $movie)
    {
        if(is_null($movie)) return $this->view(null, 404);

        return $movie;
    }

    public function getMovieScreeningsAction(?Movie $movie)
    {
        return $movie->getScreenings();
    }

    /**
     * @Rest\View(statusCode=201)
     * @ParamConverter("movie", converter="fos_rest.request_body")
     * @Rest\NoRoute()
     */
    public function postMoviesAction(?Movie $movie, Request $request, ConstraintViolationListInterface $validationErrors)
    {
        if(count($validationErrors) > 0) throw new ValidationException($validationErrors);

        $em = $this->getDoctrine()->getManager();
        $em->persist($movie);
        $em->flush();

        return $movie;
    }

    /**
     * @ParamConverter("modifiedMovie", converter="fos_rest.request_body")
     */
    public function patchMovieAction(?Movie $movie, Movie $modifiedMovie, ConstraintViolationListInterface $validationErrors)
    {
        if(is_null($movie)) return $this->view(null, 404);

        if(count($validationErrors) > 0) throw new ValidationException($validationErrors);

        $this->entityMerger->merge($movie, $modifiedMovie);

        $em = $this->getDoctrine()->getManager();
        $em->persist($movie);
        $em->flush();

        return $movie;
    }

    /**
     * @Rest\View(statusCode=204)
     */
    public function deleteMovieAction(?Movie $movie)
    {
        if(is_null($movie)) return $this->view(null, 404);

        $em = $this->getDoctrine()->getManager();
        $em->remove($movie);
        $em->flush();
    }


    public function putMovieImageAction(?Movie $movie, Request $request)
    {
        if(is_null($movie)) throw new NotFoundHttpException();

        $fileName = $this->fileUploader->uploadImageFromPutRequest($request, $this->imagesDirectory);
        if(!is_null($fileName))
        {
            $image = new Image();
            $image->setUrl($this->imageBaseUrl.$fileName);
            $movie->setImage($image);
            $em = $this->getDoctrine()->getManager();
            $em->persist($image);
            $em->persist($movie);
            $em->flush();

            return $this->view($image, Response::HTTP_CREATED);
        }
    }
}