<div class="page-bar">
    <?php
    if ($this->elementExists('breadcrumbs/' . $this->request['controller'] . '_' . $this->request['action'])) {
        echo $this->element('breadcrumbs/' . $this->request['controller'] . '_' . $this->request['action']);
    } else {
        echo $this->element('breadcrumbs/default');
    }
    ?>
    <?php
    if ($this->elementExists('actions/' . $this->request['controller'] . '_' . $this->request['action'])) {
        echo $this->element('actions/' . $this->request['controller'] . '_' . $this->request['action']);
    }
    ?>
</div>