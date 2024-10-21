<?php

/*
 * This file is part of the TYPO3 CMS project.
 *
 * It is free software; you can redistribute it and/or modify it under
 * the terms of the GNU General Public License, either version 2
 * of the License, or any later version.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 * The TYPO3 project - inspiring people to share!
 */

namespace ErHaWeb\L10ntableExtended\Xclass;

use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\UriInterface;
use TYPO3\CMS\Backend\Module\ModuleData;
use TYPO3\CMS\Core\Authentication\BackendUserAuthentication;
use TYPO3\CMS\Core\Utility\GeneralUtility;

/**
 * Main UrlGenerator for creating URLs for the Backend. Generates a URL based on
 * an identifier defined by Configuration/Backend/Routes.php of an extension,
 * and adds some more parameters to the URL.
 *
 * Currently only available and useful when called from Router->generate() as the information
 * about possible routes needs to be handed over.
 */
class UriBuilder extends \TYPO3\CMS\Backend\Routing\UriBuilder
{
    public function buildUriFromRoute($name, $parameters = [], $referenceType = self::ABSOLUTE_PATH): UriInterface
    {
        if (
            $name === 'record_edit' &&
            ($parameters['edit']['pages'] ?? '')
        ) {
            // Get the configuration from user TSconfig
            $userTsConfig = $this->getBackendUser()->getTSConfig()['tx_l10ntableextended.'];
            $columnsUrlParameter = $userTsConfig['columnsUrlParameter'];

            if ($parameters[$columnsUrlParameter]['pages'] ?? '') {
                $request = $this->getRequest();

                /** @var ModuleData $modSettings */
                $modSettings = $request->getAttribute('moduleData');
                if ($modSettings instanceof ModuleData && $modSettings->getModuleIdentifier() === 'web_info_translations') {

                    // Get the list of columns to be replaced from the user settings (if available)
                    $replaceColumnsList = $this->getBackendUser()->uc['tx_l10ntableextended_replaceColumnsList'];

                    // If no user settings are set, get the value from the user TSconfig configuration
                    if (!$replaceColumnsList) {
                        $replaceColumnsList = $userTsConfig['replaceColumnsList'] ?? '';
                    }

                    if ($replaceColumnsList) {
                        // Keep column `l18n_cfg` if exists
                        $replaceColumns = GeneralUtility::trimExplode(',', $replaceColumnsList);
                        if (in_array('l18n_cfg', $parameters[$columnsUrlParameter]['pages'], true)) {
                            if (!in_array('l18n_cfg', $replaceColumns, true)) {
                                $replaceColumns[] = 'l18n_cfg';
                            }
                        } else {
                            $replaceColumns = array_diff($replaceColumns, ['l18n_cfg']);
                        }

                        // Remove columns that are not available
                        $existingColumns = array_keys($GLOBALS['TCA']['pages']['columns']);
                        foreach ($replaceColumns as $key => $replaceColumn) {
                            if (!in_array($replaceColumn, $existingColumns, true)) {
                                unset($replaceColumns[$key]);
                            }
                        }

                        // Singularize duplicate keys
                        $replaceColumns = array_unique($replaceColumns);

                        // Set new "columnsOnly" values
                        $parameters[$columnsUrlParameter]['pages'] = $replaceColumns;
                    }
                }
            }
        }
        return parent::buildUriFromRoute($name, $parameters, $referenceType);
    }

    private function getRequest(): ServerRequestInterface
    {
        return $GLOBALS['TYPO3_REQUEST'];
    }

    protected function getBackendUser(): BackendUserAuthentication
    {
        return $GLOBALS['BE_USER'];
    }
}
