<?php echo $header; ?>
  <?php echo $column_left; ?>
    <div id="content">
      <div class="page-header">
        <div class="container-fluid">
          <div class="pull-right">
            <button type="submit" form="form-authorizenet-sim" data-toggle="tooltip" title="<?php echo $button_save; ?>" class="btn btn-primary"><i class="fa fa-save"></i></button>
            <a href="<?php echo $cancel; ?>" data-toggle="tooltip" title="<?php echo $button_cancel; ?>" class="btn btn-default"><i class="fa fa-reply"></i></a></div>
          <h1>
            <?php echo $heading_title; ?>
          </h1>
          <ul class="breadcrumb">
            <?php foreach ($breadcrumbs as $breadcrumb) { ?>
              <li>
                <a href="<?php echo $breadcrumb['href']; ?>">
                  <?php echo $breadcrumb['text']; ?>
                </a>
              </li>
              <?php } ?>
          </ul>
        </div>
      </div>


      <div class="container-fluid">
        <?php if ($error_warning) { ?>
          <div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i>
            <?php echo $error_warning; ?>
              <button type="button" class="close" data-dismiss="alert">&times;</button>
          </div>
          <?php } ?>
            <div class="panel panel-default">
              <div class="panel-heading">
                <h3 class="panel-title"><i class="fa fa-pencil"></i>
                  <?php echo $text_edit; ?>
                </h3>
              </div>
              <div class="panel-body">
                <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-authorizenet-sim" class="form-horizontal">




                  <div class="form-group required">
                    <label class="col-sm-2 control-label" for="input-merchant">
                      <?php echo $test_customer_code; ?>
                    </label>
                    <div class="col-sm-10">
                      <input type="text" name="pmt_test_customer_code" value="<?php echo $pmt_test_customer_code; ?>" placeholder="<?php echo $test_customer_code; ?>" id="test_customer_code" class="form-control" />
                      <?php if ($error_test_customer_code) { ?>
                        <div class="text-danger">
                          <?php echo $error_test_customer_code; ?>
                        </div>
                        <?php } ?>
                    </div>
                  </div>

                  <div class="form-group required">
                    <label class="col-sm-2 control-label" for="input-merchant">
                      <?php echo $test_customer_key; ?>
                    </label>
                    <div class="col-sm-10">
                      <input type="text" name="pmt_test_customer_key" value="<?php echo $pmt_test_customer_key; ?>" placeholder="<?php echo $test_customer_key; ?>" id="test_customer_key" class="form-control" />
                      <?php if ($error_test_customer_key) { ?>
                        <div class="text-danger">
                          <?php echo $error_test_customer_key; ?>
                        </div>
                        <?php } ?>
                    </div>
                  </div>

                  <div class="form-group">
                    <label class="col-sm-2 control-label" for="input-merchant">
                      <?php echo $real_customer_code; ?>
                    </label>
                    <div class="col-sm-10">
                      <input type="text" name="pmt_real_customer_code" value="<?php echo $pmt_real_customer_code; ?>" placeholder="<?php echo $real_customer_code; ?>" id="real_customer_code" class="form-control" />
                      <?php if ($error_real_customer_code) { ?>
                        <div class="text-danger">
                          <?php echo $error_real_customer_code; ?>
                        </div>
                        <?php } ?>
                    </div>
                  </div>

                  <div class="form-group">
                    <label class="col-sm-2 control-label" for="input-merchant">
                      <?php echo $real_customer_key; ?>
                    </label>
                    <div class="col-sm-10">
                      <input type="text" name="pmt_real_customer_key" value="<?php echo $pmt_real_customer_key; ?>" placeholder="<?php echo $real_customer_key; ?>" id="real_customer_key" class="form-control" />
                      <?php if ($error_real_customer_key) { ?>
                        <div class="text-danger">
                          <?php echo $error_real_customer_key; ?>
                        </div>
                        <?php } ?>
                    </div>
                  </div>



                  <div class="form-group">
                    <label class="col-sm-2 control-label">
                      <?php echo $entry_test; ?>
                    </label>
                    <div class="col-sm-10">
                      <label class="radio-inline">
                        <?php if ($pmt_test) { ?>
                          <input type="radio" name="pmt_test" value="1" checked="checked" />
                          <?php echo $text_yes; ?>
                            <?php } else { ?>
                              <input type="radio" name="pmt_test" value="1" />
                              <?php echo $text_yes; ?>
                                <?php } ?>
                      </label>
                      <label class="radio-inline">
                        <?php if (!$pmt_test) { ?>
                          <input type="radio" name="pmt_test" value="0" checked="checked" />
                          <?php echo $text_no; ?>
                            <?php } else { ?>
                              <input type="radio" name="pmt_test" value="0" />
                              <?php echo $text_no; ?>
                                <?php } ?>
                      </label>
                    </div>
                  </div>

                  <div class="form-group">
                    <label class="col-sm-2 control-label">
                      <?php echo $entry_discount; ?>
                    </label>
                    <div class="col-sm-10">
                      <label class="radio-inline">
                        <?php if ($pmt_discount) { ?>
                          <input type="radio" name="pmt_discount" value="1" checked="checked" />
                          <?php echo $text_yes; ?>
                            <?php } else { ?>
                              <input type="radio" name="pmt_discount" value="1" />
                              <?php echo $text_yes; ?>
                                <?php } ?>
                      </label>
                      <label class="radio-inline">
                        <?php if (!$pmt_discount) { ?>
                          <input type="radio" name="pmt_discount" value="0" checked="checked" />
                          <?php echo $text_no; ?>
                            <?php } else { ?>
                              <input type="radio" name="pmt_discount" value="0" />
                              <?php echo $text_no; ?>
                                <?php } ?>
                      </label>
                    </div>
                  </div>


                  <div class="form-group">
                    <label class="col-sm-2 control-label" for="input-status">
                      <?php echo $entry_status; ?>
                    </label>
                    <div class="col-sm-10">
                      <select name="pmt_status" id="input-status" class="form-control">
                        <?php if ($pmt_status) { ?>
                          <option value="1" selected="selected">
                            <?php echo $text_enabled; ?>
                          </option>
                          <option value="0">
                            <?php echo $text_disabled; ?>
                          </option>
                          <?php } else { ?>
                            <option value="1">
                              <?php echo $text_enabled; ?>
                            </option>
                            <option value="0" selected="selected">
                              <?php echo $text_disabled; ?>
                            </option>
                            <?php } ?>
                      </select>
                    </div>
                  </div>


                  <div class="form-group">
                    <label class="col-sm-2 control-label" for="input-sort-order">
                      <?php echo $entry_sort_order; ?>
                    </label>
                    <div class="col-sm-10">
                      <input type="text" name="pmt_sort_order" value="<?php echo $pmt_sort_order; ?>" placeholder="<?php echo $entry_sort_order; ?>" id="input-sort-order" class="form-control" />
                    </div>
                  </div>




                </form>
              </div>
            </div>
      </div>
    </div>
    <?php echo $footer; ?>
