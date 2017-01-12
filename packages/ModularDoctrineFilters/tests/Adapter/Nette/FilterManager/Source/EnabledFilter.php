<?php declare(strict_types=1);

namespace Symplify\DoctrineFilters\Tests\FilterManager\Source;

use Doctrine\ORM\Mapping\ClassMetadata;
use Symplify\DoctrineFilters\Contract\ConditionalFilterInterface;

final class EnabledFilter implements ConditionalFilterInterface
{
    public function addFilterConstraint(ClassMetadata $targetEntity, string $targetTableAlias) : string
    {
        return '';
    }

    public function isEnabled() : bool
    {
        return true;
    }
}
