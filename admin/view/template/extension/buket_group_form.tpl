<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
  <div class="page-header">
    <div class="container-fluid">
      <div class="pull-right">
        <button type="submit" form="form-buket-group" data-toggle="tooltip" title="<?php echo $button_save; ?>" class="btn btn-primary"><i class="fa fa-save"></i></button>
        <a href="<?php echo $cancel; ?>" data-toggle="tooltip" title="<?php echo $button_cancel; ?>" class="btn btn-default"><i class="fa fa-reply"></i></a></div>
      <h1><?php echo $heading_title; ?></h1>
      <ul class="breadcrumb">
        <?php foreach ($breadcrumbs as $breadcrumb) { ?>
        <li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
        <?php } ?>
      </ul>
    </div>
  </div>
  <div class="container-fluid">
    <?php if ($error_warning) { ?>
    <div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> <?php echo $error_warning; ?>
      <button type="button" class="close" data-dismiss="alert">&times;</button>
    </div>
    <?php } ?>
    <div class="panel panel-default">
      <div class="panel-heading">
        <h3 class="panel-title"><i class="fa fa-pencil"></i> <?php echo $text_form; ?></h3>
      </div>
      <div class="panel-body">
        <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-buket-group" class="form-horizontal">

          <div class="form-group required">
            <label class="col-sm-2 control-label">Изображение</label>
            <div class="col-sm-10">

            <a href="" id="thumb-image" data-toggle="image" class="img-thumbnail"><img src="<?php echo $buket_group_description['thumb']; ?>" alt="" title="" data-placeholder="<?php echo $placeholder; ?>" /></a>
              <input type="hidden" name="image" value="<?php echo $buket_group_description['image']; ?>" id="input-image"/>

            </div>
          </div>

          <div class="form-group required">
            <label class="col-sm-2 control-label"><?php echo $entry_name; ?></label>
            <div class="col-sm-10">

              <div class="input-group"><span class="input-group-addon"><img src="view/image/flags/ru.png" title="ru" /></span>
                <input type="text" name="name" value="<? if(isset($buket_group_description['name'])) {echo $buket_group_description['name'];} ?>" placeholder="<?php echo $entry_name; ?>" class="form-control" />
              </div>

            </div>
          </div>

          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-descriptionru"><?php echo $entry_description; ?></label>
            <div class="col-sm-10">
              <div class="input-group"><span class="input-group-addon"><img src="view/image/flags/ru.png" title="<?php echo $language['name']; ?>" /></span>
                <textarea name="description" rows="5" placeholder="<?php echo $entry_description; ?>" id="input-descriptionru" class="form-control"> <? if(isset($buket_group_description['description'])){ echo $buket_group_description['description'];} ?></textarea>
              </div>
            </div>
          </div>

        </form>
      </div>
    </div>
  </div>
</div>
<?php echo $footer; ?>