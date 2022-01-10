<?php
class Utilities{
  
    public function getPaging($page, $total_rows, $records_per_page, $page_url){
  
        // niz paginacija
        $paging_arr=array();
  
        // dugme za prvu stranu
        $paging_arr["first"] = $page>1 ? "{$page_url}page=1" : "";
  
        // izbroj sve proizvode u bazi za izracunavanje ukupnog broja strana
        $total_pages = ceil($total_rows / $records_per_page);
  
        // tolerancija linkova za prikaz
        $range = 2;
  
        // ispisi linkove do 'tolerancije linkova' oko 'trenutne stranice'
        $initial_num = $page - $range;
        $condition_limit_num = ($page + $range)  + 1;
  
        $paging_arr['pages']=array();
        $page_count=0;
          
        for($x=$initial_num; $x<$condition_limit_num; $x++){
            // osiguraj se da je '$x vece od 0' i 'manje ili jednako $total_pages'
            if(($x > 0) && ($x <= $total_pages)){
                $paging_arr['pages'][$page_count]["page"]=$x;
                $paging_arr['pages'][$page_count]["url"]="{$page_url}page={$x}";
                $paging_arr['pages'][$page_count]["current_page"] = $x==$page ? "yes" : "no";
  
                $page_count++;
            }
        }
  
        // dugme za poslednju stranu
        $paging_arr["last"] = $page<$total_pages ? "{$page_url}page={$total_pages}" : "";
  
        // json format
        return $paging_arr;
    }
  
}
?>