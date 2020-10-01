<?php
declare(strict_types=1);

namespace App\Form;

use Symfony\Component\Form\FormInterface;

class ApiFormErrorMapper
{
    public function map(FormInterface $form): array
    {
        return $this->getErrorMessages($form);
    }

    private function getErrorMessages(FormInterface $form): array
    {
        $errors = [];

        foreach ($form->getErrors() as $key => $error) {
            if ($form->isRoot()) {
                $errors['#'][] = $error->getMessage();
            } else {
                $errors[] = $error->getMessage();
            }
        }

        foreach ($form->all() as $child) {
            if (!$child->isValid()) {
                $errors[$child->getName()] = $this->getErrorMessages($child);
            }
        }

        return $errors;
    }
}
