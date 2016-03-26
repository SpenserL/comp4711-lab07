<?php
    /**
     * Created by PhpStorm.
     * User: scott
     * Date: 25/03/16
     * Time: 3:03 PM
     */
class Timetable extends CI_Model {
    private $xml;
    private $daysOfWeek;
    private $courses;
    private $timeslots;

    public function __construct() {
        $this->xml = simplexml_load_file('data/timetable.xml');

        //populate daysOfWeek array from days.xml
        foreach($this->xml->days->day as $day) {
            foreach($day->booking as $bookings) {
                $booking = array();
                $booking['room'] = (string) $bookings->room;
                $booking['dayofweek'] = (string) $day['code'];
                $booking['time'] = (string) $bookings->time;
                $booking['coursename'] = (string) $bookings->coursename;
                $booking['instr'] = (string) $bookings->instr;
                $booking['type'] = (string) $bookings->type;
                $this->daysOfWeek[] = new Booking($booking);

            }
        }

        //populates courses array from courses.xml
        foreach($this->xml->courses->course as $course) {
            foreach($course->booking as $bookings) {
                $booking = array();
                $booking['room'] = (string) $bookings->room;
                $booking['dayofweek'] = (string) $bookings->dayofweek;
                $booking['time'] = (string) $bookings->time;
                $booking['coursename'] = (string) $course['name'];
                $booking['instr'] = (string) $bookings->instr;
                $booking['type'] = (string) $bookings->type;
                $this->courses[] = new Booking($booking);

            }
        }

        //populates timeslots array from timeslots.xml
        foreach($this->xml->timeslots->timeslot as $timeslot) {
            foreach($timeslot->booking as $bookings) {
                $booking = array();
                $booking['room'] = (string) $bookings->room;
                $booking['dayofweek'] = (string) (string) $bookings->dayofweek;
                $booking['time'] = (string) $timeslot['time'];
                $booking['coursename'] = (string) $bookings->coursename;
                $booking['instr'] = (string) $bookings->instr;
                $booking['type'] = (string) $bookings->type;
                $this->timeslots[] = new Booking($booking);

            }
        }

    }

    public function getDaysOfTheWeek() {
        return $this->daysOfWeek;
    }

    public function getCourses() {
       return $this->courses;
    }

    public function getTimeslots() {
        return $this->timeslots;
    }

}



class Booking extends CI_Model {
    public $room;
    public $day;
    public $time;
    public $name;
    public $instructor;
    public $type;

    public function __construct($booking) {
        $this->room = $booking['room'];
        $this->day = $booking['dayofweek'];
        $this->time = $booking['time'];
        $this->name = $booking['coursename'];
        $this->instructor = $booking['instr'];
        $this->type = $booking['type'];
    }
}