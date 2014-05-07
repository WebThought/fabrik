<?php
/**
 * Bootstrap Tabs Form Template
 *
 * @package     Joomla
 * @subpackage  Fabrik
 * @copyright   Copyright (C) 2005-2013 fabrikar.com - All rights reserved.
 * @license     GNU/GPL http://www.gnu.org/copyleft/gpl.html
 * @since       3.1
 */

// No direct access
defined('_JEXEC') or die('Restricted access');

$form = $this->form;
$model = $this->getModel();
$groupTmpl = $model->editable ? 'group' : 'group_details';
$active = ($form->error != '') ? '' : ' fabrikHide';

if ($model->isMultiPage())
{
	$app = JFactory::getApplication();
	$app->enqueueMessage(FText::_('COM_FABRIK_ERR_TAB_FORM_TEMPLATE_INCOMPATIBLE_WITH_MULTIPAGE_FORMS'), 'error');
}

if ($this->params->get('show_page_heading', 1)) : ?>
	<div class="componentheading<?php echo $this->params->get('pageclass_sfx')?>">
	<?php echo $this->escape($this->params->get('page_heading')); ?>
	</div>
<?php
endif;

if ($this->params->get('show-title', 1)) :?>
	<div class="page-header">
		<h1><?php echo $form->label;?></h1>
	</div>
<?php
endif;

echo $form->intro;
?>
<form method="post" <?php echo $form->attribs?>>
<?php
echo $this->plugintop;
?>

<div class="fabrikMainError alert alert-error fabrikError<?php echo $active?>">
	<button class="close" data-dismiss="alert">×</button>
	<?php echo $form->error?>
</div>

<div class="row-fluid nav">
	<div class="span6 pull-right">
		<?php
		echo $this->loadTemplate('buttons');
		?>
	</div>
	<div class="span6">
		<?php
		echo $this->loadTemplate('relateddata');
		?>
	</div>
</div>
    
<ul class="nav nav-tabs">
    <?php $group = $this->groups['Emprendimientos']; ?>
    <li class="active" style="<?php echo $group->css;?>">
        <a href="#group-tab<?php echo $group->id; ?>" data-toggle="tab" id="group<?php echo $group->id;?>_tab">
            <?php
                if (!empty($group->title))
                {
                    echo $group->title;
                }
                else
                {
                    echo $group->name;
                }
            ?>
        </a>
    </li>	
    <?php $group = $this->groups['Emprendimientos: Datos de Compra']; ?>
    <li style="<?php echo $group->css;?>">
        <a href="#group-tab<?php echo $group->id; ?>" data-toggle="tab" id="group<?php echo $group->id;?>_tab">
            <?php
                if (!empty($group->title))
                {
                    echo $group->title;
                }
                else
                {
                    echo $group->name;
                }
            ?>
        </a>
    </li>   
    <?php $group = $this->groups['Emprendimientos: Partidas']; ?>
    <li style="<?php echo $group->css;?>">
        <a href="#group-tab<?php echo $group->id; ?>" data-toggle="tab" id="group<?php echo $group->id;?>_tab">
            <?php
                if (!empty($group->title))
                {
                    echo $group->title;
                }
                else
                {
                    echo $group->name;
                }
            ?>
        </a>
    </li>     
    <?php $group = $this->groups['Emprendimientos: Planos']; ?>
    <li style="<?php echo $group->css;?>">
        <a href="#group-tab<?php echo $group->id; ?>" data-toggle="tab" id="group<?php echo $group->id;?>_tab">
            <?php
                if (!empty($group->title))
                {
                    echo $group->title;
                }
                else
                {
                    echo $group->name;
                }
            ?>
        </a>
    </li>  
    <?php $group = $this->groups['Emprendimientos: Proyecto']; ?>
    <li style="<?php echo $group->css;?>">
        <a href="#group-tab<?php echo $group->id; ?>" data-toggle="tab" id="group<?php echo $group->id;?>_tab">
            <?php
                if (!empty($group->title))
                {
                    echo $group->title;
                }
                else
                {
                    echo $group->name;
                }                
            ?>
        </a>
    </li> 
    <?php $group = $this->groups['Emprendimientos: Inversores']; ?>
    <li style="<?php echo $group->css;?>">
        <a href="#group-tab<?php echo $group->id; ?>" data-toggle="tab" id="group<?php echo $group->id;?>_tab">
            <?php
                if (!empty($group->title))
                {
                    echo $group->title;
                }
                else
                {
                    echo $group->name;
                }
            ?>
        </a>
    </li> 
</ul>
    
<div class="tab-content">
    
    <?php
        $group = $this->groups['Emprendimientos'];
        $this->group = $group;
    ?>
    <div class="tab-pane active" id="group-tab<?php echo $group->id;?>">			
        <fieldset class="<?php echo $group->class; ?>" id="group<?php echo $group->id;?>" style="<?php echo $group->css;?>">
            <?php if (!empty($group->intro)) : ?>
                <div class="groupintro"><?php echo $group->intro ?></div>
            <?php endif; ?>
            
            <?php
                $this->element = $group->elements['nombre'];
                $this->class = 'fabrikErrorMessage';
                // Don't display hidden element's as otherwise they wreck multi-column layouts
                if (trim($this->element->error) !== '') :
                    $this->element->error = $this->errorIcon . ' ' . $this->element->error;
                    $this->element->containerClass .= ' error';
                    $this->class .= ' help-inline';
                endif;                
                echo $this->loadTemplate('group_labels_above');
            ?>
                
            <div class="row-fluid">
                <div class="span4">
                    <?php
                        $this->element = $group->elements['descripcion'];
                        $this->class = 'fabrikErrorMessage';
                        // Don't display hidden element's as otherwise they wreck multi-column layouts
                        if (trim($this->element->error) !== '') :
                            $this->element->error = $this->errorIcon . ' ' . $this->element->error;
                            $this->element->containerClass .= ' error';
                            $this->class .= ' help-inline';
                        endif;                
                        echo $this->loadTemplate('group_labels_above');
                    ?>
                </div>
                <div class="span4">
                    <?php
                        $this->element = $group->elements['fecha_inicio'];
                        $this->class = 'fabrikErrorMessage';
                        // Don't display hidden element's as otherwise they wreck multi-column layouts
                        if (trim($this->element->error) !== '') :
                            $this->element->error = $this->errorIcon . ' ' . $this->element->error;
                            $this->element->containerClass .= ' error';
                            $this->class .= ' help-inline';
                        endif;                
                        echo $this->loadTemplate('group_labels_above');
                    ?>
                </div>
                <div class="span4">
                    <?php
                        $this->element = $group->elements['fecha_formal'];
                        $this->class = 'fabrikErrorMessage';
                        // Don't display hidden element's as otherwise they wreck multi-column layouts
                        if (trim($this->element->error) !== '') :
                            $this->element->error = $this->errorIcon . ' ' . $this->element->error;
                            $this->element->containerClass .= ' error';
                            $this->class .= ' help-inline';
                        endif;                
                        echo $this->loadTemplate('group_labels_above');
                    ?>
                </div>
            </div>
                
            <div class="row-fluid">
                <div class="span3">
                    <?php
                        $this->element = $group->elements['direccion'];
                        $this->class = 'fabrikErrorMessage';
                        // Don't display hidden element's as otherwise they wreck multi-column layouts
                        if (trim($this->element->error) !== '') :
                            $this->element->error = $this->errorIcon . ' ' . $this->element->error;
                            $this->element->containerClass .= ' error';
                            $this->class .= ' help-inline';
                        endif;                
                        echo $this->loadTemplate('group_labels_above');
                    ?>
                </div>
                <div class="span3">
                    <?php
                        $this->element = $group->elements['ciudad'];
                        $this->class = 'fabrikErrorMessage';
                        // Don't display hidden element's as otherwise they wreck multi-column layouts
                        if (trim($this->element->error) !== '') :
                            $this->element->error = $this->errorIcon . ' ' . $this->element->error;
                            $this->element->containerClass .= ' error';
                            $this->class .= ' help-inline';
                        endif;                
                        echo $this->loadTemplate('group_labels_above');
                    ?>
                </div>
                <div class="span3">
                    <?php
                        $this->element = $group->elements['codigo_postal'];
                        $this->class = 'fabrikErrorMessage';
                        // Don't display hidden element's as otherwise they wreck multi-column layouts
                        if (trim($this->element->error) !== '') :
                            $this->element->error = $this->errorIcon . ' ' . $this->element->error;
                            $this->element->containerClass .= ' error';
                            $this->class .= ' help-inline';
                        endif;                
                        echo $this->loadTemplate('group_labels_above');
                    ?>
                </div>
                <div class="span3 pull-right">
                    <?php
                        $this->element = $group->elements['direccion_geo'];
                        $this->class = 'fabrikErrorMessage';
                        // Don't display hidden element's as otherwise they wreck multi-column layouts
                        if (trim($this->element->error) !== '') :
                            $this->element->error = $this->errorIcon . ' ' . $this->element->error;
                            $this->element->containerClass .= ' error';
                            $this->class .= ' help-inline';
                        endif;                
                        echo $this->loadTemplate('group_labels_above');
                    ?>
                </div>
                <div class="span3" style="margin-left: 0;">
                    <?php
                        $this->element = $group->elements['provincia'];
                        $this->class = 'fabrikErrorMessage';
                        // Don't display hidden element's as otherwise they wreck multi-column layouts
                        if (trim($this->element->error) !== '') :
                            $this->element->error = $this->errorIcon . ' ' . $this->element->error;
                            $this->element->containerClass .= ' error';
                            $this->class .= ' help-inline';
                        endif;                
                        echo $this->loadTemplate('group_labels_above');
                    ?>
                </div>
                <div class="span3">
                    <?php
                        $this->element = $group->elements['pais'];
                        $this->class = 'fabrikErrorMessage';
                        // Don't display hidden element's as otherwise they wreck multi-column layouts
                        if (trim($this->element->error) !== '') :
                            $this->element->error = $this->errorIcon . ' ' . $this->element->error;
                            $this->element->containerClass .= ' error';
                            $this->class .= ' help-inline';
                        endif;                
                        echo $this->loadTemplate('group_labels_above');
                    ?>
                </div>
            </div>
            
            <div id="nomenclatura">
                <div class="row-fluid">                
                    <div class="span12">
                        <?php
                            $this->element = $group->elements['nomenclatura'];
                            $this->class = 'fabrikErrorMessage';
                            // Don't display hidden element's as otherwise they wreck multi-column layouts
                            if (trim($this->element->error) !== '') :
                                $this->element->error = $this->errorIcon . ' ' . $this->element->error;
                                $this->element->containerClass .= ' error';
                                $this->class .= ' help-inline';
                            endif;                
                            echo $this->loadTemplate('group_labels_above');
                        ?>
                    </div>
                </div>

                <div class="row-fluid">                
                    <div class="span2">
                        <?php
                            $this->element = $group->elements['circunscripcion'];
                            $this->class = 'fabrikErrorMessage';
                            // Don't display hidden element's as otherwise they wreck multi-column layouts
                            if (trim($this->element->error) !== '') :
                                $this->element->error = $this->errorIcon . ' ' . $this->element->error;
                                $this->element->containerClass .= ' error';
                                $this->class .= ' help-inline';
                            endif;                
                            echo $this->loadTemplate('group_labels_above');
                        ?>
                    </div>
                    <div class="span2">
                        <?php
                            $this->element = $group->elements['seccion'];
                            $this->class = 'fabrikErrorMessage';
                            // Don't display hidden element's as otherwise they wreck multi-column layouts
                            if (trim($this->element->error) !== '') :
                                $this->element->error = $this->errorIcon . ' ' . $this->element->error;
                                $this->element->containerClass .= ' error';
                                $this->class .= ' help-inline';
                            endif;                
                            echo $this->loadTemplate('group_labels_above');
                        ?>
                    </div>
                    <div class="span2">
                        <?php
                            $this->element = $group->elements['chacra_quinta'];
                            $this->class = 'fabrikErrorMessage';
                            // Don't display hidden element's as otherwise they wreck multi-column layouts
                            if (trim($this->element->error) !== '') :
                                $this->element->error = $this->errorIcon . ' ' . $this->element->error;
                                $this->element->containerClass .= ' error';
                                $this->class .= ' help-inline';
                            endif;                
                            echo $this->loadTemplate('group_labels_above');
                        ?>
                    </div>
                    <div class="span2">
                        <?php
                            $this->element = $group->elements['fraccion'];
                            $this->class = 'fabrikErrorMessage';
                            // Don't display hidden element's as otherwise they wreck multi-column layouts
                            if (trim($this->element->error) !== '') :
                                $this->element->error = $this->errorIcon . ' ' . $this->element->error;
                                $this->element->containerClass .= ' error';
                                $this->class .= ' help-inline';
                            endif;                
                            echo $this->loadTemplate('group_labels_above');
                        ?>
                    </div>
                    <div class="span2">
                        <?php
                            $this->element = $group->elements['manzana'];
                            $this->class = 'fabrikErrorMessage';
                            // Don't display hidden element's as otherwise they wreck multi-column layouts
                            if (trim($this->element->error) !== '') :
                                $this->element->error = $this->errorIcon . ' ' . $this->element->error;
                                $this->element->containerClass .= ' error';
                                $this->class .= ' help-inline';
                            endif;                
                            echo $this->loadTemplate('group_labels_above');
                        ?>
                    </div>
                    <div class="span1">
                        <?php
                            $this->element = $group->elements['parcela'];
                            $this->class = 'fabrikErrorMessage';
                            // Don't display hidden element's as otherwise they wreck multi-column layouts
                            if (trim($this->element->error) !== '') :
                                $this->element->error = $this->errorIcon . ' ' . $this->element->error;
                                $this->element->containerClass .= ' error';
                                $this->class .= ' help-inline';
                            endif;                
                            echo $this->loadTemplate('group_labels_above');
                        ?>
                    </div>
                    <div class="span1">
                        <?php
                            $this->element = $group->elements['unidad_funcional'];
                            $this->class = 'fabrikErrorMessage';
                            // Don't display hidden element's as otherwise they wreck multi-column layouts
                            if (trim($this->element->error) !== '') :
                                $this->element->error = $this->errorIcon . ' ' . $this->element->error;
                                $this->element->containerClass .= ' error';
                                $this->class .= ' help-inline';
                            endif;                
                            echo $this->loadTemplate('group_labels_above');
                        ?>
                    </div>                    
                </div>
            </div>
            
        </fieldset>
    </div>
    
    <?php
        $group = $this->groups['Emprendimientos: Datos de Compra'];
        $this->group = $group;
    ?>
    <div class="tab-pane" id="group-tab<?php echo $group->id;?>">			
        <fieldset class="<?php echo $group->class; ?>" id="group<?php echo $group->id;?>" style="<?php echo $group->css;?>">
            <?php if (!empty($group->intro)) : ?>
                <div class="groupintro"><?php echo $group->intro ?></div>
            <?php
            endif;

            /* Load the group template - this can be :
             *  * default_group.php - standard group non-repeating rendered as an unordered list
             *  * default_repeatgroup.php - repeat group rendered as an unordered list
             *  * default_repeatgroup_table.php - repeat group rendered in a table.
             */
            $this->elements = $group->elements;
            echo $this->loadTemplate($group->tmpl);

            if (!empty($group->outro)) : ?>
                <div class="groupoutro"><?php echo $group->outro ?></div>
            <?php
            endif;
        ?>
        </fieldset>
    </div>
    
     <?php
        $group = $this->groups['Emprendimientos: Partidas'];
        $this->group = $group;
    ?>
    <div class="tab-pane" id="group-tab<?php echo $group->id;?>">
       
        <fieldset class="<?php echo $group->class; ?>" id="group<?php echo $group->id;?>" style="<?php echo $group->css;?>">
            <?php if (!empty($group->intro)) : ?>
                <div class="groupintro"><?php echo $group->intro ?></div>
            <?php
            endif;

            /* Load the group template - this can be :
             *  * default_group.php - standard group non-repeating rendered as an unordered list
             *  * default_repeatgroup.php - repeat group rendered as an unordered list
             *  * default_repeatgroup_table.php - repeat group rendered in a table.
             */
            $this->elements = $group->elements;
            echo $this->loadTemplate($group->tmpl);

            if (!empty($group->outro)) : ?>
                <div class="groupoutro"><?php echo $group->outro ?></div>
            <?php
            endif;
        ?>
        </fieldset>
    </div>
        
    <?php
        $group = $this->groups['Emprendimientos: Planos'];
        $this->group = $group;
    ?>
    <div class="tab-pane" id="group-tab<?php echo $group->id;?>">
        <fieldset class="<?php echo $group->class; ?>" id="group<?php echo $group->id;?>" style="<?php echo $group->css;?>">
            <?php if (!empty($group->intro)) : ?>
                <div class="groupintro"><?php echo $group->intro ?></div>
            <?php
            endif;

            /* Load the group template - this can be :
             *  * default_group.php - standard group non-repeating rendered as an unordered list
             *  * default_repeatgroup.php - repeat group rendered as an unordered list
             *  * default_repeatgroup_table.php - repeat group rendered in a table.
             */
            $this->elements = $group->elements;
            echo $this->loadTemplate($group->tmpl);

            if (!empty($group->outro)) : ?>
                <div class="groupoutro"><?php echo $group->outro ?></div>
            <?php
            endif;
        ?>
        </fieldset>
    </div>
    
    <?php
        $group = $this->groups['Emprendimientos: Proyecto'];
        $this->group = $group;
    ?>
    <div class="tab-pane" id="group-tab<?php echo $group->id;?>">			
        <fieldset class="<?php echo $group->class; ?>" id="group<?php echo $group->id;?>" style="<?php echo $group->css;?>">
            <?php if (!empty($group->intro)) : ?>
                <div class="groupintro"><?php echo $group->intro ?></div>
            <?php
            endif;

            /* Load the group template - this can be :
             *  * default_group.php - standard group non-repeating rendered as an unordered list
             *  * default_repeatgroup.php - repeat group rendered as an unordered list
             *  * default_repeatgroup_table.php - repeat group rendered in a table.
             */
            $this->elements = $group->elements;
            echo $this->loadTemplate($group->tmpl);

            if (!empty($group->outro)) : ?>
                <div class="groupoutro"><?php echo $group->outro ?></div>
            <?php
            endif;
        ?>
        </fieldset>
    </div>
    
    <?php
        $group = $this->groups['Emprendimientos: Inversores'];
        $this->group = $group;
    ?>
    <div class="tab-pane" id="group-tab<?php echo $group->id;?>">			
        <fieldset class="<?php echo $group->class; ?>" id="group<?php echo $group->id;?>" style="<?php echo $group->css;?>">
            <?php if (!empty($group->intro)) : ?>
                <div class="groupintro"><?php echo $group->intro ?></div>
            <?php
            endif;

            /* Load the group template - this can be :
             *  * default_group.php - standard group non-repeating rendered as an unordered list
             *  * default_repeatgroup.php - repeat group rendered as an unordered list
             *  * default_repeatgroup_table.php - repeat group rendered in a table.
             */
            $this->elements = $group->elements;
            echo $this->loadTemplate($group->tmpl);

            if (!empty($group->outro)) : ?>
                <div class="groupoutro"><?php echo $group->outro ?></div>
            <?php
            endif;
        ?>
        </fieldset>
    </div>
    
</div>

<?php
if ($model->editable) : ?>
<div class="fabrikHiddenFields">
	<?php echo $this->hiddenFields; ?>
</div>
<?php
endif;

echo $this->pluginbottom;
echo $this->loadTemplate('actions');
?>
</form>
<?php
echo $form->outro;
echo $this->pluginend;
echo FabrikHelperHTML::keepalive();
?>