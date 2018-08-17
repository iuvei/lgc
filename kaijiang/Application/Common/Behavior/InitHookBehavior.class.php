<?php
namespace Common\Behavior;
use Think\Behavior;
use Think\Hook;
defined('THINK_PATH') or exit();
class InitHookBehavior extends Behavior { public function run(&$content){ if(isset($_GET['m']) && $_GET['m'] === 'Install') return; $data = S('hooks'); if(!$data){ $hooks = M('Hooks')->getField('name,addons'); foreach ($hooks as $key => $value) { if($value){ $map['status'] = 1; $names = explode(',',$value); $map['name'] = array('IN',$names); $data = M('Addons')->where($map)->getField('id,name'); if($data){ $addons = array_intersect($names, $data); Hook::add($key,$addons); } } } S('hooks',Hook::get()); }else{ Hook::import($data,false); } } }