<?php
// all use statements must come first

use ErHaWeb\L10ntableExtended\UserFunctions\ItemsProcFunc;
use TYPO3\CMS\Core\Configuration\ExtensionConfiguration;
use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;
use TYPO3\CMS\Core\Utility\GeneralUtility;

defined('TYPO3') || die();

(static function () {
    $enableUserSettings = GeneralUtility::makeInstance(ExtensionConfiguration::class)
        ?->get('l10ntable_extended', 'enableUserSettings');

    if ($enableUserSettings) {
        // Extend user settings
        $GLOBALS['TYPO3_USER_SETTINGS']['columns']['tx_l10ntableextended_replaceColumnsList'] = [
            'label' => 'LLL:EXT:l10ntable_extended/Resources/Private/Language/locallang_be.xlf:usersettings.replaceColumnsList',
            'description' => 'HELLO WORLD',
            'type' => 'select',
            'itemsProcFunc' => ItemsProcFunc::class . '->renderItems',
        ];

        if (!isset($GLOBALS['TYPO3_USER_SETTINGS']['showitem'])) {
            $GLOBALS['TYPO3_USER_SETTINGS']['showitem'] = '';
        }
        ExtensionManagementUtility::addFieldsToUserSettings('--div--;LLL:EXT:l10ntable_extended/Resources/Private/Language/locallang_be.xlf:usersettings,tx_l10ntableextended_replaceColumnsList');
    }
})();
