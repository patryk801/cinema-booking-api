<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Auditorium;
use AppBundle\Entity\EntityMerger;
use AppBundle\Exception\ValidationException;
use Doctrine\Common\Annotations\AnnotationReader;
use FOS\RestBundle\Controller\ControllerTrait;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\Validator\ConstraintViolationListInterface;

class AuditoriumsController extends AbstractController
{
    use ControllerTrait;

    private $entityMerger;

    public function __construct()
    {
        $this->entityMerger = new EntityMerger(new AnnotationReader());
    }

    public function getAuditoriumsAction()
    {
        $auditoriums = $this->getDoctrine()->getRepository('AppBundle:Auditorium')->findAll();

        return $auditoriums;
    }

    public function getAuditoriumAction(?Auditorium $auditorium)
    {
        if(is_null($auditorium)) return $this->view(null, 404);

        return $auditorium;
    }

    public function getAuditoriumSeatsAction(?Auditorium $auditorium)
    {
        if(is_null($auditorium)) return $this->view(null, 404);

        return $auditorium->getSeats();
    }

    public function getAuditoriumScreeningsAction(?Auditorium $auditorium)
    {
        if(is_null($auditorium)) return $this->view(null, 404);

        return $auditorium->getScreenings();
    }

    /**
     * @Rest\View(statusCode=201)
     * @ParamConverter("auditorium", converter="fos_rest.request_body")
     * @Rest\NoRoute()
     */
    public function postAuditoriumsAction(?Auditorium $auditorium, ConstraintViolationListInterface $validationErrors)
    {
        if(count($validationErrors) > 0) throw new ValidationException($validationErrors);

        $em = $this->getDoctrine()->getManager();
        $em->persist($auditorium);
        $em->flush();

        return $auditorium;
    }

    /**
     * @ParamConverter("modifiedAuditorium", converter="fos_rest.request_body")
     */
    public function patchAuditoriumAction(?Auditorium $auditorium, Auditorium $modifiedAuditorium, ConstraintViolationListInterface $validationErrors)
    {
        if(is_null($auditorium)) return $this->view(null, 404);

        if(count($validationErrors) > 0) throw new ValidationException($validationErrors);

        $this->entityMerger->merge($auditorium, $modifiedAuditorium);

        $em = $this->getDoctrine()->getManager();
        $em->persist($auditorium);
        $em->flush();

        return $auditorium;
    }

    /**
     * @Rest\View(statusCode=204)
     */
    public function deleteAuditoriumAction(?Auditorium $auditorium)
    {
        if(is_null($auditorium)) return $this->view(null, 404);

        $em = $this->getDoctrine()->getManager();
        $em->remove($auditorium);
        $em->flush();
    }
}
