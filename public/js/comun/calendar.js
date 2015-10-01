	$(document).ready(function() {

		$('#calendar').fullCalendar({
			defaultDate: '2015-02-12',
			editable: true,
			eventLimit: true, // allow "more" link when too many events
			events: [
				{
					title: 'Curso número 1',
					start: '2015-02-01'
				},
				{
					title: 'Curso número 2',
					start: '2015-02-07',
					end: '2015-02-10'
				},
				{
					id: 999,
					title: 'Curso número 3',
					start: '2015-02-09T16:00:00'
				},
				{
					id: 999,
					title: 'Repetido curso número 3',
					start: '2015-02-16T16:00:00'
				},
				{
					title: 'Curso número 4',
					start: '2015-02-11',
					end: '2015-02-13'
				},
				{
					title: 'Curso número 5',
					start: '2015-02-12T10:30:00',
					end: '2015-02-12T12:30:00'
				},
				{
					title: 'Curso número 6',
					start: '2015-02-12T12:00:00'
				},
				{
					title: 'Curso número 7',
					start: '2015-02-12T14:30:00'
				},
				{
					title: 'Curso número 8',
					start: '2015-02-12T17:30:00'
				},
				{
					title: 'Curso número 9',
					start: '2015-02-12T20:00:00'
				},
				{
					title: 'Curso número 10',
					start: '2015-02-13T07:00:00'
				},
				{
					title: 'Curso número 11',
					start: '2015-02-28'
				}
			]
		});
		
	});
