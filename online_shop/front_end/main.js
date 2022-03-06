/**
* Template Name: Anyar - v4.7.0
* Template URL: https://bootstrapmade.com/anyar-free-multipurpose-one-page-bootstrap-theme/
* Author: BootstrapMade.com
* License: https://bootstrapmade.com/license/
*/
(function() {
    "use strict";
  
    /**
     * Easy selector helper function
     */
    const select = (el, all = false) => {
      el = el.trim()
      if (all) {
        return [...document.querySelectorAll(el)]
      } else {
        return document.querySelector(el)
      }
    }
  
    /**
     * Easy event listener function
     */
    const on = (type, el, listener, all = false) => {
      let selectEl = select(el, all)
      if (selectEl) {
        if (all) {
          selectEl.forEach(e => e.addEventListener(type, listener))
        } else {
          selectEl.addEventListener(type, listener)
        }
      }
    }
    
    /**
     * Mobile nav toggle
     */
    on('click', '.mobile-nav-toggle', function(e) {
      select('#navbar').classList.toggle('navbar-mobile')
      this.classList.toggle('bi-list')
      this.classList.toggle('bi-x')
    })
    on('click', '.navbar .dropdown > a', function(e) {
      if (select('#navbar').classList.contains('navbar-mobile')) {
        e.preventDefault()
        this.nextElementSibling.classList.toggle('dropdown-active')
      }
    }, true)
  })()

  function checkForm(){
    var name = document.forms["myform"]["name"].value;
    if(name.length < 6 || name.length > 30) {
        alert(" Tên phải có 6-30 ký tự !!");
        return false;
    }
    var username = document.forms["myform"]["username"].value;
    if(username.length < 6 || username.length > 30) {
        alert(" Tên đăng nhập phải có 6-30 ký tự !!");
        return false;
    }
    var mail = document.forms["myform"]["email"].value;
    if(mail.search(/^.+@.+\..+$/i) == -1) {
        alert("Email không đúng định dạng <sth>@<sth>.<sth> !!");
        return false;
    }
    var pwd = document.forms["myform"]["password"].value;
    if(pwd.length < 2 || pwd.length > 30) {
        alert("Password phải có 2-30 ký tự !!");
        return false;
    }
    var cpwd = document.forms["myform"]["confirm_password"].value;
    if(cpwd != pwd){
      alert("Mật khẩu xác nhận không đúng !!");
      return false;
    }
}
$(document).ready(function () {
  // MDB Lightbox Init
  $(function () {
    $("#mdb-lightbox-ui").load("mdb-addons/mdb-lightbox-ui.html");
  });
});



function checkForm3(){
  var txtEmail = document.forms["myform3"]["txtEmail"].value;
    if(txtEmail.search(/^.+@.+\..+$/i) == -1) {
        alert("Email không đúng định dạng <sth>@<sth>.<sth> !!");
        return false;
    }
    var txtMsg = document.forms["myform3"]["txtMsg"].value;
    if(txtMsg.length > 5000) {
      alert("Giới hạn 5000 ký tự !!");
      return false;
    }
  var txtPhone = document.forms["myform3"]["txtPhone"].value;
  if(txtPhone.length == 10) return true;
  else{
    alert("SĐT không đúng định dạng !!");
    return false;
  }
}

function checkban(){
  var status=document.forms["cmtform"]["status"].value;
  if(status=='0'){
    alert("Hiện bạn không thể bình luận !");
    return false;
  }
  return true;
}