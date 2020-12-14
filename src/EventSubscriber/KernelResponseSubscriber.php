<?php

namespace App\EventSubscriber;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\ResponseEvent;

class KernelResponseSubscriber implements EventSubscriberInterface
{
    public function onKernelResponse(ResponseEvent $event)
    {
        //dd($event);

        //dd((new \DateTime($_ENV['MAINTENANCE_DATE']))->format('d M à H:i'));

        //dd((bool) $_ENV['MAINTENANCE_MESSAGES']);

        if(isset($_ENV['MAINTENANCE_MESSAGES']) && $_ENV['MAINTENANCE_MESSAGES']=='true'){
            $response=$event->getResponse();
            $content=$response->getContent();
            //dd($content);
            $date=new \DateTime ($_ENV['MAINTENANCE_DATE']);
            $content = str_replace('<body>','<body><div class ="alert alert-danger">Maintenance prévue '.$date->format('l d F à H\hi'). '</div>',$content);

            $response->setContent($content);
        }
    }

    public static function getSubscribedEvents()
    {
        return [
            'kernel.response' => ['onKernelResponse',-10]
        ];
    }
}
