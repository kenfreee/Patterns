<?php
    interface observableInterface {
        public function addObserver(Observer $observer);
        public function getName();
        public function removeObserver(Observer $observer);
        public function notify(Event $event);
    }

    interface observerInterface {
        public function getName();
        public function update(Event $event);
    }

    interface EventInterface {
        public function getName();
        public function getInitiator();
    }

    class Observable implements observableInterface {
        private
            $name, //The name of the observable
            $observers = []; //The array of observers

        public function __construct($name)
        {
            $this->name = $name;
        }

        //Getter of the name
        public function getName()
        {
            return $this->name;
        }

        //Adding an observer
        public function addObserver(Observer $observer)
        {
            $this->observers[] = $observer;
        }

        //Removing an observer
        public function removeObserver(Observer $observer)
        {
            $key = array_search($observer, $this->observers, true);
            if ($key !== false) {
                unset($this->observers[$key]);
            }
        }

        //Notification of an event
        public function notify(Event $event)
        {
            foreach ($this->observers as $observer) {
                $observer->update($event);
            }
        }

        //Actions of the observable object
        public function actionOne() {
            $event = new Event(Event::EVENT_ONE, $this);
            $this->notify($event);
        }

        public function actionTwo() {
            $event = new Event(Event::EVENT_TWO, $this);
            $this->notify($event);
        }

        public function actionThree() {
            $event = new Event(Event::EVENT_THREE, $this);
            $this->notify($event);
        }
    }

    class Observer implements observerInterface {
        private $name; //The name of the observer

        public function __construct($name)
        {
            $this->name = $name;
        }

        //Getter of the name
        public function getName()
        {
            return $this->name;
        }

        //Events handler
        public function update(Event $event)
        {
            switch ($event->getName()) {
                case Event::EVENT_ONE:
                    printf(
                        "<b>Observable</b>: %s; <b>Event</b>: %s; <b>Observer</b>: %s<br>",
                        $event->getInitiator()->getName(), $event->getName(), $this->getName()
                    );
                    break;
                case Event::EVENT_TWO:
                    printf(
                        "<b>Observable</b>: %s; <b>Event</b>: %s; <b>Observer</b>: %s<br>",
                        $event->getInitiator()->getName(), $event->getName(), $this->getName()
                    );
                    break;
                case Event::EVENT_THREE:
                    printf(
                        "<b>Observable</b>: %s; <b>Event</b>: %s; <b>Observer</b>: %s<br>",
                        $event->getInitiator()->getName(), $event->getName(), $this->getName()
                    );
                    break;
                default:
                    echo "Unknown event.<br>";
            }
        }
    }

    class Event implements EventInterface {
        const EVENT_ONE = 'some event 1';
        const EVENT_TWO = 'some event 2';
        const EVENT_THREE = 'some event 3';

        private $name, //The name of the event
                $initiator; //Initiator of the event

        public function __construct($name, Observable $initiator)
        {
            $this->name = $name;
            $this->initiator = $initiator;
        }

        //Getter of the name
        public function getName()
        {
            return $this->name;
        }

        //Getter of initiator of an event
        public function getInitiator()
        {
            return $this->initiator;
        }
    }

    //TEST
    $obs1 = new Observer("Observer 1");
    $obs2 = new Observer("Observer 2");
    $obs3 = new Observer("Observer 3");
    $observable = new Observable("Object 1");
    $observable->addObserver($obs1);
    $observable->addObserver($obs2);

    echo "<pre>";
        echo "<p style='text-align: center'>ACTION 1</p>";
        $observable->actionOne();
        echo "<p style='text-align: center'>ACTION 2</p>";
        $observable->actionTwo();
        $observable->removeObserver($obs1);
        $observable->addObserver($obs3);
        echo "<p style='text-align: center'>ACTION 3</p>";
        $observable->actionThree();
    echo "</pre>";