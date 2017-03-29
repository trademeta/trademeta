$('button.close').on('click', function(e){
    $('.alert-success').fadeOut(500);
});

function ajaxHandler(url, data, handler, resp, successMess, reload) {
    var resp = resp || 'ok',
        successMess = successMess || 'Успешная операция',
        reload = reload || false;
        var handler = (handler)? handler : function (response) {
            console.log(response);
            if (response != resp) {
                if(!resp) {
                    alert("Error");
                }else{
                    alert(response);
                }
            } else {
                console.log(successMess);
                if(reload) {
                    location.reload();
                }
            }
        };
    jQuery.post(url, data, handler);
}

function saveValue ( _action, _recordId, _value, _response) {
    var value = _value;
    if(_value instanceof Array) {
        //если массив, тогда 1е значение нужно вытянуть для установки его в data-данные изменяемого элемента
        value = _value.shift();
    }
    var data = {
            action: _action,
            id: _recordId,
            value: _value
        },
        _response = _response || 'ok',
        handler = function(response) {
            var $tr = $('tr[data-id='+_recordId+']'),
                $td = $tr.find('td div.'+_action);
            if(response == _response){
                $td.data('value', value).blur();
            }else{
                $td.html($td.data('value'));
                alert(response);
            }
        };
    ajaxHandler('ajax/update-work.php', data, handler);
}

//Добавление нового поля для ввода при создании новой работы (li, p, img)
$('button.add-item').on('click', function(e){
    var $target = $(e.target),
        dataBtn = $target.attr('data-btn'),
        $parent = $target.closest('.form-group'),
        content = {
            'li' : '<div class="wrapper"><div class="col-sm-1"><button type="button" class="delete-item" data-btn="li">-</button></div><div class="col-sm-2"><label class="control-label">li</label></div> <div class="col-sm-9"><input type="text" class="form-control li" name="li[]"></div> </div>',
            'p' : '<div class="wrapper"><div class="col-sm-1"><button type="button" class="delete-item" data-btn="p">-</button></div><div class="col-sm-2"><label class="control-label">p</label></div> <div class="col-sm-9"><textarea class="form-control m_text" name="m_text[]"></textarea></div> </div>',
            'img' : '<div class="wrapper"><div class="col-sm-1"><button type="button" class="delete-item" data-btn="img">-</button></div><div class="col-sm-2"><label class="control-label">img</label></div> <div class="col-sm-9"><input type="text" class="form-control m_img" name="m_img[]"></div> </div>'
        } ;
    $parent.append(content[dataBtn]);
});
$(document).on('click', 'button.delete-item', function(e){
    var $target = $(e.target),
        $wrapper = $target.closest('.wrapper');
    $wrapper.remove();
});

var $body = $('body');

//Обработчики для правки текста в реальном времени в таблице
$body.on('focus', 'td div[contenteditable]', function (e) {
    $(this).data('value', $(this).html());
    $(this).closest('tr').css('background-color', 'lightgrey');
});

$body.on('blur', 'td div[contenteditable]', function (e) {
    if ($(this).data('value') != $(this).html()) $(this).trigger('enter');
    $(this).closest('tr').css('background-color', '');
});

$body.on('enter', 'td div', function (e) {
    var $target = $(e.target),
        id = $target.closest('tr').attr('data-id'),
        _class = $target.attr('class'),
        value = $target.html(),
        $ul = $target.find('li');
    if($ul.length) {
        /*
        * 1е значение в массиве нужно для data-данных элемента,
        * чтобы проверять изменения в тексте при редактировании работы в таблице
        */
        value = [value];
        $ul.each(function(i,el) {
            value[i+1] = $(el).text();
        });
    }
    saveValue(_class, id, value);
});

//Удаление работы
$('button.btn-del').on('click', function(e){
    var $target = $(e.target),
        id = $target.closest('tr').attr('data-id'),
        data = {
            id: id
        };
    ajaxHandler('ajax/delete-work.php', data, false, 'delete-ok', false, true);
});
