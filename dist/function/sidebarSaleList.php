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
							<h2 class="menu-section-text">จัดการรายการขาย</h2>
						</div>
						<!-- END Menu Section -->
						<div class="menu-item">
							<a href="?p=salelist" class="menu-item-link">
								<div class="menu-item-icon">
									<i class="fa fa-palette"></i>
								</div>
								<span class="menu-item-text">รายการขายทั้งหมด</span>
							</a>

						</div>
						<div class="menu-item">
							<a href="?p=salereport" class="menu-item-link">
								<div class="menu-item-icon">
									<i class="fa fa-dice"></i>
								</div>
								<span class="menu-item-text">รายงานการขาย</span>
							</a>
						</div>
						<!-- <div class="menu-item">
							<a href="?p=salecustomerreport" class="menu-item-link">
								<div class="menu-item-icon">
									<i class="fa fa-th-list"></i>
								</div>
								<span class="menu-item-text">สถิติลูกค้า/การซื้อ</span>
							</a>
						</div> -->
						<!-- <div class="menu-item">
							<a href="?p=returnreport" class="menu-item-link">
								<div class="menu-item-icon">
									<i class="fa fa-fill-drip"></i>
								</div>
								<span class="menu-item-text">รายงานคืนสินค้า</span>
							</a>
						</div> -->
						<div class="menu-item">
							<a href="?p=supplierreport" class="menu-item-link">
							<div class="menu-item-icon">
									<i class="fa fa-fill-drip"></i>
								</div>
								<span class="menu-item-text">รายงานการขาย สินค้าของ Supplier</span>
							</a>
						</div>
						<div class="menu-item">
							<a href="?p=salesumaryreport" class="menu-item-link">
							<div class="menu-item-icon">
									<i class="fa fa-pencil-ruler"></i>
								</div>
								<span class="menu-item-text">รายงานยอดการขาย</span>
							</a>
						</div>


					</div>
					<!-- END Menu -->
				</div>
			</div>
			<!-- END Aside -->
		<?php } ?>