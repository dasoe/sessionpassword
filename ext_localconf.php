<?php

defined('TYPO3_MODE') or die();

/*
 * Configure the Plugin to call the right combination of Controller and Action according to
 * the user input (default settings, FlexForm, URL etc.)
 */
\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
    'B13.Sessionpassword',
    'Password',
    ['Password' => 'unlock'],
    ['Password' => 'unlock']
);

// hook to see if the content object is allowed to render anything at all,
// based on the data inside the cObj
$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['tslib/class.tslib_content.php']['cObjTypeAndClass']['sessionpassword'] = [
    'sessionpassword',    // key for the array
    \B13\Sessionpassword\Service\ContentObjectService::class,    // class to instantiate
];

// hook in to add additional usergroups by registering the base authentication service
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addService(
    'sessionpassword',
    'auth',
    'tx_sessionpassword_fegroups',
    [
        'title' => 'Session password groups',
        'description' => 'Adds frontend usergroups by checking the session data for stored passwords by tx_sessionpassword.',
        'subtype' => 'getGroupsFE',
        'available' => true,
        'priority' => 20,
        'quality' => 20,
        'className' => \B13\Sessionpassword\Service\FrontendUsergroupService::class,
    ]
);
