<?php
/**
 * @package     Joomla.Site
 * @subpackage  mod_login
 *
 * @copyright   Copyright (C) 2005 - 2013 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

JHtml::_('behavior.keepalive');
?>
<form action="<?php echo JRoute::_('index.php', true, $params->get('usesecure')); ?>" method="post" id="login-form" class="form-logout form-vertical">
<?php if ($params->get('greeting')) : ?>
	<div class="login-greeting text-center">
		<img
			width="100"
			src="<?php echo JHtml::_('projectfork.avatar.path', $user->id);?>"
			class="img-circle"
			/> 
			<p>
	<?php if ($params->get('name') == 0) : {
		echo $user->get('name');
	} else : {
		echo $user->get('username');
	} endif; ?>
			</p>
	</div>
<?php endif; ?>
	<div class="logout-button">
		<input type="submit" name="Submit" class="btn btn-inverse btn-block" value="<?php echo JText::_('JLOGOUT'); ?>" />
		<input type="hidden" name="option" value="com_users" />
		<input type="hidden" name="task" value="user.logout" />
		<input type="hidden" name="return" value="<?php echo $return; ?>" />
		<?php echo JHtml::_('form.token'); ?>
	</div>
</form>
