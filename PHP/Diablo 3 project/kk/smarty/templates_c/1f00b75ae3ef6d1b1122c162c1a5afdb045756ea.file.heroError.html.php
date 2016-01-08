<?php /* Smarty version Smarty-3.1.14, created on 2015-07-23 14:51:28
         compiled from "smarty/templates/heroError.html" */ ?>
<?php /*%%SmartyHeaderCode:168207245455b0ff70a8e240-65467378%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '1f00b75ae3ef6d1b1122c162c1a5afdb045756ea' => 
    array (
      0 => 'smarty/templates/heroError.html',
      1 => 1437606890,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '168207245455b0ff70a8e240-65467378',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'hero' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.14',
  'unifunc' => 'content_55b0ff70abcff2_86742407',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_55b0ff70abcff2_86742407')) {function content_55b0ff70abcff2_86742407($_smarty_tpl) {?><html>
<head>
<title>Error</title>
<style>
h1,h2 {
color:red;
text-align:center;
}

</style>
</head>
<body>
   <h1><?php echo $_smarty_tpl->tpl_vars['hero']->value;?>
 could not be found in the current session</h1>
   <h2>
     Please go <a href="search.html" id="link">back to browse again</a>
   </h2>
</body>
</html>
<?php }} ?>