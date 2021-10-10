$(function(){
    "use strict";
    $('[placeholder]').focus(function(){
        $(this).attr('data-text',$(this).attr('placeholder'));
        $(this).attr('placeholder','');})
    .blur(function(){
        $(this).attr('placeholder',$(this).attr('data-text'));
        $(this).attr('data-text','');
})

$('input').each(function(){
    if($(this).attr('required')==='required'){
        $(this).after('<span class="asterisk">*</span>');
    }
});



    
 
$('.del').click(function(){
    return confirm('Are You Sure?');
})
$('.cont h1 span').click(function(){
    $(this).addClass('select').siblings().removeClass('select');
    $('.cont form').hide();
    $('.'+$(this).data('class')).fadeIn(100);
 
})

$('.live-name').keyup(function(){
    $('.live-prev h3').text($(this).val());
})

$('.live-disc').keyup(function(){
    $('.live-prev p').text($(this).val());
})

$('.live-price').keyup(function(){
    $('.live-prev .pr').text('$'+$(this).val());
})
/* check activity */


});



