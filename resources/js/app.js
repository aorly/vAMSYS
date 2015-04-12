// Sidebar Helper
var url = window.location.pathname.toLowerCase();
var menu = $('.page-sidebar-menu');
var activeLink = null;

if (menu !== null) {
    menu.find("li > a").each(function () {
        var path = $(this).attr("href").toLowerCase();
        if (path.length > 1 && url.substr(1, path.length - 1) == path.substr(1)) {
            activeLink = $(this);
            return;
        }
    });
}

if (activeLink !== null) {
    activeLink.parents('li').each(function () {
        $(this).addClass('active');
        $(this).find('> a > span.arrow').addClass('open');

        if ($(this).parent('ul.page-sidebar-menu').size() === 1) {
            $(this).find('> a').append('<span class="selected"></span>');
        }

        if ($(this).children('ul.sub-menu').size() === 1) {
            $(this).addClass('open');
        }
    });
}

// Top Menu Numbers
// TODO: This bit.