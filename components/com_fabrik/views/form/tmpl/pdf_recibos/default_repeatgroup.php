<?php
/**
 * Default Form Template: Repeat group rendered as an unordered list
 *
 * @package     Joomla
 * @subpackage  Fabrik
 * @copyright   Copyright (C) 2005 Fabrik. All rights reserved.
 * @license     http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.php
 * @since       3.0
 */

$group = $this->group;
foreach ($group->subgroups as $subgroup) :
	?>
	<div class="fabrikSubGroup">
		<div class="fabrikSubGroupElements">
			<?php

			// Load each group in a <ul>
			$this->elements = $subgroup;
			echo $this->loadTemplate('group');
			?>
		</div>
		<?php
		// Add the add/remove repeat group buttons
		if ($group->editable) : ?>
			<div class="fabrikGroupRepeater btn-group">
				<?php if ($group->canAddRepeat) :
				?>
				<a class="addGroup btn btn-link" href="#">
					<i class="glyphicon glyphicon-plus-sign fabrikTip" title="<?php echo JText::_('COM_FABRIK_ADD_GROUP'); ?>"></i>
					<?php //echo FabrikHelperHTML::image('add.png', 'form', $this->tmpl, array('class' => 'fabrikTip', 'title' => JText::_('COM_FABRIK_ADD_GROUP')));?>
				</a>
				<?php
				endif;
				if ($group->canDeleteRepeat) :
				?>
				<a class="deleteGroup btn btn-link" href="#">
					<i class="glyphicon glyphicon-minus-sign fabrikTip" title="<?php echo JText::_('COM_FABRIK_DELETE_GROUP'); ?>"></i>
					<?php //echo FabrikHelperHTML::image('del.png', 'form', $this->tmpl, array('class' => 'fabrikTip', 'title' => JText::_('COM_FABRIK_DELETE_GROUP')));?>
				</a>
				<?php
				endif;
				?>
			</div>
		<?php
		endif;
		?>
	</div>
	<?php
endforeach;
