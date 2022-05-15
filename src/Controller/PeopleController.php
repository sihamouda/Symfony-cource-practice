<?php

namespace App\Controller;

use App\Form\LoginType;
use Doctrine\Persistence\ManagerRegistry;
use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/people')]
class PeopleController extends AbstractController
{
    #[Route('/', name: 'home')]
    public function home(SessionInterface $session): Response
    {
        return $this->render('people/home.html.twig');
    }

    #[Route('/login', name: 'login')]
    public function login(ManagerRegistry $doctrine , Request $request,SessionInterface $session): Response
    {
        $user= new User();
        $repo=$doctrine->getRepository(User::class);
        $form=$this->createForm(LoginType::class,$user);
        $form->handleRequest($request);

        if($form->isSubmitted()){
            if($repo->findBy(['username'=>$user->getUsername(),'password'=>$user->getPassword()])){
                $session->set('user',$user->getUsername());
                return $this->redirectToRoute('home');
            }
            else{
                $this->addFlash('failed','oups');
            }
        }
        return $this->render('people/login.html.twig', [
            'form'=>$form->createView()
        ]);
    }

    #[Route('/signin', name: 'signin')]
    public function signin(ManagerRegistry $doctrine, Request $request,SessionInterface $session): Response
    {
        $user= new User();

        $manager = $doctrine->getManager();
        $repo=$doctrine->getRepository(User::class);
        $form=$this->createForm(LoginType::class,$user);
        $form->handleRequest($request);

        if($form->isSubmitted()){
            if(!$repo->findBy(['username'=>$user->getUsername()])){
                $manager->persist($user);
                $manager->flush();

                $this->addFlash('success','mabrouk');
            }
            else{
                $this->addFlash('failed','oups');
            }
        }



        return $this->render('people/signin.html.twig',[
            'form'=>$form->createView(),
        ]);
    }
}
