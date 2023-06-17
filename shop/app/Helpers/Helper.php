<?php

namespace App\Helpers;
use Illuminate\Support\Str;

class Helper {
    // lấy danh sách các danh mục và đưa vào table ở view admin/menu/list
    public static function menu($menus, $parent_id=0, $char='') {
        $html = '';
        foreach($menus as $key => $menu) {
            if($menu->parent_id == $parent_id) {
                $html .= '
                    <tr>
                        <td>'. $menu->id .'</td>
                        <td>'. $char . $menu->name .'</td>
                        <td>'. self::active($menu->active) .'</td>
                        <td>'. $menu->updated_at .'</td>
                        <td>
                            <a class="btn btn-primary btn-sm" href="/admin/menus/edit/'. $menu->id .'">
                                <i class="fas fa-edit"></i>
                            </a>
                            <a class="btn btn-danger btn-sm" href="#"
                            onclick="RemoveRow('. $menu->id .', \'/admin/menus/destroy\')">
                                <i class="fas fa-trash"></i>
                            </a>
                        </td>
                    </tr>
                ';

                // sau khi lấy đc data từ vị trí $menus[$key] thì xóa nó đi
                unset($menus[$key]);
                // đệ quy để lấy hết danh sách
                // &emsp; là 4 lần space và $char để thụt đầu dòng -> thể hiện danh mục con
                $html .= self::menu($menus, $menu->id, $char .'&emsp;&emsp; |-- ');
            }
        }
        return $html;
    }


    // custom giao diện cho active với id=1 là yes và 0 là no
    public static function active($active = 0) {
        return $active = 0 ? '<span class="btn btn-danger btn-xs">No</span>' :
                    '<span class="btn btn-success btn-xs">Yes</span>';
    }


    // kiểm tra xem $id đưa vào có danh mục con hay không
    public static function isChild($menus, $id) {
        foreach($menus as $menu) {
            if($menu->parent_id == $id) {
                return true;
            }
        }
        return false;
    }


    // lấy danh sách các danh mục và đưa vào navbar ở view main/navbar
    public static function navbar($menus, $parent_id=0) {
        $html = '';
        foreach($menus as $key => $menu) {
            if($menu->parent_id == $parent_id) {
                $html .= '
                    <li>
                        <a href="/danh-muc/'. $menu->id. '-'. Str::slug($menu->name, '-'). '.html">
                            '. $menu->name. '
                        </a>';

                    // xóa data của $menu[$key] sau khi đã lấy data để làm nhẹ trang web -> load nhanh hơn
                    unset($menu[$key]);

                    // nếu có danh mục con thì tạo 1 sub-menu
                    if(self::isChild($menus, $menu->id)) {
                        $html .= '<ul class="sub-menu">';
                        $html .= self::navbar($menus, $menu->id);
                        $html .= '</ul>';
                    }

                    $html .= '</li>
                ';
            }
        }

        return $html;
    }


    //  lấy giá của sản phẩm để trả vè view main/product-list
    public static function price($price= 0, $priceSale= 0) {
        if($priceSale != 0)
            return number_format((int)$priceSale);

        elseif($price != 0)
            return number_format((int)$price);

        return '<a href="/lien-he.html">Liên hệ</a>';
    }


}
