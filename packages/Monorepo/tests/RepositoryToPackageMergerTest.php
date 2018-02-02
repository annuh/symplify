<?php declare(strict_types=1);

namespace Symplify\Monorepo\Tests;

use GitWrapper\GitWrapper;
use Nette\Utils\FileSystem;
use Symplify\Monorepo\RepositoryToPackageMerger;

final class RepositoryToPackageMergerTest extends AbstractContainerAwareTestCase
{
    /**
     * @var string
     */
    private const TEMP_MONOREPO_DIRECTORY = __DIR__ . '/RepositoryToPackageMergerSource/TempRepository';

    /**
     * @var GitWrapper
     */
    private $gitWrapper;

    /**
     * @var RepositoryToPackageMerger
     */
    private $repositoryToPackageMerger;

    protected function setUp(): void
    {
        $this->gitWrapper = $this->container->get(GitWrapper::class);
        $this->repositoryToPackageMerger = $this->container->get(RepositoryToPackageMerger::class);
    }

    protected function tearDown(): void
    {
        FileSystem::delete(self::TEMP_MONOREPO_DIRECTORY);
    }

    public function testMergeTwoPackages(): void
    {
        $this->gitWrapper->init(self::TEMP_MONOREPO_DIRECTORY);

        $this->repositoryToPackageMerger->mergeRepositoryToPackage(
            'https://github.com/Symplify/Monorepo.git',
            self::TEMP_MONOREPO_DIRECTORY,
            'packages/Monorepo'
        );

        $this->assertDirectoryNotExists(self::TEMP_MONOREPO_DIRECTORY . '/src');
        $this->assertDirectoryExists(self::TEMP_MONOREPO_DIRECTORY . '/packages/Monorepo/src');
    }

    /**
     * Covers https://github.com/Symplify/Symplify/issues/617
     */
    public function testRemote(): void
    {
        $this->gitWrapper->init(self::TEMP_MONOREPO_DIRECTORY);

        $this->repositoryToPackageMerger->mergeRepositoryToPackage(
            'https://github.com/shopsys/product-feed-zbozi-copy.git',
            self::TEMP_MONOREPO_DIRECTORY,
            'packages/product-feed-zbozi-copy'
        );

        $this->assertDirectoryNotExists(self::TEMP_MONOREPO_DIRECTORY . '/src');
        $this->assertDirectoryExists(self::TEMP_MONOREPO_DIRECTORY . '/packages/product-feed-zbozi-copy/src');

        $this->repositoryToPackageMerger->mergeRepositoryToPackage(
            'https://github.com/shopsys/product-feed-google-copy.git',
            self::TEMP_MONOREPO_DIRECTORY,
            'packages/product-feed-google-copy'
        );

        $this->assertDirectoryNotExists(self::TEMP_MONOREPO_DIRECTORY . '/src');
        $this->assertDirectoryExists(self::TEMP_MONOREPO_DIRECTORY . '/packages/product-feed-google-copy/src');
    }
}
