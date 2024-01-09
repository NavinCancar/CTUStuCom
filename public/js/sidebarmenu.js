/*
Template Name: Admin Template
Author: Wrappixel

File: js
*/
// ==============================================================
// Auto select left navbar
// ==============================================================
$(function () {
    "use strict";
    var url = window.location + "";
    var path = url.replace(
      window.location.protocol + "//" + window.location.host + "/",
      ""
    );
    var element = $("ul#sidebarnav a").filter(function () {
      return this.href === url || this.href === path; // || url.href.indexOf(this.href) === 0;
    });
    element.parentsUntil(".sidebar-nav").each(function (index) {
      if ($(this).is("li") && $(this).children("a").length !== 0) {
        $(this).children("a").addClass("active");
        $(this).parent("ul#sidebarnav").length === 0
          ? $(this).addClass("active")
          : $(this).addClass("selected");
      } else if (!$(this).is("ul") && $(this).children("a").length === 0) {
        $(this).addClass("selected");
      } else if ($(this).is("ul")) {
        $(this).addClass("in");
      }
    });
  
    element.addClass("active");
    $("#sidebarnav a").on("click", function (e) {
      if (!$(this).hasClass("active")) {
        // hide any open menus and remove all other classes
        $("ul", $(this).parents("ul:first")).removeClass("in");
        $("a", $(this).parents("ul:first")).removeClass("active");
  
        // open our new menu and add the open class
        $(this).next("ul").addClass("in");
        $(this).addClass("active");
      } else if ($(this).hasClass("active")) {
        $(this).removeClass("active");
        $(this).parents("ul:first").removeClass("active");
        $(this).next("ul").removeClass("in");
      }
    });
    $("#sidebarnav >li >a.has-arrow").on("click", function (e) {
      e.preventDefault();
    });

    //Script để kiểm tra và chèn icon sau mỗi hide-menu nếu collapsible có class "show"
    $(document).ready(function () {
      // Duyệt qua mỗi phần tử có class "nav-small-cap"
      $('.nav-small-cap').each(function () {
        // Lấy target của collapsible từ thuộc tính data-bs-target
        var target = $(this).data('bs-target');

        // Kiểm tra xem collapsible có class "show" hay không
        if ($(target).hasClass('show')) {
          // Nếu có, chèn icon up sau phần tử hide-menu
          $(this).append('<i class="fas fa-chevron-up float-end"></i>');
        }
        else {
          // Nếu không, chèn icon down sau phần tử hide-menu
          $(this).append('<i class="fas fa-chevron-down float-end"></i>');
        }
      });

      // Xử lý sự kiện khi phần collapsible được click
      $('.nav-small-cap').click(function () {
        // Lấy target của collapsible từ thuộc tính data-bs-target
        var target = $(this).data('bs-target');

        // Toggle icon giữa fa-chevron-down và fa-chevron-up
        $(this).find('i').toggleClass('fa-chevron-down fa-chevron-up');
      });
    });
  });