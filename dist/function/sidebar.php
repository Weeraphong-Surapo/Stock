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
							<h2 class="menu-section-text">จัดการสต๊อคสินค้า</h2>
						</div>
						<!-- END Menu Section -->
						<div class="menu-item">
							<a href="?p=stock" class="menu-item-link">
								<div class="menu-item-icon">
									<i class="fa fa-palette"></i>
								</div>
								<span class="menu-item-text">สินค้าในสต๊อก</span>
							</a>

						</div>
						<div class="menu-item">
							<a href="?p=importproduct" class="menu-item-link">
								<div class="menu-item-icon">
									<i class="fa fa-dice"></i>
								</div>
								<span class="menu-item-text">นำเข้าสินค้า</span>
							</a>
						</div>
						<div class="menu-item">
							<a href="?p=productlist" class="menu-item-link">
								<div class="menu-item-icon">
									<i class="fa fa-th-list"></i>
								</div>
								<span class="menu-item-text">รายการสินค้า</span>
							</a>
						</div>
						<div class="menu-item">
							<a href="?p=productcategory" class="menu-item-link">
								<div class="menu-item-icon">
									<i class="fa fa-fill-drip"></i>
								</div>
								<span class="menu-item-text">หมวดหมู่สินค้า</span>
							</a>
						</div>
						<div class="menu-item">
							<a href="?p=productsubcategory" class="menu-item-link">
								<div class="menu-item-icon">
									<i class="fa fa-fill-drip"></i>
								</div>
								<span class="menu-item-text">ประเภทสินค้า</span>
							</a>
						</div>
						<div class="menu-item">
							<a href="?p=counting" class="menu-item-link">
							<div class="menu-item-icon">
									<i class="fa fa-fill-drip"></i>
								</div>
								<span class="menu-item-text">หน่วยสินค้า</span>
							</a>
						</div>
						<div class="menu-item">
							<a href="?p=supplier" class="menu-item-link">
							<div class="menu-item-icon">
									<i class="fa fa-pencil-ruler"></i>
								</div>
								<span class="menu-item-text">Supplier/ผู้ผลิต/เจ้าของสินค้า</span>
							</a>
						</div>
						<div class="menu-section">
							<div class="menu-section-icon">
								<i class="fa fa-ellipsis-h"></i>
							</div>
							<h2 class="menu-section-text">การยืมสินค้า</h2>
						</div>
						<div class="menu-item">
							<a href="?p=borrow" class="menu-item-link">
							<div class="menu-item-icon">
									<i class="fa fa-fill-drip"></i>
								</div>
								<span class="menu-item-text">ยืมสินค้า</span>
							</a>
						</div>

					</div>
					<!-- END Menu -->
				</div>
			</div>
			<!-- END Aside -->
		<?php } ?>