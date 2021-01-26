var api = './php/dskhoa.php';
function get(url, dataSend, callback) {
    $.ajax({
        type: 'get',
        url: url,
        data: dataSend,
        async: true,
        dataType: 'json',
        success: callback
    });
}

function show() {
    dataSend = {
        cauhoi: 'caub'
    }
    get(api, dataSend, function (res) {
        console.log(res);
    })
}