	$(document).ready(function() {

		$('#calendar').fullCalendar({
            header: {
                left: 'prev,next today',
                center: 'title',
                right: 'month,agendaWeek,agendaDay'
            },
            lang: '',
            buttonIcons: false,
			defaultDate: '2015-10-12',
			editable: true,
            weekNumbers: true,
			eventLimit: true, // allow "more" link when too many events
			events: [
				{
					title: 'Curso número 1',
					start: '2015-10-01'
				},
				{
					title: 'Curso número 2',
					start: '2015-10-07',
					end: '2015-10-10'
				},
				{
					id: 999,
					title: 'Curso número 3',
					start: '2015-10-09T16:00:00'
				},
				{
					id: 999,
					title: 'Repetido curso número 3',
					start: '2015-10-16T16:00:00'
				},
				{
					title: 'Curso número 4',
					start: '2015-10-11',
					end: '2015-10-13'
				},
				{
					title: 'Curso número 5',
					start: '2015-10-12T10:30:00',
					end: '2015-10-12T12:30:00'
				},
				{
					title: 'Curso número 6',
					start: '2015-10-12T12:00:00'
				},
				{
					title: 'Curso número 7',
					start: '2015-10-12T14:30:00'
				},
				{
					title: 'Curso número 8',
					start: '2015-10-12T17:30:00'
				},
				{
					title: 'Curso número 9',
					start: '2015-10-12T20:00:00'
				},
				{
					title: 'Curso número 10',
					start: '2015-10-13T07:00:00'
				},
				{
					title: 'Curso número 11',
					start: '2015-10-28'
				}
			]
		});
		
	});
