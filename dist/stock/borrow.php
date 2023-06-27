<style>
    @media (max-width: 820px){
        .cc-top-f{
            width: calc(100% / 2) !important;
        }
    }
    .td-input{
        width: 200px;
    }
    /* ::-webkit-inner-spin-button,
    ::-webkit-outer-spin-button{
        display: none !important;
    } */
</style>


<?php $borrow= $con->query("SELECT * FROM tb_borrow"); ?>

<div class="portlet-header portlet-header-bordered">
    <h3 class="portlet-title">ยืมสินค้า</h3>
</div>

<div class="card card-body" style="border: none !important; border-bottom: 1px dashed #aaa !important;">
    <div class="d-flex gap-2">
        <input id="input" class="form-control" style="width: 300px;" type="text" placeholder="ค้นหาจากชื่อสินค้า หรือ แสกนบาร์โค้ด">
        <button id="btn-search" class="btn btn-success">ค้นหา</button>
        <button id="btn-reset" class="btn btn-secondary">รีเฟรช</button>
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
                        <th>จำนวนที่มี</th>
                        <th>จำนวนยืม</th>
                        <th>วันที่ยืม</th>

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
        <input id="search-table" class="form-control" style="width: 300px;" type="text" placeholder="รหัสอ้างอิง หรือ หมายเหตุ">
        <!-- <button class="btn btn-success">ค้นหา</button> -->
        <button id="btn-reset2" class="btn btn-secondary">รีเฟรช</button>
    </div>

    <div class="d-flex justify-content-end me-3">
        <div class="d-flex gap-2">
            <button class="btn btn-danger py-0" id="show-btn">แสดงปุ่มลบ</button>
        </div>
    </div>

    <div class="portlet-body p-0">
        <!-- <p>Make your tables always responsive, use <code>.table-responsive</code> for horizontally scrolling tables.</p> -->
        <!-- <p>Use <code>.table-responsive{-sm|-md|-lg|-xl|-xxl}</code> as needed to create responsive tables up to a particular breakpoint. From that breakpoint and up, the table will behave normally and not scroll horizontally.</p> -->
        <!-- BEGIN Table -->
        <div class="table-responsive">
            <table id="table" class="table table-striped table-hover mb-0" id="cc-table">
                <thead>
                    <tr>
                        <th>ลำดับ</th>
                        <th>สินค้า</th>
                        <th>รหัสสินค้า</th>
                        <th>ที่จัดเก็บ</th>
                        <th>จำนวนยืม</th> 
                        <th>วันที่ยืม</th>
                        <th style="width: 180px;">จัดการ</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                        $num = 0;
                        foreach($borrow as $bor):
                            $num++;
                    ?>
                        <tr>
                            <td><?=$num?></td>
                            <td><?=$bor['pl_name_product']?></td>
                            <td><?=$bor['pl_product_id']?></td>
                            <td><?=$bor['pl_storage']?></td>
                            <td><?=$bor['bor_quantity']?></td>
                            <td><?=$bor['bor_date']?></td>
                            <td style="width: 180px;">
                                <button class="btn btn-warning py-0" onclick="getdata(<?=$bor['bor_id']?>)">คืนสินค้า</button>
                                <button class="btn btn-danger py-0 cc-manage d-none" onclick="swaldel(<?=$bor['bor_id']?>)">ลบ</button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <!-- END Table -->
    </div>

</div>


<!-- Modal-->
<div class="modal fade" id="modal3" data-bs-backdrop="static">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">แก้ไข</h5>
                <button type="button" class="btn btn-label-danger btn-icon" data-bs-dismiss="modal">
                    <i class="fa fa-times"></i>
                </button>
            </div>
            <div class="modal-body">

                <form id="main-form" enctype="multipart/form-data">
                    <input type="hidden" id="bor-id">
                    <input type="hidden" id="pro-id">
                    <input type="hidden" id="oldqty">
                    <div class="row">
                        <div class="mb-3 col-6">
                            <label style="font-size: 10px">สินค้า</label>
                            <input id="product2" name="pl_name_product" class="form-control" type="text" disabled>
                        </div>

                        <div class="mb-3 col-6">
                            <label style="font-size: 10px">รหัสสินค้า</label>
                            <input id="product_id2" name="pl_product_id" class="form-control" type="text" disabled>
                        </div>

                          
                        <div class="mb-3 col-12">
                            <label style="font-size: 10px">ที่จัดเก็บ</label>
                            <input id="storage2" name="pl_product_id" class="form-control" type="text" disabled>
                        </div>

                          
                        <div class="mb-3 col-6">
                            <label style="font-size: 10px">จำนวนที่ยืม</label>
                            <input disabled id="qty2" name="pl_product_id" class="form-control" type="number">
                            <span class="text-danger d-none" style="font-size: 12px" id="nosave2">จำนวนไม่พอ</span>
                        </div>

                          
                        <div class="mb-3 col-6">
                            <label style="font-size: 10px">วันที่ยืม</label>
                            <input disabled id="date2" name="pl_product_id" class="form-control" type="date">
                        </div>

                        <div class="mb-3 col-6">
                            <label style="font-size: 10px">จำนวนคืน</label>
                            <input min="1" value="1" id="qtyReturn" class="form-control" type="number">
                            <span class="text-danger" style="font-size: 12px" id="nosave3"></span>
                        </div>

                        <div class="mb-3 col-6">
                            <label style="font-size: 10px">วันที่คืน</label>
                            <input id="dateReturn" class="form-control" type="date">
                        </div>

                        <!-- <div class="mb-3 col-12">
                            <label style="font-size: 10px">จำนวนคงเหลือยืม</label>
                            <input min="1" id="qtyReturn" class="form-control" type="number">
                            <span class="text-danger" style="font-size: 12px" id="nosave3"></span>
                        </div> -->

                    </div>
                </form>

            </div>
            <div class="modal-footer">
                <button id="btn-borrow" type="button" class="btn btn-primary">บันทึก</button>
            </div>
        </div>
    </div>
</div>

<script>

    var today = new Date().toISOString().substr(0, 10);

    // reset table 1
    $('#btn-reset').click(() => {
        $('#input').val('')
        $('#result1').html('')
    })

    // search top
    $('#btn-search').click((e) => {
        e.preventDefault()
        $.ajax({
            url: 'controller/action.php',
            type:'post',
            data: {
                id: $('#input').val(),
                searchborrow: 1
            },
            success: (res) => {
                $('#result1').html(res)
                $('#dateborrow').val(today)
            }
        });
    })

    // save
    $('#btn-save').click((e) => {
        if(parseInt($('#qtyborrow').val()) > parseInt($('#oldqty').text())){
            $('#nosave').text(`จำนวนที่ยืมได้สูงสุดคือ ${$('#oldqty').text()}`)
            return
        }else{
            $('#nosave').text("")
            const data = new FormData()
            data.append('saveborrow', 1)
            data.append('id', $('#product-id').text())
            data.append('product', $('#product').text())
            data.append('storage', $('#storage').text())
            data.append('oldqty', $('#oldqty').text())
            data.append('qtyborrow', $('#qtyborrow').val())
            data.append('dateborrow', $('#dateborrow').val())
            $.ajax({
                url: 'controller/action.php',
                type: 'post',  
                data: data,
                contentType: false,
                processData: false,
                success: (res) => {
                    if(res == 1){
                        swalsuccess()
                        setTimeout(() => location.reload(), 1200)
                    }else{ swalerror() }
                }
            });
        }

    })

    // sweet alert error
    const swalerror = () => {
        Swal.fire({
            position: 'bottom-end',
            icon: 'error',
            title: '',
            showConfirmButton: false,
            timer: 1200
        })
    }
        
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

    // search
    $('#search-table').keyup(() => {
        search_table($('#search-table').val())
    })

    const search_table = (value) => {
        $('#table tbody tr').each((index, element) => {
            var found = false
            $(element).find('td').each((index, td) => {
                if($(td).text().toLowerCase().indexOf(value.toLowerCase()) >= 0) found = true
            })
            if(found) $(element).show()   
            else $(element).hide()
        })
    }

     // search reset
     $('#btn-reset2').click(() => {
        $('#search-table').val('')
        search_table('')
    })

    // btn edit and delete
    $('#show-btn').click((e) => $('.cc-manage').toggleClass("d-none"))

    // getdata borrow
    function getdata(id) {
        $('#qtyReturn').val(1)
        $('#nosave3').text('')
        $('#dateReturn').val(today)
        $('#nosave2').addClass("d-none")
        $.ajax({
            url: 'controller/action.php',
            type: 'post',
            dataType: 'json',
            data: {
                id: id,
                getborrow: 1
            },
            success: (res) => {
                $('#bor-id').val(res.bor_id)
                $('#qty2').val(res.bor_quantity)
                $('#product2').val(res.pl_name_product)
                $('#product_id2').val(res.pl_product_id)
                $('#storage2').val(res.pl_storage)
                $('#date2').val(res.bor_date)
                $('#modal3').modal('show')
            }
        });
    } 

    // return borrow
    $('#btn-borrow').click(() => {
        if(parseInt($('#qtyReturn').val()) > parseInt($('#qty2').val())){ 
            $('#nosave3').text(`จำนวนที่คืนได้สูงสุดคือ ${$('#qty2').val()}`)
            return
        }else{
            const data = new FormData()
            data.append('form_borrow', 'returnborrow')
            data.append('id', $('#product_id2').val())
            data.append('bor_id', $('#bor-id').val())
            data.append('qty', $('#qty2').val())
            data.append('qtyreturn', $('#qtyReturn').val())
            data.append('datereturn', $('#dateReturn').val())
            
            $.ajax({
                url: 'controller/action.php',
                type: 'post',  
                data: data,
                contentType: false,
                processData: false,
                success: (res) => {
                    if(res == 1){
                        swalsuccess()
                        setTimeout(() => location.reload(), 1200)
                    }else{ swalerror() }
                }
            });
        }
    }) 

    // delete borrow
    const delborrow = (id) => {
        const data = new FormData()
        data.append('form_borrow', "delborrow")
        data.append('id', id)
        data.append('delborrow', 1)

        $.ajax({
            url: 'controller/action.php',
            type: 'post',
            data: data,
            contentType: false,
            processData: false,
            success: (res) => {
                res == 1 ? swalsuccess() : swalerror()
                setTimeout(() => location.reload(), 1200)
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
                delborrow(id)
            }
        })
    }

    // auto select date
    function currentdate(){
        const today = new Date();
        const day = today.getDate();
        const month = today.getMonth() + 1;
        const year = today.getFullYear();
        return dmy = `${month < 10 ? '0' : ''}${month}/${day < 10 ? '0' : ''}${day}/${year}`
    }


</script>


