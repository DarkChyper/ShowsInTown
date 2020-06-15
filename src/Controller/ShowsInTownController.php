<?php


namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class ShowsInTownController
 * @package App\Controller
 */
class ShowsInTownController extends AbstractController
{

    /**
     * @return Response
     */
    public function index(){
        return $this->render('homepage/home.html.twig', [
            'current_page' => 'homepage',
        ]);
    }

    /**
     * @return Response
     */
    public function dashboard(){
        return $this->render('dashboard/dashboard.html.twig', [
            'current_page' => 'dashboard',
        ]);
    }
}