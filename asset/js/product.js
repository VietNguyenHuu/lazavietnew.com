$(document).ready(function () {
    $(".input_addtocard").click(function () {
//      alert(
//          $(".product_center_input_number").val()
//          
//      );
//        alert($(".product_center_title_h1").attr("data-id"));
        $.ajax({
            url: "index.php/product/addtocart",
            type: "post",
            dateType: "html",
            data: {
                id: $(".product_center_title_h1").attr("data-id"),
                count: $(".product_center_input_number").val()
            },
            success: function (result) {
                $(".product_center_result").html(result);
                if($(".product_center_result .success").length>0)
                {
                    $(".user_cart_total").html($(".user_cart_total").html()*1+1);
                }
            },
            error: function () {
                alert("conection fail");
            }
        });
    })
});