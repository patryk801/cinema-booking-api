<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Screening;
use AppBundle\Resource\Filtering\Screening\ScreeningFilterDefinitionFactory;
use AppBundle\Resource\Pagination\PageFactory;
use AppBundle\Resource\Pagination\Screening\ScreeningPagination;
use FOS\RestBundle\Controller\ControllerTrait;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpFoundation\Request;

class ScreeningsController extends AbstractController
{
    use ControllerTrait;

    private $pagination;

    public function __construct(ScreeningPagination $pagination)
    {
        $this->pagination = $pagination;
    }

    public function getScreeningsAction(Request $request)
    {
        $page = PageFactory::createFromRequest($request);
        $screeningFilterDefinition = ScreeningFilterDefinitionFactory::createFromRequest($request);

        return $this->pagination->paginate($page, $screeningFilterDefinition);
    }

    public function getScreeningAction(?Screening $screening)
    {
        if(is_null($screening)) return $this->view(null, 404);

        return $screening;
    }

    public function getScreeningSeatsAction(?Screening $screening)
    {
        if(is_null($screening)) return $this->view(null, 404);

        return $screening->getAuditorium()->getSeats();
    }

    /**
     * @Rest\NoRoute()
     */
    public function getScreeningReservedSeatsAction(?Screening $screening)
    {
        $seats = [];

        foreach ($screening->getReservedSeats() as $reservedSeat)
        {
            $seats[] = $reservedSeat->getSeat();
        }

        return $seats;
    }
}
