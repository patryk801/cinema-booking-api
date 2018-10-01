<?php

namespace AppBundle\Request\ParamConverter;


use AppBundle\Entity\Reservation;
use AppBundle\Repository\ScreeningRepository;
use AppBundle\Repository\SeatRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Request\ParamConverter\ParamConverterInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class ReservationParamConverter implements ParamConverterInterface
{
    /**
     * @var ScreeningRepository
     */
    private $screeningRepository;
    /**
     * @var SeatRepository
     */
    private $seatRepository;
    /**
     * @var ValidatorInterface
     */
    private $validator;
    /**
     * @var string
     */
    private $validationErrorsArgument;

    /**
     * @param ScreeningRepository $screeningRepository
     * @param SeatRepository $seatRepository
     * @param ValidatorInterface $validator
     * @param string $validationErrorsArgument
     */
    public function __construct(
        ScreeningRepository $screeningRepository,
        SeatRepository $seatRepository,
        ValidatorInterface $validator,
        string $validationErrorsArgument = 'validationErrors'
    )
    {
        $this->screeningRepository = $screeningRepository;
        $this->seatRepository = $seatRepository;
        $this->validator = $validator;
        $this->validationErrorsArgument = $validationErrorsArgument;
    }

    public function apply(Request $request, ParamConverter $configuration)
    {
        $screening = $this->screeningRepository->find($request->request->get('screening_id'));
        if(!$screening) throw new NotFoundHttpException('Screening not found.');

        $reservation = new Reservation();
        $reservation
            ->setName($request->request->get('name'))
            ->setSurname($request->request->get('surname'))
            ->setEmail($request->request->get('email'))
            ->setScreening($screening);

        foreach ($request->request->get('seats') as $seatId)
        {
            $seat = $this->seatRepository->find($seatId);
            if(!$seat) throw new NotFoundHttpException('Seat not found.');
            $reservation->addSeat($seat);
        }

        $errors = $this->validator->validate($reservation);

        $request->attributes->set($configuration->getName(), $reservation);
        $request->attributes->set($this->validationErrorsArgument, $errors);

        return true;
    }

    public function supports(ParamConverter $configuration)
    {
        return null !== $configuration->getClass() && 'reservation_param_converter' === $configuration->getConverter();
    }
}