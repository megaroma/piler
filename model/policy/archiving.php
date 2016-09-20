<?php


class ModelPolicyArchiving extends Model {

   public function get_rules($s = '') {
      if($s) {
         $query = $this->db->query("SELECT * FROM " . TABLE_ARCHIVING_RULE . " WHERE `from` LIKE ? OR `to` LIKE ? OR subject LIKE ? ORDER BY domain, id", array('%' . $s . '%', '%' . $s . '%', '%' . $s . '%'));
      } else {
         $query = $this->db->query("SELECT * FROM " . TABLE_ARCHIVING_RULE . " ORDER BY id");
      }

      if(isset($query->rows)) { return $query->rows; }

      return array();
   }


   public function get_rule($id = 0) {
      $query = $this->db->query("SELECT * FROM " . TABLE_ARCHIVING_RULE . " WHERE id=?", array($id));

      if(isset($query->row)) { return $query->row; }

      return array();
   }


   public function add_new_rule($data = array()) {
      $query = $this->db->query("INSERT INTO " . TABLE_ARCHIVING_RULE . " (`from`,`to`,`subject`,`_size`,`size`,`attachment_name`,`attachment_type`,`_attachment_size`,`attachment_size`,`spam`) VALUES(?,?,?,?,?,?,?,?,?,?)", array($data['from'], $data['to'], $data['subject'], $data['_size'], $data['size'], $data['attachment_name'], $data['attachment_type'], $data['_attachment_size'], $data['attachment_size'], $data['spam']));

      return $this->db->countAffected();
   }


   public function remove_rule($id = 0) {
      $query = $this->db->query("DELETE FROM " .  TABLE_ARCHIVING_RULE . " WHERE id=?", array($id));
      return $this->db->countAffected();
   }


}

?>
