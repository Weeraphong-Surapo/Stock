<?php 
    $productlist = $con->query("SELECT * FROM tb_productlist"); 
    $category = $con->query("SELECT * FROM tb_categorie");
?>

<div class="portlet-header portlet-header-bordered">
    <h3 class="portlet-title">สินค้าในสต็อก</h3>
</div>

<div id="cc-search-1" class="d-flex gap-2">
    <div class="m-3 d-flex gap-2">
        <select style="min-width: 140px; width: auto;" id="option-search" class="form-control">
            <option id="main-option" hidden>เลือกดู หมวดหมู่สินค้า</option>
            <option value="all">ทั้งหมด</option>
            <?php foreach($category as $cat): ?>
                <option value="<?=$cat['cat_name_categorie']?>"><?=$cat['cat_name_categorie']?></option>
            <?php endforeach; ?>
        </select>
        <input id="search-table" class="form-control" style="width: 300px;" type="text" placeholder="ค้นหาจากชื่อสินค้า หรือ แสกนบาร์โค้ด">
        <button id="btn-reset" class="btn btn-secondary">รีเฟรช</button>
    </div>
</div>

<div class="portlet-body">
    <div class="table-responsive">
        <table id="cc-table" class="table table-striped table-hover mb-0">
            <thead>
                <tr>
                    <th>ลำดับ</th>
                    <th>รหัสสินค้า</th>
                    <th>บาร์โค้ด</th>
                    <th>ชื่อสินค้า</th>
                    <th>หมวดหมู่</th>
                    <th>ที่จัดเก็บ</th>
                    <th>ราคาขาย1/บาท</th>
                    <th>ราคาขาย2/บาท</th>
                    <th>ราคาขาย3/บาท</th>
                    <th>ส่วนลด/บาท</th>
                    <th>จำนวนคงเหลือ</th>
                    <!-- <th>รายรับประมาณการ/บาท</th> -->
                </tr>
            </thead>
            <tbody>
                <?php
                    $num = 0;
                    foreach($productlist as $pro):
                        $num++;
                        $catID = "SELECT * FROM tb_categorie WHERE cat_id = '$pro[c_id]' ";
                        $cat_name = mysqli_fetch_array($con->query($catID))
                ?>
                <tr class="tr<?=$cat_name['cat_name_categorie']?>">
                    <td><?=$num?></td>
                    <td><?=$pro['pl_product_id']?></td>
                    <td><a class="btn btn-secondary py-0" href="stock/Barcode.php?id=<?=$pro['id'];?>" target="_blank"><i class="fa-solid fa-barcode"></i> Barcode</a></td>
                    <td><?=$pro['pl_name_product']?></td>
                    <td class="tdcat"><?=$cat_name['cat_name_categorie']?></td>
                    <td><?=$pro['pl_storage']?></td>
                    <td><?=number_format($pro['	pl_price1'])?></td>
                    <td><?=number_format($pro['	pl_price2'])?></td>
                    <td><?=number_format($pro['	pl_price3'])?></td>
                    <td><?=number_format($pro['pl_discount'])?></td>
                    <td><?=$pro['pl_quantity']?></td>
                    <!-- <td><?php //$pro['pl_revenue']?></td> -->
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <!-- END Table -->
</div>


<script>
    // search
    $('#search-table').keyup(() => {
        search_table($('#search-table').val())
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
        $('#search-table').val('')
        search_table('')
        getall()
        $('#main-option').attr("selected", "selected")
    })

    // search option table
    $('#option-search').change((e) => {
        $('#main-option').attr("selected", false)
        if(e.target.value == "all"){
            getall()
        }else{
            $('tr').removeClass("d-none")
            const tdcat = document.querySelectorAll(".tdcat")
            tdcat.forEach(td => {
                if(td.textContent != e.target.value){
                    $(`.tr${td.textContent}`).addClass("d-none")
                }
            })
        }
    })

    const getall = () => {
        const alltr = document.querySelectorAll("tbody tr")
        alltr.forEach(all => all.classList.remove("d-none"))
    }
</script>


