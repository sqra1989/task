<?php

foreach ($dtResults as &$result) {


    if ($result['User']['status']) {
        $result['User']['status'] = 'Aktywny';
    } else {
        $result['User']['status'] = 'Nieaktywny';
    }
    //= Configure::read('Config.userStatuses.' . $result['User']['status']).$result['User']['status'];
    $result['Role']['id'] = $result['Role']['nazwa'];
    if ($result['Role']['symbol'] == 'user') {
        $loginAs = $this->Html->link(__('Login As'), array('controller' => 'users', 'action' => 'login_as', $result['User']['id']), array('class' => 'btn purple btn-xs'));
    } elseif ($result['Role']['symbol'] == 'admin' && $this->viewVars['auth']['role_id'] === '3') {
        $loginAs = $this->Html->link(__('Login As'), array('controller' => 'users', 'action' => 'login_as', $result['User']['id']), array('class' => 'btn purple btn-xs'));
    } else {
        $loginAs = '';
    }

    $loginAs .= $this->Html->link(__('Edit'), array('controller' => 'users', 'action' => 'edit', $result['User']['id']), array('class' => 'btn green btn-xs'));


    $loginAs .= $this->Form->postLink(__('Delete'), array('controller' => 'users', 'action' => 'delete', $result['User']['id']), array('escape' => false, 'class' => 'btn red btn-xs'), __('Are you sure you want to delete %s?', $result['User']['name'] . ' ' . $result['User']['surname']));


    $result['Actions'] = $loginAs;
}

echo $this->element('datatable/default', compact(['dtResults', 'config']));
