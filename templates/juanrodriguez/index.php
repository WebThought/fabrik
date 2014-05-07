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
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<jdoc:include type="head" />    
		
    <!-- Bootstrap -->
    <link rel="stylesheet" href="templates/<?php echo $this->template ?>/css/bootstrap.min.css" media="screen">
	<link rel="stylesheet" href="templates/<?php echo $this->template ?>/css/bootstrap-glyphicons.css">
	<link rel="stylesheet" href="templates/<?php echo $this->template ?>/css/template.css" type="text/css" />	
	<link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Ropa+Sans" type="text/css">
</head>

<body>

	<div id="topbar" class="navbar navbar-inverse navbar-fixed-top">
		<div class="container">
			<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".nav-collapse">
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>
			<a class="navbar-brand" href="<?php echo $this->baseurl?>" title="<?php echo $app->getCfg('sitename');?>"><img alt="<?php echo $app->getCfg('sitename');?>" src="/templates/juanrodriguez/images/logo_juanrodriguez.png"/></a>			
			<div class="nav-collapse collapse">
				<jdoc:include type="modules" name="nav" style="raw"/>				
				
				<?php if ($user->get('id')): ?>
					<form action="<?php echo JRoute::_('index.php', true); ?>" method="post" class="navbar-form form-inline pull-right">
						<span class="glyphicon glyphicon-user"></span> <?php echo htmlspecialchars($user->get('name')); ?>
						<input type="submit" name="Submit" class="btn btn-danger" value="<?php echo JText::_('JLOGOUT'); ?>" />
						<input type="hidden" name="option" value="com_users" />
						<input type="hidden" name="task" value="user.logout" />
						<input type="hidden" name="return" value="<?php echo JRoute::_('index.php'); ?>" />								
						<?php echo JHtml::_('form.token'); ?>							
					</form>
				<?php endif; ?>
			</div><!--/.nav-collapse -->
		</div>
    </div><!-- /#topbar -->

    <div class="container">

		<?php if ($showTop) : ?>
		<section id="top" class="row">
			<jdoc:include type="modules" name="top" style="xhtml"/>		
		</section>
		<img id="top_bottom" src="<?php echo $this->baseurl ?>/templates/<?php echo $this->template ?>/images/img_top_separator.jpg" />		
		<?php endif; ?>	
			
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
	
	<footer>
		<div class="container">		
			<div class="row">
				<div class="col-lg-9">
					<jdoc:include type="modules" name="footer" style="xhtml" />
				</div>
				<div class="col-lg-3">
					<a class="wtlink" href="http://www.webthought.co" target="_blank"><img src="/templates/juanrodriguez/images/logo-wt.png" />WebThought | Programación Creativa</a>					
				</div>
			</div>
		</div>
	</footer>

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