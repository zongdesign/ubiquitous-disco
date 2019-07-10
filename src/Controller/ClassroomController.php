<?php

namespace App\Controller;

use App\Entity\Classroom;
use App\Repository\ClassroomRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * API controller for Classroom entity.
 */
class ClassroomController extends AbstractController
{

    /**
     * @Route("classrooms", methods={"GET"})
     *
     * @param ClassroomRepository $repository
     *
     * @return JsonResponse
     */
    public function listAction(ClassroomRepository $repository): JsonResponse
    {
        $classrooms = $repository->findAll();
        $data = ['classrooms' => []];

        foreach ($classrooms as $classroom) {
            $data['classrooms'][] = $this->serializeProgrammer($classroom);
        }

        $response = new JsonResponse($data, 200);
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }

    /**
     * @param Classroom $classroom
     *
     * @return array
     */
    private function serializeProgrammer(Classroom $classroom): array
    {
        return [
            'id' => $classroom->getId(),
            'name' => $classroom->getName(),
            'active' => $classroom->isActive(),
            'createdAt' => $classroom->getCreatedAt(),
            'updatedAt' => $classroom->getUpdatedAt(),
        ];
    }
}
