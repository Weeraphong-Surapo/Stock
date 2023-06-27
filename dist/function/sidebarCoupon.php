<?php if (isset($_GET['p']) && $_GET['p'] != 'home' && $_GET['p'] != 'salepic') { ?>
			<!-- BEGIN Aside -->
			<div class="aside">
				<div class="aside-header">
					<h3 class="aside-title">Upmin</h3>
					<div class="aside-addon">
						<button class="btn btn-label-primary btn-icon btn-lg" data-toggle="aside">
							<i class="fa fa-times aside-icon-minimize"></i>
							<i class="fa fa-thumbtack aside-icon-maximize"></i>
						</button>
					</div>
				</div>
				<div class="aside-body" data-simplebar data-simplebar-direction="ltr">
					<!-- BEGIN Menu -->
					<div class="menu">
						<!-- BEGIN Menu Section -->
						<div class="menu-section">
							<div class="menu-section-icon">
								<i class="fa fa-ellipsis-h"></i>
							</div>
							<h2 class="menu-section-text">จัดการส่วนลด</h2>
						</div>
						<!-- END Menu Section -->
						<div class="menu-item">
							<a href="?p=setting-coupon" class="menu-item-link">
								<div class="menu-item-icon">
									<i class="fa fa-palette"></i>
								</div>
								<span class="menu-item-text">ตั้งค่าส่วนลด</span>
							</a>

						</div>
						<!-- <div class="menu-item">
							<a href="?p=contactlist" class="menu-item-link">
								<div class="menu-item-icon">
									<i class="fa fa-dice"></i>
								</div>
								<span class="menu-item-text">รายการติดต่อ</span>
							</a>
						</div> -->


					</div>
					<!-- END Menu -->
				</div>
			</div>
			<!-- END Aside -->
		<?php } ?>