<?php namespace MaddHatter\LaravelFullcalendar;

use DateTime;

interface Event
{
    /**
     * Get the event's title
     *
     * @return string
     */
    public function getTitle();

    /**
     * Is it an all day event?
     *
     * @return bool
     */
    public function isAllDay();

    /**
     * Get the start time
     *
     * @return DateTime
     */
    public function getStart();

    /**
     * Get the end time
     *
     * @return DateTime
     */
    public function getEnd();

    /**
     * Obtiene el color obtenido de la comunidad que realiza el curso
     * @return mixed
     */
    public function getColorFondo();

    /**
     * Obtiene el color obtenido de la comunidad que realiza el curso
     * @return mixed
     */
    public function getColorTexto();

    /**
     * Obteniene el nombre de la cumidad que realiza el curso
     * @return mixed
     */
    public function getComunidad();
}