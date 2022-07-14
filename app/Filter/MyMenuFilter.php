<?php

namespace App\Filter;

use JeroenNoten\LaravelAdminLte\Menu\Filters\FilterInterface;

class MyMenuFilter implements FilterInterface
{
    public function transform($item)
    {
        $as = auth()->user()->role_id;
        if (isset($item['permission']) && $item['permission'] != $as) {
            $item['show'] = false;
        }
//        echo "<pre>";print_r($item);echo "</pre>";
        return $item;
    }
}
