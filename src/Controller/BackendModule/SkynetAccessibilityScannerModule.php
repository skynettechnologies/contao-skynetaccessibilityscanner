<?php

namespace Skynettechnologies\ContaoSkynetaccessibilityScanner\Controller\BackendModule;

use Contao\BackendModule;

class SkynetAccessibilityScannerModule extends BackendModule
{
    protected $strTemplate = 'be_skynet_accessibility';

    protected function compile(): void
    {
       
        $this->Template->title = 'SkynetAccessibility Scanner';

    }
}