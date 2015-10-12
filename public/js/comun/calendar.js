	$(document).ready(function() {

		$('#calendar').fullCalendar({
            header: {
                left: 'prev,next today',
                center: 'title'

            },
            lang: '',
            buttonIcons: true,
			defaultDate: new Date(),
			editable: false,
            weekNumbers: true,
			eventLimit: true // allow "more" link when too many events

		});
		
	});
