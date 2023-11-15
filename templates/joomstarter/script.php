<?php

defined ( '_JEXEC' ) or die;

//the class name must match the "element" property in the extensions table of the database, or the field "name" in the xml file EXACTLY or the script will not run
class joomstarterInstallerScript
{

    public function install($parent) 
    {
        echo '<p> This is the install message called from the script.php file </p>';
    }

    public function uninstall($parent) 
    {
        echo '<p>This is the uninstall message called from script.php</p>';
    }

    public function update($parent) 
    {
        echo '<p>This is the update message called from script.php</p>';

    }


}