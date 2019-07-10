<?php

declare(strict_types=1);

namespace App\Services;

use App\Dto\RequestDto;
use FOS\RestBundle\Request\ParamFetcherInterface;

/**
 * Class RequestService.
 */
final class RequestService
{
    /**
     * @param ParamFetcherInterface $paramFetcher
     *
     * @return RequestDto
     */
    public function createRequestDto(ParamFetcherInterface $paramFetcher): RequestDto
    {
        return new RequestDto(
            $paramFetcher->get('name'),
            (bool)$paramFetcher->get('active')
        );
    }
}