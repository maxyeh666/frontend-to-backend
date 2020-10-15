let vue = new Vue ({
    el: '#app',
    data: {
        errorMsg: "",
        successMsg: "",
        showAddModal: false,
        showEditModal: false,
        showDeleteModal: false,
        users: [],
        newUser: {name:'',email:''},
        currentUser:{},
        isShowClass: false
    },
    mounted:function() {
        this.getAllUsers()
    },
    methods:{
        getAllUsers: 
        function(){
            axios.get('http://localhost/front_to_back/php/process.php?action=read').then((response) => {
                // axios回傳的值並非直接就是資料,而是在data裡面
                if(response.data.error){
                    this.errorMsg = response.data.message
                }else{
                    this.users = response.data.users
                }
            })
        },
        toFormData:
        function(obj){
            // 當輸出的資料是表單時,使用FormData進行處理
            let fd = new FormData()

            // for...in 將資料對應key值寫入
            for(data in obj){
                fd.append(data,obj[data])
            }

            return fd
        },
        selectUser:
        function(user){
            this.currentUser = user
        },
        clearMessage:
        function(){
            this.errorMsg = ''
            this.successMsg = ''
        },
        addUser:
        function(){
            // 先宣告輸出表單的變數
            let formData = this.toFormData(this.newUser)

            axios.post('http://localhost/front_to_back/php/process.php?action=create',formData).then((response) => {
                // 清空資料data中的newUser資料
                this.newUser = {}

                // axios回傳的值並非直接就是資料,而是在data裡面
                if(response.data.error){
                    this.errorMsg = response.data.message
                }else{
                    this.successMsg = response.data.message
                    this.getAllUsers()
                }
            })
        },
        updateUser:
        function(){
            // 先宣告輸出表單的變數
            // 取得目前的資料(this.currentUser)
            let formData = this.toFormData(this.currentUser)

            axios.post('http://localhost/front_to_back/php/process.php?action=update',formData).then((response) => {
                // 清空資料data中的currentUser資料
                this.currentUser = {}

                // axios回傳的值並非直接就是資料,而是在data裡面
                if(response.data.error){
                    this.errorMsg = response.data.message
                }else{
                    this.successMsg = response.data.message
                    this.getAllUsers()
                }
            })
        },
        deleteUser:
        function(){
            // 先宣告輸出表單的變數
            // 取得目前的資料
            let formData = this.toFormData(this.currentUser)

            axios.post('http://localhost/front_to_back/php/process.php?action=update',formData).then((response) => {
                // 清空資料data中的currentUser資料
                this.currentUser = {}

                // axios回傳的值並非直接就是資料,而是在data裡面
                if(response.data.error){
                    this.errorMsg = response.data.message
                }else{
                    this.successMsg = response.data.message
                    this.getAllUsers()
                }
            })
        }
    },
    watch:{
        showAddModal(value){
            setTimeout(() => {
                this.isShowClass = value
            }, 50)
        },
        showEditModal(value){
            setTimeout(() => {
                this.isShowClass = value
            }, 50)
        },
        showDeleteModal(value){
            setTimeout(() => {
                this.isShowClass = value
            }, 50)
        }
    }
})