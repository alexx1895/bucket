<?php echo $header; ?>
<div id="content">
  <div class="breadcrumb">
    <?php foreach ($breadcrumbs as $breadcrumb) { ?>
    <?php echo $breadcrumb['separator']; ?><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a>
    <?php } ?>
  </div>
  <?php if ($error_warning) { ?>
  <div class="warning"><?php echo $error_warning; ?></div>
  <?php } ?>
  <div class="box">
    <div class="heading">
      <h1><img src="view/image/information.png" alt="" /> <?php echo $heading_title; ?></h1>
      <div class="buttons"><a onclick="$('#form').submit();" class="button"><?php echo $button_save; ?></a><a href="<?php echo $cancel; ?>" class="button"><?php echo $button_cancel; ?></a></div>
    </div>
    <div class="content">

      <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form">
        <div id="tab-general">
          <div id="languages" class="htabs">
            <?php foreach ($languages as $language) { ?>
            <a href="#language<?php echo $language['language_id']; ?>"><img src="view/image/flags/<?php echo $language['image']; ?>" title="<?php echo $language['name']; ?>" /> <?php echo $language['name']; ?></a>
            <?php } ?>
          </div>
		  <table class="form">
			<tbody>
						<tr>
				<td><?php echo $entry_type; ?></td>
                 <td>
					 <select name="type">
					  <?php if ($type) { ?>
					  <option value="1" selected="selected"><?php echo $text_description; ?></option>
					  <option value="0"><?php echo $text_link; ?></option>
					  <?php } else { ?>
					  <option value="1"><?php echo $text_description; ?></option>
					  <option value="0" selected="selected"><?php echo $text_link; ?></option>
					  <?php } ?>
					</select>
				 </td>
				</tr>
			</tbody>
		  </table>
          <?php foreach ($languages as $language) { ?>
          <div id="language<?php echo $language['language_id']; ?>">
            <table class="form">
              <tr>
                <td><span class="required">*</span> <?php echo $entry_title; ?></td>
                <td><input type="text" name="cmsblock_description[<?php echo $language['language_id']; ?>][title]" size="100" value="<?php echo isset($cmsblock_description[$language['language_id']]) ? $cmsblock_description[$language['language_id']]['title'] : ''; ?>" />
                  <?php if (isset($error_title[$language['language_id']])) { ?>
                  <span class="error"><?php echo $error_title[$language['language_id']]; ?></span>
                  <?php } ?></td>
              </tr>
              <tr class="entry_des">
                <td><span class="required">*</span> <?php echo $entry_description; ?></td>
                <td><textarea name="cmsblock_description[<?php echo $language['language_id']; ?>][description]" id="description<?php echo $language['language_id']; ?>"><?php echo isset($cmsblock_description[$language['language_id']]) ? $cmsblock_description[$language['language_id']]['description'] : ''; ?></textarea>
                  <?php if (isset($error_description[$language['language_id']])) { ?>
                  <span class="error"><?php echo $error_description[$language['language_id']]; ?></span>
                  <?php } ?></td>
              </tr>
            </table>
          </div>
          <?php } ?>
		  <table class="form">
		  <tbody>
		  <tr>
				<td><?php echo $entry_identify; ?></td>
              <td><input type="text" name="identify" value="<?php echo $identify; ?>" size="30" /></td>
            </tr>
			<tr class="entry_link">
				<td><?php echo $entry_link; ?></td>
              <td><input type="text" name="link" value="<?php echo $link; ?>" size="30" /></td>
            </tr>
			<tr>
				<td><?php echo $entry_status; ?></td>
              <td><select name="status">
                  <?php if ($status) { ?>
                  <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                  <option value="0"><?php echo $text_disabled; ?></option>
                  <?php } else { ?>
                  <option value="1"><?php echo $text_enabled; ?></option>
                  <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                  <?php } ?>
                </select></td>
			</tr>
			
			<tr>
              <td><?php echo $entry_sort_order; ?></td>
              <td><input type="text" name="sort_order" value="<?php echo $sort_order; ?>" size="1" /></td>
            </tr>
			</tbody>
		  </table>
        </div>
        
      </form>
    </div>
  </div>
</div>
<script type="text/javascript" src="view/javascript/ckeditor/ckeditor.js"></script> 
<script type="text/javascript"><!--
<?php foreach ($languages as $language) { ?>
CKEDITOR.replace('description<?php echo $language['language_id']; ?>', {
	filebrowserBrowseUrl: 'index.php?route=common/filemanager&token=<?php echo $token; ?>',
	filebrowserImageBrowseUrl: 'index.php?route=common/filemanager&token=<?php echo $token; ?>',
	filebrowserFlashBrowseUrl: 'index.php?route=common/filemanager&token=<?php echo $token; ?>',
	filebrowserUploadUrl: 'index.php?route=common/filemanager&token=<?php echo $token; ?>',
	filebrowserImageUploadUrl: 'index.php?route=common/filemanager&token=<?php echo $token; ?>',
	filebrowserFlashUploadUrl: 'index.php?route=common/filemanager&token=<?php echo $token; ?>'
});
<?php } ?>
//--></script> 
<script type="text/javascript"><!--
$('#tabs a').tabs(); 
$('#languages a').tabs(); 
var type_cur = "<?php echo $type ; ?>";
	if(type_cur == 0) {
		$('.entry_des').hide();
		$('.entry_link').show();
	} else {
		$('.entry_link').hide();
		$('.entry_des').show();
	}
$('select[name="type"]').bind('change', function() {
	var type = $(this).val(); 
	if(type == 0) {
		$('.entry_des').hide();
		$('.entry_link').show();
	} else {
		$('.entry_link').hide();
		$('.entry_des').show();
	}
});


//--></script> 
<?php echo $footer; ?>