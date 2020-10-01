<?php
declare(strict_types=1);

namespace App\Form;

use App\Exception\ValidationException;
use App\Model\ModelInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;

class ApiFormHandler
{
    private ApiFormErrorMapper $errorMapper;

    public function __construct(ApiFormErrorMapper $errorMapper)
    {
        $this->errorMapper = $errorMapper;
    }

    public function handle(FormInterface $form, Request $request): ModelInterface
    {
        if (false === $form->isSubmitted()) {
            $form->submit($request->request->all());
        }

        if (false === $form->isValid()) {
            throw ValidationException::createForValidationErrors($this->errorMapper->map($form));
        }

        return $form->getData();
    }
}
