<?php
namespace Home\Controller;

use Think\Controller;
class EmptyController extends Controller{
 
    public function _empty()
    {
        header("Location:".__ROOT__."/404.html");
        die;
    }
}

?>