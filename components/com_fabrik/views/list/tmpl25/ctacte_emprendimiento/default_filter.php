<?php
/**
 * Fabrik List Template: Default Filter
 *
 * @package     Joomla
 * @subpackage  Fabrik
 * @copyright   Copyright (C) 2005 Fabrik. All rights reserved.
 * @license     http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.php
 */

// No direct access
defined('_JEXEC') or die;
?>
<div class="row">
	<div class="col-lg-12">
		<?php if ($this->filterMode === 3 || $this->filterMode === 4) {?>
		<div class="searchall">
			<ul class="fabrik_action">

			<?php if (array_key_exists('all', $this->filters)) {
				echo '<li>' . $this->filters['all']->element . '</li>';
			}?>
				<?php if ($this->filter_action != 'onchange') {?>
			<li>
				<input type="button" class="fabrik_filter_submit button" value="<?php echo JText::_('COM_FABRIK_SEARCH');?>" name="filter" >

			</li>
			<?php } ?>
			</ul>
			</div>
		<?php
		} else {?>

			<!--<h3><?php echo JText::_('COM_FABRIK_SEARCH');?></h3>-->

			<div id="filter-container" class="well well-small">
				<div class="row">
					<?php foreach ($this->filters as $fkey => $filter) {							
							$required = $filter->required == 1 ? ' notempty' : '';?>					
							<div id="filter_<?php echo $fkey; ?>" class="fabrik_row col-lg-4 <?php echo $required;?>">
								<h4><?php echo $filter->label;?></h4>
								<?php echo $filter->element;?>
							</div>
					<?php } ?>
					<?php if ($this->filter_action != 'onchange') {?>
				</div>
				<div class="row">
					<div class="col-lg-12">
						<span class="pull-right">
							<?php if ($this->showClearFilters) : ?>
								<?php echo $this->clearFliterLink;?>
							<?php endif; ?>
							<input type="button" class="fabrik_filter_submit btn btn-primary" value="<?php echo JText::_('COM_FABRIK_SEARCH');?>" name="filter" />							
						</span>
					</div>
					<?php }?>
				</div>
			</div>

		<?php }?>
	</div>
</div>
<script type="text/javascript">
	jQuery(document).ready( function() {
		jQuery('.fabrik_filter').addClass('form-control').removeClass('input-small');	
	});
</script>