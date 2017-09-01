<?php
// +-----------------------------------------------------------------+
// |                   PhreeBooks Open Source ERP                    |
// +-----------------------------------------------------------------+
// | Copyright(c) 2008-2015 PhreeSoft      (www.PhreeSoft.com)       |

// +-----------------------------------------------------------------+
// | This program is free software: you can redistribute it and/or   |
// | modify it under the terms of the GNU General Public License as  |
// | published by the Free Software Foundation, either version 3 of  |
// | the License, or any later version.                              |
// |                                                                 |
// | This program is distributed in the hope that it will be useful, |
// | but WITHOUT ANY WARRANTY; without even the implied warranty of  |
// | MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the   |
// | GNU General Public License for more details.                    |
// +-----------------------------------------------------------------+
//  Path: /modules/phreedom/pages/profile/template_main.php
//
echo html_form('my_profile', FILENAME_DEFAULT, gen_get_all_get_params(array('action'))) . chr(10);
// include hidden fields
echo html_hidden_field('action', '') . chr(10);
// customize the toolbar actions
$toolbar->icon_list['cancel']['params'] = 'onclick="location.href = \'' . html_href_link(FILENAME_DEFAULT, '', 'SSL') . '\'"';
$toolbar->icon_list['open']['show']     = false;
$toolbar->icon_list['save']['params']   = 'onclick="submitToDo(\'save\')"';
$toolbar->icon_list['delete']['show']   = false;
$toolbar->icon_list['print']['show']    = false;
if (count($extra_toolbar_buttons) > 0) foreach ($extra_toolbar_buttons as $key => $value) $toolbar->icon_list[$key] = $value;
echo $toolbar->build();
// Build the page
?>
<h1><?php echo PAGE_TITLE; ?></h1>
<fieldset>
<legend><?php echo TEXT_THEMES_COLORS_TITLE; ?></legend>
<p><?php echo TEXT_THEMES_COLORS_DESC; ?></p>
<table class="ui-widget" style="border-style:none;margin-left:auto;margin-right:auto">
 <thead class="ui-widget-header">
  <tr><th colspan="2"><?php echo '&nbsp;'; ?></th></tr>
 </thead>
 <tbody class="ui-widget-content">
   <tr>
     <td><?php echo sprintf(TEXT_SELECT_ARGS, TEXT_THEME); ?> : </td>
     <td><?php echo html_pull_down_menu('theme', load_theme_dropdown(), $_SESSION['user']->theme, 'onchange="updateColors()"'); ?></td>
   </tr>
   <tr>
     <td><?php echo TEXT_SELECT_MENU_LOCATION; ?></td>
     <td><?php echo html_pull_down_menu('menu', load_menu_dropdown(), $_SESSION['user']->menu); ?></td>
   </tr>
   <tr>
     <td><?php echo TEXT_SELECT_COLOR_SCHEME; ?></td>
     <td><?php echo html_pull_down_menu('colors', load_colors_dropdown(), $_SESSION['user']->colors); ?></td>
   </tr>
 </tbody>
</table>
</fieldset>
</form>