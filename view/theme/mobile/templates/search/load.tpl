
        <div id="messagelistcontainer" class="boxlistcontent">

   <div id="results">

         <div class="resultrow">
<?php if(count($terms) > 0){ ?>

<?php } else if(count($terms) == 0) { ?>
    <div class="alert">
       <strong><?php print $text_empty_search_result; ?></strong>
    </div>
<?php } ?>
         </div>

<?php foreach($terms as $term) {
         parse_str($term['term'], $s);
         if(isset($s['search']) && $s['search']) {
?>
         <div class="resultrow center">
            <a href="#" onclick="Piler.load_search_results_for_saved_query('<?php print urlencode($term['term']); ?>');"><?php print htmlspecialchars($s['search']); ?></a> | <a href="#" class="menulink" onclick="Piler.remove_saved_search_term(<?php print $term['ts']; ?>); return false;"><?php print $text_remove; ?></a></br />
         </div>
<?php } } ?>

       </div>
   </div>


