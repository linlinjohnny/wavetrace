/*
 * ver 20141203
 */
"use strict";

var mylibrary = mylibrary || {};


mylibrary.template = (function() {
    return {
        getTableChecked: function() {
            var ids = [];
            $("[data-role='checkOne']:checked").each(function() {
                ids.push($(this).attr('data-id'));
            });


            return ids.join(',');
        }
    }
})();


mylibrary.modal = (function() {
    return {
        // varified by old interface: _title, _url, _w, _h, _ext {btn, onEscape callback}
        dialog:  function(options) {
            var message = options.message;
            if (options.url) {
                message = $('<iframe>', {
                    src: options.url,
                    frameborder:0,
                    border:0,
                    css:{
                        'display': 'block',
                        'width':'100%',
                        'height':'100%'
                    }
                });
            }


			var mymodal = tmpl('\
				<div class="modal fade" id="myModal">\
				  <div class="modal-dialog" style="width:{%= o.width %}px; height:{%= o.height %}px;">\
					<div class="modal-content">\
					  <div class="modal-header">\
						<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>\
						<h4 class="modal-title">{%= o.title %}</h4>\
					  </div>\
					  <div class="modal-body" style="height:{%= o.height %}px;">\
						{%# o.body %}\
					  </div>\
					</div><!-- /.modal-content -->\
				  </div><!-- /.modal-dialog -->\
				</div><!-- /.modal -->\
			');

			var modalHtml = mymodal({'title':options.title,
								     'width' : options.width,
								     'height' : options.height,
									 'body':(options.url) ? message[0].outerHTML : message
									 });

            options.options
			$('#myModal').remove();
			$('body').append(modalHtml);
			$('#myModal').modal({backdrop: options.backdrop ? options.backdrop : 'static',
								show: true}) ;

            if (options.onEscape) {
                $('#myModal').on('hidden.bs.modal', function () {
                  window.location.reload();
                });
            }

            if (options.beforeClose) {
                $('#myModal').on('hidden.bs.modal', options.beforeClose);
            }

            if (options.myClass) {
                $('#myModal').addClass(options.myClass);
            }

            window.closeModal = function(){
                $('#myModal').modal('hide');
            };
        },
        fancybox: function(options) {
            // image
            // mylibrary.modal.fancybox({
            //     type: 'img',
            //     smallImg: '{$testSmallUrl}',
            //     largeImg: '{$testLargeUrl}',
            //     width:250,
            //     height:250
            // });


            // iframe
            // mylibrary.modal.fancybox({
            //     type: 'iframe',
            //     url: 'http://tw-hkt.blogspot.tw/2011/11/kinect-for-windows-1115.html',
            //     width:250,
            //     height:250
            // });
            var mybox = tmpl('\
                <a id="myfancybox" href="{%= o.href %}">{%# o.src %}</a>\
               '),
                boxHtml = '';

            switch (options['type']) {
                case 'img' :
                    boxHtml = '<a id="myfancybox" href="' + options['largeImg']+'"><img src="' + options['smallImg'] + '" alt=""/></a>';
                break;

                case 'iframe' :
                    boxHtml = '<a id="myfancybox" class="fancybox fancybox.iframe" href="' + options['url'] + '">This goes to iframe</a>';

                break;
            }

            options['width'] = (options['width']!='') ? options['width'] : 560;
            options['height'] = (options['height']!='') ? options['height'] : 340;

            $('#myfancybox').remove();
            $('body').append(boxHtml);
            $('#myfancybox').fancybox({width:options['width'],
                                       height:options['height']}).trigger('click');
        }
    }
})();
