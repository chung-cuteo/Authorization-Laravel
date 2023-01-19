<?php
function isRole($datas, $moduleName, $role = 'view')
{
    if (!empty($datas[$moduleName])) {
        $roleArr = $datas[$moduleName];
        if (!empty($roleArr) && in_array($role, $roleArr)) {
            return true;
        }

        return false;
    }
}
