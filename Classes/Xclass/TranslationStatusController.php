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
        $return = parent::renderL10nTable($tree, $request);

        $replaceColumnsList = $this->getBackendUser()->getTSConfig()['tx_l10ntableextended.']['replaceColumnsList'] ?? false;

        if ($replaceColumnsList) {
            $searchColumnsList = $this->getBackendUser()->getTSConfig()['tx_l10ntableextended.']['searchColumnsList'] ?? false;
            $columnsUrlParameter = urlencode($this->getBackendUser()->getTSConfig()['tx_l10ntableextended.']['columnsUrlParameter'] ?? false);

            // Trim explode lists to remove any spaces and do further checks
            $replaceColumns = GeneralUtility::trimExplode(',', $replaceColumnsList);
            $searchColumns = GeneralUtility::trimExplode(',', $searchColumnsList);

            // Remove columns that are not available
            $existingColumns = array_keys($GLOBALS['TCA']['pages']['columns']);
            foreach ($replaceColumns as $key => $replaceColumn) {
                if (!in_array($replaceColumn, $existingColumns, true)) {
                    unset($replaceColumns[$key]);
                }
            }

            $search = implode(',', $searchColumns);
            $replace = implode(',', $replaceColumns);

            // Older TYPO3 versions need to do url encoding
            if (GeneralUtility::makeInstance(Typo3Version::class)?->getMajorVersion() < 12) {
                $search = urlencode($search);
                $replace = urlencode($replace);
            }

            $search = $columnsUrlParameter . '=' . $search;
            $replace = $columnsUrlParameter . '=' . $replace;

            // If the old field list was found as a search string, it can be replaced by the new list
            $return = str_replace($search, $replace, $return);
        }

        return $return;
    }
}
