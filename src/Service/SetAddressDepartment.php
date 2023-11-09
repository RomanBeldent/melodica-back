<?php

namespace App\Service;

use App\Entity\Address;

class SetAddressDepartment
{
    //
    public function setDepartmentFromZipcode($entity)
    {

        if ($entity instanceof Address) {
            // on récupère les 2 premiers chiffres du zipcode pour le mettre dans département
            $zipcodeIntoDepartment = $entity->getZipcode();
            $department = substr($zipcodeIntoDepartment, 0, -3);
            $entity->setDepartment($department);
        } else {
            $zipcodeIntoDepartment = $entity->getAddress()->getZipcode();
            $department = substr($zipcodeIntoDepartment, 0, -3);
            $entity->getAddress()->setDepartment($department);
        }
    }
}
