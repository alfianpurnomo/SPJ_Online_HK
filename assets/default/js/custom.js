/**
 * custom script
 * @author alfian purnomo
 * @version 2.0
 * @description this library is required jquery and other library
 */


function makeDataTables(element){
    $(document).ready(function(){
        $(element).DataTable();
    });
    
}
function convert_to_uri(val)
{
    return val
        .toLowerCase()
        .replace(/ /g,'-')
        .replace(/[^\w-]+/g,'')
        ;
}
function custom_alert(msg,type) {
    type = typeof type !== 'undefined' ? type : 'error';
    if (type=="success"){
        toastr.success(msg, "Success");
    } else if (type=="error") {
        toastr.error(msg, 'Error');
    } else if (type=="warning") {
        toastr.warning(msg, 'Warning');
    }
}
function sweet_alert(title='Berhasil',text='Berhasil',type='success',button_text='Ok'){
    swal({
      title: title,
      text: text,
      type: type,
      confirmButtonText: button_text
    });
}
function list_dataTables(element, url) {
    $(document).ready(function () {
        var selected = [];
        var sort = [];
        if ($(element+' thead th.default_sort').index(element+' thead th') > 0) {
            sort.push([$(element+' thead th.default_sort').index(element+' thead th'),"desc"]);
        }
        var colom = [];
        var i=0;
        $(element+' thead th').each(function() {
            var edit = $(this).data('edit');
            var view = $(this).data('view');
            colom[i] = {
                'data':(typeof $(this).data('name') === 'undefined') ? null : $(this).data('name'),
                'name':(typeof $(this).data('name') === 'undefined') ? null : $(this).data('name'),
                'searchable':(typeof $(this).data('searchable') === 'undefined') ? true : $(this).data('searchable'),
                'sortable':(typeof $(this).data('orderable') === 'undefined') ? true : $(this).data('orderable'),
                'className':(typeof $(this).data('classname') === 'undefined') ? null : $(this).data('classname')
            };
            i++;
        });
        $(element +' tfoot th.searchable').each( function () {
            var title = $(this).text();
            var option_data = $(this).data('option-list');
            if (typeof option_data !== 'undefined') {
                var opt_html = '';
                opt_html += '<select class="form-control input-sm column-option-filter">';
                opt_html += '<option value=""></option>';

                $.each(option_data, function(value, text) {
                    opt_html += '<option value="'+ value +'">'+ text +'</option>';
                });
                opt_html += '</select>';
                $(this).html(opt_html);
            } else {
                $(this).html( '<input type="text" placeholder="Search '+title+'" class="form-control input-sm column-search-filter" />' );
            }
        } );
        var DTTable = $(element).DataTable({
            "processing": true,
            "serverSide": true,
            "responsive": false,
            /*"ajax": $.fn.dataTable.pipeline({
                url: url,
                pages: perpage // number of pages to cache
            })*/
            "ajax": {
                "url": url,
                "type": "POST",
                "data": objToken
            },
            "rowCallback": function( row, data ) {
                if ( $.inArray(data.DT_RowId, selected) !== - 1) {
                    $(row).addClass('selected');
                }
                if ( typeof data.RowClass !== 'undefined' && data.RowClass != '') {
                    $(row).addClass(data.RowClass);
                }
            },
            "columns":colom,
            "order":sort
        });
        $(element+'_filter input').unbind();
        $(element+'_filter input').keyup(function (e) {
            if (e.keyCode == 13) {
                DTTable.search(this.value).draw();
            }
        });
        if ($(element +' tfoot th.searchable').length > 1) {
            DTTable.columns().every( function () {
                var that = this;
                $( 'input', this.footer() ).on( 'keydown', function (ev) {
                     if (ev.keyCode == 13) { //only on enter keypress (code 13)
                        that
                        .search( this.value )
                        .draw();
                    }
                } );
                $( 'select', this.footer() ).on( 'change', function (ev) {
                    that
                    .search( this.value )
                    .draw();
                } );
            } );
        }
        /*
        // edit record
        //$(element+' tbody').on('click', 'td.details-control', function () {
        $(element+' tbody').on('click', 'td.details-control span', function () {
            var selfspan = $(this);
            var selfurl = selfspan.data('url');
            var tr = this.closest('tr');
            var id = tr.id;
            window.location.href = current_ctrl+selfurl+'/'+id;
        });
        */
        // selected row
        $(element+' tbody').on('click', 'tr', function () {
            var id = this.id;
            var index = $.inArray(id, selected);

            if ( index === -1 ) {
                selected.push( id );
            } else {
                selected.splice( index, 1 );
            }
            $("#delete-record-field").val(selected);

            $(this).toggleClass('selected');
        });
        // delete record
        $(document).on('click', '.delete-record, #delete-record', function () {
            if (selected.valueOf() != '') {
                //console.log(objToken);
                var post_delete = [{name:"ids",value:selected}];
                post_delete.push({name:token_name,value:token_key});
                var url_delete = (typeof $(this).data('delete-url') === 'undefined') ? current_ctrl+'delete' : current_ctrl+$(this).data('delete-url');
                var conf = confirm('Are You sure want to delete this record(s)?');
                if (conf) {
                    $.ajax({
                        url:url_delete,
                        type:'post',
                        data:post_delete,
                        dataType:'json'
                    }).
                    done(function(data) {
                        if (data['success']) {
                            $(".flash-message").html(data['success']);
                            $(element+' tbody tr.selected').remove();
                            DTTable.draw();
                        }
                        if (data['error']) {
                            $(".flash-message").html(data['error']);
                        }
                    })
                    ;
                }
            }
        });
        $(document).on('ifChanged','.change_status', function(){
            var post = [{name:"ids",value:$(this).data('id')}];
            post.push({name:token_name,value:token_key});
            var url = (typeof $(this).data('delete-url') === 'undefined') ? current_ctrl+'change_status' : $(this).data('url');
            var conf = confirm('Are You sure want to change this record(s)?');
            if (conf) {
                $.ajax({
                    url:url,
                    type:'post',
                    data:post,
                    dataType:'json'
                }).
                done(function(data) {
                    if (data['success']) {
                        $(".flash-message").html(data['success']);
                        $(element+' tbody tr.selected').remove();
                        DTTable.draw();
                    }
                    if (data['error']) {
                        $(".flash-message").html(data['error']);
                    }
                })
                ;
            }
        });
    });
}

function list_dataTablesAfterClick(element, url) {
    //$(document).ready(function () {
        var selected = [];
        var sort = [];
        if ($(element+' thead th.default_sort').index(element+' thead th') > 0) {
            sort.push([$(element+' thead th.default_sort').index(element+' thead th'),"desc"]);
        }
        var colom = [];
        var i=0;
        $(element+' thead th').each(function() {
            var edit = $(this).data('edit');
            var view = $(this).data('view');
            colom[i] = {
                'data':(typeof $(this).data('name') === 'undefined') ? null : $(this).data('name'),
                'name':(typeof $(this).data('name') === 'undefined') ? null : $(this).data('name'),
                'searchable':(typeof $(this).data('searchable') === 'undefined') ? true : $(this).data('searchable'),
                'sortable':(typeof $(this).data('orderable') === 'undefined') ? true : $(this).data('orderable'),
                'className':(typeof $(this).data('classname') === 'undefined') ? null : $(this).data('classname')
            };
            i++;
        });
        $(element +' tfoot th.searchable').each( function () {
            var title = $(this).text();
            var option_data = $(this).data('option-list');
            if (typeof option_data !== 'undefined') {
                var opt_html = '';
                opt_html += '<select class="form-control input-sm column-option-filter">';
                opt_html += '<option value=""></option>';

                $.each(option_data, function(value, text) {
                    opt_html += '<option value="'+ value +'">'+ text +'</option>';
                });
                opt_html += '</select>';
                $(this).html(opt_html);
            } else {
                $(this).html( '<input type="text" placeholder="Search '+title+'" class="form-control input-sm column-search-filter" />' );
            }
        } );
        var DTTable = $(element).DataTable({
            "processing": true,
            "serverSide": true,
            "responsive": false,
            /*"ajax": $.fn.dataTable.pipeline({
                url: url,
                pages: perpage // number of pages to cache
            })*/
            "ajax": {
                "url": url,
                "type": "POST",
                "data": objToken
            },
            "rowCallback": function( row, data ) {
                if ( $.inArray(data.DT_RowId, selected) !== - 1) {
                    $(row).addClass('selected');
                }
                if ( typeof data.RowClass !== 'undefined' && data.RowClass != '') {
                    $(row).addClass(data.RowClass);
                }
            },
            "columns":colom,
            "order":sort
        });
        $(element+'_filter input').unbind();
        $(element+'_filter input').keyup(function (e) {
            if (e.keyCode == 13) {
                DTTable.search(this.value).draw();
            }
        });
        if ($(element +' tfoot th.searchable').length > 1) {
            DTTable.columns().every( function () {
                var that = this;
                $( 'input', this.footer() ).on( 'keydown', function (ev) {
                     if (ev.keyCode == 13) { //only on enter keypress (code 13)
                        that
                        .search( this.value )
                        .draw();
                    }
                } );
                $( 'select', this.footer() ).on( 'change', function (ev) {
                    that
                    .search( this.value )
                    .draw();
                } );
            } );
        }
        /*
        // edit record
        //$(element+' tbody').on('click', 'td.details-control', function () {
        $(element+' tbody').on('click', 'td.details-control span', function () {
            var selfspan = $(this);
            var selfurl = selfspan.data('url');
            var tr = this.closest('tr');
            var id = tr.id;
            window.location.href = current_ctrl+selfurl+'/'+id;
        });
        */
        // selected row
        $(element+' tbody').on('click', 'tr', function () {
            var id = this.id;
            var index = $.inArray(id, selected);

            if ( index === -1 ) {
                selected.push( id );
            } else {
                selected.splice( index, 1 );
            }
            $("#delete-record-field").val(selected);

            $(this).toggleClass('selected');
        });
        // delete record
        $(document).on('click', '.delete-record, #delete-record', function () {
            if (selected.valueOf() != '') {
                //console.log(objToken);
                var post_delete = [{name:"ids",value:selected}];
                post_delete.push({name:token_name,value:token_key});
                var url_delete = (typeof $(this).data('delete-url') === 'undefined') ? current_ctrl+'delete' : current_ctrl+$(this).data('delete-url');
                var conf = confirm('Are You sure want to delete this record(s)?');
                if (conf) {
                    $.ajax({
                        url:url_delete,
                        type:'post',
                        data:post_delete,
                        dataType:'json'
                    }).
                    done(function(data) {
                        if (data['success']) {
                            $(".flash-message").html(data['success']);
                            $(element+' tbody tr.selected').remove();
                            DTTable.draw();
                        }
                        if (data['error']) {
                            $(".flash-message").html(data['error']);
                        }
                    })
                    ;
                }
            }
        });
        $(document).on('ifChanged','.change_status', function(){
            var post = [{name:"ids",value:$(this).data('id')}];
            post.push({name:token_name,value:token_key});
            var url = (typeof $(this).data('delete-url') === 'undefined') ? current_ctrl+'change_status' : $(this).data('url');
            var conf = confirm('Are You sure want to change this record(s)?');
            if (conf) {
                $.ajax({
                    url:url,
                    type:'post',
                    data:post,
                    dataType:'json'
                }).
                done(function(data) {
                    if (data['success']) {
                        $(".flash-message").html(data['success']);
                        $(element+' tbody tr.selected').remove();
                        DTTable.draw();
                    }
                    if (data['error']) {
                        $(".flash-message").html(data['error']);
                    }
                })
                ;
            }
        });
    //});
}

/**
 * Ajax Post Data
 * 
 * @param  {string} url URL
 * @param  {string} data post data
 * @return {object} callback
 */
function ajax_post(url,data) {
    data.push({name:token_name,value:token_key});
    var callback = $.ajax({
        url:url,
        type:'post',
        dataType:'json',
        data:data,
        cache:false
    });
    return callback;
}


/**
 * submit via ajax by button
 * 
 * @param string url
 * @param string data
 * @param object this_var
 * @returns object/var
 */
function submit_ajax(url,data,this_var) {
    data.push({name:token_name,value:token_key});
    var callback = $.ajax({
        url:url,
        type:'post',
        dataType:'json',
        data:data,
        cache:false,
        beforeSend:function() {
            if (this_var || typeof this_var !== 'undefined') {
                this_var.html('Loading...');
                this_var.attr('disabled',true);
            }
        }
    });
    return callback;
}


$('.collapse-link').click(function () {
    var x_panel = $(this).closest('div.x_panel');
    var button = $(this).find('i');
    var content = x_panel.find('div.x_content');
    content.slideToggle(200);
    (x_panel.hasClass('fixed_height_390') ? x_panel.toggleClass('').toggleClass('fixed_height_390') : '');
    (x_panel.hasClass('fixed_height_320') ? x_panel.toggleClass('').toggleClass('fixed_height_320') : '');
    button.toggleClass('fa-chevron-up').toggleClass('fa-chevron-down');
    setTimeout(function () {
        x_panel.resize();
    }, 50);
});