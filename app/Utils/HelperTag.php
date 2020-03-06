<?php

namespace App\Utils;

use DB;

class HelperTag
{

    public static function showItem(int $selected = 5)
    {
        $result = '';
        $data   = [5, 10, 25, 50, 100];
        foreach ($data as $value) {
            $result .= '<option value="' . $value . '" ' . ($selected === $value ? 'selected' : '') . '>' . $value . '</option>';
        }

        return $result;
    }
    
    public static function roleSelect($selected = null)
    {
        $result = '';
        $roles = DB::table('roles')->select('id', 'name')->where('id', '!=', 1)->get();
        foreach ($roles as $role) {
            $result .= '<option value="' . $role->id . '" ' . ($selected === $role->id ? 'selected' : '') . '>' . $role->name . '</option>';
        }
        
        return $result;
    }
    
    public static function branchSelect($selected = null)
    {
        $result = '';
        $roles = DB::table('branches')->select('id', 'name')->whereNull('deleted_at')->get();
        foreach ($roles as $role) {
            $result .= '<option value="' . $role->id . '" ' . ($selected === $role->id ? 'selected' : '') . '>' . $role->name . '</option>';
        }
        
        return $result;
    }

}