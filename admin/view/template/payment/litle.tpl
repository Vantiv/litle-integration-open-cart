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
      <h1><img src="view/image/payment.png" alt="" /> <?php echo $heading_title; ?></h1>
      <div class="buttons"><a onclick="$('#form').submit();" class="button"><?php echo $button_save; ?></a><a onclick="location = '<?php echo $cancel; ?>';" class="button"><?php echo $button_cancel; ?></a></div>
    </div>
    <div class="content">
      <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form">
        <table class="form">
          <tr>
            <td><span class="required">*</span> <?php echo $merchant_id; ?></td>
            <td><input type="text" name="litle_merchant_id" value="<?php echo $litle_merchant_id; ?>" />
              <?php if ($error_merchant_id) { ?>
              <span class="error"><?php echo $error_merchant_id; ?></span>
              <?php } ?></td>
          </tr>
          <tr>
            <td><span class="required">*</span> <?php echo $merchant_user_name; ?></td>
            <td><input type="text" name="litle_merchant_user_name" value="<?php echo $litle_merchant_user_name; ?>" />
              <?php if ($error_merchant_user_name) { ?>
              <span class="error"><?php echo $error_merchant_user_name; ?></span>
              <?php } ?></td>
          </tr>
          <tr>
            <td><span class="required">*</span> <?php echo $merchant_password; ?></td>
            <td><input type="password" name="litle_merchant_password" value="<?php echo $litle_merchant_password; ?>" />
              <?php if ($error_merchant_password) { ?>
              <span class="error"><?php echo $error_merchant_password; ?></span>
              <?php } ?></td>
          </tr>
          <tr>
            <td><?php echo $default_report_group; ?></td>
            <td><input type="text" name="litle_default_report_group" value="<?php echo $litle_default_report_group; ?>" />
            </td>
          </tr>
          <tr>
            <td><?php echo $entry_mode; ?></td>
            <td><select name="litle_url">
                <?php if ($litle_url == "sandbox") { ?>
                <option value="sandbox" selected="selected"><?php echo $text_sandbox; ?></option>
                <?php } else { ?>
                <option value="sandbox"><?php echo $text_sandbox; ?></option>
                <?php } ?>
                <?php if ($litle_url == "precert") { ?>
                <option value="precert" selected="selected"><?php echo $text_precert; ?></option>
                <?php } else { ?>
                <option value="precert"><?php echo $text_precert; ?></option>
                <?php } ?>
                <?php if ($litle_url == "cert") { ?>
                <option value="cert" selected="selected"><?php echo $text_cert; ?></option>
                <?php } else { ?>
                <option value="cert"><?php echo $text_cert; ?></option>
                <?php } ?>
                <?php if ($litle_url == "production") { ?>
                <option value="production" selected="selected"><?php echo $text_production; ?></option>
                <?php } else { ?>
                <option value="production"><?php echo $text_production; ?></option>
                <?php } ?>
              </select></td>
          </tr>
          <tr>
            <td><?php echo $entry_transaction; ?></td>
            <td><select name="litle_transaction">
                <?php if ($litle_transaction == "auth") { ?>
                <option value="auth" selected="selected"><?php echo $text_authorization; ?></option>
                <?php } else { ?>
                <option value="auth"><?php echo $text_authorization; ?></option>
                <?php } ?>
                <?php if ($litle_transaction == "sale") { ?>
                <option value="sale" selected="selected"><?php echo $text_sale; ?></option>
                <?php } else { ?>
                <option value="sale"><?php echo $text_sale; ?></option>
                <?php } ?>
              </select></td>
          </tr>
          <tr>
            <td><?php echo $entry_debug; ?></td>
            <td><select name="litle_debug">
                <?php if ($litle_debug) { ?>
                <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                <option value="0"><?php echo $text_disabled; ?></option>
                <?php } else { ?>
                <option value="1"><?php echo $text_enabled; ?></option>
                <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                <?php } ?>
              </select></td>
          </tr>
          <tr>
            <td><?php echo $entry_total; ?></td>
            <td><input type="text" name="litle_total" value="<?php echo $litle_total; ?>" /></td>
          </tr>
          <tr>
            <td><?php echo $entry_geo_zone; ?></td>
            <td><select name="litle_geo_zone_id">
                <option value="0"><?php echo $text_all_zones; ?></option>
                <?php foreach ($geo_zones as $geo_zone) { ?>
                <?php if ($geo_zone['geo_zone_id'] == $litle_geo_zone_id) { ?>
                <option value="<?php echo $geo_zone['geo_zone_id']; ?>" selected="selected"><?php echo $geo_zone['name']; ?></option>
                <?php } else { ?>
                <option value="<?php echo $geo_zone['geo_zone_id']; ?>"><?php echo $geo_zone['name']; ?></option>
                <?php } ?>
                <?php } ?>
              </select></td>
          </tr>
          <tr>
            <td><?php echo $entry_status; ?></td>
            <td><select name="litle_status">
                <?php if ($litle_status) { ?>
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
            <td><input type="text" name="litle_sort_order" value="<?php echo $litle_sort_order; ?>" size="1" /></td>
          </tr>
        </table>
      </form>
    </div>
  </div>
</div>
<?php echo $footer; ?> 