<?php
/**
 * @copyright Copyright (C) 2013
 * Proyecto: Juan Rodriguez
 * WebThought Programación Creativa - www.webthought.co
 */

// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

/* The following line gets the application object for things like displaying the site name */
$document			= JFactory::getDocument();
$app 				= JFactory::getApplication();
$templateparams		= $app->getTemplate(true)->params;
$user				= JFactory::getUser();

$showRightColumn	= ($this->countModules('right') > 0);
$showUser4			= ($this->countModules('user4') > 0);
$showNav			= ($this->countModules('nav') > 0);
$showTop			= ($this->countModules('top') > 0);
$showPath			= ($this->countModules('breadcrumbs') > 0);
$showBottom			= ($this->countModules('bottom') > 0);

// Message overwrite
require_once JPATH_ROOT .'/templates/'. $this->template .'/html/message.php';
?>
<!DOCTYPE html>

<!--[if IE 8]> 				 <html class="no-js lt-ie9" lang="en" > <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang="en" > <!--<![endif]-->

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=1024, user-scalable=yes">
	<jdoc:include type="head" />    
		
    <!-- Bootstrap -->
    <link rel="stylesheet" href="templates/<?php echo $this->template ?>/css/bootstrap.min.css" media="all">
	<link rel="stylesheet" href="templates/<?php echo $this->template ?>/css/bootstrap-glyphicons.css">
	<link rel="stylesheet" href="templates/<?php echo $this->template ?>/css/template.css" type="text/css" />	
	<link rel="stylesheet" href="templates/<?php echo $this->template ?>/css/component.css" type="text/css" />
</head>

<?php if (JRequest::getVar('print') == 1) : ?>
<body onload="window.print()">
<?php else: ?>
<body>
<?php endif; ?>

    <div class="container">	
			
		<section id="content" class="row">	
			
			<?php if ($showRightColumn) : // Right Column ?><div id="main" class="col-lg-9">
			<?php else: ?><div id="main" class="col-lg-12">
			<?php endif; ?>
			
				<?php if (count($app->getMessageQueue())) : ?>
					<aside class="row">
						<div class="col-lg-12"><jdoc:include type="message" /></div>
					</aside>
				<?php endif; ?>
				
				<?php if ($showPath): ?>
					<aside id="pathway" class="row">
						<div class="col-lg-12"><jdoc:include type="modules" name="breadcrumbs" style="none"/></div>
					</aside>
				<?php endif; ?>				
			
				<div class="row"><div class="col-lg-12"><jdoc:include type="component" /></div></div>
				
			</div>
			
			<?php if ($showRightColumn) : // Right Column ?>
				<aside id="right" class="col-lg-3"><jdoc:include type="modules" name="right" style="xhtml"/></aside>
			<?php endif; ?>
			
		</section><!-- #content -->		
		
    </div> <!-- /container -->
	
	
	<!-- SCRIPTS -->
	<script type="text/javascript" src="/templates/juanrodriguez/js/main.js"></script>
	<jdoc:include type="modules" name="scripts" style="raw" />	
	
	<?php
		// Include all compiled plugins (below), or include individual files as needed
		$document->addScript($this->baseurl .'templates/'.$this->template.'/js/bootstrap.min.js');
		// Optionally enable responsive features in IE8
		$document->addScript($this->baseurl .'templates/'.$this->template.'/js/respond.min.js');
	?>	
	
	<!-- DEBUG -->
	<jdoc:include type="modules" name="debug" style="xhtml" />	

</body> 

</html>