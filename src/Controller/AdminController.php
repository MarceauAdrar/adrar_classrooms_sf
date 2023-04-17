<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[IsGranted('ROLE_ADMIN')]
class AdminController extends AbstractController
{
    #[Route('/admin', name: 'app_admin')]
    public function index(): Response
    {
        $myChart = array(
            'type' => 'bar',
            'data' => array(
                'labels' => ['Red', 'Blue', 'Yellow', 'Green', 'Purple', 'Orange'],
                'datasets' => array(
                    array(
                        'label' => '# of Votes',
                        'data' => [12, 19, 3, 5, 2, 3],
                        'borderWidth' => 1
                    )
                )
            ),
            'options' => array(
                'scales' => array(
                    'y' => array(
                        'beginAtZero' => true
                    )
                )
            )
        );

        return $this->render('admin/index.html.twig', [
            'myChart' => $myChart,
        ]);
    }
}
