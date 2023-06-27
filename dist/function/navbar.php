<!-- BEGIN Page Wrapper -->
<div class="wrapper">
	<!-- BEGIN Header -->
	<div class="header">
		<!-- BEGIN Desktop Sticky Header -->
		<div class="sticky-header" id="sticky-header-desktop">
			<!-- BEGIN Header Holder -->
			<div class="header-holder header-holder-desktop">
				<div class="header-container container-fluid g-5">
					<div class="header-wrap header-wrap-block justify-content-start">
						<?php if(isset($_GET['p']) && $_GET['p'] != 'home'){?>
						<div class="dropdown d-inline">
							<a href="?p=home" class="btn btn-info btn-wider">หน้าหลัก</a>
						</div>
						<?php }?>
					</div>
					<div class="header-wrap hstack gap-2">

						<!-- BEGIN Dropdown -->
						<div class="dropdown">
							<?php if (isset($_SESSION['login'])) { ?>
								<!-- END Dropdown -->
								<button class="btn btn-flat-primary widget13" data-bs-toggle="dropdown">
									<div class="widget13-text"> Hi <strong>User</strong>
									</div>
									<!-- BEGIN Avatar -->
									<div class="avatar avatar-info widget13-avatar">
										<div class="avatar-display">
											<i class="fa fa-user-alt"></i>
										</div>
									</div>
									<!-- END Avatar -->
								</button>
								<div class="dropdown-menu dropdown-menu-wide dropdown-menu-end dropdown-menu-animated overflow-hidden py-0">
									<!-- BEGIN Portlet -->
									<div class="portlet border-0">
										<div class="portlet-header bg-primary rounded-0">
											<!-- BEGIN Rich List Item -->
											<div class="rich-list-item w-100 p-0">
												<div class="rich-list-prepend">
													<!-- BEGIN Avatar -->
													<div class="avatar avatar-label-light avatar-circle">
														<div class="avatar-display">
															<i class="fa fa-user-alt"></i>
														</div>
													</div>
													<!-- END Avatar -->
												</div>
												<div class="rich-list-content">
													<h3 class="rich-list-title text-white">Charlie Stone</h3>
													<span class="rich-list-subtitle text-white">admin@blueupcode.com</span>
												</div>
												<div class="rich-list-append">
													<span class="badge badge-label-light fs-6">9+</span>
												</div>
											</div>
											<!-- END Rich List Item -->
										</div>
										<div class="portlet-body p-0">
											<!-- BEGIN Grid Nav -->
											<div class="grid-nav grid-nav-flush grid-nav-action grid-nav-no-rounded">
												<div class="grid-nav-row">
													<a href="#" class="grid-nav-item">
														<div class="grid-nav-icon">
															<i class="far fa-address-card"></i>
														</div>
														<span class="grid-nav-content">Profile</span>
													</a>
													<a href="#" class="grid-nav-item">
														<div class="grid-nav-icon">
															<i class="far fa-comments"></i>
														</div>
														<span class="grid-nav-content">Messages</span>
													</a>
													<a href="#" class="grid-nav-item">
														<div class="grid-nav-icon">
															<i class="far fa-clone"></i>
														</div>
														<span class="grid-nav-content">Activities</span>
													</a>
												</div>
												<div class="grid-nav-row">
													<a href="#" class="grid-nav-item">
														<div class="grid-nav-icon">
															<i class="far fa-calendar-check"></i>
														</div>
														<span class="grid-nav-content">Tasks</span>
													</a>
													<a href="#" class="grid-nav-item">
														<div class="grid-nav-icon">
															<i class="far fa-sticky-note"></i>
														</div>
														<span class="grid-nav-content">Notes</span>
													</a>
													<a href="#" class="grid-nav-item">
														<div class="grid-nav-icon">
															<i class="far fa-bell"></i>
														</div>
														<span class="grid-nav-content">Notification</span>
													</a>
												</div>
											</div>
											<!-- END Grid Nav -->
										</div>
										<div class="portlet-footer portlet-footer-bordered rounded-0">
											<button class="btn btn-label-danger">Sign out</button>
										</div>
									</div>
									<!-- END Portlet -->
								</div>
							<?php } else {
								echo '<button class="btn btn-flat-primary widget13" data-bs-toggle="dropdown">
								<div class="widget13-text"> ยินดีต้อนรับ <strong></strong>
								</div>
								<!-- BEGIN Avatar -->
								<div class="avatar avatar-info widget13-avatar">
									<div class="avatar-display">
										<i class="fa fa-user-alt"></i>
									</div>
								</div>
								<!-- END Avatar -->
							</button>';
							} ?>
						</div>
						<!-- END Dropdown -->
					</div>
				</div>
			</div>
			<!-- END Header Holder -->
		</div>
		<!-- END Desktop Sticky Header -->
		<?php if (isset($_GET['login'])) { ?>
			<!-- BEGIN Header Holder -->
			<div class="header-holder header-holder-desktop">
				<div class="header-container container-fluid g-5">
					<h4 class="header-title">Dashboard</h4>
					<i class="header-divider"></i>
					<div class="header-wrap header-wrap-block justify-content-start">
						<!-- BEGIN Breadcrumb -->
						<div class="breadcrumb breadcrumb-transparent mb-0">
							<a href="index.html" class="breadcrumb-item">
								<div class="breadcrumb-icon">
									<i data-feather="home"></i>
								</div>
								<span class="breadcrumb-text">Dashboard</span>
							</a>
						</div>
						<!-- END Breadcrumb -->
					</div>

					<div class="header-wrap">
						<button class="btn btn-label-info btn-icon" id="fullscreen-trigger" data-bs-toggle="tooltip" title="Toggle fullscreen" data-bs-placement="left">
							<i class="fa fa-expand fullscreen-icon-expand"></i>
							<i class="fa fa-compress fullscreen-icon-compress"></i>
						</button>
					</div>
				</div>
			</div>
			<!-- END Header Holder -->
		<?php } ?>


		<?php include('function/navbarMobile.php'); ?>


		<?php if (isset($_GET['login'])) { ?>
			<!-- BEGIN Header Holder -->
			<div class="header-holder header-holder-mobile">
				<div class="header-container container-fluid g-5">
					<div class="header-wrap header-wrap-block justify-content-start w-100">
						<!-- BEGIN Breadcrumb -->
						<div class="breadcrumb breadcrumb-transparent mb-0">
							<a href="index.html" class="breadcrumb-item">
								<div class="breadcrumb-icon">
									<i data-feather="home"></i>
								</div>
								<span class="breadcrumb-text">Dashboard</span>
							</a>
						</div>
						<!-- END Breadcrumb -->
					</div>
				</div>
			</div>
			<!-- END Header Holder -->
		<?php } ?>
	</div>
	<!-- END Header -->
	<!-- BEGIN Page Content -->
	<div class="content">
		<div class="container-fluid g-5">
			<div class="row">
				<div class="col-12">
					<!-- BEGIN Portlet -->
					<div class="portlet">