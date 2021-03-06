<?php namespace MaddHatter\LaravelFullcalendar;

use DateTime;

/**
 * Class SimpleEvent
 *
 * Simple DTO that implements the Event interface
 *
 * @package MaddHatter\LaravelFullcalendar
 */
class SimpleEvent implements IdentifiableEvent
{
    /**
     * @var string|int|null
     */
    public $id;

    /**
     * @var string
     */
    public $title;

    /**
     * @var bool
     */
    public $isAllDay;

    /**
     * @var DateTime
     */
    public $start;

    /**
     * @var DateTime
     */
    public $end;

    /**
     * @var string
     */
    public $colorFondo;

    /**
     * @var string
     */
    public $colorTexto;
    /**
     * @var string
     */
    public $comunidad;

    /**
     * @param string $title
     * @param bool $isAllDay
     * @param string|DateTime $start If string, must be valid datetime format: http://bit.ly/1z7QWbg
     * @param string|DateTime $end If string, must be valid datetime format: http://bit.ly/1z7QWbg
     * @param int|string|null $id
     */
    public function __construct($comunidad, $title, $isAllDay, $start, $end, $colorFondo = "#000", $colorTexto = "#fff", $id = null)
    {
        $this->comunidad = $comunidad;
        $this->title = $title;
        $this->isAllDay = $isAllDay;
        $this->start = $start instanceof DateTime ? $start : new DateTime($start);
        $this->end = $end instanceof DateTime ? $end : new DateTime($end);
        $this->colorFondo = $colorFondo;
        $this->colorTexto = $colorTexto;
        $this->id = $id;
    }

    /**
     * Get the event's id number
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Get the event's title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Is it an all day event?
     *
     * @return bool
     */
    public function isAllDay()
    {
        return $this->isAllDay;
    }

    /**
     * Get the start time
     *
     * @return DateTime
     */
    public function getStart()
    {
        return $this->start;
    }

    /**
     * Get the end time
     *
     * @return DateTime
     */
    public function getEnd()
    {
        return $this->end;
    }

    /**
     * @return string
     */
    public function getColorFondo()
    {
        return $this->colorFondo;
    }

    /**
     * @return string
     */
    public function getColorTexto()
    {
        return $this->colorTexto;
    }

    /**
     * @return string
     */
    public function getComunidad()
    {
        return $this->comunidad;
    }
}
