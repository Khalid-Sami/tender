$('html').addClass('loading');
$(window).load(function() {
  // Animate loader off screen
  $(".se-pre-con").fadeOut("slow",function(){
    $('html').removeClass('loading');
  });
});
$(document).ready(function(){

  /******* Nice Scroll *******/ 

  // $("html").niceScroll({styler:"fb",cursorcolor:"#a70e13",zindex :"5555"});
  // $("#storytest").niceScroll();
  // $(".modal-open .modal").niceScroll();
  // $("#storytest").getNiceScroll().hide();


	/******** product slider ******/ 
    album_slider = $('.album_slider_id');
    if( album_slider.find("div.item").length <= 1 ){
      album_slider.removeClass('products_slider_id');
    }     
    owl = $('.album_slider_id');
    owl.owlCarousel({
          rtl:true,
          loop:true,
          nav:false,
          dots:true,    
          autoplay:true,
          autoplayTimeout:7000,
          autoplayHoverPause:true,
          autoplaySpeed:1500,
          navSpeed:1500,
          dotsSpeed:1500,
          dragEndSpeed:1500,
          // navText: ['<i class="uk-icon-angle-right"></i>','<i class="uk-icon-angle-left"></i>'],
          navText: ["<i class='fa fa-angle-left'></i>","<i class='fa fa-angle-right'></i>"],
          // animateOut: 'fadeOut',
          // animateIn: 'fadeIn',                
          // margin:13,    
          // onChanged: center_fun, 
          responsive:{
              0:{
                  items:1,
                  margin:0
              },
              480:{
                  items:2,
                  margin:15
              },
              767:{
                  items:2,
                  margin:15
              },              
              991:{
                  items:3,
                  margin:30
              },              
              1370:{
                  items:4,
                  margin:30
              }
          }
    });
    // function center_fun(event) {
    //     $('.album_slider_id .owl-item.active').removeClass('center');
    //   $('.album_slider_id .owl-item.active').eq(2).addClass('center');
    // }
    // owl.on('changed.owl.carousel', function(e) {
    //   // alert("changed");
    //   $('.album_slider_id .owl-item.active').removeClass('center');
    //   $('.album_slider_id .owl-item.active').eq(2).addClass('center');
    // });
   /******** end product slider ******/
   /******** main slider ******/ 
   x = $('.mainSldier_id');
    if( x.find("div.item").length <= 1 ){
      x.removeClass('mainSldier_id');
    }
    $('.mainSldier_id').owlCarousel({
          rtl:true,
          loop:true,
          nav:false,
          dots:false,    
          autoplay:true,
          autoplayTimeout:7000,
          autoplayHoverPause:true,
          autoplaySpeed:1500,
          navSpeed:1500,
          dotsSpeed:1500,
          dragEndSpeed:1500,
          // navText: ["<i class='fa fa-angle-left'></i>","<i class='fa fa-angle-right'></i>"],
          // animateOut: 'fadeOut',
          // animateIn: 'fadeIn',                
          // margin:13,         
          responsive:{
              0:{
                  items:1
              },
              480:{
                  items:1
              },
              767:{
                  items:1
              },
              
              959:{
                  items:1
              }
          }
      });
   /******** end main slider ******/
   /******** start my story section slider *******/ 
 
    $('.catSlider').owlCarousel({
          rtl:true,
          loop:false,
          nav:true,
          dots:false,    
          autoplay:true,
          autoplayTimeout:7000,
          autoplayHoverPause:true,
          autoplaySpeed:1500,
          navSpeed:1500,
          dotsSpeed:1500,
          dragEndSpeed:1500,
          navText: ["<i class='fa fa-angle-left'></i>","<i class='fa fa-angle-right'></i>"],
          // animateOut: 'fadeOut',
          // animateIn: 'fadeIn',                
          // margin:13,         
          responsive:{
              0:{
                  items:1
              },
              480:{
                  items:2
              },
              768:{
                  items:3
              },
              
              992:{
                  items:4
              }
          }
      });

   /******** end my story section slider ******/

    /******** start my story section slider *******/ 
    x = $('.quotes_slider_id');
    if( x.find("div.item").length <= 1 ){
      x.removeClass('quotes_slider_id');
    }
    $('.quotes_slider_id').owlCarousel({
          rtl:true,
          loop:true,
          nav:false,
          dots:true,    
          autoplay:true,
          autoplayTimeout:7000,
          autoplayHoverPause:true,
          autoplaySpeed:1500,
          navSpeed:1500,
          dotsSpeed:1500,
          dragEndSpeed:1500,
          // navText: ["<i class='fa fa-angle-left'></i>","<i class='fa fa-angle-right'></i>"],
          // animateOut: 'fadeOut',
          // animateIn: 'fadeIn',                
          // margin:13,         
          responsive:{
              0:{
                  items:1
              },
              480:{
                  items:1
              },
              767:{
                  items:1
              },
              
              959:{
                  items:1
              }
          }
      });

   /******** end my story section slider ******/

});

$(document).on('click','.modal-body .form_container .available_majors_section .buttonContainer > span',function(e){
  e.preventDefault();
  // parent = $(this).parent().parent();
  parent = $(this).closest('.available_majors_section');
  major_name = parent.find('#major_name').val();
  item = '<li>'+
              '<div class="delete_item"><img src="images/cross_ic.png"></div>'+
              '<div class="major_name">'+
                  '<input type="hidden" value="'+major_name+'">'+
                  '<span>'+major_name+'</span>'+
              '</div>'+
          '</li>';
  parent.find('.majors_list ul').append(item);
});
$(document).on('click','.modal-body .form_container .available_majors_section .majors_list li > div.delete_item',function(e){
  e.preventDefault();
  parent = $(this).parent();
  parent.remove();
});
$(document).on('click','.modal-body .form_container .insurance_section .buttonContainer > span',function(e){
  e.preventDefault();
  // parent = $(this).parent().parent();
  parent = $(this).closest('.insurance_section');
  insurance_name = parent.find('#insurance_name').val();
  insurance_cateygory = parent.find('#insurance_cateygory').val();
  insurance_number = parent.find('#insurance_number').val();
  item = '<div class="insurance_item">'+
              '<div class="delete_item"><img src="images/cross_ic.png"></div>'+
              '<div class="insurance_name"><input type="text" value="'+insurance_name+'" disabled></div>'+
              '<div class="insurance_cateygory"><input type="text" value="'+insurance_cateygory+'" disabled></div>'+
              '<div class="insurance_number"><input type="text" value="'+insurance_number+'" disabled></div>'+
          '</div>';
  parent.find('.insurances_list').append(item);
});
$(document).on('click','.modal-body .form_container .insurance_section .insurances_list .insurance_item > div.delete_item',function(e){
  e.preventDefault();
  parent = $(this).parent();
  parent.remove();
});
$('.openAnthorModal').click(function(e){
  e.preventDefault();
  hiddenModel = $(this).attr('data-modal-hide');
  showModel = $(this).attr('data-modal-show');
  $(hiddenModel)
      .modal('hide')
      .on('hidden.bs.modal', function (e) {
          $(showModel).modal('show');

          $(this).off('hidden.bs.modal'); // Remove the 'on' event binding
      });

});
var $tabs = $('.modal-body .M_modal_tabs_header .nav-tabs>li');
$(document).on('click','.prevtab', function(e) {
  e.preventDefault();
  $tabs.filter('.active').prev('li').find('a[data-toggle="tab"]').tab('show');
});

$(document).on('click','.nexttab', function(e) {
  e.preventDefault();
  $tabs.filter('.active').next('li').find('a[data-toggle="tab"]').tab('show');
});