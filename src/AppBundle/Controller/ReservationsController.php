<?php

namespace AppBundle\Controller;

use AppBundle\Resource\Filtering\Reservation\ReservationFilterDefinitionFactory;
use AppBundle\Resource\Pagination\PageFactory;
use AppBundle\Resource\Pagination\Reservation\ReservationPagination;
use AppBundle\Entity\EntityMerger;
use AppBundle\Entity\Reservation;
use AppBundle\Exception\ValidationException;
use FOS\RestBundle\Controller\ControllerTrait;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\ConstraintViolationListInterface;
use FOS\RestBundle\Controller\Annotations as Rest;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

/**
 * @Security("is_anonymous() or is_authenticated()")
 */
class ReservationsController extends Controller
{
    use ControllerTrait;

    private $entityMerger;
    private $pagination;

    public function __construct(EntityMerger $entityMerger, ReservationPagination $pagination)
    {
        $this->entityMerger = $entityMerger;
        $this->pagination = $pagination;
    }

    public function getReservationsAction(Request $request)
    {
        $page = PageFactory::createFromRequest($request);
        $reservationFilterDefinition = ReservationFilterDefinitionFactory::createFromRequest($request);

        return $this->pagination->paginate($page, $reservationFilterDefinition);
    }

    public function getReservationAction(?Reservation $reservation)
    {
        if(is_null($reservation)) return $this->view(null, 404);

        return $reservation;
    }

    public function getReservationScreeningAction(?Reservation $reservation)
    {
        if(is_null($reservation)) return $this->view(null, 404);

        return $reservation->getScreening();
    }

    /**
     * @Rest\View(statusCode=201)
     * @ParamConverter("reservation", converter="fos_rest.request_body")
     * @Rest\NoRoute()
     */
    public function postReservationAction(Reservation $reservation, ConstraintViolationListInterface $validationErrors)
    {
        if(count($validationErrors) > 0) throw new ValidationException($validationErrors);

        $em = $this->getDoctrine()->getManager();
        $em->persist($reservation);
        $em->flush();

        return $reservation;
    }

    /**
     * @ParamConverter("modifiedReservation", converter="fos_rest.request_body")
     * @Security("is_authenticated()")
     */
    public function patchReservationAction(?Reservation $reservation, Reservation $modifiedReservation, ConstraintViolationListInterface $validationErrors)
    {
        if(is_null($reservation)) return $this->view(null, 404);

        if(count($validationErrors) > 0) throw new ValidationException($validationErrors);

        $this->entityMerger->merge($reservation, $modifiedReservation);

        $em = $this->getDoctrine()->getManager();
        $em->persist($reservation);
        $em->flush();

        return $reservation;
    }

    /**
     * @Rest\View(statusCode=204)
     * @Security("is_authenticated()")
     */
    public function deleteReservationAction(?Reservation $reservation)
    {
        if(is_null($reservation)) return $this->view(null, 404);

        $em = $this->getDoctrine()->getManager();
        $em->remove($reservation);
        $em->flush();
    }
}