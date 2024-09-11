<?php

use App\Helper\ModuleMetaData;
use App\Helper;


function module_dir($moduleName)
{
    return 'core/Modules/' . $moduleName . '/';
}


function cloudStorageExist(): bool
{
    return (moduleExists('CloudStorage') && isPluginActive('CloudStorage'));
}
