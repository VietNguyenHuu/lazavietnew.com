$(".list_cart_all").change(function () {

    if ($(this).is(':checked') === true)
    {
        $(".list_cart_title input[type = 'checkbox']").prop("checked", true);
    } else {
        $(".list_cart_title input[type = 'checkbox']").prop("checked", false);
    }

});
$(".delete_btn").click(function(){
    var n = $(".list_cart_input:checked");
    var ar =[];
    $.each(n, function(){
        ar.push($(this).attr("data-id"));
    });
    console.log(ar);
    $.ajax({
            url: "index.php/cart/delete",
            type: "post",
            dateType: "html",
            data: {
                ar : ar
            },
            success: function (result) {
               console.log(result);
               window.location = location.href;
            },
            error: function () {
                alert("conection fail");
            }
        });
});