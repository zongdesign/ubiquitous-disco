<?php

namespace App\Controller;

use App\Exception\EntityNotFoundException;
use App\Services\ClassroomService;
use App\Services\RequestService;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Request\ParamFetcherInterface;
use FOS\RestBundle\View\View;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\Response;


/**
 * @Rest\Route("/api/newclassroom", name="api_new_classroom_")
 */
class NewClassroomController extends AbstractFOSRestController
{
    /**
     * @var ClassroomService
     */
    private $classroomService;
    /**
     * @var RequestService
     */
    private $requestService;

    /**
     * NewClassroomController constructor.
     *
     * @param ClassroomService $classroomService
     * @param RequestService $requestService
     */
    public function __construct(ClassroomService $classroomService, RequestService $requestService)
    {
        $this->classroomService = $classroomService;
        $this->requestService = $requestService;
    }

    /**
     * @Rest\Get("/list", name="list")
     * @Rest\View(serializerGroups={"classroom"})
     *
     * @return View
     */
    public function cgetAction(): View
    {
        return $this->view($this->classroomService->findAll(), 200);
    }

    /**
     * @Rest\Get("/{id}", name="show", requirements={"id":"\d+"})
     * @Rest\View(serializerGroups={"classroom"})
     *
     * @param int $id
     *
     * @return View
     */
    public function getAction(int $id): View
    {
        $data = $this->classroomService->findById($id);

        if (null === $data) {
            return $this->view(
                $this->classroomService->getNotFoundErrorMessage($id),
                Response::HTTP_NOT_FOUND
            );
        }

        return $this->view($data, Response::HTTP_OK);
    }

    /**
     * @Rest\Post("/create", name="create")
     *
     * @param ParamFetcherInterface $paramFetcher
     *
     * @throws UniqueConstraintViolationException
     *
     * @return View
     *
     * @Rest\RequestParam(name="name", nullable=false, allowBlank=false,
     *     description="Name of classroom.")
     * @Rest\RequestParam(name="active", default="0", allowBlank=false, nullable=false,
     *     description="Active status of classroom.",
     *     requirements=@Assert\Choice(choices={"1","0"}, message="The value is not valid.", strict=true)
     * )
     */
    public function postAction(ParamFetcherInterface $paramFetcher): View
    {
        $requestDto = $this->requestService->createRequestDto($paramFetcher);
        $classroomDto = $this->classroomService->createDto($requestDto);

        try {
            $classroom = $this->classroomService->create($classroomDto);
        } catch (UniqueConstraintViolationException $e) {
            $errorMessage = ['errorMessage' => 'Bad request. Duplicate name of the classroom.'];

            return $this->view(
                $errorMessage,
                $statusCode = Response::HTTP_BAD_REQUEST
            );
        }

        return $this->view(
            $classroom,
            $statusCode = Response::HTTP_CREATED
        );
    }

    /**
     * @Rest\Put("/edit/{id}", name="edit", requirements={"id":"\d+"})
     *
     * @Rest\RequestParam(name="name", nullable=false, allowBlank=false,
     *     description="Name of classroom.")
     * @Rest\RequestParam(name="active", allowBlank=false, nullable=false,
     *     description="Active status of classroom.",
     *     requirements=@Assert\Choice(choices={"1","0"}, message="The value is not valid.", strict=true)
     * )
     *
     * @param int $id
     * @param ParamFetcherInterface $paramFetcher
     *
     * @return View
     */
    public function updateAction(int $id, ParamFetcherInterface $paramFetcher): View
    {
        $classroom = $this->classroomService->findById($id);

        if (null === $classroom) {

            return $this->view(
                $this->classroomService->getNotFoundErrorMessage($id),
                Response::HTTP_NOT_FOUND
            );
        }

        $requestDto = $this->requestService->createRequestDto($paramFetcher);
        $classroomDto = $this->classroomService->createDto($requestDto);

        return $this->view(
            $this->classroomService->edit($classroom, $classroomDto),
            Response::HTTP_CREATED
        );
    }

    /**
     * @Rest\Patch("/toggle-status/{id}", name="toggle_status", requirements={"id":"\d+"})
     *
     * @param int $id
     *
     * @return View
     */
    public function toggleStatusAction(int $id): View
    {
        $classroom = $this->classroomService->findById($id);

        if (null === $classroom) {

            return $this->view(
                $this->classroomService->getNotFoundErrorMessage($id),
                Response::HTTP_NOT_FOUND
            );
        }

        return $this->view(
            $this->classroomService->toggleStatus($classroom),
            Response::HTTP_CREATED
        );
    }
}