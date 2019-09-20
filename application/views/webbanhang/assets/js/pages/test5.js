//code js at here
$(".dynamic_user_option select[name='fontsize']").change(function()
{
    $(this).parents('.dynamic_user_option').find('.view').css({'font-size':$(this).val()})
    $.cookie('fontsize',$(this).val());
});
$(".dynamic_user_option select[name='fontcolor']").change(function()
{
    $(this).parents('.dynamic_user_option').find('.view').css({'color':$(this).val()})
    $.cookie('fontcolor',$(this).val());
});
$(".dynamic_user_option select[name='bgcolor']").change(function()
{
    $(this).parents('.dynamic_user_option').find('.view').css({'background-color':$(this).val()})
    $.cookie('bgcolor',$(this).val());
});
$(".dynamic_user_option .view").css({'color':$.cookie('fontcolor'),'font-size':$.cookie('fontsize'),'background-color':$.cookie('bgcolor')});