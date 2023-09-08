<?php

/**
 * This file is part of the "l10ntable_extended" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

namespace ErHaWeb\L10ntableExtended\Xclass;

use Psr\Http\Message\ServerRequestInterface;
use TYPO3\CMS\Backend\Tree\View\PageTreeView;
use TYPO3\CMS\Core\Information\Typo3Version;
use TYPO3\CMS\Core\Utility\GeneralUtility;

class TranslationStatusController extends \TYPO3\CMS\Info\Controller\TranslationStatusController
{
    /**
     * @param PageTreeView $tree
     * @param ServerRequestInterface $request
     * @return string
     */
    protected function renderL10nTable(PageTreeView $tree, ServerRequestInterface $request): string
    {
        // Get the string return of the original function
        $return = parent::renderL10nTable($tree, $request);

        // Get the configuration from user TSconfig
        $userTsConfig = $this->getBackendUser()->getTSConfig()['tx_l10ntableextended.'];

        // Get the list of columns to be replaced from the user settings (if available)
        $replaceColumnsList = $this->getBackendUser()->uc['tx_l10ntableextended_replaceColumnsList'];

        // If no user settings are set get the value from the user TSconfig configuration
        if(!$replaceColumnsList) {
            $replaceColumnsList = $userTsConfig['replaceColumnsList'] ?? false;
        }

        // If the list to be replaced with is not empty and does not contain the default value of the core
        if ($replaceColumnsList && $replaceColumnsList !== 'title,nav_title,hidden') {
            // Get values for the list to be replaced
            $searchColumnsList = $userTsConfig['searchColumnsList'] ?? false;

            // Get the required url parameter
            $columnsUrlParameter = urlencode($userTsConfig['columnsUrlParameter'] ?? false);

            // Trim explode search and replace lists to remove any spaces and do further checks
            $replaceColumns = GeneralUtility::trimExplode(',', $replaceColumnsList);
            $searchColumns = GeneralUtility::trimExplode(',', $searchColumnsList);

            // Remove columns that are not available
            $existingColumns = array_keys($GLOBALS['TCA']['pages']['columns']);
            foreach ($replaceColumns as $key => $replaceColumn) {
                if (!in_array($replaceColumn, $existingColumns, true)) {
                    unset($replaceColumns[$key]);
                }
            }

            // Convert arrays back to well-formed comma-separated lists
            $search = implode(',', $searchColumns);
            $replace = implode(',', $replaceColumns);

            // Older TYPO3 versions need to do url encoding
            if (GeneralUtility::makeInstance(Typo3Version::class)->getMajorVersion() < 12) {
                $search = urlencode($search);
                $replace = urlencode($replace);
            }

            // Form the full search and replacement string from URL parameter and field list
            $search = $columnsUrlParameter . '=' . $search;
            $replace = $columnsUrlParameter . '=' . $replace;

            // If the old field list was found as a search string, it can be replaced by the new list
            $return = str_replace($search, $replace, $return);
        }

        return $return;
    }
}
