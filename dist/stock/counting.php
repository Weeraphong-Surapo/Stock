<div id="counting">
    <div class="portlet-header portlet-header-bordered">
        <h3 class="portlet-title">หน่วยนับ</h3>
        <button class="btn btn-primary" @click="openModal">เพิ่มหน่วยนับ</button>
    </div>
    <div class="portlet-body">
        <div class="table-responsive">
            <table class="table table-striped table-hover mb-0">
                <thead>
                    <tr>
                        <th width="10%">ลำดับ</th>
                        <th width="70%">หน่วยนับ</th>
                        <th width="20%">จัดการ</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(counting,index) in Allcounting" :key="index">
                        <th scope="row">{{ ++index }}</th>
                        <td>{{ counting.ctu_name }}</td>
                        <td>
                            <button @click="editCounting(counting.ctu_id)" class="btn btn-warning">แก้ไข</button>
                            <button @click="deleteCounting(counting.ctu_id)" class="btn btn-danger">ลบ</button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <!-- END Table -->
    </div>

    <!-- BEGIN Modal -->
    <div class="modal fade" id="ModalCounting" data-bs-backdrop="static">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{ title }}</h5>
                    <button type="button" class="btn btn-label-danger btn-icon" data-bs-dismiss="modal">
                        <i class="fa fa-times"></i>
                    </button>
                </div>
                {{ form }}
                <form action="" method="post" @submit="addCounting">
                <div class="modal-body">
                    <label for="">หน่วยนับ</label>
                    <input v-model="form.counting" class="form-control" placeholder="ระบุชื่อหน่วยนับ" required>
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
<script src="vue/counting.js"></script>