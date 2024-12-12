<!--**********************************
            Content body start
        ***********************************-->
<div class="content-body">
    <div class="container-fluid">
        <div class="row page-titles">
            <ol class="breadcrumb">
                <li class="breadcrumb-item active"><a href="javascript:void(0)"><?= $title ?></a></li>
                <li class="breadcrumb-item"><a href="javascript:void(0)"><?= $sub_title ?></a></li>
            </ol>
        </div>
        <!-- row -->
        <div class="row">
            <div class="col-xl-12 col-xxl-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title"><?= $sub_title ?></h4>
                    </div>
                    <div class="col-xl-12 col-lg-12">
                        <div class="card-body">
                            <div class="basic-form">
                                <?= form_open_multipart('auth/Change_Pass'); ?>
                                <?= $this->session->flashdata('alert_message') ?>
                                <div class="mb-3">
                                    <label class="mb-1"><strong>Old Password</strong></label>
                                    <input type="password" class="form-control" name="oldpassword" id="oldpassword" readonly value="<?= $user['password'] ?>">
                                    <span><input type="checkbox" class="form-checkbox2"></span>

                                </div>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <label class="mb-1"><strong>New Password</strong></label>
                                        <input type="password" class="form-control" name="new_password" id="new_password">
                                        <span><input type="checkbox" class="form-checkbox"></span>
                                    </div>
                                    <div class="col-sm-6">
                                        <label class="mb-1"><strong>Konfirmasi Password</strong></label>
                                        <input type="password" class="form-control" name="confirm_password" id="confirm_password">
                                        <input type="checkbox" class="form-checkbox1">
                                        <div id="password_mismatch_error" style="color: red; display: none;"></div>
                                    </div>
                                    <?php if (form_error('password1')) : ?>
                                        <?= form_error('password1', '<div class="invalid-feedback-active">', '</div>') ?>
                                    <?php endif; ?>
                                </div>
                                <div class="mb-3 row">
                                    <div class="col-sm-10">
                                        <button type="submit" class="btn btn-primary">Simpan</button>
                                    </div>
                                </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript">
        $(document).ready(function() {
            $('.form-checkbox').click(function() {
                if ($(this).is(':checked')) {
                    $('#new_password').attr('type', 'text');
                } else {
                    $('#new_password').attr('type', 'password');
                }
            });
        });
        $(document).ready(function() {
            $('.form-checkbox1').click(function() {
                if ($(this).is(':checked')) {
                    $('#confirm_password').attr('type', 'text');
                } else {
                    $('#confirm_password').attr('type', 'password');
                }
            });
        });
        $(document).ready(function() {
            $('.form-checkbox2').click(function() {
                if ($(this).is(':checked')) {
                    $('#oldpassword').attr('type', 'text');
                } else {
                    $('#oldpassword').attr('type', 'password');
                }
            });
        });
    </script>
    <!-- <script>
        $(document).ready(function() {
            // Function to validate passwords
            function validatePasswords() {
                var newPassword = $("#new_password").val();
                var confirmPassword = $("#confirm_password").val();

                if (newPassword !== confirmPassword) {
                    $("#password_mismatch_error").text("Password and Konfirmasi Password must match").show();
                    return false;
                } else {
                    $("#password_mismatch_error").hide();
                    return true;
                }
            }

            // Validate passwords on form submission
            $("form").submit(function() {
                return validatePasswords();
            });

            // Validate passwords on input change
            $("#new_password, #confirm_password").on("input", function() {
                validatePasswords();
            });
        });
    </script> -->
    <script>
        $(document).ready(function() {
            // Function to validate passwords
            function validatePasswords() {
                var newPassword = $("#new_password").val();
                var confirmPassword = $("#confirm_password").val();

                if (newPassword === "" || confirmPassword === "") {
                    $("#password_mismatch_error").text("").show();
                    return false;
                }

                if (newPassword !== confirmPassword) {
                    $("#password_mismatch_error").text("Password and Konfirmasi Password must match").show();
                    return false;
                } else {
                    $("#password_mismatch_error").hide();
                    return true;
                }
            }

            // Validate passwords on form submission
            $("form").submit(function() {
                return validatePasswords();
            });

            // Validate passwords on input change
            $("#new_password, #confirm_password").on("input", function() {
                validatePasswords();
            });
        });
    </script>


</div>
</div>
<!--**********************************
            Content body end
        ***********************************-->