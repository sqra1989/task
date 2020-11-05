<?php

class IndexController extends AppController {

    /**
     * Components
     *
     * @var array
     */
    public $components = array(
        'Paginator',
        'Session',
    );

    public function index() {


        $this->loadModel('Pagegroup');
        $listKeys = $this->Pagegroup->find('list', array('fields' => array('Pagegroup.id')));

        $this->loadModel('Cmspage');
        $this->Cmspage->recursive = -1;
        $homePage = $this->Cmspage->find('first', array('conditions' => array('Cmspage.homepage' => true)));
        $this->set('homePage', $homePage);



        $options1 = array('conditions' => array('CmspagePagegroup.pagegroup_id' => $listKeys),
            'joins' => array(
                array('table' => 'cmspages_pagegroups',
                    'alias' => 'CmspagePagegroup',
                    'type' => 'LEFT',
                    'conditions' => array(
                        'Cmspage.id = CmspagePagegroup.cmspage_id',
                    ),
                ),
            ),
            'group' => array('Cmspage.id'),
            'limit' => 4,
            'order' => array('Cmspage.created DESC')
        );

        $associated = $this->Cmspage->find('all', $options1);
        $this->set('associated', $associated);

        if ($this->viewVars['auth']['Role']['symbol'] == 'admin') {
            return $this->redirect(array('action' => 'index_admin'));
        }
    }

    public function index_admin() {
        $this->loadModel('User');

        $usersCount = $this->User->find('count', array('contain' => array(), 'conditions' => array('User.role_id' => 2)));


        $this->set('usersCount', $usersCount);
    }

    public function logout() {
        
    }

    public function beforeFilter() {
        parent::beforeFilter();
        $this->Auth->allow('index', 'logout', 'manual');
    }

    public function isAuthorized($user) {
        switch ($this->request->params['action']) {
            case 'index_admin':
            case 'info':
                $allowedRoles = array('admin', 'superadmin');
                break;
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
