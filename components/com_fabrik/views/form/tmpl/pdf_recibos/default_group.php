<?php
/**
 * Default Form:Group Template
 *
 * @package     Joomla
 * @subpackage  Fabrik
 * @copyright   Copyright (C) 2005 Fabrik. All rights reserved.
 * @license     http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.php
 * @since       3.0
 */
 ?>
<?php foreach ($this->elements as $element) : ?>	
	<div class="form-group <?php echo $element->containerClass;?>">		
		<label>
			<?php echo $element->label;?>			
		</label>
		<?php echo $element->element;?>		
		<?php echo $element->errorTag; ?>		
		<div class="clearfix"></div>		
    </div>
<?php endforeach; ?>
<script type="text/javascript">
	jQuery(document).ready( function() {
		jQuery('.fabrikinput.inputbox').addClass('form-control');	
	});
</script>