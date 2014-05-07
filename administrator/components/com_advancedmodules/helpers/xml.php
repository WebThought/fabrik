<?php
/**
 * @package         Advanced Module Manager
 * @version         4.13.2
 *
 * @author          Peter van Westen <peter@nonumber.nl>
 * @link            http://www.nonumber.nl
 * @copyright       Copyright © 2014 NoNumber All Rights Reserved
 * @license         http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 */

/**
 * @copyright   Copyright (C) 2005 - 2014 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

JLog::add('ModulesHelperXML is deprecated. Do not use.', JLog::WARNING, 'deprecated');

/**
 * Helper for parse XML module files
 *
 * @package     Joomla.Administrator
 * @subpackage  com_modules
 * @since       1.5
 * @deprecated  3.2  Do not use.
 */
class ModulesHelperXML
{
	/**
	 * @since       1.5
	 * @deprecated  3.2  Do not use.
	 */
	public function parseXMLModuleFile(&$rows)
	{
		foreach ($rows as $i => $row)
		{
			if ($row->module == '')
			{
				$rows[$i]->name    = 'custom';
				$rows[$i]->module  = 'custom';
				$rows[$i]->descrip = 'Custom created module, using Module Manager New function';
			}
			else
			{
				$data = JInstaller::parseXMLInstallFile($row->path . '/' . $row->file);

				if ($data['type'] == 'module')
				{
					$rows[$i]->name    = $data['name'];
					$rows[$i]->descrip = $data['description'];
				}
			}
		}
	}
}
