<?php
/**
 * @package     Joomla.Site
 * @subpackage  Templates.JoomStarter
 *
 * @copyright   (C) YEAR Your Name
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * This is a heavily stripped down/modified version of the default Cassiopeia template, designed to build new templates off of.
 */

defined('_JEXEC') or die;  //required for basically ALL php files in Joomla, for security. Prevents direct access to this file by url.

//Imports ("use" statements) - objects from Joomla that we want to use in this file
use Joomla\CMS\Factory; // Factory class: Contains static methods to get global objects from the Joomla framework. Very important!
use Joomla\CMS\HTML\HTMLHelper; // HTMLHelper class: Contains static methods to generate HTML tags.
use Joomla\CMS\Language\Text; // Text class: Contains static methods to get text from language files
use Joomla\CMS\Uri\Uri; // Uri class: Contains static methods to manipulate URIs.

/** @var Joomla\CMS\Document\HtmlDocument $this */

$app = Factory::getApplication();
$wa  = $this->getWebAssetManager();  // Get the Web Asset Manager - used to load our CSS and JS files

// Add Favicon from images folder
$this->addHeadLink(HTMLHelper::_('image', 'favicon.ico', '', [], true, 1), 'icon', 'rel', ['type' => 'image/x-icon']);


// Detecting Active Variables
$option   = $app->input->getCmd('option', '');
$view     = $app->input->getCmd('view', '');
$layout   = $app->input->getCmd('layout', '');
$task     = $app->input->getCmd('task', '');
$itemid   = $app->input->getCmd('Itemid', '');
$sitename = htmlspecialchars($app->get('sitename'), ENT_QUOTES, 'UTF-8');
$menu     = $app->getMenu()->getActive();
$pageclass = $menu !== null ? $menu->getParams()->get('pageclass_sfx', '') : '';

//Get params from template styling
//If you want to add your own parameters you may do so in templateDetails.xml
$testparam =  $this->params->get('testparam');

//uncomment to see how this works on site... it just shows 1 or 0 depending on option selected in style config.
//You can use this style to get/set any param according to instructions at https://kevinsguides.com/guides/webdev/joomla4/joomla-4-templates/adding-config
//echo('the value of testparam is: '.$testparam);

// Get this template's path
$templatePath = 'templates/' . $this->template;


//load bootstrap collapse js (required for mobile menu to work)
//this loads collapse.min.js from media/vendor/bootstrap/js - you can check out that folder to see what other bootstrap js files are available if you need them
HTMLHelper::_('bootstrap.collapse');
//dropdown needed for 2nd level menu items
HTMLHelper::_('bootstrap.dropdown');
//You could also load all of bootstrap js with this line, but it's not recommended because it's a lot of extra code that you probably don't need
//HTMLHelper::_('bootstrap.framework');


//Register our web assets (Css/JS) with the Web Asset Manager
//The files are defined in joomla.asset.json!!! If you don't want to use the included CSS or JS, just remove these lines or replace the CSS/JS files with your own code!
$wa->useStyle('template.joomstarter.mainstyles');
$wa->useStyle('template.joomstarter.user');
$wa->useScript('template.joomstarter.scripts');

//Set viewport meta tag for mobile responsiveness -- very important for scaling on mobile devices
$this->setMetaData('viewport', 'width=device-width, initial-scale=1');

?>

<?php // Everything below here is the actual "template" part of the template. Where we put our HTML code for the layout and such. ?>
<!DOCTYPE html>
<html lang="<?php echo $this->language; ?>" dir="<?php echo $this->direction; ?>">
<head>

    <?php // Loads important metadata like the page title and viewport scaling ?>
	<jdoc:include type="metas" />

    <?php // Loads the site's CSS and JS files from web asset manager ?>
	<jdoc:include type="styles" />
	<jdoc:include type="scripts" />

    <?php /** You can put links to CSS/JS just like any regular HTML page here too, and remove the jdoc:include script/style lines above if you want.
     * Do not delete the metas line though
     * 
     * For example, if you want to manually link to a custom stylesheet or script, you can do it like this:
     * <link rel="stylesheet" href="https://mysite.com/templates/mytemplate/mycss.css" type="text/css" />
     * <script src="https://mysite.com/templates/mytemplate/myscript.js"></script>
     * */ 
    ?>
    
</head>

<?php // you can change data-bs-theme to dark for dark mode  // ?>
<body class="site <?php echo $pageclass; ?>" data-bs-theme="light">
	<header>
        <?php // Generate a Bootstrap Navbar for the top of our website and put the site title on it ?>
        <nav class="navbar navbar-dark bg-dark navbar-expand-lg">
            <div class="container">
                <a href="" class="navbar-brand"><?php echo ($sitename); ?></a>
                <?php // Update 1.14 - Added support for mobile menu with bootstrap ?>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainmenu" aria-controls="mainmenu" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
                </button>
                <?php // Put menu links in the navbar - main menu must be in the "menu" position!!! Only supports top level and 1 down, so no more than 1 level of child items ?>
                <?php if ($this->countModules('menu')): ?>
                <div class="collapse navbar-collapse" id="mainmenu"><jdoc:include type="modules" name="menu" style="none" /></div>

                <?php endif; ?>
            </div>
        </nav>
        <?php // Load Header Module if Module Exists ?>
        <?php if ($this->countModules('header')) : ?>
            <div class="headerClasses">
                <jdoc:include type="modules" name="header" style="none" />
            </div>
        <?php endif; ?>
    </header>

    <?php // Generate the main content area of the website ?>
    <div class="siteBody">
        <div class="container">
        <?php // Load Breadcrumbs Module if Module Exists ?>
            <?php if ($this->countModules('breadcrumbs')) : ?>
                <div class="breadcrumbs">
                    <jdoc:include type="modules" name="breadcrumbs" style="none" />
                </div>
            <?php endif; ?>
            <div class="row">
            <?php // Use a BootStrap grid to load main content on left, sidebar on right IF sidebar exists ?>
                <?php if ($this->countModules('sidebar')) : ?>
                <div class="col-xs-12 col-lg-8">

                    <main>
                    <?php // Load important Joomla system messages ?>
                        <jdoc:include type="message" />
                        <?php // Load the main component of the webpage ?>
                        <jdoc:include type="component" />
                    </main>
                </div>
                <?php // Load the sidebar if one exists ?>
                <div class="col-xs-12 col-lg-4">
                <?php // This line tells Joomla to load the "sidebar" module position with the "superBasicMod" mod chrome as the default (see html/layouts/chromes folder) ?>
                        <jdoc:include type="modules" name="sidebar" style="superBasicMod" />
                </div>
                <?php // If there's no sidebar, just load the component with no sidebar ?>
                <?php else: ?>
                    <?php // Load the main component of the webpage ?>
                    <main>
                        <jdoc:include type="component" />
                    </main>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <?php // Load Footer ?>
    <footer class="footer mt-auto py-3 bg-light ">
        <div class="container">
            <?php if ($this->countModules('footer')) : ?>
                <jdoc:include type="modules" name="footer" style="none" />
            <?php endif; ?>
        </div>
    </footer>

    <?php // Include any debugging info ?>
	<jdoc:include type="modules" name="debug" style="none" />
</body>
</html>
