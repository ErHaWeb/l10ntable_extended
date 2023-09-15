<?php

/**
 * This file is part of the "l10ntable_extended" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

namespace ErHaWeb\L10ntableExtended\UserFunctions;

use TYPO3\CMS\Core\Authentication\BackendUserAuthentication;
use TYPO3\CMS\Core\Localization\LanguageService;
use TYPO3\CMS\Core\Utility\GeneralUtility;

class ItemsProcFunc
{
    public function renderItems(): string
    {
        $selectedColumns = GeneralUtility::trimExplode(',', $this->getBackendUser()->uc['tx_l10ntableextended_replaceColumnsList'] ?? '');
        $lang = $this->getLanguageService();
        $html = '<select id="tx_l10ntableextended_replaceColumns" size="20" class="form-control" multiple>';
        $html .= '<option value="">-</option>';
        $existingColumns = array_keys($GLOBALS['TCA']['pages']['columns']);
        foreach ($existingColumns as $existingColumn) {
            $html .= '<option value="' . $existingColumn . '"' . ((in_array($existingColumn, $selectedColumns, true)) ? 'selected' : '') . '>';
            $label = $GLOBALS['TCA']['pages']['columns'][$existingColumn]['label'] ?? '';
            if (str_starts_with($label, 'LLL:')) {
                $label = $lang->sL($label);
            }
            $html .= $label . ' [' . $existingColumn . ']';
            $html .= '</option>';
        }
        $html .= '</select>';

        $html .= '<input type="hidden" name="data[tx_l10ntableextended_replaceColumnsList]" id="tx_l10ntableextended_replaceColumnsList">';

        $html .= '<script>';
        $html .= '(function() {';
        $html .= 'const replaceColumns = document.getElementById("tx_l10ntableextended_replaceColumns");';
        $html .= 'const replaceColumnsList = document.getElementById("tx_l10ntableextended_replaceColumnsList");';
        $html .= 'function updateHiddenInput() {';
        $html .= 'const selectedOptions = Array.from(replaceColumns.selectedOptions).map(option => option.value);';
        $html .= 'replaceColumnsList.value = selectedOptions.join(",");';
        $html .= '}';
        $html .= 'replaceColumns.addEventListener("change", updateHiddenInput);';
        $html .= 'updateHiddenInput();';
        $html .= '})();';
        $html .= '</script>';

        return $html;
    }

    /**
     * @return BackendUserAuthentication
     */
    protected function getBackendUser(): BackendUserAuthentication
    {
        return $GLOBALS['BE_USER'];
    }

    /**
     * @return LanguageService
     */
    protected function getLanguageService(): LanguageService
    {
        return $GLOBALS['LANG'];
    }
}
