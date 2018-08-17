<?php
 namespace Common\Api;
 class CategoryApi
 {
     public static function get_category($id, $field = null)
     {
         static $list; if(empty($id) || !is_numeric($id))
         {
             return '';
         }
         if(empty($list)){
             $list = S('sys_category_list');
         }
         if(!isset($list[$id])){
             $cate = M('Category')->find($id);
             if(!$cate || 1 != $cate['status']){
                 return '';
             }
             $list[$id] = $cate; S('sys_category_list', $list);
         }
         return is_null($field) ? $list[$id] : $list[$id][$field];
     }
     public static function get_category_name($id){
         return get_category($id, 'name');
     }
     public static function get_category_title($id){
         return get_category($id, 'title');
     }
     public static function get_parent_category($cid){
         if(empty($cid)){
             return false;
         }
         $cates = M('Category')->where(array('status'=>1))->field('id,title,pid')->order('sort')->select();
         $child = get_category($cid); $pid = $child['pid'];
         $temp = array(); $res[] = $child; while(true){
             foreach ($cates as $key=>$cate){
                 if($cate['id'] == $pid){
                     $pid = $cate['pid']; array_unshift($res, $cate);
             }
             }
             if($pid == 0){
                 break;
             }
         }
         return $res;
     }
 }