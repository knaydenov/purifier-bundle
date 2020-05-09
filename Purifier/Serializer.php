<?php
namespace Kna\PurifierBundle\Purifier;


use HTMLPurifier_Config;

class Serializer extends \HTMLPurifier_DefinitionCache_Serializer
{
    /**
     * Generates a unique identifier for a particular configuration
     * @param HTMLPurifier_Config $config Instance of HTMLPurifier_Config
     * @return string
     */
    public function generateKey($config): string
    {
        switch ($this->type) {
            case 'HTML':
                return $config->version . ',' . $config->get($this->type . '.DefinitionID') . ',' . $config->get($this->type . '.DefinitionRev');
            case 'CSS':
                return $config->version . ',' . $config->get($this->type . '.DefinitionRev');
            default:
                throw new \LogicException('This code should not be reached!');
        }
    }
}