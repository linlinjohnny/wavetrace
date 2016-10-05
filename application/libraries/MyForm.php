<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class MyForm {
 
 	private $CI = NULL;
	private $components = array();

	public function __construct() {
		$this->CI = &get_instance();
	}
	
	public function addBlock($content) {
		$this->components[] = "<div class='block clearfix'>{$content}</div>";
	}
	
	/* pattern example
	** date: /([0-9]*-[0-9]*-[0-9]*)/
	** account: /^[a-zA-Z0-9][a-zA-Z0-9._\-\@]+$/i
	*/
	public function addText($name, $config=array()) {
		$defaultConfig = array(
			'title' => '',
			'type' => 'text',
			'required' => FALSE,
			'autofocus' => FALSE,
			'disabled' => FALSE,
			'placeholder' => '',
			'autocomplete' => '',
			'value' => '',
			'min' => '',
			'max' => '',
			'maxlength' => '',
			'minlength' => '',
			'pattern' => ''
		);
		$config = array_merge($defaultConfig, $config);
	
		$temp = array();
		foreach ( $config as $k=>$v ) {
			if ( !$v ) {
				continue;
			}

			if ( $k == 'required' || $k == 'autofocus' || $k == 'disabled' ) {
				$temp[] = $k;
			} else {
				$temp[] = "{$k}='{$v}'";
			}
		}
		$attr = implode(' ', $temp);

		
		$requiredHint = ( !$config['title'] || !$config['required'] ) ? '' : '<span class="required">*</span>';
		$this->components[] = "<div id='form_{$name}_block' class='block clearfix'>
			<div><span class='title'>{$config['title']}</span> {$requiredHint}</div>
			<input id='form_{$name}' type='{$config['type']}' class='form-control' value='{$config['value']}' {$attr} />
		</div>";


		if ( $config['type'] == 'datePicker') {
			$js = <<<JAVASCRIPT

				$(function() {
					$("#form_{$name}").datepicker($.datepicker.regional[ "zh" ]);
				});
				
JAVASCRIPT;
			$this->CI->myjs->add($js);
		}
		
	}
	
	public function addDateRange($start, $end, $config=array()) {
		$default = array( 
			'title' => '',
			'type' => 'text',
			'required' => FALSE,
			'autofocus' => FALSE,
			'disabled' => FALSE,
			'placeholder' => '',
			'autocomplete' => 'off',
			'min' => '',
			'max' => '',
			'maxlength' => '',
			'minlength' => '',
			'pattern' => ''
		);
		$config = array_merge($default, $config);


		$temp = array();
		foreach ( $config as $k=>$v ) {
			if ( !$v || $k == "{$start}Value" || $k == "{$end}Value" ) {
				continue;
			}

			if ( $k == 'required' || $k == 'autofocus' || $k == 'disabled' ) {
				$temp[] = $k;
			} else {
				$temp[] = "{$k}='{$v}'";
			}
		}
		$attr = implode(' ', $temp);


		$startValue = $config["{$start}Value"];
		$endValue = $config["{$end}Value"];
		$requiredHint = ( !$config['required'] ) ? '' : '<span class="required">*</span>';
		$this->components[] = "<div id='form_{$start}_{$end}_block' class='block clearfix'>
			<div><span class='title'>{$config['title']}</span> {$requiredHint}</div>
			<input id='form_{$start}' type='datePicker' style='display:inline-block; width:49%;' class='form-control' value='{$startValue}' {$attr} /> ~ <input id='form_{$end}' type='datePicker' style='display:inline-block; width:49%;' class='form-control' value='{$endValue}' {$attr} />
		</div>";


		$js = <<<JAVASCRIPT

				$("#form_{$start}").datepicker($.datepicker.regional[ "zh" ]);
				
				$("#form_{$end}").datepicker($.datepicker.regional[ "zh" ]);

JAVASCRIPT;
			$this->CI->myjs->add($js);
	}

	public function addTextArea($name, $config=array()) {
		$default = array( 
			'isEditor'	=> FALSE,
			'editorWidth' => '',
			'rows' => '',
			'editorHeight' => '',
			'title' => '',
			'placeholder' => '',
			'value' => '',
			'minlength' => '',
			'maxlength' => '',
			'required' => FALSE,
			'disabled' => FALSE,
			'autofocus'	=> FALSE
		);
		$config = array_merge($default, $config);
	

		$temp = array();
		foreach ( $config as $k=>$v ) {
			if ( !$v || $k == 'isEditor' || $k == 'editorWidth' || $k == 'editorHeight' ) {
				continue;
			}

			if ( $k == 'required' || $k == 'autofocus' || $k == 'disabled' ) {
				$temp[] = $k;
			} else {
				$temp[] = "{$k}='{$v}'";
			}
		}
		$attr = implode(' ', $temp);


		$requiredHint = ( !$config['title'] || !$config['required'] ) ? '' : '<span class="required">*</span>';
		$this->components[] = "<div id='form_{$name}_block' class='block clearfix'>
			<div><span class='title'>{$config['title']}</span> {$requiredHint}</div>
			<textarea id='form_{$name}' data-editor='{$config['isEditor']}' class='form-control' {$attr}>{$config['value']}</textarea>
		</div>";


		if ( $config['isEditor'] ) {
			$uploadUrl = $this->CI->mylibrary->authUrl("{$this->CI->baseUrl}media_service/uploadCkeditorImage?user={$this->CI->user['account']}");
			$js = <<<JAVASCRIPT

				$(function(){

					CKEDITOR.timestamp = +new Date;

					CKEDITOR.replace("form_{$name}", {
						width:'{$config['editorWidth']}', 
						height:'{$config['editorHeight']}',
						filebrowserImageUploadUrl:'{$uploadUrl}',
						on: {
				            change: function() {
				            	formIsChanged = true;
			            	}
        				}
        			});

				});

JAVASCRIPT;
			$this->CI->myjs->add($js);
		}
	}
	
	public function addImage($name, $config=array()) {
		$this->CI->baseUrl = base_url();
		$default = array( 
			'title' => '',
			'style' => '',
			'src' => '',
			'defaultImage' => "{$this->CI->baseUrl}assets/imgs/default/picture_m.png",
			'uploadUrl' => '',
			'deleteUrl' => ''
		);
		$config = array_merge($default, $config);
	
		$srcPath = explode($this->CI->baseUrl, $config['src']);
		$srcPath = explode('?', $srcPath[1]);
		$showDelete = ( !file_exists(FCPATH . $srcPath[0]) ) ? '' : 'display:block;';
		$require_hint = ( in_array('required', $config['validate']) ) ? "<span class='requiredHint'>*</span>" : '';
		$height = explode("height:", $config['style']);
		$height = explode(";", $height[1]);
		$uploadingTop = "top:" . (($height[0] - 36) / 2) . "px;";
		$temp = "<div style='{$config['style']}' class='block border'>
			<div class='imgHint' for='{$name}'>{$config['title']}</div>
			<input type='file' accept='image/*' class='upload' name='{$name}' id='{$name}' data-uploadUrl='{$config['uploadUrl']}' title='{$config['title']}' />
			<img id='image_{$name}' class='image' data-role='imgForm' title='{$config['title']}' src='{$config['src']}' onerror='this.src=\"{$config['defaultImage']}\"' />	
			<img id='delete_{$name}' src='{$this->CI->baseUrl}assets/imgs/cross.svg' style='{$showDelete}' class='delete' data-deleteUrl='{$config['deleteUrl']}' title='" . $this->CI->lang->line('deleteImage') . "' />
			<img id='uploading_{$name}' style='{$uploadingTop}' class='uploading' src='{$this->CI->baseUrl}assets/imgs/loading.gif' />
			{$require_hint}
		</div>";

		$this->components[] = $temp;

	
		$js = <<<JS
		
			$(function() {
				
				$(document).on('change', "#{$name}", function() {
					var file = $(this).val().toLowerCase();
					
					if( !file.match(/^.*?\.(gif|png|jpg|jpeg|bmp)/) ){
						alert(myLang.imageTypeLimit);
						return;
					}
					
					$("#uploading_{$name}").show();
					
					var uploadUrl = $(this).attr('data-uploadUrl');
					$.ajaxFileUpload({
						url:uploadUrl,
						secureuri:false,
						fileElementId:'{$name}',
						dataType:'JSON',
						success:function(obj) {
							obj = $.parseJSON(obj);
							
							if ( obj.status == 'false' ) {
								alert(obj.msg);
								$("#uploading_{$name}").hide();
								return;
							}

							$("#image_{$name}").attr('src', obj.data.url + '?random=' + Math.random());
							$("#image_{$name}").attr('filePath', obj.data.filePath);
							
							$("#delete_{$name}").show();
							$("#uploading_{$name}").hide();
						},
						error:function() {}
					});
				});
				
				$("#delete_{$name}").bind('click', function() {
					if ( !confirm(myLang.imageDeleteConfirm) ) { 
						return; 
					}
				
					var deleteUrl = $(this).attr('data-deleteUrl');
					$.post(deleteUrl, {}, function(obj) {
						if (obj.status === 'false') {
							alert(obj.msg);
							return;
						}
						
						$("#image_{$name}").attr('src', "{$config['defaultImage']}");

						$("#delete_{$name}").hide();
					}, 'json');
				});
				
			});
			
JS;
		$this->CI->myjs->add($js);
	}

	/*
	**
	** radios item => array('title', 'value', 'checked')
	**
	*/
	public function addRadios($name, $config=array()) {
		$default = array( 
			'title' => '',
			'radios' => array()
		);
		$config = array_merge($default, $config);


		$items = array();
		foreach ( $config['radios'] as $r ) {
			$checked = ( !$r['checked'] ) ? '' : 'checked';

			$items[] = "<div class='radio-inline'>
				<label><input type='radio' name='form_{$name}' value='{$r['value']}' {$checked}>{$r['title']}</label>
			</div>";
		}
		$items = explode('', $items);


		$this->components[] = "<div id='form_{$name}_block' class='block clearfix'>
			<div><span class='title'>{$config['title']}</span></div>
			{$items}
		</div>";
	}
	
	public function addCheckbox($name, $config=array()) {
		$default = array( 
			'title' => '',
			'value' => '',
			'checked' => FALSE,
			'disabled' => FALSE
		);
		$config = array_merge($default, $config);
		

		$temp = array();
		foreach ( $config as $k=>$v ) {
			if ( !$v ) {
				continue;
			}

			if ( $k == 'checked' || $k == 'disabled' ) {
				$temp[] = $k;
			} else {
				$temp[] = "{$k}='{$v}'";
			}
		}
		$attr = implode(' ', $temp);


		$this->components[] = "<div id='form_{$name}_block' class='block clearfix'>
			<div class='input-group clearfix'>
				<div><span class='title'>{$config['title']}</span></div>
				<label><input type='checkbox' id='form_{$name}' style='margin-right:10px;' {$attr} />{$config['value']}</label>
			</div>
		</div>";
	}
	
	/*
	**
	** options item => array('value', 'text')
	**
	*/
	public function addSelect($name, $config=array()) {
		$default = array( 
			'title' => '',
			'options' => array(), 
			'disabled' => FALSE
		);
		$config = array_merge($default, $config);
		

		$temp = array();
		foreach ( $config['options'] as $op ) {
			$temp[] = "<option value='{$op['value']}' {$op['selected']}>{$op['text']}</option>";
		}
		$options = implode('', $temp);


		$disabled = ( !$config['disabled'] ) ? '' : 'disabled';
		$this->components[] = "<div id='form_{$name}_block' class='block clearfix'>
			<div><span class='title'>{$config['title']}</span></div>
			<select id='form_{$name}' class='form-control' style='width:auto;' {$disabled}>{$options}</select>
		</div>";
	}
	
	public function addSubmit($config=array()) {
		$default = array(
			'submitText' => $this->CI->lang->line('submit'),
			'submitingText' => $this->CI->lang->line('submiting'),
			'url' => '',
			'disabledSubmit' => FALSE,
			'onSuccess' => array(),
			'onCancel' => array(),
			'hideCancel' => FALSE,
			'cancelText' => $this->CI->lang->line('cancel'),
		);
		$config = array_merge($default, $config);
	
		$disabledSubmit = ( !$config['disabledSubmit'] ) ? '' : 'disabled';
		$isDialog = ( $config['onCancel'][0] == 'closeDialog' ) ? 1 : 0;
		$cancel = ( $config['hideCancel'] ) ? '' : "<button id='form_cancel' data-action='{$config['onCancel'][0]}' data-value='{$config['onCancel'][1]}' class='btn btn-default' type='button'>{$config['cancelText']}</button>";
		$result = "<div class='submitGroup'>
			<button id='form_submit' data-action='{$config['onSuccess'][0]}' data-value='{$config['onSuccess'][1]}' data-msg='{$config['onSuccess'][2]}' class='btn btn-primary' type='submit' {$disabledSubmit}>{$config['submitText']}</button>
			{$cancel}
		</div>";
		
		$this->components[] = $result;
		
		
		$js = <<<JAVASCRIPT
		
			var formIsChanged = false;

			(function(){
	

				var isDialog = {$isDialog};
				
			
				$("input").keypress(function(event){       
					if ( !$("#form_submit").prop('disabled') && event.keyCode == 13 ) { 
						$("#form_submit").trigger("click");
					} // key - enter
				});


				$("input, textarea, select").change(function () {
		            formIsChanged = true;
		        });

		        $(window).bind('beforeunload', function (e) {
		            if ( !isDialog && formIsChanged ) {
		                return myLang.confirmLeave;
		            }
		        });
			
				$("#myForm").bind('submit', function(e){
					e.preventDefault();
					if ( !this.checkValidity() ) {
						return false;
					}

					$(window).unbind('beforeunload');

					var submitBtn = $("#form_submit");

					var send = '{$config['submitText']}';
					var sending = '{$config['submitingText']}';
					submitBtn.prop('disabled', true).html(sending);
				
					var result = {};
					var id = '', name = '';
					var isEditor = false;
					var value = '';

					
					$("#myForm input, #myForm textarea, #myForm select").each(function(){
						id = $(this).attr('id').substr(5);
						name = ( !$(this).attr('name') ) ? '' : $(this).attr('name').substr(5);
						isEditor = $(this).attr('data-editor');
						value = ( !isEditor ) ? $.trim($(this).val()) : CKEDITOR.instances["form_"+id].getData();
						
						if ( $(this).attr('type') == 'password' ) {
							if ( value ) {
								result[id] = $.md5($.md5(value));
							}
						} else if ( $(this).attr('type') == 'radio' ) {
							result[name] = $("[name='" + name + "']:checked").val();
						} else if ( $(this).attr('type') == 'checkbox' ) {
							result[id] = ( $(this).prop('checked') ) ? 1 : 0;
						} else {
							result[id] = value;
						}
					});


					$("#myForm [data-role='imgForm']").each(function(e){
						id = $(this).attr('id').substr(6);
						value = $(this).attr('filepath');
						result[id] = value;
					});
					

					$.post('{$config['url']}', result, function(obj) {
						if ( obj.status === 'false' ) {
							alert(obj.msg);
							submitBtn.prop('disabled', false).html(send);
							return; 
						}

						if ( typeof CKEDITOR != 'undefined' ) {
							for ( var name in CKEDITOR.instances ) {
								CKEDITOR.instances[name].destroy(true);
							}
						}
						
						var dataAction = submitBtn.attr('data-action');
						if ( dataAction == 'reDirect' ) {
							var dataValue = submitBtn.attr('data-value');

							if ( dataValue == 'reload' ) {
								window.location.reload();
							} else if ( dataValue == 'parentReload' ) {
								parent.window.location.reload();
							} else {
								window.location.href = dataValue;
							}
						} else if ( dataAction == 'alert' ) {
							var dataValue = submitBtn.attr('data-value');
							var dataMsg = submitBtn.attr('data-msg');

							if ( dataValue == 'reload' ) {
								alert(dataMsg);
								window.location.reload();
							} else if ( dataValue == 'parentReload' ) {
								alert(dataMsg);
								parent.window.location.reload();
							} else {
								alert(dataMsg);
								window.location.href = dataValue;
							}
						} else if ( dataAction == 'returnUrl' ) {
							window.location.href = obj.data.url;
						} else if ( dataAction == 'back' ) {
							window.history.back();
						}
					}, 'json');


					return false;
				});

				if ( isDialog ) {
					$("#myModal .close", parent.document).bind('click', function(event){
						if ( formIsChanged ) {
							var confirmLeave = confirm(myLang.confirmLeave);
			                if ( !confirmLeave ) {
			                	event.stopImmediatePropagation();
			                }
			            }
					});
				}
			
				$("#form_cancel").bind('click', function(){
					var dataAction = $(this).attr('data-action');

					if ( dataAction == 'reDirect' ) {
						var dataValue = $(this).attr('data-value');

						window.location.href = dataValue;
					} else if ( dataAction == 'closeDialog' ) {
						if ( formIsChanged ) {
							var confirmLeave = confirm(myLang.confirmLeave);
			                if ( !confirmLeave ) {
			                	return;
			                }
			            }
						window.top.$('#myModal').modal('hide');
					} else if ( dataAction == 'back' ) {
						window.history.back();[]
					}
				});
			
			})();
		
JAVASCRIPT;
		$this->CI->myjs->add($js);
	}	
	
    public function getResult() {
		return "<form id='myForm'>" . join('', $this->components) . "</form>";
	}
	
}