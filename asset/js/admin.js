function f_admin() {
    this.add = function () {
        var self = this;
        var title = $(".admin_category_add_title").val();
        $.ajax({
            url: "index.php/admin/category_add",
            type: "post",
            dateType: "html",
            data: {
                t: title,
                id_parent: $(".admin_category_add_id_parent :selected").val()
            },
            success: function (result) {
                //$(".admin_category_add_title").val("");
                self.loadlist();
            },
            error: function () {
                alert("conection fail");
            }
        });
    };
    this.loadlist = function(){
       
        $.ajax({
            url: "index.php/admin/category_loadlist",
            type: "post",
            dateType: "html",
            data:{
                
            },
            success: function (result) {
                //console.log(result);
                $(".admin_category_list").html(result);
            },
            error: function () {
                alert("conection fail");
            }
        });
    };
    this.delete = function(id){
        var self = this;
        $.ajax({
            url: "index.php/admin/category_delete",
            type: "post",
            dateType: "html",
            data:{
                id : id
            },
            success: function (result) {
                self.loadlist();
                console.log(result);
            },
            error: function () {
                alert("conection fail");
            }
        });
    };
    this.edit = function(id){
        $("#category_item_"+id).find(".title").attr("contenteditable", "true").addClass('editting').focus();
    };
    this.update= function(id){
        var self = this;
        $.ajax({
            url: "index.php/admin/category_update",
            type: "post",
            dateType: "html",
            data:{
                id : id,
                title: $("#category_item_"+id).find(".title").html()
            },
            success: function (result) {
                self.loadlist();
                console.log(result);
            },
            error: function () {
                alert("conection fail");
            }
        });
    }
}

var admin = new f_admin();
admin.loadlist();

function f_admin_product(){
    var self = this;
    this.add = function () {
        var self = this;
        var title = $(".admin_product_add_title").val();
        $.ajax({
            url: "index.php/admin/product_add",
            type: "post",
            dateType: "html",
            data: {
                t: title
            },
            success: function (result) {
                //$(".admin_category_add_title").val("");
                self.loadlist();
            },
            error: function () {
                alert("conection fail");
            }
        });
    };
    this.loadlist = function(){
       
        $.ajax({
            url: "index.php/admin/product_loadlist",
            type: "post",
            dateType: "html",
            data:{
                
            },
            success: function (result) {
                //console.log(result);
                $(".admin_product_list").html(result);
            },
            error: function () {
                alert("conection fail");
            }
        });
    };
    this.delete = function(id){
        var self = this;
        $.ajax({
            url: "index.php/admin/product_delete",
            type: "post",
            dateType: "html",
            data:{
                id : id
            },
            success: function (result) {
                self.loadlist();
                console.log(result);
            },
            error: function () {
                alert("conection fail");
            }
        });
    };
    this.edit = function (id){
        $("#product_edit_popup").addClass('active');
        $.ajax({
            url: "index.php/admin/product_loadedit",
            type: "post",
            dateType: "html",
            data:{
                id : id
            },
            beforeSend: function(){
                $("#product_edit_popup").html("loadding data...");
            },
            success: function (result) {
                $("#product_edit_popup").html(result);
                console.log(result);
                CKEDITOR.replace("admin_product_update_detail");
            },
            error: function () {
                alert("conection fail");
            }
        });
    };
    this.edit_cancel =function(){
        $("#product_edit_popup").removeClass('active');
    }
    this.update_avata = '';
    this.update_setavata = function (f) {
        var reader = new FileReader();
        reader.onload = function (e) {
            admin_product.update_avata = e.target.result;
            $("#admin_product_update_avata_view").attr('src', e.target.result);
        };
        reader.readAsDataURL(f.files[0]);
    };
    
    this.update =function(id){
        //console.log(this.update_avata);
        console.log(CKEDITOR.instances.admin_product_update_detail.getData());
        $.ajax({
            url: "index.php/admin/product_update",
            type: "post",
            dateType: "html",
            data:{
                id : id,
                title: $(".admin_product_update_title").val(),
                price: $(".admin_product_update_price").val(),
                id_category: $(".admin_product_update_id_parent :selected").val(),
                avata : this.update_avata,
                detail: CKEDITOR.instances.admin_product_update_detail.getData()
            },
            
            success: function (result) {
                $("#product_edit_popup").removeClass("active");
                console.log(result);
                self.loadlist();
            },
            error: function () {
                alert("conection fail");
            }
        });
    }
}
var admin_product=new f_admin_product();
admin_product.loadlist();
