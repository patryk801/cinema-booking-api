<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\Exception\BadCredentialsException;

/**
 * @Security("is_anonymous() or is_authenticated()")
 */
class UsersController extends AbstractController
{
    private $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    /**
     * @Route("user/token")
     * @Method("POST")
     */
    public function tokenAction(Request $request)
    {
        $user = $this->getDoctrine()->getRepository('AppBundle:User')->findOneBy(['username' => $request->getUser()]);
        if(!$user) throw new BadCredentialsException();

        $isPasswordValid = $this->passwordEncoder->isPasswordValid($user, $request->getPassword());
        if(!$isPasswordValid) throw new BadCredentialsException();

        return new JsonResponse(['token' => $user->getApiKey()]);
    }
}