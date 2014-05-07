<?php
/**
* @package      Projectfork Dashboard Buttons
*
* @author       Tobias Kuhn (eaxs)
* @copyright    Copyright (C) 2006-2012 Tobias Kuhn. All rights reserved.
* @license      http://www.gnu.org/licenses/gpl.html GNU/GPL, see LICENSE.txt
**/

defined('_JEXEC') or die();


if (count($buttons) == 0) return '';
?>
<div class="btn-toolbar-dashboard clearfix">
    <?php   
        $btnClass = array("primary", "info", "success", "warning", "danger", "purple", "pink", "danger-light", "warning", "danger"); 
        $i = 0
    ?>
    <?php foreach($buttons AS $component => $btns) : ?>
        <?php if (PFApplicationHelper::enabled($component)) : ?>
            <?php foreach ($btns AS $btn) : ?>
                <a href="<?php echo JRoute::_($btn['link']);?>" class="btn btn-<?php echo $btnClass[$i++]?> btn-large pull-left">
                    <p><?php echo $btn['icon']; ?></p>
                    <div class="text-left"><?php echo JText::_($btn['title']);?></div>
                </a>
            <?php endforeach; ?>
        <?php endif; ?>
    <?php endforeach; ?>
</div>
