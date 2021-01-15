<?php

if(!function_exists('nav_item')){

    function  nav_item(string $lien, string $title, string $linkClass=''): string
    {
        $classe = 'nav-item';
        if($_SERVER['SCRIPT_NAME'] === $lien){
            $classe .= ' active';
        }
    return '<li class="' . $classe . '">
        <a class="'.$linkClass.'" href="' . $lien . '">' . $title . '</a>
      </li>';
    }
}

if(!function_exists('nav_item_children')){

    function  nav_item_children(string $item, string $lien, string $title, string $linkClass=''): string
    {
        $classe = 'nav-item';
        if($_SERVER['SCRIPT_NAME'] === $lien){
            $classe .= ' active';
        }
    return '<li class="' . $classe . '">
        <a class="'.$linkClass.'" href="' . $lien . '">' . $title . '</a>
      </li>';
    }
}


?>