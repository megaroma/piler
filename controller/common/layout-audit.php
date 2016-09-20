<?php  

class ControllerCommonLayoutAudit extends Controller {

      protected function index() {


         $this->data['title'] = $this->document->title;

         $this->template = "common/layout-audit.tpl";

         $this->data['search_args'] = '';

         $this->data['open_saved_search_box'] = 0;


         $this->children = array(
                      "common/menu",
                      "search/folder",
                      "search/popup",
                      "common/footer"
         );

         $this->render();

      }


}


?>
