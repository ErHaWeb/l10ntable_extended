# Extended Localization Table

TYPO3 Extension by Eric Harrer

## Description

With the assistance of this extension, the **Localization Overview** within the **Info** module gains an
enhanced `Edit all language overlay records` button, featuring individually customizable fields.

![Edit all language overlay records button](Documentation/Images/LocalizationOverview.png)

This empowers users to conveniently perform batch edits on configurable page fields on page translations. By default,
only the `title`, `nav_title` and `hidden` fields are available for batch processing in the translation view. This can
now be extended to any (existing) page fields.

![Batch edit pages example with configured fields](Documentation/Images/NewFieldsExample.png)

## Installation

Install the extension via Composer using

```
composer req erhaweb/l10ntable-extended
```

## How to use

### Global configuration via user TSconfig

After the installation the following can be defined in the `User TSconfig` to define as administrator for backend user
groups or single backend users which columns they can edit:

```
tx_l10ntableextended {
  replaceColumnsList := addToList(seo_title,description)
}
```

![User TSconfig](Documentation/Images/UserTsConfig.png)

In this example, the two fields `seo_title` and `description` would be added to the default fields `title`, `nav_title` and `hidden`.

Of course, it is also possible to omit all or some of the fields that are used by default and use only your own fields.
In this case overwrite the default list via a simple `=` statement.

```
tx_l10ntableextended {
  replaceColumnsList = seo_title,description
}
```

Fields that are not available in the context of a page type (for example, the `seo_title` field for pages of
type `Folder [254]`) are simply not displayed in the context of batch editing.

Fields that do not exist in `$GLOBALS['TCA']['pages']['columns']` are **not considered at all**.

### Override global configuration in your sitepackage

Please note that your sitepackage must be loaded after the `EXT:l10ntable_extended` so that the default user TSconfig
can be overwritten at file level.

This can be achieved by adding the following configuration in file `ext_emconf.php` of your sitepackage extension:

```php
$EM_CONF[$_EXTKEY]['constraints']['depends']['l10ntable_extended'] = '';
```

### Extension Configuration

Under Admin Tools > Settings > Extension Configuration you can determine whether non-admin backend users can also
determine the list of editable fields within their User Settings. Set the option for this:

```
enableUserSettings = 1
```

![Extension Configuration](Documentation/Images/ExtensionConfiguration.png)

### Configuration via the backend user settings

If the User Settings have been activated in the Extension Configuration, all backend users (also non-admin users) can
determine the page fields that should be editable via a multiple selection field.

![Backend User Settings](Documentation/Images/BackendUserSettings.png)

## Tipp

The name of the `columnsOnly` parameter, that is evaluated by the `EditDocumentController`, can be customized using
the following setting.

```
tx_l10ntableextended {
  columnsUrlParameter = columnsOnly
}
```

However, this should only be necessary if the core decides to use a different parameter to specify the columns to be edited.
