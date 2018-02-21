<?php
namespace Kna\PurifierBundle\Purifier;


use HTMLPurifier;
use HTMLPurifier_DefinitionCacheFactory;
use Symfony\Component\Filesystem\Filesystem;

class Purifier implements PurifierInterface
{

    /**
     * @var PurifierConfigProvider[]
     */
    protected $configProviders = [];
    /**
     * @var HTMLPurifier
     */
    protected $purifier;

    public function __construct()
    {
        $this->purifier = new HTMLPurifier();
        if (!class_exists(Serializer::class, false)) {
            spl_autoload_call(Serializer::class);
        }
        $factory = HTMLPurifier_DefinitionCacheFactory::instance();
        $factory->register('KnaMediaSerializer', Serializer::class);
    }

    /**
     * @return PurifierConfigProvider[]
     */
    public function getConfigProviders(): array
    {
        return $this->configProviders;
    }

    /**
     * @param PurifierConfigProviderInterface $provider
     */
    public function registerProvider(PurifierConfigProviderInterface $provider)
    {
        $this->configProviders[$provider->getName().'.'.$provider->getRevision()] = $provider;
    }

    /**
     * @param string $configName
     * @return PurifierConfigProvider
     */
    public function getConfigProvider($configName): PurifierConfigProviderInterface
    {
        if (isset($this->configProviders[$configName])) {
            return $this->configProviders[$configName];
        }
        throw new \InvalidArgumentException('Purifier config provider "' . $configName .  '" does not match any of registered (' . implode(', ', array_keys($this->getConfigProviders())) . ')');
    }

    /**
     * @param $html
     * @param $configName
     * @param int $revision
     * @return string
     */
    public function purify($html, $configName, $revision = 0): string
    {
        $configProvider = $this->getConfigProvider($configName.'.'.$revision);

        $configProvider->getConfig()->autoFinalize = false;
        $factory = HTMLPurifier_DefinitionCacheFactory::instance();
        $cache = $factory->create('HTML', $configProvider->getConfig());
        $file = $cache->cache->generateFilePath($configProvider->getConfig());
        $configProvider->getConfig()->autoFinalize = true;
        if (!file_exists($file)) {
            $fs = new Filesystem();
            $fs->mkdir($configProvider->getCacheDir());
            $configProvider->configure();
        }
        return $this->purifier->purify($html, $configProvider->getConfig());
    }
}