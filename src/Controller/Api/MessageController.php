<?php

namespace App\Controller\Api;

use App\Entity\Message;
use App\Repository\MessageRepository;
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
 * @Route("/api/message", name="api_message_")
 */
class MessageController extends AbstractController
{
    /**
     * @Route("/", name="list", methods={"GET"})
     */
    public function list(MessageRepository $messageRepository): JsonResponse
    {
        return $this->json([
            'messages' => $messageRepository->findAll()], 200, [], ['groups' => 'message_list'
        ]);
    }

    /**
     * @Route("/{id<\d+>}", name="show", methods={"GET"})
     */
    public function show(Message $message): JsonResponse
    {
        return $this->json([
            'message' => $message], 200, [], ['groups' => 'message_show']);
    }

    /**
     * @Route("/", name="create", methods={"POST"})
     */
    public function create(Request $request, EntityManagerInterface $entityManager, SerializerInterface $serializer, ValidatorInterface $validator): JsonResponse
    {
        $json = $request->getContent();
        $message = $serializer->deserialize($json, Message::class, 'json');
        $errorList = $validator->validate($message);
        if (count($errorList) > 0) {
            return $this->json($errorList, Response::HTTP_BAD_REQUEST);
        }
        $entityManager->persist($message);
        $entityManager->flush();
        return $this->json($message, Response::HTTP_CREATED, [], ["groups" => 'message_create']);
    }
    /**
     * @Route("/{id<\d+>}", name="update", methods={"PATCH"})
     */
    public function update($id, EntityManagerInterface $em, SerializerInterface $serializer, ValidatorInterface $validator, Request $request): JsonResponse
    {
        $message = $em->find(Message::class, $id);
        if ($message === null) {
            $errorMessage = [
                'message' => "Message not found",
            ];
            return new JsonResponse($errorMessage, Response::HTTP_NOT_FOUND);
        }
        $json = $request->getContent();
        $serializer->deserialize($json, Message::class, 'json', [AbstractNormalizer::OBJECT_TO_POPULATE => $message]);
        $errorList = $validator->validate($message);
        if (count($errorList) > 0) {
            return $this->json($errorList, Response::HTTP_BAD_REQUEST);
        }
        $em->flush();
        return $this->json($message, Response::HTTP_OK, [], ['groups' => 'message_update']);
    }
    /**
     * @Route("/{id<\d+>}"), name="delete", methods={"DELETE"})
     */
    public function delete($id, EntityManagerInterface $em, MessageRepository $messageRepository)
    {
        $message = $em->find(Message::class, $id);
        if ($message === null) {
            $errorMessage = [
                'message' => "Message not found",
            ];
            return new JsonResponse($errorMessage, Response::HTTP_NOT_FOUND);
        }
        $messageRepository->remove($message, true);
        return $this->json($message, Response::HTTP_OK);
    }
}
