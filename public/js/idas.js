
// 切換語系
function language_change() {
    var language = event.target.id;
    $.ajax({
      type: "POST",
      url: "?url=Dashboards/change_language",
      data: {'language':language},
      dataType: "json",
      encode: true,
      async: false,//等待ajax完成
    }).done(function (data) {//成功且有回傳值才會執行
        location.reload();
    });
}