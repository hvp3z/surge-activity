(function($){
    $(document).ready(function() {
        whole_page_spinner = new Spinner('whole_page_loading');
        whole_page_spinner.create({circles:3, base:0.3, top: ($(window).scrollTop() + $(window).height() / 2 - 250) });
        var base_url = $('.table-wrap').attr('data-url');
        console.log(whole_page_spinner);
        dashboard = {
            row: 12,
            col: 8,
            cellX: 0,
            cellY: 0,
            margin: 5, //widget
            border: 1, //widget
            wrapArea: $('.table-wrap'),
            dropArea: $('.drop'),
            widget: $('.drag'),
            grid: '',
            overlay: false,
            freeCell: true,
            createOption: $('.widget '),

            createSize: function (obj) {
                if(obj){
                    for (var index = 0; index < obj.length; ++index) {
                        if ( dashboard.col < parseInt(obj[index].y)+obj[index].height ) {
                            dashboard.col = parseInt(obj[index].y)+obj[index].height;
                        }
                    }
                }
            },

            createGrid: function () {
                dashboard.dropArea.css({'width':(dashboard.cellX * dashboard.row),
                                        'min-height':(dashboard.cellY * dashboard.col)});
                dashboard.wrapArea.css({'width':(dashboard.cellX * dashboard.row),
                                        'min-height':(dashboard.cellY * dashboard.col)});
                var html = '';
                for (var i = 0; i < dashboard.row; i ++) {
                    for (var j = 0; j < dashboard.col; j ++) {
                        html +='<div class="grid" style="left:'+(dashboard.cellX*i)+'px; top: '+(dashboard.cellY*j)+'px; height:'+dashboard.cellY+'px; width:'+dashboard.cellX+'px;"></div>';
                    }
                }
                dashboard.dropArea.append(html);
                dashboard.grid = $('.grid');
                dashboard.dropArea.droppable({
                    out: function( event, ui ) {},
                    tolerance: 'fit'
                });
            },

            initMove: function(widget) {
//                widget.draggable({
//                    revert: 'false',
//                    zIndex: 100,
//                    //containment: ".drop",
//                    start: function() {
//                        dashboard.grid.fadeIn(300);
//                    },
//                    drag: function( event, ui ) {
//                        var $container = $(".drop");
//                        var w1 = ui.helper.outerWidth(),
//                            w2 = $container.width(),
//                            h1 = ui.helper.outerHeight(),
//                            h2 = $container.height();
//                        ui.position.left = Math.max(Math.min(ui.position.left, w2 - w1-5), 5);
//                        ui.position.top = Math.max(Math.min(ui.position.top, h2 - h1-5), 5);
//                        if ((dashboard.cellY*dashboard.col) < (ui.position.top+$(this).data( 'cell' ).h*dashboard.cellY)) {
//                            dashboard.col += 1;
//                            dashboard.grid.remove();
//                            dashboard.createGrid();
//                            dashboard.grid.show();
//                        }
//                    },
//                    stop: function(event,ui){
//                        dashboard.widgetDragStop(event, ui,$(this))
//                    }
//                });
//                widget.droppable({
//                    greedy: false,
//                    tolerance: 'touch',
//                    drop: function(event,ui){
//                        //ui.draggable.draggable('option','revert',true);
//                        //dashboard.overlay = true;
//                    }
//                });
            },

            createWidget: function () {
                dashboard.createOption.select2({
                    placeholder: "Select a Widget"
                }).on('change',function(){
                        var selectWidget = $(this).find('option:selected');
                        var x = parseInt(selectWidget.attr('data_x'));
                        var y = parseInt(selectWidget.attr('data_y'));
                        dashboard.dropArea.append('<div class="new custom-block table-block" name="'+selectWidget.attr('name')+'"' +
                            'style=" width:' + (dashboard.cellX*x-2*dashboard.margin-2*dashboard.border) + 'px; height:' + (dashboard.cellY*y-2*dashboard.margin-2*dashboard.border) + 'px; top:' +
                            (dashboard.margin)+'px;left:' + (dashboard.margin)+'px;"><div class="custom-head clear-fix"><div class="custom-menu"><button class="up-custom"></button><button class="settings-custom"></button><button class="close-custom"></button></div><div class="custom-menu-select"></div><h3>'
                            +selectWidget.attr('name')+'</h3></div></div>');
                        var newWidget = $('.new');
                        newWidget.data( 'cell', { x:0, y:0,h:parseInt(selectWidget.attr('data_y')), w:parseInt(selectWidget.attr('data_x')), user: dashboard.dropArea.attr('default_user')} );
                        dashboard.searchFreeCell (newWidget,$('.drag'));
                        if (dashboard.dropArea.attr('default_user') !== '') {
                            dashboard.sendAjax(base_url+'/widget/load','create',{ name:newWidget.attr('name'), user: newWidget.data( 'cell').user},newWidget);
                            dashboard.saveWidget();
                            dashboard.searchFreeCell (newWidget,$('.drag'));
                        } else {
                            newWidget.find('.custom-menu-select').append($('.left-column > .user_data').clone().show());
                            dashboard.changeUser(newWidget);
                        }
                        $('.new').removeClass('new').addClass('drag');
                        dashboard.initMove(newWidget);
                        dashboard.deleteWidget(newWidget);
                        dashboard.createOption.select2('val','');
                    })
            },

            changeUser: function (newWidget) {
                $(newWidget).find('.user_data').select2({
                    placeholder: "Select user"
                }).on('change',function(){
                        newWidget.data( 'cell' ).user = $(this).val();
                        dashboard.sendAjax(base_url+'/widget/load','create',{ name:newWidget.attr('name'),user:$(this).val()},newWidget);
                    })
            },

            updateWidget: function (obj,newWidget) {
                whole_page_spinner.option('top', ($(window).scrollTop() + $(window).height() / 2 - 250));
                whole_page_spinner.init('top', ($(window).scrollTop() + $(window).height() / 2 - 250));
                whole_page_spinner.show();
                if (obj.length > 0) {
                    newWidget.html(obj[0].data);
                    newWidget.find('select');
                    dashboard.changeUser(newWidget);
                    dashboard.deleteWidget(newWidget);
                    dashboard.saveWidget();
                    if ($(".custom-table").length > 0){
                        $(".custom-table").tablesorter();
                    }
                }
                whole_page_spinner.hide();
            },

            deleteWidget: function (newWidget) {

                newWidget.find('.close-custom').on('click',function(){

                    var nextWidgets = newWidget.nextAll('div.drag');
                    newWidget.remove();
                    //console.log(newWidget);
                    //console.log(nextWidgets);
                    if (nextWidgets.length != 0) {
                        var height = newWidget.height();
                        console.log(nextWidgets);
                        nextWidgets.each(function() {
                            var currentTop = $(this).css("top");
                            var currentIntTop = parseInt(currentTop.substring(0, currentTop.length - 1));
                            console.log(currentIntTop);
                            console.log( $(this));
                            $(this).css("top", currentIntTop - height - 2*dashboard.margin );
                            console.log($(this).css("top"));
                        });
                    }

                    //var restWidgests = $('.ui-draggable.drag').not(function(){
                    //    return $(this)[0] === newWidget[0];
                    //});
                    //$('.ui-draggable.drag').remove();

                    //restWidgests.each(function(){
                    //    console.log($(this).find('select.user_data option:selected'));
                    //    var currentOption = $('option[name="'+ $(this).attr('name') +'"]');
                    //    currentOption.attr("selected", "selected");
                    //    $(".custom-select.widget").trigger('change');
                    //
                    //});


                    dashboard.saveWidget();
                })
            },

            saveWidget: function () {
                var employees = [];
                $('.drag').each(function(index,elem){
                    employees.push({ "id":$(this).attr('name'), "x":$(this).data('cell').x, "y":$(this).data('cell').y, "user":$(this).data('cell').user });
                });
                var sendJson = JSON.stringify(employees);
                dashboard.sendAjax(base_url+"/widget/save",'save',sendJson,'');
            },

            sendAjax: function(url, key, value, currentWidget){
                $.ajax
                ({
                    type: "POST",
                    url: url,
                    dataType: 'json',
                    data: {key: key, value: value},
                    success: function(response)
                    {
                        if ( key == 'delete' ) {
                            console.log('delete widget');
                        } else if (key == 'save') {
                            console.log('save widget');

                        } else if (key == 'create'){
                            console.log('create widget');
                            dashboard.updateWidget(response,currentWidget);
                        } else {
                            dashboard.createSize(response);
                            dashboard.createGrid();
                            dashboard.displayLoadWidget(response);
                        }
                    },
                    error: function(response)
                    {
                        console.log('Bad request!');
                    }
                });
            },

            load:function () {
                dashboard.sendAjax(base_url + '/widget/load','load','','');
            },

            displayLoadWidget: function(obj){
                whole_page_spinner.hide();
                var index;
                if(obj){
                    for (index = 0; index < obj.length; ++index) {
                        dashboard.dropArea.append('<div class="new" name="'+obj[index].title+'" style=" width:'+(dashboard.cellX*obj[index].width-2*dashboard.margin-2*dashboard.border)+'px; height:'+(dashboard.cellY*obj[index].height-2*dashboard.margin-2*dashboard.border)+'px;"></div>');
                        var newWidget = $('.new');
                        newWidget.data( 'cell', { x:obj[index].x , y: obj[index].y, h:obj[index].height, w:obj[index].width, user:obj[index].user  } );
                        if (obj[index].data){
                            newWidget.html(obj[index].data);
                        }
                        dashboard.changeUser(newWidget);
                        newWidget.css({'top':(dashboard.cellY * obj[index].y + dashboard.margin)+'px', 'left':(dashboard.cellX * obj[index].x + dashboard.margin)+'px'});
                        if ($(".new .custom-table").length > 0){
                            $(".new .custom-table").tablesorter();
                        }
                        newWidget.removeClass('new').addClass('drag');
                        dashboard.deleteWidget(newWidget);
                        dashboard.initMove(newWidget);

                    }
                }
            },

            searchFreeCell: function (newWidget,widgets) {
                var freeCell = true;
                widgets.each(function(index, element){
                    if ( !(parseInt($(this).data( 'cell' ).y) >= (parseInt(newWidget.data( 'cell' ).y)+parseInt(newWidget.data( 'cell' ).h)) ||
                        (parseInt($(this).data( 'cell' ).h)+parseInt($(this).data( 'cell' ).y)) <= parseInt(newWidget.data( 'cell' ).y) ||
                        parseInt($(this).data( 'cell' ).x)>=(parseInt(newWidget.data( 'cell' ).x)+parseInt(newWidget.data( 'cell' ).w)) ||
                        (parseInt($(this).data( 'cell' ).w)+parseInt($(this).data( 'cell' ).x)) <= parseInt(newWidget.data( 'cell' ).x))) {
                        freeCell = false;
                        var currentX = parseInt(newWidget.data( 'cell' ).x) + 1;
                        if (currentX + parseInt(newWidget.data( 'cell' ).w) <= dashboard.row) {
                            newWidget.data( 'cell' ).x = currentX;
                            newWidget.css({'top':(dashboard.cellY * newWidget.data( 'cell' ).y + dashboard.margin) + 'px', 'left':(dashboard.cellX*newWidget.data( 'cell' ).x + dashboard.margin)+'px'});
                            dashboard.searchFreeCell (newWidget,widgets);
                        } else if (parseInt(newWidget.data( 'cell' ).y) + parseInt(newWidget.data( 'cell' ).h) <= dashboard.col-1 ) {
                            var currentY = parseInt(newWidget.data( 'cell' ).y)+1;
                            newWidget.data( 'cell' ).x = 0;
                            newWidget.data( 'cell' ).y = currentY;
                            newWidget.css({'top':(dashboard.cellY*newWidget.data( 'cell' ).y + dashboard.margin - 300)+'px', 'left':(dashboard.cellX * newWidget.data( 'cell' ).x + dashboard.margin+'px')});
                            dashboard.searchFreeCell (newWidget,widgets);
                            $('.wrapper').css('height',dashboard.cellY*newWidget.data( 'cell' ).y + dashboard.margin + 700+'px!important');
                        } else {
                            dashboard.col += 1;
                            dashboard.grid.remove();
                            dashboard.createGrid();
                            dashboard.searchFreeCell (newWidget,widgets);
                        }
                    }
                    return freeCell;
                })
            },

            widgetDragStop: function ( event, ui ,currentWidget) {
                dashboard.grid.fadeOut(300);
                currentWidget.draggable('option','revert','true');
                var animateX;
                var animateY;
                var offsetXPos = parseInt( ui.position.left);
                var offsetYPos = parseInt( ui.position.top );

                if (!dashboard.overlay) {
                    var gridPositionX = offsetXPos % dashboard.cellX;
                    var gridPositionY = offsetYPos % dashboard.cellY;
                    if (gridPositionX > dashboard.cellX/2) {
                        if (gridPositionY > dashboard.cellY/2) {
                            animateX = offsetXPos+dashboard.cellX-gridPositionX+dashboard.margin;
                            animateY = offsetYPos+dashboard.cellY-gridPositionY+dashboard.margin;
                        } else {
                            animateX = offsetXPos+dashboard.cellX-gridPositionX+dashboard.margin;
                            animateY = offsetYPos-gridPositionY+dashboard.margin;
                        }
                    } else {
                        if (gridPositionY > dashboard.cellY/2) {
                            animateX = offsetXPos-gridPositionX+dashboard.margin;
                            animateY = offsetYPos+dashboard.cellY-gridPositionY+dashboard.margin;
                        } else {
                            animateX = offsetXPos-gridPositionX+dashboard.margin;
                            animateY = offsetYPos-gridPositionY+dashboard.margin;
                        }
                    }
                    currentWidget.animate({top: animateY+'px',lfeft: animateX+'px'}, 300 );
                    currentWidget.data( "cell").x = parseInt(animateX/ dashboard.cellX);
                    currentWidget.data( "cell").y = parseInt(animateY / dashboard.cellY);
                }
                dashboard.overlay = false;
                dashboard.saveWidget();
            },

            init: function() {
                dashboard.cellX = $('.left-column').width()/dashboard.row;
                dashboard.cellY =  dashboard.cellX;
                dashboard.createWidget();
                dashboard.load();
            }
        }
        dashboard.init();
        $(window).resize(function(){
            dashboard.cellX = $('.left-column').width()/dashboard.row,
                dashboard.cellY = dashboard.cellX,
                $('.grid').remove();
            $('.drag').each(function(index, element){
                $(this).css({'top':(dashboard.cellY * $(this).data( 'cell').y + dashboard.margin)+'px',
                    'left':(dashboard.cellX * $(this).data( 'cell').x + dashboard.margin)+'px',
                    'width':(dashboard.cellX*$(this).data( 'cell').w-2*dashboard.margin-2*dashboard.border)+'px',
                    'height':(dashboard.cellY*$(this).data( 'cell').h-2*dashboard.margin-2*dashboard.border)+'px'});
            })
            dashboard.createGrid();
        });
    });
    function getRandomInt() {
        return Math.floor(Math.random()*1000);
    }

})(jQuery);