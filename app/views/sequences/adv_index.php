<link rel="stylesheet" href="<?php echo URLROOT; ?>css/w3.css" type="text/css">
<link rel="stylesheet" href="<?php echo URLROOT; ?>css/sequence_manager.css" type="text/css">
<script async="" src="<?php echo URLROOT; ?>js/w3.js"></script>

<div class="container-ms">
  <div class="content">
	<div class="w3-center">
	    <header>
            <h3><?php echo $text['advanced_seq_management']; ?></h3>
	    </header>
    </div>

    <div class="main-content">
        <div class="center-content">
            <div id="TableJobName">
                <table class="w3-table w3-striped">
                    <tr>
                        <td>
                            <label style="color: #000" for="job_id"><?php echo $text['job_id']; ?></label>&nbsp;&nbsp;
                            <input type="text" id="job_id" name="job_id" size="20" maxlength="20" value="<?php echo $data['job_id'];?>" disabled
                                style="height:35px; font-size:18px;text-align: center; background-color: #DDDDDD; border:0; margin: 3px;">
                        </td>
                        <td>
                            <button id="return" onclick="location.href = '?url=Jobs/index/advanced'"><?php echo $text['return']; ?></button>
                        </td>
                    </tr>
                </table>
            </div>

        	<div id="TableSeqSetting" align="center">
        	    <div class="scrollbar" id="style-seq">
                    <div class="force-overflow">
                		<table id="Table_Seq" class="w3-table-all w3-hoverable w3-large" style="margin: 0 !important;">
                			<thead id="header-table">
                				<tr style="height:48px; font-size: 16px;" class="w3-dark-grey">
                	                <th class="w3-center" width="13%"><?php echo $text['seq_id']; ?></th>
                	                <th class="w3-center" width="20%"><?php echo $text['seq_name']; ?></th>
                	                <th class="w3-center" width="10%"><?php echo $text['tightening_repeat']; ?></th>
                	                <th class="w3-center" width="10%"><?php echo $text['enable']; ?></th>
                	                <th class="w3-center" width="10%"><?php echo $text['up']; ?></th>
                	                <th class="w3-center" width="10%"><?php echo $text['down']; ?></th>
                	                <th class="w3-center" width="15%"><?php echo $text['total_step']; ?></th>
                	                <th class="w3-center" width="15%"> <?php echo $text['add_step']; ?></th>
                	            </tr>
                			</thead>
                			<tbody>
                				<?php
                					foreach ($data['sequences'] as $key => $value) { //sequences列表
                						echo '<tr>';
                						echo '<td class="w3-center">'.$value['sequence_id'].'</td>';
                						echo '<td class="w3-center">'.$value['sequence_name'].'</td>';
                						echo '<td class="w3-center">'.$value['tightening_repeat'].'</td>';
                						if($value['sequence_enable'] == 0){
                							echo '<td class="w3-center"><input class="seq_enable" style="zoom:2; vertical-align: middle" id="" name="" value="" type="checkbox" ></td>';
                						}else{
                							echo '<td class="w3-center"><input class="seq_enable" style="zoom:2; vertical-align: middle" id="" name="" value="" type="checkbox" checked="checked"></td>';
                						}
                						echo '<td class="w3-center"><button style="width:30px; height:30px; font-size: 16px;padding:0;background: url(../public/img/btn_uarrow.png) no-repeat;" onClick="MoveUp.call(this);">&#8593;</button></td>
                                			  <td class="w3-center"><button style="width:30px; height:30px; font-size: 16px;padding:0;background: url(../public/img/btn_darrow.png) no-repeat;" onClick="MoveDown.call(this);"></button></td>';
                			            echo '<td class="w3-center">'.$value['total_step'].'</td>';
                			            echo '<td class="w3-center">
                			                    <button class="button_sequence" style="width:30px; height:30px;padding:0;background: url(../public/img/btn_plus.png) no-repeat;" id="button_sequence" type="button" onclick="edit_step(\''.$value['sequence_id'].'\');"></button>
                			                </td>';

                						echo '</tr>';
                					}
                				?>
                			</tbody>
                		</table>
                    </div>
        	    </div>
        	</div>
        </div>
    </div>

    <div class="footer">
    	<div id="TotalPage">
            <table id="TotalSeqTable">
                <tr>
                   <td style="color:#000; float: left"><?php echo $text['total_seq']; ?> : <input style="text-align: center" id="RecordCnt" name="RecordCnt" readonly="readonly" disabled size="3" maxlength="3" value=""> </td>
                   <!--
                   <td width="50%" align="right" style="color:black">
                   	<?php echo $text['page']; ?> : <input style="text-align: center" id="CurrentPage" name="CurrentPage" readonly="readonly" size="3" maxlength="3" value="">
                   	<?php echo $text['page_of']; ?> <input style="text-align: center" id="TotalPage" name="TotalPage" readonly="readonly" size="3" maxlength="3" value=""> </td>
                   <td>
                       <input style="text-align: right" id="Total_Seq" name="Total_Seq" readonly="readonly" disabled size="3" maxlength="3" value="" hidden>
                   </td>
                   -->
                </tr>
            </table>
        </div>

        <div class="buttonbox">
            <!--
            <input id="S1" name="Job_Manager_Submit" type="button" value="|<" tabindex="1"  onclick="change_page('first')">
            <input id="S2" name="Job_Manager_Submit" type="button" value="<" tabindex="1"  onclick="change_page('previous')">
            -->
            <input id="S3" name="Job_Manager_Submit" type="button" value="<?php echo $text['New']; ?>" tabindex="1" onclick="crud_job('new')">
            <input id="S6" name="Job_Manager_Submit" type="button" value="<?php echo $text['Edit']; ?>" tabindex="1" onclick="crud_job('edit')">
            <input id="S5" name="Job_Manager_Submit" type="button" value="<?php echo $text['Copy']; ?>" tabindex="1" onclick="crud_job('copy')">
            <input id="S4" name="Job_Manager_Submit" type="button" value="<?php echo $text['Delete']; ?>" tabindex="1" onclick="crud_job('del')">
            <!--
            <input id="S7" name="Job_Manager_Submit" type="button" value=">" tabindex="1"  onclick="change_page('next')">
            <input id="S8" name="Job_Manager_Submit" type="button" value=">|" tabindex="1"  onclick="change_page('last')">
            -->
        </div>
    </div>

	<!-- Seq Modal -->
	<div class="modal fade" id="SeqModal" data-bs-keyboard="false" tabindex="-1" aria-labelledby="SeqModalLabel" aria-hidden="true">
	  <div class="modal-dialog modal-dialog-centered">
	    <div class="modal-content w3-animate-zoom" style="width: 550px">

	        <div class="modal-header">
	            <h1 class="modal-title fs-5" id="SeqModalLabel">New Sequence</h1>
                <button align="right" type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

	      <div class="modal-body">
	        <form id="new_seq_form">
	          <div class="row mb-3">
			    <label for="sequence_id" class="col-sm-5 col-form-label"><?php echo $text['seq_id']; ?>：</label>
			    <div class="col-sm-5">
			      <input type="number" class="form-control" id="sequence_id" disabled>
			    </div>
			  </div>
			  <div class="row mb-3">
			    <label for="sequence_name" class="col-sm-5 col-form-label"><?php echo $text['seq_name']; ?>：</label>
			    <div class="col-sm-5">
			      <input type="text" class="form-control" id="sequence_name" oninput="validateInput_seq_name('sequence_name')" maxlength="12">
			      <div class="invalid-feedback"><?php echo $error_message['sequence_name']; ?></div>
			    </div>
			  </div>
			  <div class="row mb-3">
			    <label for="TR" class="col-sm-5 col-form-label"><?php echo $text['tightening_repeat']; ?>：</label>
			    <div class="col-sm-5">
			      <input type="number" class="form-control" id="TR" min="0" max="99" oninput="validateInput_TP('TR')">
			      <div class="invalid-feedback"><?php echo $error_message['tightening_repeat']; ?></div>
			    </div>
			  </div>
			  <div class="row mb-3">
			    <label for="ng_stop" class="col-sm-5 col-form-label"><?php echo $text['NG_Stop']; ?>：</label>
			    <div class="col-sm-5">
			      <!-- <input type="number" class="form-control" id="ng_stop" min="0" max="9"> -->
					<select id="ng_stop">
					    <option value="" disabled selected><?php echo $text['Choose_option']; ?></option>
					    <option value="0"><?php echo $text['option_no']; ?></option>
					    <option value="1">01</option>
					    <option value="2">02</option>
					    <option value="3">03</option>
					    <option value="4">04</option>
					    <option value="5">05</option>
					    <option value="6">06</option>
					    <option value="7">07</option>
					    <option value="8">08</option>
					    <option value="9">09</option>
					</select>
			    </div>
			  </div>
			  <div class="row mb-3">
			    <legend for="ok_job" class="col-sm-5 col-form-label pt-0"><?php echo $text['OK_Sequence']; ?>：</legend>
			    <div class="col-sm-5">
			    	<div class="form-check form-check-inline">
					  <input class="form-check-input" type="radio" name="ok_seq_option" id="ok_seq_off" value="0">
					  <label class="form-check-label" for="ok_seq_off"><?php echo $text['switch_off']; ?></label>
					</div>
			      	<div class="form-check form-check-inline">
					  <input class="form-check-input" type="radio" name="ok_seq_option" id="ok_seq_on" value="1">
					  <label class="form-check-label" for="ok_seq_on"><?php echo $text['switch_on']; ?></label>
					</div>
			    </div>
			  </div>
			  <div class="row mb-3">
			    <label  class="col-sm-5 col-form-label pt-0"><?php echo $text['OK_Sequence_Stop']; ?>：</label>
			    <div class="col-sm-5">
			    	<div class="form-check form-check-inline">
					  <input class="form-check-input" type="radio" name="ok_seq_stop_option" id="ok_seq_stop_off" value="0">
					  <label class="form-check-label" for="ok_seq_stop_off"><?php echo $text['switch_off']; ?></label>
					</div>
			      	<div class="form-check form-check-inline">
					  <input class="form-check-input" type="radio" name="ok_seq_stop_option" id="ok_seq_stop_on" value="1">
					  <label class="form-check-label" for="ok_seq_stop_on"><?php echo $text['switch_on']; ?></label>
					</div>					
			    </div>
			  </div>
			  <div class="row mb-3">
			    <label for="timeout" class="col-sm-5 col-form-label"><?php echo $text['Timeout']; ?></label>
			    <div class="col-sm-5">
			      <input type="number" class="form-control" id="timeout" min="0" max="60" oninput="restrictInput_timeout('timeout')">
			      <div class="invalid-feedback"><?php echo $error_message['timeout']; ?></div>
			    </div>
			    <div class="col-sm-2 col-form-label" style="padding-left:0;"><?php echo $text['Second']; ?></div>
			  </div>			  
			</form>
	      </div>

	      <div class="modal-footer justify-content-center">
	        <button type="button" class="btn btn-primary" id="new_seq_save" onclick="new_seq_save()"><?php echo $text['save']; ?></button>
	        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><?php echo $text['close']; ?></button>
	      </div>
	    </div>
	  </div>
	</div>

	<!-- Copy Modal -->
	<div class="modal fade" id="CopySeq" data-bs-keyboard="false" tabindex="-1" aria-labelledby="CopySeqLabel" aria-hidden="true">
	  <div class="modal-dialog modal-dialog-centered">
	    <div class="modal-content w3-animate-zoom" style="width: 550px">

	      <div class="modal-header">
	        <h1 class="modal-title fs-5" id="CopySeqLabel"><?php echo $text['Copy_Sequence']; ?></h1>
	        <button align="right" type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
	      </div>

	      <div class="modal-body">
	        <form id="copy_seq_form">
	        	
	          <label for="from_seq_id" class="col-sm-5 col-form-label"><?php echo $text['copy_from']; ?></label>
	          <div style="padding-left: 10px;">
		          <div class="row mb-3">
				    <label for="from_seq_id" class="col-sm-5 col-form-label"><?php echo $text['seq_id']; ?>：</label>
				    <div class="col-sm-5">
				      <input type="number" class="form-control" id="from_seq_id" disabled>
				    </div>
				  </div>
				  <div class="row mb-3">
				    <label for="from_seq_name" class="col-sm-5 col-form-label"><?php echo $text['seq_name']; ?>：</label>
				    <div class="col-sm-5">
				      <input type="text" class="form-control" id="from_seq_name" disabled>
				    </div>
				  </div>
			  </div>

			  
			  <label for="to_seq_id" class="col-sm-5 col-form-label"><?php echo $text['copy_to']; ?></label>
			  <div style="padding-left: 10px;">
				  <div class="row mb-3">
				    <label for="to_seq_id" class="col-sm-5 col-form-label"><?php echo $text['seq_id']; ?>：</label>
				    <div class="col-sm-5">
				      <input type="number" class="form-control" id="to_seq_id" disabled>
				    </div>
				  </div>
				  <div class="row mb-3">
				    <label for="to_seq_name" class="col-sm-5 col-form-label"><?php echo $text['seq_name']; ?>：</label>
				    <div class="col-sm-5">
				      <input type="text" class="form-control" id="to_seq_name" >
				      <div class="invalid-feedback"><?php echo $error_message['to_seq_name']; ?></div>
				    </div>
				  </div>	
			  </div>
			  
			</form>
	      </div>

	      <div class="modal-footer justify-content-center">
	        <button type="button" class="btn btn-primary" id="copy_seq_save" onclick="copy_seq_save()"><?php echo $text['save']; ?></button>
	        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><?php echo $text['close']; ?></button>
	      </div>
	    </div>
	  </div>
	</div>
  </div>
</div>


<script type="text/javascript">
	$(document).ready(function () {
	    const job_id = $("#job_id").val();
	    let table = $('#Table_Seq').DataTable({
	    	// paging: false,
	    	searching: false,
	    	bInfo : false,
	    	"ordering": false,
	    	// "bPaginate": false,
	    	"dom": "frti",
	    	"pageLength": 99,
	    	columnDefs: [
			    {
			        targets: [0,1,2,3,4,5],
			    }
			  ]
	    	});
	    $('#Table_Seq tbody').on('click', 'tr', function () {
	        if ($(this).hasClass('selected')) {
	            $(this).removeClass('selected');
	        } else {
	            table.$('tr.selected').removeClass('selected');
	            $(this).addClass('selected');
	        }
	    });

	    let data = table.rows().data();
	    let page_info = table.page.info();

	    $('#RecordCnt').val(data.length);
	    $('#CurrentPage').val(page_info.page + 1);
	    $( "input[name='TotalPage']" ).val( page_info.pages);

	    //job enable checkbox
		$('#Table_Seq').on('change', "input[type='checkbox'].seq_enable", function() {
		    // 這裡放置checkbox變更後要執行的程式碼
		    let index = parseInt( this.parentNode.parentNode.childNodes[0].textContent.trim() );
		    let row1 = $('#Table_Seq').DataTable().row(index-1).data();
		    let ch_true = '<input class="seq_enable" style="zoom:2; vertical-align: middle" id="" name="" value="" type="checkbox" checked="checked">';
		    let ch_false = '<input class="seq_enable" style="zoom:2; vertical-align: middle" id="" name="" value="" type="checkbox" >';
		    
		    if($(this).is(':checked')){
		    	row1[4] = ch_true;
		    }else{
		    	row1[4] = ch_false;
		    }

		    let seq_id = this.parentNode.parentNode.childNodes[0].textContent.trim();
	    	if (seq_id == '') { seq_id =  this.parentNode.parentNode.childNodes[1].textContent.trim();}
	    	let status = $(this).is(':checked');
	    	enable_disable_seq(job_id,seq_id,status);
		});

	});

	function crud_job(argument) {
		
		const job_id = $("#job_id").val();
		let table = $('#Table_Seq').DataTable();
		let seq_id;
		try { 
		  seq_id = document.querySelector("#Table_Seq tr.selected").childNodes[0].textContent;//取得第一欄的值seq_id
		} catch (error) { 
		  seq_id = null; /* 任意默认值都可以被使用 */
		};
		try { 
		  seq_name = document.querySelector("#Table_Seq tr.selected").childNodes[1].textContent;//取得第一欄的值seq_name
		} catch (error) { 
		  seq_name = null; /* 任意默认值都可以被使用 */
		};

		// console.log(seq_id)

		if(argument == 'new'){
			new_seq(job_id);
		}
		if(argument == 'del' && seq_id != null){
	        delete_seq(job_id,seq_id);
		}
		if(argument == 'edit' && seq_id != null){
			edit_seq_normal(job_id,seq_id);
		}
		if(argument == 'copy' && seq_id != null){
			copy_seq(job_id,seq_id,seq_name);
		}

	}

	function edit_step(seq_id) {
		const job_id = $("#job_id").val();
		clearInvalidClass();

		if(job_id<100){
			location.href = '?url=Normalsteps/index/'+job_id+'/'+seq_id ;
		}
		if(job_id>100){
			location.href = '?url=Advancedsteps/index/'+job_id+'/'+seq_id ;
		}
		
	}
	
	function change_page(argument) {
		let table = $('#Table_Seq').DataTable();
		table.page( argument ).draw( 'page' );
		let page_info = table.page.info();
		$('#CurrentPage').val(page_info.page + 1);
	}

	//new job 按下new job button
	function new_seq(job_id) {
		$("#new_seq_form").trigger("reset");
		clearInvalidClass();
		
		$("#TR").val(1);
		$("#unfasten_force").val(50);
		$("#ng_stop").val(0);
		$("#timeout").val(20);
		$("input[name=ok_seq_option][value='1']").attr('checked',true); 
		$("input[name=ok_seq_stop_option][value='0']").attr('checked',true); 

		// body...
		let seq_id = get_seq_id_normal(job_id);
		if(seq_id > 50){ //避免新增超過99個seq
			return 0;
		}
		// SeqModalLabel
		$("#SeqModalLabel").text('<?php echo $text['new_seq']; ?>');
		// console.log(seq_id);
		$("#sequence_id").val(seq_id); //set job id
		$("#sequence_name").val('SEQ-'+seq_id); //set job id
		//
		$('#SeqModal').modal('toggle');

	}

	//new job 按下save鍵
	function new_seq_save(){
		$('#new_seq_save').prop('disabled', true);

	    var formData = {
	      job_id: $("#job_id").val(),
	      sequence_id: $("#sequence_id").val(),
	      sequence_name: $("#sequence_name").val(),
	      
	      tightening_repeat: $("#TR").val(),
	      ng_stop: $("#ng_stop").val(),

	      ok_seq_option: $('input[name=ok_seq_option]:checked').val(),
	      ok_seq_stop_option: $('input[name=ok_seq_stop_option]:checked').val(),
	      timeout: $("#timeout").val(),
	    };

	    
	    let valid_result = form_seq_validate();
	    // console.log(formData);

	    if(valid_result){
		    $.ajax({
		      type: "POST",
		      url: "?url=Sequences/create_seq",
		      data: formData,
		      dataType: "json",
		      encode: true,
		      beforeSend: function() {
				$('#overlay').removeClass('hidden');
			  },
		    }).done(function (data) {//成功且有回傳值才會執行
		      // console.log(data);
		      $('#overlay').addClass('hidden');
		      if(data['error_message'] != ''){
		      	alert(data['error_message']);	
		      }else{
		      	location.reload();	
		      }
		      $('#new_seq_save').prop('disabled', false);
		    });
		}
		$('#new_seq_save').prop('disabled', false);
	}

	//validate form
	function form_seq_validate() {		
	    var sequence_id = document.getElementById("sequence_id");
	    var sequence_name = document.getElementById("sequence_name");
	    var tightening_repeat = document.getElementById("TR");
	    var timeout = document.getElementById("timeout");


		var isFormValid = true; // 表单验证状态，默认为通过

		// 验证 Seq Name 字段
		if (sequence_name.value.trim() === "") {
		    sequence_name.classList.add("is-invalid");
		    isFormValid = false;
		} else {
		    sequence_name.classList.remove("is-invalid");
		}

		// 验证 TP
		var TPValue = parseInt(tightening_repeat.value);
		if (isNaN(TPValue) || TPValue > 99 || TPValue < 1) {
		    tightening_repeat.classList.add("is-invalid");
		    isFormValid = false;
		} else {
		    tightening_repeat.classList.remove("is-invalid");
		}

		// 验证 Unfasten Force 字段
		var timeouteValue = parseInt(timeout.value);
		if (isNaN(timeouteValue) || timeouteValue < 0.1 || timeouteValue > 60) {
		    timeout.classList.add("is-invalid");
		    isFormValid = false;
		} else {
		    timeout.classList.remove("is-invalid");
		}

		if (isFormValid) {
		    // 表单验证通过，可以执行其他操作，如提交表单数据
		    // console.log("Form is valid. Submitting...");
		    // 添加表单提交逻辑
		} else {
		    // 表单验证失败，可以执行相应的处理，如显示错误消息等
		    // console.log("Form is is-invalid. Please check the fields.");
		}

		// console.log(isFormValid);

		return isFormValid;
	}

	//驗證job name
	function validateInput_seq_name(input_id) {
		const inputElement = document.getElementById(input_id);
		inputElement.addEventListener('input', function(event) {
		  let inputValue = event.target.value;
		  
		  // 移除特殊字符 只留-
		  inputValue = inputValue.replace(/[^\a-\z\A-\Z0-9\u4E00-\u9FA5\- ]/g, '');
		  
		  // 限制字符串长度为10个字符
		  if (inputValue.length > 10) {
		    inputValue = inputValue.slice(0, 10);  // 截断字符串到限制长度
		  }
		  
		  // 更新输入框的值
		  event.target.value = inputValue;
		});
	}

	//驗證TP 的範圍
	function validateInput_TP(input_id) {
		var input = document.getElementById(input_id).value;

		// 使用正则表达式验证输入是否为数字，并处于范围 1 到 99 之间
		var pattern = /^(?:[1-9]|[1-9][0-9])$/;
		input.value = 99; // 将输入框的值设为0
		if (pattern.test(input)) {
		    // console.log("Input is valid.");
		    // 在这里执行其他操作，例如更新第二个输入框的值
		} else {
		    // console.log("Input is invalid. Please enter a number between 1 and 99.");
		    input.value = 0; // 将输入框的值设为0
		}

		if (input.length > 2) {
		    ss = input.slice(0, 2); // 仅保留前两个字符
		    document.getElementById(input_id).value = ss
		}

	}

	//限制timeout
	function restrictInput_timeout(input_id) {
	  // 获取输入的值
	  let decimalPlaces = 1;
	  var inputValue = document.getElementById(input_id).value;

	  var regex = new RegExp("^\\d+(\\.\\d{0," + decimalPlaces + "})?$");
	  
	  if (!regex.test(inputValue)) {
	    // 如果输入不符合要求，则截取合法的部分
	    var decimalValue = parseFloat(inputValue).toFixed(decimalPlaces);
	    event.target.value = decimalValue;
	  }else{
	  	if (inputValue < 0.1) {
		    inputValue = 0.1;
		    event.target.value = '';	
		  } else if (inputValue > 60.0) {
		    inputValue = 60.0;
		    event.target.value = inputValue;	
		  }
		    
	  }

	}

	//get job_id
	function get_seq_id_normal(job_id) {

		$.ajax({
	      type: "POST",
	      url: "?url=Sequences/get_head_seq_id_normal",
	      data: {'job_id':job_id},
	      dataType: "json",
	      encode: true,
	      async: false,//等待ajax完成
	    }).done(function (data) {//成功且有回傳值才會執行
	    	seq_id = data['missing_id'];
	    });

	    return seq_id;

	}

	function edit_seq_normal(job_id,seq_id){
		$("#SeqModalLabel").text('<?php echo $text['edit_seq']; ?>');

		$.ajax({
	      type: "POST",
	      url: "?url=Sequences/get_seq_by_id",
	      data: {'job_id':job_id,'seq_id':seq_id},
	      dataType: "json",
	      encode: true,
	      async: false,//等待ajax完成
	    }).done(function (res) {//成功且有回傳值才會執行
	      // console.log(res);
	      $("#new_seq_form").trigger("reset");

	      $("#sequence_id").val(seq_id);
	      $("#sequence_name").val(res['sequence_name']);
	      $("#TR").val(res['tightening_repeat']);
	      $("#ng_stop").val(res['ng_stop']);
	      $("input[name=ng_stop][value='"+res['ng_stop']+"']").attr('checked',true); 
	      $("input[name=ok_seq_option][value='"+res['ok_sequence']+"']").attr('checked',true); 
	      $("input[name=ok_seq_stop_option][value='"+res['ok_sequence_stop']+"']").attr('checked',true); 
	      $("#timeout").val(res['sequence_maxtime']);

	      $('#SeqModal').modal('toggle');
	    });

	}

	function delete_seq(job_id,seq_id) {

		let message = '<?php echo $text['delete_seq_confirm_text'];?>'+seq_id;
		Swal.fire({
		    title: message,
		    showCancelButton: true,
		    confirmButtonText: '<?php echo $text['delete_text'];?>',
		}).then((result) => {
		    /* Read more about isConfirmed, isDenied below */
		    if (result.isConfirmed) {
		        $.ajax({
			      type: "POST",
			      url: "?url=Sequences/delete_seq_by_id",
			      data: {'job_id':job_id,'seq_id':seq_id},
			      dataType: "json",
			      encode: true,
			      // async: false,//等待ajax完成
			      beforeSend: function() {
					$('#overlay').removeClass('hidden');
				  },
			    }).done(function (res) {//成功且有回傳值才會執行
			    	$('#overlay').addClass('hidden');
			    	location.reload();
			    });
		    }
		})

	}

	function copy_seq(job_id,seq_id,seq_name){
		clearInvalidClass();
		$.ajax({
	      type: "POST",
	      url: "?url=Sequences/get_head_seq_id_normal",
	      data: {'job_id':job_id},
	      dataType: "json",
	      encode: true,
	      async: false,//等待ajax完成
	    }).done(function (res) {//成功且有回傳值才會執行
	      // console.log(res);
	      if(res[0] >= 50 ){
	      	res[0] = 50;
	      }
	      $("#from_seq_id").val(seq_id);
	      $("#from_seq_name").val(seq_name);
	      $("#to_seq_id").val(res[0]);
	      

	      $('#CopySeq').modal('toggle');
	    });

	}

	//validate form
	function form_copy_seq_validate() {		
	    var to_seq_name = document.getElementById("to_seq_name");

		var isFormValid = true; // 表单验证状态，默认为通过

		// 验证 Seq Name 字段
		if (to_seq_name.value.trim() === "") {
		    to_seq_name.classList.add("is-invalid");
		    isFormValid = false;
		} else {
		    to_seq_name.classList.remove("is-invalid");
		}

		if (isFormValid) {
		    // 表单验证通过，可以执行其他操作，如提交表单数据
		    // console.log("Form is valid. Submitting...");
		    // 添加表单提交逻辑
		} else {
		    // 表单验证失败，可以执行相应的处理，如显示错误消息等
		    // console.log("Form is is-invalid. Please check the fields.");
		}

		// console.log(isFormValid);

		return isFormValid;
	}

	//new seq 按下save鍵
	function copy_seq_save(){
		$('#copy_seq_save').prop('disabled', true);

	    var formData = {
	      from_job_id: $("#job_id").val(),
	      from_seq_id: $("#from_seq_id").val(),
	      to_seq_id: $("#to_seq_id").val(),
	      to_seq_name: $("#to_seq_name").val(),
	    };

	    let valid_result = form_copy_seq_validate();

	    if(valid_result){
		    $.ajax({
			    type: "POST",
			    url: "?url=Sequences/copy_seq",
			    data: formData,
			    dataType: "json",
			    encode: true,
			    beforeSend: function() {
				  $('#overlay').removeClass('hidden');
				},
			}).done(function(data) { //成功且有回傳值才會執行
			    // console.log(data);
			    $('#overlay').addClass('hidden');
			    if(data['error_message'] != ''){
			     alert(data['error_message']);   
			    }else{
			     location.reload();  
			    }
			    if (data == true) {
			        $('#copy_seq_save').prop('disabled', false);
			        location.reload();
			    }
			});
		}else{
			$('#copy_seq_save').prop('disabled', false);
		}

	}


	//enable or disable seq
	function enable_disable_seq(job_id,seq_id,status) {
		// body...
		var formData = {
	      job_id: job_id,
	      seq_id: seq_id,
	      status: status,
	    };

		$.ajax({
	      type: "POST",
	      url: "?url=Sequences/enable_disable_seq",
	      data: formData,
	      dataType: "json",
	      encode: true,
	      beforeSend: function() {
		    $('#overlay').removeClass('hidden');
		  },
	    }).done(function (data) {//成功且有回傳值才會執行
	      // console.log(data);
	      $('#overlay').addClass('hidden');
	      if(data['error_message'] != ''){
	      	alert(data['error_message']);	
	      }else{
	      	// location.reload();	
	      }
	    });
	}


	//sequence up down js
	function get_previoussibling(n) {
	    x = n.previousSibling;
	    while (x.nodeType != 1) {
	        x = x.previousSibling;
	    }
	    return x;
	}

	function get_nextsibling(n) {
	    x = n.nextSibling;
	    while (x != null && x.nodeType != 1) {
	        x = x.nextSibling;
	    }
	    return x;
	}

	function MoveUp() {
	    var table,
	        row = this.parentNode;
	    var index = this.parentNode.parentNode.rowIndex;

	    while (row != null) {
	        if (row.nodeName == 'TR') {
	            break;
	        }
	        row = row.parentNode;
	    }

	    let data = $('#Table_Seq').DataTable().data();
	    let index2 = parseInt( row.childNodes[0].textContent );
	    
	    table = row.parentNode;
	    $(this.parentNode.parentNode).removeClass('selected');//保持up down selected

	    if( index2 > 1 ){
			swap_row(row,'up');
	    }else{
	    	Swal.fire('<?php echo $text['already_top']; ?>');
	    }

	}

	function MoveDown() {
	    var table,
	        row = this.parentNode;
	    var index = this.parentNode.parentNode.rowIndex;

	    while (row != null) {
	        if (row.nodeName == 'TR') {
	            break;
	        }
	        row = row.parentNode;
	    }

	    let data = $('#Table_Seq').DataTable().data();
	    let index2 = parseInt( row.childNodes[0].textContent );

	    table = row.parentNode;
	    $(this.parentNode.parentNode).removeClass('selected');//保持up down selected

	    if ( index2 < data.length ){
	    	swap_row(row,'down');
	    }else{
	    	Swal.fire('<?php echo $text['already_bottom']; ?>');
	    }

	}

	//function row swap
	function swap_row(row,direction) {
		let table = row.parentNode;
		let origin_index = row.childNodes[0].textContent;
		
		if(direction == 'up'){
			seq_id2 = parseInt(origin_index) - 1;
		}
		if(direction == 'down'){
			seq_id2 = parseInt(origin_index) + 1;
		}

		var formData = {
	    	job_id: $("#job_id").val(),
	    	seq_id1: origin_index,
	     	seq_id2: seq_id2,
	    };

	    // console.log(formData)

		$.ajax({
	      type: "POST",
	      url: "?url=Sequences/swap_seq",
	      data: formData,
	      dataType: "json",
	      encode: true,
	      beforeSend: function() {
			$('#overlay').removeClass('hidden');
		  },
	    }).done(function (data) {//成功且有回傳值才會執行
	      // console.log(data);
	      $('#overlay').addClass('hidden');
	      if(data['error_message'] != ''){
	      	alert(data['error_message']);	
	      }else{
	      	if(direction == 'up'){
				//-----------
				var index = parseInt( row.childNodes[0].textContent );
				let data = $('#Table_Seq').DataTable().data();

				let row1 = $('#Table_Seq').DataTable().row(parseInt(index)-1).data();
				let row2 = $('#Table_Seq').DataTable().row(parseInt(index)-2).data();
				let temp = row1[0];
				row1[0] = row2[0];
				row2[0] = temp;

				// 將兩行的資料交換
				$('#Table_Seq').DataTable().row(parseInt(index)-1).data(row2).draw(false);
				$('#Table_Seq').DataTable().row(parseInt(index)-2).data(row1).draw(false);

				$(row).removeClass('selected');//保持up down selected
				$(row.previousSibling).addClass('selected');//保持up down selected

	      		//-------------------------------


	      	}
	      	if(direction == 'down'){
	      		
	      		//-------------------------------
				var index = parseInt( row.childNodes[0].textContent );
				let data = $('#Table_Seq').DataTable().data();

				let row1 = $('#Table_Seq').DataTable().row(parseInt(index)-1).data();
				let row2 = $('#Table_Seq').DataTable().row(parseInt(index)).data();
				let temp = row1[0];
				row1[0] = row2[0];
				row2[0] = temp;

				// 將兩行的資料交換
				$('#Table_Seq').DataTable().row(parseInt(index)-1).data(row2).draw(false);
				$('#Table_Seq').DataTable().row(parseInt(index)).data(row1).draw(false);

				$(row).removeClass('selected');//保持up down selected
				$(row.nextSibling).addClass('selected');//保持up down selected

	      		//-------------------------------

	      	}
	      	// location.reload();	
	      }
	    });	
	}

</script>

<?php if($_SESSION['privilege'] != 'admin'){ ?>
<script>
  $(document).ready(function () {
    disableAllButtonsAndInputs()
    document.getElementById("return").disabled = false;
    document.getElementById("S6").disabled = false; //edit button
    document.getElementById("S1").disabled = false; //first
    document.getElementById("S2").disabled = false; //previous
    document.getElementById("S7").disabled = false; //next
    document.getElementById("S8").disabled = false; //last
    document.getElementsByClassName("btn-close")[0].disabled = false;//btn-close

    var buttons = document.getElementsByClassName("button_sequence");
    for (var i = 0; i < buttons.length; i++) {
        buttons[i].disabled = false;
    }
  });
</script>
<?php } ?>