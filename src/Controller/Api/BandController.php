<?php

namespace App\Controller\Api;

use App\Entity\Band;
use DateTimeImmutable;
use App\Repository\BandRepository;
use App\Service\SetAddressDepartment;
use App\Repository\OrganizerRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/api/band", name="api_band_")
 */
class BandController extends AbstractController
{
    /**
     * @Route("/", name="list", methods={"GET"})
     */
    public function list(BandRepository $bandRepository): JsonResponse
    {
        return $this->json([
            'bands' => $bandRepository->findAll()], 200, [], ['groups' => 'band_list'
        ]);
    }


    /**
     * @Route("/{id<\d+>}", name="show", methods={"GET"})
     */
    public function show(Band $band): JsonResponse
    {
        return $this->json([
            'band' => $band], 200, [], ['groups' => 'band_show']);
    }

    /**
     * @Route("/random", name="random", methods={"GET"})
     */
    public function random(BandRepository $bandRepository): JsonResponse
    {
        // récupération de tous les bands existant via fonction findAll
        $bands = $bandRepository->findAll();
        // si on ne récupère aucun band alors on envoie un message comme quoi il n'y a pas de band dans la Bdd
        if (count($bands) === 0) {
            $errorMessage = [
                'message' => "No bands in database",
            ];
        // on retourne la réponse en json
            return new JsonResponse($errorMessage, Response::HTTP_NOT_FOUND);
        }

        // on mélange les groupes
        shuffle($bands);
        // on boucle sur le tableau randomBands qui contient les bands stockés dans $bands
        $randomBands = [];
        for ($randomBandToAdd = 1; $randomBandToAdd <= 30; $randomBandToAdd++) {
            $randomBands[] = $bands[$randomBandToAdd];
        }
        // on retourne les données générées en json pour pouvoir l'envoyer au front
        return $this->json([
            'randomBands' => $randomBands], 200, [], ['groups' => 'band_random']);
    }

    /**
     * @Route("/randomAll", name="randomAll", methods={"GET"})
     */
    public function randomAll(BandRepository $bandRepository, OrganizerRepository $organizerRepository): JsonResponse
    {
        // un tableau de groupes + on limite l'envoie de données
        $bands = $bandRepository->findAll();
        shuffle($bands);
        // on veut pouvoir n'afficher que les 12 premiers résultats
        $bandsSlice = array_slice($bands,0,12,true);
        // un tableau d'organisateur + on limite l'envoie de données
        $organizers = $organizerRepository->findAll();
        shuffle($organizers);
        $organizersSlice = array_slice($organizers,0,12,true);
        // on envoie nos données en json pour le front
         return $this->json([
            'organizers' => $organizersSlice,
            'bands' => $bandsSlice], 200, [], ['groups' => 'random_all']);
    }

    /**
     * @Route("/", name="create", methods={"POST"})
     */
    public function create(Request $request, EntityManagerInterface $entityManager, SerializerInterface $serializer, ValidatorInterface $validator, SetAddressDepartment $setAddressDepartment, BandRepository $bandRepository): JsonResponse
    {
        $json = $request->getContent();
        $band = $serializer->deserialize($json, Band::class, 'json');

        $setAddressDepartment->setDepartmentFromZipcode($band);
        // si l'email existe déjà on veut envoyé un message d'erreur
        // en effet l'email doit être unique donc on va chercher parmis les utilisateurs si l'email existe déjà en BDD
        //todo service find email exists
        $emailExist = $bandRepository->findOneBy(['email' => $band->getEmail()]);

        // si il existe, on envoi une erreur avec une 409, conflict
        if ($emailExist) {
            $errorEmail = [
                'message' => 'Cet email existe déjà !'
            ];
            return new JsonResponse($errorEmail, Response::HTTP_CONFLICT);
        }
        $errorList = $validator->validate($band);
        if (count($errorList) > 0) {
            return $this->json($errorList, Response::HTTP_BAD_REQUEST);
        }

        $entityManager->persist($band);
        $entityManager->flush();
        return $this->json($band, Response::HTTP_CREATED, [], ["groups" => 'band_create']);
    }

    /**
     * @Route("/{id<\d+>}", name="update", methods={"PATCH"})
     */
    public function update($id, EntityManagerInterface $em, SerializerInterface $serializer, ValidatorInterface $validator, Request $request): JsonResponse
    {
        $band = $em->find(Band::class, $id);

        $band->setUpdatedAt(new DateTimeImmutable());

        if ($band === null) {
            $errorMessage = [
                'message' => "Band not found",
            ];
            return new JsonResponse($errorMessage, Response::HTTP_NOT_FOUND);
        }

        $json = $request->getContent();
        
        $serializer->deserialize($json, Band::class, 'json', [AbstractNormalizer::OBJECT_TO_POPULATE => $band]);

        $errorList = $validator->validate($band);
        if (count($errorList) > 0) {
            return $this->json($errorList, Response::HTTP_BAD_REQUEST);
        }

        $em->flush();
        return $this->json($band, Response::HTTP_OK, [], ['groups' => 'band_update']);
    }


    /**
     * @Route("/{id<\d+>}"), name="delete", methods={"DELETE"})
     */
    public function delete($id, EntityManagerInterface $em, BandRepository $bandRepository)
    {
        $band = $em->find(Band::class, $id);
        if ($band === null) {
            $errorMessage = [
                'message' => "Band not found",
            ];
            return new JsonResponse($errorMessage, Response::HTTP_NOT_FOUND);
        }
        $bandRepository->remove($band, true);
        return $this->json($band, Response::HTTP_OK);
    }
}
