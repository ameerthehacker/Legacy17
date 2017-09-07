$(function(){
    $(".modal").modal();
    $('select').material_select();
    $('.collapsible').collapsible();
    $('.btn-collapse-sidebar').sideNav();
    function pulsate($obj){
        var original = $obj.css('font-size');
        $obj.css({'width': original});
        $obj.animate({'font-size': '10px'}, 500, function(){
            $obj.animate({'font-size': original}, 500, function(){
                pulsate($obj);
            });
        });
    }
    $('.dropdown-button').dropdown();
    pulsate($('.pulsing'));
});
