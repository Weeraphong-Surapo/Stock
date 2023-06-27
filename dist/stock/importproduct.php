<style>
    @media (max-width: 820px){
        .cc-top-f{
            width: calc(100% / 2) !important;
        }
    }
    .td-input{
        width: 200px;
    }
    ::-webkit-inner-spin-button,
    ::-webkit-outer-spin-button{
        display: none !important;
    }
</style>

<?php $sale_product = $con->query("SELECT * FROM tb_sale_product"); ?>

<div class="portlet-header portlet-header-bordered">
    <h3 class="portlet-title">นำเข้าสินค้า</h3>
</div>

<div class="card card-body" style="border: none !important; border-bottom: 1px dashed #aaa !important;">
    <div class="d-flex gap-2">
        <input id="cc-input-1" class="form-control" style="width: 300px;" type="text" placeholder="ค้นหาจากชื่อสินค้า หรือ แสกนบาร์โค้ด">
        <button id="cc-search-1" class="btn btn-success">ค้นหา</button>
        <button id="cc-refresh-1" class="btn btn-secondary">รีเฟรช</button>
    </div>

    <div class="d-flex justify-content-end me-3">
        <div class="d-flex gap-2">
            <button class="btn btn-danger py-0" id="cc-checkbox">แสดงปุ่มลบ</button>
        </div>
    </div>

    <div class="portlet-body p-0">
        <!-- <p>Make your tables always responsive, use <code>.table-responsive</code> for horizontally scrolling tables.</p> -->
        <!-- <p>Use <code>.table-responsive{-sm|-md|-lg|-xl|-xxl}</code> as needed to create responsive tables up to a particular breakpoint. From that breakpoint and up, the table will behave normally and not scroll horizontally.</p> -->
        <!-- BEGIN Table -->
        <div class="table-responsive">
            <table class="table table-striped table-hover mb-0">
                <thead>
                    <tr>
                        <th>ลำดับ</th>
                        <th>สินค้า</th>
                        <th>รหัสสินค้า</th>
                        <th>ที่จัดเก็บ</th>
                        <th>ราคาทุนต่อหน่วย/บาท</th>
                        <th>จำนวนหน่วย</th>
                        <th>รวมราคา/บาท</th>
                        <th class="cc-manage d-none">ลบ</th>
                    </tr>
                </thead>
                <tbody id="result1">
                   <!-- ===================================== -->
                   <!-- ===================================== -->
                </tbody>
            </table>

            <div class="d-flex justify-content-end mt-3">
                <button id="btn-save" class="btn btn-success">บันทึก</button>
            </div>
        </div>
        <!-- END Table -->
    </div>
</div>

<!-- card 2 -->
<div class="card card-body mt-3">
    <div id="cc-search-2" class="d-flex gap-2">
        <input id="search-table-2" class="form-control" style="width: 300px;" type="text" placeholder="รหัสอ้างอิง หรือ หมายเหตุ">
        <!-- <button class="btn btn-success">ค้นหา</button> -->
        <button id="btn-reset" class="btn btn-secondary">รีเฟรช</button>
    </div>

    <div class="d-flex justify-content-end me-3">
        <div class="d-flex gap-2">
            <button class="btn btn-danger py-0" id="cc-checkbox2">แสดงปุ่มลบ</button>
        </div>
    </div>

    <div class="portlet-body p-0">
        <!-- <p>Make your tables always responsive, use <code>.table-responsive</code> for horizontally scrolling tables.</p> -->
        <!-- <p>Use <code>.table-responsive{-sm|-md|-lg|-xl|-xxl}</code> as needed to create responsive tables up to a particular breakpoint. From that breakpoint and up, the table will behave normally and not scroll horizontally.</p> -->
        <!-- BEGIN Table -->
        <div class="table-responsive">
            <table class="table table-striped table-hover mb-0" id="cc-table">
                <thead>
                    <tr>
                        <th>ลำดับ</th>
                        <th>Run No.</th>
                        <th>รหัสอ้างอิง</th>
                        <th>รวมราคา/บาท</th>
                        <th>หมายเหตุ</th>
                        <th>วันที่</th>
                        <th class="cc-manage2 d-none">ลบ</th>
                    </tr>
                </thead>
                <tbody>
                        <?php $num = 0; foreach($sale_product as $sp): $num++; ?>
                        <tr>
                            <td><?=$num?></td>
                            <td><?=$sp['order_code']?></td>
                            <td><?=$sp['sp_qty_sale']?></td>
                            <td><?=number_format($sp['sp_sell'])?></td>
                            <td></td>
                            <td><?=$sp['sell_date']?></td>
                            <td class="cc-manage2 d-none">
                                <button class="btn btn-danger py-0">ลบ</button>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <!-- END Table -->
    </div>

</div>

<script>
    // hidden button delete
    $('#cc-checkbox').click((e) => $('.cc-manage').toggleClass("d-none"))
    $('#cc-checkbox2').click((e) => $('.cc-manage2').toggleClass("d-none"))

    // search top
    $('#cc-search-1').click((e) => {
        e.preventDefault()
        $.ajax({
            url: 'controller/action.php',
            type:'post',
            data: {
                id: $('#cc-input-1').val(),
                search: 1
            },
            success: (res) => {
                $('#result1').html(res)
            }
        });
    })

    // refresh
    $('#cc-refresh-1').click((e) => {
        e.preventDefault()
        $('#result1').html('')
        $('#cc-input-1').val('')
    })

    // save
    $('#btn-save').click((e) => {
        e.preventDefault()
        $.ajax({
            url: 'controller/action.php',
            type:'post',
            data: {
                id: $('#cc-id').val(),
                cost: $('#cc-cost').val(),
                qty: $('#cc-qty').val(),
                sum: $('#cc-sum').val(),
                saveimport: 1
            },
            success: (res) => {
                $('#result1').html(res)
                $('.cc-manage').addClass("d-none")
                swalsuccess()
            }
        });
    })

    // sweet alert success
    const swalsuccess = () => {
        Swal.fire({
            position: 'bottom-end',
            icon: 'success',
            title: '',
            showConfirmButton: false,
            timer: 1200
        })
    }

    // delete productlist
    const delPro = (id) => {
        const data = new FormData()
        data.append('form_productlist', "delete")
        data.append('id', id)
        data.append('delPro', 1)

        $.ajax({
            url: 'controller/action.php',
            type: 'post',
            data: data,
            contentType: false,
            processData: false,
            success: (res) => {
                $('#result1').html('')
                swalsuccess()
            }
        })
    }

    // sweet alert delete
    const swaldel = (id) => {
        Swal.fire({
            text: "ต้องการลบหรือไม่",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: 'blue',
            cancelButtonColor: 'red',
            confirmButtonText: 'ยืนยัน',
            cancelButtonText: 'ยกเลิก'
        }).then((result) => {
            if (result.isConfirmed) {
                delPro(id)
            }
        })
    }

    // search
    $('#search-table-2').keyup(() => {
        search_table($('#search-table-2').val())
    })

    const search_table = (value) => {
        $('#cc-table tbody tr').each((index, element) => {
            var found = false
            $(element).find('td').each((index, td) => {
                if($(td).text().toLowerCase().indexOf(value.toLowerCase()) >= 0) found = true
            })
            if(found) $(element).show()   
            else $(element).hide()
        })
    }

    // search reset
    $('#btn-reset').click(() => {
        $('#search-table-2').val('')
        search_table('')
    })
</script>


