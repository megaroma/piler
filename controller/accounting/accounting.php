<?php


class ControllerAccountingAccounting extends Controller {
   private $error = array();

   public function index(){
      $this->id = "content";
      $this->template = "accounting/accounting.tpl";
      $this->layout = "common/layout";

      $request = Registry::get('request');
      $db = Registry::get('db');

      $this->load->model('user/user');
      $this->load->model('group/group');
      $this->load->model('domain/domain');
      $this->load->model('accounting/accounting');
      if(ENABLE_SAAS == 1) {
         $this->load->model('saas/ldap');
      }

      $this->data['page'] = 0;
      $this->data['page_len'] = get_page_length();
      $this->data['sort'] = 'item';
      $this->data['sorttype'] = 0;
      $this->data['order'] = 0;


      $this->data['search'] = '';

      /* get search term if there's any */

      if(isset($this->request->post['search'])) { $this->data['search'] = $this->request->post['search']; }
      else if(isset($this->request->get['search'])) { $this->data['search'] = $this->request->get['search']; }

      // get page
      if(isset($this->request->get['page']) && is_numeric($this->request->get['page']) && $this->request->get['page'] > 0) {
         $this->data['page'] = $this->request->get['page'];
      }
      
      // get sort field
      if ( isset($this->request->get['sort']) ) {
          if(@$this->request->get['sort'] == "item") { $this->data['sort'] = 'item'; }
          if(@$this->request->get['sort'] == "oldest") { $this->data['sort'] = 'oldest'; $this->data['sorttype'] = 1; }
          if(@$this->request->get['sort'] == "newest") { $this->data['sort'] = 'newest'; $this->data['sorttype'] = 1; }
          if(@$this->request->get['sort'] == "sent") { $this->data['sort'] = 'sent'; }
          if(@$this->request->get['sort'] == "sentsize") { $this->data['sort'] = 'sentsize'; $this->data['sorttype'] = 2; }
          if(@$this->request->get['sort'] == "sentavg") { $this->data['sort'] = 'sentavg'; $this->data['sorttype'] = 2; }
          if(@$this->request->get['sort'] == "recd") { $this->data['sort'] = 'recd'; }
          if(@$this->request->get['sort'] == "recdsize") { $this->data['sort'] = 'recdsize'; $this->data['sorttype'] = 2; }
          if(@$this->request->get['sort'] == "recdavg") { $this->data['sort'] = 'recdavg'; $this->data['sorttype'] = 2; }
      }
      
      // get sort order
      if(isset($this->request->get['order']) && is_numeric($this->request->get['order'])) {
         $this->data['order'] = $this->request->get['order'];
      }
      
      // get type of accounting view
      if(@$this->request->get['view'] == "email") {
        $this->data['view'] = 'email';
        $this->data['viewname'] = $this->data['text_email'];
        $this->data['accounting'] = $this->model_accounting_accounting->get_accounting('email',$this->data['search'], $this->data['page'], $this->data['page_len'], $this->data['sort'], $this->data['order']);
        $this->data['total_records'] = $this->model_accounting_accounting->count_accounting('email',$this->data['search']);
      }
      
      if(@$this->request->get['view'] == "domain") {
        $this->data['view'] = 'domain';
        $this->data['viewname'] = $this->data['text_domain'];
        $this->data['accounting'] = $this->model_accounting_accounting->get_accounting('domain',$this->data['search'], $this->data['page'], $this->data['page_len'], $this->data['sort'], $this->data['order']);
        $this->data['total_records'] = $this->model_accounting_accounting->count_accounting('domain',$this->data['search']);

        $this->data['mydomain_count'] = $this->model_domain_domain->count_mydomains();
        $this->data['user_count'] = 0;

        if(ENABLE_SAAS == 1) {
           $this->data['accounts'] = array();

           foreach($this->data['accounting'] as $a) {
              $this->data['accounts'][$a['item']] = $this->model_saas_ldap->get_accounts_in_domain($a['item']);

              $this->data['user_count'] += count($this->data['accounts'][$a['item']]);
           }

        }
      }   

      if(@$this->request->get['view'] == "accounts" && isset($this->request->get['domain'])) {
        $this->template = "accounting/accounts.tpl";
        $this->data['domain'] = $this->request->get['domain'];
        $this->data['accounts'] = $this->model_saas_ldap->get_accounts_in_domain($this->request->get['domain']); 
      }


      if($this->data['accounting']) {
          foreach($this->data['accounting'] as $id=>$row) {
            if($this->data['sorttype'] == 0){
                $this->data['accounting'][$id]['display'] = $row[$this->data['sort']];
            }
            if($this->data['sorttype'] == 1){
                $this->data['accounting'][$id]['display'] = date(DATE_TEMPLATE, $row[$this->data['sort']]);
            }
            if($this->data['sorttype'] == 2){
                $this->data['accounting'][$id]['display'] = nice_size($row[$this->data['sort']]);
            }
          }
      }
      
      $this->document->title = $this->data['text_accounting'];

      $this->data['today'] = time()-(time()%86400);
      $this->data['days'] = 15;

      $this->data['timespan'] = @$this->request->get['timespan'];
      $this->data['uid'] = @$this->request->get['uid'];

      $this->data['admin_user'] = Registry::get('admin_user');
      $this->data['readonly_admin'] = Registry::get('readonly_admin');
      
      $this->data['prev_page'] = $this->data['page'] - 1;
      $this->data['next_page'] = $this->data['page'] + 1;

      $this->data['total_pages'] = floor($this->data['total_records'] / $this->data['page_len']);
      
      $this->render();
   }

}

?>
