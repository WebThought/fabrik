<?php
/**
 * Fabrik List Template: DB Join Select Filter
 *
 * @package     Joomla
 * @subpackage  Fabrik
 * @copyright   Copyright (C) 2005 Fabrik. All rights reserved.
 * @license     http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.php
 */

// No direct access
defined('_JEXEC') or die;
?>
<div class="fabrikFilterContainer">
<table class="filtertable fabrikList">
	<tr>
		<th style="text-align:left"><?php echo JText::_('COM_FABRIK_SEARCH');?>:</th>
		<th style="text-align:right"><?php echo $this->clearFliterLink;?></th>
	</tr>
	<?php
	$c = 0;
	foreach ($this->filters as $filter) {
		$required = $filter->required == 1 ? ' class="notempty"' : '';?>
		<tr class="fabrik_row oddRow<?php echo ($c % 2);?>">
			<td<?php echo $required ?>><?php echo $filter->label;?></td>
			<td style="text-align:right;"><?php echo $filter->element;?></td>
		</tr>
	<?php $c ++;
	} ?>
	<?php if ($this->filter_action != 'onchange') {?>
	<tr class="fabrik_row oddRow<?php echo $c % 2;?>">
		<td colspan="2" style="text-align:right;">
		<input type="button" class="fabrik_filter_submit button" value="<?php echo JText::_('COM_FABRIK_GO');?>"
			name="filter" />
		</td>
	</tr>
	<?php }?>
</table>
</div>