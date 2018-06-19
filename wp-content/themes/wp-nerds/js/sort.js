jQuery(function($){
	$('#filter').submit(function(){
		var filter = $(this);
		$.ajax({
			url:ajaxurl, // обработчик
			data:filter.serialize(), // данные
			type:filter.attr('method'), // тип запроса
			beforeSend:function(xhr){
				filter.find('button').text('Загружаю...'); // изменяем текст кнопки
			},
			success:function(data){
				filter.find('button').text('Применить фильтр'); // возвращаеи текст кнопки
				$('#response').html(data);
			}
		});
		return false;
	});
});