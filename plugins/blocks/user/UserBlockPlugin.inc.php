<?php

/**
 * UserBlockPlugin.inc.php
 *
 * Copyright (c) 2000-2011 John Willinsky
 * Distributed under the GNU GPL v2. For full terms see the file docs/COPYING.
 *
 * @class UserBlockPlugin
 * @ingroup plugins
 *
 * @brief Class for user block plugin
 */

//$Id$

import('lib.pkp.classes.plugins.BlockPlugin');

class UserBlockPlugin extends BlockPlugin {
	function register($category, $path) {
		$success = parent::register($category, $path);
		if ($success) {
			AppLocale::requireComponents(array(LOCALE_COMPONENT_PKP_USER));
		}
		return $success;
	}

	/**
	 * Install default settings on system install.
	 * @return string
	 */
	function getInstallSitePluginSettingsFile() {
		return $this->getPluginPath() . '/settings.xml';
	}

	/**
	 * Install default settings on conference creation.
	 * @return string
	 */
	function getContextSpecificPluginSettingsFile() {
		return $this->getPluginPath() . '/settings.xml';
	}

	/**
	 * Get the display name of this plugin.
	 * @return String
	 */
	function getDisplayName() {
		return __('plugins.block.user.displayName');
	}

	/**
	 * Get a description of the plugin.
	 */
	function getDescription() {
		return __('plugins.block.user.description');
	}

	function getContents(&$templateMgr) {
		if (!defined('SESSION_DISABLE_INIT')) {
			$session =& Request::getSession();
			$templateMgr->assign_by_ref('userSession', $session);
			$templateMgr->assign('loggedInUsername', $session->getSessionVar('username'));
			$loginUrl = Request::url(null, null, 'login', 'signIn');
			if (Config::getVar('security', 'force_login_ssl')) {
				$loginUrl = String::regexp_replace('/^http:/', 'https:', $loginUrl);
			}
			$templateMgr->assign('userBlockLoginUrl', $loginUrl);
		}
		return parent::getContents($templateMgr);
	}
}

?>
