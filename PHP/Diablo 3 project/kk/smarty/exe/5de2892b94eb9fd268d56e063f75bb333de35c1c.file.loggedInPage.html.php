<?php /* Smarty version Smarty-3.1.14, created on 2014-10-13 23:36:19
         compiled from "loggedInPage.html" */ ?>
<?php /*%%SmartyHeaderCode:1268064058543c9a33ba1f22-55994864%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '5de2892b94eb9fd268d56e063f75bb333de35c1c' => 
    array (
      0 => 'loggedInPage.html',
      1 => 1413257143,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1268064058543c9a33ba1f22-55994864',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'fName' => 0,
    'lDate' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.14',
  'unifunc' => 'content_543c9a33bdc4b3_60444015',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_543c9a33bdc4b3_60444015')) {function content_543c9a33bdc4b3_60444015($_smarty_tpl) {?><!DOCTYPE>
<html>
<head>
<title>Logged In</title>
</head>
<body>
Welcome <?php echo $_smarty_tpl->tpl_vars['fName']->value;?>
. you last logged in <?php echo $_smarty_tpl->tpl_vars['lDate']->value;?>
.
</body>
</html>
<?php }} ?>