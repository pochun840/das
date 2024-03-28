
// 切換語系(共用)
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


// data - 狀態切換
function get_type(selectObject) {
    var value = selectObject.value;
    window.location = '?url=Data&select_type='+value;
  
}

 // DB Sync
 function DB_sync(argument) {
    let title = '';
    let message = '';
    if(argument == 'C2D'){
        title = '<?php echo $text['system_db_exchange_C2D_t']; ?>';
        message = '<?php echo $text['system_db_exchange_C2D_m']; ?>';
    }
    if(argument == 'D2C'){
        title = '<?php echo $text['system_db_exchange_D2C_t']; ?>';
        message = '<?php echo $text['system_db_exchange_D2C_m']; ?>';
    }

    Swal.fire({
        title: title,
        text: message,
        showCancelButton: true,
        confirmButtonText: '<?php echo $text['confirm'];?>',
    }).then((result) => {
        /* Read more about isConfirmed, isDenied below */
        if (result.isConfirmed) {
            $.ajax({ // 提醒
                type: "GET",
                data: { way: argument },
                dataType: "json",
                url: "?url=Settings/SyncCheck",
            }).done(function(notice) { //成功且有回傳值才會執行
                if(notice.warning != ''){
                    Swal.fire({ // DB sync notice
                        title: 'Error',
                        text: notice.warning,
                    })
                }else{
                    if(notice.notice != ''){
                        Swal.fire({ // DB sync notice
                            title: '<?php echo $text['system_sync_warning_title']; ?>',
                            text: notice.notice,
                            showCancelButton: true,
                            confirmButtonText: '<?php echo $text['confirm'];?>',
                        }).then((result2) => {
                            /* Read more about isConfirmed, isDenied below */
                            if (result2.isConfirmed) {
                                DB_sync2(argument);
                            }
                        })
                    }else{
                        DB_sync2(argument);
                    }    
                }                    
            });
        }

    }) 
}

function DB_sync2(argument) {
    $.ajax({
        type: "POST",
        data: { way: argument },
        dataType: "json",
        url: "?url=Settings/db_sync",
        beforeSend: function() {
            $('#overlay').removeClass('hidden');
        },
    }).done(function(data) { //成功且有回傳值才會執行
        setTimeout(function() {
            $('#overlay').addClass('hidden');
        }, 1000);
        if (data.error != '') {
            alert(data.error);
        }
        console.log(data);
    });
}






