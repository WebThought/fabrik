<?php
/**
 * Contacts Custom Form Template: CSS
 *
 * @package     Joomla
 * @subpackage  Fabrik
 * @copyright   Copyright (C) 2005 Fabrik. All rights reserved.
 * @license     http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.php
 * @since       3.0
 */
 ?>
<?php
header('Content-type: text/css');
$c = (int) $_REQUEST['c'];
$view = isset($_REQUEST['view']) ? $_REQUEST['view'] : 'form';
echo "

.tab-content .tab-pane { padding: 20px 10px; }
.tab-content .tab-pane > legend { display: none; }

/* Fabrik */
.fabrikLabel, .faux-label { font-weight: bold; }
table.fabrikList th { background: #EEE; }

.floating-tip-wrapper .floating-tip.tiptop:after { margin-top: 15px; }

.mode-auto-complete .spinner { top: 60px !important; }

.auto-complete-container ul.results { background: #FFF; border: 1px solid rgba(0,0,0,0.2); border-radius: 6px; -moz-border-radius: 6px; -webkit-border-radius: 6px; -moz-border-radius: 6px; -ms-border-radius: 6px; -o-border-radius: 6px; border-radius: 6px; box-shadow: 0 5px 10px rgba(0,0,0,0.2); -moz-box-shadow: 0 5px 10px rgba(0,0,0,0.2); list-style: none; padding: 2px 0; margin: 0; }
.auto-complete-container ul.results li { padding: 5px 10px; }
.auto-complete-container ul.results li:hover { background: #FFD300; }

#fabrik-comments { border-top: 1px solid #DDD; padding-top: 0; margin-top: 20px; }
#fabrik-comment-list { float: left; width: 100%; clear: both;  list-style: none; padding: 0; margin: 0; }
#fabrik-comment-list li.empty-comment { background: none; padding: 0; margin: 0; }
#fabrik-comment-list li { background: #EEE; padding: 5px 10px; margin-bottom: 10px; }
#fabrik-comment-list li .comment-content { padding: 5px 0; }
#fabrik-comment-list li .metadata, #fabrik-comment-list li .metadata small { font-size: 11px; font-weight: bold; }
#fabrik-comment-list .replybutton,
#fabrik-comment-list .del-comment { border: 1px solid transparent; cursor: pointer; display: inline-block; font-size: 11px; font-weight: 500; line-height: 1.42857; margin-bottom: 0; padding: 4px 8px !important; text-align: center; vertical-align: middle; white-space: nowrap; -webkit-border-radius: 4px; border-radius: 4px; color: #FFF; display: inline-block; } 
#fabrik-comment-list .del-comment { background-color: #3a3c3c; border-color: #3a3c3c; }
#fabrik-comment-list .replybutton { background-color: #d43f3a; border-color: #c9302c; }
#fabrik-comment-list .reply .admin { display: inline-block; }

#{$view}_$c .fabrikActions { padding-top: 15px; clear: left; padding-bottom: 15px; }
#{$view}_$c .addGroup:link { text-decoration: none; }
#{$view}_$c .addGroup:link { text-decoration: none; }

/* Dates */
.date input[type=\"text\"] { width: 90%; margin-right: 5px; float: left; }
.date .calendarbutton { float: left; }

";?>


