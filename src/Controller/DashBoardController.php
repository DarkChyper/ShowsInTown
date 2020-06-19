<?php


namespace App\Controller;


use App\Entity\Event;
use App\Form\Type\EventType;
use App\Service\EventService;
use App\Service\MessageFlashService;
use App\Service\SessionService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class DashBoardController
 * @package App\Controller
 */
class DashBoardController extends AbstractController
{

    /**
     * @param Request $request
     * @param EventService $eventService
     * @param SessionService $sessionService
     * @return Response
     */
    public function dashboard(Request $request, EventService $eventService, SessionService $sessionService){

        $event = $sessionService->getOrCreateEventSession();

        $eventForm = $this->createForm(EventType::class, $event, ["data"=>$event])->handleRequest($request);
        $sessionService->saveEventToSession($event);

        if($eventForm->isSubmitted() && $eventForm->isValid()){
            $eventService->save($event);
            $sessionService->deleteEventFromSession();
            return new RedirectResponse($this->generateUrl('dashboard'));
        }

        $events = $eventService->getAllEventByPage($request->query->getInt('page',$this->getParameter('paginator.first.page')), $this->getParameter('paginator.elt.by.page'));

        return $this->render('dashboard/dashboard.html.twig', [
            'current_page' => 'dashboard',
            'eventForm' => $eventForm->createView(),
            'currentEvent' => $event,
            'events' => $events
        ]);
    }

    /**
     * @param int $id
     * @param EventService $eventService
     * @return RedirectResponse
     */
    public function removeEvent(int $id, EventService $eventService){
        $eventService->delete($id);

        return new RedirectResponse($this->generateUrl('dashboard'));

    }

    /**
     * @param int $id
     * @param EventService $eventService
     * @param SessionService $sessionService
     * @return RedirectResponse
     */
    public function editEvent(int $id, EventService $eventService, SessionService $sessionService){
        $event = $eventService->getEvent($id);
        $event->prepareToEdit();
        $sessionService->saveEventToSession($event);
        return new RedirectResponse($this->generateUrl('dashboard'));
    }

    /**
     * @param SessionService $sessionService
     * @return RedirectResponse
     */
    public function deleteSessionEvent(SessionService $sessionService){
        $sessionService->deleteEventFromSession();
        return new RedirectResponse($this->generateUrl('dashboard'));
    }

}