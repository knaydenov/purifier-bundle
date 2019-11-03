<?php
namespace Kna\PurifierBundle\Purifier;


interface PurifierInterface
{
    /**
     * @return PurifierConfigProvider[]
     */
    public function getConfigProviders(): array;

    /**
     * @param PurifierConfigProviderInterface $provider
     */
    public function registerProvider(PurifierConfigProviderInterface $provider);

    /**
     * @param string $configName
     * @return PurifierConfigProvider
     */
    public function getConfigProvider($configName): PurifierConfigProviderInterface;

    /**
     * @param $html
     * @param $configName
     * @param int $revision
     * @return string
     */
    public function purify($html, $configName, $revision = 0): string ;
}