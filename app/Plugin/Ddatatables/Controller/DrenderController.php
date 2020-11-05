<?php

App::uses('AppController', 'Controller');

/**
 * Ddatatables Controller
 *
 * @property PaginatorComponent $Paginator
 * @property FlashComponent $Flash
 * @property SessionComponent $Session
 */
class DrenderController extends DdatatablesAppController {

    public $uses = array("Ddatatables.Ddatatable");
    
    
}
