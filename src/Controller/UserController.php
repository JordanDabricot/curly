<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\Mapping\Annotation;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;

class UserController extends Controller
{
    /**
     * @Route("/register", name="register")
     * @Method({"POST"})
     */
    public function userRegister(Request $request)
    {
        $encoders = array(new JsonEncoder());
        $normalizers = array(new ObjectNormalizer());
        $serializer = new Serializer($normalizers, $encoders);
        if($request->request->has("submit")){
            if($request->request->get('email')
                && $request->request->get('snapchat')
                && $request->request->get('instagram')
                && $request->request->get('email')
                && $request->request->get('password1')
                && $request->request->get('password2')
                && $request->request->get('password1') == $request->request->get('password2')
            ){
                $this->getDoctrine()->getManager()->getRepository('App:User')->insertUser($request->request->all());
                return $this->json([
                    "auth" => "true",
                    "token" => "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpZCI6IjU5ZGQxY2IxNWU2YWU3YTMzMTFmYjljYyIsImlhdCI6MTUwNzY2MzAyNSwiZXhwIjoxNTA3NzQ5NDI1fQ.PC6EqYTBqcJHG2m2rR29HZG_TImnIepLAfGzVRjfJIg"
                ]);
            }
        }
        return $this->render('register.html.twig');
    }
}
