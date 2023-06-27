<!DOCTYPE html>
<html lang="en" dir="ltr" data-theme="light">

<head>
    <!-- Global site tag (gtag.js) - Google Analytics -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@200;300;400;500;600&amp;family=Roboto+Mono&amp;display=swap" rel="stylesheet">
    <link href="assets/build/styles/ltr-core.css" rel="stylesheet">
    <link href="assets/build/styles/ltr-vendor.css" rel="stylesheet">
    <link href="assets/images/favicon.ico" rel="shortcut icon" type="image/x-icon">
    <title>Login 1 | Upmin</title>
</head>

<body class="preload-active">
    <!-- BEGIN Preload -->
    <div class="preload">
        <div class="preload-dialog">
            <!-- BEGIN Spinner -->
            <div class="spinner-border text-primary preload-spinner"></div>
            <!-- END Spinner -->
        </div>
    </div>
    <!-- END Preload -->
    <!-- BEGIN Page Holder -->
    <div class="holder">
        <!-- BEGIN Page Wrapper -->
        <div class="wrapper ">
            <!-- BEGIN Page Content -->
            <div class="content">
                <div class="container-fluid g-5">
                    <div class="row g-0 align-items-center justify-content-center h-100">
                        <div class="col-sm-8 col-md-6 col-lg-4 col-xl-3">
                            <!-- BEGIN Portlet -->
                            <div class="portlet">
                                <div class="portlet-body">
                                    <div class="text-center mt-4 mb-5">
                                        <!-- BEGIN Avatar -->
                                        <div class="avatar avatar-label-primary avatar-circle widget12">
                                            <div class="avatar-display">
                                                <i class="fa fa-user-alt"></i>
                                            </div>
                                        </div>
                                        <!-- END Avatar -->
                                    </div>
                                    <!-- BEGIN Form -->
                                    <form class="d-grid gap-3" method="POST">
                                        <!-- BEGIN Validation Container -->
                                        <div class="validation-container">
                                            <!-- BEGIN Form Floating -->
                                            <div class="form-floating">
                                                <input class="form-control form-control-lg" type="username" id="username" name="username" placeholder="กรอกชื่ิผู้ใช้งาน" required>
                                                <label for="username">ชื่อผู้ใช้งาน</label>
                                            </div>
                                            <!-- END Form Floating -->
                                        </div>

                                        <!-- END Validation Container -->
                                        <!-- BEGIN Validation Container -->
                                        <div class="validation-container">
                                            <!-- BEGIN Form Floating -->
                                            <div class="form-floating">
                                                <input class="form-control form-control-lg" type="password" id="password" name="password" placeholder="รหัสผ่าน" required>
                                                <label for="password">รหัสผ่าน</label>
                                            </div>
                                            <!-- END Form Floating -->
                                        </div>
                                        <!-- END Validation Container -->
                                        <!-- BEGIN Flex -->
                                        <div class="d-flex align-items-center justify-content-between">
                                            <div class="validation-container">
                                                <!-- BEGIN Form Check -->
                                                <!-- <div class="form-check form-switch">
													<input class="form-check-input" type="checkbox" id="remember" name="remember">
													<label class="form-check-label" for="remember"></label>
												</div> -->
                                                <!-- END Form Check -->
                                            </div>
                                            <!-- <a href="#">Forgot password?</a> -->
                                        </div>
                                        <!-- END Flex -->
                                        <!-- BEGIN Flex -->
                                        <div class="d-flex align-items-center justify-content-between">
                                            <span></span>
                                            <button type="button" id="login-form" class="btn btn-label-primary btn-lg btn-widest">เข้าสู่ระบบ</button>
                                        </div>
                                        <!-- END Flex -->
                                    </form>
                                    <!-- END Form -->
                                </div>
                            </div>
                            <!-- END Portlet -->
                        </div>
                    </div>
                </div>
            </div>
            <!-- END Page Content -->
        </div>
        <!-- END Page Wrapper -->
    </div>
    <!-- END Page Holder -->
    <!-- BEGIN Float Button -->
    <!-- <div class="floating-btn floating-btn-end d-grid gap-2">
		<button class="btn btn-flat-primary btn-icon" data-bs-toggle="tooltip" data-bs-placement="right" title="Change theme" id="theme-toggle">
			<i class="fa fa-moon"></i>
		</button>
	</div> -->
    <!-- END Float Button -->
    <script type="text/javascript" src="assets/build/scripts/mandatory.js"></script>
    <script type="text/javascript" src="assets/build/scripts/core.js"></script>
    <script type="text/javascript" src="assets/build/scripts/vendor.js"></script>
    <script type="text/javascript" src="assets/app/utilities/sticky-header.js"></script>
    <script type="text/javascript" src="assets/app/utilities/copyright-year.js"></script>
    <script type="text/javascript" src="assets/app/utilities/theme-switcher.js"></script>
    <script type="text/javascript" src="assets/app/utilities/tooltip-popover.js"></script>
    <script type="text/javascript" src="assets/app/utilities/dropdown-scrollbar.js"></script>
    <script type="text/javascript" src="assets/app/utilities/fullscreen-trigger.js"></script>
    <script type="text/javascript" src="assets/app/pages/pages/login.js"></script>
</body>
<script>
    $(function() {
        $('#login-form').click(() => {
            let username = $('#username').val()
            let password = $('#password').val()
            let option = {
                url: 'controller/login.php',
                type: 'post',
                data: {
                    username: username,
                    password: password,
                    login: 1
                },
                success: function(res) {
                    if (res == 0) {
                        Swal.fire(
                            'ไม่มีผู้ใช้นี้ในระบบ!!',
                            '',
                            'error'
                        )
                    } else if (res == 1) {
                        Swal.fire(
                            'รหัสผ่านไม่ถูกต้อง!!',
                            '',
                            'error'
                        )
                        $('#password').val('')
                    } else {
                        Swal.fire(
                            'เข้าสู่ระบบสำเร็จ',
                            'ยินดีต้อนรับเข้าสู่ระบบ',
                            'success'
                        )
                        setTimeout(() => {
                            location.href = "index.php"
                        }, 700)
                    }
                }
            }
            if (username == '') {
                Swal.fire(
                    'กรุณากรอกชื่อผู้ใช้!!',
                    '',
                    'warning'
                )
            } else if (password == '') {
                Swal.fire(
                    'กรุณากรอกรหัสผ่าน!!',
                    '',
                    'warning'
                )
            } else {
                $.ajax(option)
            }


        })
    })
</script>

</html>