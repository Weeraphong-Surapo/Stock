var app = new Vue({
    el: '#category',
    data: {
        path: "controller/SotckController.php",
        no:1,
        AllCategory:[],
        showModal:false,
        status:"บันทึก",
        title:"เพิ่มหมวดหมู่",
        form:{
            id:"",
            category:"",
            isEdit:false
        }
    },
    methods: {
        addCategory(e) {
            e.preventDefault();
            if (this.form.isEdit) {
                axios.post(this.path, {
                    action: "updateCategory",
                    category: this.form.category,
                    id: this.form.id
                }).then((res) => {
                    this.resetData()
                    this.getAllCategory()
                    this.closeModal()
                    this.swalAlert('success','อัพเดตข้อมูลสำเร็จ')
                })
            } else {
                axios.post(this.path, {
                    action: "addCategory",
                    category: this.form.category
                }).then((res) => {
                    this.resetData()
                    this.getAllCategory()
                    this.closeModal()
                    this.swalAlert('success','เพิ่มข้อมูลสำเร็จ')
                })
            }
        },
        editCategorys(id) {
            this.title = "แก้ไขหมวดหมู่"
            axios.post(this.path, {
                action: "editCategory",
                id: id
            }).then((res) => {
                this.form.category = res.data.cat_name_categorie
                this.form.id = res.data.cat_id
                this.form.isEdit = true
                $('#ModalCategory').modal('show')
            })
        },
        deleteCategory(id) {
            Swal.fire({
                title: 'ต้องการลบหมวดหมู่นี้?',
                text: "",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'ตกลง',
                cancelButtonText: 'ยกเลิก',
              }).then((result) => {
                if (result.isConfirmed) {
                    axios.post(this.path, {
                        action: "deleteCategory",
                        id: id
                    }).then((res) => {
                        this.getAllCategory()
                        this.swalAlert('success','ลบข้อมูลสำเร็จ')
                    })
                }
              })
            
        },
        resetData() {
            this.form.category = "";
            this.form.isEdit = false;
            this.form.id = "";
        },
        swalAlert(type,title){
            Swal.fire({
                position: 'center',
                icon: type,
                text: title,
                showConfirmButton: false,
                timer: 900
            })
        },
        getAllCategory(){
            axios.post(this.path,{
                action:"AllCategory"
            }).then((res)=>{
                this.AllCategory = res.data
            })
        },
        openModal(){
            this.title = "เพิ่มหมวดหมู่"
            this.resetData()
            $('#ModalCategory').modal('show')
        },
        closeModal(){
            $('#ModalCategory').modal('hide')
        }
    },
    mounted() {
        this.getAllCategory()
    },
})