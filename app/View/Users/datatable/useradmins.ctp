<?php

foreach ($dtResults as &$result) {
    
    
    if($result['User']['status']){
        $result['User']['status']='Aktywny';
    }else{
        $result['User']['status']='Nieaktywny';
    }
    
     
     
    
     //= Configure::read('Config.userStatuses.' . $result['User']['status']).$result['User']['status'];
    $result['Role']['id'] = $result['Role']['nazwa'];
    if ($result['Role']['symbol'] == 'user') {
        $loginAs = $this->Html->link(__('Login As'), array('controller' => 'users', 'action' => 'login_as', $result['User']['id']), array('class' => 'btn purple btn-xs'));
    
    }elseif($result['Role']['symbol'] == 'admin'&&$this->viewVars['auth']['role_id']==='3'){
        $loginAs = $this->Html->link(__('Login As'), array('controller' => 'users', 'action' => 'login_as', $result['User']['id']), array('class' => 'btn purple btn-xs'));
     
      
    } else {
        $loginAs = '';
    }
    $result['Actions'] = $loginAs .
            $this->Html->link(__('Edit'), array('controller' => 'users', 'action' => 'edit', $result['User']['id']), array('class' => 'btn green btn-xs'));
}

echo $this->element('datatable/default', compact(['dtResults', 'config']));
