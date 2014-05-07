<?php
/**
 * Fabrik List Template: Default Row
 *
 * @package     Joomla
 * @subpackage  Fabrik
 * @copyright   Copyright (C) 2005 Fabrik. All rights reserved.
 * @license     http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.php
 */

// No direct access
defined('_JEXEC') or die;

$vencimiento = DateTime::createFromFormat('d/m/Y', @$this->_row->data->gjr_cobranza___vencimiento);
$hoy = new DateTime();
if (is_object($vencimiento)) {
	$interval = $vencimiento->diff($hoy);	
}

$trStatus = '';
if (@$this->_row->data->gjr_cobranza___estado == 'Cobrado')
	$trStatus = 'success';
elseif (@$this->_row->data->gjr_cobranza___estado == 'Pendiente') {
	if (isset($interval) && $interval->days < 0)
		$trStatus = 'danger';
	elseif (isset($interval) && $interval->days <= 30)
		$trStatus = 'warning';
}
?>
<tr id="<?php echo $this->_row->id;?>" class="<?php echo $this->_row->class. ' ' . $trStatus;?>">
	<?php foreach ($this->headings as $heading => $label) {
		$style = empty($this->cellClass[$heading]['style']) ? '' : 'style="'.$this->cellClass[$heading]['style'].'"';
		?>
		<td class="<?php echo $this->cellClass[$heading]['class']?>" <?php echo $style?>>
			<?php echo @$this->_row->data->$heading;?>			
			
			<?php if ($heading == 'fabrik_select' && $this->_row->data->gjr_cobranza___estado != 'Cobrado'): ?>
				<a class="btn btn-warning btn-small" href="<?php echo JRoute::_('/index.php?option=com_fabrik&view=form&Itemid=130&formid=27&rowid='.$this->_row->data->gjr_cobranza___id_raw.'&listid=26&cobrar=1'); ?>"><?php echo JText::_('JR_COBRANZA_COBRAR'); ?></a>
			<?php endif; ?>
		</td>		
	<?php }?>
</tr>