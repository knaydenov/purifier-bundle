<?php
namespace Kna\PurifierBundle\Purifier;


use HTMLPurifier_Config;

abstract class PurifierConfigProvider implements PurifierConfigProviderInterface
{
    /**
     * @var HTMLPurifier_Config
     */
    protected $config;

    /**
     * @var string
     */
    protected $cacheDir;

    public function __construct($cacheDir)
    {
        $this->cacheDir = $cacheDir;
        $this->config = $this->createConfig();
    }

    public function isConfigured(): bool
    {
        return $this->config->isFinalized();
    }

    protected function createConfig(): HTMLPurifier_Config {
        $config = HTMLPurifier_Config::createDefault();
        $config->set('HTML.DefinitionID', $this->getName());
        $config->set('HTML.DefinitionRev', $this->getRevision());
        $config->set('Cache.DefinitionImpl', 'KnaMediaSerializer');
        $config->set('Cache.SerializerPath', $this->getCacheDir());
        return $config;
    }

    /**
     * @return HTMLPurifier_Config
     */
    public function getConfig(): HTMLPurifier_Config
    {
        return $this->config;
    }

    /**
     * @return string
     */
    public function getCacheDir(): string
    {
        return $this->cacheDir;
    }

    /**
     * @return mixed
     */
    public function configure(): void
    {
    }

    /**
     * @return string
     */
    abstract public function getName(): string ;

    /**
     * @return string
     */
    abstract public function getRevision(): string ;
}