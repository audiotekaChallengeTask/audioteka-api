<?php

namespace App;

use App\DependencyInjection\Compiler\QueryExtensionPass;
use App\DependencyInjection\CompilerPass\ApiControllerCompilerPass;
use App\DependencyInjection\CompilerPass\GroupingCompilerPass;
use App\DependencyInjection\CompilerPass\RepresentationTransformerCompilerPass;
use App\Manager\ManagerRepository;
use App\Provider\ProviderRepository;
use App\Transformer\RepresentationTransformer;
use App\Transformer\RepresentationTransformerRepository;
use Symfony\Bundle\FrameworkBundle\Kernel\MicroKernelTrait;
use Symfony\Component\DependencyInjection\Compiler\PassConfig;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symfony\Component\HttpKernel\Kernel as BaseKernel;
use Symfony\Component\Routing\Loader\Configurator\RoutingConfigurator;

class Kernel extends BaseKernel
{
    use MicroKernelTrait;

    protected function configureContainer(ContainerConfigurator $container): void
    {
        $container->import('../config/{packages}/*.yaml');
        $container->import('../config/{packages}/' . $this->environment . '/*.yaml');

        if (is_file(\dirname(__DIR__) . '/config/services.yaml')) {
            $container->import('../config/{services}.yaml');
            $container->import('../config/{services}_' . $this->environment . '.yaml');
        } elseif (is_file($path = \dirname(__DIR__) . '/config/services.php')) {
            (require $path)($container->withPath($path), $this);
        }
    }

    protected function configureRoutes(RoutingConfigurator $routes): void
    {
        $routes->import('../config/{routes}/' . $this->environment . '/*.yaml');
        $routes->import('../config/{routes}/*.yaml');

        if (is_file(\dirname(__DIR__) . '/config/routes.yaml')) {
            $routes->import('../config/{routes}.yaml');
        } elseif (is_file($path = \dirname(__DIR__) . '/config/routes.php')) {
            (require $path)($routes->withPath($path), $this);
        }
    }

    protected function prepareContainer(ContainerBuilder $container)
    {
        $container->addCompilerPass(new ApiControllerCompilerPass());
        $container->addCompilerPass(new GroupingCompilerPass(RepresentationTransformerRepository::class, 'registerTransformer', 'api.transformer'));
        parent::prepareContainer($container);
    }
}
