<?php

declare(strict_types = 1);

namespace Ock\Egg\ClassToEgg;

use Ock\Egg\Egg\Egg_Construct;
use Ock\Egg\Egg\EggInterface;
use Ock\Egg\ParamToEgg\ParamToEggInterface;
use Symfony\Component\DependencyInjection\Attribute\AsAlias;

#[AsAlias]
class ClassToEgg_Construct implements ClassToEggInterface {

  /**
   * Constructor.
   *
   * @param \Ock\Egg\ParamToEgg\ParamToEggInterface $paramToCTV
   */
  public function __construct(
    private readonly ParamToEggInterface $paramToCTV,
  ) {}

  /**
   * {@inheritdoc}
   */
  public function classGetCTV(\ReflectionClass $reflectionClass): EggInterface {
    $argEggs = [];
    foreach ($reflectionClass->getConstructor()?->getParameters() ?? [] as $parameter) {
      $argEggs[] = $this->paramToCTV->paramGetCTV($parameter);
    }
    return new Egg_Construct(
      $reflectionClass->getName(),
      $argEggs,
    );
  }

}