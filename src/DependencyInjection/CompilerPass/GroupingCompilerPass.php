<?php
declare(strict_types=1);

namespace App\DependencyInjection\CompilerPass;

use App\Transformer\RepresentationTransformerRepository;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

class GroupingCompilerPass implements CompilerPassInterface
{
    private string $repositoryServiceId;
    private string $repositoryMethod;
    private string $servicesTag;

    public function __construct(string $repositoryServiceId, string $repositoryMethod, string $servicesTag)
    {
        $this->repositoryServiceId = $repositoryServiceId;
        $this->repositoryMethod    = $repositoryMethod;
        $this->servicesTag         = $servicesTag;
    }

    public function process(ContainerBuilder $container)
    {
        if (false === $container->hasDefinition($this->repositoryServiceId)) {
            // @todo exception when no service preent
        }

        $definition = $container->getDefinition($this->repositoryServiceId);

        foreach ($container->findTaggedServiceIds($this->servicesTag) as $id => $tags) {
            $definition->addMethodCall($this->repositoryMethod, [new Reference($id)]);
        }
    }

}
