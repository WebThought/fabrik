<?php
	/*** @copyright Copyright Pixel Praise LLC & Kyle Ledbetter © 2012. All rights reserved. */
	// no direct access
	defined('_JEXEC') or die;

    // Include the document helper
    JLoader::register('TemplateHelperDocument', dirname(__FILE__) . '/helpers/document.php');

	$app = JFactory::getApplication();
	$doc = JFactory::getDocument();

	// Settings for Joomla 3.0.x
	if (version_compare(JVERSION, '3.0.0', 'ge')) {
		// Add JavaScript Frameworks
		JHtml::_('bootstrap.framework');
	}
	// Settings for Joomla 2.5.x
	else {
		// Detect bootstrap and jQuery in document header
	    $isset_jquery = TemplateHelperDocument::headContains('jquery', 'script');
	    $isset_bsjs   = TemplateHelperDocument::headContains('bootstrap', 'script');
	    $isset_bscss  = TemplateHelperDocument::headContains('bootstrap', 'stylesheet');

	    if ($this->params->get('bootstrap_javascript', 1)) {
	        if (!$isset_jquery) {
	            $doc->addScript($this->baseurl . '/templates/' . $this->template . '/js/jquery.js');
	        }

	        if (!$isset_bsjs) {
	            $doc->addScript($this->baseurl . '/templates/' . $this->template . '/js/bootstrap.min.js');
	        }

	    }

	    // Add 2.5 System Stylesheets
		$doc->addStyleSheet('templates/system/css/general.css');
		$doc->addStyleSheet('templates/system/css/system.css');
	}

	$doc->addScript($this->baseurl . '/templates/' . $this->template . '/js/application.js');

	// Add Template Stylesheet
	$doc->addStyleSheet('templates/'.$this->template.'/css/template.css');

    // Register component route helper classes
    $pid = (int) $app->getUserState('com_projectfork.project.active.id');

    if (jimport('projectfork.library')) {
        $components = array(
            'com_pfprojects',
            'com_pfmilestones',
            'com_pftasks',
            'com_pftime',
            'com_pfrepo',
            'com_pfforum'
        );

        foreach ($components AS $component)
        {
            $route_helper = JPATH_SITE . '/components/' . $component . '/helpers/route.php';
            $class_name   = 'PF' . str_replace('com_pf', '', $component) . 'HelperRoute';

            if (file_exists($route_helper)) {
                JLoader::register($class_name, $route_helper);
            }
        }
    }

    // Have to find the project repo base dir
    if ($pid) {
        $db = JFactory::getDbo();
        $query = $db->getQuery(true);

        $query->select('attribs')
              ->from('#__pf_projects')
              ->where('id = ' . $db->quote($pid));

        $db->setQuery($query);
        $project_attribs = $db->loadResult();

        $project_params = new JRegistry;
        $project_params->loadString($project_attribs);

        $repo_dir = (int) $project_params->get('repo_dir');
    }
    else {
        $repo_dir = 1;
    }

    // Prepare component base links
    $link_tasks    = (class_exists('PFtasksHelperRoute') ? PFtasksHelperRoute::getTasksRoute() : 'index.php?option=com_pftasks');
    $link_projects = (class_exists('PFprojectsHelperRoute') ? PFprojectsHelperRoute::getProjectsRoute() : 'index.php?option=com_pfprojects');
    $link_time     = (class_exists('PFtimeHelperRoute') ? PFtimeHelperRoute::getTimesheetRoute() : 'index.php?option=com_pftime');
    $link_ms       = (class_exists('PFmilestonesHelperRoute') ? PFmilestonesHelperRoute::getMilestonesRoute() : 'index.php?option=com_pfmilestones');
    $link_forum    = (class_exists('PFforumHelperRoute') ? PFforumHelperRoute::getTopicsRoute() : 'index.php?option=com_pfforum');
    $link_repo     = (class_exists('PFrepoHelperRoute') ? PFrepoHelperRoute::getRepositoryRoute($pid, $repo_dir) : 'index.php?option=com_pfrepo&filter_project=' . $pid . '&parent_id=' . $repo_dir);
?>
<!DOCTYPE html>
<html>
<head>
	<jdoc:include type="head" />
    <?php
    // Detecting Home
    $site_app = JFactory::getApplication('Site');
    $menu     = $site_app->getMenu();

    if ($menu->getActive() == $menu->getDefault()) :
    $siteHome = 1;
    else:
    $siteHome = 0;
    endif;

    // Add current user information
    $user = JFactory::getUser();

    // Grad the Itemid
    $itemid = JRequest::getint( 'Itemid' );

    // Detecting Active Variables
    $option = JRequest::getCmd('option', '');
    $view = JRequest::getCmd('view', '');
    $layout = JRequest::getCmd('layout', '');
    $task = JRequest::getCmd('task', '');
    $itemid = JRequest::getCmd('Itemid', '');
    $sitename = $app->getCfg('sitename');
    if($task == "edit" || $layout == "form" ) :
    $fullWidth = 1;
    else:
    $fullWidth = 0;
    endif;

    // Added by jseliga
    // Determine Name to Display
    if ($this->params->get('nameDisplay') == "full") {
        $displayName = $user->name;
    }
    elseif ($this->params->get('nameDisplay') == "email") {
        $displayName = $user->email;
    }
    else {
        $displayName = $user->username;
    }

    $document = JFactory::getDocument();

    // Adjusting content width
    if ($this->countModules('position-7') && $this->countModules('right')) :
    	$span = "span6";
    elseif ($this->countModules('position-7') && !$this->countModules('right')) :
    	$span = "span10";
    elseif (!$this->countModules('position-7') && $this->countModules('right')) :
    	$span = "span8";
    else :
    	$span = "span12";
    endif;

    // Logo file or site title param
	if ($this->params->get('logoFile'))
	{
		$logo = '<img src="'. JURI::root() . $this->params->get('logoFile') .'" alt="'. $sitename .'" />';
	} else {
		$logo = '<img src="'. JURI::root() . '/templates/' . $this->template . '/img/logo.png' .'" alt="'. $sitename .'" />';
	}
	?>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="apple-mobile-web-app-capable" content="yes">
	<meta name="apple-mobile-web-app-status-bar-style" content="black-translucent" />
    <link href="//netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css" rel="stylesheet">
	<link rel="apple-touch-icon-precomposed" sizes="144x144" href="<?php echo $this->baseurl ?>/templates/<?php echo $this->template ?>/ico/apple-touch-icon-144-precomposed.png">
	<link rel="apple-touch-icon-precomposed" sizes="114x114" href="<?php echo $this->baseurl ?>/templates/<?php echo $this->template ?>/ico/apple-touch-icon-114-precomposed.png">
	<link rel="apple-touch-icon-precomposed" sizes="72x72" href="<?php echo $this->baseurl ?>/templates/<?php echo $this->template ?>/ico/apple-touch-icon-72-precomposed.png">
	<link rel="apple-touch-icon-precomposed" href="<?php echo $this->baseurl ?>/templates/<?php echo $this->template ?>/ico/apple-touch-icon-57-precomposed.png">

	<?php if($this->params->get('color', '')):?>
		<style type="text/css">
			.navbar-inverse .navbar-inner,
			.dropdown-menu > li > a:hover, .dropdown-menu > li > a:focus, .dropdown-submenu:hover > a, .dropdown-submenu:focus > a{
				background: <?php echo $this->params->get('color');?>;
			}
		</style>
	<?php endif;?>
</head>

<body class="site <?php echo $option . " view-" . $view . " layout-" . $layout . " task-" . $task . " itemid-" . $itemid . " ";?>  <?php if($siteHome && !$user->id): echo "homepage";endif;?> ">
	
	<?php if ($siteHome && !$user->id): ?>
		<div class="container-fluid"> 
			<div class="row-fluid">
				<div class="span4 offset4">
					<a href="<?php echo $this->baseurl; ?>" class="logo"><?php echo $logo;?></a>
					<jdoc:include type="modules" name="homepage" style="xhtml" />
				</div>
			</div>
		</div>
	<?php else: ?>
		<!-- Top Navigation -->
		<div class="navbar navbar-inverse navbar-fixed-top">
			<div class="navbar-inner">
				<div class="container-fluid"> 
					<a class="btn btn-navbar pull-left sidebar-toggle" href="#"> <span class="icon-bar"></span> <span class="icon-bar"></span> <span class="icon-bar"></span> </a> 
					<?php // echo JHtml::_('string.truncate', $doc->getTitle(), 0, false, false);?>
					<jdoc:include type="modules" name="searchload" style="none" />
					<jdoc:include type="modules" name="position-0" style="none" />
					<ul class="nav pull-right">
						<?php if($user->id):?>
							<li class="dropdown"> 
								<a class="dropdown-toggle hidden-phone" data-toggle="dropdown" href="#">
									<img alt="<?php echo $displayName;?>"
									width="30"
									src="<?php echo JHtml::_('projectfork.avatar.path', $user->id);?>"
									class="img-circle pull-left"
									data-placement="bottom"
									/> 
									<span><?php echo $displayName; ?> </span><span class="caret"></span>
								</a>
								<a class="dropdown-toggle visible-phone btn btn-navbar clearfix" data-toggle="dropdown" href="#">
									<img alt="<?php echo $displayName;?>"
									width="20"
									src="<?php echo JHtml::_('projectfork.avatar.path', $user->id);?>"
									class="img-circle pull-left"
									data-placement="bottom"
									/> 
								</a>
								<ul class="dropdown-menu">
									<li class=""><a href="<?php echo JRoute::_('index.php?option=com_users&view=profile&Itemid='. $itemid);?>"><?php echo JText::_('TPL_EMERALD_PROFILE');?></a></li>
									<li class="">
										<a href="<?php echo JRoute::_($link_tasks . '&filter_assigned=' . $user->id);?>">
											<?php echo JText::_('TPL_EMERALD_MY_TASKS');?>
										</a>
									</li>
									<li class="divider"></li>
									<li class=""><a href="<?php echo JRoute::_('index.php?option=com_users&task=user.logout&'. JSession::getFormToken() .'=1');?>"><?php echo JText::_('TPL_EMERALD_LOGOUT');?></a></li>
								</ul>
							</li>
						<?php else : ?>
							<li class="hidden-phone"><a href="#modal-signin" role="button" class="btn btn-navbar" data-toggle="modal"><?php echo JText::_('TPL_EMERALD_SIGN_IN');?></a></li>
							<li class="visible-phone"><a href="<?php echo $this->baseurl; ?>/index.php?option=com_users&view=login" class="btn btn-navbar"><span aria-hidden="true" class="icon-lock"></span></a></li>
						<?php endif;?>
					</ul>
					<!--/.nav-collapse -->
				</div>
			</div>
		</div>
		<!-- Container -->
		<div id="content" class="content">
			<!-- Begin Content -->
			<jdoc:include type="modules" name="top" style="xhtml" />
			<jdoc:include type="message" />
			<jdoc:include type="component" />
			<jdoc:include type="modules" name="bottom" style="xhtml" />
			<!-- End Content -->
			<hr />
			<div class="footer">
				<p>&copy; <?php echo $sitename; ?> <?php echo date('Y');?></p>
			</div>
			<jdoc:include type="modules" name="debug" style="none" />
		</div>
		<?php if ($this->countModules('position-7')) : ?>
			<div id="sidebar" class="sidebar">
				<!-- Begin Sidebar -->
				<a href="<?php echo $this->baseurl; ?>" class="logo"><?php echo $logo;?></a>
				<jdoc:include type="modules" name="create" style="xhtml" />
				<jdoc:include type="modules" name="position-7" style="xhtml" />
				<jdoc:include type="modules" name="left" style="xhtml" />
				<!-- End Sidebar -->
			</div>
		<?php endif; ?>
		<?php if ($this->countModules('right')) : ?>
			<div id="aside" class="aside">
				<!-- Begin Right Sidebar -->
				<jdoc:include type="modules" name="right" style="xhtml" />
				<!-- End Right Sidebar -->
			</div>
		<?php endif; ?>
		<!-- Modal -->
		<div id="modal-signin" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
				<h3 id="myModalLabel">Sign In</h3>
			</div>
			<div class="modal-body">
				<jdoc:include type="module" name="login" style="none" />
			</div>
		</div>
	<?php endif; ?>
</body>
</html>
