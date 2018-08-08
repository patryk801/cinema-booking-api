<?php

namespace AppBundle\Controller;

use AppBundle\Entity\EntityMerger;
use AppBundle\Entity\Movie;
use AppBundle\Exception\ValidationException;
use AppBundle\Resource\Filtering\Movie\MovieFilterDefinitionFactory;
use AppBundle\Resource\Pagination\Movie\MoviePagination;
use AppBundle\Resource\Pagination\PageFactory;
use FOS\RestBundle\Controller\ControllerTrait;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\ConstraintViolationListInterface;

class MoviesController extends AbstractController
{
    use ControllerTrait;

    private $entityMerger;
    private $moviePagination;

    public function __construct(EntityMerger $entityMerger, MoviePagination $moviePagination)
    {
        $this->entityMerger = $entityMerger;
        $this->moviePagination = $moviePagination;
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
    public function postMoviesAction(?Movie $movie, ConstraintViolationListInterface $validationErrors)
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
}