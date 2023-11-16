<?php

namespace App\Service;

use App\Entity\Address;

class SetAddressDepartment
{
    //
    public function setDepartmentFromZipcode($entity)
    {
            // si l'entité est une adresse on va chercher directement le zipcode
        if ($entity instanceof Address) {
            // on récupère le zipcode
            $zipcodeIntoDepartment = $entity->getZipcode();
            // on récupère les 2 premiers chiffres du zipcode pour le mettre dans département
            $department = substr($zipcodeIntoDepartment, 0, -3);
            // on insère ces 2 chiffres dans department (ils serviront pour le filtre avec la carte intéractive)
            $entity->setDepartment($department);
            // sinon il faut récupérer l'adresse de l'entité puis son zipcode
        } else {
            $zipcodeIntoDepartment = $entity->getAddress()->getZipcode();
            $department = substr($zipcodeIntoDepartment, 0, -3);
            $entity->getAddress()->setDepartment($department);
        }
    }
}
