<div class="portlet-header portlet-header-bordered">
        <h3 class="portlet-title">
        </h3>
        <button class="btn btn-danger btn-sm show-text" onclick="togglebtn()">แสดงปุ่มลบ</button>
    </div>
    <div class="portlet-body">
        <div class="table-responsive">
            <table class="table table-striped table-hover mb-0" id="dataSaleList">
                <thead>
                    <tr>
                        <th>ลำดับ</th>
                        <th>รหัสการขาย</th>
                        <th>ชื่อลูกค้า</th>
                        <th>จำนวนสินค้า</th>
                        <th>ราคาที่ขาย</th>
                        <th>vat/บาท</th>
                        <th>รวม vat/บาท</th>
                        <th>รับเงิน</th>
                        <th>ทอนเงิน</th>
                        <th>วันที่ขาย</th>
                        <th class="show-delete d-none">จัดการ</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $i = 1;
                    $showList = $con->query("SELECT * FROM `tb_sale_product`");
                    foreach ($showList as $row) :
                    ?>
                        <tr id="row<?php echo $row['sp_id'] ?>">
                            <th scope="row"><?php echo $i++ ?></th>
                            <td><button onclick="ShowOrder(<?php echo $row['sp_id']?>)" class="btn btn-sm btn-primary" ><?php echo $row['order_code'] ?></button></td>
                            <td><?php echo 'ชื่อลูกค้า' ?></td>
                            <td><?php echo number_format($row['sp_qty_sale']); ?></td>
                            <td><?php echo number_format($row['sp_sell']); ?></td>
                            <td><?php echo number_format($row['vat']) ?></td>
                            <td><?php echo number_format($row['total_sum_vat']); ?></td>
                            <td><?php echo number_format($row['get_money']); ?></td>
                            <td><?php echo number_format($row['change_money']); ?></td>
                            <td><?php echo $row['sell_date'] ?></td>
                            <td class="show-delete d-none">
                                <button class="btn btn-danger btn-sm " onclick="remove_row(<?php echo $row['sp_id']; ?>)">ลบ</button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <!-- END Table -->
        <!-- <button id="add-row">add row</button> -->
    </div>

	<!-- BEGIN Modal -->
	<div class="modal fade" id="ModalListOrder" data-bs-backdrop="static">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title">รายการขายสินค้า</h5>
					<button type="button" class="btn btn-label-danger btn-icon" data-bs-dismiss="modal">
						<i class="fa fa-times"></i>
					</button>
				</div>
                <div class="table-responsive">
                    <div class="modal-body" id="resultOrder">
                </div>
				</div>
				<div class="modal-footer">
                    <button class="btn btn-outline-success">พิมพ์</button>
					<button class="btn btn-primary">ปิด</button>
				</div>
			</div>
		</div>
	</div>
	<!-- END Modal -->

    <script>
        var table = $('#dataSaleList').DataTable();

        $('#add-row').click(function() {
            var name = $('#name').val();
            var age = $('#age').val();
            var gender = $('#gender').val();
            var newRow = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, '<button class="btn btn-danger btn-sm" onclick="Hello()">ลบ</button>']

            table.row.add(newRow).draw(false);
        });

        function Hello() {
            alert('click')
        }

        function togglebtn() {
            $('.show-delete').toggleClass('d-none')
            if ($('.show-delete').hasClass('d-none')) {
                $('.show-text').removeClass('btn-success')
                $('.show-text').addClass('btn-danger')
                $('.show-text').text('แสดงปุ่มลบ')
            } else {

                $('.show-text').removeClass('btn-danger')
                $('.show-text').addClass('btn-success')
                $('.show-text').text('ปิดปุ่มลบ')
            }
        }

        function remove_row(id) {
            let option = {
                url: "controller/SaleListController.php",
                type: "post",
                data: {
                    id: id,
                    DeleteRowSaleList: 1
                },
                success: function(res) {
                    $('#row' + id + '').remove()
                }
            }
            $.ajax(option)
        }

        function ShowOrder(id){
            let option = {
                url:'controller/SaleListController.php',
                type:'post',
                data:{
                    id:id,
                    ShowOrder:1
                },
                success:function(res){
                    $('#resultOrder').html(res)
                    $('#ModalListOrder').modal('show')
                }
            }
            $.ajax(option)
        }
    </script>