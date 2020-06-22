<?php


namespace App\Controller;


use App\Form\Type\EventFilterType;
use App\Service\EventService;
use App\Service\SessionService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
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
     * @param SessionService $sessionService
     * @param EventService $eventService
     * @return Response
     */
    public function index(Request $request, SessionService $sessionService, EventService $eventService)
    {
        $eventFilter = $sessionService->getOrCreateEventFilterSession();

        $eventFilterForm = $this->createForm(EventFilterType::class, $eventFilter)->handleRequest($request);

        if ($eventFilterForm->isSubmitted() && $eventFilterForm->isValid()) {
            $events = $eventService->getFilteredEvents($eventFilter, $request->query->getInt('page', $this->getParameter('app.paginator.first.page')), $this->getParameter('app.paginator.elt-by-page'));
        } else {
            $events = $eventService->getFilteredEvents($eventService->getDefaultEventFilter(), $request->query->getInt('page', $this->getParameter('app.paginator.first.page')), $this->getParameter('app.paginator.elt-by-page'));
        }
        $sessionService->saveEventFilterToSession($eventFilter);

        return $this->render('homepage/home.html.twig', [
            'current_page' => 'homepage',
            'events' => $events,
            'filterForm' => $eventFilterForm->createView(),
        ]);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function autoCompleteArtist(Request $request)
    {
        $results = array();
        return new JsonResponse($results);
    }
}