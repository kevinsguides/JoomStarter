<?php

/**
 * @package     com.kevinsguides
 * @subpackage  templates.joomstarter
 *
 * @copyright   modified version of Joomla's default module chromes
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

use Joomla\Utilities\ArrayHelper;

//get the module
$module  = $displayData['module'];
$params  = $displayData['params'];
$attribs = $displayData['attribs'];

//if the module doesn't have any content, skip (return)
if ($module->content === null || $module->content === '') {
    return;
}

//get the module information, such as header, class, tag, etc...
//all of these settings come from the individual settings of each module using this chrome!!! SEE module manager -> module -> advanced
//we are just taking values from here and placing them into a template

//this variable contains the element type for the whole module container - default is DIV
$moduleTag              = $params->get('module_tag', 'div'); 
//this is an array which will contain other attributes about the module
$moduleAttribs          = [];
$moduleAttribs['class'] = $module->position . ' no-card ' . htmlspecialchars($params->get('moduleclass_sfx', ''), ENT_QUOTES, 'UTF-8');
//this is the element type of the heading, default set to an <h3> element
$headerTag              = htmlspecialchars($params->get('header_tag', 'h3'), ENT_QUOTES, 'UTF-8');
//this is the class added to the heading element, eg. <h3 class="whatever">
$headerClass            = htmlspecialchars($params->get('header_class', ''), ENT_QUOTES, 'UTF-8');
$headerAttribs          = [];

// Only output a header class if one is set
if ($headerClass !== '') {
    $headerAttribs['class'] = $headerClass;
}

//Users may display the module in elements other than a div if desired (addreess, article, section, nav, etc...)
// Only add aria if the moduleTag is not a div
if ($moduleTag !== 'div') {
    if ($module->showtitle) :
        $moduleAttribs['aria-labelledby'] = 'mod-' . $module->id;
        $headerAttribs['id']              = 'mod-' . $module->id;
    else :
        $moduleAttribs['aria-label'] = $module->title;
    endif;
}

//this is the actual template for this module chrome. first it makes the header element (with the $module->title)
$header = '<' . $headerTag . ' ' . ArrayHelper::toString($headerAttribs) . '>' . $module->title . '</' . $headerTag . '>';
?>
<?php //then it creates the element itself, starting with the module tag (Default is DIV) followed by any other attributes, such as class?>
<<?php echo $moduleTag; ?> <?php echo ArrayHelper::toString($moduleAttribs); ?>>
    <?php // if the module's showtitle option is set to YES, it prints the $header defined a few lines above ?>
    <?php if ($module->showtitle) : ?>
        <?php echo $header; ?>
    <?php endif; ?>
    <?php // this line prints the actual contents of the module itself, such as the menu, the login form, the custom html, etc. ?>
    <?php echo $module->content; ?>
</<?php echo $moduleTag; ?>>
