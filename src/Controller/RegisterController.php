<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Form\RegisterFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\String\Slugger\SluggerInterface; 
use Symfony\Contracts\Translation\TranslatorInterface;

class RegisterController extends AbstractController
{
    #[Route('/register', name: 'app_register')]
    public function index(Request $request, UserPasswordHasherInterface $userPasswordHasher, SluggerInterface $slugger, EntityManagerInterface $entityManager): Response
    {
        $user = new User();
        $form = $this->createForm(RegisterFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid() && ($form->get('plainPassword')->getData() === $form->get('plainPasswordBis')->getData())) {
            $user->setNom(strtoupper($form->get('nom')->getData()));
            $user->setPrenom(ucwords($form->get('prenom')->getData()));
            $user->setEmail($form->get('email')->getData());

            $avatarFichier = $form->get('image')->getData(); // On récupère les données qui composent l’image
            $newFilename = "default.png";
            if ($avatarFichier) { // Si une image a bien été insérée (vu qu’elle n’est pas required, elle peut être vide)
                $originalFilename = pathinfo($avatarFichier->getClientOriginalName(), PATHINFO_FILENAME); // On prend le nom de base du fichier
                // this is needed to safely include the file name as part of the URL
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename.'-'.uniqid().'.'.$avatarFichier->guessExtension();

                // Tente de déplacer le fichier vers le répertoire définit plus tôt
                try {
                    $avatarFichier->move(
                        $this->getParameter('avatar_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    // Gérer le cas en cas d’exception levée (droits insuffisants, stockage insuffisant, ...)
                }
            }
            $user->setImage($newFilename);



            // encode the plain password
            $user->setPassword(
                $userPasswordHasher->hashPassword(
                    $user,
                    $form->get('plainPassword')->getData()
                )
            );

            $entityManager->persist($user);
            $entityManager->flush();
            // do anything else you need here, like send an email

            return $this->redirectToRoute('app_home');
        }

        return $this->render('register/index.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }
}
