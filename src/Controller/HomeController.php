<?php


namespace App\Controller;


use App\Entity\EventFilter;
use App\Form\Type\EventFilterType;
use App\Service\CityService;
use App\Service\EventService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class HomeController
 * @package App\Controller
 */
class HomeController extends AbstractController
{

    /**
     * @param Request $request
     * @param CityService $cityService
     * @param EventService $eventService
     * @return Response
     */
    public function index(Request $request, CityService $cityService, EventService $eventService)
    {

        $eventFilter = new EventFilter();
        $events = array();

        $eventFilterForm = $this->createForm(EventFilterType::class, $eventFilter)->handleRequest($request);

        if ($eventFilterForm->isSubmitted() && $eventFilterForm->isValid()) {
            $events = $eventService->getFilteredEvents($eventFilter);
        } else {
            $events = $eventService->getFilteredEvents($eventService->getDefaultEventFilter());
        }


        return $this->render('homepage/home.html.twig', [
            'current_page' => 'homepage',
            'events' => $events,
            'filterForm' => $eventFilterForm->createView(),
        ]);
    }
}