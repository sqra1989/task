<?php


foreach ($dtResults as &$result) {

   
    $cats='<ul class="tags-list">';
    foreach($result['Pagegroup'] as $item){
        $cats.='<li>'.$item['name'].'</li>';
    }
    $cats.='</ul>';
    $result['Categoria']=$cats;
    
    if($result['Cmspage']['homepage']){
        $result['Homepage']='<i class="fa fa-check green"></i>';
    }
    if($result['Cmspage']['menu']){
        $result['Menu']='<i class="fa fa-check green"></i>';
    }
    if($result['Cmspage']['footer']){
        $result['Footer']='<i class="fa fa-check green"></i>';
    }
    

    
    
}

echo $this->element('datatable/default', compact(['dtResults', 'config']));
