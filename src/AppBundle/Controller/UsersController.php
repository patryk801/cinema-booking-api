<?php

namespace AppBundle\Controller;

use AppBundle\Entity\EntityMerger;
use AppBundle\Entity\User;
use AppBundle\Exception\ValidationException;
use Lexik\Bundle\JWTAuthenticationBundle\Encoder\JWTEncoderInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\Validator\ConstraintViolationListInterface;

/**
 * @Security("is_anonymous() or is_authenticated()")
 */
class UsersController extends AbstractController
{
    private $passwordEncoder;
    private $jwtEncoder;
    private $entityMerger;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder, JWTEncoderInterface $jwtEncoder, EntityMerger $entityMerger)
    {
        $this->passwordEncoder = $passwordEncoder;
        $this->jwtEncoder = $jwtEncoder;
        $this->entityMerger = $entityMerger;
    }

    /**
     * @Security("is_granted('show', theUser)", message="Access denied")
     */
    public function getUserAction(?User $theUser)
    {
        if(is_null($theUser)) throw new NotFoundHttpException();
        return $theUser;
    }

    /**
     * @Rest\View(statusCode=201)
     * @Rest\NoRoute()
     * @ParamConverter("user", converter="fos_rest.request_body", options={"deserializationContext" = {"groups"={"Deserialize"}}})
     */
    public function postUserAction(User $user, ConstraintViolationListInterface $validationErrors)
    {
        if(count($validationErrors) > 0) throw new ValidationException($validationErrors);

        $this->encodePassword($user);
        $user->setRoles([User::ROlE_USER]);
        $this->persistUser($user);

        return $user;
    }

    /**
     * @Rest\NoRoute()
     * @ParamConverter("modifiedUser", converter="fos_rest.request_body", options={
     *     "validator"={"groups"={"Patch"}},
     *     "deserializationContext" = {"groups"={"Deserialize"}}
     *     })
     * @Security("is_granted('edit', theUser)", message="Access denied")
     */
    public function patchUserAction(?User $theUser, User $modifiedUser, ConstraintViolationListInterface $validationErrors)
    {
        if(is_null($theUser)) throw new NotFoundHttpException();
        if(count($validationErrors) > 0) throw new ValidationException($validationErrors);

        if(empty($modifiedUser->getPassword())) $modifiedUser->setPassword(null);

        $this->entityMerger->merge($theUser, $modifiedUser);
        $this->encodePassword($theUser);
        $this->persistUser($theUser);

        return $theUser;
    }

    protected function encodePassword(User $user): void
    {
        $user->setPassword($this->passwordEncoder->encodePassword($user, $user->getPassword()));
    }

    protected function persistUser(User $user): void
    {
        $em = $this->getDoctrine()->getManager();
        $em->persist($user);
        $em->flush();
    }
}