<?php
/**
 * @package     Joomla.Site
 * @subpackage  Templates.j4starter
 *
 * @copyright   (C) YEAR Your Name
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * This is a heavily stripped down/modified version of the default Cassiopeia template, designed to build new templates off of.
 */

defined('_JEXEC') or die;

use Joomla\CMS\Factory;
use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Uri\Uri;

/** @var Joomla\CMS\Document\HtmlDocument $this */

$app = Factory::getApplication();
$wa  = $this->getWebAssetManager();

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


//Register our web assets (Css/JS)
$wa->useStyle('template.j4starter.mainstyles');
$wa->useStyle('template.j4starter.user');
$wa->useScript('template.j4starter.scripts');

//Set viewport
$this->setMetaData('viewport', 'width=device-width, initial-scale=1');

?>
<!DOCTYPE html>
<html lang="<?php echo $this->language; ?>" dir="<?php echo $this->direction; ?>">
<head>
	<jdoc:include type="metas" />
	<jdoc:include type="styles" />
	<jdoc:include type="scripts" />
    
</head>

<body class="site <?php echo $pageclass; ?>">
	<header>
        <!-- Generate a Bootstrap Navbar for the top of our website and put the site title on it -->
        <nav class="navbar navbar-dark bg-dark navbar-expand-lg">
            <div class="container-fluid">
                <a href="" class="navbar-brand"><?php echo ($sitename); ?></a>
                <!-- Update 1.14 - Added support for mobile menu with bootstrap-->
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainmenu" aria-controls="mainmenu" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
                </button>
                <!-- Put menu links in the navbar - main menu must be in the "menu" position!!! Only supports top level and 1 down, so no more than 1 level of child items-->
                <?php if ($this->countModules('menu')): ?>
                <div class="collapse navbar-collapse" id="mainmenu"><jdoc:include type="modules" name="menu" style="none" /></div>

                <?php endif; ?>
            </div>
        </nav>
        <!-- Load Header Module if Module Exists -->
        <?php if ($this->countModules('header')) : ?>
            <div class="headerClasses">
                <jdoc:include type="modules" name="header" style="none" />
            </div>
        <?php endif; ?>
    </header>

    <!-- Generate the main content area of the website -->
    <main class="siteBody">
        <div class="container">
            <!-- Load Breadcrumbs Module if Module Exists -->
            <?php if ($this->countModules('breadcrumbs')) : ?>
                <div class="breadcrumbs">
                    <jdoc:include type="modules" name="breadcrumbs" style="none" />
                </div>
            <?php endif; ?>
            <div class="row">
                <!-- Use a BootStrap grid to load main content on left, sidebar on right IF sidebar exists -->
                <?php if ($this->countModules('sidebar')) : ?>
                <div class="col-xs-12 col-lg-8">

                    <main>
                        <!-- Load important Joomla system messages -->
                        <jdoc:include type="message" />
                        <!-- Load the main component of the webpage -->
                        <jdoc:include type="component" />
                    </main>
                </div>
                <!-- Load the sidebar if one exists -->
                <div class="col-xs-12 col-lg-4">
                        <!-- This line tells Joomla to load the "sidebar" module position with the "superBasicMod" mod chrome as the default (see html/layouts/chromes folder)-->
                        <jdoc:include type="modules" name="sidebar" style="superBasicMod" />
                </div>
                <!-- If there's no sidebar, just load the component with no sidebar-->
                <?php else: ?>
                    <!-- Load the main component of the webpage -->
                    <main>
                        <jdoc:include type="component" />
                    </main>
                <?php endif; ?>
            </div>
        </div>
    </main>

    <!-- Load Footer -->
    <footer class="footer mt-auto py-3 bg-light">
        <div class="container">
            <?php if ($this->countModules('footer')) : ?>
                <jdoc:include type="modules" name="footer" style="none" />
            <?php endif; ?>
        </div>
    </footer>

    <!-- Include any debugging info -->
	<jdoc:include type="modules" name="debug" style="none" />
</body>
</html>
