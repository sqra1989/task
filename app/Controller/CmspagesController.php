<?php

App::uses('AppController', 'Controller');

/**
 * Cmspages Controller
 *
 * @property Cmspage $Cmspage
 * @property PaginatorComponent $Paginator
 * @property FlashComponent $Flash
 * @property SessionComponent $Session
 */
class CmspagesController extends AppController {

    /**
     * Components
     *
     * @var array
     */
    public $components = array(
        'Paginator',
        'Session',
        'Flash',
        'DataTable.DataTable' => array(
            'mypages' => array(
                'debug' => true,
                'model' => 'Cmspage',
                'title' => 'Strony',
                'columns' => array(
                    'id' => array(
                        'type' => 'text',
                        'label' => 'ID',
                        'elementClass' => 'form-control',
                    ),
                    'title' => array(
                        'type' => 'text',
                        'label' => 'Nazwa',
                        'elementClass' => 'form-control',
                    ),
                    'Homepage' => array(
                        'type' => 'text',
                        'label' => 'Strona główna',
                        'useField' => false,
                        'elementClass' => 'form-control',
                    ),
                    'Menu' => array(
                        'type' => 'text',
                        'label' => 'W menu',
                        'useField' => false,
                        'elementClass' => 'form-control',
                    ),
                    'Footer' => array(
                        'type' => 'text',
                        'label' => 'W stopce',
                        'useField' => false,
                        'elementClass' => 'form-control',
                    ),
                    /* 'datehide' => array(
                      'type' => 'text',
                      'label' => 'Ukryta data',
                      'useField' => false,
                      'elementClass' => 'form-control',
                      ), */
                    'position' => array(
                        'type' => 'text',
                        'label' => 'Pozycja w menu',
                        'elementClass' => 'form-control',
                    ),
                  
                    'Actions' => [
                        'useField' => false,
                        'label' => 'Actions',
                        'actions' => [
                            'edit' => [
                                'class' => 'green',
                                'name' => "Edit",
                            ],
                            'delete' => [
                                'class' => 'red',
                                'name' => "Delete",
                            ],
                        ]
                    ],
                ),
                /* 'joins' => array(
                  array('table' => 'cmspages_pagegroups',
                  'alias' => 'CmspagePagegroup',
                  'type' => 'LEFT',
                  'conditions' => array(
                  'Cmspage.id = CmspagePagegroup.cmspage_id',
                  ),
                  ),
                  array('table' => 'pagegroups',
                  'alias' => 'Pagegroup',
                  'type' => 'LEFT',
                  'conditions' => array(
                  'Pagegroup.id = CmspagePagegroup.pagegroup_id',
                  ),
                  )
                  ), */
                'fields' => array('Cmspage.*'),
                'autoData' => false,
                'autoRender' => false
            ),
        )
    );

    /**
     * index method
     *
     * @return void
     */
    public function index() {
        $this->_index($this->Cmspage, 'mypages');
        $this->loadModel('Pagegroup');
        $this->set('groups', $this->Pagegroup->find('list'));
    }

    /**
     * view method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function view($id = null) {
        if (!$this->Cmspage->exists($id)) {
            throw new NotFoundException(__('Invalid cmspage'));
        }
        $options = array('conditions' => array('Cmspage.' . $this->Cmspage->primaryKey => $id),
            'contain' => array(
                'Pagegroup' => array(
                    'limit' => 1,
                )
        ));
        $cmsPage = $this->Cmspage->find('first', $options);
        $this->set('cmspage', $cmsPage);
        $associated = false;
        if ($cmsPage['Pagegroup']) {
            $options1 = array('conditions' => array('NOT' => array('Cmspage.id' => $id), 'CmspagePagegroup.pagegroup_id' => $cmsPage['Pagegroup'][0]['id']),
                'joins' => array(
                    array('table' => 'cmspages_pagegroups',
                        'alias' => 'CmspagePagegroup',
                        'type' => 'LEFT',
                        'conditions' => array(
                            'Cmspage.id = CmspagePagegroup.cmspage_id',
                        ),
                    ),
                ),
                'limit' => 4,
                'order' => array('Cmspage.created DESC')
            );
            $associated = $this->Cmspage->find('all', $options1);
        }
        $this->set('associated', $associated);

        if ($cmsPage['Cmspage']['loggedonly'] == 1 && $this->viewVars['auth'] == null) {
            $this->Session->write('backUrl', '/strona/' . $id . '/' . $this->getSlug($cmsPage['Cmspage']['title']));
            $this->Session->setFlash(__('Musisz się zalogować, aby przeglądać zawartość tego wpisu'), 'default', array('class' => 'alert alert-danger'));
            $this->redirect(array('controller' => 'users', 'action' => 'login'));
        }
    }

    /**
     * add method
     *
     * @return void
     */
    public function gallery($id = null) {
        // var_dump($this->request->data); exit;




        $src2 = WWW_ROOT . 'img/thumbs/gallery/' . $id;
        $dbsource2 = '/img/thumbs/gallery/' . $id;
        $image2 = array();
        foreach ($this->request->data['Cmspage']['file'] as $item) {

            //var_dump($item); exit;
           // $image2[] = $this->uploadImage($item['name'], $src2, $dbsource2, $item, 1500, 1500, false);
        }
        if (in_array(false, $image2)) {
            $this->Session->setFlash(__('Błąd. nie wszystkie zdjęcia zostały przesłane poprawnie'), 'default', array('class' => 'alert alert-danger'));
        } else {
            $this->Session->setFlash(__('Poprawnie przesłano wszystkie zdjęcia'), 'default', array('class' => 'alert alert-success'));
        }
        return $this->redirect(array('action' => 'edit', $id));
    }

    public function add() {
        if ($this->request->is('post')) {
            $this->Cmspage->create();
            $this->request->data['Cmspage']['footer'] = false;

            $this->request->data['Cmspage']['url'] = $this->getSlug($this->request->data['Cmspage']['title']);
            if ($this->Cmspage->save($this->request->data)) {




                $this->Session->setFlash(__('The cmspage has been saved.'), 'default', array('class' => 'alert alert-success'));
                return $this->redirect(array('action' => 'edit', $this->Cmspage->getLastInsertID()));
            } else {
                $this->Session->setFlash(__('The cmspage could not be saved. Please, try again.'), 'default', array('class' => 'alert alert-danger'));
            }
        }
        $pagegroups = $this->Cmspage->Pagegroup->find('list');
        $this->set(compact('pagegroups'));
    }

    /**
     * edit method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function edit($id = null) {
        if (!$this->Cmspage->exists($id)) {
            throw new NotFoundException(__('Invalid cmspage'));
        }
        if ($this->request->is(array('post', 'put'))) {

            $options = array('conditions' => array('Cmspage.' . $this->Cmspage->primaryKey => $id), 'contain' => array());
            $cmsPage = $this->Cmspage->find('first', $options);


            if (isset($this->request->data['Cmspage']['title'])) {
                $this->request->data['Cmspage']['url'] = $this->getSlug($this->request->data['Cmspage']['title']);
            }
            if (isset($this->request->data['Cmspage']['sections_update'])) {

                $saveArray = array();
                if ($cmsPage['Cmspage']['sections']) {
                    $saveArray = unserialize($cmsPage['Cmspage']['sections']);
                }

                for ($i = 0; $i < 10; $i++) {
                    $saveArray[$i]['sections'] = $this->request->data['Cmspage']['sections_' . $i];
                    $saveArray[$i]['class'] = $this->request->data['Cmspage']['class_' . $i];
                    unset($this->request->data['Cmspage']['sections_' . $i]);
                }

                for ($i = 0; $i < 10; $i++) {
                    //var_dump($this->request->data['Cmspage']['image_' . $i]); exit;
                    if (isset($this->request->data['Cmspage']['image_' . $i]) && $this->request->data['Cmspage']['image_' . $i]['size'] != 0) {
                        $src = WWW_ROOT . 'img/thumbs/pages/' . $this->Cmspage->field('id') . '/sections';
                        $srcbig = WWW_ROOT . 'img/thumbs/pages/big' . $this->Cmspage->field('id') . '/sections';
                        $dbsource = '/img/thumbs/pages/' . $this->Cmspage->field('id') . '/sections';
                        //$image = $this->uploadImage($this->Cmspage->field('title'), $src, $dbsource, $this->request->data['Cmspage']['image_' . $i], 550, 550, false, true);

                        if ($image) {
                            $saveArray[$i]['image'] = $image['big'];
                            //$this->Cmspage->saveField('image', $image['thumb']);
                            //$this->Cmspage->saveField('imagebig', $image['big']);
                        }
                    }
                }


                $this->request->data['Cmspage']['sections'] = serialize($saveArray);
            }




            if ($this->Cmspage->save($this->request->data)) {

                if (isset($this->request->data['Cmspage']['fooderimage'])) {
                    $src = WWW_ROOT . 'img/thumbs/pages/' . $this->Cmspage->field('id');
                    $srcbig = WWW_ROOT . 'img/thumbs/pages/big' . $this->Cmspage->field('id');
                    $dbsource = '/img/thumbs/pages/' . $this->Cmspage->field('id');
                    //$image = $this->uploadImage($this->Cmspage->field('title'), $src, $dbsource, $this->request->data['Cmspage']['fooderimage'], 550, 550, true, true);

                    /*if ($image) {
                        $this->Cmspage->saveField('image', $image['thumb']);
                        $this->Cmspage->saveField('imagebig', $image['big']);
                    }*/
                }


                $this->Session->setFlash(__('Zapisano poprawnie.'), 'default', array('class' => 'alert alert-success'));
                return $this->redirect(array('action' => 'edit', $id));
            } else {
                $this->Session->setFlash(__('The cmspage could not be saved. Please, try again.'), 'default', array('class' => 'alert alert-danger'));
            }
        } else {
            $options = array('conditions' => array('Cmspage.' . $this->Cmspage->primaryKey => $id), 'contain' => array('Pagegroup'));
            $array = $this->Cmspage->find('first', $options);
            if ($array['Cmspage']['sections']) {
                foreach (unserialize($array['Cmspage']['sections']) as $key => $item) {
                    $array['Cmspage']['sections_' . $key] = $item['sections'];
                    $array['Cmspage']['class_' . $key] = $item['class'];
                    if (isset($item['image'])) {
                        $array['Cmspage']['image_' . $key] = $item['image'];
                    }
                }
            }

            $this->request->data = $array;
        }
        $dir = new Folder(WWW_ROOT . 'img/thumbs/gallery/' . $id . '/');
        $files = $dir->find('.*\.jpg');
        $filespng = $dir->find('.*\.png');
        $this->set('files', array_merge($files, $filespng));
        $cmspage = $this->Cmspage->find('first', array('conditions' => array('Cmspage.id' => $id)));
        $pagegroups = $this->Cmspage->Pagegroup->find('list');
        $this->set(compact('pagegroups', 'cmspage', 'id'));
    }

    /**
     * delete method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function delete($id = null) {
        $this->Cmspage->id = $id;
        if (!$this->Cmspage->exists()) {
            throw new NotFoundException(__('Invalid cmspage'));
        }
        $this->request->onlyAllow('post', 'delete');
        if ($this->Cmspage->delete()) {
            $this->Session->setFlash(__('The cmspage has been deleted.'), 'default', array('class' => 'alert alert-success'));
        } else {
            $this->Session->setFlash(__('The cmspage could not be deleted. Please, try again.'), 'default', array('class' => 'alert alert-danger'));
        }
        return $this->redirect(array('action' => 'index'));
    }

    public function beforeFilter() {
        parent::beforeFilter();
        // Allow everything to not logged user except admin pages
        if (isset($this->params["admin"]) && $this->params["admin"]) {
            $this->Auth->deny();
        } else {
            $this->Auth->allow(array('view'));
        }
    }

    public function isAuthorized($user) {

        switch ($this->request->params['action']) {
            default :
                $allowedRoles = array('admin');
                break;
        }

        if (in_array($user['Role']['symbol'], $allowedRoles)) {
            return TRUE;
        } else {
            return FALSE;
        }
        //parent::isAuthorized($user);
    }

}
