<?php
/**
 * Fabrik List Template: Default Buttons
 *
 * @package     Joomla
 * @subpackage  Fabrik
 * @copyright   Copyright (C) 2005 Fabrik. All rights reserved.
 * @license     http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.php
 */

// No direct access
defined('_JEXEC') or die;
?>

<?php if ($this->hasButtons) :?>
	<div class="row">
		<div class="col-lg-12">
			<div class="btn-toolbar fabrik_buttons">
				<div class="btn-group">	
					<?php if ($this->showAdd) : ?>
						<a class="addRecord btn btn-default" href="<?php echo $this->addRecordLink;?>">
							<span class="glyphicon glyphicon-plus"></span>
							<span><?php echo $this->addLabel?></span>
						</a>			
					<?php endif; ?>
					<?php if ($this->showFilters && $this->toggleFilters) : ?>
						<a href="#" class="toggleFilters btn btn-default">
							<?php echo $this->buttons->filter;?>
							<span><?php echo JText::_('COM_FABRIK_FILTER');?></span>
						</a>			
					<?php endif; ?>
					<?php if ($this->advancedSearch !== '') {
						echo $this->advancedSearch;
					}
					if ($this->canGroupBy): ?>
						<div class="btn-group">
							<a href="#" class="groupBy btn btn-default dropdown-toggle" data-toggle="dropdown">
								<span class="glyphicon glyphicon-random"></span>
								<span><?php echo JText::_('COM_FABRIK_GROUP_BY');?></span>
								<span class="caret"></span>
							</a>			
							<ul class="dropdown-menu">
								<?php foreach ($this->groupByHeadings as $url => $label) : ?>
									<li><a href="<?php echo $url?>"><?php echo $label?></a></li>
								<?php endforeach; ?>
							</ul>
						</div>
					<?php endif; ?>
				</div>
				<div class="btn-group">		
					<?php if ($this->showCSV): ?>
						<a href="#" class="csvExportButton btn btn-default">
							<span class="glyphicon glyphicon-download-alt"></span>						
							<span><?php echo JText::_('COM_FABRIK_EXPORT_TO_CSV');?></span>
						</a>		
					<?php endif; ?>
					<?php if ($this->showCSVImport) : ?>		
						<a href="<?php echo $this->csvImportLink;?>" class="btn btn-default">
							<span class="glyphicon glyphicon-hdd"></span>
							<span><?php echo JText::_('COM_FABRIK_IMPORT_FROM_CSV');?></span>
						</a>
					<?php endif; ?>
					<?php if ($this->showRSS) : ?>
						<a href="<?php echo $this->rssLink;?>" class="btn btn-default">
							<span class="glyphicon glyphicon-share"></span>
							<span><?php echo JText::_('COM_FABRIK_SUBSCRIBE_RSS');?></span>
						</a>
					<?php endif; ?>
					<?php if ($this->showPDF) : ?>
						<a href="<?php echo $this->pdfLink;?>" class="btn btn-default">
							<span class="glyphicon glyphicon-file"></span>
							<span><?php echo JText::_('COM_FABRIK_PDF');?></span>
						</a>
					<?php endif; ?>
					<?php if ($this->emptyLink): ?>
						<a href="<?php echo $this->emptyLink?>" class="doempty btn btn-default">
							<span class="glyphicon glyphicon-trash"></span>
							<span><?php echo JText::_('COM_FABRIK_EMPTY')?></span>
						</a>
					<?php endif; ?>
					<?php foreach ($this->pluginTopButtons as $b): ?>
						<a class="btn btn-default">
							<?php echo $b;?>
						</a>
					<?php endforeach; ?>
				</div>		
			</div>
		</div>
	</div>
<?php endif;?>