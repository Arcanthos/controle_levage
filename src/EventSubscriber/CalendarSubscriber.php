<?php

namespace App\EventSubscriber;

use App\Repository\ControlRepository;
use CalendarBundle\CalendarEvents;
use CalendarBundle\Entity\Event;
use CalendarBundle\Event\CalendarEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\ControllerEvent;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class CalendarSubscriber implements EventSubscriberInterface
{

    private $controlRepository;
    private $router;

    public function __construct(ControlRepository $controlRepository, UrlGeneratorInterface $router)
    {
        $this->controlRepository  = $controlRepository;
        $this->router = $router;
    }


    public static function getSubscribedEvents()
    {
        return [
            CalendarEvents::SET_DATA => 'onCalendarSetData',
        ];
    }

    public function onCalendarSetData(CalendarEvent $calendar)
    {
        $start = $calendar->getStart();
        $end = $calendar->getEnd();
        $filters = $calendar->getFilters();

        $controls = $this->controlRepository
            ->createQueryBuilder('control')
            ->where('control.beginAt BETWEEN :start and :end OR control.endAt BETWEEN :start and :end')
            ->setParameter('start', $start->format('Y-m-d H:i:s'))
            ->setParameter('end', $end->format('Y-m-d H:i:s'))
            ->getQuery()
            ->getResult();

        foreach ($controls as $control){
            $controlEvent = new Event(
                $control->getControlEquipment()->getBrand(),
                $control->getControlEquipment()->getClientCompany(),
                $control->getDate(),
                $control->getType()
            );

            $controlEvent->setOptions([
                'backgroundColor' => '#ffbb33',
                'borderColor' => '#ffbb33',
            ]);





        }







    }































}
