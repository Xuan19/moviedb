<?php

namespace App\EventListener;

use App\Entity\User;
use Doctrine\Persistence\Event\LifecycleEventArgs;

class  UpdatedAtSetter{

    public function preUpdate(LifecycleEventArgs $args )
    {
        $entity=$args->getObject();

        if (!($entity instanceof User)){

            $entity->setUpdatedAt(new \DateTime());
        }



    }
}