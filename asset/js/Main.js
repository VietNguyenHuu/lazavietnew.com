/*
 $(".click_messager").click(function(){
 $(".messager_box").show();
 });
 
 $(".messager_box i.fa-times").click(function(){
 console.log("clocik ");
 $(".messager_box").hide();
 });
 */

/*
 $(".messager_box").html(
 $(".messager_box").html()
 + "<textarea>Nhập tin nhắn của bạn</textarea>"
 + "<br>"
 + "<input  type='submit' value='Gửi'>");
 $(".messager_box textarea").css({
 "height":"100px",
 "width": "100%"
 });
 $(".messager_box input").css({
 "padding": "15px"
 });
 console.log("đây là kích thước màn hình ngang: " + $(screen).width());
 console.log("đây là kích thước màn hình dọc: " + $(screen).height());
 */

$(".messager_box i.button_cross").click(function(){
    $(".messager_box").hide();
    $(".quick_messager").show();
});
$(".click_messager").click(function(){
    $(".messager_box").show();
    $(".quick_messager").hide();
});
//$("img").attr("src", "1.jpg");


function runtime(){
    var gio_now= $(".gio").html();
    var phut_now= $(".phut").html();
    var giay_now= $(".giay").html();
    giay_now++;
    if( giay_now==60)
    {
        giay_now=0; phut_now++;
        if(phut_now==60){
            phut_now=0; gio_now++;
            if(gio_now>=24){gio_now=0}
        }
        
    }
        $(".giay").html(giay_now);
        $(".phut").html(phut_now);
        $(".gio").html(gio_now);  
    setTimeout(function(){
        runtime();
    },2);
}

var baygio = new Date();
var gio = baygio.getHours();
var phut = baygio.getMinutes();
var giay = baygio.getSeconds();
$(".giay").html(giay);
$(".phut").html(phut);
$(".gio").html(gio);

function runtime2(){
    var gio_now= $(".gio1").html();
    var phut_now= $(".phut1").html();
    var giay_now= $(".giay1").html();
    giay_now--;
    if( giay_now<=0)
    {
        giay_now=59; phut_now--;
        if(phut_now==0){
            phut_now=59; gio_now--;
            if(gio_now<0){console.log("da het time")}
        }
        
    }
        $(".giay1").html(giay_now);
        $(".phut1").html(phut_now);
        $(".gio1").html(gio_now);  
    if(gio_now>=0){setTimeout(function(){
        runtime2();
    },100);}
}

//runtime2();
//runtime();
