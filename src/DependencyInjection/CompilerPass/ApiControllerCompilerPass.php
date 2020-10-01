<?php
declare(strict_types=1);

namespace App\DependencyInjection\CompilerPass;

use App\Controller\Api\AbstractApiAction;
use App\Form\ApiFormHandler;
use App\Manager\ManagerRepository;
use App\Provider\ProviderRepository;
use App\Transformer\RepresentationTransformer;
use JMS\Serializer\SerializerInterface;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

/**
 * Class ApiControllerCompilerPass
 * Package App\DependencyInjection\CompilerPass
 */
class ApiControllerCompilerPass implements CompilerPassInterface
{
    const TAG = 'controller.service_arguments';

    public function process(ContainerBuilder $container)
    {
        foreach ($container->findTaggedServiceIds(self::TAG) as $id => $tag) {
            $definition = $container->getDefinition($id);

            if (false === is_subclass_of($definition->getClass(), AbstractApiAction::class, true)) {
                continue;
            }

            $definition->addMethodCall('setTransformer', [new Reference(RepresentationTransformer::class)]);
            $definition->addMethodCall('setSerializer', [new Reference(SerializerInterface::class)]);
            $definition->addMethodCall('setFormFactory', [new Reference(FormFactoryInterface::class)]);
            $definition->addMethodCall('setFormHandler', [new Reference(ApiFormHandler::class)]);
            $definition->addMethodCall('setAuthorizationChecker', [new Reference(AuthorizationCheckerInterface::class)]);
        }
    }
}
