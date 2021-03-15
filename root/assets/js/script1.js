$(document).ready(function(){
    $('[type="search"]').focus(function(){
        $(this).attr('class','form-control');
    })
    $('[type="search"]').blur(function(){
        $(this).attr('class','form-control offset-9');
    })
})