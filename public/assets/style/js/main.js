$(document).ready(function(){
    ShowNavigationMenu();
    scrollTabs();
    if ($('body').hasClass('page-scrollspy')) 
    {
        ScrollSpySidebar();
    }
    ResponsiveSidebarSpy();
});

// Show navigation menu on button click
function ShowNavigationMenu (){
    $('.navbar-toggle').on('click', function ()
    {
        var btn = $(this);
        var target = $('body');

        if (!target.hasClass('navbar-open'))
        {
            btn.addClass('active');
            target.addClass('navbar-open');
        }
        else
        {
            btn.removeClass('active');
            target.addClass('navbar-closing');
            setTimeout(function ()
            {
                target.addClass('navbar-bgfade');
            }, 400);
            setTimeout(function ()
            {
                btn.removeClass('active');
                target.removeClass('navbar-open navbar-closing navbar-bgfade');
            }, 800);
        }
    });
}

// For responsive tabs scrolling

function scrollTabs(){
    $(function() {
        "use strict";

        function e() {
            c.classList.remove("disabled"), n.classList.remove("disabled"), l.scrollLeft <= 0 && c.classList.add("disabled"), l.scrollLeft + l.clientWidth + 5 >= l.scrollWidth && n.classList.add("disabled")
        }

        function t(e) {
            l.scrollLeft += e
        }
        var n = document.querySelector(".btn-next"),
            c = document.querySelector(".btn-prev"),
            l = document.querySelector(".tabs-responsive > .tabs-container > .nav-tabs"),
            i = 40;
        if (l !== null)
        {
            l.addEventListener("scroll", e), e(), n.addEventListener("click", t.bind(null, i)), n.addEventListener("tap", t.bind(null, i)), c.addEventListener("click", t.bind(null, -i)), c.addEventListener("tap", t.bind(null, -i))
        }
    }(),
    function() {
        "use strict";
        var e = document.querySelectorAll('[href=""]');
        Array.prototype.forEach.call(e, function(e) {
            e.addEventListener("click", function(e) {
                e.preventDefault()
            })
        })
    });
}


// scrollspy
function ScrollSpySidebar()
{
  
    $('.page-scrollspy').scrollspy({ target: '.main-sidebar-scrollspy' });
    $('.main-sidebar-scrollspy .nav-sidebar').affix({
          offset: {
              top: $('.page-main').offset().top,
              bottom: $('body').height() - ($('.page-main').height() + $('.page-main').offset().top) + 80,
          }
    });
    // console.log($('body').height() - ($('.page-main').height() + $('.page-main').offset().top) + 60);
    $('.main-sidebar-scrollspy .nav-sidebar > li > a').on('click', function(e)  
    {
        e.preventDefault();
        $('html, body').animate({
            scrollTop: $(this.hash).offset().top
        }, 350);        
    });    
}

// scrollspy nav responsive
function ResponsiveSidebarSpy()
{
  
  $('.nav-responsive .btn').on('click', function() 
    {
        var target = $('.nav-responsive');

        if (!target.hasClass('open')) 
        {
            target.addClass('open');
            $('html, body').animate({
                scrollTop: target.offset().top -70
            }, 250);        
        }
        else 
        {
            target.removeClass('open');
        }
    });
    $('.nav-responsive > .nav-sidebar a').on('click', function()
    {
        $(this).closest('.nav-responsive').removeClass('open');
    });
    $(document).on('click','.nav-responsive.open > .nav-sidebar > .dropdown > a', function(e)
    {
        e.preventDefault();
        $(this).parent().addClass('active');
    });
    $(document).mouseup(function (e)
    {   
        var target = $('.nav-responsive');
        if (!target.is(e.target) && target.has(e.target).length === 0) 
        {
            target.removeClass('open');
        }   
    }); 
};