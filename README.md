# L10ntable Extended
Experimental TYPO3 Extension by Eric Harrer

## Description

With the assistance of this extension, the **Localization Overview** within the **Info** module gains an enhanced `Edit all language overlay records` button, featuring individually customizable fields.

This empowers users to conveniently perform batch edits on configurable page fields on page translations. By default, only the `title`, `nav_title` and `hidden` fields are available for batch processing in the translation view. This can now be extended to any (existing) page fields.

## Installation

Install the extension via Composer using

```
composer req erhaweb/l10ntable-extended
```

## How to use

After the installation the following can be defined in the `User TSconfig`:
```
tx_l10ntableextended {
  replaceColumnsList := addToList(seo_title,description)
}
```
In this example, the two fields `seo_title` and `description` would be added to the standard field list `title,nav_title,hidden`.

Of course, it is also possible to omit all or some of the fields that are used by default and use only your own fields. In this case overwrite the default list via a simple `=` statement.
```
tx_l10ntableextended {
  columns = seo_title,description
}
```
Fields that are not available in the context of a page type (for example, the `seo_title` field for pages of type `Folder [254]`) are simply not displayed in the context of batch editing.

Fields that do not exist in `$GLOBALS['TCA']['pages']['columns']` are **not considered at all**.

## Attention

Please do not expect too much from this extension. It is based on a simple string replacement in the final output of the function `TranslationStatusController::renderL10nTable`.

The disadvantage is that the functionality of this extension is broken if something of the output of the method changes in the future. After all, the output at the required position remained identical in both TYPO3 v11 and v12.

The advantage with this approach is that despite the use of XCLASS no problems with the core behavior can arise.

## Tipp

If the default fields used by the TYPO3 core for batch editing in future versions have indeed changed and this extension no longer works, try updating the following default `User TSconfig` setting to match the new field list:
```
tx_l10ntableextended {
  searchColumnsList = title,nav_title,hidden
}
```
