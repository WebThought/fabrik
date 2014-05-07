<?php
/**
 * Bootstrap List Template - Filter
 *
 * @package     Joomla
 * @subpackage  Fabrik
 * @copyright   Copyright (C) 2005-2013 fabrikar.com - All rights reserved.
 * @license     GNU/GPL http://www.gnu.org/copyleft/gpl.html
 * @since       3.1
 */

// No direct access
defined('_JEXEC') or die('Restricted access');
$filterColumns = 'span'.$this->filterCols;
$style = $this->toggleFilters ? 'style="display:none"' : ''; ?>
<div class="fabrikFilterContainer well well-small" <?php echo $style?>>	
	<?php if ($this->filterMode != 3 && $this->filterMode != 4) : ?>	
		<!--<h4><?php echo FText::_('COM_FABRIK_SEARCH');?>:</h4>-->
		<div class="row-fluid">			
			<?php foreach ($this->filters as $key => $filter) : ?>
				<?php
					$required = $filter->required == 1 ? ' notempty' : '';
				?>
				<div data-filter-row="<?php echo $key;?>" class="<?php echo $filterColumns;?> <?php echo $required; ?>">
					<label><?php echo $filter->label;?></label>
					<?php echo $filter->element;?>
				</div>
			<?php endforeach; ?>
			
			<div class="btn-group pull-right">			
				<?php if ($this->showClearFilters) :?>
					<a class="clearFilters btn" href="#"><i class="icon-refresh"></i> <?php echo FText::_('COM_FABRIK_CLEAR')?>	</a>					
				<?php endif ?>
				<?php if ($this->filter_action != 'onchange') : ?>
					<input type="button" class="btn-info btn fabrik_filter_submit button" value="<?php echo FText::_('COM_FABRIK_GO');?>" name="filter" >
				<?php endif; ?>	
			</div>
			
			
		</div>
	<?php endif; ?>
</div>