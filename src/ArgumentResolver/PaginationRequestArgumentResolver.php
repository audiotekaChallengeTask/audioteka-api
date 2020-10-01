<?php
declare(strict_types=1);

namespace App\ArgumentResolver;

use App\Model\PaginationRequest;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Controller\ArgumentValueResolverInterface;
use Symfony\Component\HttpKernel\ControllerMetadata\ArgumentMetadata;

class PaginationRequestArgumentResolver implements ArgumentValueResolverInterface
{
    const DEFAULT_PAGE  = 1;
    const DEFAULT_LIMIT = 3;

    public function supports(Request $request, ArgumentMetadata $argument)
    {
        return $argument->getType() === PaginationRequest::class;
    }

    public function resolve(Request $request, ArgumentMetadata $argument)
    {
        $page  = $request->query->getInt('page', self::DEFAULT_PAGE);
        $limit = $request->query->getInt('limit', self::DEFAULT_LIMIT);

        if ($page < 1) {
            $page = self::DEFAULT_PAGE;
        }

        if ($limit < 1 || $limit > self::DEFAULT_LIMIT) {
            $limit = self::DEFAULT_LIMIT;
        }

        yield new PaginationRequest($page, $limit);
    }
}
