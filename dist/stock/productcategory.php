<div id="category">
    <div class="portlet-header portlet-header-bordered">
        <h3 class="portlet-title">หมวดหมู่ทั้งหมด</h3>
        <button class="btn btn-primary" @click="openModal">เพิ่มหมวดหมู่</button>
    </div>
    <div class="portlet-body">
        <div class="table-responsive">
            <table class="table table-striped table-hover mb-0">
                <thead>
                    <tr>
                        <th width="10%">ลำดับ</th>
                        <th width="70%">หมวดหมู่</th>
                        <th width="20%">จัดการ</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(category,index) in AllCategory" :key="index">
                        <th scope="row">{{ ++index }}</th>
                        <td>{{ category.cat_name_categorie }}</td>
                        <td>
                            <button @click="editCategorys(category.cat_id)" class="btn btn-warning">แก้ไข</button>
                            <button @click="deleteCategory(category.cat_id)" class="btn btn-danger">ลบ</button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <!-- END Table -->
    </div>

    <!-- BEGIN Modal -->
    <div class="modal fade" id="ModalCategory" data-bs-backdrop="static">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{ title }}</h5>
                    <button type="button" class="btn btn-label-danger btn-icon" data-bs-dismiss="modal">
                        <i class="fa fa-times"></i>
                    </button>
                </div>
                <form action="" method="post" @submit="addCategory">
                <div class="modal-body">
                    <label for="">ชื่อหมวดหมู่</label>
                    <input v-model="form.category" class="form-control" placeholder="ระบุชื่อหมวดหมู่" required>
                </div>
                <div class="modal-footer">
                    <a href="#" @click="closeModal" class="btn btn-outline-danger">ปิด</a>
                    <button type="submit" class="btn btn-primary">{{ status }}</button>
                </div>
            </form>
            </div>
        </div>
    </div>
    <!-- END Modal -->
</div>
<script src="vue/category.js"></script>