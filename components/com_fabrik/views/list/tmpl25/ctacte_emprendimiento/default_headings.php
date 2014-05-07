<?php
/**
 * Fabrik List Template: Default Headings
 *
 * @package     Joomla
 * @subpackage  Fabrik
 * @copyright   Copyright (C) 2005 Fabrik. All rights reserved.
 * @license     http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.php
 */

// No direct access
defined('_JEXEC') or die;
?>
<tr class="fabrik___heading">
<?php foreach ($this->headings as $key => $heading) {	
	$style = empty($this->headingClass[$key]['style']) ? '' : 'style="'.$this->headingClass[$key]['style'].'"';	
	?>
	<th class="<?php echo $this->headingClass[$key]['class']?>" <?php echo $style?>>
		<span class="heading"><?php echo  $heading; ?></span>
		<?php if (array_key_exists($key, $this->filters) && ($this->filterMode === 3 || $this->filterMode === 4)) {
			$filter = $this->filters[$key];
			$required = $filter->required == 1 ? ' notempty' : '';
			echo '<div class="listfilter' . $required . '">
			<span>' . $filter->element . '</span></div>';
		}?>
		<?php if ($heading == 'Ingreso' || $heading == 'Egreso'): ?>
			<table class="table moneda">
				<tr>
					<td>AR$</td>
					<td>US$</td>
					<td>R$</td>
					<td>€</td>
				</tr>
			</table>
		<?php endif; ?>
	</th>
	<?php }?>
	<th>
		<?php echo JText::_('JR_CTACTEEMP_SALDO'); ?>
		<table class="table moneda">
			<tr>
				<td>AR$</td>
				<td>US$</td>
				<td>R$</td>
				<td>€</td>
			</tr>
		</table>
	</th>
</tr>