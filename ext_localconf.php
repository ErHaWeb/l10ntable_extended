<?php

declare(strict_types=1);

use ErHaWeb\L10ntableExtended\Xclass\UriBuilder as UriBuilderXclass;
use TYPO3\CMS\Backend\Routing\UriBuilder;
use TYPO3\CMS\Core\Information\Typo3Version;
use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;
use TYPO3\CMS\Core\Utility\GeneralUtility;

defined('TYPO3') || die();

/**
 * Adding XCLASS for UriBuilder
 */
$GLOBALS['TYPO3_CONF_VARS']['SYS']['Objects'][UriBuilder::class] = [
    'className' => UriBuilderXclass::class,
];

if (GeneralUtility::makeInstance(Typo3Version::class)->getMajorVersion() < 13) {
    /**
     * Adding the default User TSconfig
     */
    ExtensionManagementUtility::addUserTSConfig('@import "EXT:l10ntable_extended/Configuration/user.tsconfig"');
}
