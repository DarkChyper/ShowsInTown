<?php


namespace App\Controller;


use App\Entity\Event;
use App\Form\Type\EventType;
use App\Service\EventService;
use App\Service\MessageFlashService;
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
     * @param MessageFlashService $messageFlashService
     * @return Response
     */
    public function dashboard(Request $request, EventService $eventService, MessageFlashService $messageFlashService){

        $event = new Event();
        $eventForm = $this->createForm(EventType::class, $event)->handleRequest($request);

        if($eventForm->isSubmitted() && $eventForm->isValid()){
            $eventService->save($event);
        }

        $events = $eventService->getAllEventByPage($request->query->getInt('page',$this->getParameter('paginator.first.page')), $this->getParameter('paginator.elt.by.page'));

        return $this->render('dashboard/dashboard.html.twig', [
            'current_page' => 'dashboard',
            'eventForm' => $eventForm->createView(),
            'events' => $events
        ]);
    }

    /**
     * @param int $id
     * @param EventService $eventService
     * @return RedirectResponse
     */
    public function remove(int $id, EventService $eventService){
        $eventService->delete($id);

        return new RedirectResponse($this->generateUrl('dashboard'));

    }
}