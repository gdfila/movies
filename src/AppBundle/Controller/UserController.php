<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

use AppBundle\Entity\User;
use AppBundle\Form\RegistrationType;

class UserController extends Controller
{
    /**
     * @Route("/register", name="register")
     */
    public function registerAction(Request $request)
    {
        //on creer un utilisateur vide(une instance de notre entité User)
        $user = new User();
        
        // ce form est associer a l'utilisateur vide
        $registrationForm = $this->createForm(new RegistrationType(), $user);
        
        //traiter le formulaire
        $registrationForm->handleRequest($request);
        
        
        //si les données sont valide
        if ($registrationForm->isvalid()){
            //hydrate les autres donnée de notre User 
            
                //hacher le MP
               
                //generer le salt
                $salt= md5(uniqid());
                $user->setSalt($salt);
                
                //generer un token
                $token= md5(uniqid());
                $user->setToken($token);
                
                //dates d'inscrription et de modif
                
            //sauvegarder le user en DBB
            dump($user);
        }
        // on shoot le formulaire a twig (on oublie pas la createview
        $params = array(
            "registrationForm" => $registrationForm ->createView()
        );
        return $this->render('user/register.html.twig', $params);
    }
}
