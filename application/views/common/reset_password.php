<?php if (isset($needsTitle) && $needsTitle) : ?>
    <!-- begin page-header -->
    <h1 class="__page-header"><?= $title ?> <small><?= $sub_title ?></small></h1>
    <!-- end page-header -->
<?php endif; ?>

<form action="<?= site_url('profile/update') ?>" method="post">
    <div class="card">
        <div class="card-header">
            <h5 class="m-b-0">Form Update Password</h5>
        </div>

        <div class="card-block">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group row">
                        <label class="col-form-label col-md-4">Username</label>
                        <div class="col-md-8">
                            <input type="text" name="username" id="username" class="form-control" value="<?= $row['USERNAME_LOGIN'] ?>" readonly>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-form-label col-md-4">Password Baru</label>
                        <div class="col-md-8">
                            <input type="password" name="new_password" id="new_password" class="form-control" required>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-form-label col-md-4">Konfirmasi Password</label>
                        <div class="col-md-8">
                            <input type="password" name="new_password_confirm" id="new_password_confirm" class="form-control" required>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card-footer bg-white text-right">
            <a href="<?php echo base_url('home') ?>" class="btn btn-sm btn-default">Cancel</a>
            <button type="submit" name="btn_submit" id="btn_submit" class="btn btn-sm btn-primary m-r-5">Update</button>
        </div>
    </div>
</form>

<script type="text/javascript">
    $(function() {
        $("#btn_submit").click(function() {
            var password = $("#new_password").val();
            var confirmPassword = $("#new_password_confirm").val();
            if (password != confirmPassword) {
                alert("Password Tidak Cocok");
                return false;
            }
            return true;
        });
    });
</script>
