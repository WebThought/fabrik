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

// Helper Alertas
$persona_id = $this->groups['Personas']->elements['id']->value;

if ($persona_id) {
    require_once JPATH_ROOT . '/libraries/gestionjr/alertas.php';
    JFactory::getDocument()->addScript('/components/com_fabrik/js/noty/packaged/jquery.noty.packaged.min.js');
    $helperAlertas = new AlertasHelper('gjr_persona_117_repeat', $persona_id);
    $this->alertas = $helperAlertas->getAlertas();
} else {
    $this->alertas = NULL;
}

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
    <?php $group = $this->groups['Personas']; ?>
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
    <?php $group = $this->groups['Personas: Dirección']; ?>
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
    <li>
        <a href="#group-tab12" data-toggle="tab" id="group12_tab">
            <?php echo JText::_('JR_PERSONAS_DATOSCONTACTO'); ?>                
        </a>
    </li>
    <?php $group = $this->groups['Personas: Relaciones']; ?>
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
    <?php $group = $this->groups['Personas: Alertas']; ?>
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
                
                if (count($this->alertas)) {
                    echo ' <span class="badge badge-important">'.count($this->alertas).'</span>';
                }
            ?>
        </a>
    </li> 
</ul>
    
<div class="tab-content">
    
    <?php
        $group = $this->groups['Personas'];
        $this->group = $group;
    ?>
    <div class="tab-pane active" id="group-tab<?php echo $group->id;?>">			
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
        $group = $this->groups['Personas: Dirección'];
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
    
    <div class="tab-pane" id="group-tab12">			
        <?php
            $group = $this->groups['Personas: E-mails'];
            $this->group = $group;
        ?>
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
        
        <?php
            $group = $this->groups['Personas: Teléfonos'];
            $this->group = $group;
        ?>
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
        $group = $this->groups['Personas: Relaciones'];
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
        $group = $this->groups['Personas: Alertas'];
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

<?php if (count($this->alertas)) : ?>
    <script type="text/javascript">
        <?php foreach($this->alertas as $alerta): ?>

        // Alert Notifyer
        var n = noty({
                text        : '<?php echo $alerta['recordatorio']; ?>',
                type        : 'warning',
                dismissQueue: true,
                layout      : 'topRight',
                theme       : 'defaultTheme',
                buttons     : [
                    {
                        addClass: 'btn btn-primary', text: '<?php echo JText::_('JR_PERSONAS_MARCARCOMOLEIDA'); ?>', onClick: function ($noty) {                            
                            jQuery.ajax({
                                url: '/index.php?option=com_fabrik&task=gjalertas.ajaxMarcarComoLeido&no_html=1',
                                type: "POST",
                                data: {
                                    table: 'gjr_persona_117_repeat',
                                    id: '<?php echo $alerta['id']; ?>'
                                },
                                error:function(){
                                    alert("ERROR");
                                    return;						
                                }
                            });
                            $noty.close();
                        }
                    },
                    {
                        addClass: 'btn btn-danger', text: '<?php echo JText::_('JR_PERSONAS_CERRARALERTAS'); ?>', onClick: function ($noty) 
                        {
                            $noty.close();                        
                        }
                    }
                ]
            });
        <?php endforeach; ?>
    </script>
<?php endif; ?>