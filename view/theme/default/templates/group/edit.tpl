<div id="deleteconfirm-modal" class="modal hide fade">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" role="dialog" aria-hidden="true"><i class="icon-remove"></i></button>
    <h3><?php print $text_confirm; ?> <?php print $text_delete; ?></h3>
  </div>
  <div class="modal-body">
    <p><?php print $text_group_delete_confirm_message; ?> <span id="name">ERROR</span>?</p>
  </div>
  <div class="modal-footer">
    <a href="#" class="btn" data-dismiss="modal" aria-hidden="true"><?php print $text_close; ?></a>
    <a href="index.php?route=group/remove&amp;id=-1&amp;name=Error&amp;confirmed=0" class="btn btn-primary" id="id"><?php print $text_delete; ?></a>
  </div>
</div>

<?php if(isset($errorstring)){ ?><div class="alert alert-danger"><?php print $text_error; ?>: <?php print $errorstring; ?></div><?php } ?>

<?php if(isset($x)){ ?>

<div class="alert alert-success"><?php print $x; ?>.</div>
<p><a href="index.php?route=group/list"><i class="icon-circle-arrow-left"></i>&nbsp;<?php print $text_back; ?></a></p>

<?php } elseif(isset($group)) { ?>

<p><a href="index.php?route=group/list"><i class="icon-circle-arrow-left"></i>&nbsp;<?php print $text_back; ?></a> | 
<a href="index.php?route=group/remove&amp;id=<?php print $group['id']; ?>&amp;name=<?php print urlencode($group['groupname']); ?>" class="confirm-delete" data-id="<?php print $group['id']; ?>" data-name="<?php print $group['groupname']; ?>"><i class="icon-remove-sign"></i>&nbsp;<?php print $text_remove_this_group; ?></a></p>
<form action="index.php?route=group/edit" name="addgroup" method="post" autocomplete="off" class="form-horizontal">
   <input type="hidden" name="id" value="<?php print $id; ?>" />

    <div class="control-group">
	  <label class="control-label" for="groupname"><?php print $text_groupname; ?>:</label>
	  <div class="controls">
	    <input type="text" name="groupname" id="groupname" value="<?php print $group['groupname']; ?>" class="text" />
	  </div>
    </div>

    <div class="control-group">
	  <label class="control-label" for="s_piler_email"><?php print $text_search_emails; ?>*:</label>
	  <div class="controls">
            <input type="text" id="s_piler_email" name="s_piler_email" placeholder="<?php print $text_search_email_to_add; ?>" class="autocompletetext" />
	  </div>
    </div>

	<div class="control-group">
	  <label class="control-label" for="throwaway"><?php print $text_select_letter; ?>:</label>
	  <div class="controls">
	<?php foreach(Registry::get('letters') as $letter) { ?>
         <a href="#" onclick="window.open('<?php print SITE_URL; ?>index.php?route=group/email&term=<?php print $letter; ?>', 'aaa', 'width=300,height=400,scroll=yes');" ><?php print $letter; ?></a>
<?php } ?>
	  </div>
    </div>

    <div class="control-group">
          <label class="control-label" for="groupname"><?php print $text_email_addresses; ?>**:</label>
          <div class="controls">
            <textarea style="height:280px;" name="email" id="email" class="domain"><?php if(isset($email)){ print $email; } ?></textarea>
          </div>
    </div>

    <div class="control-group">
	  <label class="control-label" for="groupname"><?php print $text_assigned_email_addresses; ?>**:</label>
	  <div class="controls">
	    <textarea style="height:280px;" name="assigned_email" id="assigned_email" class="domain"><?php if(isset($assigned_email)){ print $assigned_email; } ?></textarea>
	  </div>
    </div>
   
    <div class="alert alert-info">*: <?php print $text_min_2_chars; ?><br />**: <?php print $text_enter_one_email_address_per_line; ?></div>

    <div class="form-actions">
        <input type="submit" id="button_edit" class="btn btn-primary" value="<?php print $text_modify; ?>" />
        <a href="index.php?route=group/list" class="btn"><?php print $text_cancel; ?></a>
    </div>

</form>

<?php } ?>
