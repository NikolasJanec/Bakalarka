<?php

namespace InterfaceBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{

    public function indexAction(Request $request)
    {
        $users = null;
        $sections = $this->getUser()->getSections();
        $result = [];
        $userRole = $this->getDoctrine()->getRepository("CoreBundle:Role")->findOneBy([
            'code' => "ROLE_USER"
        ]);

        $userRole = $userRole->getId();



        if ($request->getMethod() == Request::METHOD_POST)
        {
            $filter = [
                'firstName' => $request->request->get('firstName'),
                'lastName' => $request->request->get('lastName'),
                'query' => $request->request->get('query')
            ];
                $i = 0;


                while (!empty($sections[$i])){
                    $data = $this->getDoctrine()->getRepository("CoreBundle:User")->findAllByFilter($filter, $sections[$i]->getId(), $userRole);
                    if($i == 0){
                        $result = $data;
                    }else{
                        $a = 0;
                        $b = 0;
                        $c = true;
                        while(!empty($data[$a])){
                            while(!empty($result[$b])){
                                if($data[$a]->getId() == $result[$b]->getId()){
                                    $c = false;
                                    break;
                                }
                                $b++;
                            }
                            if($c == true){
                                array_push($result, $data[$a]);
                            }
                            $c = true;
                            $b = 0;
                            $a++;
                        }
                    }
                    $i ++;
                }


        }
        else
        {

            $i = 0;
            $filter = null;
            $data = null;

            while(!empty($sections[$i])){
                $data = $this->getDoctrine()->getRepository("CoreBundle:User")->findAllByFilter($filter, $sections[$i]->getId(), $userRole);
                if($i == 0){
                    $result = $data;
                }else{
                    $a = 0;
                    $b = 0;
                    $c = true;
                    while(!empty($data[$a])){
                        while(!empty($result[$b])){
                            if($data[$a]->getId() == $result[$b]->getId()){
                                $c = false;
                                break;
                            }
                            $b++;
                        }
                        if($c == true){
                            array_push($result, $data[$a]);
                        }
                        $c = true;
                        $b = 0;
                        $a++;
                    }
                }
                $i ++;
            }


        }

        return $this->render('InterfaceBundle:Default:index.html.twig', [
            'users' => $result
        ]);
    }

    public function viewAction($id)
    {
        $user = $this->getDoctrine()->getRepository("CoreBundle:User")->find($id);

        return $this->render('InterfaceBundle:Default:user.html.twig', [
            'user' => $user
        ]);
    }


    public function loginAction(Request $request)
    {
        $authenticationUtils = $this->get('security.authentication_utils');

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();

        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('InterfaceBundle:security:login.html.twig', array(
            'last_username' => $lastUsername,
            'error'         => $error,
        ));
    }
}
