<?php

App::uses('AppController', 'Controller');

/**
 * Users Controller
 *
 * @property User $User
 * @property PaginatorComponent $Paginator
 */
class UsersController extends AppController {

    public $uses = array('User', 'Role');

    /**
     * Components
     *
     * @var array
     */
    public $components = array(
        'Paginator',
        'Session',
        'DataTable.DataTable' => array(
            'User' => array(
                'debug' => false,
                'model' => 'User',
                'columns' => array(
                    'name' => array(
                        'type' => 'text',
                        'label' => 'Imię',
                        'elementClass' => 'form-control',
                    ),
                    'surname' => array(
                        'type' => 'text',
                        'label' => 'Nazwisko',
                        'elementClass' => 'form-control',
                    ),
                    'telefon' => array(
                        'type' => 'text',
                        'label' => 'Telefon',
                        'elementClass' => 'form-control',
                    ),
                    'email' => array(
                        'type' => 'text',
                        'label' => 'E-mail',
                        'elementClass' => 'form-control',
                    ),
                    'created' => array(
                        'type' => 'range',
                        'label' => 'Data utworzenia',
                        'elementClass' => 'form-control',
                    ),
                    'User.status' => array(
                        'type' => 'select',
                        'select2' => array(
                            'placeholder' => '',
                            'allowClear' => true
                        ),
                        'elementOptions' => 'statuses',
                        'label' => 'Status Konta',
                        'elementClass' => 'form-control',
                    ),

                    'Actions' => null,
                ),
                'contain' => array('Role'),
                'conditions' => array(
                    'User.role_id' => 2,
                ),
                'fields' => array('id', 'Role.name', 'Role.symbol'),
                'autoData' => false,
                'autoRender' => false
            ),
           
            'Useradmins' => array(
                'debug' => false,
                'model' => 'User',
                'title' => 'Administratorzy systemu',
                'columns' => array(
                    'name' => array(
                        'type' => 'text',
                        'label' => 'Imię',
                        'elementClass' => 'form-control',
                    ),
                    'surname' => array(
                        'type' => 'text',
                        'label' => 'Nazwisko',
                        'elementClass' => 'form-control',
                    ),
                    'email' => array(
                        'type' => 'text',
                        'label' => 'E-mail',
                        'elementClass' => 'form-control',
                    ),
                    'created',
                    'modified',
                    'User.status' => array(
                        'type' => 'select',
                        'select2' => array(
                            'placeholder' => '',
                            'allowClear' => true
                        ),
                        'elementOptions' => 'statuses',
                        'label' => 'Status Konta',
                        'elementClass' => 'form-control',
                    ),
                    'Actions' => null,
                ),
                'contain' => array('Role'),
                'conditions' => array(
                    'User.role_id' => 1
                ),
                'fields' => array('id', 'Role.name', 'Role.symbol'),
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
    public function userlogs($id = null) {
        $this->loadModel('User');
        $question = $this->User->find('first', array('conditions' => array('User.id' => $id),
            'contain' => array()));
        $this->loadModel('Historylog');
        $this->DataTable->settings['userloggs']['viewVars']['js'] = array(
            'sAjaxSource' => array('action' => 'processDataTableRequest', $this->request->pass[0]),
            'order' => array(array(0, "desc"))
        );
        $this->set('id', $id);
        $this->DataTable->settings['userloggs']['title'] = 'Powiadomienia dla użytkownika ' . $question['User']['id'] . '. ' . $question['User']['username'];
        $this->_index($this->Historylog, 'userloggs');
    }

    public function admins() {
        if ($this->viewVars['auth']['role_id'] == 3) {
            return $this->redirect(array('action' => 'all'));
        }
        $this->set('statuses', Configure::read('Config.userStatuses'));
        $this->set('roles', $this->Role->find('list', array(
                    'conditions' => array(
                        'NOT' => array(
                            'symbol' => 'superadmin'
                        )
                    ),
                    'order' => 'name ASC'
        )));
        $this->_index($this->User, 'Useradmins');
    }

   



    public function index() {
        if ($this->viewVars['auth']['role_id'] == 3) {
            return $this->redirect(array('action' => 'all'));
        }
    
     
        $this->set('statuses', Configure::read('Config.userStatuses'));
        $this->set('roles', $this->Role->find('list', array(
                    'conditions' => array(
                        'NOT' => array(
                            'symbol' => 'superadmin'
                        )
                    ),
                    'order' => 'name ASC'
        )));
        $this->_index($this->User);
    }

   

    public function profile() {

        $id = $this->Auth->user('id');

        $this->User->read(null, $id);
        if ($this->request->is(array('post', 'put'))) {
            // Do not change password if not requested or old password is incorrect
            if (array_key_exists('passwordnew', $this->request->data['User']) and array_key_exists('passwordnew2', $this->request->data['User'])) {
                if (!$this->isAdmin and $this->User->data['User']['password'] != AuthComponent::password($this->request->data['User']['oldpassword'])) {
                    $this->User->invalidate('oldpassword', __('Invalid old password'));
                    $this->Session->setFlash(__('Invalid old password'), 'flash', array('class' => 'alert alert-danger'));
                    return $this->redirect(array('action' => 'profile'));
                }
                if (empty($this->request->data['User']['passwordnew'])) {
                    $this->Session->setFlash(__('Invalid new password'), 'flash', array('class' => 'alert alert-danger'));
                    return $this->redirect(array('action' => 'profile'));
                }
                $this->User->data['User']['password'] = $this->request->data['User']['passwordnew'];
                $this->User->data['User']['password2'] = $this->request->data['User']['passwordnew2'];
            } else {
                unset($this->User->data['User']['password']);
                unset($this->User->data['User']['password2']);
            }

            $this->request->data['User']['id'] = $id;

            if (isset($this->request->data['User']['name']) && isset($this->request->data['User']['surname'])) {
                $this->request->data['User']['username'] = $this->request->data['User']['name'] . ' ' . $this->request->data['User']['surname'];
            }
            if ($this->isUser) {
                if (isset($this->request->data['User']['role_id'])) {
                    unset($this->request->data['User']['role_id']);
                }
                if (isset($this->request->data['User']['status'])) {
                    unset($this->request->data['User']['status']);
                }
            }
            unset($this->User->data['User']['modified']);
            $this->request->data['User'] = array_merge($this->User->data['User'], $this->request->data['User']);
            unset($this->request->data['User']['tokens']);
            unset($this->request->data['User']['created']);
            unset($this->request->data['User']['created']);
            unset($this->request->data['User']['verified']);

            if ($this->User->save($this->request->data)) {

                $this->Session->setFlash(__('The profile has been saved.'), 'flash', array('class' => 'alert alert-success'));
                return $this->redirect(array('action' => 'profile'));
            } else {
                /* var_dump($this->User->validationErrors);
                  exit; */
                $options = array('conditions' => array('User.' . $this->User->primaryKey => $id));
                $this->request->data = $this->User->find('first', $options);
                $this->Session->setFlash(__('The profile could not be saved. Please, try again.'), 'flash', array('class' => 'alert alert-danger'));
                return $this->redirect(array('action' => 'profile'));
            }
        } else {
            $options = array('conditions' => array('User.' . $this->User->primaryKey => $id));
            $this->request->data = $this->User->find('first', $options);
            $this->set('user', $this->request->data);
        }
    }

    public function user_profile() {

        $id = $this->Auth->user('id');
        $changeStatus = false;
        $this->User->read(null, $id);
        $options = array('conditions' => array('User.' . $this->User->primaryKey => $id));
        $thisUser = $this->User->find('first', $options);





        if ($this->request->is(array('post', 'put'))) {
            // Do not change password if not requested or old password is incorrect
            if (array_key_exists('passwordnew', $this->request->data['User']) and array_key_exists('passwordnew2', $this->request->data['User'])) {
                if (!$this->isAdmin and $this->User->data['User']['password'] != AuthComponent::password($this->request->data['User']['oldpassword'])) {
                    $this->User->invalidate('oldpassword', __('Invalid old password'));
                    $this->Session->setFlash(__('Invalid old password'), 'flash', array('class' => 'alert alert-danger'));
                    return $this->redirect(array('action' => 'user_profile'));
                }
                if (empty($this->request->data['User']['passwordnew'])) {
                    $this->Session->setFlash(__('Invalid new password'), 'flash', array('class' => 'alert alert-danger'));
                    return $this->redirect(array('action' => 'user_profile'));
                }
                $this->User->data['User']['password'] = $this->request->data['User']['passwordnew'];
                $this->User->data['User']['password2'] = $this->request->data['User']['passwordnew2'];
            } else {

                $this->User->data['User']['verified'] = 2;
                $changeStatus = true;
                $this->request->data['User']['username'] = $this->request->data['User']['name'] . ' ' . $this->request->data['User']['surname'];

                if ($thisUser['User']['type'] == 'b2b') {
                    $this->User->data['User']['verified'] = 3;
                    $changeStatus = false;
                    $this->request->data['User']['username'] = $thisUser['User']['company'] . '(' . $this->request->data['User']['name'] . ' ' . $this->request->data['User']['surname'] . ')';
                }
                unset($this->User->data['User']['password']);
                unset($this->User->data['User']['password2']);
            }

            $this->request->data['User']['id'] = $id;

            if ($this->isUser) {
                if (isset($this->request->data['User']['role_id'])) {
                    unset($this->request->data['User']['role_id']);
                }
                if (isset($this->request->data['User']['status'])) {
                    unset($this->request->data['User']['status']);
                }
            }
            unset($this->User->data['User']['modified']);
            $this->request->data['User'] = array_merge($this->User->data['User'], $this->request->data['User']);

            unset($this->User->data['User']['tokens']);
            if ($this->User->saveAll($this->request->data)) {


                $updatedUser = $this->User->find('first', array(
                    'conditions' => array(
                        'User.id' => $id,
                    ),
                    'contain' => array('Role')
                ));
                $userMerged = array_merge($updatedUser, $updatedUser['User']);


                $this->Session->write('Auth.User', $userMerged);
                if ($changeStatus) {
                    $this->sendMailStatusChangeUser($id);
                }
                $this->Session->setFlash(__('Dane zapisane.'), 'flash', array('class' => 'alert alert-success'));
                return $this->redirect(array('action' => 'user_profile'));
            } else {

                $this->request->data = $thisUser;
                $this->Session->setFlash(__('The user_profile could not be saved. Please, try again.'), 'flash', array('class' => 'alert alert-danger'));
            }
        } else {
            $options = array('conditions' => array('User.' . $this->User->primaryKey => $id));
            $this->request->data = $this->User->find('first', $options);

            $this->set('user', $this->request->data);
        }
    }

    /**
     * view method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function view($id = null) {
        if (!$this->User->exists($id)) {
            throw new NotFoundException(__('Invalid user'));
        }
        $this->loadModel("Chain");
        $chains = $this->Chain->Code->find('all', array(
            'conditions' => array(
                'Code.owner_user_id=' . $this->Auth->user('id'),
                'Code.code_referal_id' => NULL,
                'Code.complain' => null,
            ),
                //'group' => array('Code.chain_id')
        ));
        $options = array();
        foreach ($chains as $key => $chain) {

            $options[$chain['Chain']['id']] = $chain['Chain']['name'];
        }
        $this->set('chains', $options);
        $options = array('conditions' => array('User.' . $this->User->primaryKey => $id));
        $this->set('user', $this->User->find('first', $options));
    }

    /**
     * add method
     *
     * @return void
     */
    public function add($role = false) {
        if ($this->request->is('post')) {

            $this->User->create();
            $this->request->data['User']['verified'] = 3;
            $this->request->data['User']['username'] = $this->request->data['User']['name'] . ' ' . $this->request->data['User']['surname'];

            $terms = $this->setAgreements($this->request->data['User']);

            if (!$terms) {
                $this->Session->setFlash(__('Zatwierdź wymagane zgody.'), 'flash', array('class' => 'alert alert-danger'));
                return $this->redirect(array('action' => 'register'));
            }
            $this->request->data['User']['terms'] = $terms;
            unset($this->request->data['User']['term1']);
            unset($this->request->data['User']['term3']);
            unset($this->request->data['User']['term2']);


            if ($role == 'b2b') {
                $this->request->data['User']['type'] = 'b2b';
                $this->request->data['User']['role_id'] = 2;
                $this->request->data['User']['tokens'] = 0;
                $this->request->data['User']['username'] = $this->request->data['User']['company'] . '(' . $this->request->data['User']['name'] . ' ' . $this->request->data['User']['surname'] . ')';
            }

            $passwordHash = md5($this->request->data['User']['email'] . uniqid());
            $this->request->data['User']['password'] = $passwordHash;
            $this->request->data['User']['password2'] = $passwordHash;
            if ($this->User->save($this->request->data)) {
                $this->Session->setFlash(__('Dodano użytkownika. Email z danymi do logowania został wysłany do użytkownika'), 'flash', array('class' => 'alert alert-success'));


                $email = new CakeEmail();
                $email->emailFormat('html');
                $email->template('createuser', Configure::read('App.theme'))->viewVars(array(
                    'title' => __('Dodano nowego użytkownika'),
                    'login' => $this->request->data['User']['email'],
                    'password' => $passwordHash,
                        //'shop' => $this->viewVars['technicalSystemInfo'],
                ));

                $email->from(Configure::read('NotifyEmail.from'));
                $email->to($this->request->data['User']['email']);
                $email->bcc(Configure::read('NotifyEmail.to'));
                $email->subject(__('Dodano nowego użytkownika w ') . Configure::read('App.name'));

                if ($email->send()) {
                    $this->addHistoryLog($this->User->getLastInsertId(), '', __('Dodano nowego użytkownika ') . $this->request->data['User']['email'], null);
                }
                if ($this->request->data['User']['role_id'] == 2 && $this->request->data['User']['type'] = 'b2b') {
                    return $this->redirect(array('action' => 'edit_b2b', $this->User->getLastInsertId()));
                }
                return $this->redirect(array('action' => 'edit', $this->User->getLastInsertId()));
            } else {
                $this->Session->setFlash(__('Please correct form errors.'), 'flash', array('class' => 'alert alert-danger'));
            }
        }

        $this->set('role', $role);
        $roleList = $this->Role->find('list', array(
            'conditions' => array(
                'NOT' => array(
                    'symbol' => 'superadmin'
                )
            ),
            'order' => 'name ASC'
        ));

        $this->set('roles', $roleList);
    }

   

    public function edit($id = NULL) {
        if (is_null($id)) {
            $id = $this->Auth->user('id');
        }
        $this->User->read(null, $id);
        if (!$this->User->exists($id)) {
            throw new NotFoundException(__('Invalid user'));
        }
        $options = array('conditions' => array('User.' . $this->User->primaryKey => $id));
        $thisUser = $this->User->find('first', $options);
 
        $this->set('thisUser', $thisUser);
        if ($thisUser['User']['type'] == 'b2b') {
            return $this->redirect(array('action' => 'edit_b2b', $id));
        }
        if ($this->request->is(array('post', 'put'))) {
            // Do not change password if not requested or old password is incorrect
            if (array_key_exists('passwordnew', $this->request->data['User']) and array_key_exists('passwordnew2', $this->request->data['User'])) {
                if (!$this->isAdmin and $this->User->data['User']['password'] != AuthComponent::password($this->request->data['User']['oldpassword'])) {
                    $this->User->invalidate('oldpassword', __('Invalid old password'));
                    $this->Session->setFlash(__('Invalid old password'), 'flash', array('class' => 'alert alert-danger'));
                    return $this->redirect(array('action' => 'edit', $id));
                }
                if (empty($this->request->data['User']['passwordnew'])) {
                    $this->Session->setFlash(__('Invalid new password'), 'flash', array('class' => 'alert alert-danger'));
                    return $this->redirect(array('action' => 'edit', $id));
                }
                $this->User->data['User']['password'] = $this->request->data['User']['passwordnew'];
                $this->User->data['User']['password2'] = $this->request->data['User']['passwordnew2'];
            } else {
                unset($this->User->data['User']['password']);
                unset($this->User->data['User']['password2']);
            }

            $this->request->data['User']['id'] = $id;
            if(isset($this->request->data['User']['name']) && isset($this->request->data['User']['surname'])){
            $this->request->data['User']['username'] = $this->request->data['User']['name'] . ' ' . $this->request->data['User']['surname'];
            }
            if ($this->isUser) {
                if (isset($this->request->data['User']['role_id'])) {
                    unset($this->request->data['User']['role_id']);
                }
                if (isset($this->request->data['User']['status'])) {
                    unset($this->request->data['User']['status']);
                }
            }
            unset($this->User->data['User']['modified']);
            $this->request->data['User'] = array_merge($this->User->data['User'], $this->request->data['User']);


           




            if ($this->User->save($this->request->data)) {

               

                $this->Session->setFlash(__('The user has been saved.'), 'flash', array('class' => 'alert alert-success'));
                return $this->redirect(array('action' => 'edit', $id));
            } else {
                //debug($this->User->validationErrors); die();
                $options = array('conditions' => array('User.' . $this->User->primaryKey => $id));
                $this->request->data = $this->User->find('first', $options);
                $this->Session->setFlash(__('The user could not be saved. Please, try again.'), 'flash', array('class' => 'alert alert-danger'));
            }
        } else {

            $this->request->data = $thisUser;
        }
        $this->set('roles', $this->User->Role->find('list', array(
                    'conditions' => array(
                        'NOT' => array(
                            'symbol' => 'superadmin'
                        )
                    ),
                    'order' => 'name ASC'
        )));
    }

    /**
     * delete method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function registered() {
        
    }

    public function registered_firmowe() {
        
    }

    public function delete($id = null) {
        $this->User->id = $id;
        if (!$this->User->exists()) {
            throw new NotFoundException(__('Invalid user'));
        }
        $this->User->recursive = -1;
        $type = $this->User->find('first', array('conditions' => array('User.id' => $id)));
        $this->request->allowMethod('post', 'delete');

        if ($this->User->delete()) {
            $this->Session->setFlash(__('The user has been deleted.'), 'flash', array('class' => 'alert alert-success'));
        } else {
            $this->Session->setFlash(__('The user could not be deleted. Please, try again.'), 'flash_info');
        }
  
        return $this->redirect(array('action' => 'index'));
    }



  

    public function login($email = null) {

        if ($this->Session->read('backUrl')) {
            $backUrl = $this->Session->read('backUrl');
        }
        if ($this->Auth->loggedIn()) {
            return $this->redirect(array('controller' => 'index', 'action' => 'index'));
        }

        if ($this->request->is(array('post', 'put'))) {


       
            // User status check
            $user = $this->User->find('first', array(
                'conditions' => array(
                    'User.email' => $this->request->data['User']['email']
                ),
                'contain' => array(
                    'Role'
                )
            ));



            if (!empty($user)) {
                switch ((string) $user['User']['status']) {
                    case '1':
                        // Account active

                        if ($this->Auth->login()) {
                      
                            if ($this->request->data['User']['remember_me'] == 1) {
                                unset($this->request->data['User']['remember_me']);
                                $cookieArray = $this->request->data['User'];
                                $cookieArray['password'] = AuthComponent::password($cookieArray['password']);
                                $this->Cookie->write('remember_me_cookie', $cookieArray, true, '2 weeks');
                            }
                            $this->User->id = $this->Auth->user('id');


                            if ($this->User->field('role_id') == '1') {
                                $this->Session->setFlash(__('Poprawne logowanie'), 'flash', array('class' => 'alert alert-success'));
                                return $this->redirect(array('controller' => 'index', 'action' => 'index_admin'));
                            } elseif ($this->User->field('role_id') == '3') {
                                $this->Session->setFlash(__('Poprawne logowanie'), 'flash', array('class' => 'alert alert-success'));
                                return $this->redirect(array('controller' => 'index', 'action' => 'index'));
                            } elseif ($this->User->field('role_id') == '2') {
                                $this->Session->setFlash(__('Poprawne logowanie'), 'flash', array('class' => 'alert alert-success'));
                                /* if (isset($backUrl)) {
                                  return $this->redirect($backUrl);
                                  } */
                                return $this->redirect(array('controller' => 'questionnaires', 'action' => 'all'));
                            } else {
                                //return $this->redirect($this->viewVars['backurl']);
                                return $this->redirect(array('controller' => 'index', 'action' => 'index'));
                            }
                        } else {
                         
                            $this->Session->setFlash(__('Nieprawidłowy email lub hasło'), 'flash', array('class' => 'alert alert-danger'));
                            if (isset($this->request->data['User']['normallogin'])) {
                                return $this->redirect(array('controller' => 'index', 'action' => 'index', '#' => 'logowanie'));
                            }
                        }
                        break;
                    case '2':
                        // Account banned
                        $this->Session->setFlash(__('This account has been baned'), 'flash', array('class' => 'alert alert-danger'));
                        if (isset($this->request->data['User']['normallogin'])) {
                            return $this->redirect(array('controller' => 'index', 'action' => 'index', '#' => 'logowanie'));
                        }
                        break;
                    default :
                        // Account not activated
                        $this->Session->setFlash(__('Account is not activated'), 'flash', array('class' => 'alert alert-danger'));
                        if (isset($this->request->data['User']['normallogin'])) {
                            return $this->redirect(array('controller' => 'index', 'action' => 'index', '#' => 'logowanie'));
                        }
                        break;
                }
            } else {
           
                $this->Session->setFlash(__('Brak użytkownika'), 'flash', array('class' => 'alert alert-danger'));
                if (isset($this->request->data['User']['normallogin'])) {
                    return $this->redirect(array('controller' => 'index', 'action' => 'index'));
                }
            }
        }
    }

    public function login_as($id, $question_id = false) {
        $adminId = $this->Session->read('Auth.User.id');
        $user = $this->User->find('first', array(
            'conditions' => array(
                'User.id' => $id,
            ),
            'contain' => array('Role')
        ));
        $user = array_merge($user, $user['User']);

        if ($user && !$this->Auth->login($user)) {
            $this->redirect('/users/logout'); // Destroy session & cookie
        } else {
            $this->User->id = $this->Auth->user('id');
        }
        if (!$this->Session->read('Auth.Admin.id')) {
            $this->Session->write('Auth.Admin.id', $adminId);
        } else {
            $this->Session->delete('Auth.Admin.id');
        }
        $this->backupRestoreSession();

        if ($this->Auth->user('role_id') == 1) {

            return $this->redirect(array('controller' => 'index', 'action' => 'index'));
        }
        return $this->redirect(array('controller' => 'index', 'action' => 'index'));
    }

    public function notifications() {
        $this->loadModel('Historylog');

        $id = $this->viewVars['auth']['id'];
        $userLogs = $this->Historylog->find('all', array(
            'conditions' => array('Historylog.user_id' => $id, 'Historylog.guestionnarie_id' => null),
            'order' => array('created DESC')
                )
        );
        $this->set('userLogs', $userLogs);


        $userWnioski = $this->Historylog->find('all', array(
            'conditions' => array('Historylog.user_id' => $id, 'NOT' => array('Historylog.guestionnarie_id' => null)),
            'order' => array('created DESC')
                )
        );
        $this->set('userWnioski', $userWnioski);


        $this->Historylog->updateAll(array('read' => 1), array('Historylog.user_id' => $id));
    }

    public function logouts() {
        if ($this->Auth->loggedIn()) {
            if ($this->Session->read('Auth.Admin.id')) {
                $this->Session->setFlash(__('Wylogowałeś się z konta usera'), 'flash', array('class' => 'alert alert-success'));
                return $this->login_as($this->Session->read('Auth.Admin.id'));
            } else {
                $this->Cookie->delete('remember_me_cookie');
                $this->Session->destroy();
                $this->Session->setFlash(__('Wylogowałeś się'), 'flash', array('class' => 'alert alert-success'));
                return $this->redirect($this->Auth->logout());
            }
        } else {
            $this->Session->setFlash(__('Jesteś wylogowany'), 'flash', array('class' => 'alert alert-success'));
            return $this->redirect(array('action' => 'login'));
        }
    }

    private function backupRestoreSession() {
        $sessionBackup = $this->Session->read('_SessionCopy_'); // Created session backup
        // Remove session values
        $sessionCopy = $this->Session->read(); // Session copy
        foreach ($sessionCopy as $k => $v) {
            if (in_array($k, array('Config', 'Auth'))) { // CakePHP session values
                unset($sessionCopy[$k]);
            } else {
                $this->Session->delete($k);
            }
        }

        if (!is_null($sessionBackup) and is_array($sessionBackup)) {
            // Restore session
            foreach ($sessionBackup as $k => $v) {
                $this->Session->write($k, $v);
            }
        } else {
            // Backup session
            $this->Session->write('_SessionCopy_', $sessionCopy);
        }
    }

   



    public function register() {

        if ($this->request->is('post')) {
            $this->request->data['User']['username'] = $this->request->data['User']['name'] . ' ' . $this->request->data['User']['surname'];

            $this->User->set($this->request->data);

            if ($this->User->validates()) {

                $this->User->data['User']['status'] = false;
                $this->User->data['User']['role_id'] = 2;
 
                $this->request->data['User']['username'] = $this->request->data['User']['name'] . ' ' . $this->request->data['User']['surname'];

                if ($this->request->data['User']['type'] == 'b2b') {
                    $this->request->data['User']['username'] = $this->request->data['User']['company'] . '(' . $this->request->data['User']['name'] . ' ' . $this->request->data['User']['surname'] . ')';
                }

                $userEmail = $this->User->data['User']['email'];
                $user_status = Security::hash($this->User->data['User']['email'], 'md5', TRUE);

                if ($this->User->save($this->request->data)) {
                   
                        try {
                            $email1 = new CakeEmail();
                            $email1->emailFormat('html');
                            $email1->from(Configure::read('NotifyEmail.from'));
                            $email1->to(Configure::read('Admin.mail'));
                            $email1->template('register', Configure::read('App.theme'))->viewVars(array(
                                'user' => $this->request->data,
                                    //'link' => Router::url('/', true) . $this->request->params['controller'] . '/activate/' . urlencode(md5($userEmail))
                            ));
                            $email1->subject(__('Nowe konto (' . $this->request->data['User']['type'] . ')'));
                            $email1->send();
                        } catch (Exception $e) {
                            
                        }

                        if ($this->request->data['User']['type'] == 'prywatne') {
                            try {
                                $email = new CakeEmail();
                                $email->emailFormat('html');
                                $email->from(Configure::read('NotifyEmail.from'));
                                $email->to($userEmail);
                                $email->template('register', Configure::read('App.theme'))->viewVars(array(
                                    'user' => $this->request->data,
                                    'link' => Router::url('/', true) . $this->request->params['controller'] . '/activate/' . urlencode($this->User->getLastInsertID() . '-' . md5($userEmail))
                                ));
                                $email->subject(__('New account'));
                                $email->send();
                                $this->Session->setFlash(__('Email z linkiem aktywacyjnym został wysłany '), 'flash', array('class' => 'alert alert-success'));
                                $this->redirect(array('controller' => 'users', 'action' => 'registered'));
                            } catch (Exception $e) {
                                $this->Session->setFlash(__('Dziekujemy za rejestrację'), 'flash', array('class' => 'alert alert-success'));
                            }
                        }
                        $this->Session->setFlash(__('Dziekujemy za rejestrację'), 'flash', array('class' => 'alert alert-success'));
                    
                            $this->redirect(array('controller' => 'users', 'action' => 'registered'));
              
                    
                }
            } else {
                $this->Session->setFlash(__('Popraw błędy'), 'flash', array('class' => 'alert alert-danger'));
            }
        }
    }

    protected function get_client_ip() {
        $ipaddress = '';
        if (getenv('HTTP_CLIENT_IP'))
            $ipaddress = getenv('HTTP_CLIENT_IP');
        else if (getenv('HTTP_X_FORWARDED_FOR'))
            $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
        else if (getenv('HTTP_X_FORWARDED'))
            $ipaddress = getenv('HTTP_X_FORWARDED');
        else if (getenv('HTTP_FORWARDED_FOR'))
            $ipaddress = getenv('HTTP_FORWARDED_FOR');
        else if (getenv('HTTP_FORWARDED'))
            $ipaddress = getenv('HTTP_FORWARDED');
        else if (getenv('REMOTE_ADDR'))
            $ipaddress = getenv('REMOTE_ADDR');
        else
            $ipaddress = 'UNKNOWN';
        return $ipaddress;
    }

    public function activate($email = NULL, $hash = NULL) {

        $email = explode('-', $email);


        if (isset($email[0])) {
            $user = $this->User->find('first', array(
                'conditions' => array(
                    'User.id' => $email[0],
                    'User.status' => '0'
                )
            ));

            $userActive = $this->User->find('first', array(
                'conditions' => array(
                    'User.id' => $email[0],
                    'User.status' => '1'
                )
            ));
            if (!empty($userActive)) {
                $this->Session->setFlash(__('Konto jest już aktywne. Proszę się zalogować.'), 'flash', array('class' => 'alert alert-success'));
                $this->redirect(array('controller' => 'users', 'action' => 'login'));
            }

            if (!empty($user) && isset($email[1]) && (md5($user['User']['email']) == $email[1])) {
                $this->User->id = $user['User']['id'];
                $this->User->saveField('status', '1');
                $this->Session->setFlash(__('Account successfully activated, please log in'), 'flash', array('class' => 'alert alert-success'));
                //$this->redirect(array('action' => 'login'));
            } else {
                $this->Session->setFlash(__('Błędny link'), 'flash', array('class' => 'alert alert-danger'));
            }
        } else {
            $this->Session->setFlash(__('Błędny link'), 'flash', array('class' => 'alert alert-danger'));
        }
        $this->redirect(array('controller' => 'users', 'action' => 'login'));
    }

    public function lostpassword() {
        if ($this->request->is('post') and ( isset($this->request->data['User']['email']))) {
            $user = $this->User->find('first', array(
                'conditions' => array(
                    'User.email' => $this->request->data['User']['email']
                )
            ));
            if (!empty($user)) {
                $hash = Security::hash($user['User']['password'] . $user['User']['created'], 'md5', TRUE);
                $userEmail = $user['User']['email'];
                // Mail
                $email = new CakeEmail();
                $email->emailFormat('html');
                $email->from(Configure::read('NotifyEmail.from'));
                $email->to($userEmail);
                $email->template('lostpassword', Configure::read('App.theme'))->viewVars(array(
                    'user' => $user,
                    'link' => Router::url('/', true) . $this->request->params['controller'] . '/changepassword/' . urlencode($userEmail) . '/' . $hash
                ));
                $email->subject(__('Password change request'));
                $email->send();
                //exit($hash);
                $this->Session->setFlash(__('To set a new password, click on the link that we have sent to your e-mail address'), 'flash', array('class' => 'alert alert-success'));
                $this->redirect(array('action' => 'login'));
            } else {
                $this->Session->setFlash(__('Invalid e-mail address'), 'flash', array('class' => 'alert alert-danger'));
            }
        }
    }

    public function changepassword($email, $hash) {
        $this->User->validator()->getField('password')->setRules(array(
            'notBlank' => array(
                'rule' => array('notBlank'),
                'message' => 'This field is required.',
                'allowEmpty' => false,
                'required' => true,
            ),
            'identicalFieldValues' => array(
                'rule' => array('identicalFieldValues', 'password2'),
                'message' => 'Passwords do not match',
            ))
        );

        $user = $this->User->find('first', array(
            'conditions' => array(
                'email' => $email
            ),
            'fields' => array('id', 'password', 'created'),
            'recursive' => -1
        ));

        if (!empty($user) and ( Security::hash($user['User']['password'] . $user['User']['created'], 'md5', TRUE) == $hash)) {
            if ($this->request->is('post') and isset($this->request->data['User']['password']) and isset($this->request->data['User']['password2'])) {
                $user['User']['password'] = $this->request->data['User']['password'];
                $user['User']['password2'] = $this->request->data['User']['password2'];
                //$this->User->validator()->remove('imie', 'notBlank');
                //$this->User->validator()->remove('nazwisko', 'notBlank');
                $this->User->set($user);
                if ($this->User->save($user)) {
                    $this->Session->setFlash(__('Password has been changed'), 'flash', array('class' => 'alert alert-success'));
                    $this->redirect(array('action' => 'login'));
                }
            }
        } else {
            $this->Session->setFlash(__('Invalid link'), 'flash', array('class' => 'alert alert-danger'));
            $this->redirect(array('action' => 'login'));
        }
    }

    public function beforeFilter() {
        parent::beforeFilter();
        // Allow everything to not logged user except admin pages
        if (isset($this->params["admin"]) && $this->params["admin"]) {
            $this->Auth->deny();
        } else {
            $this->Auth->allow(array('register', 'get_client_ip', 'registered', 'registered_firmowe', 'activate', 'lostpassword', 'changepassword', 'login', 'logouts', 'edit'));
        }
    }

    public function isAuthorized($user) {

        switch ($this->request->params['action']) {
            case 'index':
            case 'add':
            case 'edit':
            case 'delete':
            case 'login_as':
            case 'logouts':
            case 'profile':
            case 'register':

            case 'notverified':
                $allowedRoles = array('admin', 'superadmin');
                break;
            case 'set_terms':
            case 'logouts':
            case 'user_profile':
            case 'view':
            case 'verify':
            case 'notifications':
            case 'upload_certyficate':
                $allowedRoles = array('user', 'admin');
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
