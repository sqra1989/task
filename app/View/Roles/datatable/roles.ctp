<?php


foreach ($dtResults as &$result) {

   
    
    $resultat='';
     if($result['Tasktype']){
         $resultat.='<ul class="tag-list">';
         foreach ($result['Tasktype'] as $substance){
             $resultat.='<li>'.$substance['name'].'</li>';
         }
         $resultat.='</ul>';
     }
    
    $result['Custom']=$resultat;
    
    
    $resultat='';
     if($result['Project']){
         $resultat.='<ul class="tag-list">';
         foreach ($result['Project'] as $substance){
             $resultat.='<li>'.$substance['name'].'</li>';
         }
         $resultat.='</ul>';
     }
    
    $result['Custom2']=$resultat;
    
    $resultat='';
    $resultat.='<ul class="tag-list">';
         $resultat.='<li>'.Configure::read('Config.rolePermisions')[$result['Role']['type']].'</li>';
    $resultat.='</ul>';
    
    $result['dodatkowe']=$resultat;
    
    $resultat='<a href="/roles/edit/'.$result['Role']['id'].'" class="btn btn-xs green">Edytuj</a>';
     //$resultat.='<a href="/czemar/pl/roles/view/'.$result['Role']['id'].'" class="btn btn-xs blue">Details</a>';
     if($result['Role']['id']!=2){
     $resultat.='<a href="/roles/delete/'.$result['Role']['id'].'" class="btn btn-xs red ajax post" data-question="Czy na pewno chcesz usunąć %s?">Usuń</a>';
     }
    $result['actions']=$resultat;

}

echo $this->element('datatable/default', compact(['dtResults', 'config']));
