<?php

namespace App\Controller;

use App\Entity\Student;
use App\Form\StudentType;
use App\Repository\StudentRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class StudentController extends AbstractController
{

    public $studentRepositotry;

    public function __construct(StudentRepository $studentRepository)
    {
        $this->studentRepositotry = $studentRepository;
    }

    /**
     * @Route("/accueil", name="accueil")
     */
    public function index(Request $request): Response
    {

        $info = new Student();

        $form = $this->createForm(StudentType::class, $info);

        $form->handleRequest($request);

        $manager = $this->getDoctrine()->getManager();

        if ($form->isSubmitted() && $form->isValid()) {
            $manager->persist($info);
            $manager->flush();

            return $this->redirectToRoute('display');
        }

        return $this->render('student/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/display", name="display")
     */
    public function affichage(): Response
    {
        $studentData = $this->studentRepositotry->findAll();

        return $this->render('display/index.html.twig', [
            'studentData' => $studentData
        ]);
    }

    /**
     * @Route("/modify/{id}", name="modify")
     */
    public function modify($id)
    {
        $studentData = $this->studentRepositotry->find($id);

        var_dump($studentData);
        die;
    }
}
