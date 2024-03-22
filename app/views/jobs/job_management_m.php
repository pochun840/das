<?php require APPROOT . 'views/inc/header.php'; ?>

<link rel="stylesheet" href="<?php echo URLROOT; ?>css/w3.css" type="text/css">
<link rel="stylesheet" href="<?php echo URLROOT; ?>css/job_manager_m.css" type="text/css">
<script async="" src="<?php echo URLROOT; ?>js/w3.js"></script>

<style>
.t1{font-size: 16px; margin: 5px 0px; display: flex; align-items: center;}
.t2{font-size: 16px; margin: 5px 0px;}
</style>

<div class="container-ms">
    <div class="w3-text-white w3-center">
        <table>
            <tr id="header">
                <td width="100%">
                	<?php if($data['job_type'] == 'normal'){ ?>
                    	<h3><?php echo $text['normal_job_management']; ?></h3>
                	<?php } ?>
                	<?php if($data['job_type'] == 'advanced'){ ?>
                    	<h3><?php echo $text['advanced_job_management']; ?></h3>
                    <?php } ?>
                </td>
                <td>
                    <button id="home" class="w3-btn w3-round-large" style="height:50px;padding: 0" onclick="window.location.href='?url=Dashboards'">
                        <img src="./img/btn_home.png">
                    </button>
                </td>
            </tr>
        </table>
    </div>

    <div class="main-content ">
        <div class="center-content">
        	<div id="TableJobSetting" align="center">
        	    <div class="scrollbar" id="style-job">
                    <div class="force-overflow">
                		<table id="Table_Job" class="w3-table-all w3-hoverable w3-large">
                			<thead id="header-table">
                				<tr style="height:45px; font-size: 3.4vmin;vertical-align: middle;" class="w3-dark-grey">
                                    <th class="w3-center" width="13%"><?php echo $text['job_id']; ?></th>
                                    <th class="w3-center" width="20%"><?php echo $text['job_name']; ?></th>
                                    <th class="w3-center" width="18%"><?php echo $text['job_ok']; ?></th>
                                    <th class="w3-center" width="20%"><?php echo $text['job_ok_stop']; ?></th>
                                    <th class="w3-center" width="15%"><?php echo $text['total_seq']; ?></th>
                                    <th class="w3-center"><?php echo $text['add_seq']; ?></th>
                                </tr>
                			</thead>
                			<tbody style="height:40px; font-size: 3.2vmin;vertical-align: middle;">
                				<?php
                					foreach ($data['jobs'] as $key => $value) { //job列表
                						echo '<tr>';
                						echo '<td class="w3-center">'.$value['job_id'].'</td>';
                						echo '<td class="w3-center">'.$value['job_name'].'</td>';
                						if($value['ok_job'] == 1){ echo '<td class="w3-center"> '.$text['switch_on'].' </td>'; }else{ echo '<td class="w3-center"> '.$text['switch_off'].' </td>'; }
                						if($value['ok_job_stop'] == 1){ echo '<td class="w3-center"> '.$text['switch_on'].' </td>'; }else{ echo '<td class="w3-center"> '.$text['switch_off'].' </td>'; }
                						echo '<td class="w3-center">'.$value['total_seq'].'</td>';
                						echo "<td class='w3-center'> <img src='..\public\img\btn_plus.png' style=\" border: 1px solid black;cursor: pointer; \" onclick=\"location.href = '?url=Sequences/index/".$value['job_id']."';\"> </td>";
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
            <table id="TotalJobTable">
                <tr>
                    <td style="color:#000; float: left"><?php echo $text['total_job']; ?> : <input style="text-align: center" id="RecordCnt" name="RecordCnt" readonly="readonly" disabled size="5" maxlength="3" value=""> </td>
                    <!--
                    <td align="center" style="color:#000">
                   	    <?php echo $text['page']; ?> : <input style="text-align: center" id="CurrentPage" name="CurrentPage" readonly="readonly" size="2" maxlength="3" value="">
                   	    <?php echo $text['page_of']; ?> <input style="text-align: center" id="TotalPage2" name="TotalPage" readonly="readonly" size="2" maxlength="3" value=""> </td>
                    <td>
                        <input style="text-align: center" id="Total_Seq" name="Total_Seq" readonly="readonly" disabled size="1" maxlength="3" value="" hidden>
                    </td>
                    -->
                </tr>
            </table>
        </div>

        <div class="buttonbox">
            <input id="S3" name="Job_Manager_Submit" type="button" value="<?php echo $text['New']; ?>" tabindex="1" onclick="crud_job('new')">
            <input id="S6" name="Job_Manager_Submit" type="button" value="<?php echo $text['Edit']; ?>" tabindex="1" onclick="crud_job('edit')">
            <input id="S5" name="Job_Manager_Submit" type="button" value="<?php echo $text['Copy']; ?>" tabindex="1" onclick="crud_job('copy')">
            <input id="S4" name="Job_Manager_Submit" type="button" value="<?php echo $text['Delete']; ?>" tabindex="1" onclick="crud_job('del')">
        </div>
    </div>

	<div style="display: none;">
		<button id="new">new</button>
		<button id="del">delete</button>
		<button id="edit">edit</button>
		<button id="copy">copy</button>
	</div>
	<div style="display: none;">
		<button onclick="change_page('first')">first</button>
		<button onclick="change_page('previous')">previous</button>
		<button onclick="change_page('next')">next</button>
		<button onclick="change_page('last')">last</button>
	</div>
	<!-- Job Modal -->
	<div class="modal fade" id="JobModal" data-bs-keyboard="false" tabindex="-1" aria-labelledby="JobModalLabel" aria-hidden="true">
	    <div class="modal-dialog modal-dialog-centered modal-lg">
	        <div class="modal-content w3-animate-zoom" style="width: 650px">
	            <div class="modal-header">
	                <h1 class="modal-title fs-5" id="JobModalLabel">New Job</h1>
	                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
	            </div>
	            <input id="edit_mode" value="" style="display:none;">

	            <div class="modal-body">
	                <form id="new_job_form">
	                    <div class="row">
			                <div for="job_id" class="col-5 t1"><?php echo $text['job_id']; ?>：</div>
			                <div class="col t2">
			                    <?php if($data['job_type'] == 'normal'){ ?>
			                    <input type="number" min=1 max=99 class="form-control" id="job_id" maxlength="2" onblur="syncInputValue('job_id')" oninput="validateInput('job_id')" required>
			  	                <?php } ?>

               			  	    <?php if($data['job_type'] == 'advanced'){ ?>
                			    <input type="number" min=101 max=170 class="form-control" id="job_id" maxlength="2" onblur="syncInputValue('job_id')" oninput="validateInput('job_id')" required>
                			  	<?php } ?>
			                    <div class="invalid-feedback"><?php echo $error_message['job_id']; ?></div>
			                </div>
			            </div>
			            <div class="row">
			                <div for="job_name" class="col-5 t1"><?php echo $text['job_name']; ?>：</div>
			                <div class="col t2">
			                    <input type="text" class="form-control" id="job_name" maxlength="12" oninput="validateInput_name('job_name')" required>
			                    <div class="invalid-feedback"><?php echo $error_message['job_name']; ?></div>
			                </div>
			            </div>
			            <div class="row">
			                <div for="ok_job" class="col-5 t1"><?php echo $text['job_ok']; ?>：</div>
            			    <div class="col t2">
            			    	<div class="form-check form-check-inline col-4">
            					    <input class="form-check-input" type="radio" name="ok_job_option" id="ok_job_off" value="0" style="zoom:1.3; vertical-align: middle">
            					    <label class="form-check-label t2" for="ok_job_off"><?php echo $text['switch_off']; ?></label>
            					</div>
            			      	<div class="form-check form-check-inline col">
            					    <input class="form-check-input" type="radio" name="ok_job_option" id="ok_job_on" value="1" style="zoom:1.3; vertical-align: middle">
            					    <label class="form-check-label t2" for="ok_job_on"><?php echo $text['switch_on']; ?></label>
            					</div>
            			    </div>
			            </div>
			            <div class="row">
			                <div  class="col-5 t1"><?php echo $text['job_ok_stop']; ?>：</div>
            			    <div id="div_ok_job_stop" class="col t2">
            			      	<div class="form-check form-check-inline col-4">
            					    <input class="form-check-input" type="radio" name="ok_job_stop_option" id="ok_job_stop_off" value="0" style="zoom:1.3; vertical-align: middle">
            					    <label class="form-check-label t2" for="ok_job_stop_off"><?php echo $text['switch_off']; ?></label>
            					</div>
            			      	<div class="form-check form-check-inline col">
            					    <input class="form-check-input" type="radio" name="ok_job_stop_option" id="ok_job_stop_on" value="1" style="zoom:1.3; vertical-align: middle">
            					    <label class="form-check-label t2" for="ok_job_stop_on"><?php echo $text['switch_on']; ?></label>
            					</div>
            			    </div>
			            </div>
			            <div class="row">
			                <div  class="col-5 t1"><?php echo $text['unfasten_direction']; ?>：</div>
			                <div class="col t2">
 			    	            <?php if( strtoupper($data['job_type']) == 'ADVANCED'){  ?>
            			    	<div class="form-check form-check-inline col-4">
            					    <input class="form-check-input" type="radio" name="unfasten_direction_option" id="unfasten_direction_CW" value="0" style="zoom:1.3; vertical-align: middle">
            					    <label class="form-check-label t2" for="unfasten_direction_CW"><?php echo $text['CW']; ?></label>
            					</div>
            					<?php } ?>

            			      	<div class="form-check form-check-inline col-4">
            					    <input class="form-check-input" type="radio" name="unfasten_direction_option" id="unfasten_direction_CCW" value="1" style="zoom:1.3; vertical-align: middle">
            					    <label class="form-label t2" for="unfasten_direction_CCW"><?php echo $text['CCW']; ?></label>
            					</div>
            					<div class="form-check form-check-inline col">
            					    <input class="form-check-input" type="radio" name="unfasten_direction_option" id="unfasten_direction_disable" value="2" style="zoom:1.3; vertical-align: middle">
            					    <label class="form-label" for="unfasten_direction_disable" style="font-size: 18px"><?php echo $text['disable']; ?></label>
            					</div>
            			    </div>
			            </div>
			            <div class="row">
			                <div for="unfasten_RPM" class="col-5 t1"><?php echo $text['unfasten_rpm']; ?>：</div>
            			    <div class="col t2">
            			        <input type="number" class="form-control" id="unfasten_RPM" min="0" max="<?php echo $data['tool_info']['tool_maxrpm'];?>" oninput="validateInput_RPM('unfasten_RPM')">
            			        <div class="invalid-feedback"><?php echo $error_message['unfasten_RPM']; ?></div>
            			    </div>
                            <div class="col t2">
                			    <label><?php echo $text['max_rpm'];?> <?php echo $data['tool_info']['tool_maxrpm'];?></label>
                            </div>
			            </div>
			            <div class="row">
			                <div for="unfasten_force" class="col-5 t1"><?php echo $text['unfasten_force']; ?>(%)</div>
			                <div class="col t2">
			                    <input type="number" class="form-control" id="unfasten_force" min="0" max="110" oninput="validateInput_unfasten_force('unfasten_force')">
			                    <div class="invalid-feedback"><?php echo $error_message['unfasten_force']; ?></div>
			                </div>
			            </div>
			            <div class="row mb-6">
						    <div class="col-5 t1"><?php echo $text['rev_count']; ?></div>
						    <div class="col t2">
            			      	<div class="form-check form-check-inline col-4">
            					    <input class="form-check-input" type="radio" name="reverse_cnt_mode_option" id="reverse_cnt_mode_off" value="0" style="zoom:1.3; vertical-align: middle">
            					    <label class="form-check-label" for="reverse_cnt_mode_off" style="font-size: 18px; margin: 5px 0px 5px"><?php echo $text['switch_off']; ?></label>
            					</div>
            			      	<div class="form-check form-check-inline col">
            					    <input class="form-check-input" type="radio" name="reverse_cnt_mode_option" id="reverse_cnt_mode_on" value="1" style="zoom:1.3; vertical-align: middle">
            					    <label class="form-check-label" for="reverse_cnt_mode_on" style="font-size: 18px; margin: 5px 0px 5px"><?php echo $text['switch_on']; ?></label>
            					</div>
            			    </div>
						</div>
						<div class="row mb-3 ">
							<div for="unfasten_RPM" class="col-5 t1"><?php echo $text['rev_tor_threshold']; ?></div>
						    <div class="col-3">
						        <input type="number" class="form-control" id="reverse_threshold_torque" min="0" max="110" oninput="validateInput_unfasten_threshold('reverse_threshold_torque')">
						    </div>
						    <div class="col-3 t2">
						        <label>
						            <?php echo $text['unit_status_'.$data['controller_Info']['device_torque_unit'].'']; ?></label>
						    </div>
						</div>
			        </form>
	            </div>

	            <div class="modal-footer justify-content-center">
	                <button type="button" class="btn btn-primary" id="new_job_save" onclick="new_job_save()"><?php echo $text['save']; ?></button>
	                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><?php echo $text['close']; ?></button>
	            </div>
	        </div>
	    </div>
	</div>

	<!-- Copy Modal -->
	<div class="modal fade" id="CopyJob" data-bs-keyboard="false" tabindex="-1" aria-labelledby="CopyJobLabel" aria-hidden="true">
	    <div class="modal-dialog modal-dialog-centered">
	        <div class="modal-content w3-animate-zoom" style="width: 600px">
	            <div class="modal-header">
	                <h1 class="modal-title fs-5" id="CopyJobLabel"><?php echo $text['copy_job']; ?></h1>
	                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
	            </div>

	            <div class="modal-body">
	                <form id="new_job_form">
	                    <div for="from_job_id" class="col-5 t1"><?php echo $text['copy_from']; ?></div>
	                    <div style="padding-left: 10px;">
        		            <div class="row">
        				        <div for="from_job_id" class="col-5 t1"><?php echo $text['job_id']; ?>：</div>
        				        <div class="col t2">
        				            <input type="number" class="form-control" id="from_job_id" disabled>
        				        </div>
        				    </div>
				            <div class="row">
				                <div for="from_job_name" class="col-5 t1"><?php echo $text['job_name']; ?>：</div>
				                <div class="col t2">
				                    <input type="text" class="form-control" id="from_job_name" disabled>
				                </div>
				            </div>
			            </div>

			            <div for="from_job_id" class="col-5 t1"><?php echo $text['copy_to']; ?></div>
			            <div style="padding-left: 10px;">
				            <div class="row">
				                <div for="to_job_id" class="col-5 t1"><?php echo $text['job_id']; ?>：</div>
                				<div class="col t2">
                				    <input type="number" class="form-control" id="to_job_id" onblur="syncInputValue('to_job_id')" oninput="validateInput('to_job_id')" >
                				    <div class="invalid-feedback"><?php echo $error_message['copy_to_id']; ?></div>
                				</div>
            				</div>
				            <div class="row">
				                <div for="to_job_name" class="col-5 t1"><?php echo $text['job_name']; ?>：</div>
				                <div class="col t2">
				                    <input type="text" class="form-control" id="to_job_name" oninput="validateInput_name('to_job_name')" >
				                    <div class="invalid-feedback"><?php echo $error_message['copy_to_name']; ?></div>
				                </div>
				            </div>
			            </div>
			        </form>
	            </div>

	            <div class="modal-footer justify-content-center">
	                <button type="button" class="btn btn-primary" id="copy_job_save" onclick="copy_job_save()"><?php echo $text['save']; ?></button>
	                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><?php echo $text['close']; ?></button>
	            </div>
	        </div>
	    </div>
	</div>

</div>


<script type="text/javascript">
	$(document).ready(function () {
	    let table = $('#Table_Job').DataTable({
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
	    $('#Table_Job tbody').on('click', 'tr', function () {
	        if ($(this).hasClass('selected')) {
	            $(this).removeClass('selected');
	        } else {
	            table.$('tr.selected').removeClass('selected');
	            $(this).addClass('selected');
	        }
	    });

	    let data = table.rows().data();
	    let page_info = table.page.info();
	    // console.log(page_info)

	    $('#RecordCnt').val(data.length);
	    $('#CurrentPage').val(page_info.page + 1);
	    $( "input[name='TotalPage']" ).val( page_info.pages);

	});

	function crud_job(argument) {

		let table = $('#Table_Job').DataTable();
		let job_id;
		try { 
		  job_id = table.row('.selected').data()[0];//取得第一欄的值job_id
		} catch (error) {
		  job_id = null; // 任意默认值都可以被使用
		};
		// console.log(job_id)

		if(argument == 'new'){
			new_job();
		}
		if(argument == 'del' && job_id != null){
	        delete_job(job_id);
		}
		if(argument == 'edit' && job_id != null){
			edit_job(job_id);
		}
		if(argument == 'copy' && job_id != null){
			copy_job(job_id);
		}
	}
	
	function change_page(argument) {
		let table = $('#Table_Job').DataTable();
		table.page( argument ).draw( 'page' );
		let page_info = table.page.info();
		$('#CurrentPage').val(page_info.page + 1);
	}

	//new job 按下new job button
	function new_job() {
		document.getElementById("new_job_form").reset();
		$("#edit_mode").val('false');//讓編輯時判斷

		clearInvalidClass();
		$("#job_id").prop('disabled', false);

		//自動代出預設值
		$("input[name=ok_job_option][value='1']").attr('checked',true);
		$("input[name=ok_job_stop_option][value='0']").attr('checked',true);
		$("input[name=unfasten_direction_option][value='1']").attr('checked',true);
		$("#unfasten_RPM").val(200);
		$("#unfasten_force").val(50);
		$("input[name=reverse_cnt_mode_option][value='0']").attr('checked',true);
		$("#reverse_threshold_torque").val(0.0);

		// JobModalLabel
		$("#JobModalLabel").text('<?php echo $text['new_job'];?>');
		$('#JobModal').modal('toggle');

	}

	//new job 按下save鍵
	function new_job_save(){
		$('#new_job_save').prop('disabled', true);

	    var formData = {
	      job_id: $("#job_id").val(),
	      job_name: $("#job_name").val(),
	      ok_job_option: $('input[name=ok_job_option]:checked').val(),
	      ok_job_stop_option: $('input[name=ok_job_stop_option]:checked').val(),
	      unfasten_direction_option: $('input[name=unfasten_direction_option]:checked').val(),
	      unfasten_RPM: $("#unfasten_RPM").val(),
	      unfasten_force: $("#unfasten_force").val(),
	      reverse_threshold_torque: $("#reverse_threshold_torque").val(),
	      reverse_cnt_mode: $('input[name=reverse_cnt_mode_option]:checked').val(),
	    };

	    // console.log($("#JobModalLabel").text());

	    let valid_result = form_validate();
	    let edit_mode = $("#edit_mode").val();

	    if(valid_result){
	    	$.ajax({
				type: "POST",
				url: "?url=Jobs/job_id_repeat_check",
				data: {'job_id':$("#job_id").val()},
				dataType: "json",
				encode: true,
			}).done(function (dupli) {//成功且有回傳值才會執行
				// console.log(dupli);
				// alert(555);
				if(dupli['result'] && edit_mode != 'true'){
					Swal.fire({
					  title: '<?php echo $text['cover_confirm_text'];?>',
					  showCancelButton: true,
					  confirmButtonText: '<?php echo $text['cover_text'];?>',
					}).then((result) => {
					  /* Read more about isConfirmed, isDenied below */
						// console.log(result)
					  if (result.isConfirmed) {
					  	$.ajax({
					      type: "POST",
					      url: "?url=Jobs/create_job",
					      data: formData,
					      dataType: "json",
					      encode: true,
					      beforeSend: function() {
							$('#overlay').removeClass('hidden');
						  },
					    }).done(function (data) {//成功且有回傳值才會執行
					      $('#overlay').addClass('hidden');
					      if(data['error_message'] != ''){
					      	alert(data['error_message']);	
					      }else{
					      	location.reload();	
					      }
					      $('#new_job_save').prop('disabled', false);
					    });
					  }else{
					  	$('#new_job_save').prop('disabled', false);
					  }
					})
				}else{
					$.ajax({
					    type: "POST",
					    url: "?url=Jobs/create_job",
					    data: formData,
					    dataType: "json",
					    encode: true,
					    beforeSend: function() {
						  $('#overlay').removeClass('hidden');
						},
					}).done(function(data) { //成功且有回傳值才會執行
						$('#overlay').addClass('hidden');
					    if (data['error_message'] != '') {
					        alert(data['error_message']);
					    } else {
					        location.reload();
					    }
					    $('#new_job_save').prop('disabled', false);
					});
				}
				
			});

		}else{
			$('#new_job_save').prop('disabled', false);	
		}
		

	}

	//validate form
	function form_validate() {
		// body...
		let job_type = '<?php echo $data['job_type']; ?>';
		var jobIDInput = document.getElementById("job_id");
		var jobNameInput = document.getElementById("job_name");
		var unfastenRPMInput = document.getElementById("unfasten_RPM");
		var unfastenForceInput = document.getElementById("unfasten_force");

		var isFormValid = true; // 表单验证状态，默认为通过

		// 验证 Job ID 字段
		if(job_type == 'normal'){
			if (jobIDInput.value.trim() === "" || jobIDInput.value.trim() > 99 || jobIDInput.value.trim() <= 0) {
			    jobIDInput.classList.add("is-invalid");
			    isFormValid = false;
			} else {
			    jobIDInput.classList.remove("is-invalid");
			}
		}

		if(job_type == 'advanced'){
			if (jobIDInput.value.trim() === "" || jobIDInput.value.trim() > 170 || jobIDInput.value.trim() < 101) {
			    jobIDInput.classList.add("is-invalid");
			    isFormValid = false;
			} else {
			    jobIDInput.classList.remove("is-invalid");
			}
		}

		// 验证 Job Name 字段
		if (jobNameInput.value.trim() === "") {
		    jobNameInput.classList.add("is-invalid");
		    isFormValid = false;
		} else {
		    jobNameInput.classList.remove("is-invalid");
		}

		// 验证 Unfasten RPM 字段
		var unfastenRPMValue = parseInt(unfastenRPMInput.value);
		if (isNaN(unfastenRPMValue) || unfastenRPMValue < 60 || unfastenRPMValue > <?php echo $data['tool_info']['tool_maxrpm'];?> ) {
		    unfastenRPMInput.classList.add("is-invalid");
		    isFormValid = false;
		} else {
		    unfastenRPMInput.classList.remove("is-invalid");
		}

		// 验证 Unfasten Force 字段
		var unfastenForceValue = parseInt(unfastenForceInput.value);
		if (isNaN(unfastenForceValue) || unfastenForceValue < 1 || unfastenForceValue > 110) {
		    unfastenForceInput.classList.add("is-invalid");
		    isFormValid = false;
		} else {
		    unfastenForceInput.classList.remove("is-invalid");
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

	//自動帶入job name
	function syncInputValue(input_id) {
		var input1Value = document.getElementById(input_id).value;

	  if(document.getElementById("job_name").value == ''){
		  document.getElementById("job_name").value = 'JOB-'+input1Value;
		}
	  if(input1Value == '')
	  {
	  	document.getElementById("job_name").value = '';
	  }

	  	if(input_id == 'to_job_id'){
		  if(document.getElementById("to_job_name").value == ''){
			  document.getElementById("to_job_name").value = 'JOB-'+input1Value;
			}
		  if(input1Value == '')
		  {
		  	document.getElementById("to_job_name").value = '';
		  }
		}
	}

	//驗證job_id 的範圍
	function validateInput(input_id) {

	  let job_type = '<?php echo $data['job_type']; ?>';

	  var input = document.getElementById(input_id).value;
	  // console.log(input.value)

	  if(job_type == 'normal'){
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

	   if(job_type == 'advanced'){
		

		  input = input.replace(/\D/g, "");

		  // 限制输入长度为 3
		  input = input.slice(0, 3);

		  // 将字符串转换为数字
		  var numericValue = parseInt(input, 10);

		  // 判断数字是否在范围内
		  if (input.length === 3 && numericValue >= 101 && numericValue <= 170) {
		    this.value = numericValue; // 保留合法数值
		  } else {
		    this.value = ""; // 清空输入
		  }

	   }

	}

	//驗證job name
	function validateInput_name(input_id) {
		const inputElement = document.getElementById(input_id);
		inputElement.addEventListener('input', function(event) {
		  let inputValue = event.target.value;
		  
		  // 移除特殊字符 只留-
		  inputValue = inputValue.replace(/[^\a-\z\A-\Z0-9\u4E00-\u9FA5\- ]/g, '');
		  
		  // 限制字符串长度为14个字符
		  if (inputValue.length > 12) {
		    inputValue = inputValue.slice(0, 12);  // 截断字符串到限制长度
		  }
		  
		  // 更新输入框的值
		  event.target.value = inputValue;
		});
	}

	//驗證RPM
	function validateInput_RPM(input_id) {
		const inputElement = document.getElementById(input_id);
		inputElement.addEventListener('input', function(event) {
		  let inputValue = event.target.value;
		  
		  // 移除特殊字符 只留-
		  inputValue = inputValue.replace(/\D/g, '');
		  
		  // 限制字符串长度为10个字符
		  if (inputValue.length > 4) {
		    inputValue = inputValue.slice(0, 4);  // 截断字符串到限制长度
		  }
		  
		  // 更新输入框的值
		  event.target.value = inputValue;
		});
	}

	//驗證unfasten force
	function validateInput_unfasten_force(input_id) {
		const inputElement = document.getElementById(input_id);
		inputElement.addEventListener('input', function(event) {
		  let inputValue = event.target.value;
		  
		  // 移除特殊字符 只留-
		  inputValue = inputValue.replace(/\D/g, '');
		  
		  // 限制字符串长度为10个字符
		  if (inputValue.length > 3) {
		    inputValue = inputValue.slice(0, 3);  // 截断字符串到限制长度
		  }
		  
		  // 更新输入框的值
		  event.target.value = inputValue;
		});
	}

	//驗證unfasten threshold torque
	function validateInput_unfasten_threshold(input_id) {
		const inputElement = document.getElementById(input_id);
		inputElement.addEventListener('input', function(event) {
		  let inputValue = event.target.value;
		  		  
		  // 限制小數點後的位數為4位
	        if (inputValue.includes('.')) {
	            let decimalPart = inputValue.split('.')[1];
	            if (decimalPart && decimalPart.length > 4) {
	                inputValue = inputValue.slice(0, inputValue.indexOf('.') + 5);
	            }
	        }
		  
		  // 更新输入框的值
		  event.target.value = inputValue;
		});
	}

	//get job_id
	function get_job_id_normal() {
		let job_id = 0;

		$.ajax({
	      type: "POST",
	      url: "?url=Jobs/get_head_job_id_normal",
	      dataType: "json",
	      encode: true,
	      async: false,//等待ajax完成
	    }).done(function (data) {//成功且有回傳值才會執行
	    	job_id = data['missing_id'];
	    });

	    return job_id;

	}

	function edit_job(job_id){
		$("#JobModalLabel").text('<?php echo $text['edit_job'];?>');
		$("#job_id").prop('disabled', true);
		$("#edit_mode").val('true');//讓編輯時判斷
		clearInvalidClass();

		$.ajax({
	      type: "POST",
	      url: "?url=Jobs/get_job_by_id",
	      data: {'job_id':job_id},
	      dataType: "json",
	      encode: true,
	      async: false,//等待ajax完成
	    }).done(function (res) {//成功且有回傳值才會執行
	      // console.log(res);
	      $("#new_job_form").trigger("reset");

	      $("#job_id").val(job_id);
	      $("#job_name").val(res['job_name']);
	      $("input[name=ok_job_option][value='"+res['ok_job']+"']").attr('checked',true); 
	      $("input[name=ok_job_stop_option][value='"+res['ok_job_stop']+"']").attr('checked',true); 
	      $("input[name=unfasten_direction_option][value='"+res['reverse_direction']+"']").attr('checked',true); 
	      $("#unfasten_RPM").val(res['reverse_rpm']);
	      $("#unfasten_force").val(res['reverse_force']);
	      $("#reverse_threshold_torque").val(res['reverse_threshold_torque']);
	      $("input[name=reverse_cnt_mode_option][value='"+res['reverse_cnt_mode']+"']").attr('checked',true); 

	      $('#JobModal').modal('toggle');
	    });

	}

	function delete_job(job_id) {

		//job_id 
		let message = '<?php echo $text['delete_confirm_text'];?>'+job_id;
		Swal.fire({
		    title: message,
		    showCancelButton: true,
		    confirmButtonText: '<?php echo $text['delete_text'];?>',
		}).then((result) => {
		    /* Read more about isConfirmed, isDenied below */
		    if (result.isConfirmed) {
		        $.ajax({
			      type: "POST",
			      url: "?url=Jobs/delete_job_by_id",
			      data: {'job_id':job_id},
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

	function copy_job(job_id){
		clearInvalidClass();
		$.ajax({
	      type: "POST",
	      url: "?url=Jobs/get_job_by_id",
	      data: {'job_id':job_id},
	      dataType: "json",
	      encode: true,
	      async: false,//等待ajax完成
	    }).done(function (res) {//成功且有回傳值才會執行
	      // console.log(res);

	      $("#from_job_id").val(job_id);
	      $("#from_job_name").val(res['job_name']);

	      $('#CopyJob').modal('toggle');
	    });

	}

	//new job 按下save鍵
	function copy_job_save(){
		$('#copy_job_save').prop('disabled', true);

		let valid_result = form_copy_validate();
		let confirm = false;
	    let to_job_id2 = $("#to_job_id").val()

	    var formData = {
	      from_job_id: $("#from_job_id").val(),
	      from_job_name: $("#from_job_name").val(),
	      to_job_id: $("#to_job_id").val(),
	      to_job_name: $("#to_job_name").val(),
	    };

	    if(valid_result){
		    $.ajax({
				type: "POST",
				url: "?url=Jobs/job_id_repeat_check",
				data: {'job_id':to_job_id2},
				dataType: "json",
				encode: true,
			}).done(function (dupli) {//成功且有回傳值才會執行
				// console.log(dupli);
				if(dupli['result']){
					Swal.fire({
					  title: '<?php echo $text['cover_confirm_text'];?>',
					  showCancelButton: true,
					  confirmButtonText: '<?php echo $text['cover_text'];?>',
					}).then((result) => {
					  /* Read more about isConfirmed, isDenied below */
						// console.log(result)
					  if (result.isConfirmed) {
					  	$.ajax({
							type: "POST",
							url: "?url=Jobs/copy_job",
							data: formData,
							dataType: "json",
							encode: true,
							beforeSend: function() {
							  $('#overlay').removeClass('hidden');
							},
						}).done(function (data) {//成功且有回傳值才會執行
							// console.log(data);
							$('#overlay').addClass('hidden');
							if(data == true){
								$('#copy_job_save').prop('disabled', false);
								Swal.fire('Saved!', '', 'success')
								location.reload();	
							}
						});
					  }else{
					  	$('#copy_job_save').prop('disabled', false);
					  }
					})
				}else{
					$.ajax({
							type: "POST",
							url: "?url=Jobs/copy_job",
							data: formData,
							dataType: "json",
							encode: true,
							beforeSend: function() {
							  $('#overlay').removeClass('hidden');
							},
						}).done(function (data) {//成功且有回傳值才會執行
							// console.log(data);
							$('#overlay').addClass('hidden');
							if(data == true){
								$('#copy_job_save').prop('disabled', false);
								Swal.fire('Saved!', '', 'success')
								location.reload();	
							}
						});
				}
				
			});
		}else{
			$('#copy_job_save').prop('disabled', false);
		}



	   

	}

	//validate form
	function form_copy_validate() {
		// body...
		let job_type = '<?php echo $data['job_type']; ?>';
		var from_job_id = document.getElementById("from_job_id");
		var from_job_name = document.getElementById("from_job_name");
		var to_job_id = document.getElementById("to_job_id");
		var to_job_name = document.getElementById("to_job_name");

		var isFormValid = true; // 表单验证状态，默认为通过

		// 验证 Job ID 字段
		if(job_type == 'normal'){
			if (from_job_id.value.trim() === "" || from_job_id.value.trim() > 99 || from_job_id.value.trim() <= 0) {
			    from_job_id.classList.add("is-invalid");
			    isFormValid = false;
			} else {
			    from_job_id.classList.remove("is-invalid");
			}
		}
		if(job_type == 'advanced'){
			if (from_job_id.value.trim() === "" || from_job_id.value.trim() > 170 || from_job_id.value.trim() <= 100) {
			    from_job_id.classList.add("is-invalid");
			    isFormValid = false;
			} else {
			    from_job_id.classList.remove("is-invalid");
			}
		}

		// 验证 Job Name 字段
		if (from_job_name.value.trim() === "") {
		    from_job_name.classList.add("is-invalid");
		    isFormValid = false;
		} else {
		    from_job_name.classList.remove("is-invalid");
		}

		// 验证 Job ID 字段
		if(job_type == 'normal'){
			if (to_job_id.value.trim() === "" || to_job_id.value.trim() > 99 || to_job_id.value.trim() <= 0) {
			    to_job_id.classList.add("is-invalid");
			    isFormValid = false;
			} else {
			    to_job_id.classList.remove("is-invalid");
			}
		}
		if(job_type == 'advanced'){
			if (to_job_id.value.trim() === "" || to_job_id.value.trim() > 170 || to_job_id.value.trim() <= 100) {
			    to_job_id.classList.add("is-invalid");
			    isFormValid = false;
			} else {
			    to_job_id.classList.remove("is-invalid");
			}
		}

		// 验证 Job ID 字段
		if (to_job_name.value.trim() === "" ) {
		    to_job_name.classList.add("is-invalid");
		    isFormValid = false;
		} else {
		    to_job_name.classList.remove("is-invalid");
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

	//ok job option display ok job stop
    document.querySelectorAll('input[name="ok_job_option"]').forEach(function(radio) {
      radio.addEventListener('change', function() {
        // 获取选中的radio的值
        var selectedValue = document.querySelector('input[name="ok_job_option"]:checked').value;

        // 根据值来显示或隐藏特定的div
        if (selectedValue === '1') {
          document.getElementById('div_ok_job_stop').style.display = 'block';
        } else {
          document.getElementById('div_ok_job_stop').style.display = 'none';
        }
      });
    });


</script>

<?php if($_SESSION['privilege'] != 'admin'){ ?>
<script>
  $(document).ready(function () {
    disableAllButtonsAndInputs()
    document.getElementById("home").disabled = false;
    document.getElementById("S6").disabled = false; //edit button
    document.getElementById("S2").disabled = false; //previous
    document.getElementById("S7").disabled = false; //next
    document.getElementsByClassName("btn-close")[0].disabled = false;
  });
</script>
<?php } ?>

<?php require APPROOT . 'views/inc/footer.php'; ?>
