<div id="app" class="container">
    <h3 class="mt-3">Add User</h3>
    <hr>
    <div class="row">
        <div class="col">

            <label>User ID</label>
            <input type="number" class="form-control" v-model="id">
        </div>
        <div class="col">

            <label>User name</label>
            <input type="text" class="form-control" v-model="name">
        </div>
        <div class="col">

            <label>User Email</label>
            <input type="text" class="form-control" v-model="email">
        </div>

    </div>
    <button class="btn btn-info mt-2" @click="addUser">Add User</button>
    <hr>

    <div class="row">
        <div class="col">
            <table id="user-table" class="display table-bordered nowrap" cellspacing="0" width="100%">
                <thead>
                    <tr>
                        <th>User ID</th>
                        <th>User Name</th>
                        <th>User Email</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>
</div>
<script>
    new Vue({
        el: '#app',
        data: {
            id: '',
            name: '',
            email: '',
            dataTable: null,
        },
        methods: {

            addUser() {

                this.dataTable.row.add([
                    this.id,
                    '<a href="#">' + this.name + '</a>',
                    this.email
                ]).draw(false)
                this.id = '';
                this.name = '';
                this.email = '';
            }
        },
        mounted() {
            let users = [];

            this.dataTable = $('#user-table').DataTable({});
            const url = 'https://jsonplaceholder.typicode.com/users';
            fetch(url)
                .then(res => res.json())
                .then(data => {
                    data.forEach(item => {
                        users.push(item);
                    });

                    users.forEach(user => {
                        this.dataTable.row.add([
                            user.id,
                            '<a href="#">' + user.name + '</a>',
                            user.email
                        ]).draw(false)
                    })
                })
        }
    })
</script>