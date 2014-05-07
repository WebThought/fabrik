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

$moneda = @$this->_row->data->gjr_view_ctacte_emprendimiento___simbolo;
$ingreso = floatval(@$this->_row->data->gjr_view_ctacte_emprendimiento___ingreso);
$egreso = floatval(@$this->_row->data->gjr_view_ctacte_emprendimiento___egreso);
if (!isset($this->saldo[$moneda]))
	$this->saldo[$moneda] = 0;
?>
<tr id="<?php echo $this->_row->id;?>" class="<?php echo $this->_row->class;?>">
	<?php foreach ($this->headings as $heading => $label) {		
		$style = empty($this->cellClass[$heading]['style']) ? '' : 'style="'.$this->cellClass[$heading]['style'].'"';
		?>
		<td class="<?php echo $this->cellClass[$heading]['class']?>" <?php echo $style?>>			
			<?php if ($label == 'Ingreso'): ?>
				<table class="table moneda">
					<tr>
						<td><?php if ($moneda == 'AR$' && $ingreso != 0) echo number_format($ingreso, 2, ',', '.'); ?></td>
						<td><?php if ($moneda == 'US$' && $ingreso != 0) echo number_format($ingreso, 2, ',', '.'); ?></td>
						<td><?php if ($moneda == 'R$' && $ingreso != 0) echo number_format($ingreso, 2, ',', '.'); ?></td>
						<td><?php if ($moneda == '€' && $ingreso != 0) echo number_format($ingreso, 2, ',', '.'); ?></td>
					</tr>
				</table>
			<?php elseif ($label == 'Egreso'): ?>
				<table class="table moneda">
					<tr>
						<td><?php if ($moneda == 'AR$' && $egreso != 0) number_format($egreso, 2, ',', '.'); ?></td>
						<td><?php if ($moneda == 'US$' && $egreso != 0) number_format($egreso, 2, ',', '.'); ?></td>
						<td><?php if ($moneda == 'R$' && $egreso != 0) number_format($egreso, 2, ',', '.'); ?></td>
						<td><?php if ($moneda == '€' && $egreso != 0) number_format($egreso, 2, ',', '.'); ?></td>
					</tr>
				</table>
			<?php else: ?>
				<?php echo @$this->_row->data->$heading;?>
			<?php endif; ?>
		</td>
	<?php }?>
		<td class="saldo">
			<?php
				$this->saldo[$moneda] += ($ingreso + $egreso);
			?>
			<table class="table moneda">
				<tr>
					<td><?php if ($moneda == 'AR$') echo number_format($this->saldo[$moneda], 2, ',', '.'); ?></td>
					<td><?php if ($moneda == 'US$') echo number_format($this->saldo[$moneda], 2, ',', '.'); ?></td>
					<td><?php if ($moneda == 'R$') echo number_format($this->saldo[$moneda], 2, ',', '.'); ?></td>
					<td><?php if ($moneda == '€') echo number_format($this->saldo[$moneda], 2, ',', '.'); ?></td>
				</tr>
			</table>			
		</td>
</tr>