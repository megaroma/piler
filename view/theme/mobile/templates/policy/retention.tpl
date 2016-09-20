<form method="get" name="search1" action="retention.php" class="form-inline pull-right">
    <div class="input-append">
        <input type="text" name="search" class="input-medium" value="<?php print $search; ?>" />
        <input type="submit" class="btn" value="<?php print $text_search; ?>" />
    </div>
</form>

<h4><?php print $text_add_new_rule; ?></h4>

<form method="post" name="add1" action="index.php?route=policy/retention" class="formbottom">

   <div id="ss1">

<?php if(ENABLE_SAAS == 1) { ?>
      <div class="row">
         <div class="domaincell"><?php print $text_domain; ?>:</div>
         <div class="domaincell"><input type="text" name="domain" class="input-medium span5" /></div>
      </div>
<?php } ?>
      <div class="row">
         <div class="domaincell"><?php print $text_from; ?>:</div>
         <div class="domaincell"><input type="text" name="from" class="input-medium span5" /></div>
      </div>
      <div class="row">
         <div class="domaincell"><?php print $text_to; ?>:</div>
         <div class="domaincell"><input type="text" name="to" class="input-medium span5" /></div>
      </div>
      <div class="row">
         <div class="domaincell"><?php print $text_subject; ?>:</div>
         <div class="domaincell"><input type="text" name="subject" class="input-medium span5" /></div>
      </div>
      <div class="row">
         <div class="domaincell"><?php print $text_size; ?>:</div>
         <div class="domaincell">
            <select name="_size" class="span1">
               <option value=">">&gt;</option>
               <option value="=">=</option>
               <option value="<">&lt;</option>
            </select>
            <input type="text" name="size" class="input-medium span4" />
         </div>
      </div>
      <div class="row">
         <div class="domaincell"><?php print $text_attachment_name; ?>:</div>
         <div class="domaincell"><input type="text" name="attachment_name" class="input-medium span5" /></div>
      </div>
      <div class="row">
         <div class="domaincell"><?php print $text_attachment_type; ?>:</div>
         <div class="domaincell"><input type="text" name="attachment_type" class="input-medium span5" /></div>
      </div>
      <div class="row">
         <div class="domaincell"><?php print $text_attachment_size; ?>:</div>
         <div class="domaincell">
            <select name="_attachment_size" class="span1">
               <option value=">">&gt;</option>
               <option value="=">=</option>
               <option value="<">&lt;</option>
            </select>
            <input type="text" name="attachment_size" class="input-medium span4" />
         </div>
      </div>
      <div class="row">
         <div class="domaincell"><?php print $text_spam; ?>:</div>
         <div class="domaincell">
            <select name="spam" class="span1">
               <option value="-1">-</option>
               <option value="0"><?php print $text_not_spam; ?></option>
               <option value="1"><?php print $text_spam2; ?></option>
            </select>
            <input type="text" name="attachment_size" class="input-medium span4" />
         </div>
      </div>
      <div class="row">
         <div class="domaincell"><?php print $text_days_to_retain; ?>:</div>
         <div class="domaincell"><input type="text" name="days" class="input-medium span5" /></div>
      </div>


      <div class="row">
         <div class="domaincell">&nbsp;</div>
         <div class="domaincell"><input type="submit" class="btn btn-primary" value="<?php print $text_add; ?>" /> <input type="reset" class="btn" value="<?php print $text_cancel; ?>" /></div>
      </div>

   </div>

</form>

<?php if($error) { ?><p class="text-error bold"><?php print $text_error; ?>: <?php print $error; ?></p><?php } ?>


<h4><?php print $text_existing_rules; ?></h4>

<?php if(isset($rules)){ ?>

   <div id="ss1">
      <div class="domainrow">
<?php if(ENABLE_SAAS == 1) { ?>
         <div class="domaincell"><?php print $text_domain; ?></div>
<?php } ?>
         <div class="domaincell"><?php print $text_from; ?></div>
         <div class="domaincell"><?php print $text_to; ?></div>
         <div class="domaincell"><?php print $text_subject; ?></div>
         <div class="domaincell"><?php print $text_spam; ?></div>
         <div class="domaincell"><?php print $text_size; ?></div>
         <div class="domaincell"><?php print $text_attachment_name; ?></div>
         <div class="domaincell"><?php print $text_attachment_type; ?></div>
         <div class="domaincell"><?php print $text_attachment_size; ?></div>
         <div class="domaincell"><?php print $text_days; ?></div>
         <div class="domaincell">&nbsp;</div>
<?php if(ENABLE_SAAS == 1) { ?>
         <div class="domaincell">&nbsp;</div>
<?php } ?>
      </div>

<?php foreach($rules as $rule) { ?>
      <div class="domainrow">
<?php if(ENABLE_SAAS == 1) { ?>
         <div class="domaincell"><?php print $rule['domain']; ?></div>
<?php } ?>
         <div class="domaincell"><?php print $rule['from']; ?></div>
         <div class="domaincell"><?php print $rule['to']; ?></div>
         <div class="domaincell"><?php print $rule['subject']; ?></div>
         <div class="domaincell"><?php if($rule['spam'] == -1) { print "-"; } else if($rule['spam'] == 0) { print $text_not_spam; } else { print $text_spam; } ?></div>
         <div class="domaincell"><?php if($rule['size'] > 0) { print $rule['_size']; ?> <?php print $rule['size']; } ?></div>
         <div class="domaincell"><?php print $rule['attachment_name']; ?></div>
         <div class="domaincell"><?php print $rule['attachment_type']; ?></div>
         <div class="domaincell"><?php if($rule['attachment_size'] > 0) { print $rule['_attachment_size']; ?> <?php print $rule['attachment_size']; } ?></div>
         <div class="domaincell"><?php print $rule['days']; ?></div>
         <div class="domaincell"><a href="index.php?route=policy/removeretention&amp;confirmed=1&amp;id=<?php print $rule['id']; ?>" onclick="if(confirm('<?php print $text_remove_rule; ?>: ' + '#<?php print $rule['id']; ?>')) return true; return false;"><?php print $text_remove; ?></a></div>
<?php if(ENABLE_SAAS == 1) { ?>
         <div class="domaincell"><?php if($rule['domain']) { ?><a href="index.php?route=policy/updateretention&domain=<?php print $rule['domain']; ?>&days=<?php print $rule['days']; ?>"><?php print $text_update_retention_within_this_domain; ?></a><?php } else { ?>&nbsp;<?php } ?></div>
<?php } ?>
      </div>
<?php } ?>

   </div>

<?php } else { ?>
<?php print $text_not_found; ?>
<?php } ?>



<div class="top20px">
   <input type="button" class="btn btn-danger" onclick="Piler.reload_piler();" value="<?php print $text_apply_changes; ?>" /> <span id="applyChangesOutput"></span>
</div>


