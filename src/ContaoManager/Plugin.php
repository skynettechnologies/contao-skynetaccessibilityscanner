<?php
namespace Skynettechnologies\ContaoSkynetaccessibilityScanner\ContaoManager;

use Contao\ManagerPlugin\Bundle\BundlePluginInterface;
use Contao\ManagerPlugin\Bundle\Config\BundleConfig;
use Contao\ManagerPlugin\Bundle\Parser\ParserInterface;
use Contao\CoreBundle\ContaoCoreBundle;
use Skynettechnologies\ContaoSkynetaccessibilityScanner\ContaoSkynetaccessibilityScannerBundle;

class Plugin implements BundlePluginInterface
{
    public function getBundles(ParserInterface $parser): array
    {
        return [
            BundleConfig::create(ContaoSkynetaccessibilityScannerBundle::class)
                ->setLoadAfter([ContaoCoreBundle::class]),
        ];
    }
}
