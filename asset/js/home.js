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
