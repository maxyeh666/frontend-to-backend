# 從前端到後端實作  
---
## 目的:了解前端到後端的運作與框架和Libery的使用  
---
### 使用技術:  
  * 前端:  
    * Html、CSS、Javascript、Bootstrap、Vue.js、axios  
  * 後端:  
    * PHP、MySql  
---
### 實作筆記  
  1. 從基礎的crud開始，完成一個擁有基礎crud的使用者清單  
  * 整體流程:  
      在Vue.js的data設定觀察的資料，在前端接收到資料後，根據資料的變化進行處理(渲染到網頁、發送請求)，再根據發出的請求給PHP來進行資料庫的操作。  
  * 各階段筆記:  
    * HTML:
      1. 原始bootstrap使用互動視窗(Modal)元件時，會在body上套上.modal-open來造成視窗出現時，背景就變成黑色的效果。為了因應針對使用Vue.js的規則進行修改，將下方標籤加入互動式窗最後一行取得相同效果。  
      ```<div class="modal-backdrop show"></div>```
    * Bootstrap4:  
      1. 使用格線系統進行快速排版，並使用元件:彈出式視窗(Modal)將資料以表單(Form)的方式寫入資料庫。  
      2. 元件:互動視窗(Modal)按照官方文件的用法會直接操控DOM元素，與Vue的基本使用概念有所衝突，需另外改變由Vue.js來操控是否顯示。
    * Vue.js:
      1. 設定data中的資料，Msg為根據後端處理後回傳的訊息，showXXXModal為控制要顯示的互動視窗，user類則處理資料流向控管，isShowClass來控制彈出式視窗元件的Class。
          ```javascript 
              data:{
                errorMsg: "",
                successMsg: "",
                showAddModal: false,
                showEditModal: false,
                showDeleteModal: false,
                users: [],
                newUser: {name:'',email:''},
                currentUser:{},
                isShowClass: false
              }
          ```
      2. 因為bootstrap中的modal元件操控顯示的方式是直接操控DOM，為了避免直接操控DOM，在這裡用watch來觀察元件的顯示狀態，再加入setTimeout延遲來讓原本bootstarp用來控制的class加入，讓動畫生效。
          ```javascript
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
            ```
