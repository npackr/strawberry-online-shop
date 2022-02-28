/* (c) NPACkr 2020. All Rights Reserved
        GET/POST METHOD
*/

var get_api = './php/get.php';
var post_api = './php/post.php';
var registration_api = './php/registration.php';
var login_api = './php/login.php';
var werehouse_api = './php/werehouse.php';
var order_api = './php/order.php';
var system_api = './php/system.php';

function queryDataPost(url, dataSend, callback) {
    $.ajax({
        type: 'post',
        url: url,
        data: dataSend,
        async: true,
        dataType: 'text',
        success: callback
    });
}

function queryDataGet(url, dataSend, callback) {
    $.ajax({
        type: 'get',
        url: url,
        data: dataSend,
        async: true,
        dataType: 'text',
        success: callback
    });
}

function queryJSONGet(url, dataSend, callback) {
    $.ajax({
        type: 'get',
        url: url,
        data: dataSend,
        async: true,
        dataType: 'json',
        success: callback
    });
}

function queryJSONPost(url, dataSend, callback) {
    $.ajax({
        type: 'post',
        url: url,
        data: dataSend,
        async: true,
        dataType: 'json',
        success: callback
    });
}

/* (c) NPACkr 2020. All Rights Reserved
        PAGE ONLOAD SCRIPT
*/

$(document).ready(function() {
    showQuickLaunchButton();
    showProfileBadge();
})

/* (c) NPACkr 2020. All Rights Reserved
        MODULE
*/

function goToLogin() {
    window.location.href = 'login.html';
}

function goToTheHome() {
    window.location.href = 'index.html';
}

function goToContactForm() {
    comingSoonAlert();
}

function showLoginButton() {
    $('div.npackr_thaotacnhanh').html('<a href="#" onClick="goToLogin()" class="btn btn-info btn-lg bigger uppercase">Đăng nhập</a><div class="login-description">để mua ngay và dễ dàng theo dõi đơn hàng</div>');
}

function showBuyNowButton() {
    $('div.npackr_thaotacnhanh').html('<a onclick="comingSoonAlert()" class="btn btn-info btn-lg bigger uppercase">Mua ngay</a>');
}

function loginChecking() {
    var onlinekey = localStorage.getItem('npackr_onlinekey');
    var username = localStorage.getItem('npackr_username');
    var loginid = localStorage.getItem('npackr_loginid');
    var dataSend = {
        request: 'login_checking',
        onlinekey: onlinekey,
        username: username,
        loginid: loginid
    }

    queryJSONPost(login_api, dataSend, function (res) {
        if (res['result'] == 1) {
            localStorage.setItem('npackr_loginstatus', 1);
        } else {
            localStorage.setItem('npackr_loginstatus', 0);
            localStorage.removeItem('npackr_loginstatus');
            localStorage.removeItem('npackr_onlinekey');
            localStorage.removeItem('npackr_loginid');
            localStorage.removeItem('npackr_username');
            localStorage.removeItem('npackr_name');
            console.log(res);
        }
    })
}

function showProfileBadge() {
    loginChecking();
    var loginstatus = localStorage.getItem('npackr_loginstatus');
    if (loginstatus == 1) {
        var user = localStorage.getItem('npackr_username');
        var name = localStorage.getItem('npackr_name');
        if (user != null && name != null) {
            $('.npackr_profilebadge').html('<img onerror="showAlternativeAvatar()" alt="' + name + '" src="images/avatar/' + user +'.jpg"> <span class="username"> ' + name +' </span><b class="caret"></b>');
        } else {
            $('.npackr_profilebadge').html('<img alt="Hãy đăng nhập để đổi ảnh đại diện" src="https://secure.gravatar.com/avatar/bdefff757401be9a2ece4f5bd9b4850c"> <span class="username"> Khách </span> <b class="caret"></b>');
        }
    } else {
        $('.npackr_profilebadge').html('<img alt="Hãy đăng nhập để đổi ảnh đại diện" src="https://secure.gravatar.com/avatar/bdefff757401be9a2ece4f5bd9b4850c"> <span class="username"> Khách </span> <b class="caret"></b>');
    }
    showProfileBadgeMenu();
}

function showProfileBadgeMenu() {
    var loginstatus = localStorage.getItem('npackr_loginstatus');
    if (loginstatus == 1) {
        $('.npackr_profilebadge_menu').html('<li><a href="#" onClick="logOut()"><i class="fa fa-suitcase"></i> Đăng xuất</a></li>');
    } else {
        $('.npackr_profilebadge_menu').html('<li><a href="#" onClick="goToLogin()"><i class="fa fa-suitcase"></i> Đăng nhập</a></li>');
    }
}

function showAlternativeAvatar() {
    var name = localStorage.getItem('npackr_name');
    $('.npackr_profilebadge').html('<img alt="Chưa tải lên ảnh đại diện" src="/forum/upload/uc_server/images/noavatar_small.gif" /> <span class="username"> ' + name +' </span><b class="caret"></b>');
}


/* (c) NPACkr 2020. All Rights Reserved
        QUICK BOOTBOX SCRIPT
*/

function alert_unsuccessful(msg) {
    bootbox.alert({
        size: 'small',
        title: '<span style="color: red;">Thao tác thất bại</style>',
        message: msg,
        callback: function () { }
    })
}

function alert_successful(msg) {
    bootbox.alert({
        size: 'small',
        title: '<span style="color: green;">Thao tác thành công</style>',
        message: msg,
        callback: function () { }
    })
}

function alert_information(msg) {
    bootbox.alert({
        size: 'small',
        title: '<span style="color: blue;">Thông tin</style>',
        message: msg,
        callback: function () { }
    })
}

function alert_error(msg) {
    bootbox.alert({
        size: 'small',
        title: '<span style="color: blue;">Phát sinh lỗi</style>',
        message: msg,
        callback: function () { }
    })
}

function comingSoonAlert() {
    bootbox.alert({
        size: 'small',
        title: '<span style="color: #f90;">Tính năng sắp được ra mắt</style>',
        message: 'Tính năng này vẫn đang được xây dựng và sẽ ra mắt trong thời gian tới, cùng chờ đợi nha ^^',
        callback: function () { }
    })
}

/* (c) NPACkr 2020. All Rights Reserved
        MAIN INDEX SCRIPT
*/

function showQuickLaunchButton() {
    var loginstatus = localStorage.getItem('npackr_loginstatus');
    if ( loginstatus == 1) {
        showBuyNowButton();
    } else {
        showLoginButton();
    }
}

$('.npackr_posts_menu').hover(function () {
    getPostsList(5);
})

$('.npackr_newitems_menu').hover(function () {
    getNewItemList();
})

$('.npackr_nationalities_menu').hover(function () {
    getNationalitiesList();
})

function getNewItemList() {
    var dataSend = {
        chungloai: 0
    }
    queryDataGet(get_api, dataSend, function (res) {
        showNewItemMenu(res);
    })
}

function getNationalitiesList() {
    var dataSend = {
        xuatxu: 'unknown'
    }
    queryDataGet(get_api, dataSend, function (res) {
        showNationalitiesMenu(res);
    })
}

function getPostsList(num_of_posts) {
    var dataSend = {
        request : 'getpostslist',
        numofposts : num_of_posts
    }

    queryJSONPost(system_api, dataSend, function(res) {
        if (res['result'] == 1) {
            showPostsListMenu(res['result_content'], num_of_posts);
        } else {
            return -1;
        }
    })
}

function getItemDescription(item_id) {

    var dataSend = {
        request : 'getitem',
        id : item_id
    }

    queryJSONGet(werehouse_api, dataSend, function(res) {
        var login_status = localStorage.getItem('npackr_loginstatus');
        var item_picnum = res['item_picnum'];
        var item_amount = $('.npackr-categories-detail-view-amount-picker-amount-input').val();
        var item_price = new Intl.NumberFormat('vi-VN', { style: 'currency', currency: 'VND' }).format(res['item_price']);
        $('.npackr-categories-detail-view-title').html(res['item_name']);
        $('.npackr-categories-detail-view-bio-madein').html('<div class="npackr-categories-madein-block" style="background-image: url(./images/freepik-flags/png/'+ res['item_country_id'] + '.png)"><div class="npackr-categories-madein-title">Xuất xứ:</div><div class="npackr-categories-madein-content">' + res['item_country_name'] + '</div></div>');
        $('.npackr-categories-detail-view-bio-provider').html(res['item_provider']);
        $('.npackr-categories-detail-view-bio-price').html('<div class="npackr-categories-price-block"><div class="npackr-categories-price-amount">'+ item_price +'</div><div class="npackr-categories-price-qte">/ 1 kg</div></div>');
        $('.npackr-categories-detail-view-properties').html(res['item_properties']);
        $('.npackr-categories-detail-view-description').html('<div class="npackr-categories-detail-view-description-body">'+ res['item_description'] + '</div>');
        if (login_status == 1) {
            $('.npackr-categories-detail-view-order-btn').html('<a onclick="addItemToCart(' + item_id +', '+ item_amount +')" class="btn btn-success npackr-categories-selected" type="button">Chọn mua</button>');
        } else {
            $('.npackr-categories-detail-view-amount-picker').html('<a onclick="goToLogin()" class="btn btn-success npackr-categories-selected" type="button">Đăng nhập để chọn mua</button>');
        }

        showItemPicture(item_id, item_picnum, 1);
    })
}

function showPostsListMenu(res, num_of_posts) {
    var show_content = '';
    var content = res;
    var i;
    var x = 1;
    for (i = 1; i <= num_of_posts; i++) {
        //show_content = show_content + '<li class="npackr_posts_' + content[x]['post_title'].toString() + ' uppercase"><a href="#" title="' + content[x]['post_title'].toString() + '">' + content[x]['post_id'].toString() + ' <b class=" fa fa-angle-right"></b></a></li>';
        x++;
    }
    $('.npackr_posts_data').html('<div style="margin: 10px">Tính năng đang xây dựng</div>');
}

function showNationalitiesMenu(res) {
    $('.npackr_nationalities_data').html(res);
}

function showNewItemMenu(res) {
    $('.npackr_newitems_data').html(res);
}

function getSystemInformation(content_name) {
    dataSend = {
        request: content_name
    }

    queryJSONPost(system_api, dataSend, function (res) {
        $('.npackr-system-information-view-title').html(res['result_title']);
        $('.npackr-system-information-view-body').html(res['result_content']);
        $('#npackr-system-information-view').modal('show');
    })
}

function showItemPicture(item_id, item_picnum, item_pic_id) {
    var item_next_pic = item_pic_id + 1;
    var item_prev_pic = item_pic_id - 1;

    if (item_next_pic > item_picnum) {
        item_next_pic = 1;
    }
    if (item_prev_pic < 0) {
        item_prev_pic = 1;
    }

    var picture_code ='<div class="npackr-categories-detail-picture" style="background-image: url(images/items/' + item_id + '/' + item_pic_id + '.jpg); "></div>';
    var control_button_code ='<a href=#" onclick="showItemPicture('+item_id+', '+item_picnum+', '+item_prev_pic+')" class="npackr-categories-detail-prev-picture-button">◀</a><a href="#" onclick="showItemPicture('+item_id+', '+item_picnum+', '+item_next_pic+')" class="npackr-categories-detail-next-picture-button">▶</a>';

    if (item_picnum <= 1) {
        $('.npackr-categories-detail-view-cover-background').html(picture_code);
    } else {
        $('.npackr-categories-detail-view-cover-background').html(picture_code + control_button_code);
    }
    
}

function addItemToCart(item_id, item_amount) {
    var username = localStorage.getItem('npackr_username');
    var onlinekey = localStorage.getItem('npackr_onlinekey');
    var dataSend = {
        request : 'addtocart',
        username : username,
        onlinekey : onlinekey,
        itemid : item_id,
        itemamount : item_amount
    }

    queryJSONPost(order_api, dataSend, function(res) {
        if (res['result'] == 1) {
            console.log(res);
            var dialog = bootbox.dialog({
                size: 'small',
                title: 'Thêm vào giỏ thành công',
                message: 'Hàng đã vào giỏ, bạn có muốn thanh toán ngay?',
                buttons: {
                    true: {
                        label: 'Mua thêm nữa',
                        className: 'btn-default',
                        classback: function() {

                        }
                    },
                    false: {
                        label: 'Chốt đơn',
                        className: 'btn-success',
                        classback: function() {
                        }
                    }
                }
            })
        } else {
            alert_unsuccessful(res['error_description']);
        }
    })
}
/* (c) NPACkr 2020. All Rights Reserved
        REGISTRATION SCRIPT
*/

var name = '';
var address = '';
var phone = '';
var gender = '';
var email = '';
var username = '';
var password = '';

$('.signup-btn-submit').click(function () {
    var name = $('.signup-fullname').val();
    var address = $('.signup-address').val();
    var phone = $('.signup-phone').val();
    var gender = $('.signup-gender').val();
    var email = $('.signup-email').val();
    var username = $('.signup-username').val();
    var password = $('.signup-password').val();
    sendSignUpInformation(name, address, phone, gender, email, username, password);
})

function checkingTOSAgreement() {
    var obj = $('.signup-tosagree').val();
    if (obj == 1) {
        return 1
    } else {
        return 0
    }
}

function checkingPasswordAreSame() {
    var obj1 = $('.signup-password').val();
    var obj2 = $('.signup-passwordrepeat').val();
    if (obj1 == obj2) {
        return 1
    } else {
        return 0
    }
}

function checkingIfFeildsEmpty(name, phone, email, username, password) {
    if (name != '') {
        if (phone != '') {
            if (username != '') {
                if (password != '') {
                    if (email != '') {
                        return 0
                    } else {
                        alert_error('Email không thể để trống!');
                        return 1
                    }
                } else {
                    alert_error('Mật khẩu không thể để trống!');
                    return 1
                }
            } else {
                alert_error('Tên người dùng không thể để trống!');
                return 1
            }
        } else {
            alert_error('Số điện thoại không thể để trống!');
            return 1
        }
    } else {
        alert_error('Tên không thể để trống!');
        return 1
    }
}

function sendSignUpInformation(name, address, phone, gender, email, username, password) {
    if (checkingIfFeildsEmpty(name, phone, email, username, password) == 0) {
        if (checkingPasswordAreSame() == 1) {
            if (checkingTOSAgreement() == 1) {
                var dataSend = {
                    request: 'checking_phone_number',
                    phone: phone
                }
                queryJSONPost(registration_api, dataSend, function (res) {
                    console.log(res['exists']);
                    if (res['exists'] == 0) {

                        var dataSend = {
                            request: 'checking_username',
                            username: username
                        }
                        queryJSONPost(registration_api, dataSend, function(res) {
                            if (res['exists'] == 0) {

                                var dataSend = {
                                    request: 'signup',
                                    name: name,
                                    address: address,
                                    phone: phone,
                                    gender: gender,
                                    email: email,
                                    username: username,
                                    password: password
                                }
                
                                queryJSONPost(registration_api, dataSend, function (res) {
                                    if (res['result'] == 1) {
                                        bootbox.confirm({
                                            size : 'small',
                                            message: 'Đăng ký thành công, bạn có muốn đăng nhập ngay?',
                                            callback: function(result) {
                                                if (result == true) {
                                                    goToLogin();
                                                } else {
                                                    goToTheHome();
                                                }
                                            }
                                        })
                                    } else {
                                        alert_unsuccessful('Đăng ký thất bại, vui lòng thử lại sau!');
                                    }
                                });
                            } else {
                                alert_error('Tài khoản ' + username + ' đã được sử dụng!');
                            }
                        })
                    } else {
                        alert_error('Số điện thoại ' + phone + ' đã được sử dụng!');
                    }
                })
            } else {
                alert_information('Bạn cần đồng ý điều khoản và quy tắc về quyền riêng tư mới có thể đăng ký');
            }
        } else {
            alert_error('Mật khẩu nhập lại không trùng khớp');
        }
    }
}

/* (c) NPACkr 2020. All Rights Reserved
        LOGIN SCRIPT
*/

$('.npackr-login-submit').click( function () {
    login_username = $('.npackr-login-username').val();
    login_password = $('.npackr-login-password').val();
    sendLoginInformation(login_username, login_password);
})

$('.npackr-login-forgotpassword-submit').click( function () {
    var forgotusername = $('.npackr-login-forgotpassword-username').val();
    sendForgotPasswordUsername(forgotusername);
})

function sendForgotPasswordUsername(username) {
    alert_information('Sử dụng email đã đăng ký tài khoản ' + username + ' để gửi email yêu cầu cấp lại mật khẩu đến địa chỉ: webmaster@npackr.com để thực hiện cấp lại mật khẩu mới');
}
function sendLoginInformation(obj_username, obj_password) {
    var dataSend = {
        request : 'login',
        username : obj_username,
        password : obj_password
    }

    queryJSONPost(login_api, dataSend, function (res) {
        if (res['result'] == 1) {
            localStorage.setItem('npackr_username', res['user_username']);
            localStorage.setItem('npackr_name', res['user_fullname']);
            localStorage.setItem('npackr_onlinekey', res['user_onlinekey']);
            localStorage.setItem('npackr_loginid', res['user_loginid']);
            localStorage.setItem('npackr_loginstatus', '1');
            goToTheHome();
            
        } else {
            alert_unsuccessful(res['error_description']);
        }
    })
}

function logOut() {
    var obj_onlinekey = localStorage.getItem('npackr_onlinekey');
    var obj_loginid = localStorage.getItem('npackr_loginid');
    var obj_username = localStorage.getItem('npackr_username');
    var dataSend = {
        request : 'logout',
        username : obj_username,
        onlinekey : obj_onlinekey,
        loginid : obj_loginid
    }
    queryJSONPost(login_api, dataSend, function (res) {
        if (res['result'] == '1') {
            localStorage.removeItem('npackr_loginstatus');
            localStorage.removeItem('npackr_onlinekey');
            localStorage.removeItem('npackr_loginid');
            localStorage.removeItem('npackr_username');
            goToTheHome();
        } else {
            alert_unsuccessful(res['error_description']);
        }
    })
}

// Kiểm tra độ dài của trường textBox
function checkTextBoxLength(object, needlength) {
    // Lấy giá trị từ object đưa vào value
    value = $(object).val();
    console.log('Độ dài của trường' + object + ' là ' + value.length);
    // Kiểm tra độ dài của giá trị trong value
    if (value.length != needlength) {
        return false;
    } else {
        return true;
    }
}

// Kiểm tra trường có phải toàn là số hay không
function isNumber(n) {
    return /^-?[\d.]+(?:e-?\d+)?$/.test(n);
}

//Kiểm tra trường có phải là email hay không
function validateEmail(email) {
    var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return re.test(email);
}

/* Bắt sự kiện click thay button thay đổi ảnh đại diện */
$('.btn_DoiAnhDaiDien').click(function () {
    $('.fibr_image_file_browser').val('')
    $('.modal_TaiLenAnhDaiDien').modal('show');
    imageUpload('imgSP', 'uploaded_thumbnail_preview', 'onSuccessAvatarUpload');
});

/* Tải lên ảnh */
var imageUpload = function (photo, callback) {
    var formData = new FormData();
    formData.append('photo', photo);
    $.ajax({
        url: 'php/uploadfile.php',
        type: 'POST',
        data: formData,
        async: true,
        xhrFields: {
            withCredentials: true
        },
        processData: false, // tell jQuery not to process the data
        contentType: false, // tell jQuery not to set contentType
        success: callback
    });
};

/* Sự kiện tải lên ảnh thành công */
var urlimage = '';
function onSuccessAvatarUpload(oj) {
    console.log(oj);
    $("#uploaded_thumbnail_preview").removeClass("is-hidden");
    $("#uploaded_thumbnail_preview").attr("src", oj.url);
    console.log(oj.attach);
    urlimage = oj.attach;
}

/* Bắt sự kiện bấm nút Đổi ảnh đại diện trong Modal tải lên */
$(".btn_CapNhatAnhDaiDien").click(function () {
    if (urlimage == "") {
        alert_info("Vui lòng chọn ảnh để tải lên");
    } else {
        var datasend = {
            event: "UpdateAvatar",
            iduser: iduser,
            avartar: urlimage
        };
        console.log(datasend);
        queryData("php/theloai.php", datasend, function (data) {
            console.log(data);
            if (data["UpdateAvatar"] == 1) {
                alert_successful("Đổi ảnh đại diện thành công !");
                //$(".avartaimage").attr("src",urllocal+"file/"+urlimage);
                localStorage.removeItem("Avatar");
                localStorage.setItem('Avatar', urlimage);
                buildUserDropdown();
                urlimage = '';
            } else {
                alert_unsuccessful('Đổi ảnh đại diện thất bại!');
            }
        });

    }
});


// Phân trang
function buildSlidePage(obj, codan, pageActive, totalPage) {
    var html = "";
    pageActive = parseInt(pageActive);
    for (i = 1; i <= codan; i++) {
        if (pageActive - i < 0) break;
        html = '<button type="button" class="btn btn-outline btn-default" value="' + (pageActive - i) + '">' + (pageActive - i + 1) + '</button> ' + html;
    }
    if (pageActive > codan) {
        html = '<button type="button" class="btn btn-outline btn-default" value="' + (pageActive - i) + '">...</button>' + html;
    }
    html += '<button type="button" class="btn btn-outline btn-default" style="background-color: #5cb85c" value="' + pageActive + '">' + (pageActive + 1) + '</button> ';
    for (i = 1; i <= codan; i++) {
        if (pageActive + i >= totalPage) break;
        html = html + '<button  type="button" class="btn btn-outline btn-default" value="' + (pageActive + i) + '">' + (pageActive + i + 1) + '</button> ';
    }
    if (totalPage - pageActive > codan + 1) {
        html = html + '<button type="button" value="' + (pageActive + i) + '" class="btn btn-outline btn-default">...</button> ';
    }
    obj.html('<div align="center" class="paging-bar"> ' + html + '</div>');
}

function printSTT(record, pageCurr) {
    if ((pageCurr + 1) == 1) {
        return 1;
    } else {
        return record * (pageCurr + 1) - (record - 1);
    }
}