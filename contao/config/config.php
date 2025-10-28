<?php

/**
 * skynetaccessibility_scanner extension for Contao Open Source CMS
 *
 * Cleaned-up version: Display SCanning & Monitoring report in the backend module
 *
 * @author Skynet Technologies USA LLC
 * @license LGPL
 */

/**
 * Backend module
 * This registers the menu in Contao backend and shows HTML content via a callback
 */

$GLOBALS['BE_MOD']['system']['skynetaccessibility_scanner'] = [
    'callback' => 'Skynettechnologies\ContaoSkynetaccessibilityScanner\Controller\BackendModule\SkynetAccessibilityScannerModule'
];
