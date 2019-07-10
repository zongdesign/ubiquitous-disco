<?php

namespace App\Services;

use App\Dto\ClassroomDto;
use App\Dto\RequestDto;
use App\Entity\Classroom;
use App\Repository\ClassroomRepository;
use Doctrine\ORM\EntityManagerInterface;

/**
 * Class ClassroomService.
 */
final class ClassroomService
{
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;
    /**
     * @var ClassroomRepository
     */
    private $classroomRepository;

    /**
     * CompanyService constructor.
     *
     * @param EntityManagerInterface $entityManager
     * @param ClassroomRepository $classroomRepository
     */
    public function __construct(EntityManagerInterface $entityManager, ClassroomRepository $classroomRepository)
    {
        $this->entityManager = $entityManager;
        $this->classroomRepository = $classroomRepository;
    }

    /**
     * @return Classroom[]
     */
    public function findAll(): array
    {
        return $this->classroomRepository->findAll();
    }

    /**
     * @param int $id
     *
     * @return Classroom|null
     */
    public function findById(int $id): ?Classroom
    {
        return $this->classroomRepository->find($id);
    }

    /**
     * @param RequestDto $requestDto
     *
     * @return ClassroomDto
     */
    public function createDto(RequestDto $requestDto): ClassroomDto
    {
        return new ClassroomDto($requestDto->getName(), $requestDto->isActive());
    }

    /**
     * @param ClassroomDto $classroomDto
     *
     * @return Classroom
     */
    public function create(ClassroomDto $classroomDto): Classroom
    {
        $classroom = (new Classroom())
            ->setName($classroomDto->getName())
            ->setActive($classroomDto->isActive());

        $this->entityManager->persist($classroom);
        $this->entityManager->flush();

        return $classroom;
    }

    /**
     * @param Classroom $classroom
     * @param ClassroomDto $classroomDto
     *
     * @return Classroom
     */
    public function edit(Classroom $classroom, ClassroomDto $classroomDto): Classroom
    {
        $classroom
            ->setName($classroomDto->getName())
            ->setActive($classroomDto->isActive());

        $this->entityManager->persist($classroom);
        $this->entityManager->flush();

        return $classroom;
    }

    /**
     * @param Classroom $classroom
     *
     * @return Classroom
     */
    public function toggleStatus(Classroom $classroom): Classroom
    {
        $classroom->setActive(!$classroom->isActive());
        $this->entityManager->persist($classroom);
        $this->entityManager->flush();

        return $classroom;
    }

    /**
     * @param int $id
     *
     * @return array
     */
    public function getNotFoundErrorMessage(int $id): array
    {
        return [
            'errorMessage' => sprintf('Classroom with id=%d not found', $id),
        ];
    }
}
