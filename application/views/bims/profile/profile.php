<div class="row">
    <div class="col-lg-12">
        <div class="form-message">
            <?php 
            if (isset($form_message)) {
                echo $form_message;
            }
            ?>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-lg-12">
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <h5><?php echo $page_title ?></h5>
                <div class="ibox-tools">
                    <a class="collapse-link">
                        <i class="fa fa-chevron-up"></i>
                    </a>
                </div>
            </div>
            <div class="ibox-content">

                <div class="">
                    <?php echo form_open($form_action, 'enctype="multipart/form-data" role="form"'); ?>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="f_username">Username:</label>
                                    <strong><?php echo $post['f_username']; ?></strong>
                                </div>
                                <div class="form-group">
                                    <label for="f_nik">NIK <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="f_nik" id="f_nik" value="<?php echo (isset($post['f_nik'])) ? $post['f_nik'] : ''; ?>" required="required"/>
                                </div>
                                <div class="form-group">
                                    <label for="f_firstname">First Name <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="f_firstname" id="f_firstname" value="<?php echo (isset($post['f_firstname'])) ? $post['f_firstname'] : ''; ?>" required="required"/>
                                </div>
                                <div class="form-group">
                                    <label for="f_lastname">Last Name <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="f_lastname" id="f_lastname" value="<?php echo (isset($post['f_lastname'])) ? $post['f_lastname'] : ''; ?>" required="required"/>
                                </div>
                                <div class="form-group">
                                    <label for="f_mail">Email <span class="text-danger">*</span></label>
                                    <input type="email" class="form-control" name="f_mail" id="f_mail" value="<?php echo (isset($post['f_mail'])) ? $post['f_mail'] : ''; ?>" required="required"/>
                                </div>

                                <div class="form-group">
                                    <label for="f_phone">Phone</label>
                                    <input type="text" class="form-control" name="f_phone" id="f_phone" value="<?php echo (isset($post['f_phone'])) ? $post['f_phone'] : ''; ?>"/>
                                </div>
                                <div class="form-group">
                                    <button class="btn btn-info" id="change_pass" type="button" data-toggle="modal" data-target="#passModal">Change Password</button>
                                </div>
                            </div>
                            <!-- <div class="col-lg-4 col-lg-offset-2">
                                <div class="form-group">
                                    <label for="themes">Themes</label>
                                    <select class="form-control" name="themes" id="themes">
                                        <option value="sbadmin2">SBADMIN 2</option>
                                        <option value="inspinia">Inspinia</option>
                                    </select>
                                </div> -->
                            <?php /*?>    
                                <div class="form-group">
                                    <label for="image">Image</label>
                                    <div class="fileinput fileinput-new" data-provides="fileinput">
                                        <div class="fileinput-new thumbnail" style="width: 200px; height: 150px;">
                                            <?php if (isset($post['image']) && $post['image'] != '' && file_exists(UPLOAD_DIR.'admin/'.$post['image'])): ?>
                                                <img src="<?php echo RELATIVE_UPLOAD_DIR.'admin/tmb_'.$post['image']; ?>" id="post-image" />
                                                <span class="btn btn-danger btn-delete-photo" id="delete-picture" data-id="<?php echo $post['id_auth_user']; ?>">x</span>
                                            <?php endif; ?>
                                        </div>
                                        <div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 200px; max-height: 150px;"></div>
                                        <div>
                                            <span class="btn btn-default btn-file">
                                                <span class="fileinput-new">Select image</span><span class="fileinput-exists">Change</span>
                                                <input type="file" name="image">
                                            </span>
                                            <a href="#" class="btn btn-default fileinput-exists" data-dismiss="fileinput">Remove</a>
                                        </div>
                                    </div>
                                </div>
                            <?php */ ?>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-4 col-lg-offset-8">
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </div>
                        </div>
                        <!-- /.row (nested) -->
                    <?php echo form_close(); ?>
                </div>

            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="passModal" tabindex="-1" role="dialog" aria-labelledby="passModalLabel" aria-hidden="true">
    <!-- Modal Dialog -->
    <div class="modal-dialog">
        <!-- Modal Content -->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                Change Password
            </div>
            <div class="modal-body">
                <form action="<?php echo $changepass_form; ?>" method="post" id="change_pass_form" onsubmit="return false;">
                    <div id="print-msg" class="error"></div>
                    <div class="form-group">
                        <label for="old_password" class="control-label">Old Password:</label>
                        <input type="password" id="old_password" class="form-control" name="old_password" value="" required="required" />
                    </div>
                    <div class="form-group">
                        <label for="f_password" class="control-label">New Password:</label>
                        <input type="password" id="f_password" class="form-control" name="f_password" value="" required="required" />
                    </div>
                    <div class="form-group">
                        <label for="conf_password" class="control-label">Confirm New Password:</label>
                        <input type="password" id="conf_password" class="form-control" name="conf_password" value="" required="required" />
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button class="btn btn-primary" id="save_password" type="button">Save changes</button>
                <button class="btn btn-warning" data-dismiss="modal" aria-hidden="true" type="button">Close</button>
            </div>
        </div><!-- Modal Content -->
    </div><!-- Modal Dialog -->
</div><!-- Modal -->
<script type="text/javascript">
    $("#save_password").click(function() {
        $("#print-msg").empty();
        var self = $(this),
            self_html = $(this).html();
        var old_password = $("#old_password").val();
        var f_password = $("#f_password").val();
        var conf_password = $("#conf_password").val();
        if (old_password != '') {
            if (f_password != '' && (conf_password == f_password)) {
                var data = $('#change_pass_form').serializeArray();
                submit_ajax('<?php echo $changepass_form; ?>', data, self)
                    .done(function(data) {
                        if (data['location']) {
                            window.location = data['location'];
                            return;
                        }
                        if (data['error']) {
                            $("#print-msg").html(data['error']);
                        }
                        if (data['success']) {
                            $("#print-msg").html(data['success']);
                            setTimeout(function() {
                                if (data['redirect']) {
                                    window.location = data['redirect'];
                                }
                            }, 1000);
                        }
                        self.html(self_html).removeAttr('disabled');
                    });
            } else {
                $("#print-msg").html('<?php echo alert_box('Please input Your New Password or Confirmation is not correct.', 'danger'); ?>');
            }
        } else {
            $("#print-msg").html('<?php echo alert_box('Please input Your old password.', 'danger'); ?>');
        }
    });
</script>