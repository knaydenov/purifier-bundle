<?php
namespace Kna\PurifierBundle\Purifier;


use HTMLPurifier_Config;

interface PurifierConfigProviderInterface
{
    public function configure(): void;

    /**
     * @return string
     */
    public function getName(): string ;

    /**
     * @return string
     */
    public function getRevision(): string ;
    /**
     * @return string
     */
    public function getCacheDir(): string ;

    /**
     * @return HTMLPurifier_Config
     */
    public function getConfig(): HTMLPurifier_Config;
}