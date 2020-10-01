<?php
declare(strict_types=1);

namespace App\Exception;

use App\Model\ModelInterface;

class TransformationException extends ApplicationException
{
    public static function createForUnknownModel(ModelInterface $model): TransformationException
    {
        return new TransformationException(sprintf('Model of class "%s" has no supporting transformer.', get_class($model)));
    }
}
