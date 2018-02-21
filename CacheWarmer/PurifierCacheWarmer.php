<?php
namespace Kna\PurifierBundle\CacheWarmer;


use Kna\PurifierBundle\Purifier\PurifierInterface;
use Symfony\Component\HttpKernel\CacheWarmer\CacheWarmerInterface;

class PurifierCacheWarmer implements  CacheWarmerInterface
{
    /**
     * @var string
     */
    protected $cacheDir;

    /**
     * @var PurifierInterface
     */
    protected $purifier;

    public function __construct(PurifierInterface $purifier, string $cacheDir)
    {
        $this->purifier = $purifier;
        $this->cacheDir = $cacheDir;
    }

    /**
     * @return bool
     */
    public function isOptional(): bool
    {
        return true;
    }

    /**
     * Warms up the cache.
     *
     * @param string $cacheDir The cache directory
     */
    public function warmUp($cacheDir): void
    {
        foreach ($this->purifier->getConfigProviders() as $name => $configProvider) {
            $this->purifier->purify('<p>Some html</p>', $configProvider->getName(), $configProvider->getRevision());
        }
    }
}