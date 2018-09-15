<?php

namespace AppBundle\Controller;

use FOS\RestBundle\Controller\FOSRestController;
use Lexik\Bundle\JWTAuthenticationBundle\Encoder\JWTEncoderInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\Security\Core\Exception\BadCredentialsException;

class TokensController extends FOSRestController
{
    private $passwordEncoder;
    private $encoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder, JWTEncoderInterface $encoder)
    {
        $this->passwordEncoder = $passwordEncoder;
        $this->encoder = $encoder;
    }

    /**
     * @Rest\View(statusCode=201)
     */
    public function postTokenAction(Request $request)
    {
        $user = $this->getDoctrine()->getRepository('AppBundle:User')->findOneBy(['username' => $request->getUser()]);
        if(!$user) throw new BadCredentialsException();

        $isPasswordValid = $this->passwordEncoder->isPasswordValid($user, $request->getPassword());
        if(!$isPasswordValid) throw new BadCredentialsException();

        $token = $this->encoder->encode(
            [
                'username' => $user->getUsername(),
                'exp' => time() + 3600,
            ]
        );

        return new JsonResponse(['token' => $token]);
    }
}