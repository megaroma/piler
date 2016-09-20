<?php

class ModelAuditAudit extends Model {

   public function search_audit($data = array()) {
      $where = '';
      $arr = $results = array();
      $from = 0;
      $sort = "ts";
      $order = "DESC";
      $sortorder = "ORDER BY ts DESC";
      $date1 = $date2 = 0;
      $q = '';

      $session = Registry::get('session');

      if($data['sort'] == "user") { $sort = "email"; }
      if($data['sort'] == "ipaddr") { $sort = "ipaddr"; }
      if($data['sort'] == "ref") { $sort = "meta_id"; }
      if($data['sort'] == "action") { $sort = "action"; }
      if($data['sort'] == "description") { $sort = "description"; }

      if($data['order'] == 1) { $order = "ASC"; }

      $sortorder = "ORDER BY `$sort` $order";

      if(isset($data['action']) && $data['action'] != ACTION_ALL) {
         $where .= " AND ( " . $this->append_search_criteria("action", $data['action'], $arr) . " )";
      }

      if(isset($data['ipaddr']) && $data['ipaddr']) {
         $where .= " AND ( " . $this->append_search_criteria("ipaddr", $data['ipaddr'], $arr) . " )";
      }

      if(isset($data['user']) && $data['user']) {
         $where .= " AND ( " . $this->append_search_criteria("email", $data['user'], $arr) . " )";
      }

      if(isset($data['ref']) && $data['ref']) {
         $where .= " AND ( " . $this->append_search_criteria("meta_id", $data['ref'], $arr) . " )";
      }

      if(Registry::get('admin_user') == 0 && RESTRICTED_AUDITOR == 1) {
         $auditdomains = $session->get("auditdomains");

         while(list($k, $v) = each($auditdomains)) {
            if($q) { $q .= ","; }
            $q .= "?";
            array_push($arr, $v);
         }

         $where .= " AND domain IN ($q) ";

         reset($session->get("auditdomains"));
      }


      if(isset($data['date1'])) { $date1 = $data['date1']; }
      if(isset($data['date2'])) { $date2 = $data['date2']; }

      $date = fixup_date_condition('ts', $date1, $date2);


      if($date) { $where .= " AND $date "; }

      if($where) {
         $where = " WHERE " . substr($where, 5, strlen($where));
      }

      $from = $data['page_len'] * $data['page'];


      if($where) {
         $query = $this->db->query("SELECT COUNT(*) AS count FROM " . TABLE_AUDIT . " $where", $arr);
         $n = $query->row['count'];

         if(ENABLE_SYSLOG == 1) { syslog(LOG_INFO, sprintf("audit query: '%s' in %.2f s, %d hits", $query->query, $query->exec_time, $query->row['count'])); }
      }
      else { $n = MAX_AUDIT_HITS; }


      if($n > 0) {
         if($n > MAX_AUDIT_HITS) { $n = MAX_AUDIT_HITS; }

         
         $query = $this->db->query("SELECT * FROM " . TABLE_AUDIT . " $where $sortorder LIMIT $from," . $data['page_len'], $arr);

         $this->session->set("audit_query", array('where' => $where, 'sortorder' => $sortorder, 'arr' => $arr));

         if(ENABLE_SYSLOG == 1) { syslog(LOG_INFO, sprintf("audit query: '%s', param: '%s' in %.2f s, %d hits", $query->query, implode(' ', $arr), $query->exec_time, $query->num_rows)); }

         if(isset($query->rows)) {

            foreach($query->rows as $a) {

               $a['description'] = preg_replace("/\"/", "'", $a['description']);

               $results[] = array(
                                    'id' => $a['meta_id'],
                                    'piler_id' => isset($m[$a['meta_id']]) ? $m[$a['meta_id']] : '',
                                    'action' => $a['action'],
                                    'email' => $a['email'],
                                    'date' => date(DATE_TEMPLATE . " H:i", $a['ts']),
                                    'ipaddr' => DEMO_MODE == 1 ? anonimize_ip_addr($a['ipaddr']) : $a['ipaddr'],
                                    'description' => $a['description'],
                                    'shortdescription' => make_short_string($a['description'], MAX_CGI_FROM_SUBJ_LEN)
                                  );

            }
         }
      }

      return array($n, $results);
   }


   public function print_audit_to_csv() {
      $actions = array_flip(Registry::get('actions'));

      $a = $this->session->get("audit_query");

      if(isset($a['where']) && isset($a['sortorder']) && isset($a['arr'])) {
         print "Date" . DELIMITER . "ID" . DELIMITER . "User" . DELIMITER . "IP-address" . DELIMITER . "Action" . DELIMITER . "Piler ID" . DELIMITER . "Description\n";

         $query = $this->db->query("SELECT * FROM " . TABLE_AUDIT . " " . $a['where'] . " " . $a['sortorder'], $a['arr']);
         foreach($query->rows as $q) {
            if(DEMO_MODE == 1) { $q['ipaddr'] = anonimize_ip_addr($q['ipaddr']); }

            print date(DATE_TEMPLATE . " H:i:s", $q['ts']) . DELIMITER . $q['id'] . DELIMITER . $q['email'] . DELIMITER . $q['ipaddr'] . DELIMITER . $actions[$q['action']] . DELIMITER . $q['meta_id'] . DELIMITER . $q['description'] . "\n";
         }
      }
   }


   private function append_search_criteria($var = '', $s = '', &$arr = array()) {
      $str = "";

      $a = explode("\t", $s);

      for($i=0; $i<count($a); $i++) {
         if($a[$i]) {
            $p = strchr($a[$i], '*');
            if($p) {
               $str .= "OR $var LIKE ? ";
               array_push($arr, preg_replace("/\*.{0,}/", "%", $a[$i]));
            }
            else {
               $str .= "OR $var = ? ";
               array_push($arr, $a[$i]);
            }
         }
      }

      return substr($str, 2, strlen($str));
   }


}

?>
