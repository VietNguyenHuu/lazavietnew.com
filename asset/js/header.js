$.ajax({
    url: "index.php/cart/loadnumber",
    type: "post",
    dateType: "html",
    data: {
        
    },
    success: function (result) {
        $(".user_cart_total").html(result);
    },
    error: function () {
        alert("conection fail");
    }
    
});
